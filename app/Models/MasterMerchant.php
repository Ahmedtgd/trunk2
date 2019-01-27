<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterMerchant extends Model
{
    protected $table = 'merchant';
	protected $fillable = ["user_id", 'company_name', 'gst', 'business_reg_no',
		'country_id', 'business_type', 'contact_person', 'office_no', 'mobile_no',
		'oshop_name', 'bankaccount_id', 'address_id', 'description', 'license',
		'coverage', 'category_id', 'return_policy', 'remarks','mc_sales_staff_id'];
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
    /* The merchant that belong to the website. */
    public function ecommerce($merchantid)
    {
        return \DB::table('website')->select('name')->where('id', $merchantid)->where('type', 'ecommerce');
       // $ecom = \DB::select( DB::raw("SELECT name FROM website WHERE id = '$merchantid' and type='ecommerce'") );
      //  print_r($ecom);die();
        //return $this->belongsToMany('App\Models\Website', 'merchantwebsite', 'merchant_id', 'website_id');
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
        return $this->hasMany('App\Models\Director');
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
    public function address($countryid)
    {
        return \DB::table('country')->select('name')->where('id', $countryid);
        //return $this->belongsTo('App\Models\Address', 'address_id', 'id');
    }

    /*merchant belongs to only one bank 1:1*/
    public function bankaccount()
    {
        return $this->belongsTo('App\Models\BankAccount', 'bankaccount_id', 'id');
    }

    /* merchant belongs to only mc_id 1:1 */
    public function mc_id()
    {
        return $this->belongsTo('App\Models\SalesStaff','mc_sales_staff_id', 'id');
    }
    /* merchant belongs to only mc_id_referral 1:1 */
    public function mc_id_referal()
    {
        return $this->belongsTo('App\Models\SalesStaff','referral_sales_staff_id', 'id');
    }
    /* merchant belongs to only mc_id_mcp1 1:1 */
    public function mcp1_id()
    {
        return $this->belongsTo('App\Models\SalesStaff','mcp1_sales_staff_id', 'id');
    }
    /* merchant belongs to only mc_id_mcp2 1:1 */
    public function mcp2_id()
    {
        return $this->belongsTo('App\Models\SalesStaff','mcp2_sales_staff_id', 'id');
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
            "ownership" => null,
            "category_id" => null,
            "planned_sales" => null,
            "bankaccount_id" => null,
            "return_policy" => null,
            "remarks" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null
        ];

        return $merchant;
    }

    public function store(Request $request, $user_model, $bankaccount_model, $address_model)
    {

        $user_data = $this->collectMerchantFormData(
            $request, $user_model, $bankaccount_model, $address_model);
        //dd($user_data);

        $user = new Merchant();

        $user_mer_model = $user->create($user_data);
        //  dd($user_mer_model);
        return $user_mer_model;
    }

	public function collectMerchantFormData(Request $request, $user_model, $bankaccount_model,
		$address_model)
    {
        return $user_data = [
            //  'id'=>$request->get(),
            'user_id' => $user_model['id'],
            'company_name' => $request->get('company_name'),
            'gst' => $request->get('gst'),
            'business_reg_no' => $request->get('business_reg_no'),
            'country_id' => $request->get('country'),
            'business_type' => $request->get('business_type'),
            'address_id' => $address_model['id'],
            'contact_person' => $request->get('contact'),
            'office_no' => $request->get('office'),
            'mobile_no' => $request->get('mobile'),
            'oshop_name' => $request->get('shop_name'),
            'oshop_logo' => $request->get(''),
            'description' => $request->get('description'),
            'license' => $request->get('have_license'),
            'coverage' => $request->get('supply_method'),
            'ownership' => $request->get('have_brand'),
            'category_id' => $request->get('category'),
            'planned_sales' => $request->get('sell_plan'),
            'bankaccount_id' => $bankaccount_model['id'],
            'return_policy' => $request->get('return_policy'),
            'remarks' => $request->get('remarks')
        ];
    }

    //Update merchant info

    public function UpdateInfo($merchant_data,$request)
    {
        $Merchant = Merchant::find($merchant_data->id);
        $Merchant->contact_person = $request->get('contact');
        $Merchant->office_no = $request->get('office');
        $Merchant->mobile_no = $request->get('mobile');
        $Merchant->description = $request->get('description');
        $Merchant->license = $request->get('have_license');
        $Merchant->coverage = $request->get('supply_method');
        $Merchant->ownership = $request->get('have_brand');
        $Merchant->category_id = $request->get('category');
        $Merchant->planned_sales = $request->get('sell_plan');
        $Merchant->return_policy = $request->get('return_policy');
        $Merchant->remarks = $request->get('remarks');
        return $Merchant->save();
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
        return $this->belongsTo('App\Models\MerchantProduct', 'id', 'merchant_id');
    }
    //just for test
    public function merchant_product_test()
    {
        return $this->belongsToMany('App\Models\MerchantProduct');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'merchantproduct',
            'merchant_id', 'product_id')->withTimestamps();
    }

    public function oshopproducts()
    {
        return $this->belongsToMany('App\Models\Product', 'oshopproduct',
            'merchant_id', 'product_id')->withTimestamps();
    }

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
    
    
}
