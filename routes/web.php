<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SavedJobController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Str;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search.results'); // MOVED HERE
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions'); 
Route::get('/debug-session', function() {
    dd(session()->all());
});
// Demo reset password route (for direct access)
// Simple demo reset route
Route::get('/demo-reset', function() {
    $token = 'demo-token-' . time();
    $email = 'demo@example.com';
    
    return redirect()->route('password.reset', [
        'token' => $token,
        'email' => $email
    ]);
})->name('demo.reset');

// Auth routes
require __DIR__.'/auth.php';
// Add this in the public routes section (outside of middleware)
Route::get('/freelancers/{user}', [ProfileController::class, 'publicShow'])->name('freelancers.public.show');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile')->middleware('auth');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');
    
    // Jobs (public browsing)
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{job}/save', [JobController::class, 'save'])->name('jobs.save');
    
    // Client-only routes
    Route::middleware(['client'])->prefix('client')->name('client.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        
        // Jobs Management
        Route::get('/jobs', [ClientController::class, 'jobs'])->name('jobs');
        Route::get('/jobs/create', [ClientController::class, 'createJob'])->name('jobs.create');
        Route::post('/jobs', [ClientController::class, 'storeJob'])->name('jobs.store');
        Route::get('/jobs/{job}/edit', [ClientController::class, 'editJob'])->name('jobs.edit');
        Route::put('/jobs/{job}', [ClientController::class, 'updateJob'])->name('jobs.update');
        Route::delete('/jobs/{job}', [ClientController::class, 'destroyJob'])->name('jobs.destroy');
        Route::get('/jobs/{job}/applicants', [ClientController::class, 'jobApplicants'])->name('jobs.applicants');
        
        // Proposals Management
        Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');
        Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');
        Route::post('/proposals/{proposal}/accept', [ProposalController::class, 'accept'])->name('proposals.accept');
        Route::post('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('proposals.reject');
        
        // Contracts Management
        Route::get('/contracts/create/{job}/{freelancer}', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::post('/contracts/{contract}/complete', [ContractController::class, 'complete'])->name('contracts.complete');
        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts'); // FIXED: removed freelancerIndex
        Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');

        // Route::get('/', [MessageController::class, 'index'])->name('index');
        
        // // Individual chat view
        // Route::get('/{user}', [MessageController::class, 'show'])->name('show');
        
        // // Send message
        // Route::post('/{user}', [MessageController::class, 'store'])->name('store');
        
        // // API routes
        // Route::get('/api/conversations', [MessageController::class, 'getConversationsApi'])->name('api.conversations');
        // Route::get('/api/unread-count', [MessageController::class, 'getUnreadCount'])->name('api.unread-count');
        // Route::post('/{user}/mark-read', [MessageController::class, 'markAllAsRead'])->name('mark-read');
    
        
        
        // Freelancers Directory
        Route::get('/freelancers', [ClientController::class, 'freelancers'])->name('freelancers');
        
        // Financial
        Route::get('/financial', [ClientController::class, 'financial'])->name('financial');
        
        // Settings
        Route::get('/settings', [ClientController::class, 'settings'])->name('settings');
    });
    
    // Freelancer-only routes
    Route::middleware(['freelancer'])->group(function () {
        // Freelancer Dashboard
        Route::get('/freelancer/dashboard', [DashboardController::class, 'freelancerDashboard'])->name('freelancer.dashboard');
        
        // Job Applications
        Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
        
        // Proposals
        Route::get('/freelancer/proposals', [ProposalController::class, 'freelancerIndex'])->name('freelancer.proposals');
         Route::get('/profile/{user?}', [ProfileController::class, 'show'])->name('freelancer.profile-show');
        
        // ========== SAVED JOBS ROUTES ==========
        Route::get('/freelancer/saved-jobs', function() {
            $user = Auth::user();
            
            // Get saved jobs directly from database
            $savedJobs = \App\Models\MarketplaceJob::whereHas('savedByUsers', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->paginate(10);
            
            return view('dashboard.freelancer.saved-jobs', [
                'savedJobs' => $savedJobs,
                'recommendedJobs' => collect([])
            ]);
        })->name('freelancer.saved-jobs');
        
        Route::post('/freelancer/saved-jobs/bulk-action', function() {
            return response()->json([
                'success' => true,
                'message' => 'Action completed successfully'
            ]);
        })->name('freelancer.saved-jobs.bulk');
        
        Route::get('/freelancer/saved-jobs/stats', function() {
            $user = Auth::user();
            $count = \App\Models\MarketplaceJob::whereHas('savedByUsers', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();
            
            return response()->json([
                'total' => $count,
                'applied' => 0,
                'not_applied' => $count
            ]);
        })->name('freelancer.saved-jobs.stats');
        // ========== END SAVED JOBS ROUTES ==========
    });
    
    // Freelancer contracts (with proper prefix)
    Route::middleware(['freelancer'])->prefix('freelancer')->name('freelancer.')->group(function () {
        Route::get('/contracts', [ContractController::class, 'freelancerIndex'])->name('contracts');
        Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
    });
    
   // In web.php - Replace your current messages routes with this:

Route::prefix('messages')->name('messages.')->middleware('auth')->group(function () {
    Route::get('/', [MessageController::class, 'index'])->name('index');
    Route::get('/{user}', [MessageController::class, 'show'])->name('show');
    Route::post('/{user}', [MessageController::class, 'store'])->name('store');
    
    // API routes
    Route::get('/api/conversations', [MessageController::class, 'getConversationsApi'])->name('api.conversations');
    Route::get('/api/unread-count', [MessageController::class, 'getUnreadCount'])->name('api.unread-count');
    Route::post('/{user}/mark-read', [MessageController::class, 'markAllAsRead'])->name('mark-read');
    
    // Add this for message polling/refreshing
    Route::get('/api/with/{user}', [MessageController::class, 'getMessagesApi'])->name('api.messages');
});

    
    // Add this user API route
    Route::get('/api/users/all', function() {
        try {
            $currentUserId = Auth::id();
            $users = App\Models\User::where('id', '!=', $currentUserId)
                ->orderBy('role')
                ->orderBy('name')
                ->get(['id', 'name', 'email', 'role', 'company', 'title', 'avatar', 'created_at']);
                
            return response()->json([
                'success' => true,
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
    
    // Settings Routes (for both roles)
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::get('/load-tab/{tab}', [SettingsController::class, 'loadTab'])->name('load.tab');
        
        // Update routes
        Route::post('/update/account', [SettingsController::class, 'updateAccount'])->name('update.account');
        Route::post('/update/freelancer-profile', [SettingsController::class, 'updateFreelancerProfile'])->name('update.freelancer-profile');
        Route::post('/update/client-company', [SettingsController::class, 'updateClientCompany'])->name('update.client-company');
        Route::post('/update/availability', [SettingsController::class, 'updateAvailability'])->name('update.availability');
        Route::post('/update/notifications', [SettingsController::class, 'updateNotifications'])->name('update.notifications');
        Route::post('/update/password', [SettingsController::class, 'updatePassword'])->name('update.password');
        Route::post('/delete-account', [SettingsController::class, 'deleteAccount'])->name('delete.account');
    });
}); // END OF AUTH MIDDLEWARE GROUP