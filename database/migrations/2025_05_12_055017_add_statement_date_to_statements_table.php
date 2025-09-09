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
            // Add the statement_date column.
            // Use ->date() if you only store the date, or ->timestamp() if you include time.
            // ->nullable() is optional, but good if some old statements might not have it initially.
            // ->after('user_id') or similar to place it logically in your table structure.
            $table->date('statement_date')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('statements', function (Blueprint $table) {
            $table->dropColumn('statement_date');
        });
    }
};