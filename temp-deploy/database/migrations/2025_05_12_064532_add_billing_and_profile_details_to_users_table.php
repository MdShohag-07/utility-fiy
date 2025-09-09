<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Rename this class if your filename is different
return new class extends Migration // Or your specific class name like AddBillingAndProfileDetailsToUsersTable
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable()->after('id'); // Or after 'name'
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }

            // Add secondary name fields
            if (!Schema::hasColumn('users', 'secondary_first_name')) {
                $table->string('secondary_first_name')->nullable()->after('last_name');
            }
            if (!Schema::hasColumn('users', 'secondary_last_name')) {
                $table->string('secondary_last_name')->nullable()->after('secondary_first_name');
            }

            // If you are replacing a generic 'name' column:
            // if (Schema::hasColumn('users', 'name') && Schema::hasColumn('users', 'first_name')) {
            //     // Consider migrating data before dropping if 'name' had valuable info
            //     $table->dropColumn('name');
            // }

            if (!Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('email_verified_at'); // Adjust 'after' as needed
            }
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'state')) {
                $table->string('state')->nullable()->after('city');
            }
            if (!Schema::hasColumn('users', 'zip_code')) {
                $table->string('zip_code')->nullable()->after('state');
            }
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->after('zip_code');
            }
            if (!Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number')->nullable()->unique()->after('phone_number');
            }
            if (!Schema::hasColumn('users', 'service_type')) {
                $table->string('service_type')->nullable()->after('account_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToDrop = [
                'first_name', 'last_name', 'secondary_first_name', 'secondary_last_name',
                'address', 'city', 'state', 'zip_code', 'phone_number',
                'account_number', 'service_type'
            ];
            // Conditionally drop 'name' if you re-added it in the 'up' logic for replacement
            // if (Schema::hasColumn('users', 'name') && !Schema::hasColumn('users', 'first_name')) {
            // // $table->dropColumn('name'); // Be careful here, this is illustrative
            // }

            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};