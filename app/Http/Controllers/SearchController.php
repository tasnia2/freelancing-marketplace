<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    /**
     * Handle both /search and search results
     */
    public function index(Request $request)
    {
        return $this->results($request);
    }
    
    /**
     * Handle search results
     */
    public function results(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'all');
        
        $results = [
            'jobs' => collect(),
            'freelancers' => collect(),
            'skills' => collect(),
        ];
        
        if (!empty($query)) {
            // === SEARCH JOBS ===
            if ($type == 'all' || $type == 'jobs') {
                $results['jobs'] = $this->searchJobs($request, $query);
            }
            
            // === SEARCH FREELANCERS ===
            if ($type == 'all' || $type == 'freelancers') {
                $results['freelancers'] = $this->searchFreelancers($request, $query);
            }
            
            // === SEARCH SKILLS ===
            if ($type == 'all' || $type == 'skills') {
                $results['skills'] = $this->searchSkills($request, $query);
            }
        }
        
        return view('search.results', [
            'query' => $query,
            'type' => $type,
            'results' => $results,
        ]);
    }
    
    /**
     * Search jobs in database
     */
    private function searchJobs(Request $request, $query)
    {
        try {
            // First try to use MarketplaceJob model if it exists
            if (class_exists('App\Models\MarketplaceJob')) {
                $jobsQuery = \App\Models\MarketplaceJob::query();
            } 
            // Then try Job model
            elseif (class_exists('App\Models\Job')) {
                $jobsQuery = \App\Models\Job::query();
            } 
            // Fallback to direct database
            else {
                return $this->searchJobsDirectDB($request, $query);
            }
            
            // Apply search query
            $jobsQuery->where('status', 'open')
                ->where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                });
            
            // Apply filters
            $this->applyJobFilters($jobsQuery, $request);
            
            // Get results with client relationship
            return $jobsQuery->with('client')->take(9)->get();
            
        } catch (\Exception $e) {
            // Fallback to direct DB query
            return $this->searchJobsDirectDB($request, $query);
        }
    }
    
    /**
     * Search jobs using direct database query
     */
    private function searchJobsDirectDB(Request $request, $query)
    {
        $tableName = $this->getJobsTableName();
        
        if (!$tableName) {
            return $this->getSampleJobs($query);
        }
        
        $jobsQuery = DB::table($tableName)
            ->where('status', 'open')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        
        // Apply filters
        if ($request->filled('job_type') && Schema::hasColumn($tableName, 'job_type')) {
            $jobsQuery->where('job_type', $request->job_type);
        }
        
        if ($request->filled('experience_level') && Schema::hasColumn($tableName, 'experience_level')) {
            $jobsQuery->where('experience_level', $request->experience_level);
        }
        
        if ($request->filled('budget_min') && Schema::hasColumn($tableName, 'budget')) {
            $jobsQuery->where('budget', '>=', $request->budget_min);
        }
        
        if ($request->filled('budget_max') && Schema::hasColumn($tableName, 'budget')) {
            $jobsQuery->where('budget', '<=', $request->budget_max);
        }
        
        if ($request->filled('remote_only') && Schema::hasColumn($tableName, 'is_remote')) {
            $jobsQuery->where('is_remote', true);
        }
        
        if ($request->filled('urgent_only') && Schema::hasColumn($tableName, 'is_urgent')) {
            $jobsQuery->where('is_urgent', true);
        }
        
        $jobs = $jobsQuery->take(9)->get();
        
        // Convert to objects with client property
        return $jobs->map(function($job) {
            $job = (object) $job;
            $job->client = (object) ['name' => 'Client'];
            return $job;
        });
    }
    
    /**
     * Apply job filters to query
     */
    private function applyJobFilters($query, Request $request)
    {
        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }
        
        if ($request->filled('experience_level')) {
            $query->where('experience_level', $request->experience_level);
        }
        
        if ($request->filled('budget_min')) {
            $query->where('budget', '>=', $request->budget_min);
        }
        
        if ($request->filled('budget_max')) {
            $query->where('budget', '<=', $request->budget_max);
        }
        
        if ($request->filled('remote_only')) {
            $query->where('is_remote', true);
        }
        
        if ($request->filled('urgent_only')) {
            $query->where('is_urgent', true);
        }
    }
    
    /**
     * Get jobs table name
     */
    private function getJobsTableName()
    {
        if (Schema::hasTable('marketplace_jobs')) {
            return 'marketplace_jobs';
        } elseif (Schema::hasTable('jobs')) {
            return 'jobs';
        }
        return null;
    }
    
    /**
     * Search freelancers
     */
    private function searchFreelancers(Request $request, $query)
    {
        try {
            return \App\Models\User::where('role', 'freelancer')
                ->where(function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%")
                      ->orWhere('title', 'like', "%{$query}%")
                      ->orWhere('bio', 'like', "%{$query}%");
                })
                ->take(9)
                ->get();
        } catch (\Exception $e) {
            return $this->getSampleFreelancers($query);
        }
    }
    
    /**
     * Search skills
     */
    private function searchSkills(Request $request, $query)
    {
        try {
            if (class_exists('App\Models\Skill')) {
                return \App\Models\Skill::where('name', 'like', "%{$query}%")
                    ->take(20)
                    ->get();
            }
            return collect();
        } catch (\Exception $e) {
            return $this->getSampleSkills($query);
        }
    }
    
    /**
     * Get sample jobs (fallback)
     */
    private function getSampleJobs($query)
    {
        return collect([
            (object)[
                'id' => 1,
                'title' => "{$query} Designer Needed",
                'description' => "Looking for a skilled {$query} to create modern designs.",
                'budget' => 2500,
                'hourly_rate' => 40,
                'job_type' => 'fixed',
                'experience_level' => 'intermediate',
                'is_remote' => true,
                'is_urgent' => false,
                'status' => 'open',
                'created_at' => now()->subDays(2),
                'client' => (object)['name' => 'Design Studio']
            ],
            (object)[
                'id' => 2,
                'title' => "Senior {$query} Expert",
                'description' => "Need an expert in {$query} for brand identity design.",
                'budget' => 5000,
                'hourly_rate' => 65,
                'job_type' => 'hourly',
                'experience_level' => 'expert',
                'is_remote' => true,
                'is_urgent' => true,
                'status' => 'open',
                'created_at' => now()->subDays(1),
                'client' => (object)['name' => 'Marketing Agency']
            ],
        ]);
    }
    
    /**
     * Get sample freelancers
     */
    private function getSampleFreelancers($query)
    {
        return collect([
            (object)[
                'id' => 1,
                'name' => 'Alex Johnson',
                'title' => "Senior {$query}",
                'bio' => "Experienced {$query} with 5+ years in creative design.",
                'hourly_rate' => 60,
                'location' => 'New York',
                'rating' => 4.9,
                'created_at' => now()->subMonths(18),
                'role' => 'freelancer'
            ],
            (object)[
                'id' => 2,
                'name' => 'Sarah Miller',
                'title' => "UI/UX {$query}",
                'bio' => "Specialized in user interface design and {$query}.",
                'hourly_rate' => 75,
                'location' => 'San Francisco',
                'rating' => 4.7,
                'created_at' => now()->subMonths(12),
                'role' => 'freelancer'
            ],
        ]);
    }
    
    /**
     * Get sample skills
     */
    private function getSampleSkills($query)
    {
        return collect([
            (object)['id' => 1, 'name' => $query, 'jobs_count' => 15],
            (object)['id' => 2, 'name' => "Web {$query}", 'jobs_count' => 8],
            (object)['id' => 3, 'name' => "Digital {$query}", 'jobs_count' => 12],
        ]);
    }
}