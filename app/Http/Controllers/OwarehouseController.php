<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\Globals;
use App\Models\Owarehouse;
use App\Models\Owarehouse_pledge;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\GlobalT;

use Illuminate\Http\Request;
use DateTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Cart;
class OwarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
    {
          // if(!Auth::check()) return redirect('/'); 
        // $merchants = Product::leftJoin('merchantproduct as mp','product.id','=','mp.product_id')
        //                  ->leftJoin('merchant as m','m.id','=','mp.merchant_id')
        //                  ->where('owarehouse_moq','>','0')
        //                  ->where('owarehouse_price','>','0')
  //                           ->where('owarehouse_ave_unit_price','>','0')
  //                           ->where('owarehouse_duration','>','0')
        //                  ->select(DB::raw('m.id as m_id,m.oshop_name,product.subcat_level'))
        //                  ->get();

       // $category = Category::all();
        // $subcategory = DB::select(DB::raw('select mp.merchant_id,s.id,s.name from product p left join subcat_level_1 s on p.subcat_id = s.id left join merchantproduct mp on mp.product_id = p.id where p.subcat_level = 1 Union select mp.merchant_id,s.id,s.name from product p left join subcat_level_2 s on p.subcat_id = s.id left join merchantproduct mp on mp.product_id = p.id where p.subcat_level = 2 Union select mp.merchant_id,s.id,s.name from product p left join subcat_level_3 s on p.subcat_id = s.id left join merchantproduct mp on mp.product_id = p.id where p.subcat_level = 3'));
	   $global_system_vars = DB::table('global')->first();
      $duration = $global_system_vars->hyper_duration;
      $category = DB::select(DB::raw('SELECT
    GROUP_CONCAT(DISTINCT (s))      AS sub_cat,
    c                               AS cat_name,
    logo,
    GROUP_CONCAT(DISTINCT (sub_id)) AS sub_id
FROM (SELECT
          -- mp.section_id,
          CONCAT(s.id , "-", "1")  AS sub_id,
          s.description AS s,
          c.description AS c,
          c.id          AS cat_id,
          c.logo_green  AS logo,
          c.floor       AS floor
      FROM product p 
          LEFT JOIN subcat_level_1 s ON p.subcat_id = s.id
          LEFT JOIN oshopproduct mp ON mp.product_id = p.id
          LEFT JOIN owarehouse ow ON ow.product_id=p.id
          -- LEFT JOIN sectionproduct mp ON mp.product_id = p.id
          -- LEFT JOIN section mp ON mp.id = sp.section_id
          LEFT JOIN merchantproduct  ON merchantproduct.product_id = p.parent_id
          LEFT JOIN merchant ON merchant.id=merchantproduct.merchant_id
          LEFT JOIN oshop ON mp.oshop_id=oshop.id
          LEFT JOIN category c ON c.id = p.category_id
      WHERE p.subcat_level = 1 and ow.moq>0 and p.owarehouse_moqperpax > 0 and  p.owarehouse_price > 0 and p.oshop_selected=1 and p.status="active" and ow.product_id=p.id and ow.status="active" and
                and merchant.status="active" and oshop.status="active"

       NOW() <= DATE_ADD(ow.created_at,INTERVAL '.$duration.' DAY) 
      UNION SELECT
                --  mp.section_id,
                CONCAT(s.id , "-", "2")       AS sub_id,
                s.description AS s,
                c.description AS c,
                c.id          AS cat_id,
                c.logo_green  AS logo,
                c.floor       AS floor
            FROM product p LEFT JOIN subcat_level_2 s ON p.subcat_id = s.id
                LEFT JOIN oshopproduct mp ON mp.product_id = p.id
                LEFT JOIN owarehouse ow ON ow.product_id=p.id
                -- LEFT JOIN sectionproduct mp ON mp.product_id = p.id
                LEFT JOIN category c ON c.id = p.category_id
            WHERE p.subcat_level = 2 and ow.moq>0 and  p.owarehouse_moqperpax > 0 and  p.owarehouse_price > 0 and p.oshop_selected=1 and p.status="active" and ow.product_id=p.id and ow.status="active" and NOW() <= DATE_ADD(ow.created_at,INTERVAL '.$duration.' DAY)
      UNION SELECT
                -- mp.section_id,
                CONCAT(s.id , "-", "3")         AS sub_id,
                s.description AS s,
                c.description AS c,
                c.id          AS cat_id,
                c.logo_green  AS logo,
                c.floor       AS floor
            FROM product p LEFT JOIN subcat_level_3 s ON p.subcat_id = s.id
                LEFT JOIN oshopproduct mp ON mp.product_id = p.id
                LEFT JOIN owarehouse ow ON ow.product_id=p.id
                -- LEFT JOIN sectionproduct mp ON mp.product_id = p.id
                LEFT JOIN category c ON c.id = p.category_id
            WHERE p.subcat_level = 3 and ow.moq>0 and  p.owarehouse_moqperpax > 0 and  p.owarehouse_price > 0 and p.oshop_selected=1 and p.status="active" and ow.product_id=p.id and ow.status="active" and NOW() <= DATE_ADD(ow.created_at,INTERVAL '.$duration.' DAY)
            ) AS t
GROUP BY cat_id
ORDER BY floor, s'
                ));
      // return $category;
      // Alternative Query by Zurez or maybe filter the existing query
      //Get all product ids.
      // return $category[0]->cat_name;
      // $product_ids= DB::table('owarehouse')->distinct()->lists('product_id');
      // $cat_ids= DB::table('product')->whereIn('id',$product_ids)->distinct()->lists('subcat_id');
      // return $cat_ids;
      // Filtered for no product; Not efficient though! Needs to be optimised
      // $test=array();
      // $filtered_category=array();
      // foreach ($category as $cat) {
      //     $temp=array();
      //     $temp['cat_name']=$cat->cat_name;
      //     $temp['logo']=$cat->logo;
      //     $filtered_subcat_ids="";
      //     $filtered_subcat_names="";
      //     $temp_cat_ids= explode(',',$cat->sub_id);
      //     $temp_cat_names=explode(',',$cat->sub_cat);
      //     $filtered_subcat=array_intersect($cat_ids,$temp_cat_ids);
      //     array_push($test,$filtered_subcat);
      //     foreach ($filtered_subcat as $fs) {
      //         $index= array_search($fs,$temp_cat_ids);
      //         $filtered_subcat_names.=$temp_cat_names[$index];
      //         $filtered_subcat_ids.=$fs;
      //     }

      //     $temp['sub_cat']=$filtered_subcat_names;
      //     $temp['sub_id']=$filtered_subcat_ids;
      //     if ($filtered_subcat_names!="") {
      //       # code...
      //       array_push($filtered_category,$temp);
      //     }
          
      // }
      // return $filtered_category;



        $firstLetter = '';
        $firstRun = true;

        $letters['AD'] = array('A','B','C','D');
        $letters['EH'] = array('E','F','G','H');
        $letters['IL'] = array('I','J','K','L');
        $letters['MP'] = array('M','N','O','P');
        $letters['QT'] = array('Q','R','S','T');
        $letters['UX'] = array('U','V','W','X');
        $letters['YZ'] = array('Y','Z');


        // return $category;

        return view('owarehouselist')
            ->with('category', $category)
            ->with('firstLetter', $firstLetter)
            ->with('firstRun', $firstRun)
            ->with('letters', $letters)
           ;
    }
