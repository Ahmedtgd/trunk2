<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Classes\FPX;
use App\Classes\MasterCard;
use App\Classes\Delivery;
use App\Classes\CC;
use App\Models\User;
use App\Models\POrder;
use App\Models\SMMout;
use App\Models\Channel;
use App\Models\OAcc;
use App\Models\Globals;
use App\Http\Requests;
use App\Classes\NinjaVan;
use App\Classes\CityLinkConnection as CL;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\APICapsOcreditController;
use App\Http\Controllers\PriceController;
use App\Classes\StationIntelligence;
use App\Http\Controllers\CityLinkController;
use App\Http\Controllers\rn\FireBaseController;
use App\Models\Address;
use App\Models\FPXAC;
use Illuminate\Support\Facades\Hash;
use Moltin\Cart\Storage\LaravelSession;
use Moltin\Cart\Storage\Session as SessionStore;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// use App\Classes\StationIntelligence;
use Schema;
use Cart;
use Carbon;
use Auth;
use DB;
use PDF;
use Session;
use Input;
use Image;
use SnappyImage;
use QrCode;
use Log;
// use Barryvdh\Snappy\ImageWrapper as SnappyImage;
use Knp\Snappy\Image as KImage;

class TestController extends Controller
{

    public function jnv1()
    {
        $nvclass = new NinjaVan;
        $access_token = $nvclass->get_access_token();
        dump($access_token);
        //return $access_token;
    }

    public function fbtoken()
    {
        return view('tests.fbtoken');
    }

    public function a()
    {
        return redirect("b");
    }

    public function b()
    {
        return view('tests.nvsimul');
    }

    public function stuff($id = 1)
    {
        switch ($id) {
            case 1:
                $s = new SnappyImage;
                return SnappyImage::loadFile(url("/"))->download("test.jpg");
                break;
            case 2:
                $m = new MasterCard;
                return $m->get_token();
                //return $m->do_authentication(rand(1000,10000) , rand(1000,10000));
                //return $m->test();
                break;
            case 3:

                dump(UtilityController::is_mobile());
                break;
            case 4:
                # code...
                // Auth::loginUsingId(360);
                Schema::create('locationcacctno', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('cacctno_id')->unsigned();

                    /*Merchant's User Id*/
                    $table->integer('location_id')->unsigned();
                    $table->softDeletes();
                    $table->timestamps();
                    $table->engine = "MYISAM";
                });
                break;
            case 5:
                $o = new OcreditvalidationController;
                return $o->get_matches(100, 360);
                break;
            case 6:
                return UtilityController::get_ip();
                break;
            case 7:
                for ($i = 0; $i < 50; $i++) {
                    # code...
                    $del = new Delivery;
                    $quantity = $i + 1;
                    echo "<br/>" . $quantity . " --MYR " . number_format($del->get_delivery_price(3571, $quantity, False) / 100, 2) . "<br/>";
                }


                break;
            case 8:
                dump(Cart::contents());
                break;
            case 9:
                $p = POrder::find(9);
                $p->payment_id = $p->payment_id + 1;
                $p->save();
                # code...
                break;
            case 10:
                $fpx = new FPX;
                $banks = $fpx->get_banks();
                dump($banks);
                break;
            case 11:
                $globals = DB::table('global')->first();
                $fpx = new FPX;

                $r = (object)array();
                $r->seller_exorderno = time();
                $r->reference_number = "00112233";
                $r->amount = 1;
                if ($fpx->check_production()) {
                    $bank = "MB2U0227";
                } else {
                    $bank = "TEST0021";
                }
                $r->buyer_bankid = $bank;
                //$r->buyer_bankbranch="SBI BANK A";

                $msg = $fpx->get_ar_msg($r);
                if ($msg == 0) {
                    echo "Please log in";
                    break;
                }
                dump($msg);
                //$html = "<form action='".$fpx->fpx_url_test."' type='POST'>";
                $url = $fpx->get_primary_url($globals);
                dump($url);
                $html = "<form action='" . $url . "' type='POST'>";
                $html .= "<table>";
                foreach ($msg as $key => $value) {
                    $html .= "<tr>";
                    $html .= "<td><label>" . $key . "&nbsp;&nbsp;</label></td>";
                    $html .= "<td><input name='" . $key . "' value='" . $value . "'></td>";
                    $html .= "</tr>";
                }
                $html .= "<tr><td></td><td><input type='submit'/></td></tr>";
                $html .= "</table></form>";
                echo $html;
                break;

            case 13:
                $handle = fopen(getcwd() . "../../app/Http/Controllers/UtilityController.php", "r");
                echo "<pre>" . fread($handle, 10240000) . "</pre>";
                break;

            case 14:
                $fpx = FPXAC::orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    echo "<pre>" . $k . "</pre>";
                }

