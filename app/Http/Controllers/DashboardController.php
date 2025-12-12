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
        $user = Auth::user();
        
        if ($user->role == 'freelancer') {
            return $this->freelancerDashboard($user);
        } elseif ($user->role == 'client') {
            return $this->clientDashboard($user);
        } else {
            return $this->adminDashboard($user);
        }
    }
    
    private function freelancerDashboard($user)
    {
        // Stats
        $stats = [
            'total_earnings' => $user->getTotalEarnings(),
            'active_proposals' => $user->proposals()->where('status', 'pending')->count(),
            'accepted_proposals' => $user->proposals()->where('status', 'accepted')->count(),
            'completed_jobs' => $user->contracts()->where('status', 'completed')->count(),
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
        $recentProposals = $user->proposals()
            ->with('job')
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.freelancer.index', compact('stats', 'recommendedJobs', 'recentProposals', 'user'));
    }
    
    private function clientDashboard($user)
    {
        // Stats
        $stats = [
            'posted_jobs' => $user->jobs()->count(),
            'active_jobs' => $user->jobs()->where('status', 'open')->count(),
            'total_spent' => $user->contracts()->where('status', 'completed')->sum('amount'),
            'hired_freelancers' => $user->contracts()->count(),
        ];
        
        // Recent jobs
        $recentJobs = $user->jobs()
            ->withCount(['proposals' => function($query) {
                $query->where('status', 'pending');
            }])
            ->latest()
            ->take(5)
            ->get();
            
        // Recent applications
        $recentApplications = JobProposal::whereHas('job', function($query) use ($user) {
                $query->where('client_id', $user->id);
            })
            ->with(['job', 'freelancer'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.client.index', compact('stats', 'recentJobs', 'recentApplications', 'user'));
    }
    
    private function adminDashboard($user)
    {
        // Stats
        $stats = [
            'total_users' => User::count(),
            'total_jobs' => MarketplaceJob::count(),
            'total_proposals' => JobProposal::count(),
        ];
        
        return view('dashboard.admin.index', compact('stats', 'user'));
    }
    
    private function calculateProfileCompleteness($user)
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