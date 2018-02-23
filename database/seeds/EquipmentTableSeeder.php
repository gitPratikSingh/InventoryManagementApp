<?php

use Illuminate\Database\Seeder;

class EquipmentTableSeeder extends Seeder
{
   
    public function run()
    {
    	DB::table('equipment')->truncate();
    	$faker = Faker\Factory::create();
    	foreach(range(1,20000) as $index)  {
    		DB::table('equipment')->insert([
    		    'equipment_name' => ucwords($faker->word),
    		    'type_id' => rand(1,5),
    		    'serial_number' => strtoupper(str_random(5)).rand(1000,99999),
    		    'barcode' => rand(1000000000,9999999999),
    		    'cams' =>  rand(1111,9999),
    		    'make_id' => rand(1,5),
    		    'model_id' => rand(1,15),
    		    'department_id' => rand(1,5),
    		    'building_id' => rand(1,5),
    		    'warranty' => rand(1,9)
    		    //'', => ,
    		]);
    	}
    }
}
