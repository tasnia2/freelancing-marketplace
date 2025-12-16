<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceJob;
use App\Models\JobProposal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'client') {
                return redirect()->route('client.dashboard');
            } elseif ($user->role == 'freelancer') {
                return redirect()->route('freelancer.dashboard');
            }
            return view('dashboard.admin.index'); // For admin or other roles
        }
        return redirect()->route('login');
    }
    
    // Change from PRIVATE to PUBLIC - This will be called from routes
    public function freelancerDashboard()
    {
        $user = Auth::user();
        
        // Only freelancers can access this
        if ($user->role !== 'freelancer') {
            abort(403, 'Access denied. Freelancer access only.');
        }
        
        // Stats
        $stats = [
            'total_earnings' => $user->total_earnings ?? 0, 
            'active_proposals' => $user->proposals()->where('status', 'pending')->count(),
            'accepted_proposals' => $user->proposals()->where('status', 'accepted')->count(),
            'completed_jobs' => $user->acceptedProposals()->whereHas('job', function($q) {
                $q->where('status', 'completed');
            })->count(),
            'profile_completeness' => $this->calculateProfileCompleteness($user),
        ];
        
        // Recommended jobs
        $recommendedJobs = MarketplaceJob::where('status', 'open')
            ->whereDoesntHave('proposals', function($query) use ($user) {
                $query->where('freelancer_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();
            
        // Recent proposals
        $activities = $user->proposals()
            ->with('job')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.freelancer.index', [
            'stats' => $stats,
            'recommendedJobs' => $recommendedJobs,
            'activities' => $activities,
            'user' => $user,
        ]);
    }
    
    // Change from PRIVATE to PUBLIC
    // public function clientDashboard()
    // {
    //     $user = Auth::user();
        
    //     // Only clients can access this
    //     if ($user->role !== 'client') {
    //         abort(403, 'Access denied. Client access only.');
    //     }
        
    //     // Stats
    //     $stats = [
    //         'posted_jobs' => $user->jobs()->count(),
    //         'active_jobs' => $user->jobs()->where('status', 'open')->count(),
    //         'total_spent' => $user->contracts()->where('status', 'completed')->sum('amount') ?? 0,
    //         'hired_freelancers' => $user->contracts()->count(),
    //     ];
        
    //     // Recent jobs
    //     $recentJobs = $user->jobs()
    //         ->withCount(['proposals' => function($query) {
    //             $query->where('status', 'pending');
    //         }])
    //         ->latest()
    //         ->take(5)
    //         ->get();
            
    //     // Recent applications
    //     $recentApplications = JobProposal::whereHas('job', function($query) use ($user) {
    //             $query->where('client_id', $user->id);
    //         })
    //         ->with(['job', 'freelancer'])
    //         ->where('status', 'pending')
    //         ->latest()
    //         ->take(5)
    //         ->get();
        
    //     return view('dashboard.client.index', compact('stats', 'recentJobs', 'recentApplications', 'user'));
    // }
    
    public function adminDashboard()
    {
        $user = Auth::user();
        
        // Only admins can access this
        if ($user->role !== 'admin') {
            abort(403, 'Access denied. Admin access only.');
        }
        
        // Stats
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => MarketplaceJob::count(),
            'total_proposals' => JobProposal::count(),
        ];
        
        return view('dashboard.admin.index', compact('stats', 'user'));
    }
    
    public function calculateProfileCompleteness($user)
    {
        $completeness = 0;
        $totalFields = 5;
        
        if ($user->profile) {
            if ($user->profile->headline) $completeness += 20;
            if ($user->profile->description) $completeness += 20;
            if ($user->profile->skills) $completeness += 20;
        }
        if ($user->hourly_rate) $completeness += 20;
        if ($user->avatar) $completeness += 20;
        
        return min($completeness, 100);
    }
}