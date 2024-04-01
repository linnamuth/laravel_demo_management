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
        Schema::table('mission_leaves', function (Blueprint $table) {
              
            $table->enum('leader_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('ceo_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('hr_manager_approval', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('cfo_approval', ['pending', 'approved', 'rejected'])->default('pending');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mission_leaves', function (Blueprint $table) {
            $table->dropColumn('leader_approval');
            $table->dropColumn('ceo_approval');
            $table->dropColumn('hr_manager_approval');
            $table->dropColumn('cfo_approval');

        });
    }
};
