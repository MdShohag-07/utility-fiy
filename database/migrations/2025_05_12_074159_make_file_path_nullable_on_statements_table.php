<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            // Check if the column exists before trying to modify it
            if (Schema::hasColumn('statements', 'file_path')) {
                // Change the column to be nullable
                $table->string('file_path')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            // Optional: Revert to not nullable if you have a specific reason
            // This assumes it was a string and not nullable before.
            // Be cautious with down migrations that change nullability.
            if (Schema::hasColumn('statements', 'file_path')) {
                // $table->string('file_path')->nullable(false)->change();
            }
        });
    }
};