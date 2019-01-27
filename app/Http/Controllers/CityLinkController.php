<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IdController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UtilityController;
use App\Models\User;
use App\Models\Buyer;
use App\Models\Address;
use App\Models\Merchant;
use App\Models\MerchantProduct;
use App\Models\POrder;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Logistic;
use App\Models\LogisticSlab as LS;
use App\Models\CtlShip;
use App\Classes\CityLinkConnection as CL;
use App\Models\PackageDimension;
use Exception;
use DateTime;
use DB;
use QrCode;
use DNS1D;
use PDF;

// use Requests;
// use App\Models\

class CityLinkController extends Controller
{
    public $bl = "|"; //Barcode Limiter
    public $cN = "";
    public $btype = "C128";
    public $logistic_id;
    public $sysname = "ctl";

    public function __construct () {
        $log=new LogisticsController;

        $this->logistic_id=$log->select_logistic_id($this->sysname);
    }

    public function split_on($string, $num)
    {
        // http://stackoverflow.com/questions/5200940/split-string-after-x-characters
        $length = strlen($string);
        $output[0] = substr($string, 0, $num);
        $output[1] = substr($string, $num, $num + $num);
        $output[2] = substr($string, $num + $num, $length);
        return $output;
    }

    public function shipReqXML($order_id)
    {
        $data = $this->labelData($order_id, $type = "new");
        $buyer = $data[0];
        $merchant = $data[1];
        $TransactionIdentifier = IdController::nO($order_id);
        $CompanyCode = "CT";
        $Account = "TEST";
        $MeterNumber = "TEST_123";
        $ServiceType = "EXP";
        $PackageType = "SPX";
        $shipmentTotalCost = 0.00;
        $shipmentTotalWeight = 0.00;
        $WeightUnits = "KG";
        $CurrencyCode = "MYR";
        $MerchantContactPerson = $merchant->contact_person;
        // $MerchantContactPerson="Harry";
        $MerchantCompanyName = $merchant->company_name;
        $MerchantContact = $merchant->office_no;
        if (is_null($MerchantContact)) {
            $MerchantContact = $merchant->mobile_no;
        }
        $mAdd = Address::find($merchant->address_id);
        $mer_add = $mAdd->line1 . " " . $mAdd->line2 . " " . $mAdd->line3;
        $mer_add = $this->split_on($mer_add, 50);
        $MerchantAddressLine1 = $mer_add[0];
        $MerchantAddressLine2 = $mer_add[1];
        $MerchantAddressLine3 = $mer_add[2];
        $MerchantCityData = DB::table('city')->where('id', $mAdd->city_id)->first();
        $MerchantCity = $MerchantCityData->name;
        $MerchantState = DB::table('state')->where('code', $MerchantCityData->state_code)->pluck('name');
        $MerchantPostCode = $mAdd->postcode;
        $MerchantCountryCode = "ML";

        // Buyer
        $BuyerContactPerson = $buyer->name;
        $BuyerName = $buyer->name;
        $BuyerContact = $buyer->contact_no;
        $bAdd = Address::find($buyer->default_address_id);
        $buy_add = $bAdd->line1 . " " . $bAdd->line2 . " " . $bAdd->line3;
        $buy_add = $this->split_on($buy_add, 50);
        $BuyerAddressLine1 = $buy_add[0];
        $BuyerAddressLine2 = $buy_add[1];
        $BuyerAddressLine3 = $buy_add[2];
        $BuyerCityData = DB::table('city')->where('id', $bAdd->city_id)->first();
        $BuyerCity = $BuyerCityData->name;
        $BuyerState = DB::table('state')->where('code', $BuyerCityData->state_code)->pluck('name');
        $BuyerPostCode = $bAdd->postcode;
        $BuyerCountryCode = "ML";

        $ret = '<?xml version="1.0" encoding="utf-8" ?>
            <CTLShipReq xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
              <RequestHeader>
                    <TransactionIdentifier>' . $TransactionIdentifier . '</TransactionIdentifier>
                    <CompanyCode>' . $CompanyCode . '</CompanyCode>
                    <Account>' . $Account . '</Account>
                    <MeterNumber>' . $MeterNumber . '</MeterNumber>
              </RequestHeader>
              <ServiceType>' . $ServiceType . '</ServiceType>
              <PackageType>' . $PackageType . '</PackageType>
              <Weight>' . $shipmentTotalWeight . '</Weight>
              <WeightUnits>' . $WeightUnits . '</WeightUnits>
              <CurrencyCode>' . $CurrencyCode . '</CurrencyCode>
              <DeclaredValue>' . $shipmentTotalCost . '</DeclaredValue>
              <Shipper>
                    <ContactPerson>' . htmlentities($MerchantContactPerson) . '</ContactPerson>
                    <Name>' . $MerchantCompanyName . '</Name>
                    <Tel>' . $MerchantContact . '</Tel>
                    <AddressLine1>' . $MerchantAddressLine1 . '</AddressLine1>
                    <AddressLine2>' . $MerchantAddressLine2 . '</AddressLine2>
                    <AddressLine3>' . $MerchantAddressLine3 . '</AddressLine3>
                    <City>' . $MerchantCity . '</City>
                    <State>' . $MerchantState . '</State>
                    <PostCode>' . $MerchantPostCode . '</PostCode>
                    <CountryCode>' . $MerchantCountryCode . '</CountryCode>
              </Shipper>
              <Consignee>
                <ContactPerson>' . $BuyerContactPerson . '</ContactPerson>
                <Name>' . $BuyerName . '</Name>
                <Tel>' . $BuyerContact . '</Tel>
                <AddressLine1>' . $BuyerAddressLine1 . '</AddressLine1>
                <AddressLine2>' . $BuyerAddressLine2 . '</AddressLine2>
                <AddressLine3>' . $BuyerAddressLine3 . '</AddressLine3>
                <City>' . $BuyerCity . '</City>
                <State>' . $BuyerState . '</State>
                <PostCode>' . $BuyerPostCode . '</PostCode>
                <CountryCode>' . $BuyerCountryCode . '</CountryCode>
              </Consignee>  
              <Dimensions>
                <Length>0.00</Length>  
                <Width>0.00</Width>
                <Height>0.00</Height>
                <Units>CM</Units>
              </Dimensions> 
              <Remarks>I have no remarks</Remarks>   
              <Label>
                <GenerateLabel>0</GenerateLabel>    
                <Type>A4</Type>
              </Label>  
              <MultiPiece>
                <NumberPieces>1</NumberPieces>  
              </MultiPiece> 
              <ShipmentContent>
                <Description>--</Description>  
                <Quantity>1000</Quantity>
                <UnitPrice>10.00</UnitPrice>
              </ShipmentContent>    
              <Reference>
                <XR>XR4321</XR>
              </Reference>

            </CTLShipReq>';

        return $ret;

    }

