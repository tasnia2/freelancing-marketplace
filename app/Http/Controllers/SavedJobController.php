<?php

namespace App\Http\Controllers;

use App\Models\MarketplaceJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedJobController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get saved jobs with eager loading
        $savedJobs = $user->savedJobs()
            ->with(['client', 'proposals' => function($query) use ($user) {
                $query->where('freelancer_id', $user->id);
            }])
            ->paginate(10);
        
        // Get recommended jobs (not saved)
        $recommendedJobs = MarketplaceJob::whereDoesntHave('savedByUsers', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'active')
            ->with('client')
            ->latest()
            ->take(5)
            ->get();
        
        return view('dashboard.freelancer.saved-jobs', compact('savedJobs', 'recommendedJobs'));
    }
    
    public function save(Request $request, $jobId)
    {
        $user = Auth::user();
        $job = MarketplaceJob::findOrFail($jobId);
        
        if (!$user->savedJobs()->where('marketplace_job_id', $jobId)->exists()) {
            $user->savedJobs()->attach($jobId);
            
            return response()->json([
                'success' => true,
                'message' => 'Job saved successfully!',
                'action' => 'saved',
                'count' => $user->savedJobs()->count()
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Job already saved',
            'action' => 'already_saved'
        ]);
    }
    
    public function unsave(Request $request, $jobId)
    {
        $user = Auth::user();
        $user->savedJobs()->detach($jobId);
        
        return response()->json([
            'success' => true,
            'message' => 'Job removed from saved list',
            'action' => 'unsaved',
            'count' => $user->savedJobs()->count()
        ]);
    }
    
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:unsave,apply',
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:marketplace_jobs,id'
        ]);
        
        $user = Auth::user();
        
        if ($request->action === 'unsave') {
            $user->savedJobs()->detach($request->job_ids);
            $message = count($request->job_ids) . ' job(s) removed from saved list';
        } else {
            // For apply action - you might want to redirect to apply page
            // or show apply modal for each job
            $message = 'Apply functionality would be triggered for ' . count($request->job_ids) . ' job(s)';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'count' => $user->savedJobs()->count()
        ]);
    }
    
    public function stats()
    {
        $user = Auth::user();
        $totalSaved = $user->savedJobs()->count();
        $appliedFromSaved = $user->savedJobs()
            ->whereHas('proposals', function($query) use ($user) {
                $query->where('freelancer_id', $user->id);
            })->count();
        
        return response()->json([
            'total' => $totalSaved,
            'applied' => $appliedFromSaved,
            'not_applied' => $totalSaved - $appliedFromSaved
        ]);
    }
}