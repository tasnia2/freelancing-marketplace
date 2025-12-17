<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the empty table first
        Schema::dropIfExists('reviews');
        
        // Create the proper table
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewee_id')->constrained('users')->onDelete('cascade'); // User being reviewed
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade'); // User writing the review
            $table->foreignId('job_id')->nullable()->constrained('marketplace_jobs')->onDelete('set null');
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('set null');
            $table->integer('rating')->unsigned()->between(1, 5);
            $table->text('comment')->nullable();
            $table->enum('type', ['client_to_freelancer', 'freelancer_to_client'])->default('client_to_freelancer');
            $table->boolean('is_public')->default(true);
            $table->boolean('is_recommended')->default(true);
            $table->json('strengths')->nullable(); // e.g., ["communication", "quality", "timeliness"]
            $table->json('weaknesses')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            // Indexes
            $table->index(['reviewee_id', 'created_at']);
            $table->index(['reviewer_id', 'created_at']);
            $table->index(['job_id', 'type']);
            $table->index(['rating', 'type']);
            
            // A user can only review another user once per job
            $table->unique(['reviewee_id', 'reviewer_id', 'job_id']);
        });
        
        \Log::info('Reviews table recreated successfully');
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};