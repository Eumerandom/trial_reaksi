<?php

use App\Support\StatusLevel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $newValues = StatusLevel::values();
        $default = StatusLevel::DIRECT_SUPPORT;

        // Step 1: Expand ENUM to include both old and new values so existing data is valid
        $expandedEnum = "'affiliated','unaffiliated','".implode("','", $newValues)."'";
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM ($expandedEnum) NULL DEFAULT '$default'");
        DB::statement("ALTER TABLE companies MODIFY COLUMN status ENUM ($expandedEnum) NULL DEFAULT '$default'");

        // Step 2: Migrate old values to new values
        DB::table('products')
            ->whereIn('status', ['affiliated', 'Affiliated'])
            ->update(['status' => StatusLevel::DIRECT_SUPPORT]);

        DB::table('products')
            ->whereIn('status', ['unaffiliated', 'Unaffiliated'])
            ->update(['status' => StatusLevel::LOCAL_INDEPENDENT]);

        DB::table('companies')
            ->whereIn('status', ['affiliated', 'Affiliated'])
            ->update(['status' => StatusLevel::DIRECT_SUPPORT]);

        DB::table('companies')
            ->whereIn('status', ['unaffiliated', 'Unaffiliated'])
            ->update(['status' => StatusLevel::LOCAL_INDEPENDENT]);

        // Step 3: Shrink ENUM to only new values (old values no longer exist in data)
        $finalEnum = "'".implode("','", $newValues)."'";
        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM ($finalEnum) NULL DEFAULT '$default'");
        DB::statement("ALTER TABLE companies MODIFY COLUMN status ENUM ($finalEnum) NULL DEFAULT '$default'");
    }

    public function down(): void
    {
        $enum = "'affiliated','unaffiliated'";

        DB::statement("ALTER TABLE products MODIFY COLUMN status ENUM ($enum) NULL DEFAULT 'unaffiliated'");
        DB::statement("ALTER TABLE companies MODIFY COLUMN status ENUM ($enum) NULL DEFAULT 'unaffiliated'");

        DB::table('products')
            ->whereIn('status', [StatusLevel::DIRECT_SUPPORT, StatusLevel::INDIRECT_SUPPORT])
            ->update(['status' => 'affiliated']);

        DB::table('products')
            ->whereIn('status', [StatusLevel::PUBLIC_COMPANY, StatusLevel::LOCAL_INDEPENDENT])
            ->update(['status' => 'unaffiliated']);

        DB::table('companies')
            ->whereIn('status', [StatusLevel::DIRECT_SUPPORT, StatusLevel::INDIRECT_SUPPORT])
            ->update(['status' => 'affiliated']);

        DB::table('companies')
            ->whereIn('status', [StatusLevel::PUBLIC_COMPANY, StatusLevel::LOCAL_INDEPENDENT])
            ->update(['status' => 'unaffiliated']);
    }
};
