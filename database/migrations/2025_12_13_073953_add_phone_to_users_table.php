<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
            $table->string('location')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('location');
            $table->string('avatar')->nullable()->after('bio');
            $table->string('title')->nullable()->after('avatar');
            $table->decimal('hourly_rate', 10, 2)->nullable()->after('title');
            $table->string('company')->nullable()->after('hourly_rate');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'location', 'bio', 'avatar', 'title', 'hourly_rate', 'company']);
        });
    }
};