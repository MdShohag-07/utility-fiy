<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// The class name will match your generated filename
return new class extends Migration // Or class RemoveFilePathAndOriginalNameFromStatementsTable extends Migration
{
    /**
     * Run the migrations.
     * This method will remove the specified columns.
     */
    public function up(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            if (Schema::hasColumn('statements', 'file_path')) {
                $table->dropColumn('file_path');
            }
            if (Schema::hasColumn('statements', 'original_name')) {
                $table->dropColumn('original_name');
            }
            // Optional: If you also had statement_month and statement_year and want to remove them
            // if (Schema::hasColumn('statements', 'statement_month')) {
            //     $table->dropColumn('statement_month');
            // }
            // if (Schema::hasColumn('statements', 'statement_year')) {
            //     $table->dropColumn('statement_year');
            // }
        });
    }

    /**
     * Reverse the migrations.
     * This method will attempt to re-add the columns if you roll back.
     */
    public function down(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            // Re-add the columns. It's good practice to make them nullable
            // as their original non-nullable status and default values might be unknown.
            // Adjust 'after' based on where they were originally or your preference.
            if (!Schema::hasColumn('statements', 'file_path')) {
                // Assuming 'user_id' is a common column they might have been after
                $table->string('file_path')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('statements', 'original_name')) {
                $table->string('original_name')->nullable()->after('file_path');
            }

            // Optional: Re-add statement_month and statement_year if you dropped them in up()
            // if (!Schema::hasColumn('statements', 'statement_month')) {
            //     $table->string('statement_month')->nullable()->after('original_name'); // Or integer, adjust type
            // }
            // if (!Schema::hasColumn('statements', 'statement_year')) {
            //     $table->year('statement_year')->nullable()->after('statement_month'); // Or integer
            // }
        });
    }
};