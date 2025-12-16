<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\MarketplaceJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    
    // Financial Overview Stats
    $stats = [
        'total_spent' => (float) (Contract::where('client_id', $user->id)
        ->where('status', 'completed')
        ->sum('amount') ?? 0),
        
        'active_contracts_value' => (float) (Contract::where('client_id', $user->id)
            ->where('status', 'active')
            ->sum('amount') ?? 0),
        
        'pending_payments' => (float) (Contract::where('client_id', $user->id)
            ->where('status', 'active')
            ->where('end_date', '<=', now())
            ->sum('amount') ?? 0),
        
        'upcoming_payments' => (float)( Contract::where('client_id', $user->id)
            ->where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(7)])
            ->sum('amount') ?? 0),
        
        'total_contracts' => (int) Contract::where('client_id', $user->id)->count(),
        'completed_contracts' => (int) Contract::where('client_id', $user->id)
            ->where('status', 'completed')
            ->count(),
    ];
    
    // Monthly spending for chart - ensure it's always an array
     $monthlySpending = $this->validateChartData(
        $this->getMonthlySpending($user), 
        ['month', 'amount', 'contracts']
    );
    
    // Validate monthly spending structure
    if (empty($monthlySpending) || !is_array($monthlySpending)) {
        $monthlySpending = [];
    }
    
    // Recent transactions
    $transactions = Transaction::where(function($query) use ($user) {
    $query->where('user_id', $user->id)
          ->orWhere('payer_id', $user->id);
                })
             ->with(['user', 'payer', 'contract'])
              ->latest()
                ->take(20)
              ->get();
    
    // Contracts with upcoming payments
    $upcomingContracts = Contract::where('client_id', $user->id)
        ->where('status', 'active')
        ->whereBetween('end_date', [now(), now()->addDays(30)])
        ->with('freelancer')
        ->orderBy('end_date')
        ->get();
    
    // Spending by category - ensure it's always an array
     $spendingByCategory = $this->validateChartData(
        $this->getSpendingByCategory($user),
        ['category', 'amount', 'percentage']
    );
    
    // If no spending data, create empty structure
    if (empty($spendingByCategory) || !is_array($spendingByCategory)) {
        $spendingByCategory = [];
    }
    
    // Payment methods
    $paymentMethods = $user->paymentMethods()->where('is_default', true)->get();
    
    return view('dashboard.client.financial', compact(
        'stats', 
        'monthlySpending',
        'transactions',
        'upcomingContracts',
        'spendingByCategory',
        'paymentMethods'
    ));
}
    
    public function transactions(Request $request)
    {
        $user = Auth::user();
        
        $query = Transaction::where('user_id', $user->id)
            ->orWhere('payer_id', $user->id)
            ->with(['user', 'payer', 'contract']);
        
        // Filters
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $transactions = $query->latest()->paginate(20);
        
        $transactionStats = [
            'total' => Transaction::where('user_id', $user->id)->orWhere('payer_id', $user->id)->count(),
            'completed' => Transaction::where('user_id', $user->id)->orWhere('payer_id', $user->id)
                ->where('status', 'completed')->count(),
            'pending' => Transaction::where('user_id', $user->id)->orWhere('payer_id', $user->id)
                ->where('status', 'pending')->count(),
            'failed' => Transaction::where('user_id', $user->id)->orWhere('payer_id', $user->id)
                ->where('status', 'failed')->count(),
        ];
        
        return view('dashboard.client.financial-transactions', compact('transactions', 'transactionStats'));
    }
    
    public function invoices()
    {
        $user = Auth::user();
        
        $invoices = Contract::where('client_id', $user->id)
            ->where('status', 'completed')
            ->with('freelancer')
            ->latest()
            ->paginate(20);
        
        return view('dashboard.client.financial-invoices', compact('invoices'));
    }
    
    public function generateInvoice(Contract $contract)
    {
        if ($contract->client_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        // Generate invoice PDF
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad($contract->id, 6, '0', STR_PAD_LEFT);
        
        // Return PDF or HTML view
        return view('dashboard.client.invoice-pdf', compact('contract', 'invoiceNumber'));
    }
    
    public function paymentMethods()
    {
        $user = Auth::user();
        $paymentMethods = $user->paymentMethods()->latest()->get();
        
        return view('dashboard.client.financial-payment-methods', compact('paymentMethods'));
    }
    
    public function storePaymentMethod(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:card,bank,paypal',
            'card_number' => 'required_if:type,card',
            'card_holder' => 'required_if:type,card',
            'expiry_month' => 'required_if:type,card',
            'expiry_year' => 'required_if:type,card',
            'cvv' => 'required_if:type,card',
            'bank_name' => 'required_if:type,bank',
            'account_number' => 'required_if:type,bank',
            'routing_number' => 'required_if:type,bank',
            'paypal_email' => 'required_if:type,paypal|email',
        ]);
        
        try {
        $user = Auth::user();
        
        $paymentMethod = $user->paymentMethods()->create([
            'type' => $validated['type'],
            'details' => encrypt(json_encode($validated)),
            'is_default' => $user->paymentMethods()->count() === 0,
            'last_four' => $validated['type'] === 'card' ? substr($validated['card_number'], -4) : null,
        ]);
        
        return redirect()->back()->with('success', 'Payment method added successfully');
        
    } catch (\Exception $e) {
        \Log::error('Error storing payment method: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to add payment method. Please try again.');
    }
}
    
    public function makeDefaultPaymentMethod($id)
    {
        $user = Auth::user();
        
        // Reset all to not default
        $user->paymentMethods()->update(['is_default' => false]);
        
        // Set selected as default
        $user->paymentMethods()->where('id', $id)->update(['is_default' => true]);
        
        return redirect()->back()->with('success', 'Default payment method updated');
    }
    
    public function deletePaymentMethod($id)
    {
        $user = Auth::user();
        $paymentMethod = $user->paymentMethods()->findOrFail($id);
        
        if ($paymentMethod->is_default && $user->paymentMethods()->count() > 1) {
            return redirect()->back()->with('error', 'Cannot delete default payment method. Set another as default first.');
        }
        
        $paymentMethod->delete();
        
        return redirect()->back()->with('success', 'Payment method deleted');
    }
    
    public function reports(Request $request)
    {
        $user = Auth::user();
        
        
        $reportType = $request->get('type', 'monthly');
        $dateFrom = $request->get('date_from', now()->subYear());
        $dateTo = $request->get('date_to', now());
        
        $reportData = $this->generateReport($user, $reportType, $dateFrom, $dateTo);
        
        return view('dashboard.client.financial-reports', compact('reportData', 'reportType', 'dateFrom', 'dateTo'));
    }
    
    public function downloadReport(Request $request)
    {
        $user = Auth::user();
        $format = $request->get('format', 'pdf');
        $reportType = $request->get('type', 'monthly');
        
        $reportData = $this->generateReport($user, $reportType, $request->date_from, $request->date_to);
        
        if ($format === 'csv') {
            return $this->generateCSV($reportData);
        }
        
        // Generate PDF
        return view('dashboard.client.financial-report-pdf', compact('reportData'));
    }
    
