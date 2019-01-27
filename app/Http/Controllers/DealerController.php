<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
// use App\Models\
use App\Models\Product;
use App\Models\Wholesale;
use App\Models\Merchant;
use App\Models\Autolink;
use Auth;
use DB;
/* 
Get correct dealer
Get correct checkboxes
fix the autolink button

*/
class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // $id as input is merchant_id
        $user_id= Auth::user()->id;
        $merchant_user_id= Merchant::where('id',$id)->first()->id;
        //Check for autolink 
        $autolink= Autolink::where('initiator',$user_id)->where('responder',$merchant_user_id)->where('status','linked')->first();
        if (empty($autolink)) {
            # code...
            return "You are not authorised to view this dealer's page";
        }
        return $this->show_page($id);
    }
    public function show_page($id)
    {
        # code...
        // $merchant = Merchant::relatedProducts($id);
      
        //Lazy loading
        $merchant = Merchant::with('categories')->find($id);
        // $merchant_pro = Merchant::find($id);
        // $oshopsection=DB::table("oshopsection")->where('merchant_id',$id)->get();
        // return $oshopsection;
        
        // Get Album ID 
        try{
            $album = DB::table('album')->where('merchant_id',$id)->first();
            $album_id= $album->id;
        }catch(\Exception $e){
            $album_id=false;
        }
        //Get Profile ID

        try {
            $profile = DB::table('profile')->where('album_id',$album_id)->first();
            $profile_id=$profile->id;
        } catch (\Exception $e) {
            $profile_id=false;    
        }
        //Get theme 
        if ($profile_id!=false) {
            # code...
               try {
                    $theme= DB::table('theme')->where('profile_id',$profile_id)->firstorFail();
                    } catch (\Exception $e) {
                        $theme= null;
                    }
        }
        if ($album_id!=false) {
            //Signboard
            try {
                $signboard=DB::table('signboard')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $signboard=null;
            }
            //Bunting
            try {
                $bunting= DB::table('bunting')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $bunting=null;
            }
            //Vbanner
            try {
                $vbanner=DB::table('vbanner')->where('album_id',$album_id)->first();
            } catch (\Exception $e) {
                $vbanner=null;
            }
        }
        //Get all section for the merchant
        /*=====================
        try {
            $section_all= DB::table('oshopsection')->where('merchant_id',$id)->get();
            $section_all[0]; //check for fail
        } catch (\Exception $e) {
            $section_all=false;
        }
        ************/
        //Get section name
        /*=====================
        $section_names= array(); 
        try {
            $section_all[0];
        } catch (\Exception $e) {
          return "No sections found";   
        }
        ======================*/
        /*========================
        foreach ($section_all as $s) {
            try{
            $sec=DB::table('section')->where('id',$s->section_id)->first();
            // Check if there is a product for this section;

            $name=$sec->name;
            array_push($section_names, $name);
                }catch(\Exception $e){
                    return "Error";
                }
        }
        ========================*/
        // return $section_names;
        $products= array();
        //if ($section_all!=false) {
            //foreach ($section_all as $section) {
             
                //Get all product for a particular section
                //$product_idsForaSection=DB::table('sectionproduct')->where('section_id',$section->id)->get();
        $product_idsForaSection=DB::table('merchantproduct')->where('merchant_id',$id)->get();
                foreach ($product_idsForaSection as $product_id) {
                    $product=Product::find($product_id->id);
                    $prices=Wholesale::where('product_id',$product->id)->get();
                    $temp2=array();
                    //$temp2['section']=DB::table('section')->where('id',$section->section_id)->first();
                    $temp2['product']=$product;
                    $temp2['price']=$prices;
                    array_push($products, $temp2);
                    
                }
                // array_push($products,$temp2);

            //}
        //}
        $oshop_template=DB::table('oshop_template')->where('merchant_id',$id)->first();
        if (count($oshop_template)) {
            # There is a template
            $viewpath="oshop.template.oshop_".$oshop_template->blade_file."_template";
            $custom_data_table=null;
            $custom_data_table=$oshop_template->data_table;
            if (count($custom_data_table)) {
                $custom_data= DB::table($custom_data_table)->get();
            }
             return view($viewpath)
            ->with('merchant',$merchant)
            ->with('theme',$theme)
            ->with('bunting',$bunting)
            ->with('vbanner',$vbanner)
            ->with('signboard',$signboard)
            ->with('products',$products)
            ->with('type','dealer')
            ->with('section',$section_names)
            ->with('id',$id)
            ->with('custom_data',$custom_data);

        }
        // return $bunting->id;
        return view('dealer.index')
            ->with('merchant',$merchant)
            ->with('theme',$theme)
            ->with('bunting',$bunting)
            ->with('vbanner',$vbanner)
            ->with('signboard',$signboard)
            ->with('products',$products)
            ->with('type','dealer')
            ->with('section',$section_names)
            ->with('id',$id);
    }
    
}