    public function informLogistic($order_id,$type,$xml)
    {
        $xml = utf8_encode(str_replace('&', '&amp;', $this->shipReqXML($order_id)));
        $cl = new CL;
        return $cl->shipReq($xml);
        return 0;

    }


    /*BELOW FUNCTIONS ARE RESPONSIBLE FOR CITILINK LABEL GENERATION*/


    public function labelQR($user, $bAdd, $order_id, $consignmentNumber)
    {
        $filename = "qr.png";
        $bl = "|";
        $filepath = public_path('/citilink/' . $consignmentNumber . "/" . $filename);
        $qrInfo = $consignmentNumber . $bl . $user->name . $bl
            . $bAdd->line1 . $bl . $bAdd->line2 . " " . $bAdd->line3 . $bl . $bl . $bl .
            $bAdd->city . $bl . $bAdd->state . $bl . "MALAYSIA" . $bl . $user->mobile_no . $bl .
            IdController::nO($order_id);

        QrCode::format('png')->
        encoding('UTF-8')->
        size(400)->
        generate($qrInfo, $filepath);
    }

    public function labelSK($order_id, $consignmentNumber)
    {
        // (SecurityKey+PorderID) BarCode+QR 
        $delivery = DB::table('delivery')->where('porder_id', $order_id)
            ->where('type', $this->ctype)
            ->first();
        $securityID = $delivery->pickup_password;
        // $securityID=123456789012345;
        $height = 1.7;
        $filename = "barcodeSK.png";
        $filepath = public_path('/citilink/' . $consignmentNumber . "/" . $filename);
        $base64 = DNS1D::getBarcodePNG($securityID, $this->btype, $height);
        $img = base64_decode($base64);
        file_put_contents($filepath, $img);
        $filename = "qrSK.png";
        $bl = "|";
        $filepath = public_path('/citilink/' . $consignmentNumber . "/" . $filename);
        $qrInfo = $securityID . ";" . $order_id;

        QrCode::format('png')->
        encoding('UTF-8')->
        size(400)->
        generate($qrInfo, $filepath);


    }

