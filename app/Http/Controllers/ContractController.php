<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\MarketplaceJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    // CLIENT: View contracts
   public function index()
{
    $user = Auth::user();
    
    $contracts = Contract::where('client_id', $user->id)
        ->with(['job', 'freelancer'])
        ->latest()
        ->paginate(10);
        
    
    // Add stats calculation
    $contractStats = [
        'all' => Contract::where('client_id', $user->id)->count(),
        'draft' => Contract::where('client_id', $user->id)->where('status', 'draft')->count(),
        'active' => Contract::where('client_id', $user->id)->where('status', 'active')->count(),
        'completed' => Contract::where('client_id', $user->id)->where('status', 'completed')->count(),
        'cancelled' => Contract::where('client_id', $user->id)->where('status', 'cancelled')->count(),
    ];
    
    return view('dashboard.client.contracts', compact('contracts', 'contractStats'));
}

    // FREELANCER: View contracts
    public function freelancerIndex()
    {
        $contracts = Contract::where('freelancer_id', Auth::id())
            ->with(['job', 'client'])
            ->latest()
            ->paginate(10);
        
        return view('dashboard.freelancer.contracts', compact('contracts'));
    }

    // Create contract page
    public function create(MarketplaceJob $job, User $freelancer)
    {
        // Check if client owns the job
        if ($job->client_id !== Auth::id()) {
            abort(403);
        }
        
        return view('dashboard.client.contracts-create', compact('job', 'freelancer'));
    }

    // Store contract
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_id' => 'required|exists:marketplace_jobs,id',
            'freelancer_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:10',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);
        
        // Create contract
        // Update existing draft or create new
$contract = Contract::updateOrCreate(
    [
        'job_id' => $validated['job_id'],
        'freelancer_id' => $validated['freelancer_id'],
    ],
    [
        'client_id' => Auth::id(),
        'title' => $validated['title'],
        'description' => $validated['description'],
        'amount' => $validated['amount'],
        'status' => 'active', // Change draft to active
        'start_date' => $validated['start_date'],
        'end_date' => $validated['end_date'],
    ]
);
        
        // Update job status
        MarketplaceJob::where('id', $validated['job_id'])->update(['status' => 'in_progress']);
        
        return redirect()->route('client.contracts.show', $contract)
            ->with('success', 'Contract created successfully!');
    }

    // Show contract (BOTH client and freelancer can view)
    public function show(Contract $contract)
    {
        // Check if user is either client or freelancer
        if (!$contract->canView(Auth::id())) {
            abort(403);
        }
        
        $contract->load(['job', 'client', 'freelancer']);
        
        // Determine which view to show based on user role
        if (Auth::id() == $contract->client_id) {
            return view('dashboard.client.contracts-show', compact('contract'));
        } else {
            return view('dashboard.freelancer.contracts-show', compact('contract'));
        }
    }

    // Complete contract (client only)
    public function complete(Contract $contract)
    {
        if ($contract->client_id !== Auth::id()) {
            abort(403);
        }
        
        $contract->update([
            'status' => 'completed',
            'end_date' => now(),
        ]);
        
        // Update job status
        $contract->job->update(['status' => 'completed']);
        
        return redirect()->back()->with('success', 'Contract marked as completed!');
    }
}