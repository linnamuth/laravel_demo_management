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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key referencing the Users table
            $table->string('type'); // 'leave' or 'mission'
            $table->date('start_date');
            $table->date('end_date');
            $table->text('reason');
            $table->string('duration');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('days', ['morning', 'afternoon', 'day'])->default('day');
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
