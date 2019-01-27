<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Merchant extends Model
{
    protected $table = 'merchant';
	protected $fillable = ['user_id', 'company_name', 'gst', 'business_reg_no',
		'country_id', 'business_type', 'contact_person', 'office_no', 'mobile_no',
		'oshop_name', 'bankaccount_id', 'address_id', 'oshop_address_id', 'ownership', 'planned_sales', 'own_delivery_logistic_id',
        'description', 'license','note','coverage', 'category_id','min_order', 'return_policy', 'status', 'all_system_delivery',
        'all_own_delivery','salesorder_no','opossum_receipt_no','membership','referral_code'];

    public static function getMerchant($supplier)
    {
        $merchant = Merchant::where('user_id',$supplier)->first();
        return $merchant;
    }

    public static function getAddressOfMerchant($supplier)
    {
        $merchant = Merchant::select('address.*','merchant.address_id as address_id')
            ->join('address','address.id','=','merchant.address_id')
            ->where('user_id',$supplier)
            ->first();

        return $merchant;
    }
    //  protected $guarded = [ 'id'];

    /*relations*/

    /* The merchant that belong to the Documents. */
    public function documents()
    {
        return $this->belongsToMany('App\Models\Document', 'merchantdocument', 'merchant_id', 'document_id');
    }

    /* The merchant that belong to the website. */
    public function websites()
    {
        return $this->belongsToMany('App\Models\Website', 'merchantwebsite', 'merchant_id', 'website_id');
    }
     /* The merchant that belong to the Social media. */
    public function socialmedia()
    {
        return $this->belongsToMany('App\Models\SocialMedia', 'merchantsocialmedia', 'merchant_id', 'smedia_id');
    }

    /* Merchant belongs to merchantdirector table m:n */
    public function directors()
    {
        return $this->belongsToMany('App\Models\Director', 'merchantdirector', 'merchant_id', 'director_id');
    }
    /* Merchant belongs to merchantdirector table m:n */
    public function directorsInEditView()
    {
        //return $this->hasMany('App\Models\Director');
        return $this->belongsToMany('App\Models\Director','merchantdirector','merchant_id','director_id');
    }
    public function brand()
    {
        return $this->belongsToMany('App\Models\Brand', 'merchantbrand', 'merchant_id', 'brand_id');
    }
    public function subcatlevel1()
    {
        return $this->hasMany('App\Models\MerchantSubCategory1');
    }
    public function merchant_category()
    {
        return $this->hasMany('App\Models\MerchantCategory');
    }
    /* merchant belongs to only one user */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /* merchant belongs to only one address 1:1 */
    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'address_id', 'id');
    }

    /*merchant belongs to only one bank 1:1*/
    public function bankaccount()
    {
        return $this->belongsTo('App\Models\BankAccount', 'bankaccount_id', 'id');
    }

    /*relations ends*/

    public function getMerchantRelationsFullMeta()
    {
        $user = new User();
        $website = new Website();
        $director = new Director();
        $address = new \App\Models\Address();
        $bankaccount = new \App\Models\BankAccount();
        $brand = new Brand();
        $socialmedia = new SocialMedia();

        $merchantFullMeta = [
            'user' => $user->getMeta(),
            'merchant' => [$this->getMeta()],
            'bankaccount' => [$bankaccount->getMeta()],
            'bank'=>null,
            'bankcode'=>null,
            'address' => [$address->getMeta()],
            'brand' => [$brand->getMeta()],
            'websites' => [$website->getMeta()],
            'socialmedia' => [$socialmedia->getMeta()],
            'directors' => [$director->getMeta()],
			'contactemail' => []
        ];

        return $merchantFullMeta;
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
            "contact_person" => null,
            "office_no" => null,
            "mobile_no" => null,
            "oshop_name" => null,
            "oshop_logo_1" => null,
            "oshop_logo_2" => null,
            "oshop_logo_3" => null,
            "oshop_logo_4" => null,
            "oshop_logo_5" => null,
            "oshop_adimage_1" => null,
            "oshop_adimage_2" => null,
            "oshop_adimage_3" => null,
            "oshop_adimage_4" => null,
            "oshop_adimage_5" => null,
            "description" => null,
            "history" => null,
            "license" => null,
            "coverage" => null,
            "min_order" => null,
            "ownership" => null,
            "category_id" => null,
            "planned_sales" => null,
            "bankaccount_id" => null,
            "return_policy" => null,
            "all_own_delivery" => null,
            "own_delivery_logistic_id" => null,
            "all_system_delivery" => null,
            "note" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null
        ];

        return $merchant;
    }

    public function store(Request $request, $user_model, $bankaccount_model, $address_model)
    {
        $user_data = $this->collectMerchantFormData($request, $user_model, $bankaccount_model, $address_model);
		
        $user = new Merchant();
        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }
	
	 public function store_empty(Request $request, $user_model)
    {

        $user_data = $this->collectMerchantFormDataEmpty(
            $request, $user_model);

        $user = new Merchant();

        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }	
	
    public function store_fromstation($station, $userid)
    {
        $user_data = $this->collectMerchantStationData($station, $userid);
		
        $user = new Merchant();
        $user_mer_model = $user->create($user_data);
        return $user_mer_model;
    }	
	
    public function collectMerchantFormDataEmpty(Request $request, $user_model)
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
			'oshop_name' => "",
            'oshop_logo' => "",
            'description' => '',
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => '',
            'bankaccount_id' => 0,
            'return_policy' => '',
            'note' => '',
			'all_own_delivery' => 0, 
            'all_system_delivery' => 0
        ];
    }	

	public function collectMerchantStationData($station, $userid)
    {		
        return $user_data = [
            'user_id' => $userid,
            'company_name' => $station->company_name,
            'gst' => $station->gst,
            'business_reg_no' => $station->business_reg_no,
            'country_id' => $station->country_id,
            'business_type' => $station->business_type,
            'address_id' => $station->address_id,
            'contact_person' => "",
            'office_no' => $station->office_no,
            'mobile_no' => $station->mobile_no,
            'oshop_name' => "",
            'oshop_logo' => "",
            'description' => $station->description,
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => $station->planned_sales,
            'bankaccount_id' => $station->bankaccount_id,
            'return_policy' => "",
            'all_own_delivery' => 0, 
            'all_system_delivery' => 0,
            'note' => $station->note
        ];
    }	
	
	public function collectMerchantFormData(Request $request, $user_model, $bankaccount_model, $address_model)
    {
		$all_own_delivery = $request->get('all_own_delivery');
		if(is_null($all_own_delivery)){
			$all_own_delivery = 0;
		}
		$all_system_delivery = $request->get('all_system_delivery');
		if(is_null($all_system_delivery)){
			$all_system_delivery = 0;
		}		
        return $user_data = [
            'user_id' => $user_model['id'],
            'company_name' => $request->get('company_name'),
            'gst' => $request->get('gst') ? $request->get('gst') : "",
            'business_reg_no' => $request->get('business_reg_no') ? $request->get('business_reg_no') : "",
            'country_id' => $request->get('country') ? $request->get('country') : "",
            'business_type' => $request->get('business_type') ? $request->get('business_type') : "",
            'address_id' => $address_model['id'],
            'contact_person' => "",
            'office_no' => $request->get('office') ? $request->get('office') : "",
            'mobile_no' => $request->get('mobile') ? $request->get('mobile') : "",
            'oshop_name' => "",
            'oshop_logo' => $request->get(''),
            'description' => $request->get('description') ? $request->get('description') : "",
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => $request->get('sell_plan') ? $request->get('sell_plan') : "",
            'bankaccount_id' => $bankaccount_model['id'],
            'return_policy' => $request->get('return_policy') ? $request->get('return_policy') : "",
            'min_order' => $request->get('min_order') ? $request->get('min_order') : 0,
            'all_own_delivery' => $all_own_delivery, 
            'all_system_delivery' => $all_system_delivery,
            'note' => $request->get('note') ? $request->get('note') : ""
        ];
    }

    //Update merchant info

    public function UpdateInfo($merchant_data,$request)
    {
		$all_own_delivery = $request->get('all_own_delivery');
		if(is_null($all_own_delivery)){
			$all_own_delivery = 0;
		}
		$all_system_delivery = $request->get('all_system_delivery');
		if(is_null($all_system_delivery)){
			$all_system_delivery = 0;
		}	

        $Merchant = Merchant::find($merchant_data->id);
        $Merchant->contact_person = "";
        $Merchant->business_type=$request->get('business_type');
        $Merchant->company_name=$request->get('company_name');
        $Merchant->office_no = $request->get('office');
        $Merchant->mobile_no = $request->get('mobile');
        $Merchant->description = $request->get('description');
        $Merchant->license = 0;
        $Merchant->coverage = "";
        $Merchant->ownership = 0;
        $Merchant->category_id = 0;
        $Merchant->planned_sales = $request->get('sell_plan');
        $Merchant->return_policy = $request->get('return_policy');
        $Merchant->business_reg_no = $request->get('business_reg_no');
        $Merchant->note = $request->get('note');
		$user_data = [
            'company_name' => $request->get('company_name'),
            'gst' => $request->get('gst'),
            'business_reg_no' => $request->get('business_reg_no'),
            'country_id' => $request->get('country'),
            'business_type' => $request->get('business_type'),
            'contact_person' => "",
            'office_no' => $request->get('office'),
            'mobile_no' => $request->get('mobile'),
            'description' => $request->get('description'),
            'license' => 0,
            'coverage' => "",
            'ownership' => 0,
            'category_id' => 0,
            'planned_sales' => $request->get('sell_plan'),
            'return_policy' => $request->get('return_policy') ? $request->get('return_policy') : "",
            'min_order' => $request->get('min_order') ? $request->get('min_order') : 0,
            'all_own_delivery' => $all_own_delivery, 
            'all_system_delivery' => $all_system_delivery,
            'note' => $request->get('note')
        ];
	//	dump($all_system_delivery);
	//	dump($all_own_delivery);
		$result = DB::table('merchant')->where('id',$merchant_data->id)->update($user_data);
        /*  Ends Here  */
        return $result;
    }

    public function attachWebsites($website_models, $user_as_merchant_model)
    {
        foreach ($website_models as $website_model) {
            $user_as_merchant_model->websites()->attach($website_model->id);
        }

    }

    public function attachBrands($user_as_merchant_model, $brand_models)
    {  //dd($brand_models);
        foreach ($brand_models as $brand_model) {
            $user_as_merchant_model->brand()->attach($brand_model->id);
        }

    }

    public function attachDirectors($director_models, $user_as_merchant_model)
    {
        foreach ($director_models as $director_model) {
            $user_as_merchant_model->directors()->attach($director_model->id);
        }

    }

    public function merchant_product()
    {
        return $this->belongsTo('App\Models\MerchantProduct', 'id',
			'merchant_id')->
			whereNull('merchantproduct.deleted_at');
    }

    //just for test
    public function merchant_product_test()
    {
        return $this->belongsToMany('App\Models\MerchantProduct');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'merchantproduct',
            'merchant_id', 'product_id')
        ->whereNull('merchantproduct.deleted_at')
        ->withTimestamps();
    }

