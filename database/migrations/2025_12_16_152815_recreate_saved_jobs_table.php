<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, drop the existing table if it exists
        Schema::dropIfExists('saved_jobs');
        
        // Create the proper table
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('marketplace_job_id')->constrained('marketplace_jobs')->onDelete('cascade');
            $table->timestamps();
            
            // Prevent duplicate saves - user can't save same job twice
            $table->unique(['user_id', 'marketplace_job_id']);
            
            // Index for faster queries
            $table->index(['user_id', 'created_at']);
            $table->index(['marketplace_job_id']);
        });
        
        \Log::info('Saved jobs table recreated successfully');
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};