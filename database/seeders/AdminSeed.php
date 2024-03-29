<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
        [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('somesecretpassword'),
            'is_admin' => 1,
            'last_seen' => NULL,
            'phone_number' => random_int(10,12)
        ]
        );
    }
}
