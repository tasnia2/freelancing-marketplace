<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceJob;
use App\Models\User;
use App\Models\JobProposal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured jobs (open status, latest first)
        $featuredJobs = MarketplaceJob::where('status', 'open')
            ->with('client')
            ->latest()
            ->take(8)
            ->get();

        // Get urgent jobs (deadline within 3 days)
        $urgentJobs = MarketplaceJob::where('status', 'open')
            ->whereNotNull('deadline')
            ->where('deadline', '<=', now()->addDays(3))
            ->with('client')
            ->latest()
            ->take(4)
            ->get();

        // Get top freelancers (users with freelancer role)
        $topFreelancers = User::where('role', 'freelancer')
            ->withCount(['proposals' => function($query) {
                $query->where('status', 'accepted');
            }])
            ->orderBy('proposals_count', 'desc')
            ->take(6)
            ->get();

        // Get job categories count
        $categories = [
            'web-development' => MarketplaceJob::where('status', 'open')
                ->whereJsonContains('skills', ['Web Development'])
                ->count(),
            'design' => MarketplaceJob::where('status', 'open')
                ->whereJsonContains('skills', ['Design'])
                ->count(),
            'writing' => MarketplaceJob::where('status', 'open')
                ->whereJsonContains('skills', ['Writing'])
                ->count(),
            'marketing' => MarketplaceJob::where('status', 'open')
                ->whereJsonContains('skills', ['Marketing'])
                ->count(),
            'mobile' => MarketplaceJob::where('status', 'open')
                ->whereJsonContains('skills', ['Mobile Development'])
                ->count(),
            'ai' => MarketplaceJob::where('status', 'open')
                ->whereJsonContains('skills', ['AI/ML'])
                ->count(),
        ];

        // Stats for counters
        $stats = [
            'total_jobs' => MarketplaceJob::where('status', 'open')->count(),
            'total_freelancers' => User::where('role', 'freelancer')->count(),
            'total_clients' => User::where('role', 'client')->count(),
            'total_earned' => JobProposal::where('status', 'accepted')->sum('bid_amount'),
        ];

        return view('welcome', compact(
            'featuredJobs',
            'urgentJobs',
            'topFreelancers',
            'categories',
            'stats'
        ));
    }

    public function search(Request $request)
    {
        $query = MarketplaceJob::where('status', 'open');
        
        if ($request->has('q') && $request->q) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->has('category') && $request->category) {
            $query->whereJsonContains('skills', [$request->category]);
        }

        if ($request->has('budget_min') && $request->budget_min) {
            $query->where('budget', '>=', $request->budget_min);
        }

        if ($request->has('budget_max') && $request->budget_max) {
            $query->where('budget', '<=', $request->budget_max);
        }

        $jobs = $query->with('client')->latest()->paginate(12);

        return view('jobs.search', compact('jobs'));
    }
}