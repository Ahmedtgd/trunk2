<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
// use App\Models\;
use App\Models\Merchant;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\POrder;
use App\Models\Receipt;
use App\Models\OrderProduct;
use App\Models\DeliveryOrder;

class AppBuyingProcessController extends Controller
{
    /*
        This controller is only for requests via app.
        This controller only controls the buying process
        All requests are POST
        All responses are json
        routes are in app/Http/Routes/AppRoutes.php

    */

    public function updateStatus($r, $status, $pstatus)
    {
        $ret = 0;
        try {
            $oid = $r->oid;
            $skey = $r->skey;
            $d = DB::table('delivery')
                ->where('pickup_password', $skey)
                ->first();
            if (!is_null($d) and $d->porder_id == $oid) {
                // Check the password type
                $ret = -1;
                $type = $d->type;
                $p = POrder::find($oid);
                switch ($type) {
                    case 'm2b':
                        if ($p->status == "l-collected1") {
                            $status = "m-collected";
                            $pstatus = "l-collected1";
                            $p->status = $status;
                            $p->save();
                            $ops = OrderProduct::where('porder_id', $oid)
                                ->where('status', $pstatus)
                                ->get();
                            foreach ($ops as $op) {
                                $o = OrderProduct::find($op->id);
                                $o->status = $status;
                                $o->save();
                            }
                            $ret = 1;
                        }
                        if ($p->status == "l-processing") {
                            $status = "l-collected";
                            $pstatus = "l-processing";
                            $p->status = $status;
                            $p->save();
                            $ops = OrderProduct::where('porder_id', $oid)
                                ->where('status', $pstatus)
                                ->get();
                            foreach ($ops as $op) {
                                $o = OrderProduct::find($op->id);
                                $o->status = $status;
                                $o->save();
                            }
                            $ret = 2;
                        }
                        break;
                    case 'b2m':
                        if ($p->status == $pstatus) {
                            $p->status = $status;
                            $p->save();
                            $ops = OrderProduct::where('porder_id', $oid)
                                ->where('status', $pstatus)
                                ->get();
                            foreach ($ops as $op) {
                                $o = OrderProduct::find($op->id);
                                $o->status = $status;
                                $o->save();
                            }
                            $ret = 3;
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }

            // Validation

        } catch (\Exception $e) {
            $ret = 99;
        }
        return $ret;
    }

    public function message($result)
    {
        if ($result > 0 and $result != 99) {
            $m = [
                "status" => "success",
                "short_message" => "us",
                "long_message" => "Order status has been updated"
            ];
        } else {
            $m = [
                "status" => "failure",
                "short_message" => "excep" . $result,
                "long_message" => "Order status could not be updated.Wrong Password"
            ];
        }
        return $m;
    }


    public function lscanB(Request $r)
    {
        $status = "l-collected1";
        $pstatus = "l-processing";
        //  Paul: Now this Method not only Authenticate
        //  but also Saves Image (Signature)
        $result = $this->authPassword($r);
        // return $result;
        $m = $this->message($result);

        return response()->json($m);
    }
	
	public function blscanB(Request $r)
    {
        $status = "l-collected1";
        $pstatus = "l-processing";
        //  Paul: Now this Method not only Authenticate
        //  but also Saves Image (Signature)
        $result = $this->authPasswordb($r);
		//dd($result);
        // return $result;
        $m = $this->message($result);

        return response()->json($m);
    }

    public function saveImage($r)
    {
        $return = 0;
        //  Paul
        if ($r->imgBase64 != null)
        {
            //	Paul on 13 April 2017
            $oid = $r->oid;
            $img = $r->imgBase64;

            $img = str_replace('data:image/png;base64,', '', $img);

            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);

            //saving
            $fileName = $oid.'-'.$r->skey. '.png';
            //dump($fileName);
            $filepath = public_path('/images/pod/' . $fileName);

            if(file_put_contents($filepath, $fileData) > 0)
                $return = 1;

            try {
                // Create folder
                mkdir($fileName, 0775, true);
            } catch (\Exception $e) {}

            if(file_put_contents($filepath, $fileData) > 0)
                $return = 1;
        }
        return $return;
    }

    //  Ends Here

    public function authPassword($r)
    {
        // Add consignment Number.

        $ret = 0;
        $skey = $r->skey;
        $oid = $r->oid;
        $type = $r->type;
        $cn = $r->cn;
        //dump($cn);
        // Find PORDER
        $po = POrder::find($oid);
        if (is_null($po)) {
            $ret = -1;
            return $ret;
        }
        $do = DB::table('delivery')
            ->where('pickup_password', $skey)
            ->first();

        // if ($do->status == "delivered") {
        //     $ret=-2;
        //     return $ret;
        // }
        if (is_null($do) and $po->status != "l-collected") {
            $ret = -2;
            return $ret;
        }
        // dd($do);
        // if (!is_null($do) and
        //			$do->status=="delivered" and
        //			$do->consignment_number!=$cn) {
        //     $ret=-3;
        //     return $ret;
        // }

        switch ($po->status) {
            case 'l-collected':
                /* The password is the receipt password here. We need to
                 * update the order status as well as orderproduct status.
                 * We also need to check if the security matches the receipt
                 * password.*/
                try {
                    $porder_id = $po->id;
                    $password = $skey;

                    $deliveryorder = DeliveryOrder::join('receipt',
                                        'deliveryorder.receipt_id', '=', 'receipt.id')->
                                        where('receipt.porder_id', $porder_id)->
                                        select('deliveryorder.*')->first();

                    $receipt = Receipt::where('id',
                        $deliveryorder->receipt_id)->first();

                    // Testing for password match.
                    
                    if ($password === $receipt->do_password) {

                        try {
                            DOController::processOrder($porder_id,
                                $deliveryorder);

                            DB::table('delivery')->
                            where('porder_id', $porder_id)->
                            where('type', 'm2b')->
                            update(['status' => 'delivered']);

                            $ret = 1;

                            //  Paul
                            $ret = $this->saveImage($r);

                        } catch (\Exception $e) {

                            $ret = -6;

                        }

                    } else {
                        $ret = -5;

                    }
                } catch (\Exception $e) {
                    // return $e;
                    $ret = -4;

                }
                return $ret;
                break;
            case 'l-collected1':
                # code...
                if ($do->porder_id == $po->id and $do->type == "m2b") {
                    $po->status = "m-collected";
                    OrderProduct::where('porder_id', $po->id)
                        ->where('status', 'l-collected1')
                        ->update(['status' => 'm-collected']);
                    $po->save();
                    DB::table('delivery')
                        ->where('porder_id', $do->porder_id)
                        ->where('type', 'b2m')
                        ->where('id', $do->id)
                        ->update(['status' => 'delivered']);

                    $ret = 1;

                    //  Paul
                    $ret = $this->saveImage($r);
                } else {
                    $ret = -7;
                }

                return $ret;
                break;
            case 'l-processing':
                /*This is when the merchant enters the password at the time of logistic coming to collect package from merchant */
                if ($do->porder_id == $po->id and $do->consignment_number == $cn) {
                    $po->status = "l-collected";
                    OrderProduct::where('porder_id', $po->id)
                        ->where('status', 'l-processing')
                        ->update(['status' => 'l-collected']);
                    $po->save();
                    $ret = 1;
                } else {
                    $ret = -8;
                }

                return $ret;
                break;
            case 'l-processing2':
                /* This is when logistic has initiated return delivery*/
                if ($do->porder_id == $po->id and $do->consignment_number == $cn) {
                    $po->status = "l-collected1";
                    OrderProduct::where('porder_id', $po->id)
                        ->where('status', 'l-processing2')
                        ->update(['status' => 'l-collected1']);
                    $po->save();
                    $ret = 1;
                } else {
                    $ret = -9;
                }

                return $ret;
                break;
            case 'manual':
                # code...
                break;
            default:
                $ret = -3;
                return $ret;
                break;
        }
    }

    public function authPasswordb($r)
    {
        // Add consignment Number.

        $ret = 0;
        $skey = $r->skey;
        $dname = $r->dname;
        $nric = $r->nric;
        $oid = $r->oid;
        $type = $r->type;
        $cn = $r->cn;
        //dump($cn);
        // Find PORDER
        $po = POrder::find($oid);
        if (is_null($po)) {
            $ret = -1;
            return $ret;
        }
        $do = DB::table('delivery')
            ->where('pickup_password', $skey)
            ->first();

        // if ($do->status == "delivered") {
        //     $ret=-2;
        //     return $ret;
        // }
		
        if (is_null($do) and $po->status != "l-collected") {
            $ret = -2;
            return $ret;
        } else {
			DB::table('delivery')->where('pickup_password', $skey)->update(['pickup_name' => $dname, 'pickup_nric' => $nric]);
		}
        // dd($do);
        // if (!is_null($do) and
        //			$do->status=="delivered" and
        //			$do->consignment_number!=$cn) {
        //     $ret=-3;
        //     return $ret;
        // }

        switch ($po->status) {
            case 'l-collected':
                /* The password is the receipt password here. We need to
                 * update the order status as well as orderproduct status.
                 * We also need to check if the security matches the receipt
                 * password.*/
                try {
                    $porder_id = $po->id;
                    $password = $skey;

                    $deliveryorder = DeliveryOrder::join('receipt',
                                        'deliveryorder.receipt_id', '=', 'receipt.id')->
                                        where('receipt.porder_id', $porder_id)->
                                        select('deliveryorder.*')->first();

                    $receipt = Receipt::where('id',
                        $deliveryorder->receipt_id)->first();

                    // Testing for password match.
                    if ($password === $receipt->do_password) {
                        try {
                            DOController::processOrder($porder_id,
                                $deliveryorder);

                            DB::table('delivery')->
                            where('porder_id', $porder_id)->
                            where('type', 'm2b')->
                            update(['status' => 'delivered']);

                            $ret = 1;

                            //  Paul
                            $ret = $this->saveImage($r);

                        } catch (\Exception $e) {

                            $ret = -6;

                        }

                    } else {
                        $ret = -5;

                    }
                } catch (\Exception $e) {
                    // return $e;
                    $ret = -4;

                }
                return $ret;
                break;
            case 'l-collected1':
                # code...
                if ($do->porder_id == $po->id and $do->type == "m2b") {
                    $po->status = "m-collected";
                    OrderProduct::where('porder_id', $po->id)
                        ->where('status', 'l-collected1')
                        ->update(['status' => 'm-collected']);
                    $po->save();
                    DB::table('delivery')
                        ->where('porder_id', $do->porder_id)
                        ->where('type', 'b2m')
                        ->where('id', $do->id)
                        ->update(['status' => 'delivered']);

                    $ret = 1;

                    //  Paul
                    $ret = $this->saveImage($r);
                } else {
                    $ret = -7;
                }

                return $ret;
                break;
            case 'l-processing':
                /*This is when the merchant enters the password at the time of logistic coming to collect package from merchant */
			/*	dump($do->porder_id);
				dump($po->id);
				dump($do->consignment_number);
				dd($cn);*/
                if ($do->porder_id == $po->id and $do->consignment_number == $cn) {
                    $po->status = "l-collected";
                    OrderProduct::where('porder_id', $po->id)
                        ->where('status', 'l-processing')
                        ->update(['status' => 'l-collected']);
                    $po->save();
                    $ret = 1;
                } else {
                    $ret = -8;
                }

                return $ret;
                break;
            case 'l-processing2':
                /* This is when logistic has initiated return delivery*/
                if ($do->porder_id == $po->id and $do->consignment_number == $cn) {
                    $po->status = "l-collected1";
                    OrderProduct::where('porder_id', $po->id)
                        ->where('status', 'l-processing2')
                        ->update(['status' => 'l-collected1']);
                    $po->save();
                    $ret = 1;
                } else {
                    $ret = -9;
                }

                return $ret;
                break;
            case 'manual':
                # code...
                break;
            default:
                $ret = -3;
                return $ret;
                break;
        }
    }	
	
}
