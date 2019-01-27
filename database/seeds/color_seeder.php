<?php

use Illuminate\Database\Seeder;

class color_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 		\DB::table('color')->truncate();

		/* Private database of standard 16 colors */
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('color')->insert(array(
			0 => array (
				'name' => 'aqua',
				'description' => 'Aqua',
				'rgb' => 'rgb(0,255,255)',
				'hex' => '#00ffff',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			1 => array (
				'name' => 'black',
				'description' => 'Black',
				'rgb' => 'rgb(0,0,0)',
				'hex' => '#000000',
				'created_at' => $now,
				'updated_at' => $now,
			), 
 			2 => array (
				'name' => 'blue',
				'description' => 'Blue',
				'rgb' => 'rgb(0,0,255)',
				'hex' => '#0000ff',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			3 => array (
				'name' => 'fuschia',
				'description' => 'Fuschia',
				'rgb' => 'rgb(255,0,255)',
				'hex' => '#ff00ff',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			4 => array (
				'name' => 'gray',
				'description' => 'Gray',
				'rgb' => 'rgb(128,128,128)',
				'hex' => '#808080',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			5 => array (
				'name' => 'green',
				'description' => 'Green',
				'rgb' => 'rgb(0,128,0)',
				'hex' => '#008000',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			6 => array (
				'name' => 'lime',
				'description' => 'Lime',
				'rgb' => 'rgb(0,255,0)',
				'hex' => '#00ff00',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			7 => array (
				'name' => 'maroon',
				'description' => 'Maroon',
				'rgb' => 'rgb(128,0,0)',
				'hex' => '#800000',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			8 => array (
				'name' => 'navy',
				'description' => 'Navy',
				'rgb' => 'rgb(0,0,128)',
				'hex' => '#000080',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			9 => array (
				'name' => 'olive',
				'description' => 'Olive',
				'rgb' => 'rgb(128,128,0)',
				'hex' => '#808000',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			10 => array (
				'name' => 'purple',
				'description' => 'Purple',
				'rgb' => 'rgb(128,0,128)',
				'hex' => '#800080',
				'created_at' => $now,
				'updated_at' => $now,
			), 
   			11 => array (
				'name' => 'red',
				'description' => 'Red',
				'rgb' => 'rgb(255,0,0)',
				'hex' => '#ff0000',
				'created_at' => $now,
				'updated_at' => $now,
			), 
   			12 => array (
				'name' => 'silver',
				'description' => 'Silver',
				'rgb' => 'rgb(192,192,192)',
				'hex' => '#c0c0c0',
				'created_at' => $now,
				'updated_at' => $now,
			), 
   			13 => array (
				'name' => 'teal',
				'description' => 'Teal',
				'rgb' => 'rgb(0,128,128)',
				'hex' => '#008080',
				'created_at' => $now,
				'updated_at' => $now,
			), 
   			14 => array (
				'name' => 'white',
				'description' => 'White',
				'rgb' => 'rgb(255,255,255)',
				'hex' => '#ffffff',
				'created_at' => $now,
				'updated_at' => $now,
			), 
   			15 => array (
				'name' => 'yellow',
				'description' => 'Yellow',
				'rgb' => 'rgb(255,255,0)',
				'hex' => '#ffff00',
				'created_at' => $now,
				'updated_at' => $now,
			), 
    	));
    }
}
