<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => "Administrator"],
            ['name' => "Manager"],
            ['name' => "Analyst"],
            ['name' => "Support"],
            ['name' => "Other"]
        ]);

        DB::table('permissions')->insert([
            ['name' => "manage units"],
            ['name' => "manage users"],
            ['name' => "manage roles"],
            ['name' => "read devices"]
        ]);

        DB::table('devices_types')->insert([
            ['name' => "Computers"],
            ['name' => "Handhelds"],
            ['name' => "Printers"],
            ['name' => "Other Assets"]
        ]);
        /*
        DB::table('devices_types')->insert([
            ['name' => "PC", 'parent_id' => 1],
            ['name' => "Laptop", 'parent_id' => 1],
            ['name' => "iPhone", 'parent_id' => 2],
            ['name' => "iPad", 'parent_id' => 2],
            ['name' => "Network Printers", 'parent_id' => 3],
            ['name' => "TV", 'parent_id' => 4],
            ['name' => "Oscilloscope", 'parent_id' => 4],
            ['name' => "USB", 'parent_id' => 4]
        ]);
        */
    }
}
