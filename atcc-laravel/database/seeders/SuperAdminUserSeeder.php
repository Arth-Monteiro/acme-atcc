<?php

namespace Database\Seeders;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];

        User::create([
            'name' => 'Acme User',
            'email' => 'super.admin@acme.com',
            'password' => Hash::make('Senha@123'),
            'role_id' => Roles::where('code', 'super_admin')->first(['id'])->id,
        ]);
    }
}
