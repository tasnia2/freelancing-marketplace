<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\MarketplaceJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Contract::where('client_id', $user->id)
            ->with(['job', 'freelancer'])
            ->latest();
        
        $status = $request->get('status', 'all');
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $contracts = $query->paginate(10);
        
        $contractStats = [
            'all' => Contract::where('client_id', $user->id)->count(),
            'draft' => Contract::where('client_id', $user->id)->where('status', 'draft')->count(),
            'active' => Contract::where('client_id', $user->id)->where('status', 'active')->count(),
            'completed' => Contract::where('client_id', $user->id)->where('status', 'completed')->count(),
        ];
        
        return view('dashboard.client.contracts', compact('contracts', 'contractStats', 'status'));
    }
    
    public function create(MarketplaceJob $job, User $freelancer)
    {
        if ($job->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $proposal = $job->proposals()
            ->where('freelancer_id', $freelancer->id)
            ->where('status', 'accepted')
            ->firstOrFail();
        
        return view('dashboard.client.contracts-create', compact('job', 'freelancer', 'proposal'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:marketplace_jobs,id',
            'freelancer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:100',
            'amount' => 'required|numeric|min:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'milestones' => 'nullable|array',
            'milestones.*.title' => 'required|string|max:255',
            'milestones.*.amount' => 'required|numeric|min:1',
            'milestones.*.due_date' => 'required|date',
            'terms' => 'nullable|array',
            'terms.*' => 'string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:5120',
        ]);
        
        $job = MarketplaceJob::find($validated['job_id']);
        
        if ($job->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Handle attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('contract_attachments', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $file->getMimeType()
                ];
            }
        }
        
        $contract = Contract::create([
            'job_id' => $validated['job_id'],
            'client_id' => Auth::id(),
            'freelancer_id' => $validated['freelancer_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'amount' => $validated['amount'],
            'status' => 'active',
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'milestones' => $validated['milestones'] ?? [],
            'terms' => $validated['terms'] ?? [],
            'attachments' => $attachments,
        ]);
        
        // Update job status if not already in progress
        if ($job->status !== 'in_progress') {
            $job->update(['status' => 'in_progress']);
        }
        
        // Notification to freelancer
        $freelancer = User::find($validated['freelancer_id']);
        $freelancer->notifications()->create([
            'type' => 'contract_created',
            'title' => 'New Contract',
            'message' => 'A contract has been created for "' . $validated['title'] . '"',
            'data' => json_encode(['contract_id' => $contract->id]),
            'read' => false,
        ]);
        
        return redirect()->route('client.contracts.show', $contract)
            ->with('success', 'Contract created successfully!');
    }
    
    public function show(Contract $contract)
    {
        if ($contract->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $contract->load(['job', 'freelancer.profile']);
        
        return view('dashboard.client.contracts-show', compact('contract'));
    }
    
    public function complete(Contract $contract)
    {
        if ($contract->client_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $contract->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);
        
        // Update job status
        $contract->job->update(['status' => 'completed']);
        
        // Notification to freelancer
        $contract->freelancer->notifications()->create([
            'type' => 'contract_completed',
            'title' => 'Contract Completed',
            'message' => 'The contract for "' . $contract->title . '" has been marked as completed.',
            'data' => json_encode(['contract_id' => $contract->id]),
            'read' => false,
        ]);
        
        return redirect()->back()->with('success', 'Contract marked as completed!');
    }
}