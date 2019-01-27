<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MerchantCategory extends Model
{
    protected $table = 'merchantcategory';
    protected $fillable = ['merchant_id','category_id'];

    public function storecategory($request,$merchant_id)
    {
        //first check if category exist
        $isfound = MerchantCategory::where('merchant_id',$merchant_id)->where('category_id',$request->category_id)->first();
        if($isfound) return false;
        $records =[
            'merchant_id' 	=> $merchant_id,
            'category_id'   => $request->category_id,
        ];
        $merchant_cat = new MerchantCategory();
        return $merchant_cat->create($records);
    }
}
