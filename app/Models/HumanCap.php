<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HumanCap extends Model
{
    protected $table = 'humancap';
	protected $fillable = ['user_id', 'company_name', 'gst', 'business_reg_no',
		'country_id', 'business_type', 'office_no', 'mobile_no',
		'address_id','status']; 
		
    /* The humancap that belong to the Documents. */
    public function documents()
    {
        return $this->belongsToMany('App\Models\Document', 'humancapdocument', 'humancap_id', 'document_id');
    }

    /* humancap belongs to merchantdirector table m:n */
    public function directors()
    {
        return $this->belongsToMany('App\Models\Director', 'humancapdirector', 'humancap_id', 'director_id');
    }		
    /* humancap belongs to only one user */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }		
    public function getHumanRelationsFullMeta()
    {
        $user = new User();
        $director = new Director();
		$address = new \App\Models\Address();
		
        $humancapFullMeta = [
            'user' => $user->getMeta(),
			'humancap' => [$this->getMeta()],
			'address' => [$address->getMeta()],
            'directors' => [$director->getMeta()],
        ];

        return $humancapFullMeta;
    }	

    public function getMeta()
    {
        $merchant = [
            "id" => null,
            "user_id" => null,
            "company_name" => null,
            "gst" => null,
            "business_reg_no" => null,
            "country_id" => null,
            "business_type" => null,
            "address_id" => null,
            "office_no" => null,
            "mobile_no" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null
        ];

        return $merchant;
    }	
	
    public function store(Request $request, $user_model, $address_model)
    {
        $user_data = $this->collectMerchantFormData($request, $user_model, $address_model);
		
        $user = new HumanCap();
        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }	
	
	public function collectMerchantFormData(Request $request, $user_model, $address_model)
    {	
        return $user_data = [
            'user_id' => $user_model['id'],
            'company_name' => $request->get('company_name'),
            'gst' => $request->get('gst'),
            'business_reg_no' => $request->get('business_reg_no'),
            'country_id' => $request->get('country'),
            'business_type' => $request->get('business_type'),
            'address_id' => $address_model['id'],
            'office_no' => $request->get('office'),
            'mobile_no' => $request->get('mobile')
        ];
    }	
}
