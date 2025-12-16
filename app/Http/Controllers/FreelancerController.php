<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MarketplaceJob;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'freelancer')
            ->with(['profile', 'reviewsReceived'])
            ->withCount(['reviewsReceived', 'acceptedProposals'])
            ->orderBy('created_at', 'desc');
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('bio', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($q) use ($search) {
                      $q->whereJsonContains('skills', $search);
                  });
            });
        }
        
        // Filters
        if ($request->has('skills')) {
            $skills = explode(',', $request->skills);
            $query->whereHas('profile', function($q) use ($skills) {
                foreach ($skills as $skill) {
                    $q->orWhereJsonContains('skills', trim($skill));
                }
            });
        }
        
        if ($request->has('location')) {
            if ($request->location === 'remote') {
                $query->where('location', 'like', '%remote%');
            } else {
                $query->where('location', 'like', "%{$request->location}%");
            }
        }
        
        if ($request->has('hourly_rate_min')) {
            $query->where('hourly_rate', '>=', $request->hourly_rate_min);
        }
        
        if ($request->has('hourly_rate_max')) {
            $query->where('hourly_rate', '<=', $request->hourly_rate_max);
        }
        
        // Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->orderByDesc('average_rating');
                    break;
                case 'jobs_completed':
                    $query->orderByDesc('accepted_proposals_count');
                    break;
                case 'price_low':
                    $query->orderBy('hourly_rate');
                    break;
                case 'price_high':
                    $query->orderByDesc('hourly_rate');
                    break;
            }
        }
        
        $freelancers = $query->paginate(12);
        
        return view('dashboard.client.freelancers', compact('freelancers'));
    }
    
    public function show(User $freelancer)
    {
        if ($freelancer->role !== 'freelancer') {
            abort(404);
        }
        
        $freelancer->load(['profile', 'reviewsReceived.reviewer', 'portfolioItems']);
        
        // Similar freelancers
        $similarFreelancers = User::where('role', 'freelancer')
            ->where('id', '!=', $freelancer->id)
            ->whereHas('profile', function($q) use ($freelancer) {
                if ($freelancer->profile && $freelancer->profile->skills) {
                    $skills = json_decode($freelancer->profile->skills, true);
                    foreach ($skills as $skill) {
                        $q->orWhereJsonContains('skills', $skill);
                    }
                }
            })
            ->withCount('acceptedProposals')
            ->limit(4)
            ->get();
        
        return view('dashboard.client.freelancer-show', compact('freelancer', 'similarFreelancers'));
    }
    
    public function inviteToJob(Request $request, User $freelancer)
    {
        $request->validate([
            'job_id' => 'required|exists:marketplace_jobs,id',
            'message' => 'nullable|string|max:500'
        ]);
        
        $job = MarketplaceJob::find($request->job_id);
        
        if ($job->client_id !== Auth::id()) {
            abort(403);
        }
        
        // Create notification for freelancer
        $freelancer->notifications()->create([
            'type' => 'job_invitation',
            'title' => 'Job Invitation',
            'message' => Auth::user()->name . ' invited you to apply for "' . $job->title . '"',
            'data' => json_encode([
                'job_id' => $job->id,
                'client_id' => Auth::id(),
                'client_name' => Auth::user()->name,
                'message' => $request->message
            ]),
            'read' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Invitation sent successfully!'
        ]);
    }
    
    public function inviteModal(User $freelancer)
    {
        $jobs = Auth::user()->jobsPosted()->where('status', 'open')->get();
        
        return view('dashboard.client.partials.invite-modal', compact('freelancer', 'jobs'));
    }
    
    public function searchUsers(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }
        
        $users = User::where('role', 'freelancer')
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%")
                  ->orWhere('title', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email', 'role', 'title', 'avatar'])
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'title' => $user->title,
                    'avatar' => $user->getAvatarUrl()
                ];
            });
        
        return response()->json($users);
    }
}