private function getMonthlySpending($user)
{
    $data = [];
    
    // Get all completed contracts for the last 6 months
    $sixMonthsAgo = now()->subMonths(6)->startOfMonth();
    
    $contractsData = Contract::where('client_id', $user->id)
        ->where('status', 'completed')
        ->where('created_at', '>=', $sixMonthsAgo)
        ->select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month_name"),
            DB::raw("MONTH(created_at) as month_num"),
            DB::raw("YEAR(created_at) as year"),
            DB::raw("SUM(amount) as total_amount"),
            DB::raw("COUNT(*) as contract_count")
        )
        ->groupBy('year', 'month_num', 'month_name')
        ->orderBy('year')
        ->orderBy('month_num')
        ->get();
    
    // Create a map of existing data
    $existingData = [];
    foreach ($contractsData as $item) {
        $existingData[$item->month_name] = [
            'amount' => (float) $item->total_amount,
            'contracts' => (int) $item->contract_count
        ];
    }
    
    // Build final array for last 6 months
    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $monthName = $month->format('M');
        
        $data[] = [
            'month' => $monthName,
            'amount' => $existingData[$monthName]['amount'] ?? 0.0,
            'contracts' => $existingData[$monthName]['contracts'] ?? 0
        ];
    }
    
    return $data;
}
    
  private function getSpendingByCategory($user)
{
    // Get actual spending by category from the database
    $categories = MarketplaceJob::where('client_id', $user->id)
        ->whereHas('contracts', function($query) {
            $query->where('status', 'completed');
        })
        ->with(['category', 'contracts' => function($query) {
            $query->where('status', 'completed');
        }])
        ->get();
    
    if ($categories->isEmpty()) {
        return [];
    }
    
    // Group by category and calculate totals
    $groupedData = [];
    foreach ($categories as $job) {
        $categoryName = $job->category->name ?? 'Uncategorized';
        $totalAmount = $job->contracts->sum('amount');
        
        if (!isset($groupedData[$categoryName])) {
            $groupedData[$categoryName] = [
                'category' => $categoryName,
                'amount' => 0,
                'percentage' => 0
            ];
        }
        $groupedData[$categoryName]['amount'] += $totalAmount;
    }
    
    // Calculate total for percentages
    $totalAmount = array_sum(array_column($groupedData, 'amount'));
    
    // Add percentages
    $result = [];
    foreach ($groupedData as $categoryName => $data) {
        $result[] = [
            'category' => $data['category'],
            'amount' => $data['amount'],
            'percentage' => $totalAmount > 0 ? round(($data['amount'] / $totalAmount) * 100, 1) : 0
        ];
    }
    
    // Sort by amount descending
    usort($result, function($a, $b) {
        return $b['amount'] <=> $a['amount'];
    });
    
    // Limit to top 5 categories
    return array_slice($result, 0, 5);
}
    
    private function generateReport($user, $type, $dateFrom, $dateTo)
    {
        $contracts = Contract::where('client_id', $user->id)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->with('freelancer')
            ->get();
        
        $transactions = Transaction::where('payer_id', $user->id)
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();
        
        return [
            'period' => [
                'from' => Carbon::parse($dateFrom)->format('M d, Y'),
                'to' => Carbon::parse($dateTo)->format('M d, Y')
            ],
            'summary' => [
                'total_spent' => $contracts->where('status', 'completed')->sum('amount'),
                'active_contracts' => $contracts->where('status', 'active')->sum('amount'),
                'total_transactions' => $transactions->count(),
                'avg_transaction' => $transactions->avg('amount'),
            ],
            'contracts' => $contracts,
            'transactions' => $transactions,
            'spending_trend' => $this->getSpendingTrend($user, $dateFrom, $dateTo)
        ];
    }
    
    private function getSpendingTrend($user, $dateFrom, $dateTo)
    {
        $data = [];
        $start = Carbon::parse($dateFrom);
        $end = Carbon::parse($dateTo);
        $diffInMonths = $start->diffInMonths($end);
        
        for ($i = 0; $i <= min($diffInMonths, 12); $i++) {
            $month = $start->copy()->addMonths($i);
            $total = Contract::where('client_id', $user->id)
                ->where('status', 'completed')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            
            $data[] = [
                'period' => $month->format('M Y'),
                'amount' => $total
            ];
        }
        
        return $data;
    }
    
    private function generateCSV($reportData)
    {
        $filename = 'financial-report-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($reportData) {
            $file = fopen('php://output', 'w');
            
            // Summary
            fputcsv($file, ['Financial Report', $reportData['period']['from'] . ' to ' . $reportData['period']['to']]);
            fputcsv($file, []);
            fputcsv($file, ['SUMMARY']);
            fputcsv($file, ['Total Spent', '$' . number_format($reportData['summary']['total_spent'], 2)]);
            fputcsv($file, ['Active Contracts Value', '$' . number_format($reportData['summary']['active_contracts'], 2)]);
            fputcsv($file, ['Total Transactions', $reportData['summary']['total_transactions']]);
            fputcsv($file, ['Average Transaction', '$' . number_format($reportData['summary']['avg_transaction'], 2)]);
            fputcsv($file, []);
            
            // Contracts
            fputcsv($file, ['CONTRACTS']);
            fputcsv($file, ['ID', 'Title', 'Freelancer', 'Amount', 'Status', 'Start Date', 'End Date']);
            foreach ($reportData['contracts'] as $contract) {
                fputcsv($file, [
                    $contract->id,
                    $contract->title,
                    $contract->freelancer->name,
                    '$' . number_format($contract->amount, 2),
                    ucfirst($contract->status),
                    $contract->start_date->format('Y-m-d'),
                    $contract->end_date ? $contract->end_date->format('Y-m-d') : 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    protected function validateChartData(array $data, array $requiredKeys = []): array
{
    if (empty($data) || !is_array($data)) {
        return [];
    }
    
    $validated = [];
    foreach ($data as $item) {
        if (is_array($item)) {
            $validItem = [];
            foreach ($requiredKeys as $key) {
                $validItem[$key] = $item[$key] ?? ($key === 'month' ? '' : 0);
            }
            $validated[] = $validItem;
        }
    }
    
    return $validated;
}
}