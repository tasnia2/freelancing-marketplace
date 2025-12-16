<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Auth routes
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
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
        
        // Proposals Management
        Route::get('/proposals', [ProposalController::class, 'index'])->name('proposals');
        Route::get('/proposals/{proposal}', [ProposalController::class, 'show'])->name('proposals.show');
        Route::post('/proposals/{proposal}/accept', [ProposalController::class, 'accept'])->name('proposals.accept');
        Route::post('/proposals/{proposal}/reject', [ProposalController::class, 'reject'])->name('proposals.reject');
        
        // Contracts Management
        Route::get('/contracts', [ContractController::class, 'index'])->name('contracts');
        Route::get('/contracts/create/{job}/{freelancer}', [ContractController::class, 'create'])->name('contracts.create');
        Route::post('/contracts', [ContractController::class, 'store'])->name('contracts.store');
        Route::get('/contracts/{contract}', [ContractController::class, 'show'])->name('contracts.show');
        Route::post('/contracts/{contract}/complete', [ContractController::class, 'complete'])->name('contracts.complete');
        
        // Messaging
        Route::get('/messages', [MessageController::class, 'index'])->name('messages');
        Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
        
        // Freelancers Directory
        Route::get('/freelancers', [ClientController::class, 'freelancers'])->name('freelancers');
        
        // Financial
        Route::get('/financial', [ClientController::class, 'financial'])->name('financial');
        
        // Settings
        Route::get('/settings', [ClientController::class, 'settings'])->name('settings');
    });
    
    // Freelancer-only routes (for proposals)
    Route::middleware(['freelancer'])->group(function () {
        // ADDED FREELANCER DASHBOARD:
        Route::get('/freelancer/dashboard', [DashboardController::class, 'freelancerDashboard'])->name('freelancer.dashboard');
        
        Route::post('/jobs/{job}/apply', [JobController::class, 'apply'])->name('jobs.apply');
        Route::get('/proposals', [ProposalController::class, 'freelancerIndex'])->name('freelancer.proposals');
    });
    
    // Messaging routes
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{user}', [MessageController::class, 'show'])->name('show');
        Route::post('/{user}', [MessageController::class, 'store'])->name('store');
        Route::post('/{user}/mark-read', [MessageController::class, 'markAllAsRead'])->name('mark-read');
        Route::get('/api/conversations', [MessageController::class, 'getConversations']);
        Route::get('/api/unread-count', [MessageController::class, 'getUnreadCount']);
    });
});