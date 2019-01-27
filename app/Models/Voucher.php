<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Voucher extends Model
{
    protected $table = "voucher";

	public static function category()
	{
		$result	= DB::table('category')
			->orderBy('id','DESC')
			->get();
		return $result;
	} 
 public function timeSlots()
    {
        return $this->hasMany('App\Models\TimeSlot');
    }
    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }


	public static function SubCategory($categoryId)
	{
		$result	= DB::table('subcat_level_1')
					->where('category_id','=',$categoryId)
					->get();
		return $result;
	}

	public static function CreateVoucherDetails($VoucherId)
	{
		$result  = DB::table('voucher')
			->join('product', 'voucher.product_id', '=', 'product.id')
			->join('category', 'product.category_id', '=', 'category.id')
			->join('subcat_level_1', 'product.subcat_id', '=', 'subcat_level_1.id')
			->join('brand', 'product.brand_id', '=', 'brand.id')
			->join('address', 'voucher.address_id', '=', 'address.id')
			->select('product.*','address.line1','address.line2',
				'address.line3', 'brand.name as brandname',
				'subcat_level_1.name as subname', 'category.name as catName')
			->where('voucher.id','=',$VoucherId)
			->get();
		return $result;
	}

	public static function Brand()
	{
		$resul= DB::table('brand')
			->orderBy('id','DESC')
			->get();
		return $resul;
	}

	public static function store($data = null)
	{			
		try {
			//DB::beginTransaction();
			$dateTime=date('Y-m-d H:i:s');
			$getpdtId=DB::table('product')
				->insertGetId([
					'name' 			=> $data['productName'],
					'brand_id' 		=> $data['Brand'],
					'category_id'  	=> $data['categoryId'],
					'subcat_id'  	=> $data['subCategoryId'],
					'retail_price'  => $data['rPrice'],
					'created_at'  	=> $dateTime,
				]);
			
			$address=DB::table('address')
				->insertGetId([
					'line1'  		=> $data['address_lan_1'],
					'line2' 		=> $data['address_lan_2'],
					'line3' 		=> $data['address_lan_3'],
					'created_at'  	=> $dateTime,
				]);	

			$voucher=DB::table('voucher')
				->insertGetId([
					'product_id'  	=> $getpdtId,
					'validity' 		=> $data['validity'],
					'address_id' 	=>$address,
					'status' 	    =>'active',
					'created_at'  	=> $dateTime,
				]);

			for ($k=0; $k <sizeof($data['bookingDate']); $k++) {
				$chamberId[]=DB::table('timeslot')
					->insertGetId([
						'voucher_id'  	=>$voucher,
						'booking' 		=>$data['bookingDate'][$k],
						'from' 			=>$data['fromTime'][$k],
						'to' 			=>$data['toTime'][$k],
						'qty_left' 		=>$data['qtyLeft'][$k],
						'qty_ordered' 	=>$data['qtyOrdered'][$k],
						'price' 		=>$data['price'][$k],
						'pax_per_table' =>$data['pax_per_table'][$k],
						'created_at'  	=>$dateTime,
				]);
			}


			//return false;
			//DB::commit();

		}
		catch(\Exception $e) {
			return "dbError";
		}
	}

	
	 public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    /**
     * @param $profile_products
     * @return mixed
     */
    public static function getVouchers($profile_products)
    {
        $vouchers = $profile_products->filter(function ($product) {
            return $product->type == "voucher";
        });
        return $vouchers;
    }
}
