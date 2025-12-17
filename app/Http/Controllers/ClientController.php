<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceJob;
use App\Models\JobProposal;
use App\Models\Contract;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Statistics
        $stats = [
            'posted_jobs' => $user->jobsPosted()->count(),
            'active_jobs' => $user->jobsPosted()->whereIn('status', ['open', 'in_progress'])->count(),
            'total_proposals' => JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })->count(),
            'hired_freelancers' => Contract::where('client_id', $user->id)->count(),
            'total_spent' => Contract::where('client_id', $user->id)
                ->where('status', 'completed')
                ->sum('amount'),
            'pending_proposals' => JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })->where('status', 'pending')->count(),
        ];
        
        // Recent jobs with proposal counts
        $recentJobs = $user->jobsPosted()
            ->withCount(['proposals as pending_proposals_count' => function($query) {
                $query->where('status', 'pending');
            }])
            ->latest()
            ->take(5)
            ->get();
        
        // Recent proposals
        $recentProposals = JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })
            ->with(['job', 'freelancer'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        // Active contracts
        $activeContracts = Contract::where('client_id', $user->id)
            ->where('status', 'active')
            ->with(['freelancer', 'job'])
            ->latest()
            ->take(5)
            ->get();
        
        // Recent notifications
        $notifications = $user->notifications()
            ->latest()
            ->take(10)
            ->get();
        
        // Chart data (last 6 months job posts)
         $chartData = $this->getJobChartData($user);
    
    // Debug: Check what getJobChartData returns
    \Log::info('Chart Data Raw:', ['chartData' => $chartData]);
    \Log::info('Chart Data Type:', ['type' => gettype($chartData)]);
    
    if (empty($chartData) || !is_array($chartData)) {
        \Log::warning('Chart data is empty or not array, using defaults');
        $chartData = [
            ['month' => 'Jan', 'jobs' => 0],
            ['month' => 'Feb', 'jobs' => 0],
            ['month' => 'Mar', 'jobs' => 0],
            ['month' => 'Apr', 'jobs' => 0],
            ['month' => 'May', 'jobs' => 0],
            ['month' => 'Jun', 'jobs' => 0],
        ];
    }
    
    // Debug: Check final structure
    \Log::info('Final Chart Data:', ['chartData' => $chartData]);
    
        
        return view('dashboard.client.index', compact(
            'stats', 
            'recentJobs', 
            'recentProposals', 
            'activeContracts',
            'notifications',
            'chartData'
        ));
    }
    
    public function jobs(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        
        $query = $user->jobsPosted()->withCount(['proposals']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $jobs = $query->latest()->paginate(10);
        
        $jobStats = [
            'all' => $user->jobsPosted()->count(),
            'open' => $user->jobsPosted()->where('status', 'open')->count(),
            'in_progress' => $user->jobsPosted()->where('status', 'in_progress')->count(),
            'completed' => $user->jobsPosted()->where('status', 'completed')->count(),
        ];
        
        return view('dashboard.client.jobs', compact('jobs', 'jobStats', 'status'));
    }
    
    public function createJob()
    {
        return view('dashboard.client.jobs-create');
    }
    
   public function storeJob(Request $request)
{
    \Log::info('=== JOB CREATION STARTED ===');
    \Log::info('Request data:', $request->all());
    
    // First, let's handle the skills JSON
    $skillsArray = [];
    if ($request->has('skills')) {
        // If skills comes as JSON string (from hidden input)
        if (is_string($request->skills)) {
            try {
                $skillsArray = json_decode($request->skills, true);
                \Log::info('Skills decoded from JSON:', $skillsArray);
            } catch (\Exception $e) {
                \Log::error('Failed to decode skills JSON: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Invalid skills format. Please add skills again.');
            }
        } elseif (is_array($request->skills)) {
            $skillsArray = $request->skills;
            \Log::info('Skills received as array:', $skillsArray);
        }
    }
    
    \Log::info('Final skills array:', $skillsArray);
    
    // Validate the request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|min:10', // Reduced from 100 for testing
        'job_type' => 'required|in:hourly,fixed',
        'budget' => 'required_if:job_type,fixed|numeric|min:10',
        'hourly_rate' => 'required_if:job_type,hourly|numeric|min:5',
        'hours_per_week' => 'required_if:job_type,hourly|integer|min:1|max:168',
        'experience_level' => 'required|in:entry,intermediate,expert',
        'project_length' => 'required|in:less_than_1_month,1_to_3_months,3_to_6_months,more_than_6_months',
        'deadline' => 'nullable|date|after:today',
        'is_urgent' => 'boolean',
        'is_remote' => 'boolean',
        'attachments' => 'nullable|array',
        'attachments.*' => 'file|max:5120',
    ]);
    
    \Log::info('Validation passed');
    
    // Manually validate skills
    if (empty($skillsArray)) {
        \Log::error('No skills provided');
        return redirect()->back()
            ->withInput()
            ->with('error', 'Please add at least one skill.')
            ->withErrors(['skills' => 'At least one skill is required.']);
    }
    
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
        \Log::info('Attachments processed:', $attachments);
    }
    
    \Log::info('Creating job...');
    
    try {
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
            'skills_required' => $skillsArray,
            'deadline' => $validated['deadline'] ?? null,
            'is_urgent' => $request->boolean('is_urgent'),
            'is_remote' => $request->boolean('is_remote') ?? true,
            'attachments' => !empty($attachments) ? $attachments : null,
            'status' => 'open',
        ]);
        
        \Log::info('Job created successfully! ID: ' . $job->id);
        
        // Create slug if not auto-generated
        if (empty($job->slug)) {
            $job->slug = \Illuminate\Support\Str::slug($job->title) . '-' . \Illuminate\Support\Str::random(6);
            $job->save();
        }
        
        // Notification
        Auth::user()->notifications()->create([
            'type' => 'job_posted',
            'title' => 'Job Posted Successfully',
            'message' => 'Your job "' . $job->title . '" is now live.',
            'data' => json_encode(['job_id' => $job->id]),
            'read' => false,
        ]);
        
        \Log::info('=== JOB CREATION COMPLETED ===');
        
        return redirect()->route('client.jobs')
            ->with('success', 'Job posted successfully! It is now visible to freelancers.');
            
    } catch (\Exception $e) {
        \Log::error('Job creation failed: ' . $e->getMessage());
        \Log::error('Exception trace:', $e->getTrace());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to create job: ' . $e->getMessage());
    }
}
    
    public function editJob(MarketplaceJob $job)
    {
        if ($job->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('dashboard.client.jobs-edit', compact('job'));
    }
    
    public function updateJob(Request $request, MarketplaceJob $job)
{
    if ($job->client_id !== Auth::id()) {
        abort(403, 'Unauthorized action.');
    }
    
    \Log::info('=== UPDATE JOB STARTED ===');
    \Log::info('Request data:', $request->all());
    
    // Handle skills - could be JSON string or array
    $skillsArray = [];
    if ($request->has('skills')) {
        if (is_string($request->skills)) {
            try {
                $skillsArray = json_decode($request->skills, true);
                \Log::info('Skills decoded from JSON:', $skillsArray);
            } catch (\Exception $e) {
                \Log::error('Failed to decode skills JSON: ' . $e->getMessage());
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Invalid skills format. Please add skills again.');
            }
        } elseif (is_array($request->skills)) {
            $skillsArray = $request->skills;
            \Log::info('Skills received as array:', $skillsArray);
        }
    }
    
    // Validate the request
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string|min:100',
        'job_type' => 'required|in:hourly,fixed',
        'budget' => 'nullable|required_if:job_type,fixed|numeric|min:10',
        'hourly_rate' => 'nullable|required_if:job_type,hourly|numeric|min:5',
        'hours_per_week' => 'nullable|required_if:job_type,hourly|integer|min:1|max:168',
        'experience_level' => 'required|in:entry,intermediate,expert',
        'project_length' => 'required|in:less_than_1_month,1_to_3_months,3_to_6_months,more_than_6_months',
        'deadline' => 'nullable|date|after:today',
        'is_urgent' => 'boolean',
        'is_remote' => 'boolean',
        'status' => 'required|in:draft,open,in_progress,completed,cancelled',
    ]);
    
    // Manually validate skills
    if (empty($skillsArray)) {
        \Log::error('No skills provided for update');
        return redirect()->back()
            ->withInput()
            ->with('error', 'Please add at least one skill.')
            ->withErrors(['skills' => 'At least one skill is required.']);
    }
    
    \Log::info('Validation passed');
    
    try {
        // Prepare update data
        $updateData = [
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'job_type' => $validatedData['job_type'],
            'experience_level' => $validatedData['experience_level'],
            'project_length' => $validatedData['project_length'],
            'skills_required' => $skillsArray,
            'deadline' => $validatedData['deadline'] ?? null,
            'is_urgent' => $request->boolean('is_urgent'),
            'is_remote' => $request->boolean('is_remote'),
            'status' => $validatedData['status'],
        ];
        
        // Handle budget based on job type
        if ($validatedData['job_type'] === 'fixed') {
            $updateData['budget'] = $validatedData['budget'];
            $updateData['hourly_rate'] = null;
            $updateData['hours_per_week'] = null;
        } else {
            $updateData['hourly_rate'] = $validatedData['hourly_rate'];
            $updateData['hours_per_week'] = $validatedData['hours_per_week'];
            $updateData['budget'] = null;
        }
        
        \Log::info('Updating job with data:', $updateData);
        
        $job->update($updateData);
        
        \Log::info('=== JOB UPDATED SUCCESSFULLY ===');
        
        return redirect()->route('client.jobs')
            ->with('success', 'Job updated successfully!');
            
    } catch (\Exception $e) {
        \Log::error('Job update failed: ' . $e->getMessage());
        \Log::error('Exception trace:', $e->getTrace());
        
        return redirect()->back()
            ->withInput()
            ->with('error', 'Failed to update job: ' . $e->getMessage());
    }
}
    public function destroyJob(MarketplaceJob $job)
    {
        if ($job->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $job->delete();
        
        return redirect()->route('client.jobs')->with('success', 'Job deleted successfully!');
    }
    
    public function freelancers(Request $request)
    {
        $query = User::where('role', 'freelancer')
            ->with(['profile', 'reviewsReceived'])
            ->withCount(['reviewsReceived', 'acceptedProposals']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('skills')) {
            $skills = explode(',', $request->skills);
            $query->whereHas('profile', function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhereJsonContains('skills', $skill);
                }
            });
        }
        
        $freelancers = $query->paginate(12);
        
        return view('dashboard.client.freelancers', compact('freelancers'));
    }
    
    public function financial()
    {
        $user = Auth::user();
        
        $contracts = Contract::where('client_id', $user->id)
            ->with(['job', 'freelancer'])
            ->latest()
            ->paginate(10);
        
        $financialStats = [
            'total_spent' => Contract::where('client_id', $user->id)
                ->where('status', 'completed')
                ->sum('amount'),
            'active_contracts_value' => Contract::where('client_id', $user->id)
                ->where('status', 'active')
                ->sum('amount'),
            'pending_payments' => Contract::where('client_id', $user->id)
                ->where('status', 'active')
                ->where('end_date', '<=', now())
                ->sum('amount'),
        ];
        
        return view('dashboard.client.financial', compact('contracts', 'financialStats'));
    }
    
    public function settings()
    {
        $user = Auth::user();
        return view('dashboard.client.settings', compact('user'));
    }
    
    private function getJobChartData($user)
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = $user->jobsPosted()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
            
            $data[] = [
                'month' => $month->format('M'),
                'jobs' => $count
            ];
        }
        
        return $data;
    }
}