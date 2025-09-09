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
        Schema::table('statements', function (Blueprint $table) {
            // --- ADD NECESSARY COLUMNS FOR DYNAMIC STATEMENTS ---

            if (!Schema::hasColumn('statements', 'statement_date')) {
                // Assuming user_id already exists from the initial statements table creation
                $table->date('statement_date')->nullable()->after('user_id');
            } else {
                // If it exists, ensure it's nullable or change its type if needed
                 $table->date('statement_date')->nullable()->change();
            }

            if (!Schema::hasColumn('statements', 'due_date')) {
                $table->date('due_date')->nullable()->after('statement_date');
            } else {
                 $table->date('due_date')->nullable()->change();
            }

            if (!Schema::hasColumn('statements', 'total_amount')) {
                $table->decimal('total_amount', 10, 2)->default(0.00)->after('due_date');
            } else {
                // Ensure it's the correct decimal type and has a default
                 $table->decimal('total_amount', 10, 2)->default(0.00)->change();
            }

            if (!Schema::hasColumn('statements', 'status')) {
                $table->string('status')->default('issued')->nullable()->after('total_amount'); // e.g., draft, issued, paid
            } else {
                $table->string('status')->default('issued')->nullable()->change();
            }

            // Optional: Add a statement_number if you want a unique human-readable ID
            if (!Schema::hasColumn('statements', 'statement_number')) {
                $table->string('statement_number')->nullable()->unique()->after('user_id'); // Or after 'id'
            }


            // --- REMOVE OBSOLETE COLUMNS FROM OLD PDF UPLOAD SYSTEM ---

            if (Schema::hasColumn('statements', 'file_path')) {
                $table->dropColumn('file_path');
            }

            if (Schema::hasColumn('statements', 'original_name')) {
                $table->dropColumn('original_name');
            }

            // Optional: Remove old month/year columns if they existed and are replaced by statement_date
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
     * This attempts to revert the changes made in the up() method.
     */
    public function down(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            // Re-add old columns if they were dropped (make them nullable as their original state might be unknown)
            if (!Schema::hasColumn('statements', 'file_path')) {
                $table->string('file_path')->nullable();
            }
            if (!Schema::hasColumn('statements', 'original_name')) {
                $table->string('original_name')->nullable();
            }

            // Optional: Re-add old month/year columns
            // if (!Schema::hasColumn('statements', 'statement_month')) {
            //     $table->string('statement_month')->nullable(); // Or integer, depending on original type
            // }
            // if (!Schema::hasColumn('statements', 'statement_year')) {
            //     $table->year('statement_year')->nullable(); // Or integer
            // }

            // Drop columns that were added or primarily defined by this migration's up() method
            $columnsToDrop = ['statement_number', 'status', 'total_amount', 'due_date', 'statement_date'];
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('statements', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};