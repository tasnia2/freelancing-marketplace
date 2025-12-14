<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // database/migrations/xxxx_create_marketplace_jobs_table.php
public function up(): void
{
    Schema::create('marketplace_jobs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('description');
        $table->enum('job_type', ['hourly', 'fixed'])->default('fixed');
        $table->decimal('budget', 15, 2)->nullable();
        $table->decimal('hourly_rate', 10, 2)->nullable();
        $table->integer('hours_per_week')->nullable();
        $table->enum('experience_level', ['entry', 'intermediate', 'expert'])->default('intermediate');
        $table->enum('project_length', ['less_than_1_month', '1_to_3_months', '3_to_6_months', 'more_than_6_months'])->default('1_to_3_months');
        $table->json('skills_required')->nullable();
        $table->json('attachments')->nullable();
        $table->enum('status', ['draft', 'open', 'in_progress', 'completed', 'cancelled'])->default('open');
        $table->integer('views')->default(0);
        $table->integer('proposals_count')->default(0);
        $table->integer('hires_count')->default(0);
        $table->timestamp('deadline')->nullable();
        $table->timestamp('featured_until')->nullable();
        $table->boolean('is_urgent')->default(false);
        $table->boolean('is_featured')->default(false);
        $table->boolean('is_remote')->default(true);
        $table->softDeletes();
        $table->timestamps();
        
        $table->index(['status', 'created_at']);
        $table->index(['client_id', 'status']);
        $table->fullText(['title', 'description']);
    });
}

    public function down(): void {
        Schema::dropIfExists('marketplace_jobs');
    }
};