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
        Schema::create('approve_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->notNullable();
            $table->unsignedBigInteger('department_id')->notNullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approve_roles');
    }
};
