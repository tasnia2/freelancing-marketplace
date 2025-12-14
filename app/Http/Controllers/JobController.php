<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceJob;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Routing\Controller;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('client')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    // Browse Jobs (for freelancers)
    public function index(Request $request)
    {
        $query = MarketplaceJob::with('client')->open();
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Filters
        if ($request->has('job_type')) {
            $query->where('job_type', $request->job_type);
        }
        
        if ($request->has('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }
        
        if ($request->has('budget_min')) {
            $query->where('budget', '>=', $request->budget_min);
        }
        
        if ($request->has('budget_max')) {
            $query->where('budget', '<=', $request->budget_max);
        }
        
        if ($request->has('is_remote')) {
            $query->where('is_remote', true);
        }
        
        if ($request->has('is_urgent')) {
            $query->where('is_urgent', true);
        }
        
        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'budget_high':
                $query->orderBy('budget', 'desc');
                break;
            case 'budget_low':
                $query->orderBy('budget', 'asc');
                break;
            case 'urgent':
                $query->orderBy('is_urgent', 'desc')->latest();
                break;
            case 'featured':
                $query->featured()->latest();
                break;
            default:
                $query->latest();
        }
        
        $jobs = $query->paginate(12);
        $stats = [
            'total_jobs' => MarketplaceJob::open()->count(),
            'total_budget' => MarketplaceJob::open()->sum('budget'),
            'urgent_jobs' => MarketplaceJob::open()->urgent()->count(),
            'remote_jobs' => MarketplaceJob::open()->remote()->count(),
        ];
        
        return view('jobs.index', compact('jobs', 'stats'));
    }

    // Create Job (Client only)
    public function create()
    {
        $skills = Skill::orderBy('name')->get();
        $categories = Category::with('skills')->get();
        
        return view('jobs.create', compact('skills', 'categories'));
    }

    // Store Job (Client only)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:100',
            'job_type' => 'required|in:hourly,fixed',
            'budget' => 'required_if:job_type,fixed|numeric|min:10',
            'hourly_rate' => 'required_if:job_type,hourly|numeric|min:5',
            'hours_per_week' => 'required_if:job_type,hourly|integer|min:1|max:168',
            'experience_level' => 'required|in:entry,intermediate,expert',
            'project_length' => 'required|in:less_than_1_month,1_to_3_months,3_to_6_months,more_than_6_months',
            'skills' => 'required|array|min:1',
            'skills.*' => 'string|max:50',
            'deadline' => 'nullable|date|after:today',
            'is_urgent' => 'boolean',
            'is_remote' => 'boolean',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ]);
        
        // Handle attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('job_attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }
        
        $job = MarketplaceJob::create([
            'client_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'job_type' => $validated['job_type'],
            'budget' => $validated['job_type'] === 'fixed' ? $validated['budget'] : null,
            'hourly_rate' => $validated['job_type'] === 'hourly' ? $validated['hourly_rate'] : null,
            'hours_per_week' => $validated['job_type'] === 'hourly' ? $validated['hours_per_week'] : null,
            'experience_level' => $validated['experience_level'],
            'project_length' => $validated['project_length'],
            'skills_required' => $validated['skills'],
            'deadline' => $validated['deadline'] ?? null,
            'is_urgent' => $validated['is_urgent'] ?? false,
            'is_remote' => $validated['is_remote'] ?? true,
            'attachments' => $attachments,
            'status' => 'open',
        ]);
        
        // Create notification for job posting
        Auth::user()->notifications()->create([
            'type' => 'job_posted',
            'title' => 'Job Posted Successfully',
            'message' => 'Your job "' . $job->title . '" has been posted and is now visible to freelancers.',
            'data' => json_encode(['job_id' => $job->id]),
            'read' => false,
        ]);
        
        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job posted successfully! It will be visible to freelancers shortly.');
    }

    // Show Job Details
    public function show(MarketplaceJob $job)
    {
        // Increment views
        $job->incrementViews();
        
        $hasApplied = Auth::check() && Auth::user()->user_type === 'freelancer' 
            ? $job->proposals()->where('freelancer_id', Auth::id())->exists()
            : false;
            
        $isSaved = Auth::check() 
            ? $job->savedByUsers()->where('user_id', Auth::id())->exists()
            : false;
        
        $similarJobs = MarketplaceJob::open()
            ->where('id', '!=', $job->id)
            ->where(function($query) use ($job) {
                $query->whereJsonContains('skills_required', $job->skills_required[0] ?? '')
                      ->orWhere('experience_level', $job->experience_level);
            })
            ->take(4)
            ->get();
        
        return view('jobs.show', compact('job', 'hasApplied', 'isSaved', 'similarJobs'));
    }

    // Apply to Job (Freelancer only)
    public function apply(Request $request, MarketplaceJob $job)
    {
        if (Auth::user()->user_type !== 'freelancer') {
            return redirect()->back()->with('error', 'Only freelancers can apply to jobs.');
        }
        
        if ($job->proposals()->where('freelancer_id', Auth::id())->exists()) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }
        
        $validated = $request->validate([
            'cover_letter' => 'required|string|min:100|max:2000',
            'bid_amount' => 'required|numeric|min:' . ($job->job_type === 'hourly' ? 5 : 10),
            'estimated_days' => 'required|integer|min:1|max:365',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ]);
        
        // Handle proposal attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('proposal_attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }
        
        $proposal = $job->proposals()->create([
            'freelancer_id' => Auth::id(),
            'cover_letter' => $validated['cover_letter'],
            'bid_amount' => $validated['bid_amount'],
            'estimated_days' => $validated['estimated_days'],
            'attachments' => $attachments,
            'status' => 'pending',
        ]);
        
        // Create notifications
        // For freelancer
        Auth::user()->notifications()->create([
            'type' => 'proposal_submitted',
            'title' => 'Proposal Submitted',
            'message' => 'Your proposal for "' . $job->title . '" has been submitted successfully.',
            'data' => json_encode(['job_id' => $job->id, 'proposal_id' => $proposal->id]),
            'read' => false,
        ]);
        
        // For client
        $job->client->notifications()->create([
            'type' => 'new_proposal',
            'title' => 'New Proposal Received',
            'message' => Auth::user()->name . ' has submitted a proposal for your job "' . $job->title . '".',
            'data' => json_encode(['job_id' => $job->id, 'proposal_id' => $proposal->id, 'freelancer_id' => Auth::id()]),
            'read' => false,
        ]);
        
        // Increment proposals count
        $job->increment('proposals_count');
        
        return redirect()->route('proposals.show', $proposal)
            ->with('success', 'Proposal submitted successfully! The client will review it soon.');
    }

    // Save/Unsave Job
  public function save(MarketplaceJob $job)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();
    
    // Check if job is already saved
    if ($user->savedJobs()->where('marketplace_job_id', $job->id)->exists()) {
        // Remove from saved
        $user->savedJobs()->detach($job->id);
        return response()->json([
            'saved' => false, 
            'message' => 'Job removed from saved'
        ]);
    } else {
        // Add to saved
        $user->savedJobs()->attach($job->id);
        return response()->json([
            'saved' => true, 
            'message' => 'Job saved successfully'
        ]);
    }
}
}