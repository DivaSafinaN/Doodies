<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->insert(
            [[
                'priority'=>'None'
            ],
            [
                'priority' => 'Low'
            ],
            [
                'priority' => 'Medium'
            ],
            [
                'priority' => 'High' 
            ]]
            );
    }
}
