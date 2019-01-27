<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\OshopProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;

use Auth;
use DB;
class BrandController extends Controller {
	public $logo_path = 'images/brandslogo/';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $getABrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
				->where('product.oshop_selected', '=', true)
               ->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
                //->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'A%')
                ->select('brand.*')
                ->get();
        $getBBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
                //->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'B%')
                ->select('brand.*')
                ->get();
        $getCBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'C%')
                ->select('brand.*')
                ->get();
        $getDBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'D%')
                ->select('brand.*')
                ->get();
        $getEBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'E%')
                ->select('brand.*')
                ->get();
        $getFBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'F%')
                ->select('brand.*')
                ->get();
        $getGBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
				->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'G%')
                ->select('brand.*')
                ->get();
        $getHBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'H%')
                ->select('brand.*')
                ->get();
        $getIBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'I%')
                ->select('brand.*')
                ->get();
        $getJBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'J%')
                ->select('brand.*')
                ->get();
        $getKBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'K%')
                ->select('brand.*')
                ->get();
        $getLBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'L%')
                ->select('brand.*')
                ->get();
        $getMBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'M%')
                ->select('brand.*')
                ->get();
        $getNBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'N%')
                ->select('brand.*')
                ->get();
        $getOBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'O%')
                ->select('brand.*')
                ->get();
        $getPBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'P%')
                ->select('brand.*')
                ->get();
        $getQBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'Q%')
                ->select('brand.*')
                ->get();
        $getRBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'R%')
                ->select('brand.*')
                ->get();
        $getSBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'S%')
                ->select('brand.*')
                ->get();
        $getTBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'T%')
                ->select('brand.*')
                ->get();
        $getUBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'U%')
                ->select('brand.*')
                ->get();
        $getVBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'V%')
                ->select('brand.*')
                ->get();
        $getWBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'W%')
                ->select('brand.*')
                ->get();
        $getXBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'X%')
                ->select('brand.*')
                ->get();
        $getYBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'Y%')
                ->select('brand.*')
                ->get();
        $getZBrands = Brand::distinct()
                ->join('product', 'brand.id', '=', 'product.brand_id')->join('merchantproduct','product.id','=','merchantproduct.product_id')->join('merchant','merchantproduct.merchant_id','=','merchant.id')->where('merchant.status', '=', 'active')
                ->where('product.oshop_selected',true)->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
               // ->join('sectionproduct', 'sectionproduct.product_id', '=', 'product.id')
                ->join('oshopproduct', 'oshopproduct.product_id','=','product.id')
                ->where('brand.name', 'like', 'Z%')
                ->select('brand.*')
                ->get();


        //dd($getAllBrands);

        return view('brandlist')->with(array(
                    'allABrands' => $getABrands,
                    'allBBrands' => $getBBrands,
                    'allCBrands' => $getCBrands,
                    'allDBrands' => $getDBrands,
                    'allEBrands' => $getEBrands,
                    'allFBrands' => $getFBrands,
                    'allGBrands' => $getGBrands,
                    'allHBrands' => $getHBrands,
                    'allIBrands' => $getIBrands,
                    'allJBrands' => $getJBrands,
                    'allKBrands' => $getKBrands,
                    'allLBrands' => $getLBrands,
                    'allMBrands' => $getMBrands,
                    'allNBrands' => $getNBrands,
                    'allOBrands' => $getOBrands,
                    'allPBrands' => $getPBrands,
                    'allQBrands' => $getQBrands,
                    'allRBrands' => $getRBrands,
                    'allSBrands' => $getSBrands,
                    'allTBrands' => $getTBrands,
                    'allUBrands' => $getUBrands,
                    'allVBrands' => $getVBrands,
                    'allWBrands' => $getWBrands,
                    'allXBrands' => $getXBrands,
                    'allYBrands' => $getYBrands,
                    'allZBrands' => $getZBrands,
                ));
    }

    /**
     * Get all brands
     *
     * @method Ajax Get
     */
    public function getBrand() {
        $brand = brand::orderBy('name')->select('id', 'name', 'description', 'logo')->get()->toArray();
        $brands = array();
        foreach ($brand as $key => $value) {
            if (empty($brands[$key])) {
                $brands[$key] = array();
            }
            $brands[$key]['text'] = $value['name'];
            $brands[$key]['name'] = $value['name'];
            $brands[$key]['brandDescription'] = $value['description'];
            $brands[$key]['data-brand-id'] = $value['id'];
            if (!empty($value['logo'])) {
                $brands[$key]['logo'] = \URL::to($this->logo_path . $value['logo']);
            }
        }
//        print_r($brands);
        return response()->json($brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    public function getBrandTable() {
        return view('admin/brandTree');
    }

    /**
     * Add new brand or subbrand
     *
     * @method Ajax
     */
    public function postNewbrand(Request $request) {

        $formData = Input::all();

        $destinationPath = array(
            'logo' => $this->logo_path,
        );

        $image = $request->file('logo');

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $brandData = array(
                'name' => $formData['brandName'],
                'description' => $formData['brandDescription'],
                'created_at' => $now,
                'updated_at' => $now,
            );



            $mainbrand = array(
                'name' => $formData['brandName'],
                'description' => $formData['brandDescription'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            if (!empty($image)) {
                $filename = $image->getClientOriginalName();
                $uploadSuccess = $image->move($destinationPath['logo'], $filename);
//                copy($destinationPath['logo'] . '/' . $filename);
                if ($uploadSuccess) {
                    $mainbrand['logo'] = $filename;
                }
            }
            brand::insert($mainbrand);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new brand or subbrand
     *
     * @method Ajax POST
     */
    public function postEditbrand(Request $request) {

        $formData = Input::all();
        $destinationPath = array(
            'logo' => $this->logo_path,
        );

        $image = $request->file('logo');

        $brandData = array(
            'name' => $formData['brandName'],
            'description' => $formData['brandDescription']
        );

        if (!empty($image)) {
            $filename = $image->getClientOriginalName();
            $uploadSuccess = $image->move($destinationPath['logo'], $filename);
            if ($uploadSuccess) {
                $brandData['logo'] = $filename;
            }
        }

        brand::where('id', '=', $formData['data-brand-id'])->update($brandData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new brand or subbrand
     *
     * @method Ajax
     */
    public function removebrand() {
        $formData = Input::all();
        brand::where('id', '=', $formData['data-brand-id'])->delete();

        echo "success";
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBrandDetails($id) {
		$merchant=False;
        $user=False;
        $station=False;
       if(Auth::check()){

            $user_id = Auth::user()->id;
            $roles=DB::table('role_users')->where('user_id',$user_id)->get();

            foreach ($roles as $r) {
                # code...
                $r= $r->role_id;
                if ($r==3) {
                # Merchant is Yes now.

                $merchant=True;
                $merchant_id=DB::table('merchant')->where('user_id',$user_id)->pluck('id');
                }
                if ($r==2) {
                    $user=True;
                }
            }
        } 

        $type = "brand";
        // $brandDetails = Brand::where('id', $id)->with('products')->first();
        $brandDetails = Brand::where('id', $id)->
        with(['products' => function($query) use($id) {
                $query->where('product.oshop_selected', '=', true)->select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.thumb_photo' ,
				  'product.photo_2' ,
				  'product.photo_3' ,
				  'product.photo_4' ,
				  'product.photo_5' ,
				  'product.adimage_1' ,
				  'product.adimage_2' ,
				  'product.adimage_3' ,
				  'product.adimage_4' ,
				  'product.adimage_5' ,
				  'product.description' ,
				  'product.free_delivery' ,
				  'product.free_delivery_with_purchase_qty' ,
				  'product.views' ,
				  'product.display_non_autolink' ,
				  'product.del_worldwide'  ,
				  'product.del_west_malaysia'  ,
				  'product.del_sabah_labuan'  ,
				  'product.del_sarawak'  ,
				  'product.cov_country_id' ,
				  'product.cov_state_id' ,
				  'product.cov_city_id' ,
				  'product.cov_area_id' ,
				  'product.b2b_del_worldwide' ,
				  'product.b2b_del_west_malaysia' ,
				  'product.b2b_del_sabah_labuan' ,
				  'product.b2b_del_sarawak' ,
				  'product.b2b_cov_country_id' ,
				  'product.b2b_cov_state_id' ,
				  'product.b2b_cov_city_id' ,
				  'product.b2b_cov_area_id' ,
				  'product.del_pricing'  ,
				  'product.del_width'  ,
				  'product.del_lenght'  ,
				  'product.del_height'  ,
				  'product.del_weight'  ,
				  'product.weight'  ,
				  'product.height'  ,
				  'product.width'  ,
				  'product.length'  ,
				  'product.del_option' ,
				  'product.retail_price' ,
				  'product.original_price' ,
				  'product.discounted_price',
				  'product.private_retail_price' ,
				  'product.private_discounted_price' ,
				  'product.stock' ,
				  'product.available' ,
				  'product.private_available' ,
				  'product.b2b_available' ,
				  'product.hyper_available' ,
				  'product.owarehouse_moq' ,
				  'product.owarehouse_moqpb' ,
				  'product.owarehouse_moqperpax' ,
				  'product.owarehouse_price' ,
				  'product.measure'  ,
				  'product.owarehouse_units' ,
				  'product.owarehouse_ave_unit_price' ,
				  'product.type'  ,
				  'product.owarehouse_duration' ,
				  'product.smm_selected'  ,
				  'product.oshop_selected'  ,
				  'product.mc_sales_staff_id' ,
				  'product.referral_sales_staff_id' ,
				  'product.mcp1_sales_staff_id' ,
				  'product.mcp2_sales_staff_id' ,
				  'product.psh_sales_staff_id' ,
				  'product.osmall_commission'  ,
				  'product.b2b_osmall_commission'  ,
				  'product.mc_sales_staff_commission'  ,
				  'product.mc_with_ref_sales_staff_commission'  ,
				  'product.referral_sales_staff_commission'  ,
				  'product.mcp1_sales_staff_commission'  ,
				  'product.mcp2_sales_staff_commission'  ,
				  'product.smm_sales_staff_commission'  ,
				  'product.psh_sales_staff_commission'  ,
				  'product.str_sales_staff_commission'  ,
				  'product.return_policy' ,
				  'product.return_address_id' ,
				  'product.status' ,
				  'product.active_date'  ,
				  'product.deleted_at'  ,
				  'product.created_at' ,
				  'product.updated_at')->join('merchantproduct','product.id','=','merchantproduct.product_id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
				->where('merchant.status', '=', 'active')->where('product.available','>','0')->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')->orderBy('product.retail_price', 'asc');
            }])->first();
        // return $brandDetails->products;
        $count=0;
       /* foreach ($brandDetails->products as $b) {
           if (!Product::where('id',$b->id)->where('oshop_selected', '=', true)->where('retail_price','>','0')->where('segment', '=', 'b2c')->exists()) {
               # code...
             //   unset($brandDetails->products[$count]);
           }
           $count++;
        }*/
     //  dd($brandDetails->products);
        return view('detail')
                        ->with('brandDetails', $brandDetails)
                        ->with('type', $type)
                        ->with('user',$user);
    }

    public function brand_sort(Request $request)
    {
        $r = $request->all();
		$sort = 1;
		if(isset($r['sort'])){
			$sort = $r['sort'];
		}
        
        $id = $r['brand_id'];

        if($sort == 1){
            $by = "retail_price";
            $sort = "asc";
        } else if($sort == 2){
            $by = "retail_price";
            $sort = "desc";
        } else if($sort == 3){
            $by = "created_at";
            $sort = "desc";
        } else if($sort == 4){
            $by = "discounted_price";
            $sort = "asc";
        }

        $sectionProduct=Product::where('brand_id',$id)
		->where('merchant.status', '=', 'active')->where('product.retail_price','>','0')->where('product.segment','=','b2c')->where('product.status','=','active')
		->join('merchantproduct','product.id','=','merchantproduct.product_id')
		->join('merchant','merchantproduct.merchant_id','=','merchant.id')
		->select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
				  'product.thumb_photo' ,
				  'product.photo_2' ,
				  'product.photo_3' ,
				  'product.photo_4' ,
				  'product.photo_5' ,
				  'product.adimage_1' ,
				  'product.adimage_2' ,
				  'product.adimage_3' ,
				  'product.adimage_4' ,
				  'product.adimage_5' ,
				  'product.description' ,
				  'product.free_delivery' ,
				  'product.free_delivery_with_purchase_qty' ,
				  'product.views' ,
				  'product.display_non_autolink' ,
				  'product.del_worldwide'  ,
				  'product.del_west_malaysia'  ,
				  'product.del_sabah_labuan'  ,
				  'product.del_sarawak'  ,
				  'product.cov_country_id' ,
				  'product.cov_state_id' ,
				  'product.cov_city_id' ,
				  'product.cov_area_id' ,
				  'product.b2b_del_worldwide' ,
				  'product.b2b_del_west_malaysia' ,
				  'product.b2b_del_sabah_labuan' ,
				  'product.b2b_del_sarawak' ,
				  'product.b2b_cov_country_id' ,
				  'product.b2b_cov_state_id' ,
				  'product.b2b_cov_city_id' ,
				  'product.b2b_cov_area_id' ,
				  'product.del_pricing'  ,
				  'product.del_width'  ,
				  'product.del_lenght'  ,
				  'product.del_height'  ,
				  'product.del_weight'  ,
				  'product.weight'  ,
				  'product.height'  ,
				  'product.width'  ,
				  'product.length'  ,
				  'product.del_option' ,
				  'product.retail_price' ,
				  'product.original_price' ,
				  'product.discounted_price',
				  'product.private_retail_price' ,
				  'product.private_discounted_price' ,
				  'product.stock' ,
				  'product.available' ,
				  'product.private_available' ,
				  'product.b2b_available' ,
				  'product.hyper_available' ,
				  'product.owarehouse_moq' ,
				  'product.owarehouse_moqpb' ,
				  'product.owarehouse_moqperpax' ,
				  'product.owarehouse_price' ,
				  'product.measure'  ,
				  'product.owarehouse_units' ,
				  'product.owarehouse_ave_unit_price' ,
				  'product.type'  ,
				  'product.owarehouse_duration' ,
				  'product.smm_selected'  ,
				  'product.oshop_selected'  ,
				  'product.mc_sales_staff_id' ,
				  'product.referral_sales_staff_id' ,
				  'product.mcp1_sales_staff_id' ,
				  'product.mcp2_sales_staff_id' ,
				  'product.psh_sales_staff_id' ,
				  'product.osmall_commission'  ,
				  'product.b2b_osmall_commission'  ,
				  'product.mc_sales_staff_commission'  ,
				  'product.mc_with_ref_sales_staff_commission'  ,
				  'product.referral_sales_staff_commission'  ,
				  'product.mcp1_sales_staff_commission'  ,
				  'product.mcp2_sales_staff_commission'  ,
				  'product.smm_sales_staff_commission'  ,
				  'product.psh_sales_staff_commission'  ,
				  'product.str_sales_staff_commission'  ,
				  'product.return_policy' ,
				  'product.return_address_id' ,
				  'product.status' ,
				  'product.active_date'  ,
				  'product.deleted_at'  ,
				  'product.created_at' ,
				  'product.updated_at')->get();
         $pids=array();
             foreach ($sectionProduct as $sp) {
            # code...
            // array_push($category_ids,$products->category_id);
            array_push($pids, $sp->id);
            // array_push($pids, $products->id);
        }
        $pids=array_unique($pids);
        //
        $brandDetails = Brand::where('id', $id)->
        with(['products' => function($query) use($pids,$by, $sort) {
                if($by == "discounted_price"){
                    $query->where('oshop_selected', '=', true)->where('discounted_price', '>', "0")->whereIn('id',$pids)->orderBy($by, $sort);
                } else {
                    $query->where('oshop_selected', '=', true)->whereIn('id',$pids)->orderBy($by, $sort);
                }

            }])->first();
       /*
        $catDetails = \App\Category::where('id', $id)->
            with('product')->first();
         */

        // $subCatDesc = SubCatLevel1::find($sid)->description;

       return view('brandsort')
           ->with('brandDetails', $brandDetails);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function merchantsWithSameBrand($merchant_id)
    {
        $ret=array();
        try {
            $data=UtilityController::sameBrandMerchants($merchant_id);
            $ret["status"]="success";
            $ret["data"]=$data;
        } catch (\Exception $e) {
            $ret["status"]="failure";
            $ret["short_message"]=$e->getMessage();
        }
        return response()->json($ret);
    }
    public function oshopsWithSameBrand($oshop_id)
    {
        $ret=array();
        try {
            $data=UtilityController::same_brand_oshops($oshop_id);
            $ret["status"]="success";
            $ret["data"]=$data;
        } catch (\Exception $e) {
            $ret["status"]="failure";
            $ret["short_message"]=$e->getMessage();
        }
        return response()->json($ret);
    }
}
