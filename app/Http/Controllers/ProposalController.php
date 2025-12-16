<?php

namespace App\Http\Controllers;

use App\Models\JobProposal;
use App\Models\MarketplaceJob;
use App\Models\Contract;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProposalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })
            ->with(['job', 'freelancer'])
            ->latest();
        
        $status = $request->get('status', 'all');
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        if ($request->has('job_id')) {
            $query->where('job_id', $request->job_id);
        }
        
        $proposals = $query->paginate(10);
        
        $proposalStats = [
            'all' => JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })->count(),
            'pending' => JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })->where('status', 'pending')->count(),
            'accepted' => JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })->where('status', 'accepted')->count(),
            'rejected' => JobProposal::whereHas('job', function($q) use ($user) {
                $q->where('client_id', $user->id);
            })->where('status', 'rejected')->count(),
        ];
        
        $jobs = MarketplaceJob::where('client_id', $user->id)
            ->where('status', 'open')
            ->get();
        
        return view('dashboard.client.proposals', compact('proposals', 'proposalStats', 'jobs', 'status'));
    }
    
    public function show(JobProposal $proposal)
    {
        $user = Auth::user();
        
        if ($proposal->job->client_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $proposal->load(['job', 'freelancer.profile', 'freelancer.reviewsReceived']);
        
        $similarProposals = JobProposal::where('job_id', $proposal->job_id)
            ->where('id', '!=', $proposal->id)
            ->where('status', 'pending')
            ->with('freelancer')
            ->take(3)
            ->get();
        
        return view('dashboard.client.proposal-show', compact('proposal', 'similarProposals'));
    }
    
    public function accept(Request $request, JobProposal $proposal)
    {
        $user = Auth::user();
        
        if ($proposal->job->client_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        if ($proposal->status !== 'pending') {
            return redirect()->back()->with('error', 'This proposal is no longer pending.');
        }
        
        DB::transaction(function () use ($proposal, $user) {
            // Accept this proposal
            $proposal->update(['status' => 'accepted']);
            
            // Reject all other proposals for this job
            JobProposal::where('job_id', $proposal->job_id)
                ->where('id', '!=', $proposal->id)
                ->update(['status' => 'rejected']);
            
            // Update job status
            $proposal->job->update(['status' => 'in_progress']);
            
            // Create contract draft
            $contract = Contract::create([
                'job_id' => $proposal->job_id,
                'client_id' => $user->id,
                'freelancer_id' => $proposal->freelancer_id,
                'title' => $proposal->job->title,
                'description' => $proposal->job->description,
                'amount' => $proposal->bid_amount,
                'status' => 'draft',
                'start_date' => now(),
                'end_date' => now()->addDays($proposal->estimated_days),
            ]);
            
            // Create notifications
            // For freelancer
            $proposal->freelancer->notifications()->create([
                'type' => 'proposal_accepted',
                'title' => 'Proposal Accepted!',
                'message' => 'Your proposal for "' . $proposal->job->title . '" has been accepted.',
                'data' => json_encode(['job_id' => $proposal->job_id, 'proposal_id' => $proposal->id]),
                'read' => false,
            ]);
            
            // For client
            $user->notifications()->create([
                'type' => 'freelancer_hired',
                'title' => 'Freelancer Hired',
                'message' => 'You have hired ' . $proposal->freelancer->name . ' for "' . $proposal->job->title . '"',
                'data' => json_encode(['job_id' => $proposal->job_id, 'freelancer_id' => $proposal->freelancer_id]),
                'read' => false,
            ]);
        });
        
        return redirect()->route('client.contracts.create', [
            'job' => $proposal->job_id,
            'freelancer' => $proposal->freelancer_id
        ])->with('success', 'Proposal accepted! Please create a contract.');
    }
    
    public function reject(JobProposal $proposal)
    {
        $user = Auth::user();
        
        if ($proposal->job->client_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $proposal->update(['status' => 'rejected']);
        
        // Notification to freelancer
        $proposal->freelancer->notifications()->create([
            'type' => 'proposal_rejected',
            'title' => 'Proposal Not Selected',
            'message' => 'Your proposal for "' . $proposal->job->title . '" was not selected.',
            'data' => json_encode(['job_id' => $proposal->job_id]),
            'read' => false,
        ]);
        
        return redirect()->back()->with('success', 'Proposal rejected.');
    }
    
    public function freelancerIndex()
    {
        $user = Auth::user();
        $proposals = $user->proposals()->with('job')->latest()->paginate(10);
        
        return view('dashboard.freelancer.proposals', compact('proposals'));
    }
}