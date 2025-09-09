<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            // Add after an existing column, e.g., 'status' or 'total_amount'
            // It should be nullable because a statement is unpaid until it's paid.
            if (!Schema::hasColumn('statements', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            if (Schema::hasColumn('statements', 'paid_at')) {
                $table->dropColumn('paid_at');
            }
        });
    }
};