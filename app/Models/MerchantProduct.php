<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MerchantProduct extends Model
{
        protected $table = 'merchantproduct';

		protected $fillable = ['merchant_id','product_id'];
        
	public function merchants() {
		return $this->hasMany('App\Models\Merchants', 'merchant_id');
	}
	
	/*public function products() {
		return $this->hasMany('App\Models\Product', 'product_id');
	}*/

	public function procount($merchant_id,$category_id,$sub_categoryid)
	{
		$pro_count = DB::table('merchantproduct')
			->join('product', 'merchantproduct.product_id', '=', 'product.id')
			->where('merchantproduct.merchant_id',$merchant_id)
			->where('product.category_id',$category_id)
			->where('product.subcat_id',$sub_categoryid)
			->where('product.subcat_level',1)
			->count();
		return $pro_count;
	}

	public function storeproduct($product_data,$merchant_id)
	{
		$records =[
			'merchant_id' 	=> $merchant_id,
			'product_id'	=> $product_data->id,
		];
		$merchant_pro = new MerchantProduct();
		DB::table('omerchantproduct')->insert(['merchant_id'=>$merchant_id, 'product_id' => $product_data->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
		return $merchant_pro->create($records);
	}
		public static function products($merchant_id) {
					$products = DB::table('merchantproduct')
			->join('product', 'merchantproduct.product_id', '=', 'product.id')
			->where('merchantproduct.merchant_id',$merchant_id)
			->get();
			return $products;
			}

    public function tproduct()
    {
        return MerchantProduct::joiningTable('product_id')->get();
    }


}
