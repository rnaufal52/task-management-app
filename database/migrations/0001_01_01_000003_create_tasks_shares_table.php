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
        Schema::create('task_shares', function (Blueprint $table) {
            $table->id(); // Kolom id
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade'); // Foreign key ke tasks
            $table->foreignId('shared_with')->constrained('users')->onDelete('cascade'); // Foreign key ke users
            $table->enum('permission', ['view', 'edit'])->default('view'); // Kolom permission (enum)
            $table->timestamps(); // Timestamps

            // Tambahan index untuk meningkatkan performa query berdasarkan task_id dan shared_with
            $table->unique(['task_id', 'shared_with']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_shares');
    }
};
