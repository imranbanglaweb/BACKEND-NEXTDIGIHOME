<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CompanySeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('companies')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();
        $adminId = 1; // Super Admin

        DB::table('companies')->insert([
            'id'            => 1,
            'company_name'  => 'Demo Transport Company',
            'company_code'  => 'TMS-001',
            'email'         => 'info@demo-tms.com',
            'phone'         => '+8801000000000',
            'address'       => 'Dhaka, Bangladesh',
            'logo'          => 'company/logo.png',
            'status'        => 1,
            'created_by'    => $adminId,
            'updated_by'    => $adminId,
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);
    }
}