//----------Does Not Found Any Route For This Method
public function hyperterms($id){
	$product = DB::table('product')->where('id',$id)->first();
	$hyperterms = "";
	if(!is_null($product)){
		$hyperterms = $product->return_policy;
	}
	return $hyperterms;
}

public function owarehouse_list(Request $request,$id){
	
      //if(!Auth::check()) return redirect('/');

       //  $merchant = Merchant::find($id);
       // $merchant_cat  = Merchant:: leftJoin('merchantcategory as mc', 'merchant.id', '=', 'mc.merchant_id')
       //               ->leftJoin('category as c', 'c.id', '=', 'mc.category_id')
       //               ->leftJoin('merchantproduct as mp', 'mp.merchant_id', '=', 'merchant.id')
       //               ->leftJoin('product as p', 'p.id', '=', 'mp.product_id')
       //               ->leftJoin('subcat_level_1 as sc1','p.subcat_id','=','sc1.id')
       //               ->where('merchant.id','=',$id)
       //               ->select('merchant.oshop_name')
       //               ->get();
      //  dd($merchant);

       //Lazy loading
        $merchant = Merchant::with('categories')->find($id);
        $merchant_pro = OshopProduct::with('products')->find($id);

        if(count($merchant_pro->products) < 1){
            $request->session()->flash('message', "Merchant can't be found");
            return redirect()->back();
        }


        //remove category repetation
        foreach($merchant->categories as $cat)
        {
            $merchant_cat[] = $cat->id;
        }
        $merchant_cat = array_unique($merchant_cat);
        //Get the profile settings referring to album for a given merchant
        $profile = Merchant::withProfile($id);

        return view('owarehouse1')
            ->with('merchant', $merchant)
            ->with('merchant_cat', $merchant_cat)
            ->with('merchant_pro', $merchant_pro)
            ->with('profile', $profile)
            ->with('type','oshop');
}

    public function hyperbyid($id){
     $currency= DB::table('currency')->where('active', 1)->first()->code;
	   $global_system_vars = DB::table('global')->first();
       $duration = $global_system_vars->hyper_duration;		
        $product = DB::table('product')->leftJoin('owarehouse as o','product.id','=','o.product_id')
                ->join('oshopproduct','oshopproduct.product_id','=','product.id')
        ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
        ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
        ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->where('merchant.status','active')
                ->where('oshop.status','active')
                ->where('o.id',$id)
                ->where(DB::raw("CURDATE() <= DATE_ADD(o.created_at,INTERVAL ".$duration." DAY)"))
                ->select(DB::raw('product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
				->orderBy('o.created_at','DESC')
                ->groupBy('product.id')
                ->first();
         
			if(!is_null($product)){
				$qty = explode(',', $product->pledged_qty);
				$v=0;
				if (array_filter($qty)) {
					foreach ($qty as $key => $value) {
						# code...
						$v = $v + $value;
					}
				}
				$left_pledge = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; 
				$date = $product->odate;
				$date = strtotime($date);
				$current_date = strtotime(date('Y-m-d H:i:s'));
				$date1 = new DateTime('now');
				$date2 = new DateTime(date('Y-m-d H:i:s', strtotime("+ $product->owarehouse_duration day", $date)));
				$dDiff = $date1->diff($date2);
				$price = ($product->owarehouse_price / 100);
				$op = $product->retail_price / 100;
				// $save = $op > 0 ? sprintf('%.2f', ((($op - $product->owarehouse_price) / $op) * 100)) : 0;
				$save= $op>0 ? (($op-$price)/$op)*100 :0;
				$status=1;
				if ($dDiff->format("%r") == '-') {
					# code...
					$status='<span class="label label-danger pull-right">Expired</span>';
					$status=0;
				}
			   $left = ($product->owarehouse_moq - $v) > 0 ? ($product->owarehouse_moq - $v) : 0; 
						   $returnvar = '<div class="well owarehouseform">
						        	<span class="text-center"><center><mark>';
									if($dDiff->format("%r") == '-') {
										$returnvar .= '<div></div>';
									} else {
										$returnvar .= 'Time Left: '. $dDiff->y .' y '. $dDiff->m .' mo '. $dDiff->d .' days' . $dDiff->h .' hrs and '. $dDiff->i .' mins ';
									} 
                  $image_url=url()."/images/product/".$product->product_id.'/'.$product->photo_1;
									$returnvar .= '</mark></center></span>';
									$returnvar .= '<div class="no-padding imagePreview" id="imagePreview2"
										style="height: 260px; margin-top: -2px;
										background-size:cover;
										background-position: center top;
										background-image: url('.$image_url.');">
									</div>
									<div class="clearfix"> </div>
									<hr>
						          	<div >
						          	<div class="text-primary">';
									$ii = 0;
									$sumii = 0;
									if(array_filter($qty)){
											foreach($qty as $key => $value){
												if($ii <= 5){
													$returnvar .= '<i class="fa fa-user fa-1x" style="float: left; padding:3px;" aria-hidden="true">'.$value.'</i>';
												}
												$sumii = $sumii + $value;
												$ii++;
											}
												$returnvar .= '<span class="pull-right"><span style="color: #000;"><strong >P&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;'.$ii.'&nbsp;</span></strong></span>&nbsp;<span style="color: #000;"><strong>Q&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;'.$sumii.'&nbsp;</span></strong></span></span>';
									} else {
											$returnvar .= '<span class="pull-right"><span style="color: #000;"><strong >P&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;'.$ii.'&nbsp;</span></strong></span>&nbsp;<span style="color: #000;"><strong>Q&nbsp;<span style="border: black solid 1px; padding: 1px;">&nbsp;'.$sumii.'&nbsp;</span></strong></span></span>';
									}
									$returnvar .= '</div>						          	
									<div class="clearfix"> </div>	
									<span class="badge pull-left" style="background:red; font-size: 15px; margin-top: 10px; vertical-align: middle;">Save '.number_format($save,0).'%</span>							
						          	</div>
									<div class="clearfix"> </div>
									<hr>';
										$pfullnote = null;
										$pnote = null;
										$elipsis = "...";
										$pfullnote = $product->name;
										$pnote = substr($pfullnote,0, 20);

										if(strlen($pfullnote) > 20){
											$pnote = $pnote . $elipsis;	
										}
																		
						          	$returnvar .= '<h4><span title="'.$pfullnote.'">'.$pnote.'</span>	</h4>';
						          	$returnvar .= '<div class="line line_3">
						          		Price :<span class="new-price price">'.$currency.' '. number_format($price,2).'</span> <span class="old-price price" style="font-size: 0.9em;
    color: red;
    text-decoration:line-through;">'.$currency . ' ' .number_format($product->retail_price/100,2).' </span>
						          	</div>
						          	<div class="line ">
  						          	<table class="table striped replacable_1">
  						          		<tr>
  						          			<td>MOQ</td>
  						          			<td class="text-center">'.$product->owarehouse_moq.'</td>
                              <td class="text-right">' . $currency . ' '.number_format($price * $product->owarehouse_moq,2).'</td>
  						          		</tr>
                            <tr>
                              <td>MOQ/location</td>
                              <td class="text-center">'.$product->owarehouse_moqperpax.'</td>
							  <input type="hidden" value="'.$product->owarehouse_moqperpax.'" id="moqperpax" />
                              <td class="text-right">'. $currency .' '.number_format($price * $product->owarehouse_moqperpax,2).'</td>
                            </tr>
  						    <tr>
  						          			<td>Left</td>
  						          			<td class="text-center">'.$left.'</td>
                              <td class="text-right">'. $currency .' '.number_format($left * $price,2).'</td>
  						     </tr>							
  						          		<tr>';
											$pl = 0;
											if($product->owarehouse_moq > 0 && $v > 0){
												$pl = ($v * 100)/$product->owarehouse_moq;
											}
											if($pl > 100){
												$pl = 100;
											}												
  						          			$returnvar .= '<td>Pledged&nbsp;'.number_format($pl,0).'%</td>
  						          			<td class="text-center">'.$v.'</td>
                              <td class="text-right">'.$currency.' '.number_format($v * $price,2).'</td>
  						          		</tr>

  						          	</table>
						          	</div>
									<script type="text/javascript"></script>
						     </div>';
							return $returnvar;
			} else {
				return "No hyper found.";
			}

    }

    public function owarehouse(Request $request,$id){
   // return redirect('/');  

	   $global_system_vars = GlobalT::orderBy('id', 'desc')->first();
		$subcat_arr = explode("-",$id);
        $level = Product::select('product.subcat_level')
                ->join('oshopproduct','oshopproduct.product_id','=','product.id')
                ->join('oshop','oshop.id','=','oshopproduct.oshop_id')
                ->join('merchantproduct','merchantproduct.product_id','=','product.parent_id')
                ->join('merchant','merchant.id','=','merchantproduct.merchant_id')
                ->where('product.subcat_id','=',$subcat_arr[0])
                ->where('merchant.status','active')
                ->where('oshop.status','active')
                ->get();
            // dd($level);
		$cat = [];
		if($subcat_arr[1] == '1'){
			$cat =  SubCatLevel1::select('subcat_level_1.description')->find($subcat_arr[0]);
		} else if($subcat_arr[1] == '2'){
			$cat =  SubCatLevel2::select('subcat_level_2.description')->find($subcat_arr[0]);
		} else if($subcat_arr[1] == '3'){
			$cat =  SubCatLevel3::select('subcat_level_3.description')->find($subcat_arr[0]);
		}
		
		$product_ids= DB::table('owarehouse')->lists('product_id');
        $data = Product::join('owarehouse as o','product.id','=','o.product_id')
                ->leftJoin('owarehousepledge as op', function($join)
                         {
                             $join->on('o.id', '=', 'op.owarehouse_id')
							 ->where('op.status','=','executed');
                         })
                ->where('product.subcat_id','=',$subcat_arr[0])
                ->whereIn('product.id',$product_ids)
                ->where('product.status','active')
                ->where('product.oshop_selected',true)
                ->where('o.status','active')
                ->where('o.moq','>',0)
                ->where('product.owarehouse_moqperpax','>',0)
                ->where('product.owarehouse_price','>',0)
                ->where('product.oshop_selected',1)
                ->select(DB::raw('DISTINCT(product.id) as pid, product.*,o.id as owarehouse_id,o.collection_price, product.parent_id as product_id,o.collection_units,o.created_at as odate,GROUP_CONCAT(op.pledged_qty) as pledged_qty'))
                ->groupBy('product.id')
                ->get();

		if(count($data) == 0){
			return redirect()->back();
		}
		//if(!Auth::check()) return redirect('/');	  
			
            if(!Auth::check()){
				$role=False;
			} else {
				$role_user=DB::table('role_users')->where('user_id',Auth::user()->id)->pluck('role_id');
				$role=False;
				if ($role_user==2 || $role_user==11 || $role_user==3) {
				  # code...
				  $role=True;
				}
			}

			return view('hyper.by_id')
				->with('global_system_vars',$global_system_vars)
				->with('ow_product',$data)
				->with('cat_name',$cat)
				->with('role',$role);
    }

       public function storeOwarehouse(Request $request){
                   if(!Auth::check()) return "Please login"; 
                        $owarehousepledge = new Owarehouse_pledge();
                        $owarehousepledge->owarehouse_id =$request->owarehouse_id;
                        $owarehousepledge->user_id=Auth::user()->id;
                        $owarehousepledge->pledged_qty =$request->quantity;
                        if(!$owarehousepledge->save()){
                          $data['status'] = 'error';
                        }else{
                          $data['status'] = 'success';
						              $producthyper = DB::table('product')->where('segment','hyper')->where('parent_id',$request->parent_id)->first();
						              if(!is_null($producthyper)){
							             $available = $producthyper->available - $request->quantity;
							             DB::table('product')->where('segment','hyper')->where('parent_id',$request->parent_id)->update(['available'=>$available]);
						            }
                    }

                      $data = $owarehousepledge::select('*')->where('owarehouse_id', '=', $request->owarehouse_id)->get();
                      echo json_encode($data);
       }
       public function save_owarehouse_pledge($owarehouse_id,$pledged_qty)
       {
          // Early Return 
          if (!Auth::check()) {
            # code...
          //   return response()->json(['status'=>'failure','message':'Unauthorized Access','long_message'=>'You must me logged in for Hyper Pledge']);
          }
          try {
            $ow_pledge= new Owarehouse_pledge(); 
          } catch (\Exception $e) {
            
          }
       }
      
}