                break;
            case 15:
                # code...
                $fpx = DB::table('stuff')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }
                }
                break;
            case 16:
                $fpx = DB::table('fpxref')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }
                }
                break;
            case 17:
                $fpx = DB::table('cart')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }
                }
                break;
            case 18:
                $fpx = DB::table('ctrans')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }
                }
                break;
            case 19:
                dump(Cart::contents());
                break;
            case 20:
                echo "Session Save Path: " . ini_get('session.save_path');
                dump(scandir(session_save_path()));
                break;
            case 21:
                $fpx = new FPX;
                $data = $fpx->create_be();
                dump($data);

                $result = $fpx->post_be($data);
                dump("result=" . $result);

                echo "<textarea style='width:100%'>" . $result . "</textarea>";
                break;
            case 22:
                $fpx = DB::table('fpx_AC')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }

                }
                break;

            case 23:
                # code...
                // dump(session()->all()) ;
                //session_start();
                dump(scandir(session_save_path()));
                dump(session_id());
                $cart = $_SESSION;
                reset($cart);
                // $first_key = key($cart);
                // foreach ($cart as $key => $value) {
                //     dump($key);
                //     dump($value);
                // }
                // dump($first_key);
                break;
            case 24:
                return view('ninjavan.label');
                # code...
                break;
            case 25:
                return UtilityController::cart_session_id();
                break;
            case 26:
                $fpx = DB::table('nv_order_create_req')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }

                }
                break;
            case 27:
                $fpx = DB::table('nv_order_create_resp')->
                orderBy('id', 'DESC')->limit(10)->get();
                foreach ($fpx as $k) {
                    try {
                        echo "<pre>" . $k . "</pre>";
                    } catch (\Exception $e) {
                        dump($k);
                    }

                }
                break;
            case 28:
                return view("tests.nvsimul");

                break;
            case 29:
                $fpx = new FPX;
                $banks = $fpx->get_banks();
                dump($banks);
                foreach ($banks as $key => $value) {
                    $v = DB::table('bank')->where('code', $key)->first();
                    if (is_null($v)) {
                        echo "Bank not found for code: " . $key . " <br>";
                    } else {
                        echo "<strong>Bank :" . $v->name . "    Code: " . $key . " </strong><br>";
                    }
                }
                break;
            case 30:
                # code...
                $e = new EmailController;
                $e->sendRC("zurez4u@gmail.com", 1);
                $e->sendRC("zurez4u@gmail.com", 2);
                $e->sendRC("zurez4u@gmail.com", 3);
                $e->sendRC("zurez4u@gmail.com", 4);
                $e->sendRC("zurez4u@gmail.com", 7);
                break;

            case 31:
                $mn = DB::table('userninjavan')->get();
                dump($mn);
                break;
            case 32:
                $cc = new CC();
                return view('cc/cc', ['data' => $cc->check_connection()]);
                break;
            case 33:
                // session_start( );
                echo session_id();
                // session_start( );
                // echo session_id();
                break;
            case 34:
                $smmout = DB::table('smmout')->
                orderBy('id', 'DESC')->get();
                foreach ($smmout as $s) {
                    $v = DB::table('nsmmid')->where('smm_id', $s->id)->first();

                    if (empty($v)) {
                        UtilityController::smm_unique_id($s->id);
                    }
                }
                break;
            case 35:
                $request = new Request;
                dump($this->request->session()->all());
                echo "<img src='/images/footer/footer-flourish.png'/>";
                break;

            case 36:
                $e = new EmailController;
                $e->sendCampaignOsmall(360, 5);
                break;

            case 37:
                $channel = new Channel;
                $channel->name = "email";
                $channel->description = "Email";
                $channel->save();
                $channel = new Channel;
                $channel->name = "fb";
                $channel->description = "Facebook";
                $channel->save();
                break;

            case 38:
                $file = storage_path("logs/laravel.log");
                return response()->download($file, "laravel.log");
                break;
            case 39:
                return DB::table("product")
                    ->join("merchantproduct", "merchantproduct.product_id", "=", "product.id")
                    ->where("product.parent_id", 2087)
                    ->where("merchantproduct.merchant_id", 109)
                    ->whereNull("product.deleted_at")
                    ->select("product.*")->


                    toSql();
                break;
            case 40:
                return $this->sales_memo_new(55);
                # code...
                break;

            case 400:
                return $this->sales_memo_new(51);
                # code...
                break;

            case '41':
                # code...
                return base64_encode(QrCode::format("png")->size(75)->generate("3445"));
                break;
            case 42:
                # code...
                return $this->get_summary();
                break;
            case '43':
                # code..
                $linked_companies = DB::select(DB::raw("
                    select
                    DISTINCT f.id as location_id,
                    c.id,
                    c.dispname,
                    f.location
                    
                from
                    autolink al,
                    users mu,   -- merchant.user_id
                    merchant m,
                    users cu,   -- company.owner_user_id
                    merchant cm,
                    company c,
                    fairlocation f
                where
                    
                    mu.id =378 and
                    m.user_id=mu.id and
                    f.user_id=c.owner_user_id and 
                    cm.user_id=c.owner_user_id and
                    c.owner_user_id=cu.id and
                    ((al.initiator=cm.user_id and al.responder=m.id) OR
                    (al.initiator=m.user_id and al.responder=cm.id))
                "));
                $raw_ret = array();
                foreach ($linked_companies as $m) {
                    $key = $m->dispname;
                    try {


                        $temp_contant = $raw_ret[$key];

                    } catch (\Exception $e) {
                        $temp_contant = array();
                    }


                    array_push($temp_contant, ["location" => $m->location, "location_id" => $m->location_id, "company_id" => $m->id]);

                    $raw_ret[$key] = $temp_contant;

                }
                $ret = array();
                foreach ($raw_ret as $c => $rr) {

                    $temp = array();
                    $temp["title"] = $c;
                    $temp["content"] = $rr;
                    array_push($ret, $temp);
                }

                return $ret;
                break;
            case 51:
                # code...
                $this->test_salesmemo();
                break;
            case 52:
                $f = new FireBaseController;
                return $f->notify();
                break;
            case 53:
                # code...
                return $this->report_new();
                break;
            case 54:
                # code..
                DB::table("stockreport")
                    ->where("id", "=", 556)
                    ->update([
                        "created_at" => new Carbon("first day of april 2018", "ASIA/KOLKATA")
                    ]);
                break;
            case '55':
                # code...

                return view("product.barcode");
                break;
            case '56':
                # code...
                $user_id = 378;
                $company = "Samsung";
                $data = DB::select(DB::raw(
                    "
                SELECT 
                c.acctno,
                l.location_id,
                CASE
                    WHEN l.location_id IS NULL  THEN 'unchecked'
                    ELSE 'checked'
                END as 'status'
                FROM
                cacctno c
                LEFT JOIN locationcacctno l ON c.id=l.cacctno_id 
                WHERE
                        c.company='$company'
                    
                    AND c.user_id='$user_id'
                    AND c.deleted_at IS NULL
                ORDER BY 
                    c.created_at DESC
                "
                ));
                return $data;
                break;
            case '57':
                return response()->json(['status' => 'failure', 'error' =>
                    "Report does not exists"
                ], 1001);
                # code...
                break;
            case '58':
                # code...
                $fairlocations = DB::table("fairlocation")->whereNull("deleted_at")->get();

                foreach ($fairlocations as $f) {
                    DB::table("branch")->insert([
                        "updated_at" => Carbon::now(),
                        "created_at" => Carbon::now(),
                        "deleted_at" => NULL,
                        "location_id" => $f->id,
                        "name" => $f->location
                    ]);
                }
                break;
            case 666:
                DB::table('stuff')->delete();
                // DB::table('fpxref')->delete();
                // DB::table('cart')->delete();
                break;

            default:
                return UtilityController::delete_cart($id);
        }
    }

    /**
     * [test_cc_payment description]
     * @return [type] [description]
     */
    public function test_cc_payment()
    {
        $cc = new CC();
        if (Input::get('submit') != null) {
            $data = Input::all();
            $response = $cc->do_payment(Input::all());

        }
    }

    public function table($table, $id, $fk = "")
    {
        $op = DB::table($table)->where('id', $id)->first();
        dump($op);

        dump("*******************");
        $op = DB::table($table)->where('porder_id', $id)->get();
        dump($op);
    }

    public function nv($nporder_id)
    {
        # code...
    }

    public function testMail($email)
    {
        $e = new  EmailController;
        // $e->sendRC($email,106);
        $result = $e->testMail($email);
        $img = Image::make(file_get_contents("https://opensupermall.com/o/nikon"));
        $res = $img->response('png', 70);
        // $result=$e->testMail("zurez4u+test@gmail.com");
        // return $result;
        if ($result == 1) {
            # code...
            return "Mail Sent to " . $email;

        } else {
            return $result;
        }
    }

    /*
        FPX Payment Test Methods
    */
    public function fpx_webview()
    {
        return view("payment.fpx.test.webview");
    }

    public function nv_data($type, $tracking_id, $porder_id)
    {
        switch ($type) {
            case "pickup":
                $ret = '{ 
                "shipper_id":921,   
                "status":"Successful Delivery",
                "previous_status":"On Vehicle for Delivery",
                "shipper_order_ref_no": "' . $porder_id . '",
                "timestamp":"2015-01-20 20:21:09",
                "order_id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
                "tracking_id":"' . $tracking_id . '",   
                "pod": {
                    "type": "SUBSTITUTE",
                    "name": "Sarah",
                    "identity_number": "S8987615J",
                    "contact": "9987976",
                    "uri": "https://link.to/pod.jpeg",
                    "left_in_safe_place": false
                }
             }';
                break;
            case 'parcel_weight':
                $ret = '{ 
                    "shipper_id":921,   
                    "status":"Parcel Size",
                    "shipper_order_ref_no": "' . $porder_id . '",
                    "timestamp":"2015-01-20 20:21:09",
                    "order_id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
                    "previous_weight":"2",
                    "new_weight":"10",
                    "tracking_id":"' . $tracking_id . '", 
                 }';
                break;
            case 'parcel_size':
                $ret = '{ 
                "shipper_id":921,   
                "status":"Parcel Size",
                "shipper_order_ref_no": "' . $porder_id . '",
                "timestamp":"2015-01-20 20:21:09",
                "order_id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
                "previous_size":"SMALL",
                "new_size":"EXTRALARGE",
                "tracking_id":"' . $tracking_id . '", 
                }';
                break;
            case 'delivery':
                $ret = '{ 
                "shipper_id":921,   
                "status":"Successful Delivery",
                "previous_status":"On Vehicle for Delivery",
                "shipper_order_ref_no": "' . $porder_id . '",
                "timestamp":"2015-01-20 20:21:09",
                "order_id":"3b7327b9-54bf-417f-3104-f4e134ed22308",
                "tracking_id":"' . $tracking_id . '",   
                "pod": {
                    "type": "SUBSTITUTE",
                    "name": "Sarah",
                    "identity_number": "S8987615J",
                    "contact": "9987976",
                    "uri": "https://link.to/pod.jpeg",
                    "left_in_safe_place": false
                }
             }';
                break;
            default:
                # code...
                break;
        }
    }

    public function nv_curl($data, $type)
    {
        $url = "";
        switch ($type) {
            case 'delivery':
                $url = url('nv/sdelivery');
                break;
            case 'pickup':
                $url = url();
            case 'parcel_weight':
                $url = url('nv/parcelweight');
                # code...
                break;
            case 'pickup':
                $url = url('nv/ppickup');
                break;
            default:
                # code...
                break;
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'HTTP_X_NINJAVAN_HMAC_SHA256: 1234567'
        ));
        $result = curl_exec($ch);
        return $result;
    }

    public function nv_webhook(Request $r)
    {
        // $order_id
        $ret = NULL;
        $order_id = $r->order_id;
        $type = $r->type;
        $tracking_id_array = DB::table('delivery')->
        where('porder_id', $order_id)->
        select('consignment_number')->get();

        foreach ($tracking_id_array as $key => $value) {
            $value = $value->consignment_number;
            $json = $this->nv_data($type, $value, $order_id);

            dump("DUMP FOR tracking_id: " . $value);
            try {
                $ret = $this->nv_curl($json, $type);

            } catch (\Exception $e) {
                dump($e);
            }
            dump($ret);
        }
    }


    public function get_summary()
    {
        # code...

        /*Hardcoded Company Id*/
        $company_id = 6;

        $created = DB::table("t_stockreport")->
        join("t_stockreportproduct", "t_stockreportproduct.stockreport_id", "=", "t_stockreport.id")->
        join("fairlocation", "t_stockreport.creator_location_id", "=", "fairlocation.id")->
        whereRaw('Date(t_stockreport.created_at) = CURDATE()')->

        where("t_stockreport.creator_company_id", $company_id)->
        groupBy("t_stockreport.id")->
        select(DB::raw("
            t_stockreport.id,
                fairlocation.location
            "))->
        groupBy("fairlocation.location")
            ->get();

        dump($created);


        $checked = DB::table("t_stockreport")->
        join("t_stockreportproduct", "t_stockreportproduct.stockreport_id", "=", "t_stockreport.id")->
        join("fairlocation", "t_stockreport.checker_location_id", "=", "fairlocation.id")->
        whereRaw('Date(t_stockreport.created_at) = CURDATE()')->
        // whereRaw("t_stockreport.creator_company_id <> t_stockreport.checker_company_id")->

        where("t_stockreport.checker_company_id", $company_id)->

        select(DB::raw("
                COUNT(DISTINCT(t_stockreport.id)) as count,
                fairlocation.location
            "))->
        groupBy("fairlocation.location")
            ->get();

        /*Get Losses*/
        $t_stockreports = DB::table("t_stockreport")->
        join("t_stockreportproduct", "t_stockreportproduct.stockreport_id", "=", "t_stockreport.id")->
        join("fairlocation as f1", "t_stockreport.creator_location_id", "=", "f1.id")->
        // join("fairlocation as f2","t_stockreport.checker_location_id","=","f2.id")->
        whereRaw('Date(t_stockreport.created_at) = CURDATE()')->
        // where("t_stockreport.checker_company_id",$company_id)->
        where("t_stockreportproduct.quantity", "!=", "t_stockreportproduct.received")->
        where("t_stockreport.status", "confirmed")->
        where("t_stockreport.creator_company_id", $company_id)->
        select(DB::raw("
                t_stockreport.id,
                t_stockreport.ttype,
                t_stockreportproduct.opening_balance,
                t_stockreportproduct.quantity,
                t_stockreportproduct.received,
                f1.location,
                t_stockreport.created_at
            "))
            ->get();
        dump($t_stockreports);
        $filtered = array();
        $losses = [];
        foreach ($t_stockreports as $s) {
            // dump($filtered);
            // dump($losses);
            if (!in_array($s->id, $filtered)) {
                if (($s->ttype != "stocktake" and $s->quantity != $s->received) ||
                    ($s->ttype == "stocktake" and $s->opening_balance > $s->quantity)
                ) {
                    array_push($filtered, $s->id);
                    try {
                        $losses[$s->location] += 1;
                    } catch (\Exception $e) {
                        $losses[$s->location] = 1;
                    }
                }
            }
        }

        /*Format Data*/
        $report = array();
        foreach ($losses as $key => $value) {
            $report[$key]["loss"] = $value;
        }
        foreach ($created as $key => $value) {
            try {
                $report[$value->location]["created"] += $value->count;
            } catch (\Exception $e) {
                $report[$value->location]["created"] = $value->count;
            }

        }
        foreach ($checked as $key => $value) {
            try {
                $report[$value->location]["checked"] += $value->count;
            } catch (\Exception $e) {
                $report[$value->location]["checked"] = $value->count;
            }
        }

        /*SalesMemo*/
        $salesmemo = DB::table("salesmemo")->
        join("fairlocation", "salesmemo.fairlocation_id", "=", "fairlocation.id")->
        join("salesmemoproduct", "salesmemoproduct.salesmemo_id", "=", "salesmemo.id")->
        join("company", "company.owner_user_id", "=", "fairlocation.user_id")->
        whereDate('salesmemo.created_at', ">=", Carbon::today())->
        where("salesmemo.status", "active")->
        whereNull("salesmemo.deleted_at")->
        whereNotNull("salesmemo.confirmed_on")->
        where("company.id", $company_id)->
        select(DB::raw("

                SUM(salesmemoproduct.quantity*salesmemoproduct.price) as sale,
                fairlocation.location
            "))
            ->groupBy("fairlocation.location")
            ->get();

        return response()->json(compact("salesmemo", "report"));
    }

    public function sales_memo_new($location_id)
    {
        $ret = array();

        $ret['long_message'] = "Validation failure";
        // $user = JWTAuth::parseToken()->authenticate();

        /* Why are we hardcoding here? */
        $owner_user_id = 570;
        if (empty($owner_user_id)) {
            $ret['long_message'] = "Fairlocation not valid.";
            return response()->json($ret);
        }

        /**************/
        $salesmemo_no = 1;

        /* Delete useless SM */
        DB::table("t_salesmemo")->
        join("fairlocation", "fairlocation.id", "=",
            "t_salesmemo.fairlocation_id")->
        leftJoin("t_salesmemoproduct", "t_salesmemo.id", "=",
            "t_salesmemoproduct.salesmemo_id")->
        where("fairlocation.user_id", $owner_user_id)->
        whereNull("t_salesmemoproduct.id")->
        update([
            "t_salesmemo.salesmemo_no" => NULL,
            "t_salesmemo.deleted_at" => Carbon::now()
        ]);

        $ts = DB::table("t_salesmemo")->
        join("fairlocation", "fairlocation.id", "=",
            "t_salesmemo.fairlocation_id")->
        where("fairlocation.user_id", $owner_user_id)->
        get();

        foreach ($ts as $t) {
            $smp = DB::table("t_salesmemoproduct")->
            where("salesmemo_id", $t->id)->
            whereNull("deleted_at")->
            first();

            # Validate against productLESS Salesmemo
            if (empty($smp)) {
                DB::table("t_salesmemo")->
                where("id", $t->id)->
                update([
                    "salesmemo_no" => NULL,
                    "updated_at" => Carbon::now(),
                    "deleted_at" => Carbon::now()
                ]);
            }

            # Validate against null or empty Consignment Account No
            DB::table("t_salesmemo")->
            where("id", $t->id)->
            whereNull("consignment_account_no")->
            orWhere("consignment_account_no", "")->
            update([
                "salesmemo_no" => NULL,
                "updated_at" => Carbon::now(),
                "deleted_at" => Carbon::now()
            ]);
        }

        /* RECOVERY SECTION */
        $total_salesmemos_records = DB::table("t_salesmemo")->
        join("fairlocation", "fairlocation.id", "=",
            "t_salesmemo.fairlocation_id")->
        where("fairlocation.user_id", $owner_user_id)->
        groupBy("t_salesmemo.salesmemo_no")->
        select("t_salesmemo.*")->
        whereNull("t_salesmemo.deleted_at")->
        get();

        $total_salesmemos = count($total_salesmemos_records);
        $max_salememo = DB::table("t_salesmemo")->
        join("fairlocation", "fairlocation.id", "=",
            "t_salesmemo.fairlocation_id")->
        join("t_salesmemoproduct", "t_salesmemo.id", "=",
            "t_salesmemoproduct.salesmemo_id")->
        where("fairlocation.user_id", $owner_user_id)->
        orderBy("t_salesmemo.salesmemo_no", "DESC")->
        select("t_salesmemo.*")->
        whereNull("t_salesmemo.deleted_at")->
        first();

        $max_salememo->salesmemo_no = 5000;

        dump("max_salememo=" . $max_salememo->salesmemo_no);
        dump("total_salesmemos=" . $total_salesmemos);

        $uniq = array();
        if (!empty($max_salememo) &&
            $total_salesmemos != $max_salememo->salesmemo_no) {

            /* Prepare datastructure of unique salesmemo_no and possible
             * salesmemo_id that has the same salesmemo_no */
            foreach ($total_salesmemos_records as $k) {
                /* This is a case where salesmemo_no is the SAME but valid
                 * with products!! */
                $validrecs = DB::table("t_salesmemo")->
                join("fairlocation", "fairlocation.id", "=",
                    "t_salesmemo.fairlocation_id")->
                where("salesmemo_no", $k->salesmemo_no)->
                where("fairlocation.user_id", $owner_user_id)->
                whereNull("t_salesmemo.deleted_at")->
                where("t_salesmemo.consignment_account_no", "!=", "")->
                whereNotNull("t_salesmemo.consignment_account_no")->
                select("t_salesmemo.*")->
                orderBy("t_salesmemo.id")->
                get();

                $procs = array_map(function ($v) {
                    return $v->id;
                }, $validrecs);
                $uniq[$k->salesmemo_no] = $procs;

                dump('uniq[' . $k->salesmemo_no . ']=' .
                    json_encode($uniq[$k->salesmemo_no]));
                /*
                dump($procs);
                dump($validrecs);
                */
            }

            # Recovery
            dump("Going in Recovery");
            $i = 1;
            foreach ($uniq as $k => $v) {
                dump('v=' . json_encode($v));

                if (!empty($v) and count($v) > 0) {
                    foreach ($v as $pid) {
                        dump("Editing salesmemo_id " . $pid .
                            " having old salesmemo_no " . $k .
                            ". Assigning salesmemo_no " . $i);

                        DB::table("t_salesmemo")->
                        where("id", $pid)->
                        update(["salesmemo_no" => $i]);
                        $i++;
                    }
                }
            }
        }

        /*****************/
        $sm = DB::table("t_salesmemo")->
        join("fairlocation", "fairlocation.id", "=",
            "t_salesmemo.fairlocation_id")->
        join("t_salesmemoproduct", "t_salesmemoproduct.salesmemo_id", "=",
            "t_salesmemo.id")->
        where("fairlocation.user_id", $owner_user_id)->
        orderBy("t_salesmemo.salesmemo_no", "DESC")->
        select("t_salesmemo.*")->
        whereNull("t_salesmemo.deleted_at")->
        first();

        dump($sm);
        if (!empty($sm)) {
            $salesmemo_no = $sm->salesmemo_no + 1;
        }

        /*******************/
        $sales_memo_id = DB::table('t_salesmemo')->
        insertGetId([
            /* Why are we hardcoding this creator_user_id? */
            "creator_user_id" => 360,
            "fairlocation_id" => $location_id,
            "salesmemo_no" => $salesmemo_no,
            "updated_at" => Carbon::now(),
            "created_at" => Carbon::now()
        ]);

        return $sales_memo_id;
    }

    public function test_salesmemo()
    {
        for ($i = 0; $i < 100; $i++) {
            $salesmemo_no = rand(1, 99);
            $s = DB::table("t_salesmemo")
                ->insertGetId([
                    "salesmemo_no" => $salesmemo_no,
                    "creator_user_id" => 360,
                    "fairlocation_id" => 55,
                    "status" => "confirmed",
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
            DB::table("t_salesmemoproduct")
                ->insert([
                    "product_id" => 2945,
                    "salesmemo_id" => $s,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now()
                ]);
        }
    }

    public function report_new()
    {
        $ret = array();

        $ret['long_message'] = "Validation failure";

        $owner_user_id = 378;

        /**************/
        $report_no = 1;

        /* Delete useless SM */
        DB::table("t_stockreport")->
        join("fairlocation", "fairlocation.id", "=",
            "t_stockreport.creator_location_id")->
        leftJoin("t_stockreportproduct", "t_stockreport.id", "=",
            "t_stockreportproduct.stockreport_id")->
        where("fairlocation.user_id", $owner_user_id)->
        whereNull("t_stockreportproduct.id")->
        update([
            "t_stockreport.report_no" => NULL,
            "t_stockreport.deleted_at" => Carbon::now()
        ]);

        $ts = DB::table("t_stockreport")->
        join("fairlocation", "fairlocation.id", "=",
            "t_stockreport.creator_location_id")->
        where("fairlocation.user_id", $owner_user_id)->
        get();

        foreach ($ts as $t) {
            $smp = DB::table("t_stockreportproduct")->
            where("stockreport_id", $t->id)->
            whereNull("deleted_at")->
            first();

            if (empty($smp)) {
                DB::table("t_stockreport")->
                where("id", $t->id)->
                update([
                    "report_no" => NULL,
                    "updated_at" => Carbon::now(),
                    "deleted_at" => Carbon::now()
                ]);
            }
        }

        /* RECOVERY SECTION */
        $total_t_stockreport_records = DB::table("t_stockreport")->
        join("fairlocation", "fairlocation.id", "=",
            "t_stockreport.creator_location_id")->
        where("fairlocation.user_id", $owner_user_id)->
        groupBy("t_stockreport.report_no")->
        select("t_stockreport.*")->
        whereNull("t_stockreport.deleted_at")->
        get();

        $total_t_stockreports = count($total_t_stockreport_records);
        $max_t_stockreport = DB::table("t_stockreport")->
        join("fairlocation", "fairlocation.id", "=",
            "t_stockreport.creator_location_id")->
        join("t_stockreportproduct", "t_stockreport.id", "=",
            "t_stockreportproduct.stockreport_id")->
        where("fairlocation.user_id", $owner_user_id)->
        orderBy("t_stockreport.id", "DESC")->
        select("t_stockreport.*")->
        whereNull("t_stockreport.deleted_at")->
        first();

        $uniq = array();
        if (!empty($max_t_stockreport) &&
            $total_t_stockreports != $max_t_stockreport->report_no) {

            /* Prepare datastructure of unique report_no and possible
             * stockreport_id that has the same report_no */
            foreach ($total_t_stockreport_records as $k) {
                /* This is a case where report_no is the SAME but valid
                 * with products!! */
                $validrecs = DB::table("t_stockreport")->
                join("fairlocation", "fairlocation.id", "=",
                    "t_stockreport.creator_location_id")->
                where("report_no", $k->report_no)->
                where("fairlocation.user_id", $owner_user_id)->
                whereNull("t_stockreport.deleted_at")->
                select("t_stockreport.*")->
                orderBy("t_stockreport.id")->
                get();

                $procs = array_map(function ($v) {
                    return $v->id;
                }, $validrecs);
                $uniq[$k->report_no] = $procs;

                dump('uniq[' . $k->report_no . ']=' .
                    json_encode($uniq[$k->report_no]));
                /*
                dump($procs);
                dump($validrecs);
                */
            }

            # Recovery
            $i = 1;
            foreach ($uniq as $k => $v) {
                if (!empty($v) and count($v) > 0) {
                    foreach ($v as $pid) {
                        DB::table("t_stockreport")->
                        where("id", $pid)->
                        update(["report_no" => $i]);
                        $i++;
                    }
                }
            }
        }

        /*****************/
        $sm = DB::table("t_stockreport")->
        join("fairlocation", "fairlocation.id", "=",
            "t_stockreport.creator_location_id")->
        join("t_stockreportproduct", "t_stockreportproduct.stockreport_id", "=",
            "t_stockreport.id")->
        where("fairlocation.user_id", $owner_user_id)->
        orderBy("t_stockreport.report_no", "DESC")->
        select("t_stockreport.*")->
        whereNull("t_stockreport.deleted_at")->
        first();

        if (!empty($sm)) {
            $report_no = $sm->report_no + 1;
        }

        /*******************/
        $stockreport_id = DB::table('t_stockreport')->
        insertGetId([
            "creator_user_id" => 360,
            "creator_location_id" => 1,
            "report_no" => $report_no,
            "updated_at" => Carbon::now(),
            "created_at" => Carbon::now()
        ]);

        return $stockreport_id;
    }


    public function mytest()
    {
        $merchant_id = Merchant::where('user_id', Auth::user()->id)->pluck('id');
        $merchant = Merchant::find($merchant_id);
        return $merchant_pro = $merchant->products()
            ->join('merchantproduct as mp', 'mp.product_id', '=', 'product.id')
            ->whereNull('mp.deleted_at')
            ->where('product.status', '!=', 'transferred')
            ->whereNull('product.deleted_at')->select('product.id',
                'product.name',
                'product.brand_id',
                'product.parent_id',
                'product.category_id',
                'product.subcat_id',
                'product.subcat_level',
                'product.segment',
                'product.photo_1',
                'product.photo_2',
                'product.photo_3',
                'product.photo_4',
                'product.photo_5',
                'product.adimage_1',
                'product.adimage_2',
                'product.adimage_3',
                'product.adimage_4',
                'product.adimage_5',
                'product.description',
                'product.free_delivery',
                'product.free_delivery_with_purchase_qty',
                'product.views',
                'product.display_non_autolink',
                'product.del_worldwide',
                'product.del_west_malaysia',
                'product.del_sabah_labuan',
                'product.del_sarawak',
                'product.cov_country_id',
                'product.cov_state_id',
                'product.cov_city_id',
                'product.cov_area_id',
                'product.b2b_del_worldwide',
                'product.b2b_del_west_malaysia',
                'product.b2b_del_sabah_labuan',
                'product.b2b_del_sarawak',
                'product.b2b_cov_country_id',
                'product.b2b_cov_state_id',
                'product.b2b_cov_city_id',
                'product.b2b_cov_area_id',
                'product.del_pricing',
                'product.del_width',
                'product.del_lenght',
                'product.del_height',
                'product.del_weight',
                'product.weight',
                'product.height',
                'product.width',
                'product.length',
                'product.del_option',
                'product.retail_price',
                'product.original_price',
                'product.discounted_price',
                'product.private_retail_price',
                'product.private_discounted_price',
                'product.stock',
                'product.available',
                'product.private_available',
                'product.b2b_available',
                'product.hyper_available',
                'product.owarehouse_moq',
                'product.owarehouse_moqpb',
                'product.owarehouse_moqperpax',
                'product.owarehouse_price',
                'product.measure',
                'product.owarehouse_units',
                'product.owarehouse_ave_unit_price',
                'product.type',
                'product.owarehouse_duration',
                'product.smm_selected',
                'product.oshop_selected',
                'product.mc_sales_staff_id',
                'product.referral_sales_staff_id',
                'product.mcp1_sales_staff_id',
                'product.mcp2_sales_staff_id',
                'product.psh_sales_staff_id',
                'product.osmall_commission',
                'product.b2b_osmall_commission',
                'product.mc_sales_staff_commission',
                'product.mc_with_ref_sales_staff_commission',
                'product.referral_sales_staff_commission',
                'product.mcp1_sales_staff_commission',
                'product.mcp2_sales_staff_commission',
                'product.smm_sales_staff_commission',
                'product.psh_sales_staff_commission',
                'product.str_sales_staff_commission',
                'product.return_policy',
                'product.return_address_id',
                'product.status',
                'product.cashback',
                'product.private_cashback',
                'product.pcashback',
                'product.active_date',
                'product.deleted_at',
                'product.created_at',
                'product.updated_at')->orderBy('product.created_at', 'DESC')->get();
    }
}
