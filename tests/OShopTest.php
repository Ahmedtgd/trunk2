<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OShopTest extends TestCase {
	/* Make sure the primary route is visible */
	public function testRoute() {
		$this->visit('/oshoplist')
			->see('O-Shops')
			->dontSee('Foobar');
	}

	public function testTableInitialization() {
		// Initialize tables first
		DB::table('merchant')->truncate();
		$ary = DB::table('merchant')->select('id')->get();
		$this->assertEquals(0, sizeof($ary));

		DB::table('product')->truncate();
		$ary = DB::table('product')->select('id')->get();
		$this->assertEquals(0, sizeof($ary));

		DB::table('merchantproduct')->truncate();
		$ary = DB::table('merchantproduct')->select('id')->get();
		$this->assertEquals(0, sizeof($ary));

		DB::table('merchantcategory')->truncate();
		$ary = DB::table('merchantcategory')->select('id')->get();
		$this->assertEquals(0, sizeof($ary));
	}

    public function testSeeding() {
		// Instantiate a faker factory
		$faker = Faker\Factory::create();

		// Create 100 products, with category_id=1,
		// subcat_id is between 1 and 22
		factory('App\Models\Product', 100)->
			create(['category_id'=>1,
					'subcat_id'=>$faker->numberBetween(1 ,22)]);
		$ary = DB::table('product')->select('id')->
			where('category_id', 1)->get();
		$this->assertEquals(100, sizeof($ary));

		// Create 100 products, with category_id=2,
		// subcat_id is between 23 and 34 
		factory('App\Models\Product', 100)->
			create(['category_id'=>2,
					'subcat_id'=>$faker->numberBetween(23,34)]);
		$ary = DB::table('product')->select('id')->
			where('category_id', 2)->get();
		$this->assertEquals(100, sizeof($ary));
	
		
		// Create 100 merchants of various category_id between 1 and 10
		factory('App\Models\Merchant', 100)->create();
		$ary = DB::table('merchant')->select('id')->get();
		$this->assertEquals(100, sizeof($ary));
	}
		
    public function testProductAttachment() {
		// Attach some products with category_id=1 to merchant_id=26
		$p1 = \App\Models\Product::select()->where('category_id',1)->get();
		$c1 = 0;
		if ($p1[0]) $c1 += 1; $p1[0]->merchants()->attach(26); 
		if ($p1[1]) $c1 += 1; $p1[1]->merchants()->attach(26); 
		if ($p1[2]) $c1 += 1; $p1[2]->merchants()->attach(26); 
		if ($p1[3]) $c1 += 1; $p1[3]->merchants()->attach(26); 
		if ($p1[4]) $c1 += 1; $p1[4]->merchants()->attach(26); 
		if ($p1[5]) $c1 += 1; $p1[5]->merchants()->attach(26); 


		// Make sure we have the correct products attached to this merchant
		$ary = DB::table('merchantproduct')->select()->
			where('merchant_id', 26)->get();
		$this->assertEquals($c1, sizeof($ary));

		// Attach some products with category_id=2 to merchant_id=26
		$p2 = \App\Models\Product::select()->where('category_id',2)->get();
		$c2 = 0;
		if ($p2[0]) $c2 += 1; $p2[0]->merchants()->attach(26); 
		if ($p2[1]) $c2 += 1; $p2[1]->merchants()->attach(26); 
		if ($p2[2]) $c2 += 1; $p2[2]->merchants()->attach(26); 
		if ($p2[3]) $c2 += 1; $p2[3]->merchants()->attach(26); 
		if ($p2[4]) $c2 += 1; $p2[4]->merchants()->attach(26); 
		if ($p2[5]) $c2 += 1; $p2[5]->merchants()->attach(26); 

		// Make sure we attach to the right merchant (i.e. merchant_id=26)
		$ary = DB::table('merchantproduct')->select('merchant_id')->
			where('merchant_id', 26)->get();
		$this->assertEquals($c2, sizeof($ary)-$c1);
    }


    public function testMultiCategorySupport() {
		// We attach category_id=1 to merchant_id=26 and
		//           category_id=2 to merchant_id=26
		\App\Models\Category::find(1)->merchants()->attach(26);
		\App\Models\Category::find(2)->merchants()->attach(26);

		// Make sure category_id=1 is attach to merchant_id=26
		$ary = DB::table('merchantcategory')->
			select('merchant_id', 'category_id')->
			where('merchant_id', 26)->
			where('category_id', 1)->get();

		// Make sure merchant_id=26
		$this->assertEquals(26, $ary[0]->merchant_id);

		// Make sure category_id=1
		$this->assertEquals(1, $ary[0]->category_id);

		// Make sure category_id=2 is attach to merchant_id=26
		$ary = DB::table('merchantcategory')->
			select('merchant_id', 'category_id')->
			where('merchant_id', 26)->
			where('category_id', 2)->get();

		// Make sure merchant_id=26
		$this->assertEquals(26, $ary[0]->merchant_id);

		// Make sure category_id=1
		$this->assertEquals(2, $ary[0]->category_id);

	}
}
