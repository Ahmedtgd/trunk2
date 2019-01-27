<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Station extends Model
{
    protected $table = 'station';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
	protected $fillable = ["user_id", 'company_name', 'gst', 'business_reg_no',
		'country_id', 'business_type', 'contact_person', 'office_no',
		'mobile_no', 'station_name', 'bankaccount_id', 'address_id',
		'station_description','station_address_id','delivery_mode',
		'description', 'license', 'coverage', 'ownership','category_id',
		'planned_sales','bankaccount_id','return_policy',
		'status','note'];
    //  protected $guarded = [ 'id'];

    /*relations*/

    /* The station that belong to the website. */
    public function websites()
    {
        return $this->belongsToMany('App\Models\Website', 'stationwebsite', 'station_id', 'website_id');
    }

    /* Station belongs to director table m:n */
    public function directors()
    {
        return $this->belongsToMany('App\Models\Director', 'stationdirector', 'station_id', 'director_id');
    }
    /* Station belongs to stationdirector table m:n */
    public function directorsInEditView()
    {

        return $this->belongsToMany('App\Models\Director','stationdirector','station_id','director_id');
    }


    public function brand()
    {
        return $this->belongsToMany('App\Models\Brand', 'stationbrand', 'station_id', 'brand_id');
    }

    public function station_category()
    {
        return $this->hasMany('App\Models\StationCategory');
    }
    /* station belongs to only one user */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /* station belongs to only one address 1:1 */
    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id', 'id');
    }

    /* station belongs to only one country 1:1 */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /* station belongs to only one state 1:1 */
    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }

    /*station belongs to only one bank 1:1*/
    public function bank()
    {
        return $this->belongsTo('App\Models\Bank', 'bank_id', 'id');
    }

    /*station belongs to only one property 1:1*/
    public function property()
    {
        return $this->belongsTo('App\Models\Sproperty', 'station_id', 'id');
    }

    public function bankaccount()
    {
        return $this->belongsTo('App\Models\BankAccount', 'bankaccount_id', 'id');
    }

    /*relations ends*/

    public function getStationRelationsFullMeta()
    {
        $user = new User();
        $website = new Website();
        $director = new Director();
        $address = new \App\Models\Address();
        $stn_address = new \App\Models\Address();
        $bank = new Bank();
        $brand = new Brand();
        $property = new Sproperty();
        $stationFullMeta = [
            'user' => $user->getMeta(),
            'station' => [$this->getMeta()],
            'bank' => [$bank->getMeta()],
            'contactemail' => [],
            'address' => [$address->getMeta()],
            'stn_address' => [$address->getMeta()],
            'brand' => [$brand->getMeta()],
            'websites' => [$website->getMeta()],
            'directors' => [$director->getMeta()],
            'property' => [$property->getMeta()],
        ];
        return $stationFullMeta;
    }

    public function getMeta()
    {
        $station = [
            "id" => null,
            "user_id" => null,
            "company_name" => null,
            "gst" => null,
            "business_reg_no" => null,
            "country_id" => null,
            "business_type" => null,
            "address_id" => null,
            "contact_person" => null,
            "office_no" => null,
            "mobile_no" => null,
            "station_name" => null,
            "station_description" => null,
            "description" => null,
            "history" => null,
            "license" => null,
            "coverage" => null,
            "ownership" => null,
            "category_id" => null,
            "planned_sales" => null,
            "bankaccount_id" => null,
            "delivery_mode" => null,
            "note" => null,
            "return_policy" => null,
            "status" => null,
            "note" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null
        ];

        return $station;
    }

	 public function store_empty(Request $request, $user_model)
    {

        $user_data = $this->collectStationFormDataEmpty(
            $request, $user_model);

        $user = new Station();

        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }
	
    public function store(Request $request, $user_model, $bank_model, $address_model)
    {

        $user_data = $this->collectStationFormData(
            $request, $user_model, $bank_model, $address_model);

        $user = new Station();

        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }
	
    public function store_frommerchant($merchant, $user_id)
    {

        $user_data = $this->collectStationMerchantData($merchant, $user_id);

        $user = new Station();

        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }	

    public function collectStationMerchantData($merchant, $user_id)
    {
        return $user_data = [
            'user_id' => $user_id,
            'company_name' => $merchant->company_name,
            'gst' => $merchant->gst,
            'business_reg_no' => $merchant->business_reg_no,
            'country_id' => $merchant->country_id,
            'business_type' => $merchant->business_type,
            'address_id' => $merchant->address_id,
            'contact_person' => "",
            'office_no' => $merchant->office_no,
            'mobile_no' => $merchant->mobile_no,
            'station_name' => "",
            'description' => $merchant->description,
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => $merchant->planned_sales,
            'bankaccount_id' => $merchant->bankaccount_id, //changed from bank_id to bankaccount_id by imran
            'return_policy' => $merchant->return_policy,
            'note' => $merchant->note,
            'delivery_mode' => ""

        ];
    }	
	
    public function collectStationFormData(Request $request, $user_model, $bank_model, $address_model)
    {
        return $user_data = [
            'user_id' => $user_model['id'],
            'company_name' => $request->get('company_name'),
            'gst' => $request->get('gst'),
            'business_reg_no' => $request->get('business_reg_no'),
            'country_id' => $request->get('country'),
            'business_type' => $request->get('business_type'),
            'address_id' => $address_model['id'],
            'contact_person' => "",
            'office_no' => $request->get('office'),
            'mobile_no' => $request->get('mobile'),
            'station_name' => "",
            'description' => $request->get('description'),
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => $request->get('sell_plan'),
            'bankaccount_id' => $bank_model['id'], //changed from bank_id to bankaccount_id by imran
            'return_policy' => $request->get('return_policy'),
            'note' => $request->get('notes_station'),
            'delivery_mode' => ""

        ];
    }
	
    public function collectStationFormDataEmpty(Request $request, $user_model)
    {
        return $user_data = [
            'user_id' => $user_model->id,
            'company_name' => '',
            'gst' => '',
            'business_reg_no' => '',
            'country_id' => 0,
            'business_type' => '',
            'address_id' => 0,
            'contact_person' => "",
            'office_no' => '',
            'mobile_no' => '',
            'station_name' => "",
            'description' => '',
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => '',
            'bankaccount_id' => 0, //changed from bank_id to bankaccount_id by imran
            'return_policy' => '',
            'note' => '',
            'delivery_mode' => ""

        ];
    }	

    //Update station info

    public function UpdateInfo($station_data,$request)
    {
        $Station = Station::find($station_data->id);
        $Station->contact_person = "";
        $Station->office_no = $request->get('office');
        $Station->mobile_no = $request->get('mobile');
        $Station->description = $request->get('description');
        $Station->license = 0;
        $Station->coverage = "";
        $Station->ownership = 0;
        $Station->category_id = 0;
        $Station->planned_sales = $request->get('sell_plan');
        $Station->return_policy = $request->get('return_policy');
        $Station->note = $request->get('notes_station');

        /*  Paul on 7 April 2017 at 5:55PM  */
        $Station->gst= $request->get('gst');
        /*  Ends Here   */
        return $Station->save();
    }

    public function attachWebsites($website_models, $user_as_station_model)
    {
        foreach ($website_models as $website_model) {
            $user_as_station_model->websites()->attach($website_model->id);
        }

    }

    public function attachBrands($user_as_station_model, $brand_models)
    {
        foreach ($brand_models as $brand_model) {

            $user_as_station_model->brand()->attach($brand_model->id);
        }

    }

    public function attachDirectors($director_models, $user_as_station_model)
    {
        foreach ($director_models as $director_model) {
            $user_as_station_model->directors()->attach($director_model->id);
        }

    }


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'stationcategory',
            'station_id', 'category_id')->withTimestamps();
    }

    public function descimages()
    {
        return $this->hasMany('App\Models\Descimage', 'station_id');
    }

    //---Section Method---//
    public function sections(){
        return $this->hasMany('App\Models\Section', 'station_id');
    }

    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'station_id');
    }

    public function scopeWithProfile($query, $id)
    {
        $profile = Profile::whereHas('album', function($q) use ($id){
            $q->where('station_id', $id);
        })->first();

        return $profile;
    }

    public function scopeSmm_quota_max($query, $user_id)
    {
        $station = $query->select('smm_quota_max')
            ->where('user_id', $user_id)
            ->first();
        return $station->smm_quota_max;
    }

    public static function getStation($supplier)
    {
        $station = Station::where('user_id',$supplier)->first();
        return $station;
    }

    public function station_product()
    {
        return $this->belongsTo('App\Models\StationProduct', 'id', 'station_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'stationsproduct',
            'station_id', 'sproduct_id')->withTimestamps();
    }
}
