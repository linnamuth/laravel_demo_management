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
            $table->string('hr_reject')->nullable()->after('hr_manager_approval');
            $table->string('team_leader_reject')->nullable()->after('team_leader_approval');
            $table->string('cfo_reject')->nullable()->after('cfo_approval');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropColumn('hr_reject');
            $table->dropColumn('team_leader_reject');
            $table->dropColumn('cfo_reject');

        });
    }
};