    public function labelBC($consignmentNumber)
    {
        $height = 1.7;
        $filename = "barcodeL.png";
        $filepath = public_path('/citilink/' . $consignmentNumber . "/" . $filename);
        $base64 = DNS1D::getBarcodePNG($consignmentNumber, $this->btype, $height);
        $img = base64_decode($base64);
        file_put_contents($filepath, $img);

    }

    public function labelBCpod($consignmentNumber)
    {
        $height = 1.2;
        $filename = "barcodeS.png";
        $filepath = public_path('/citilink/' . $consignmentNumber . "/" . $filename);
        $base64 = DNS1D::getBarcodePNG($consignmentNumber, $this->btype, $height);
        $img = base64_decode($base64);
        file_put_contents($filepath, $img);
    }

    public function labelBCship($referenceNumber, $consignmentNumber)
    {
        $height = 1; //cm
        $filename = "ref.png";
        $filepath = public_path('citilink/' . $consignmentNumber . "/" . $filename);
        $base64 = DNS1D::getBarcodePNG($referenceNumber, $this->btype, $height);
        $img = base64_decode($base64);
        file_put_contents($filepath, $img);
    }

    public function bootStrap($consignmentNumber, $order_id)
    {
        $pathName = public_path("citilink/" . $consignmentNumber);
        try {
            // Create folder
            mkdir($pathName, 0775, true);
            // Copy Background SVG
            $item = "1.svg";
            $source = public_path("/citilink/asset/" . $item);
            $dest = $pathName . "/" . $item;
            copy($source, $dest);
            $item = "1.png";
            $source = public_path("/citilink/asset/" . $item);
            $dest = $pathName . "/" . $item;
            copy($source, $dest);
            $item = "2.png";
            $source = public_path("/citilink/asset/" . $item);
            $dest = $pathName . "/" . $item;
            copy($source, $dest);
            // Generate QR
            $qrFileName = "qr.png";
            $this->labelBC($consignmentNumber);
            // Generate POD
            $this->labelBCpod($consignmentNumber);
            // Reference Barcode
            $this->labelSK($order_id, $consignmentNumber);
            $nOrderId = IdController::nO($order_id);
            $this->labelBCship($nOrderId, $consignmentNumber);


        } catch (\Exception $e) {
        }
        return $pathName;

    }

    public function labelData($order_id, $type = "old")
    {

        $porder = POrder::find($order_id);
        $buyer_user_id = $porder->user_id;
        // Get Buyer's Data
        $user = User::find($buyer_user_id);

        $pid = OrderProduct::where('porder_id', $order_id)->pluck('product_id');
        $mp = MerchantProduct::where('product_id', $pid)->first();
        if (is_null($mp)) {
            $product = Product::find($pid);

            if (is_null($product)) {

                $product = Product::where('parent_id', $pid)->first();
            }
            $mp = MerchantProduct::where('product_id', $product->parent_id)->first();
        }
        $merchant = Merchant::find($mp->merchant_id);
        if ($type == "old") {
            $delivery = DB::table('delivery')->where('porder_id', $order_id)
                ->where('type', $this->ctype)
                ->first();
            $securityID = $delivery->pickup_password;
            $ret = [$user, $merchant, $securityID];
        } else {
            $ret = [$user, $merchant];
        }
        return $ret;

        // Get Merchant's Data


    }

