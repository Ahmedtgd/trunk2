<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Brand extends Model
{
    //
    protected $table = 'brand';
    protected $guarded = [ 'id'];
    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function categories()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /*brand belongs to merchantbrand table with m:n */
    public function merchant()
    {
        return $this->belongsToMany('App\Models\Merchant','merchantbrand','brand_id','merchant_id');
    }

    /*brand belongs to merchantbrand table with m:n */
    public function station()
    {
        return $this->belongsToMany('App\Models\Station','stationbrand','brand_id','station_id');
    }

    /*relations ends*/

    public function getMeta()
    {
        return
            $brand = [
                "id" => null,
                "name" => null,
                "description" =>null,
                "logo" => null,
                "deleted_at" => null,
                "created_at" => null,
                "updated_at" => null,
                "pivot_merchant_id" =>null,
                "pivot_brand_id" => null
            ];
    }

    public function store(Request $request, $merchant_model, $address_model )
    {
        //may be we get more that brands so loop through brand_name[] in request
        //create record for each brand
        //then save one by one and save in model array brand_models_array

        $brand_name_array = $request->get('brand_name');
        $brandRecords[] = ['name'=>null,'description'=>null,'logo'=>null,'deleted_at'=>null];//all website records
        $brand_models[] = null;

        foreach($brand_name_array as $brand_name)
        {
            $brandRecords[] = $this->collectBrandFormData($request,$brand_name);
        }

        unset($brandRecords[0]);

        $brand = new Brand();
        foreach($brandRecords as $brandRecord)
        {
            $brand_models[] = $brand->create($brandRecord);
        }

        unset($brand_models[0]);

        return $brand_models;
    }

    public function collectBrandFormData(Request $request, $brand_name)
    {
        return $data = [
            'name' => $brand_name,
            'description' => '',
            'logo' => '',
            'deleted_at' => null,//default is zero according to waisun
        ];
    }




}
