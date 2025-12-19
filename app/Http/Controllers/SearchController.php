<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Skill;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');
        
        $results = [
            'jobs' => collect(),
            'freelancers' => collect(),
            'skills' => collect()
        ];
        
        if (!empty($query)) {
            // Search for freelancers - use 'role' column
            if ($type === 'all' || $type === 'freelancers') {
                try {
                    $results['freelancers'] = User::where('role', 'freelancer')
                        ->where(function($q) use ($query) {
                            $q->where('name', 'LIKE', "%{$query}%")
                              ->orWhere('email', 'LIKE', "%{$query}%")
                              ->orWhere('bio', 'LIKE', "%{$query}%")
                              ->orWhere('title', 'LIKE', "%{$query}%");
                        })
                        ->take(10)
                        ->get();
                } catch (\Exception $e) {
                    $results['freelancers'] = collect();
                }
            }
            
            // Search for skills
            if ($type === 'all' || $type === 'skills') {
                try {
                    $results['skills'] = Skill::where('name', 'LIKE', "%{$query}%")
                        ->take(10)
                        ->get();
                } catch (\Exception $e) {
                    $results['skills'] = collect();
                }
            }
            
            // Search for jobs - only if Job model exists
            if ($type === 'all' || $type === 'jobs') {
                try {
                    // Check if Job model exists
                    if (class_exists('App\Models\Job')) {
                        $results['jobs'] = \App\Models\Job::where('status', 'open')
                            ->where(function($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                  ->orWhere('description', 'LIKE', "%{$query}%");
                            })
                            ->take(10)
                            ->get();
                    }
                    // Or check if MarketplaceJob exists
                    elseif (class_exists('App\Models\MarketplaceJob')) {
                        $results['jobs'] = \App\Models\MarketplaceJob::where('status', 'open')
                            ->where(function($q) use ($query) {
                                $q->where('title', 'LIKE', "%{$query}%")
                                  ->orWhere('description', 'LIKE', "%{$query}%");
                            })
                            ->take(10)
                            ->get();
                    }
                } catch (\Exception $e) {
                    $results['jobs'] = collect();
                }
            }
        }
        
        return view('search.results', compact('query', 'type', 'results'));
    }
    
    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        $suggestions = [];
        
        if (strlen($query) >= 2) {
            try {
                $jobs = collect();
                $freelancers = collect();
                $skills = collect();
                
                // Job suggestions - only if route exists
                if (class_exists('App\Models\Job')) {
                    $jobs = \App\Models\Job::where('status', 'open')
                        ->where('title', 'LIKE', "%{$query}%")
                        ->take(3)
                        ->get()
                        ->map(function($job) {
                            // Check if route exists using Laravel's Route facade
                            $routeExists = false;
                            try {
                                $routeExists = \Route::has('jobs.show');
                            } catch (\Exception $e) {
                                $routeExists = false;
                            }
                            
                            return [
                                'title' => $job->title,
                                'type' => 'job',
                                'url' => $routeExists ? route('jobs.show', $job) : '#'
                            ];
                        });
                }
                
                // Freelancer suggestions
                $freelancers = User::where('role', 'freelancer')
                    ->where('name', 'LIKE', "%{$query}%")
                    ->take(3)
                    ->get()
                    ->map(function($user) {
                        return [
                            'title' => $user->name,
                            'type' => 'freelancer',
                            'url' => '#'
                        ];
                    });
                
                // Skill suggestions
                if (class_exists('App\Models\Skill')) {
                    $skills = Skill::where('name', 'LIKE', "%{$query}%")
                        ->take(3)
                        ->get()
                        ->map(function($skill) {
                            return [
                                'title' => $skill->name,
                                'type' => 'skill',
                                'url' => '#'
                            ];
                        });
                }
                
                $suggestions = collect()
                    ->merge($jobs)
                    ->merge($freelancers)
                    ->merge($skills)
                    ->take(5)
                    ->values();
                    
            } catch (\Exception $e) {
                // Return empty suggestions if there's an error
                $suggestions = collect();
            }
        }
        
        return response()->json([
            'suggestions' => $suggestions
        ]);
    }
}