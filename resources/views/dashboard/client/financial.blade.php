<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                    Financial Dashboard
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Track your spending, payments, and financial reports
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="downloadReport()"
                        class="px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                    <i class="fas fa-download text-[#456882]"></i>
                    <span>Export Report</span>
                </button>
                <a href="{{ route('client.financial.reports') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] text-white rounded-lg hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-chart-bar"></i>
                    <span>View Reports</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Financial Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Spent -->
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Total Spent</p>
                            <h3 class="text-3xl font-bold mt-2">${{ number_format($stats['total_spent'], 0) }}</h3>
                            <p class="text-sm text-[#E3E3E3] mt-2">{{ $stats['completed_contracts'] }} completed contracts</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-wallet text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">Active Contracts</span>
                            <span class="font-semibold">${{ number_format($stats['active_contracts_value'], 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Payments -->
                <div class="bg-gradient-to-r from-[#456882] to-[#3A5A72] rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Pending Payments</p>
                            <h3 class="text-3xl font-bold mt-2">${{ number_format($stats['pending_payments'], 0) }}</h3>
                            <p class="text-sm text-[#E3E3E3] mt-2">Overdue or due soon</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">Upcoming (7 days)</span>
                            <span class="font-semibold">${{ number_format($stats['upcoming_payments'], 0) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Total Contracts -->
                <div class="bg-gradient-to-r from-[#234C6A] to-[#1B3C53] rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Total Contracts</p>
                            <h3 class="text-3xl font-bold mt-2">{{ $stats['total_contracts'] }}</h3>
                            <p class="text-sm text-[#E3E3E3] mt-2">All time contracts</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-file-contract text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <div class="flex justify-between text-sm">
                            <span class="text-[#E3E3E3]">Avg. Contract Value</span>
                            <span class="font-semibold">${{ $stats['total_contracts'] > 0 ? number_format($stats['total_spent'] / $stats['total_contracts'], 0) : 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="bg-gradient-to-r from-[#1B3C53] to-[#456882] rounded-2xl p-6 text-white shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[#E3E3E3] text-sm">Payment Methods</p>
                            <h3 class="text-3xl font-bold mt-2">{{ count($paymentMethods) }}</h3>
                            <p class="text-sm text-[#E3E3E3] mt-2">{{ $paymentMethods->firstWhere('is_default', true)->type ?? 'None' }} is default</p>
                        </div>
                        <div class="bg-white/20 p-3 rounded-xl">
                            <i class="fas fa-credit-card text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-white/20">
                        <a href="{{ route('client.financial.payment-methods') }}" 
                           class="text-sm text-white hover:text-[#E3E3E3] flex items-center">
                            <span>Manage Methods</span>
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Monthly Spending Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                            <i class="fas fa-chart-line text-[#234C6A] mr-2"></i>
                            Monthly Spending Trend
                        </h3>
                        <select class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg text-sm dark:bg-gray-700 dark:text-white">
                            <option>Last 6 Months</option>
                            <option>Last Year</option>
                            <option>All Time</option>
                        </select>
                    </div>
                    <div class="h-64">
                        <canvas id="spendingChart"></canvas>
                    </div>
                </div>

                <!-- Spending by Category -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6 flex items-center">
                        <i class="fas fa-chart-pie text-[#456882] mr-2"></i>
                        Spending by Category
                    </h3>
                    <div class="h-64">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions & Upcoming Payments -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Transactions -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-exchange-alt text-[#1B3C53] mr-2"></i>
                                Recent Transactions
                            </h3>
                            <a href="{{ route('client.financial.transactions') }}" 
                               class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                                View All →
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-800 dark:text-white">
                                            {{ $transaction->created_at->format('M d') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $transaction->created_at->format('g:i A') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-800 dark:text-white">
                                            {{ $transaction->description ?? 'Contract Payment' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            @if($transaction->contract)
                                                {{ Str::limit($transaction->contract->title, 30) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-lg font-bold 
                                            {{ $transaction->amount > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->amount > 0 ? '+' : '' }}${{ number_format(abs($transaction->amount), 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                               ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                               'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-exchange-alt text-3xl mb-2"></i>
                                        <p>No transactions yet</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Upcoming Payments -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white flex items-center">
                                <i class="fas fa-calendar-alt text-[#234C6A] mr-2"></i>
                                Upcoming Payments
                            </h3>
                            <a href="{{ route('client.contracts') }}?status=active" 
                               class="text-sm text-[#456882] hover:text-[#1B3C53] dark:text-gray-400 dark:hover:text-white">
                                View All →
                            </a>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($upcomingContracts as $contract)
                        <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-800 dark:text-white">
                                        {{ Str::limit($contract->title, 30) }}
                                    </h4>
                                    <div class="flex items-center mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        <div class="w-6 h-6 rounded-full bg-gradient-to-r from-[#1B3C53] to-[#456882] flex items-center justify-center text-white text-xs mr-2">
                                            {{ substr($contract->freelancer->name, 0, 1) }}
                                        </div>
                                        {{ $contract->freelancer->name }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-[#234C6A] dark:text-[#456882]">
                                        ${{ number_format($contract->amount, 0) }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Due {{ $contract->end_date->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400 mb-1">
                                    <span>Progress</span>
                                    <span>{{ $contract->getProgressPercentage() }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
    <div class="progress-bar bg-gradient-to-r from-[#1B3C53] to-[#456882] h-2 rounded-full"
         data-progress="{{ $contract->getProgressPercentage() }}"
         style="width: 0%;">
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.progress-bar').forEach(bar => {
        let progress = parseInt(bar.dataset.progress, 10);
        progress = Math.max(0, Math.min(100, progress));

        setTimeout(() => {
            bar.style.width = progress + '%';
        }, 100);
    });
});
</script>


                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-calendar-check text-3xl mb-2"></i>
                            <p>No upcoming payments</p>
                            <p class="text-sm mt-1">All payments are up to date</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('client.financial.transactions') }}" 
                   class="p-6 bg-gradient-to-r from-[#1B3C53] to-[#234C6A] rounded-2xl text-white hover:from-[#234C6A] hover:to-[#456882] transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-list-alt text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">View All Transactions</h4>
                            <p class="text-sm opacity-90 mt-1">Complete payment history</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('client.financial.invoices') }}" 
                   class="p-6 bg-gradient-to-r from-[#456882] to-[#3A5A72] rounded-2xl text-white hover:from-[#3A5A72] hover:to-[#1B3C53] transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Download Invoices</h4>
                            <p class="text-sm opacity-90 mt-1">Tax and accounting documents</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('client.financial.payment-methods') }}" 
                   class="p-6 bg-gradient-to-r from-[#234C6A] to-[#1B3C53] rounded-2xl text-white hover:from-[#1B3C53] hover:to-[#456882] transition-all duration-300">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-lg mr-4">
                            <i class="fas fa-credit-card text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold">Manage Payment Methods</h4>
                            <p class="text-sm opacity-90 mt-1">Add or update payment options</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
     document.addEventListener('DOMContentLoaded', function() {
    // Safely get PHP data with defaults
    const monthlySpending = <?php echo json_encode($monthlySpending ?? []); ?>;
    const spendingByCategory = <?php echo json_encode($spendingByCategory ?? []); ?>;
    
    // Debug: Check what data we're receiving
    console.log('Monthly Spending:', monthlySpending);
    console.log('Spending by Category:', spendingByCategory);
    
    // Helper function to safely extract data
    function extractData(data, key) {
        if (!Array.isArray(data) || data.length === 0) {
            return [];
        }
        
        return data.map(item => {
            // Handle both cases: item might be object or array
            if (item && typeof item === 'object') {
                return item[key] !== undefined ? item[key] : 0;
            }
            return 0;
        });
    }
    
    // Extract data safely
    const spendingLabels = extractData(monthlySpending, 'month');
    const spendingAmounts = extractData(monthlySpending, 'amount');
    const spendingContracts = extractData(monthlySpending, 'contracts');
    
    const categoryLabels = extractData(spendingByCategory, 'category');
    const categoryPercentages = extractData(spendingByCategory, 'percentage');
    const categoryAmounts = extractData(spendingByCategory, 'amount');
    
    // Debug extracted data
    console.log('Spending Labels:', spendingLabels);
    console.log('Spending Amounts:', spendingAmounts);
    console.log('Category Labels:', categoryLabels);
    console.log('Category Percentages:', categoryPercentages);
    
    // Create charts only if elements exist
    createSpendingChart(spendingLabels, spendingAmounts, spendingContracts);
    createCategoryChart(categoryLabels, categoryPercentages, categoryAmounts);
});

function createSpendingChart(labels, amounts, contracts) {
    const spendingCtx = document.getElementById('spendingChart');
    
    if (!spendingCtx) {
        console.error('Spending chart element not found');
        return;
    }
    
    // If no data, show empty chart
    if (labels.length === 0 || amounts.length === 0) {
        labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        amounts = [0, 0, 0, 0, 0, 0];
        contracts = [0, 0, 0, 0, 0, 0];
    }
    
    try {
        const spendingChart = new Chart(spendingCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Spending ($)',
                    data: amounts,
                    borderColor: '#1B3C53',
                    backgroundColor: 'rgba(27, 60, 83, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#234C6A',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const amount = context.raw || 0;
                                const contractCount = contracts[context.dataIndex] || 0;
                                return `$${amount.toLocaleString()} (${contractCount} contracts)`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    }
                }
            }
        });
        
        // Store chart for dark mode updates
        window.spendingChart = spendingChart;
        
    } catch (error) {
        console.error('Error creating spending chart:', error);
    }
}

function createCategoryChart(labels, percentages, amounts) {
    const categoryCtx = document.getElementById('categoryChart');
    
    if (!categoryCtx) {
        console.error('Category chart element not found');
        return;
    }
    
    // If no data, show empty chart
    if (labels.length === 0 || percentages.length === 0) {
        labels = ['No Data'];
        percentages = [100];
        amounts = [0];
    }
    
    try {
        const categoryChart = new Chart(categoryCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: percentages,
                    backgroundColor: [
                        '#1B3C53',
                        '#234C6A',
                        '#456882',
                        '#3A5A72',
                        '#2a3b4a'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const amount = amounts[context.dataIndex] || 0;
                                const percentage = context.raw || 0;
                                return `${context.label}: $${amount.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
        
        // Store chart for dark mode updates
        window.categoryChart = categoryChart;
        
    } catch (error) {
        console.error('Error creating category chart:', error);
    }
}

// Dark mode updates
function updateChartThemes() {
    const isDark = document.documentElement.classList.contains('dark');
    
    [window.spendingChart, window.categoryChart].forEach(chart => {
        if (chart && chart.options && chart.options.scales) {
            chart.options.scales.x.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            chart.options.scales.y.grid.color = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
            chart.update();
        }
    });
}

// Listen for dark mode changes
document.addEventListener('DOMContentLoaded', function() {
    const observer = new MutationObserver(updateChartThemes);
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
});

        function downloadReport() {
            const format = prompt('Choose format: PDF or CSV', 'PDF');
            if (format) {
                window.open(`/client/financial/reports/download?format=${format.toLowerCase()}`, '_blank');
            }
        }

        // Auto-refresh transactions
        setInterval(() => {
            fetch('/client/financial/transactions?ajax=1')
                .then(response => response.json())
                .then(data => {
                    if (data.new_transactions > 0) {
                        showNotification(`You have ${data.new_transactions} new transaction(s)`);
                    }
                });
        }, 60000);

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-gradient-to-r from-[#1B3C53] to-[#456882] text-white px-6 py-4 rounded-lg shadow-xl z-50 transform translate-x-full transition-transform duration-500';
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-bell text-xl mr-3"></i>
                    <div>
                        <div class="font-medium">New Transactions</div>
                        <div class="text-sm opacity-90">${message}</div>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 10);
            
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 500);
            }, 5000);
        }
    </script>
    @endpush

    @push('styles')
    <style>
        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.1;
            animation: float 20s linear infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-20px, -20px) rotate(360deg); }
        }

        .transaction-row {
            transition: all 0.2s ease;
        }

        .transaction-row:hover {
            transform: translateX(4px);
            background: linear-gradient(90deg, rgba(27, 60, 83, 0.05), transparent);
        }

        .dark .transaction-row:hover {
            background: linear-gradient(90deg, rgba(27, 60, 83, 0.2), transparent);
        }

        .progress-bar-animated {
            position: relative;
            overflow: hidden;
        }

        .progress-bar-animated::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .quick-action-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .quick-action-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(27, 60, 83, 0.2);
        }

        .quick-action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 3s infinite;
        }
    </style>
    @endpush
</x-app-layout>