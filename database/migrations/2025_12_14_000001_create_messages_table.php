<?php
// database/migrations/2025_12_18_fix_messages_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixMessagesTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('messages');
        
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_id')->nullable()->constrained('marketplace_jobs')->onDelete('cascade');
            $table->foreignId('contract_id')->nullable()->constrained('contracts')->onDelete('cascade');
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['sender_id', 'receiver_id']);
            $table->index(['job_id']);
            $table->index(['contract_id']);
            $table->index(['read']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
}