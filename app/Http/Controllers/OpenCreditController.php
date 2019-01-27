<?php

// written by wahid

namespace App\Http\Controllers;

use App\Models\PRef;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UtilityController;
use App\Models\Ocredit;
use App\Models\SMMout;
use App\Models\OpenWish;
use App\Models\OpenWishPledge;
use App\Models\Owarehouse;
use App\Models\Owarehouse_pledge;
use App\Models\Currency;
use App\Models\Cre;
use App\Models\SMMin;
use App\Models\Product;
use App\Models\OrderProduct;
use DB;
use Auth;
use Carbon;
use App\Exceptions\CustomException;
use Exception;
use \Illuminate\Database\QueryException;
class OpenCreditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $smm = DB::select(DB::raw("select so.id as id, po.user_id as uid, oc.source as source, oc.porder_id as porder_id, DATE_FORMAT(si.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value, pmt.receivable as prev, pr.osmall_commission as ocomm, m.smm_sales_staff_commission/100 as smmcomm, case when (pr.osmall_commission > 0 and pr.osmall_commission != null) then pr.osmall_commission/100 when (m.osmall_commission > 0 and m.osmall_commission != null) then m.osmall_commission/100 else g.osmall_commission/100 end as ocomm, oc.id as ocid from global g, merchant m, product pr, payment pmt, ocredit oc, porder po, smmin si, smmout so where pr.id = oc.product_id and m.user_id = po.user_id and pmt.id = po.payment_id and oc.source = 'smm' and oc.porder_id = si.porder_id and si.response = 'buy' and si.smmout_id = so.id group by oc.id order by oc.id desc"));
        
        $openwish = DB::select(DB::raw("select ow.id as id, ow.user_id as uid, oc.source as source, DATE_FORMAT(ow.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value, oc.id as ocid from openwish ow, ocredit oc where oc.openwish_id = ow.id and oc.source = 'openwish' and ow.status = 'expired' group by oc.id order by oc.id desc"));

        // dd($openwish_price);

        $hprice = DB::select(DB::raw("select owh.id as id, owhp.user_id as uid, oc.source as source, oc.porder_id as porder_id, owh.duration as duration, DATE_FORMAT(owh.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value, oc.id as ocid from ocredit oc, owarehouse owh, owarehousepledge owhp, porder po where oc.source='hyper' and owhp.owarehouse_id = owh.id and owh.id = oc.owarehouse_id group by oc.id order by oc.id desc"));

        $hyper = array();

        foreach ($hprice as $key => $hp) {
            $duration = $hp->duration;
            $expiry_date = new \Carbon\Carbon($hp->cdate);
            $expiry_date = $expiry_date->addMinutes($duration);
            $curr_date = Carbon::now();

            if ($expiry_date < $curr_date) {
                $hyper[$key] = $hp;
            }
        }
        // Ordered by CRE
        //$cre = DB::select(DB::raw("select c.id as id, c.user_id as uid, oc.source as source, DATE_FORMAT(c.created_at,'%d%b%y %h:%m') as cdate, oc.product_id as pid, oc.value as value, oc.id as ocid  from cre c, ocredit oc where oc.source = 'cre' and oc.cre_id = c.id and c.status = 'success' group by oc.id order by c.created_at DESC"));

        /*  Paul on 10 May 2017  */
        $cre = UtilityController::admin_opencredit();
        //dd($cre);

        /*foreach ($cre['oc_rows'] as $c) {
            dump($c->uid);
        }*/

        $array_smm = isset($smm) ? $smm : null;
        $array_openwish = isset($openwish) ? $openwish : null;
        $array_cre = isset($cre) ? $cre['oc_rows'] : null;
        $array_hyper = isset($hyper) ? $hyper : null;

        $opencredits = array_merge($array_smm, $array_openwish, $array_hyper, $array_cre);

        $currency = Currency::where('active', 1)->first()->code;

		/*
		dd($array_smm);
		dd($array_openwish);
		dd($array_cre);
		dd($array_hyper);
		dd($opencredits);
		dd($array_cre);
		*/


        return view('opencredit')
                ->with('opencredits', $opencredits)
                ->with('debit', $cre['oc_debit'])
                ->with('credit', $cre['oc_credit'])
                ->with('balance', $cre['ocredit'])
                ->with('currency', $currency);
    }

    public function getSourceDetail(Request $request) {
        $currency = Currency::where('active', 1)->first()->code;
        $source = $request->get('source');
        $userID = $request->get('userID');
        $opencredits=array();
        $id = $request->get('id');
		$orderproducts=null;
		//dd($id);
        $result = array();
        if ($source == 'smm') {
            $smm = SMMout::where('id', $id)->first(['connections', 'created_at']);
            $connection = $smm->connections;
            $datetime = $smm->created_at;
            $prev = $request->get('prev');
            $smmcomm = $request->get('smmcomm');
            $ocomm = $request->get('ocomm');
            $commission = 0;
            if (!is_null($prev) && !is_null($smmcomm) && !is_null($ocomm)) {
                $commission = $prev * $ocomm * $smmcomm;
            } else {
                $commission = 0;
            }
            
            $status = '';

            $duration = DB::table('global')->where('id', 1)->first(['smm_active_duration']);

            $expiry_date = $datetime->addMinutes($duration->smm_active_duration);
            $curr_date = Carbon::now();

            if ($expiry_date < $curr_date) {
                $status = 'Expired';
            } else {
                $status = 'Active';
            }

            $result = [
                'source' => $source,
                'id' => $id,
                'userID' => $userID,
                'productID' => $productID,
                'commission' => isset($commission) ? $commission : null,
                'connection' => isset($connection) ? $connection : null,
                'status' => isset($status) ? $status : null
            ];
        }elseif ($source == 'openwish') {
            $pamount = OpenWishPledge::where('openwish_id', $id)->first();
			
            $ow = OpenWish::where('id', $id)->first();
		//	dd($ow);
            $result = [
                'source' => $source,
                'id' => $id,
                'userID' => $userID,
                'productID' => $ow->product_id,
                'pamount' => isset($pamount->pledged_amt) ? $pamount->pledged_amt : null,
                'duration' => isset($ow->duration) ? $ow->duration : null,
                'status' => isset($ow->status) ? $ow->status : null
            ];
        }elseif ($source == 'hyper') {
            $pamount = Owarehouse_pledge::where('owarehouse_id', $id)->first(['pledged_qty']);
            $owh = Owarehouse::where('id', $id)->first(['duration', 'collection_price', 'created_at']);
            $status = '';

            $duration = $owh->duration;
            $expiry_date = new \Carbon\Carbon($owh->created_at);
            $expiry_date = $expiry_date->addMinutes($duration);
            $curr_date = Carbon::now();

            if ($expiry_date < $curr_date) {
                $status = 'Expired';
            } else {
                $status = 'Active';
            }
        
            
            $result = [
                'source' => $source,
                'id' => $id,
                'userID' => $userID,
                'productID' => $productID,
                'pamount' => isset($pamount->pledged_qty) ? $pamount->pledged_qty : null,
                'price' => isset($owh->collection_price) ? $owh->collection_price : null,
                'duration' => isset($owh->duration) ? $owh->duration : null,
                'status' => isset($status) ? $status : null
            ];
        }elseif ($source == 'cre') {
		//	dd($productID);
           
            $cre = Cre::where('id', $id)->first(['crereason_id','porder_id', 'status', 'type']);
			//dd($cre);
			
			if(!is_null($cre)){
				$orderproducts=DB::table('orderproduct')->where('porder_id',$cre->porder_id)->whereNull('deleted_at')->get();
			}
			//dd($cre->porder_id);
            // $dpr = Product::where('id', $productID)->first();
			$dp = 0;
			// if(!is_null($dpr)){
			// 	$dp = Product::where('id', $productID)->first()->discounted_price;
			// }
                    $dp = 0;
    
            if(!is_null($orderproducts)){
                foreach ($orderproducts as $op) {
                    $dp+=($op->order_price * $op->quantity) + $op->order_delivery_price;
                }
            }

            $value = $dp/100;
            $value = number_format($value, 2);
            $result = [
                'source' => $source,
                'id' => $id,
                'userID' => $userID,
                'productID' => null,
                'value' => isset($value) ? $value : null,
                'creason' => isset($cre->crereason_id) ? $cre->crereason_id : null,
                'type' => isset($cre->type) ? $cre->type : null,
                'status' => isset($cre->status) ? $cre->status : null
            ];
        }

        return view('ocSourceDetails')->with('results', $result)->with('currency', $currency)
            ->with('orderproducts',$orderproducts)
        ;
    }

    public function get_source_id_detail(Request $request) {
        $ref_no = $request->get('ref_no');

        $prefs = PRef::where('ref_no','=', $ref_no)
            ->get(['porder_id']);

//        foreach($prefs as $pref)
//            dump($pref->porder_id);
        
        return view('ocSourceIdDetails')->with('prefs',$prefs);
    }

    public function saveClaim(Request $request) {
        $pending = $request->get('pending');
        $userID = Auth::id();
        $source = 'smm';
        $ocredit = new Ocredit();
        $ocredit->merchant_id = $userID;
        $ocredit->source = $source;
        $ocredit->value = $pending;
        if ($ocredit->save()) {
			$newid = UtilityController::generaluniqueid($ocredit->id, '5','1', $ocredit->created_at, 'nocreditid', 'nocredit_id');
			DB::table('nocreditid')->insert(['nocredit_id'=>$newid, 'ocredit_id'=>$ocredit->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            $unpaid = DB::select(DB::raw("SELECT si.id as siid FROM payment p, sales_staff ss, porder po, smmin si WHERE ss.user_id = $userID and ss.type = 'smm' and ss.user_id = po.user_id and po.payment_id = p.id and si.porder_id = po.id and si.comm_claimed = 0"));

            // dd($unpaid);

            $unpaid = is_array($unpaid) ? $unpaid : null;

            if (isset($unpaid)) {
                foreach ($unpaid as $up) {
                    $si = SMMin::find($up->siid);
                    $si->comm_claimed = 1;
                    $si->save();
                }
            }
            
        }
    }
    // mini helper function
    public function create($porder_id,$value,$merchant_id,$source,$referance_id,$product_id='')
    {
        $error=True;
        $o= new Ocredit;
        if ($product_id!='') {
            $o->product_id=$product_id;
            $o->merchant_id=$merchant_id;
            $o->porder_id=$porder_id;
            $o->value=$value;
            $o->source==$source;
            if ($source=="smm") {
                $o->smmout_id=$referance_id;
                $error=False;
            }
            if ($source=="openwish") {
                $o->openwish_id=$referance_id;
                $error=False;
            }
            if ($source=="hyper") {
                $o->owarehouse_id=$referance_id;
                $error=False;
            }
            if ($source=="cre") {
                $o->cre_id=$referance_id;
                $error=False;
            }
            if ($source=="mcredit") {
                $o->mcredit_id=$referance_id;
                $error=False;
            }
        }
        if ($error==False) {
            $o->save();
			$newid = UtilityController::generaluniqueid($o->id, '5','1', $o->created_at, 'nocreditid', 'nocredit_id');
			DB::table('nocreditid')->insert(['nocredit_id'=>$newid, 'ocredit_id'=>$o->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            return $o;
        }
        else{return False;}
    }
    // Function to write in Ocredit:
    public static function add_oc($porder_id,$value,$merchant_id,$source,$pid='',$cre_id='',$smmout_id='',$openwish_id='',$owarehouse_id='',$mcredit_id='')
    {
        /* This function requires highest level of security. Before writing a record, a check would be made for a porder_id and product_id*/
        $doesExists=null;
        if ($pid=="" and $porder_id!="") {
            # $pid is product_id
            $doesExist=Ocredit::where('porder_id',$porder_id)->first();
            if (!is_null($doesExist)) {
                return False;
            }
        }
        if ($pid!="" and $porder_id!="") {
            $doesExist=Ocredit::where('porder_id',$porder_id)->first();
            if (!is_null($doesExist)) {
                return False;
            }
        }
        if ($porder_id='' or is_null($porder_id)) {
            return False;
        }
        if ($value==0 or is_null($value) or $value<0) {
            return False;
        }
        /* By now all security and logical should have been done and passed*/

        try {
            if ($source=="smm") {
                $this->create($porder_id,$value,$merchant_id,$source,$smmout_id,$product_id);
                return True;
            }
            if ($source=="openwish") {
                $this->create($porder_id,$value,$merchant_id,$source,$openwish_id,$product_id);
                return True;
            }
            if ($source=="hyper") {
                $this->create($porder_id,$value,$merchant_id,$source,$owarehouse_id,$product_id);
                return True;
            }
            if ($source=="cre") {
                $this->create($porder_id,$value,$merchant_id,$source,$cre_id,$product_id);
                return True;
            }
            if ($source=="mcredit") {
                $this->create($porder_id,$value,$merchant_id,$source,$mcredit_id,$product_id);
                return True;
            }
            return False;
        } catch (\Exception $e) {
            return False;
        }
    }

    public static function get_ocredit($user_id)
    {
        $smm=SMMout::join('smmin as sin','sin.smmout_id','=','smmout.id')
            ->join('ocredit','ocredit.smmout_id','=','smmout.id')
            ->join('product','product.id','=','smmout.product_id')
            ->join('porder','porder.id','=','sin.porder_id')
            ->join('nporderid','nporderid.porder_id','=','porder.id')
            ->where('smmout.user_id',$user_id)
            ->where('ocredit.mode','credit')
            ->where('ocredit.value','>',0)
            ->select(DB::raw("
                ocredit.id as ocredit_id,
                porder.id as id,
                nporderid.nporder_id as nporder_id,
                porder.id as porder_id,
                ocredit.mode as mode,
                ocredit.source as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;

        // return $smm->get();
        $openwish_pledged=Ocredit::join('openwish','ocredit.openwish_id','=','openwish.id')
            ->join('product','product.id','=','openwish.product_id')
            ->join('openwishpledge','openwishpledge.openwish_id','=','openwish.id')

            ->where('openwishpledge.user_id',$user_id)
            ->where('ocredit.mode','debit')
            ->where('ocredit.source','openwish')
            ->select(DB::raw("
                ocredit.id as ocredit_id,
                ocredit.id as id,
                openwish.id as nporder_id,
                openwish.id as porder_id,
                ocredit.mode as mode,
                ocredit.source as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        /*Danger Error in logic.*/ 

        $openwish_earned=Ocredit::join('openwish','ocredit.openwish_id','=','openwish.id')
            ->join('nopenwishid','openwish.id','=','nopenwishid.openwish_id')
            ->join('product','product.id','=','openwish.product_id')
            ->where('openwish.user_id',$user_id)
            ->where('ocredit.mode','credit')
            ->where('ocredit.source','openwish')
            ->select(DB::raw("
                ocredit.id as ocredit_id,
                ocredit.id as id,
                nopenwishid.nopenwish_id as nporder_id,
                openwish.product_id as porder_id,
                ocredit.mode as mode,
                ocredit.source as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        $cre=Ocredit::join('cre','ocredit.cre_id','=','cre.id')
            ->join('porder','porder.id','=','cre.porder_id')
            ->join('ncreid','ncreid.cre_id','=','cre.id')
            ->where('porder.user_id',$user_id)
            ->where('ocredit.mode','credit')
            ->where('ocredit.source','cre')
            ->select(DB::raw("
                ocredit.id as ocredit_id,
                ocredit.id as id,
                ncreid.ncre_id as nporder_id,
                porder.id as porder_id,
                ocredit.mode as mode,
                ocredit.source as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        $purchase=Ocredit::join('porderrefno as prr','ocredit.ref_no','=','prr.ref_no')
             ->join('porder','prr.porder_id','=','porder.id')
            ->join('nporderid','nporderid.porder_id','=','porder.id')
            ->where('porder.user_id',$user_id)
            ->where('ocredit.mode','debit')

            ->select(DB::raw("
                ocredit.id as ocredit_id,
                ocredit.id as id,
                prr.ref_no as nporder_id,
                prr.ref_no as porder_id,
                ocredit.mode as mode,
                ocredit.source as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        // $purchase=array();
        $opencredits=$smm->union($cre)->union($purchase)->union($openwish_earned)->union($openwish_pledged)->orderBy('id','DESC')->get();
        return $opencredits;

    }

    public static function save_nocredit_id($ocredit)
    {
        $ret=1;
        try {
            $newid = $newid = UtilityController::generaluniqueid($ocredit->id, '5','1', $ocredit->created_at, 'nocreditid', 'nocredit_id');
            DB::table('nocreditid')->insert(['nocredit_id'=>$newid, 'ocredit_id'=>$ocredit->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);

        } catch (\Exception $e) {
            dump($e);
            $ret=0;
        }
        return $ret;
    }

    /*This function is more detailed and useful for getting opencredit records for a user_id. For buyer display purpose only*/
    public static function detailed_ocredit($user_id)
    {
        $smm=SMMout::join('smmin as sin','sin.smmout_id','=','smmout.id')
            ->join('ocredit','ocredit.smmout_id','=','smmout.id')
            ->join('porder','porder.id','=','sin.porder_id')
            ->join('nporderid','nporderid.porder_id','=','porder.id')
            ->join('product','product.id','=','product.parent_id')
            ->join('nproductid','nproductid.product_id','=','product.id')
            ->where('smmout.user_id',$user_id)
            ->select(DB::raw("
                ocredit.id as id,
                nproductid.nproduct_id as n_id,
                product_id.id as m_id,
                ocredit.mode as mode,
                'SMM' as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        // return $smm->get();
        $openwish=Ocredit::join('openwish','ocredit.openwish_id','=','openwish.id')
            ->join('openwishpledge','openwishpledge.openwish_id','=','openwish.id')
            ->where('openwishpledge.user_id',$user_id)
            ->select(DB::raw("
                ocredit.id as id,
                openwish.id as nporder_id,
                openwish.id as porder_id,
                ocredit.mode as mode,
                'OpenWish' as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;

        $cre=Ocredit::join('cre','ocredit.cre_id','=','cre.id')
            ->join('porder','porder.id','=','cre.porder_id')
            ->join('ncreid','ncreid.cre_id','=','cre.id')
            ->where('porder.user_id',$user_id)
            ->select(DB::raw("
                ocredit.id as id,
                ncreid.ncre_id as nporder_id,
                porder.id as porder_id,
                ocredit.mode as mode,
                'CRE' as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        $purchase=Ocredit::join('porderrefno as prr','ocredit.ref_no','=','prr.ref_no')
             ->join('porder','prr.porder_id','=','porder.id')
            ->join('nporderid','nporderid.porder_id','=','porder.id')
            ->where('porder.user_id',$user_id)
            ->select(DB::raw("
                ocredit.id as id,
                prr.ref_no as nporder_id,
                prr.ref_no as porder_id,
                ocredit.mode as mode,
                'PURCHASE' as source,
                ocredit.value as value,
                DATE_FORMAT(ocredit.created_at,'%d%b%y %h:%m') as cdate
                "))
            ;
        $opencredits=$smm->union($cre)->union($purchase)->union($openwish)->orderBy('id','DESC')->get();
        return $opencredits;

    }

    public function get_opencredit_buyer($buyer_id)
    {
        # code...
        $ret=array();
        $ret['status']="failure";
        try {
            $user_id=DB::table('nbuyerid')->where('nbuyer_id',$buyer_id)->pluck('user_id');
            if (empty($user_id)) {
                $ret['long_message']="Buyer ID not correct";
                return response()->json($ret);
            }
            $oc=UtilityController::ocredit($user_id);
            $debit=$oc['oc_debit'];
            $credit=$oc['oc_credit'];
            $balance=$credit-$debit;
            $ret['debit']=number_format($debit/100,2);
            $ret['credit']=number_format($credit/100,2);
            $ret['balance']=number_format($balance/100,2);
            $ret['status']="success";
        } catch (\Exception $e) {
            $status['short_message']=$e->getMessage();
            $status['long_message']="Server error happened. Please contact OpenSupport";
        }

        return response()->json($ret);
        
    }
 
}