/*    public function oshopproducts()
    {
        return $this->belongsToMany('App\Models\Product', 'oshopproduct',
            'merchant_id', 'product_id')->withTimestamps();
    }*/

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'merchantcategory',
            'merchant_id', 'category_id')->withTimestamps();
    }

    public function descimages()
    {
        return $this->hasMany('App\Models\Descimage', 'merchant_id');
    }

    //---Section Method---//
    public function oshopSections(){
        return $this->hasMany('App\Models\OshopSection', 'merchant_id');
    }

    public function sections()
    {
        return $this->belongsToMany('App\Models\Section', 'oshopsection',
            'merchant_id', 'section_id')->withTimestamps();
    }
    //--End Section Method--//
    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'merchant_id');
    }

    public function scopeRelatedProducts($query, $id)
    {
        return $query->where('id', $id)
            ->whereHas('categories', function($q) use ($id) {
                $q->whereIn('category_id', $this->categoryList($id));
            })->first();
    }

    public function albums()
    {
        return $this->hasMany('App\Models\Album', 'merchant_id');
    }

    public function certificates()
    {
        return $this->hasMany('App\Models\Certificate', 'merchant_id');
    }

    public function scopeWithProfile($query, $id)
    {
        $profile = Profile::whereHas('album', function($q) use ($id){
            $q->where('merchant_id', $id);
        })->first();

        return $profile;
    }

    /**
     * Get selected products from
     * merchant selection view
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeWithSelectedProducts($query)
    {
        $query = $query->with(array('products' => function($query){
                $query->where('smm_selected', 1);
            }))->first();

        return isset($query) ? $query->products : null;
    }

    /**
     * Get the max number of selection
     * Created by Dean
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeSmm_quota_max($query, $user_id)
     {
        $merchant = $query->where('user_id', $user_id)
            ->select('smm_quota_max')
            ->first();
        //dd($merchant[0]->smm_quota_max);
        return $merchant;
    }
    
    public function getAllMerchants()
    {
        return $this->join('users', 'merchant.user_id', '=', 'users.id')->orderBy('users.name')->lists('users.name','merchant.id')->all();
    }


    public static function getCity($city_id)
    {
        return City::find($city_id);
    }

    public function getPrefixofID($id)
    {
        return str_pad($id,10,0,STR_PAD_LEFT);
    }

    public function merchant_product_list()
    {
        return $this->hasMany(MerchantProduct::class,'merchant_id')->where('deleted_at',null);
    }

    public function company()
    {
        return$this->hasOne(Company::class,'owner_user_id','user_id');
    }

}