    public function labelPDF($order_id, $consignmentNumber)
    {
        $fileName = "labels/label-" . $consignmentNumber . "-o-" . $order_id . ".pdf";
        $filePath = $fileName;
        $merUseData = $this->labelData($order_id);
        $user = $merUseData[0];
        $data = [$consignmentNumber,
            IdController::nO($order_id),
            $merUseData, $this->ctype];
        $bAdd = DB::table('address')->where('address.id', $user->default_address_id)
            ->join('city', 'address.city_id', '=', 'city.id')
            ->join('state', 'city.state_code', '=', 'state.code')
            ->select(DB::raw("
                    address.*,
                    city.name as city,
                    state.name as state
                    "))
            ->first();
        $this->labelQR($user, $bAdd, $order_id, $consignmentNumber);
        // return view('label.citilink')->with('data',$data);
        try {
            unlink(storage_path($filePath));
        } catch (\Exception $e) {

        }
        // return view('label.citilink',['data' => $data]);
        $pdf = PDF::loadView('label.citilink', ['data' => $data])
            ->setOption('zoom', 0.80)
            ->save(storage_path($filePath));
        return $filePath;
    }

    public static function cleanUP($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new Exception("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            // if (is_dir($file)) {
            //     self::deleteDir($file);
            // } else {
            unlink($file);
            // }
        }
        rmdir($dirPath);
    }

    public function downloadLabel($order_id, $type = "m2b")
    {
        $f1 = "";
        $this->ctype = $type;
        try {
            $consignmentNumber = DB::table('delivery')->where('porder_id', $order_id)->where('type', $type)->pluck('consignment_number');
            $f1 = $this->bootStrap($consignmentNumber, $order_id);
            $f2 = $this->labelPDF($order_id, $consignmentNumber);

            $this->cleanUP($f1);

            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download(storage_path($f2), "label.pdf", $headers)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
            //  Paul on 13 April 2017 at 10 10 pm
            //dump($e);
            //  Ends Here
            try {
                $this->cleanUP($f1);
            } catch (\Exception $e) {

            }
            return view('common.generic')
                ->with('message_type', 'error')
                ->with('message', 'Something went wrong. Please contact OpenSupport');
        }

    }


// THE CODE BELOW CALLS THE LOGISTIC
    public function callLogistic(Request $r)
    {
        try {

            $order_id = $r->oid;
            $type = "m2b";

            if ($r->has('type')) {
                $type = $r->type;

            }
            if ($type == "m2b") {
                $status = "m-processing2";
                $pstatus = "m-processing1";
            }
            if ($type == "b2m") {
                # code...
                $pstatus = "b-paid1";
                $status = "b-returning2";
            }
            $porder = POrder::find($order_id);

            // return $type;
            // Validation

            // 
            $isotime = $r->isotime;
            $packageArray = $r->pd;
            $packageCount = $r->count;

            $datetime = new DateTime($isotime);
            $fdate = $datetime->format("Y-m-d H:i");
            // return $fdate;
            $dt = explode(" ", $fdate);
            $pref_date = $dt[0];
            $t = explode(":", $dt[1]);
            $hr = $t[0];
            $min = $t[1];

            // return [$pref_date,$hr,$min];


            $buyer_user_id = $porder->user_id;
            $user = User::find($buyer_user_id);

            $pid = OrderProduct::where('porder_id', $order_id)->pluck('product_id');
            $mp = MerchantProduct::where('product_id', $pid)->first();
            if (is_null($mp)) {
                $product = Product::find($pid);

                if (is_null($product)) {

                    $product = Product::where('parent_id', $pid)->first();
                }
                // dump($product);
                $mp = MerchantProduct::where('product_id', $product->id)->first();
                if (is_null($mp)) {
                    $mp = MerchantProduct::where('product_id', $product->parent_id)->first();
                }
            }
            // $mer=Merchant::find($mp->merchant_id);
            $mer = Merchant::join('users', 'users.id', '=', 'merchant.user_id')
                ->where('merchant.id', '=', $mp->merchant_id)
                ->select(DB::raw("
                        merchant.*,
                        users.email
                        "))
                ->first();
            $mAdd = DB::table('address')->where('address.id', $mer->address_id)
                ->join('city', 'address.city_id', '=', 'city.id')
                ->join('state', 'city.state_code', '=', 'state.code')
                ->select(DB::raw("
                address.*,
                city.name as city,
                state.name as state
                "))
                ->first();
            $bAdd = DB::table('address')->where('address.id', $user->default_address_id)
                ->join('city', 'address.city_id', '=', 'city.id')
                ->join('state', 'city.state_code', '=', 'state.code')
                ->select(DB::raw("
                address.*,
                city.name as city,
                state.name as state
                "))
                ->first();
            $cn = CtlShip::where('porder_id', $porder->id)->first();


            if (is_null($cn)) {
                return response()->json(['status' => 'failure', 'short_message' => 'MC Error', 'long_message' => 'Something went wrong. Please contact OpenSupport.']);
            }
            $cnu = CtlShip::find($cn->id);
            $cnu->ctl_pref_date = $pref_date;
            $cnu->ctl_pref_hour = $hr;
            $cnu->ctl_pref_min = $min;
            $cnu->ctl_package_quantity = $packageCount;
            $cnu->save();
            // $delivery=DB::table('delivery')->where('consignment_number',$cnu->ctl_consignment_number)->where('porder_id',$cnu->porder_id)
            //     ->first();
            // foreach ($packageArray as $pa) {
            //     $pdm= new PackageDimension;
            //     $pdm->delivery_id=$cnu->ctl_consignment_number;
            //     $pdm->height=$pa["height"];
            //     $pdm->length=$pa["length"];
            //     $pdm->width=$pa["width"];
            //     $pdm->weight=$pa["weight"];
            //     $pdm->save();
            // }
            $m = EmailController::callLogisticMail($user, $mer, $bAdd, $mAdd, $cnu, $type);

            if ($m == 1) {

                /*  Paul on 09 May 2017 at 1 15 am
                    DR Error means Duplicate Request  */
                if($porder->status === $status)
                    return response()->json(['status' => 'failure', 'short_message' =>
                        'DR Error', 'long_message' =>
                        'You have already called the Logistic.']);
                /*  Ends Here  */

                $porder->status = $status;
                // Update OrderProduct
                $ops = OrderProduct::where('porder_id', $porder->id)
                    ->where('status', $pstatus)
                    ->get();

                foreach ($ops as $op) {
                    $o = OrderProduct::find($op->id);

                    //  Paul on 09 May 2017
                    if($o->status === $status)
                        return response()->json(['status' => 'failure', 'short_message' =>
                            'DR Error', 'long_message' =>
                            'You have already called the Logistic.']);

                    $o->status = $status;
                    $o->save();
                }

                $porder->save();

                return response()->json(['status' => 'success', 'short_message' => 'P&O updated', 'long_message' => 'The logistic has been informed. Please ready the package for pickup']);
            }
            return response()->json(['status' => 'failure', 'short_message' => 'EMC Error', 'long_message' => 'Something went wrong. Please contact OpenSupport.']);
        } catch (\Exception $e) {
            //  Paul on 13 April 2017 at 10 10 pm
            //dump($e);
            //  Ends Here
            return response()->json(['status' => 'failure', 'short_message' => 'Server Error', 'long_message' => 'Something went wrong. Please contact OpenSupport.']);
        }

    }

    // Calculate Delivery Charge for product
    public static function dC($weight)
    {
        $gl = DB::table('global')->first();
        $surcharge = 36; //percentage
        $log_comm = $gl->logistic_commission; //percentage
        $logistic_id = $this->logistic_id;
        try {

            $w = $weight; // in kg ->g?

            $query = DB::table('slab')
                ->join('logisticslab as ls', 'ls.slab_id', '=', 'slab.id')
                ->where('ls.logistic_id', $logistic_id);
            $maxima = $query
                ->where('slab.weight', '>', $w)->orderBy('slab.weight', 'ASC')
                ->select(DB::raw("
            slab.*
            "))
                ->first();
            $minima = $query
                ->where('slab.weight', '<', $w)->orderBy('slab.weight', 'DESC')
                ->first();
            // Check if there is interval
            //  Paul on 13 April 2017 at 10 10 pm
            //dump($minima);
            echo "------------";
            //dump($maxima);
            //  Ends Here
            if ($minima != null and $minima->incremental_price != null and $minima->incremental_price != "" and $minima->increment_unit != null) {
                $leftOverW = $weight - $minima->weight;
                $leftOverC = ($leftOverW / $minima->increment_unit) * $minima->incremental_price;
                $rawPrice = $minima->base_price + $leftOverC;

            } else {
                $rawPrice = $maxima->base_price;
            }
            $surcharge = ($surcharge * $rawPrice) / 100;
            $price = $rawPrice + $surcharge;
            $comm = ($log_comm * $price) / 100;

            $charge = $price + $comm;
        } catch (\Exception $e) {
            //  Paul on 13 April 2017 at 10 10 pm
            //dump($e);
            //  Ends Here
            $charge = 99999999;
        }
        return $charge;
    }

    /* Tracking */
    public static function track($consignmentNumber)
    {
        $ret = "Could not be tracked";
        try {
            $c = new CL;
            $ret = $c->trackDetail($consignmentNumber);
        } catch (\Exception $e) {

        }
        return $ret;

    }
}
