<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            '*'
        ];

        Roles::create([
            'name' => 'Super Admin',
            'code' => 'super_admin',
            'permissions' => $permissions,
        ]);
    }
}
