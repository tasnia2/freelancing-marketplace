<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('marketplace_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->enum('job_type', ['hourly', 'fixed'])->default('fixed');
            $table->decimal('budget', 15, 2);
            $table->enum('experience_level', ['entry', 'intermediate', 'expert'])->default('intermediate');
            $table->enum('status', ['draft', 'open', 'in_progress', 'completed'])->default('open');
            $table->json('skills')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('marketplace_jobs');
    }
};