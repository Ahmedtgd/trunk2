<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SMMin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use App;
use Input;
use App\Http\Requests;
use App\Models\Theme;
use App\Models\Bunting;
use App\Models\Signboard;
use App\Models\Product;
use App\Models\SubCatLevel1;
use App\Models\Profile;
use App\Models\Merchant;
use App\Models\Album;
use App\Models\VBanner;
use App\Http\Models\OshopProduct;

class ProfileSettingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //get album id
        $album_id = Session::get('album_id');

        $themes = Theme::all();
        $buntings = Bunting::all();
        $signboards = Signboard::all();
        $VBanners = VBanner::all();
        $SubCatLevel1 = SubCatLevel1::all();
        $Product = Product::select('product.id' ,
				  'product.name' ,
				  'product.brand_id' ,
				  'product.parent_id' ,
				  'product.category_id' ,
				  'product.subcat_id' ,
				  'product.subcat_level'  ,
				  'product.segment' ,
				  'product.photo_1' ,
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
        $profile_setting = Profile::where('album_id', $album_id)->get();

        $user = Auth::user();
        //dd($user);

        /* If the user is NOT a merchant the code below WILL BOMB out! */
        $merchant = $user->merchant;


        if (is_null($merchant->first()))
            return "<b>Error:</b> User $user->name is NOT a merchant!";

        $merchant_categories = $products = $merchant->first()->categories;

        $profile_products = $profile_setting->first()
            ? $profile_setting->first()->profileproducts
            : collect();

        //$oshopPro = $merchant->first()->oshopproducts;
        $sections = null;
        if ($merchant->first() instanceof Merchant) {
            $sections = $merchant->first()->sections()->get();
        }
//        dd($sections[0]->products);
        $section_products = null;
        if ($merchant->first() instanceof Merchant) {
            if ($merchant->first()->sections()->first() instanceof Section) {
                $section_products = $merchant->first()->sections()->first()->products()->get();
            }
        }
//        dd($section_products);

        $sec_id = session()->get('p_section_id');
        $sec_name = session()->get('p_section_name');
        $datas = session()->get('p_section_data');
        $secs_data = [];
//        print_r(session()->get('p_section_name');

//        return $datas;

        if (!is_null($datas)) {
            foreach ($datas as $data) {
                $sec_data = [];
                if (!empty($data)) {


                    foreach ($data as $c_key => $c_val) {

                        if (!empty($c_val)) {

                            foreach ($c_val as $p_key => $p_val) {

                                App\Models\ProfileProduct::where('profile_id', session()->get('profile_id'))
                                    ->where('product_id', $p_val)->delete();

                                $product = App\Models\Product::find($p_val);

                                array_push($sec_data, $product);
                            }
                        }
                    }

                    array_push($secs_data, $sec_data);
                }
            }
        }
        $profile = Profile::find(session()->get('profile_id'));

        $bunty = Bunting::find(session()->get('updateBunting'));
        if (is_null($bunty) && !is_null($profile)) {
            $bunty = $profile->bunting;
        }
        $signboardupdate = Signboard::find(session()->get('signboard_update'));
        if (is_null($signboardupdate) && !is_null($profile)) {
            $signboardupdate = $profile->signboard;
        }
        $videoBannerUpdate = VBanner::find(session()->get('video_banner_update'));
        if (is_null($videoBannerUpdate) && !is_null($profile)) {
            $videoBannerUpdate = $profile->vbanner;
        }
//        return $sections;
        $smm_quota_max = Merchant::smm_quota_max(Auth::user()->id)->smm_quota_max;
        //dd($smm_quota_max);
        /* Make sure $secs_data is NOT null */
        return view('profilesetting', compact(
            'themes', 'buntings', 'signboards', 'signboardupdate', 'videoBannerUpdate', 'VBanners', 'SubCatLevel1', 'Product', 'profile_setting', 'profile_products', 'merchant_categories', 'section_products', 'sections', 'sec_id', 'sec_name', 'secs_data', 'bunty', 'merchant', 'smm_quota_max'
        ));
    }

    public function saveSelectedProducts(Request $request)
    {
        if (!$request->ajax()) {
            return;
        }
        //Get selected products from profile setting
        $selectedProducts = $request->selectedProducts;

        //Initialize some values
        $output = [];
        $user_id = Auth::user()->id;

        //Merchant with selected products
        $products = Merchant::withSelectedProducts($user_id);

        //Check if user is allowed to select more than smm quota max
        if ($products->count() >= globalSettings('smm_quota_max')) {
            $response = array(
                'status' => 'error',
                'message' => 'You have already selected ' . globalSettings('smm_quota_max')
            );
            return $response;
        }

        Product::whereIn('id', $selectedProducts)->update(array(
            'smm_selected' => 1
        ));

        $response = array(
            'status' => 'success',
            'message' => 'You have successfully selected products for SMM'
        );

        return $response;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postOshopTransfer(Request $request)
    {
        //dd();
        $product_id = $request['id'];
        $profile_id = $request['profile_id'];

        $status = App\Models\ProfileProduct::where('profile_id', $profile_id)
            ->where('product_id', $product_id)->delete();
        dd($profile_id);
        $user = Auth::user();
        $merchant = $user->merchant->first();
        $shop_p = new App\Models\OshopProduct();
        //$shop_p = new App\Models\SectionProduct();
        $shop_p->merchant_id = $merchant->id;
        $shop_p->product_id = $product_id;
        $shop_p->save();

        return response()->json([
            'status' => $status
        ]);
    }

    //---PostName Method---//
    public function postName(Request $request)
    {

        $secs = $request['secs'];

        $user = Auth::user();
        $merchant = $user->merchant->first();
        $data = session()->get('p_section_id');
        $datas = session()->get('p_section_data');
        $newNames = $request['data'];

        if (!is_null($secs)) {
            foreach ($secs as $sec) {
                $section = new Section();
                $section->name = $sec['val'];
                $section->save();
                $oshop = new App\Models\OshopSection();
                $oshop->merchant_id = $merchant->id;
                $oshop->section_id = $section->id;
                $oshop->save();
            }
        }

        if (!$datas == null) {

            foreach ($datas as $k_data => $data) {
                $section = new Section();
                $section->name = $this->name($newNames, $k_data);
                $section->save();

                foreach ($data as $c_key => $c_val) {
                    if (!empty($c_val)) {
                        foreach ($c_val as $p_key => $p_val) {

                            //$section->products()->create(['product_id' => $p_val]);
                            $secProd = new App\Models\SectionProduct();
                            $secProd->section_id = $section->id;
                            $secProd->product_id = $p_val;
                            $secProd->save();

                        }
                    }
                }
                $oshop = new App\Models\OshopSection();
                $oshop->merchant_id = $merchant->id;
                $oshop->section_id = $section->id;
                $oshop->save();
            }


            session()->forget('p_section_id');
            session()->forget('p_section_name');
            session()->forget('p_section_data');
        }

        $update = [];
        $profileId = session()->get('profile_id');
        $bunty = session()->get('updateBunting');
        $signboardupdate = session()->get('signboard_update');
        $videoBannerUpdate = session()->get('video_banner_update');
        if (!(empty($bunty) || $bunty == 'null')) {
            $update['bunting_id'] = $bunty;
        }
        if (!(empty($signboardupdate) || $signboardupdate == 'null')) {
            $update['signboard_id'] = $signboardupdate;
        }
        if (!(empty($videoBannerUpdate) || $videoBannerUpdate == 'null')) {

            $update['vbanner_id'] = $videoBannerUpdate;
        }

        if (!empty($profileId) && !empty($update)) {
            Profile::whereId($profileId)->update($update);
            session()->forget('updateBunting');
            session()->forget('signboard_update');
            session()->forget('video_banner_update');
        }
        return $request->all();
    }

    public function name($newNames, $id)
    {
        foreach ($newNames as $key => $newName) {
            if ($key == $id) {
                return $newName['val'];
            }
        }

        return '';
    }

    //---Name Method---//

    public function postDbname(Request $request)
    {

        $data = $request['data'];


        if (!$data == null) {
            foreach ($data as $c_key => $c_val) {

                Section::where('id', $c_val['id'])
                    ->update(['name' => $c_val['val']]);
            }
            session()->forget('p_section_id');
            session()->forget('p_section_name');
            session()->forget('p_section_data');


            return $request->all();
        }
        return $data;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postOshopTransferBack(Request $request)
    {
        $product_id = $request['id'];
        $profile_id = $request['profile_id'];

        $user = Auth::user();

        $merchant = $user->merchant->first();

//        $status = App\Models\OshopProduct::where('merchant_id', $merchant->id)
//                        ->where('product_id', $product_id)->delete();

        $status = App\Models\SectionProduct::where('merchant_id', $merchant->id)
            ->where('product_id', $product_id)->delete();

        $shop_p = new App\Models\ProfileProduct();
        $shop_p->profile_id = $profile_id;
        $shop_p->product_id = $product_id;
        $shop_p->save();

        return response()->json([
            'status' => $status
        ]);
    }

    //---PostAddSectionProduct Method---//
    public function postAddSectionProduct(Request $request)
    {

        $data = $request->get('data');
        $user = Auth::user();
        $merchant = $user->merchant->first();

        $count = 0;
        $new = 1;
        $productSearch = 0;
        $merchantProCount = 0;

        foreach ($data as $c_key => $c_vel) {

            if (!empty($c_vel)) {
                foreach ($c_vel as $c_key => $c_vel) {

                    if ($new == 1) {

                        $productSearch = Product::find($c_vel);

                        $merchantProCount = $merchant->products()->whereSubcat_id($productSearch->subcat_id)->count();
                    }
                    $newPro = Product::find($c_vel);

                    if ($productSearch->subcat_id == $newPro->subcat_id) {
                        $count++;
                    }
                    $new++;
                }
            }
        }

        if ($merchantProCount == $count) {
//
            session()->push('p_section_data', $data);
            session()->push('p_section_name', $productSearch->subCat->name);
//             return \Illuminate\Support\Facades\Session::all();
            return response()->json([
                'status' => 'true'
            ]);
        } else {
            session()->push('p_section_data', $data);
//
            session()->push('p_section_name', null);

//            return \Illuminate\Support\Facades\Session::all();
            return response()->json([
                'status' => 'true'
            ]);
        }
    }

    //---PostReturn Method---//
    public function postReturn(Request $request)
    {
        $p_id = $request['p_id'];
        $s_id = $request['s_id'];
//        App\Models\SectionProduct::where('section_id',$s_id)
//            ->where('product_id',$p_id)->delete();

        $datas = session()->get('p_section_data');
        $id = session()->get('p_section_id');

        if (!is_null($datas)) {
            foreach ($datas as $d_val => $data) {
                if ($id[$d_val] == $s_id) {
                    foreach ($data as $c_key => $c_val) {
                        if (!empty($c_val)) {
                            foreach ($c_val as $p_key => $p_val) {
                                if ($p_val == $p_id) {
                                    unset($c_val[$p_key]);
                                    $data[$c_key] = $c_val;
                                }
                            }
                        }
                        $datas[$d_val] = $data;
                    }
                }

                session()->forget('p_section_data');
                session()->put('p_section_data', $datas);
            }
        }


        $profile = new App\Models\ProfileProduct();
        $profile->profile_id = session()->get('profile_id');
        $profile->product_id = $p_id;
        $profile->save();

        App\Models\SectionProduct::where('section_id', $s_id)
            ->where('product_id', $p_id)->delete();


        return response()->json([
            'status' => 'true'
        ]);
    }

    public function postSectionSession(Request $request)
    {

        //destroy session variables if exists
        session()->forget('updateBunting');
        session()->forget('signboard_update');
        session()->forget('video_banner_update');

        session()->push('p_section_id', $request['id']);
        if (!empty($request['name'])) {
            session()->push('p_section_name', $request['name']);
        }

        return response()->json([
            'status' => 'true'
        ]);
    }

    public function postRemove(Request $request)
    {

        $sec_id = $request->get('sec_id');
        $db_sec_id = $request->get('db_sec');

        if (!empty($sec_id)) {
            try {
                $allSecId = Session::get('p_section_id');
                $findingValue = array_search($sec_id, $allSecId);
                unset($allSecId[$findingValue]);
                Session::set('p_section_id', $allSecId);
                App\Models\OshopSection::where('section_id', $sec_id)->delete();
                App\Models\SectionProduct::where('section_id', $sec_id)->delete();
            } catch (\Exception $e) {

            }
        }

        if (!is_null($db_sec_id)) {
            Section::destroy($db_sec_id);
            App\Models\OshopSection::where('section_id', $db_sec_id)->delete();
            App\Models\SectionProduct::where('section_id', $db_sec_id)->delete();
        }

        return 'done';
    }

    /*
     * Function for update the bunting signboard and vBanner..
     */

    public function getBadgeUpdate(Request $request, $btn)
    {
        session()->forget('updateBunting');
        session()->forget('signboard_update');
        session()->forget('video_banner_update');

        session()->forget('p_section_id');
        session()->forget('p_section_name');
        session()->forget('p_section_data');

        if ($btn == 'bunting') {
            session()->put('updateBunting', "null");
        } else if ($btn == 'sign-board') {
            session()->put('signboard_update', "null");
        } else if ($btn == 'video-banner') {
            session()->put('video_banner_update', "null");
        } else {
            return false;
        }

        return redirect('/album/profilesetting');
    }

    //---PostBadgeUpdate Method---//
    public function postBadgeUpdate(Request $request)
    {
        $data = $request->all();

//        if ($data['badge'] == 'bunting') {
//            session()->put('updateBunting', $data['id']);
//        } else if ($data['badge'] == 'signboard') {
//            session()->put('signboard_update', $data['id']);
//        } else if ($data['badge'] == 'video-banner') {
//            session()->put('video_banner_update', $data['id']);
//        } else {
//            return response()->json([
//                        'status' => 'false'
//            ]);
//        }


        $update = [];
        //$product_id;
        $profileId = session()->get('profile_id');
        $bunty = $data['bunting_id'];
        $signboardupdate = $data['signboard_id'];
        $videoBannerUpdate = $data['video_id'];
        //$product_id = $data['product_id'];
        $user = Auth::user();
        $merchant = $user->merchant->first();

        if ($bunty != 0) {
            $update['bunting_id'] = $bunty;
        }

        if ($signboardupdate != 0) {
            $update['signboard_id'] = $signboardupdate;
			DB::table('signboard')->
				where('id',$signboardupdate)->
				update(['active'=>true]);

			$sss = DB::table('signboard')->
				where('id',$signboardupdate)->
				first();

			if(!is_null($sss)){
				DB::table('signboard')->
					where('id','<>',$signboardupdate)->
					where('album_id',$sss->album_id)->
					update(['active'=>false]);
			}
        }
        if ($signboardupdate != 0) {
            $update['vbanner_id'] = $videoBannerUpdate;
        }

        if (!empty($profileId) && !empty($update)) {
            Profile::whereId($profileId)->update($update);
        }

        //dd($product_id);
       /* foreach($product_id as $id){
            $product = new App\Models\OshopProduct();
            $product->merchant_id =$merchant->id;
            $product->product_id = $id;
            $product->save();
        }*/

        return response()->json([
            'status' => 'true'
        ]);
    }

    /*
     * Function for updating user profile setting theme,singbord,bunting,VideoBanner
     */

    public function updateSettings(Request $req)
    {
        $id = $req->Id;
        $identifier = $req->Identifier;
        $user = Auth::user()->id;
        $merchantId = Merchant::where('user_id', $user)->first();
        // For now we are passing static user_id in it later we get this from session

        $albumId = Album::where('merchant_id', $merchantId->id)->first();
        $profileTable = Profile::where('album_id', $albumId->id)
            ->update([$identifier => $id]);
//        dd($albumId->id);
        $Signboard = Signboard::where('album_id', $albumId->id)->first();
        $Bunting = Bunting::where('album_id', $albumId->id)->first();
        $vBanner = VBanner::where('album_id', $albumId->id)->first();

        if ($profileTable) {
            $profile_id = Profile::where('album_id', $albumId->id)->first();
            $theme_data = Theme::where('profile_id', $profile_id->id)->get();
        }
        $theme_data['vBanner'] = $vBanner->path;
        $theme_data['Bunting'] = $Bunting->image;
        $theme_data['Signboard'] = $Signboard->image;

        return $theme_data;
    }

    public function addCustomTheme()
    {
        $customValues = Input::All();
//        dd($customValues);
        $user = Auth::user()->id;
        $merchantId = Merchant::where('user_id', $user)->first(); // For now we are passing static user_id in it later we get this from session

        $albumId = Album::where('merchant_id', $merchantId->id)->first();
        $profile_id = Profile::where('album_id', $albumId->id)->first();
        $Signboard = Signboard::where('album_id', $albumId->id)->first();
        $Bunting = Bunting::where('album_id', $albumId->id)->first();
        $vBanner = VBanner::where('album_id', $albumId->id)->first();

        $theme_data = Theme::where('profile_id', $profile_id->id)->first();
        $image = imagecreatefrompng('images/opensupermall_customtheme.png');

        $text_colour = imagecolorallocate($image, 255, 255, 255); //Defined the text color for working with string on the images.

        $font_file = 'fonts/font5.TTF'; //This will Load the font file.

        $x_axis = 60;
        $y_axis = 150;
        $imagebgColor = "<input type='textarea' style='background-color:" . $customValues['bg_color'] . "'>";

        imagefttext($image, 11, 0, 20, 130, $text_colour, $font_file, $customValues['bg_color'] .
            " as Bg color");
        imagefttext($image, 11, 0, 15, 175, $text_colour, $font_file, $customValues['font_family'] .
            " font family");
        imagefttext($image, 11, 0, 15, 235, $text_colour, $font_file, $customValues['font_color'] .
            " font color");
        imagefttext($image, 11, 0, 15, 290, $text_colour, $font_file, $customValues['font_style'] .
            " font style");

        imagepng($image, "images/" . $merchantId->id . "_customTheme.png");
        imagedestroy($image);


        $customValues['profile_id'] = $profile_id->id;
        $customValues['image'] = $merchantId->id . "_customTheme.png";
        //dd($customValues);

        if (!$theme_data) {
            $newTheme = Theme::create($customValues);
        } else {
            $newTheme = Theme::where('id', $theme_data->id)->update($customValues);
        }
        if ($newTheme) {
            $newTheme['vBanner'] = $vBanner->path;
            $newTheme['Bunting'] = $Bunting->image;
            $newTheme['Signboard'] = $Signboard->image;
            return Response::json(array($customValues));
        } else {
            return 0;
        }
    }

    function profilesettingaboutus(Request $request, $id){

        $merchant = Merchant::find($id);


        if(!$merchant){
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        //dd($merchant->teams);

        return view('profilesettingaboutus')->with('merchant', $merchant);
    }

    function profilesettingcertificate(Request $request, $id){

        $merchant = Merchant::find($id);


        if(!$merchant){
            $request->session()->flash('message', 'Cant find these merchant');
            return redirect()->back();
        }

        //dd($merchant->teams);

        return view('profilesettingcertificate')->with('merchant', $merchant);
    }

}
