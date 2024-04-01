<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            
            $table->enum('team_leader_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('hr_manager_approval', ['pending', 'approved', 'rejected'])->default('pending');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn('team_leader_approved');
            $table->dropColumn('hr_manager_approved');
        });
    }
};
