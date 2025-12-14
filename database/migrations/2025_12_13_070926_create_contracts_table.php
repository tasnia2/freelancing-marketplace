<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('marketplace_jobs')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled', 'terminated'])->default('draft');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->json('milestones')->nullable();
            $table->json('attachments')->nullable();
            $table->json('terms')->nullable();
            $table->text('termination_reason')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['client_id', 'status']);
            $table->index(['freelancer_id', 'status']);
            $table->index('job_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};