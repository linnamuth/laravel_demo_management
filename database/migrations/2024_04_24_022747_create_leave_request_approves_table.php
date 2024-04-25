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
        Schema::create('leave_request_approves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leave_request_id');
            $table->unsignedBigInteger('approved_by');
            $table->unsignedBigInteger('role_id');
            $table->enum('status', ['pending', 'approved', 'rejected']);
            $table->timestamp('approved_at')->nullable();

            $table->foreign('leave_request_id')->references('id')->on('leave_requests')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_request_approves');
    }
};
