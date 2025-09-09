<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('statements')) { // Good practice to check
            Schema::create('statements', function (Blueprint $table) {
                $table->id(); // Standard primary key
                $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
                // Add any other columns that were part of the VERY FIRST version of this table.
                // If it was initially an empty table just for user_id, that's fine.
                // If it was for the old upload system and had file_path from the start, include it:
                // $table->string('file_path')->nullable();
                // $table->string('original_name')->nullable();
                $table->timestamps(); // created_at, updated_at
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('statements');
    }
};