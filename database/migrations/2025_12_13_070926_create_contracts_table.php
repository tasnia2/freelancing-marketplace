<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::create('contracts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('job_id')->constrained('marketplace_jobs')->onDelete('cascade');
        $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('freelancer_id')->constrained('users')->onDelete('cascade');
        $table->string('title');
        $table->text('description');
        $table->decimal('amount', 15, 2);
        $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
        $table->date('start_date');
        $table->date('end_date');
        $table->json('terms')->nullable();
        $table->json('attachments')->nullable();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};