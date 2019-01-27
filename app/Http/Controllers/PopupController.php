<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Brand;
use App\Models\MerchantDocument;
use App\Models\Document;
use App\Models\StationDocument;
use App\Models\Station;
use App\Models\Merchant;
use App\Models\StationBrand;
use App\Models\Address;
use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\SMMin;
use App\Models\SMMout;
use App\Models\Product;
use App\Models\Autolink;
use App\Models\Website;
use App\Models\Buyer;
use App\Models\Occupation;
use App\Models\Language;
use App\Models\BuyerCategory;
use DateTime;
use App\lib\Date;
use Mailgun\Mailgun;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendmail(Request $request){
		$mgClient = new Mailgun('key-80495c8905443d885803333b49b45718');
		$domain = "opensupermall.com";

		# Make the call to the client.
		$result = $mgClient->sendMessage($domain, array(
			'from'    => 'Excited User <mailgun@opensupermall.com>',
			'to'      => 'Baz <waisun@sqci.biz>',
			'subject' => 'Hello',
			'text'    => 'Testing some Mailgun awesomeness!'
		));
		return json_encode($result);
	}

    public function user($id)
    {
        $buyer_img = false;
        $user_id = $id;
        $buyer = Buyer::where('user_id', $user_id)->first();
        $buyerinfo = Buyer::where('user_id', $user_id)->first();

        try {
            $buyer_image = $buyer->photo_1;
            $image = "images/users/" . $user_id . "/" . $buyer_image;
            $buyer_img = true;
        } catch (\Exception $e) {
            echo "<script> console.log('Exception:Image not found'); </script>";
            $image = "images/placecards/dummy.jpg";
        }


        $smmProducts = SMMout::withPosts($user_id);

        $dateObj = new Date();
        $userObj = new User();
        // $userModel = $userObj->with('merchant', 'occupation', 'merchant.address', 'merchant.city')->where('id', '=', $u->id)->get()->first();
        // $userModel->age = 12;//$dateObj->age(new DateTime($u->birthdate),null,true);
        // return $user_id;
        $user = User::where('id', $user_id)->first(); //?Why this returns a list
        // return $user;
		if($user == null){
			 return redirect()->route('home');
		} else {
			if ($user->first_name == null and $user->last_name == null) {
				$name = $user->name;

			} elseif ($user->first_name != null and $user->last_name != null) {
				$name = $user->first_name . " " . $user->last_name;
			} elseif ($user->last_name == null and $user->name == null) {
				$name = $user->first_name;
			} elseif ($user->name != null and $user->first_name != null) {
				# code...
				$name = $user->name;
			} elseif ($user->first_name == null and $user->name == null) {
				# code...
				$name = $user->last_name;
			} elseif ($user->first_name == null and $user->name != null) {
				# code...
				$name = $user->name;
			} elseif ($user->name == null and $user->first_name == null and $user->last_name == null) {
				# code...
				$name = "John Doe"; //? Get the joke??
			}

			$member_since = $user->created_at->format('d/m/Y');
			$dob = $user->birthdate;

			try {
				$dob_f = new DateTime($dob);
				$today = new DateTime('today');

				$age = $dob_f->diff($today)->y;
			} catch (\Exception $e) {

				$age = "";
				echo "<script>console.log('Invalid Birthdate or Birthdate is string in users table');</script>";
			}

			try {
				$occupation = Occupation::where('id', $user->occupation_id)->first()->name;
			} catch (\Exception $e) {
				$occupation = "---";
				echo "<script>console.log('Occupation id not found');</script>";
			}

			$language = Language::where('id', '1')->get()[0]->description;
			$bi = BuyerCategory::where('user_id', $user_id)->get(); //returns an array.for buyer interests
			$t = "subcat_level_"; //temp variable
			$interests = "";

			// $bi= (array)$bi;
			try {
				$filter = $bi->subcat_level;
				if (!empty($bi)) {
					foreach ($bi as $b) {
						if ($b->subcat_level_ == '0') {
							$interest = DB::table('category')->where('id', $b->subcat_id)->pluck('description');
							$interests = $interests . " " . $interest;
						} elseif ($b->subcat_level_ == "?") {

						} else {
							$table = $t . $b->subcat_level;
							$interest = DB::table($table)->where('id', $b->subcat_id)->pluck('description');
							$interests = $interests . " " . $interest;
						}
					}
				} else {
					$interests = "No interest specified";
				}

			} catch (\Exception $e) {
				$interests = "No interest specified";
			}

			// return $interests;
			try {
				$billing_address = Address::where(['id' => $user->billing_address_id])->get()[0];//ba
			} catch (\Exception $e) {
				echo "<script>console.log('No Billing Address Found');</script>";
				$billing_address = "";
			}

			try {
				$default_address = Address::where(['id' => $user->default_address_id])->get()[0]; //da
			} catch (\Exception $e) {
				echo "<script>console.log('No Default Address Found');</script>";
				$default_address = "";
			}
			//Buyer
			try {
				$buyer = Buyer::where('user_id', $user_id);
			} catch (\Exception $e) {
				echo "<script>console.log('No Buyer Detail Found');</script>";
			}

			// AUTOLINK

		   $a_links= $this->get_autolink($user_id);
		   // return $a_links;
		   $porders = DB::table('porder')->where('user_id', $user_id)->get();
			//Shipping

		   $couriers=$this->get_shipping($porders,false);
			// return $porders;
			// Product
			$products= $this->products($porders,$id);

			// AUTOLINKS
			// $autolinks= null;
			// try {

			// } catch (\Exception $e) {

			// }
			// return $products;
			// return $couriers;
			return view('popup.user', ['buyerinfo' => $buyerinfo, 'name' => $name, 'user_id' => $id, 'image' => $image, 'products' => $products, 'couriers' => $couriers, 'autolinks' => $a_links, 'user' => $user, 'smmProducts' => $smmProducts, 'occupation' => $occupation, 'age' => $age, 'member_since' => $member_since, 'language' => $language, 'interests' => $interests, 'ba' => $billing_address, 'da' => $default_address]);
		}

               // ->with('userModel', $userModel)
    }

    public function station($id){
            $indication = "station";
            $disabled = 'disabled';
            $route = route('edit-merchant');
            // User,Bank,Address,Merchant,Brand,Website, and Director
            $userObj = new User();
            $userModel = $userObj->with(['station', 'station.bankaccount', 'station.address', 'station.brand', 'station.websites'])->where('id', '=', $id)->get()->first();
			$userModel = $this->reShapeStationModel($userModel, $id);

            $stationID = $id;

            try {
				$station_docs = StationDocument::where('station_id',$stationID->id)->select('document_id')->get();
            }catch(\Exception $e){
                $e;
            }

            if(isset($station_docs)){
                $count = count($station_docs);
                try{
                    for ($i=0; $i < $count ; $i++) {
                        $doc[$i] = Document::where('id', $station_docs[$i]->document_id)->first();
                    }
                }catch(\Exception $ex){
                }
            }
            // By default it is type Collection
            $brand_table = Brand::all();
            $isbrand = true;

			return view('popup.station', compact(['indication', 'route', 'disabled', 'userModel', 'doc', 'brand_table', 'isbrand']));

    }

    public function merchant($id)
    {

        $indication = "merchant";
        $disabled = 'disabled';
        $route = route('edit-merchant');
        // User,Bank,Address,Merchant,Brand,Website, and Director
        $merch = Merchant::where('id',$id)->first();

        $userObj = new User();


        $userModel = $userObj->with(['merchant', 'merchant.bankaccount', 'merchant.address', 'merchant.brand', 'merchant.websites','merchant.socialmedia', 'merchant.directorsInEditView'])->where('id', '=', $merch->user_id)->get()->first();

        $userModel = $this->reShapeMasterMerchantModel($userModel, $id);

        $mer_doc = MerchantDocument::all();
        $doc = Document::all();

        // By default it is type Collection
        $brand_table = Brand::all();
        $bank= $userModel;
        // return $bank;
        $isbrand = true;



        return view('popup.merchant', compact(['indication', 'route', 'disabled', 'userModel', 'mer_doc', 'doc', 'brand_table', 'isbrand']));
    }

    public function order()
    {
        //
        $modal_name = "order";
        return view('popup.order', ['modal_name'=>$modal_name]);
    }

    public function reShapeStationModel($stationModel, $id)
    {
        $stationObj = new Station();
        $userModel = $stationObj->getStationRelationsFullMeta();

        // dd($stationModel['station'][0]['directorsInEditView']);

        $station =  isset($stationModel['station'] ) ?  $stationModel['station'] : null;
        $bank =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['bank_id'] ) ?  [$stationModel['station'][0]['bank_id']] : null ):null ;//dd($merchantModel);
        $address =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['address_id'] ) ?  [$stationModel['station'][0]['address_id']] : null):null;
        $brand =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['brand'] ) ?  $stationModel['station'][0]['brand'] : null):null;
        $websites =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['websites'] ) ?  $stationModel['station'][0]['websites'] : null):null;
        $directors =  count($stationModel['station']) > 0 ? (isset($stationModel['station'][0]['directorsInEditView'] ) ?  $stationModel['station'][0]['directorsInEditView'] : null):null;

        $stationArr = null;
        $bankArr = null;
        $addressArr = null;
        $brandArr = null;
        $websitesArr = null;
        $directorsArr = null;

        if(!is_null( $station))
        foreach($station as $data)
        {
            $stationArr[]=[
                "id" => isset($data->id) ?  $data->id: null,
                "user_id" => isset($data->user_id) ?  $data->user_id: null,
                "company_name" =>
                    isset($data->company_name) ?$data->company_name  : null,
                "gst" => isset($data->gst) ? $data->gst : null,
                "business_reg_no" =>
                    isset($data->business_reg_no) ? $data->business_reg_no : null,
                "country_id" => isset($data->country_id) ? $data->country_id : null,
                "business_type" =>
                    isset($data->business_type) ? $data->business_type : null,
                "address_id" =>
                    isset($data->address_id) ?  $data->address_id: null,
                "contact_person" =>
                    isset($data->contact_person) ?  $data->contact_person: null,
                "office_no" => isset($data->office_no) ?  $data->office_no: null,
                "mobile_no" => isset($data->mobile_no) ?  $data->mobile_no: null,
                "oshop_name" => isset($data->oshop_name) ? $data->oshop_name : null,
                "oshop_logo_1" =>
                    isset($data->oshop_logo_1) ? $data->oshop_logo_1 : null,
                "oshop_logo_2" =>
                    isset($data->oshop_logo_2) ?  $data->oshop_logo_2: null,
                "oshop_logo_3" =>
                    isset($data->oshop_logo_3) ?  $data->oshop_logo_3: null,
                "oshop_logo_4" =>
                    isset($data->oshop_logo_4) ? $data->oshop_logo_4 : null,
                "oshop_logo_5" =>
                    isset($data->oshop_logo_5) ?  $data->oshop_logo_5: null,
                "oshop_adimage_1" =>
                    isset($data->oshop_adimage_1) ? $data->oshop_adimage_1: null,
                "oshop_adimage_2" =>
                    isset($data->oshop_adimage_2) ? $data->oshop_adimage_2: null,
                "oshop_adimage_3" =>
                    isset($data->oshop_adimage_3) ?  $data->oshop_adimage_3: null,
                "oshop_adimage_4" =>
                    isset($data->oshop_adimage_4) ? $data->oshop_adimage_4 : null,
                "oshop_adimage_5" =>
                    isset($data->oshop_adimage_5) ? $data->oshop_adimage_5 : null,
                "description" =>
                    isset($data->description) ? $data->description : null,
                "history" => isset($data->history) ?  $data->history: null,
                "license" => isset($data->license) ?  $data->license: null,
                "coverage" => isset($data->coverage) ? $data->coverage : null,
                "ownership" => isset($data->ownership) ? $data->ownership : null,
                "category_id" =>
                    isset($data->category_id) ? $data->category_id : null,
                "planned_sales" =>
                    isset($data->planned_sales) ? $data->planned_sales : null,
                "bank_id" => isset($data->bank_id) ? $data->bank_id : null,
                "return_policy" =>
                    isset($data->return_policy) ? $data->return_policy : null,
                "remarks" => isset($data->remarks) ? $data->remarks : null,
                "deleted_at" => isset($data->deleted_at) ? $data->deleted_at : null,
                "created_at" => isset($data->created_at) ?  $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }

        if(!is_null($bank))
        foreach($bank  as $data)
        {
            $data = BankAccount::find($data);

            $bankArr[] = [
                "id" => isset($data->id) ?  $data->id: null,
                "name" => isset($data->name) ?  $data->name: null,
                "code" => isset($data->code) ?  $data->code: null,
                "account_name1" => isset($data->account_name1) ?    $data->account_name1: null,
                "account_number1" => isset($data->account_number1) ?    $data->account_number1: null,
                "account_name2" => isset($data->account_name2) ?    $data->account_name2: null,
                "account_number2" => isset($data->account_number2) ?    $data->account_number2: null,
                "iban" => isset($data->iban) ?  $data->iban: null,
                "swift" => isset($data->swift) ?    $data->swift: null,
                "url" => isset($data->url) ?    $data->url: null,
                "description" => isset($data->description) ?    $data->description: null,
                "deleted_at" => isset($data->deleted_at) ?    $data->deleted_at: null,
                "created_at" => isset($data->created_at) ?  $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }

        if(!is_null($address))
        foreach($address  as $data)
        {
            $data = Address::find($data);

            $addressArr[] = [
                "id" => isset($data->id) ? $data->id : null,
                "city_id" => isset($data->city_id) ? $data->city_id: null,
                "postcode" => isset($data->postcode) ? $data->postcode: null,
                "line1" => isset($data->line1) ? $data->line1: null,
                "line2" => isset($data->line2) ? $data->line2: null,
                "line3" =>isset($data->line3) ? $data->line3: null,
                "line4" => isset($data->line4) ? $data->line4: null,
                "type" => isset($data->type) ?  $data->type: null,
                "deleted_at" => isset($data->deleted_at) ?    $data->deleted_at: null,
                "created_at" => isset($data->created_at) ? $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }

         if(!is_null($brand))
        foreach($brand  as $data)
        {
            $brandArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "description" => isset($data->description) ?$data->description: null,
                "logo" => isset($data->logo) ?$data->logo: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($websites))
        foreach($websites  as $data)
        {
            $websitesArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "description" => isset($data->description) ?$data->description: null,
                "url" => isset($data->url) ?$data->url: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($directors))
        foreach($directors  as $data)
        {
            $doc = DB::table('directordocument')
                ->join('document','document.id','=','directordocument.document_id')
                ->where('directordocument.director_id',$data->id)
                ->first();
            $directorsArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "merchant_id" => isset($data->merchant_id) ?$data->merchant_id: null,
                "country_id" => isset($data->country_id) ?$data->country_id: null,
                "name" => isset($data->name) ?$data->name: null,
                "nric" => isset($data->nric) ?$data->nric: null,
                "photo_1" => isset($data->photo_1) ?$data->photo_1: null,
                "photo_2" => isset($data->photo_2) ?$data->photo_2: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
                "doc" => isset($doc->path)?$doc->path:null
            ];
        }


        $userModel = [
          "user" =>[
            "id" => isset($stationModel['id']) ? $stationModel['id'] : null ,
            "occupation_id" => isset($stationModel['occupation_id']) ? $stationModel['occupation_id'] : null ,
            "first_name" => isset($stationModel['first_name']) ? $stationModel['first_name'] : null ,
            "last_name" =>  isset($stationModel['last_name']) ? $stationModel['last_name'] : null,
            "birthdate" => isset($stationModel['birthdate']) ? $stationModel['birthdate'] : null ,
            "mobile_no" => isset($stationModel['mobile_no']) ? $stationModel['mobile_no'] : null ,
            "email" =>  isset($stationModel['email']) ? $stationModel['email'] : null,
            "password" => isset($stationModel['password']) ? $stationModel['password'] : null ,
            "gender" =>  isset($stationModel['gender']) ?  $stationModel['gender']: null,
            "annual_income" => isset($stationModel['annual_income']) ?$stationModel['annual_income']  : null,
            "salutation" =>  isset($stationModel['salutation']) ? $stationModel['salutation'] : null,
            "type" =>  isset($stationModel['type']) ? $stationModel['type'] : null,
            "deleted_at" =>  isset($stationModel['deleted_at']) ?  $stationModel['deleted_at']: null,
            "created_at" => isset($stationModel['created_at']) ? $stationModel['created_at'] : null,
            "updated_at" => isset($stationModel['updated_at']) ?  $stationModel['updated_at']: null
            ],
          "station" => $stationArr,
          "bank" => $bankArr,
          "address" =>$addressArr,
          "brand" =>$brandArr,
          "websites" =>$websitesArr ,
          "directorsInEditView" => $directorsArr
        ];

        return $userModel;
    }

    public function reShapeMasterMerchantModel($merchantModel, $id)
    {
        $merchant1= Merchant::where('id',$id)->first();

         //dd($merchant1);
        $mid= $merchant1->id;


        $merchantObj = new Merchant();
        $userModel = $merchantObj->getMerchantRelationsFullMeta();

       $bankaccount_id= $merchant1->bankaccount_id;

       $bank= BankAccount::where('id',$bankaccount_id)->get();

        $merchant =  isset($merchantModel['merchant'] ) ?  $merchantModel['merchant'] : null;

        $address =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['address'] ) ?  [$merchantModel['merchant'][0]['address']] : null):null;
        // $brand =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['brand'] ) ?  $merchantModel['merchant'][0]['brand'] : null):null;

        // return $mid;
        $brand_raw= DB::table("merchantbrand")->where('merchant_id',$mid)->get();
        $brand_id_array=array();
        foreach ($brand_raw as $b) {
            # code...
            array_push($brand_id_array, $b->id);
        }
        $brand=Brand::whereIn('id',$brand_id_array)->get();
        // return $brand;
        $websites =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['websites'] ) ?  $merchantModel['merchant'][0]['websites'] : null):null;
        $social_media =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['socialmedia'] ) ?  $merchantModel['merchant'][0]['socialmedia'] : null):null;

        $directors =  count($merchantModel['merchant']) > 0 ? (isset($merchantModel['merchant'][0]['directorsInEditView'] ) ?  $merchantModel['merchant'][0]['directorsInEditView'] : null):null;
        // return $brand;

        $merchantArr = null;
        $bankArr = null;
        $addressArr = null;
        $brandArr = null;
        $websitesArr = null;
        $socialmediaArr = null;
        $directorsArr = null;

        if(!is_null( $merchant))
        foreach($merchant as $data)
        {
            $merchantArr[]=[
                "id" => isset($data->id) ?  $data->id: null,
                "user_id" => isset($data->user_id) ?  $data->user_id: null,
                "company_name" =>
                    isset($data->company_name) ?$data->company_name  : null,
                "gst" => isset($data->gst) ? $data->gst : null,
                "business_reg_no" =>
                    isset($data->business_reg_no) ? $data->business_reg_no : null,
                "country_id" => isset($data->country_id) ? $data->country_id : null,
                "business_type" =>
                    isset($data->business_type) ? $data->business_type : null,
                "address_id" =>
                    isset($data->address_id) ?  $data->address_id: null,
                "contact_person" =>
                    isset($data->contact_person) ?  $data->contact_person: null,
                "office_no" => isset($data->office_no) ?  $data->office_no: null,
                "mobile_no" => isset($data->mobile_no) ?  $data->mobile_no: null,
                "oshop_name" => isset($data->oshop_name) ? $data->oshop_name : null,
                "oshop_logo_1" =>
                    isset($data->oshop_logo_1) ? $data->oshop_logo_1 : null,
                "oshop_logo_2" =>
                    isset($data->oshop_logo_2) ?  $data->oshop_logo_2: null,
                "oshop_logo_3" =>
                    isset($data->oshop_logo_3) ?  $data->oshop_logo_3: null,
                "oshop_logo_4" =>
                    isset($data->oshop_logo_4) ? $data->oshop_logo_4 : null,
                "oshop_logo_5" =>
                    isset($data->oshop_logo_5) ?  $data->oshop_logo_5: null,
                "oshop_adimage_1" =>
                    isset($data->oshop_adimage_1) ? $data->oshop_adimage_1: null,
                "oshop_adimage_2" =>
                    isset($data->oshop_adimage_2) ? $data->oshop_adimage_2: null,
                "oshop_adimage_3" =>
                    isset($data->oshop_adimage_3) ?  $data->oshop_adimage_3: null,
                "oshop_adimage_4" =>
                    isset($data->oshop_adimage_4) ? $data->oshop_adimage_4 : null,
                "oshop_adimage_5" =>
                    isset($data->oshop_adimage_5) ? $data->oshop_adimage_5 : null,
                "description" =>
                    isset($data->description) ? $data->description : null,
                "history" => isset($data->history) ?  $data->history: null,
                "license" => isset($data->license) ?  $data->license: null,
                "coverage" => isset($data->coverage) ? $data->coverage : null,
                "ownership" => isset($data->ownership) ? $data->ownership : null,
                "category_id" =>
                    isset($data->category_id) ? $data->category_id : null,
                "planned_sales" =>
                    isset($data->planned_sales) ? $data->planned_sales : null,
                "bank_id" => isset($data->bank_id) ? $data->bank_id : null,
                "return_policy" =>
                    isset($data->return_policy) ? $data->return_policy : null,
                "remarks" => isset($data->remarks) ? $data->remarks : null,
                "deleted_at" => isset($data->deleted_at) ? $data->deleted_at : null,
                "created_at" => isset($data->created_at) ?  $data->created_at: null,
                "updated_at" => isset($data->updated_at) ?  $data->updated_at: null
            ];
        }


        if(!is_null($bank))
        foreach($bank  as $data)
        {
            // $b= BankAccount::find($data);
            $b=Bank::where('id',$data->bank_id)->first();

            $bankArr[] = [

                "id" => isset($data->id) ?$data->id: null,
                "name" => $b->name,
                "code" => $b->code,
                "account_name1" => isset($data->account_name1) ?$data->account_name1: null,
                "account_number1" => isset($data->account_number1) ?$data->account_number1: null,
                "account_name2" => isset($data->account_name2) ?$data->account_name2: null,
                "account_number2" => isset($data->account_number2) ?$data->account_number2: null,
                "iban" => isset($data->iban) ?$data->iban: null,
                "swift" => isset($data->swift) ?$data->swift: null,
                "url" => isset($data->url) ?$data->url: null,
                "description" => isset($data->description) ?$data->description: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($address))
        foreach($address  as $data)
        {
            $addressArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "city_id" => isset($data->city_id) ?$data->city_id: null,
                "postcode" => isset($data->postcode) ?$data->postcode: null,
                "line1" => isset($data->line1) ?$data->line1: null,
                "line2" => isset($data->line2) ?$data->line2: null,
                "line3" =>isset($data->line3) ?$data->line3: null,
                "line4" => isset($data->line4) ?$data->line4: null,
                "type" => isset($data->type) ?$data->type: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

         if(!is_null($brand))
        foreach($brand  as $data)
        {

            $brandArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "description" => isset($data->description) ?$data->description: null,
                "logo" => isset($data->logo) ?$data->logo: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($websites))
        foreach($websites  as $data)
        {
            $websitesArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "type" => isset($data->type) ?$data->type: null,
                "description" => isset($data->description) ?$data->description: null,
                "url" => isset($data->url) ?$data->url: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($social_media))
        foreach($social_media  as $data)
        {
            $socialmediaArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "name" => isset($data->name) ?$data->name: null,
                "description" => isset($data->description) ?$data->description: null,
                "url" => isset($data->url) ?$data->url: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null
            ];
        }

        if(!is_null($directors))
        foreach($directors  as $data)
        {
            $doc = DB::table('directordocument')
                ->join('document','document.id','=','directordocument.document_id')
                ->where('directordocument.director_id',$data->id)
                ->first();
            $directorsArr[] = [
                "id" => isset($data->id) ?$data->id: null,
                "merchant_id" => isset($data->merchant_id) ?$data->merchant_id: null,
                "country_id" => isset($data->country_id) ?$data->country_id: null,
                "name" => isset($data->name) ?$data->name: null,
                "nric" => isset($data->nric) ?$data->nric: null,
                "photo_1" => isset($data->photo_1) ?$data->photo_1: null,
                "photo_2" => isset($data->photo_2) ?$data->photo_2: null,
                "deleted_at" => isset($data->deleted_at) ?$data->deleted_at: null,
                "created_at" => isset($data->created_at) ?$data->created_at: null,
                "updated_at" => isset($data->updated_at) ?$data->updated_at: null,
                "doc" => isset($doc->path)?$doc->path:null
            ];
        }

        $userModel = [
          "user" =>[
            "id" => isset($merchantModel['id']) ? $merchantModel['id'] : null ,
            "occupation_id" => isset($merchantModel['occupation_id']) ? $merchantModel['occupation_id'] : null ,
            "first_name" => isset($merchantModel['first_name']) ? $merchantModel['first_name'] : null ,
            "last_name" =>  isset($merchantModel['last_name']) ? $merchantModel['last_name'] : null,
            "birthdate" => isset($merchantModel['birthdate']) ? $merchantModel['birthdate'] : null ,
            "mobile_no" => isset($merchantModel['mobile_no']) ? $merchantModel['mobile_no'] : null ,
            "email" =>  isset($merchantModel['email']) ? $merchantModel['email'] : null,
            "password" => isset($merchantModel['password']) ? $merchantModel['password'] : null ,
            "gender" =>  isset($merchantModel['gender']) ?  $merchantModel['gender']: null,
            "annual_income" => isset($merchantModel['annual_income']) ?$merchantModel['annual_income']  : null,
            "salutation" =>  isset($merchantModel['salutation']) ? $merchantModel['salutation'] : null,
            "type" =>  isset($merchantModel['type']) ? $merchantModel['type'] : null,
            "deleted_at" =>  isset($merchantModel['deleted_at']) ?  $merchantModel['deleted_at']: null,
            "created_at" => isset($merchantModel['created_at']) ? $merchantModel['created_at'] : null,
            "updated_at" => isset($merchantModel['updated_at']) ?  $merchantModel['updated_at']: null
            ],
          "merchant" => $merchantArr,
          "bank" => $bankArr,
          "address" =>$addressArr,
          "brand" =>$brandArr,
          "websites" =>$websitesArr ,
          "socialmedia"=>$socialmediaArr,
          "directorsInEditView" => $directorsArr
        ];

        return $userModel;
    }

    public function get_autolink($user_id)
    {
        # code...
         try {
            $autolinks = Autolink::where('initiator', $user_id)->get();


            $autolinks[0];//Just to check if there is any autolink

            $a_links = array();
            foreach ($autolinks as $link) {
                $temp = array();
                $temp['id'] = $link->id;
                $temp['merchant_id'] = $link->responder;
                $temp['linked_since'] = $link->linked_since;
                $temp['rid'] = $link->responder;
				$mname = Merchant::where('id', $link->responder)->pluck('company_name');

                $temp['mname'] = $mname;
                $temp['status'] = $link->status;

                try {
                    $temp ['l_s'] = $link->linked_since;

                    $temp['deleted_at'] = $link->deleted_at;
                } catch (\Exception $e) {

                    // echo "<script> console.log('Exception: Bad Linked-Since Date'); </script>";

                }
                array_push($a_links, $temp);

            }

        } catch (\Exception $e) {
            $a_links = array();
            // echo "<script> console.log('Exception:Autolink not found'); </script>";
            // return "Please fill up the autolink table and connect with your user id";
        }
        return $a_links;
    }
    public function get_shipping($porders,$porder=false)
    {
        # code...
        $couriers = array();
        try {
            // $porders = DB::table('porder')->where('user_id', $user_id)->get();


            foreach ($porders as $id) {
                $courier = DB::table('courier')->where('shipping_id', $id->courier_id)->first();
                if ($porder==true) {
                    # code...
                    $courier->porder_id= $id->id;
                } else {
                    # code...
                }

                array_push($couriers, $courier);
            }
        } catch (\Exception $e) {

        }
        return $couriers;
    }

    public function products($porders,$id,$payment=false)
    {
        # code...

        $products = array();

        foreach ($porders as $order) {
            try {
                $odata = DB::table('orderproduct')->where('porder_id', $order->id)->first();
                $pdata = DB::table('product')->where('id', $odata->product_id)->first();//product detail

                // return $pdata->name;

                //
                if ($pdata->subcat_level == '0') {
                    $cat2 = DB::table('category')->where('id', $pdata->category_id)->pluck('name');
                } else {
                    try {
                        $table = 'subcat_level_' . $link->subcat_level;
                        $totaldata = DB::table($table)->where('id', $link->subcat_id)->first();
                        $catdata = DB::table('category')->where('id', $totaldata->category_id)->first();
                        $cat2 = $catdata->name;
                        $subcat2 = $totaldata->description;
                    } catch (\Exception $e) {
                        $cat2 = "Not Found";
                        $subcat2 = "Not Found";
                    }
                }
                $commission= Product::where('id',$pdata->id)->pluck('osmall_commission');
                if (is_null($commission)) {
                    # code...
                    $m= new MerchantDashboardController;
                    $user_id=$id;
                    $commission= $m->get_merchant_commission($user_id);
                }
                $temp = array();
                $temp['pname'] = $pdata->name; //
                $temp['oid'] = $order->id;//Order ID
                $temp['quantity'] = $odata->quantity;
                $temp['orig_price'] = $pdata->retail_price;
                $temp['retail_price'] = $pdata->original_price;
                $temp['o_rcv'] = $order->delivery_tstamp;
                $temp['o_exec'] = $order->created_at;
                $temp['uid'] = $order->user_id;
                $temp['source'] = $cat2;
                $temp['sku'] = $pdata->id; //product id
                $temp['comm']=$commission;
                if ($payment==true) {
                    # code...
                    $pay = DB::table('payment')->where('id',$order->payment_id)->first();
                }
                $temp['payment']=$pay;
                array_push($products, $temp);
            } catch (\Exception $e) {
                // echo "<script> console.log('Exception:Product not found' ); </script>";
            }
        }
        return $products;
    }
}
