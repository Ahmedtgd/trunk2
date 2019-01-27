<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		//\DB::table('product')->truncate();

		$now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('product')->insert(array (
 			0 => array (
				'name'			=> 'Pacfica 76cm Electric Oven XT',
				'brand_id'		=> 1,
				'category_id'	=> 5,
				'subcat_id'		=> 1,
				'subcat_level'	=> 1,
				'photo_1'		=> '500x500_F60-CON-XT.jpg',
				'retail_price'	=> 68000,
				'original_price'=> 68000,
				'owarehouse_moq'=> 5,
				'owarehouse_price' => 50000,
				'created_at'	=> $now,
				'updated_at'	=> $now,
			),
  			1 => array (
				'name'           => 'Pacfica 46cm Combi Steam Oven',
				'brand_id'       => 1,
				'category_id'    => 5,
				'subcat_id'      => 1,
				'subcat_level'   => 1,
				'photo_1'        => '500x500_AD90-5-MFE-NET.jpg',
				'retail_price'   => 58000,
				'original_price' => 70000,
				'owarehouse_moq'=> 5,
				'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			2 => array (
				'name'           => 'Pacfica 60cm Electric Oven XT',
				'brand_id'       => 1,
				'category_id'    => 5,
				'subcat_id'      => 1,
				'subcat_level'   => 1,
				'photo_1'        => '500x500_F30-CON-XT.jpg',
				'retail_price'   => 60000,
				'original_price' => 65000,
				'owarehouse_moq'=> 5,
				'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			3 => array (
				'name'           => 'Pacfica A90 SMFE CRT',
				'brand_id'       => 1,
				'category_id'    => 1,
				'subcat_id'      => 15,
				'subcat_level'   => 1,
				'photo_1'        => '500x500_F45-CON-VAP-X.jpg',
				'retail_price'   => 69000,
				'original_price' => 73000,
				'owarehouse_moq'=> 5,
					'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			4 => array (
				'name'           => 'Pacfica A90 SMFE NET',
				'brand_id'       => 1,
				'category_id'    => 1,
				'subcat_id'      => 15,
				'subcat_level'   => 1,
				'photo_1'        => '500x500_A90-5-MFE-CRT.jpg',
				'retail_price'   => 58000,
				'original_price' => 68000,
				'owarehouse_moq'=> 5,
					'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			5 => array (
				'name'           => 'Pacfica A90 MFE NET',
				'brand_id'       => 1,
				'category_id'    => 1,
				'subcat_id'      => 15,
				'subcat_level'   => 1,
				'photo_1'        => '71meYcwWBPL._SL1500_.jpg',
				'retail_price'   => 90000,
				'original_price' => 112000,
				'owarehouse_moq'=> 5,
				'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			6 => array (
				'name'           => 'Pacfica AD90 MFE CRT',
				'brand_id'       => 1,
				'category_id'    => 1,
				'subcat_id'      => 15,
				'subcat_level'   => 1,
				'photo_1'        => '71miiHV6HmL._SL1500_.jpg',
				'retail_price'   => 110000,
				'original_price' => 126000,
				'owarehouse_moq'=> 5,
					'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			7 => array (
				'name'           => 'Hamilton Bench Countertop Oven with Convection',
				'brand_id'       => 1,
				'category_id'    => 1,
				'subcat_id'      => 15,
				'subcat_level'   => 1,
				'photo_1'        => '71z9h90IsbL._SL1500_.jpg',
				'retail_price'   => 150000,
				'original_price' => 210000,
				'owarehouse_moq'=> 5,
				'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
  			8 => array (
				'name'           => 'Eyes Lip Face Glamorous Lipstick',
				'brand_id'       => 2,
				'category_id'    => 2,
				'subcat_id'      => 30,
				'subcat_level'   => 1,
				'photo_1'        => 'eyes_lip_face.jpg',
				'retail_price'   => 11500,
				'original_price' => 48000,
				'owarehouse_moq'=> 5,
				'owarehouse_price' => 50000,
				'created_at'     => $now,
				'updated_at'     => $now,
			),
		));
		
		\DB::update("Update product SET parent_id = id WHERE segment = 'b2c'");

	}

}
