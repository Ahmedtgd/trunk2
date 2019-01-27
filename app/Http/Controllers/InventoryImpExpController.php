<?php

namespace App\Http\Controllers;

use App\lib\Date;
use App\Models\Inventorycost;
use App\Models\Merchant;
use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Compound;


class InventoryImpExpController extends Controller
{



    public function index(){
        return view('merchant.inv_importexport');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function exports($uid = null)
    {

            $limit = 60;
            $num = 0;
            ob_end_clean();
            ob_start();

            $user_id = Auth::user()->id;
            if(!empty($uid) and Auth::user()->hasRole('adm')){
                $user_id=$uid;
            }

            $selluser = User::find($user_id);
            Log::debug('selluser_id=' .$user_id);

            $merchant = Merchant::where('user_id','=',$user_id)->first();
            $merchant_id = $merchant->id;

         /*$products = DB::table('product')
                    ->leftJoin('product as pb2b','product.id','=','pb2b.parent_id')
                    ->leftJoin('locationproduct','product.id','=','locationproduct.product_id')
                    ->leftJoin('inventorycostproduct','product.id','=','inventorycostproduct.product_id')
                    ->join('merchantproduct','product.id','=','merchantproduct.product_id')
                    ->join('merchant','merchantproduct.merchant_id','=','merchant.id')
                    ->join('nproductid','product.id','=','nproductid.product_id')
                    ->where('merchantproduct.merchant_id',$merchant_id)
                    ->where("product.status","!=","transferred")
                    ->where("product.status","!=","deleted")
                    ->where("product.status","!=","")
                    ->select('nproductid.nproduct_id','product.name','product.available', 'locationproduct.quantity')
                    ->selectRaw('
                            inventorycostproduct.cost * inventorycostproduct.quantity /inventorycostproduct.quantity  as average_cost
                        ')

                    ->selectRaw('product.available + locationproduct.quantity as total')
                    ->groupBy('product.id')
                    ->orderBy('locationproduct.quantity','DESC')
                    ->distinct()
                    ->get();*/

        /*->join('fairlocation','locationproduct.location_id','=','fairlocation.id')*/

            //$i = 0;
            //see item
            /*foreach ($products as $key => $value) {
                $data[$key]['No'] = ++$i;
                $data[$key]['Product ID'] = $value->nproduct_id;
                $data[$key]['Product Name'] = $value->name;
                //$data[$key]['Location ID'] = $value->location_id;
                $data[$key]['Online Qty'] = $value->available;
                $data[$key]['Offline Qty '] = $value->quantity;
                $data[$key]['Average Cost'] = $value->average_cost;
                $data[$key]['Total'] = $value->total;

            }*/

         //echo Auth::user()->id;

        if(!is_null($merchant)) {
            $product = $merchant->products()
                ->whereNull('product.deleted_at')
                ->leftJoin('product as productb2b', function ($join) {
                    $join->on('product.id', '=', 'productb2b.parent_id')
                        ->where('productb2b.segment', '=', 'b2b');
                })
                ->leftJoin('product as producthyper', function ($join) {
                    $join->on('product.id', '=', 'producthyper.parent_id')
                        ->where('producthyper.segment', '=', 'hyper');

                })
                ->leftJoin('tproduct as tproduct', function ($join) {
                    $join->on('product.id', '=', 'tproduct.parent_id');
                })

                ->leftJoin('inventorycostproduct','product.id','=','inventorycostproduct.product_id')
                ->leftJoin('inventorycost','inventorycostproduct.inventorycost_id', '=','inventorycost.id')
                ->join('nproductid', 'product.id', '=', 'nproductid.product_id')
                ->leftJoin('productbc', 'product.id', '=', 'productbc.product_id')
                ->leftJoin('bc_management', 'bc_management.id', '=', 'productbc.bc_management_id')
                ->select(DB::raw('
                product.id as id,
                product.parent_id,
                bc_management.id as bc_management_id,
                productbc.deleted_at as pbdeleted_at,
                product.name as product_name,
                product.thumb_photo as photo_1,
                product.available,
                productb2b.available as availableb2b,
                producthyper.available as availablehyper,
                tproduct.available as warehouse_available,
                nproductid.nproduct_id as pid,
                
                inventorycostproduct.cost * inventorycostproduct.quantity /inventorycostproduct.quantity  as average_cost,
                
                product.sku'))
                /*->where('product.id',2699)*/
                // ->whereNull('bc_management.deleted_at')
                ->groupBy('product.id')
                // ->limit(2) //danger Danger , to be commented in production
                ->where("product.status", "!=", "transferred")
                ->where("product.status", "!=", "deleted")
                ->where("product.status", "!=", "")
                ->get();



            $average_cost = Inventorycost::where('inventorycost.buyer_merchant_id'
                ,$merchant_id)->
            join('inventorycostproduct','inventorycostproduct.inventorycost_id',
                '=','inventorycost.id')->
            join('product','product.id','=',
                'inventorycostproduct.product_id')->
//            join('product as parent','product.id','=','product.parent_id')->
            get([
                'inventorycostproduct.product_id',
                'inventorycostproduct.quantity',
                'inventorycostproduct.cost',
                'product.parent_id',
            ])->groupby('product_id');
            //      ])->groupby('tproduct_id');

            /*
            Log::debug('******** merchantinventory() ********');
            Log::debug($average_cost);
            */

            $count =0;

            foreach ($average_cost as $key => $value1) {
                //$avg = array();
                $add = 0;
                $qty = 0;
                foreach ($value1 as $vv) {
                    $add +=  ($vv->cost * $vv->quantity);
                    $qty += ($vv->quantity);
                }
                $avg[$key] = $add/$qty;
            }




               $pr = new ProductController;

               foreach ($product as $key => $value) {

                   $totalb2b = 0;
                   $b2b = 0;
                   $term = 0;
                   $hyper = 0;

                   $value->consignment_total = $pr->consignment($value->id,$user_id);
                   $offline=$value->consignment_total;
                   $pname = $value->product_name;


                   if(!is_null($value->availableb2b))
                      { $b2b= $value->availableb2b; }

                   if(!is_null($value->warehouse_available))
                      { $term= $value->warehouse_available; }

                   if(!is_null($value->availablehyper))
                      { $hyper= $value->availablehyper; }

                   $totalb2b = $b2b + $term;
                   $totaldef = $b2b + $term + $hyper + $value->available;


                   $totalavailable = $value->available + $totalb2b + $value->availablehyper;

                   $totalavailable += $value->consignment_total;



                   if (strlen($pname) > $limit) {
                       $pname = substr($pname, 0, $limit - 3);
                       $pname .= "...";

                   }


                   if (empty($totaldef)){

                       if(isset($avg[$value->id])){
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format(0);
                           $data[$key]['Offline'] = number_format($offline);
                           $data[$key]['Cost'] = number_format($avg[$value->id]/100,2);
                           $data[$key]['Total']=number_format($totalavailable);
                       }

                       else{
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format(0);
                           $data[$key]['Offline'] = number_format($offline);
                           $data[$key]['Cost'] = number_format(0,2);
                           $data[$key]['Total']=number_format($totalavailable);
                       }

                   }


                   elseif (empty($offline)){
                       if(isset($avg[$value->id])){
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format($totaldef);
                           $data[$key]['Offline']= number_format(0);
                           $data[$key]['Cost'] = number_format($avg[$value->id]/100,2);
                           $data[$key]['Total']=number_format($totalavailable);
                       }

                       else{
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format($totaldef);
                           $data[$key]['Offline']= number_format(0);
                           $data[$key]['Cost'] = number_format(0,2);
                           $data[$key]['Total']=number_format($totalavailable);
                       }
                   }


                   elseif (empty($totaldef) && empty($offline)){

                       if(isset($avg[$value->id])){
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format(0);
                           $data[$key]['Offline']= number_format(0);
                           $data[$key]['Cost'] = number_format($avg[$value->id]/100,2);
                           $data[$key]['Total']=number_format(0);
                       }

                       else{
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format(0);
                           $data[$key]['Offline']= number_format(0);
                           $data[$key]['Cost'] = number_format(0,2);
                           $data[$key]['Total']=number_format(0);
                       }

                   }


                   else{

                       if(isset($avg[$value->id])){
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format($totaldef);
                           $data[$key]['Offline']=number_format($offline);
                           $data[$key]['Cost'] = number_format($avg[$value->id]/100,2);
                           $data[$key]['Total']=number_format($totalavailable);
                       }

                       else{
                           $data[$key]['No'] = number_format(++$num);
                           $data[$key]['Product ID'] = $value->pid;
                           $data[$key]['Product Name'] = $pname;
                           $data[$key]['Online'] = number_format($totaldef);
                           $data[$key]['Offline']=number_format($offline);
                           $data[$key]['Cost'] = number_format(0,2);
                           $data[$key]['Total']=number_format($totalavailable);
                       }

                   }


               }

        }


return Excel::create('Merchant Inventory'.'-'.\date('d/m/y'), function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {

                $sheet->fromArray(array(array('Merchant Inventory',\date('d/m/y'))));
                $sheet->fromArray($data)->setAutoSize(true);
                $sheet->cell(1, function($row) {
                    $row->setBackground('#CCCCCC');
                });

            });
        })->export('xlsx');
    }

}