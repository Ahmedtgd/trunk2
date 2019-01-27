<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Log;
use App\Models\Merchant;
use App\Models\Uom;
use App\Http\Repository\RecipeRepo;
use Illuminate\Support\Facades\Config;
use Auth;
use Carbon;

class TerminalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    //  */

    protected $repo;
    function __construct(RecipeRepo $repo) {
        $this->repo = $repo;
    }

    public function index($merchant_id=null)
    {
        $matches = '';        
        $user_id = \Auth::user()->id;
        $merchant = \App\Models\Merchant::where('user_id',$user_id)->first();
        
        // $products = DB::table('merchantproduct')
        // ->where('merchant_id',$merchant->id)
        // ->join('product','merchantproduct.product_id','=','product.id')
        // ->leftJoin('q1def','q1def.product_id','=','product.id')
        // ->select('product.id','product.name','q1def.measurement','q1def.unit')->get();

        $products =$this->repo->getRawMaterial();
        // $units = array();

        try {
           // $units = DB::select(DB::raw("select column_type from information_schema.columns where table_schema='".Config::get('app.DBNAME')."' and table_name='q1def' and column_name='unit'"))[0]->column_type;
           //  // echo '<pre>'; print_r($units); die();
           // preg_match("/^enum\(\'(.*)\'\)$/", $units, $matches);
           // $units = explode("','", $matches[1]);

            $units = Uom::select('id','symbol')->get()->pluck('symbol', 'id');
        } 
        catch (\Exception $e) {
            Log::error('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
            return Response()->json(['error' => true]);
        }
        
        return view('seller.q1',[
            'products' => $products,
            'selluser' => $merchant,
            'units'    => $units
        ]);
    }   
    
    public function updateQ1Def(Request $req)
    {
        $pid = $req->get('product_id');
        $measurement = $req->get('measurement');
        $unit = $req->get('unit');
        $def = DB::table('q1def')->where('product_id','=',$pid)->first();
        $uom_id =array();
        if(!$def){
            // $units = array();
            
            try {
                /***** Take note of the DB name ******/
               // $units = DB::select(DB::raw("
               //  select
               //      column_type
               //  from
               //      information_schema.columns
               //  where
               //      table_schema='".Config::get('app.DBNAME')."' and
               //      table_name='q1def' and
               //      column_name='unit'"))[0]->column_type;

               //  preg_match("/^enum\(\'(.*)\'\)$/", $units, $matches);
               //  $units = explode("','", $matches[1]);
               //  $unit = $unit || $units[0];

                $units = Uom::select('id','symbol')->get()->pluck('symbol', 'id');
                $unit = $unit || $units[1];

                DB::table('q1def')->insert(['product_id' => $pid, 'measurement'=> $measurement?:1, 'unit' => $unit,'uom_id' => $unit]);                
            } 
            catch (\Exception $e) {
                Log::error('Error @ '.$e->getLine().' file '.$e->getFile().' '.$e->getMessage());
                return Response()->json(['error' => true]);
            }
            
        } else {

            $measurement = $measurement?:$def->measurement;
            $unit = $unit?:$def->unit;
            DB::table('q1def')
            ->where('product_id','=',$pid)
            ->update([
                'measurement'=> $measurement, 
                'unit' => $unit,
                'uom_id' => $unit
            ]);

            $symbol = Uom::select('symbol')->where('id',$unit)->first();
            if(count($symbol) > 0){
                $uom_id =  $symbol->symbol;
            }
        }
        return ['product_id' => $pid, 'measurement'=> $measurement, 'uom_id' => $uom_id];
    }

    public function viewTerminal($location_id,$uid=null){
		Log::debug('***** viewTerminal('.$location_id.','.$uid.') *****');

        if (!\Auth::check() ) {
			return view('common.generic')->
				with('message_type','error')->
				with('message','Please login to access the page')->
				with('redirect_to_login',1);
		}
        $user_id=Auth::user()->id;
        if (Auth::user()->hasRole("adm") && !empty($uid)) {
            # code...
            $user_id=$uid;
        }
		     
        $branch = DB::table('fairlocation')->where('id',$location_id)->select(DB::raw("fairlocation.location as name"))->first();
        //return $branch;
	     	$selluser = \App\Models\User::find($user_id);

      /*  $terminal = DB::table('opos_terminal')->
        select(DB::raw("opos_terminal.*"))->
        join("opos_locationterminal","terminal_id","=","opos_terminal.id")->
        where("location_id","=",$location_id)->
        select(DB::raw("opos_terminal.*, HOUR(opos_terminal.start_work) as starthour,HOUR(opos_terminal.end_work) as endhour"))->
        get();
*/
        $terminal=DB::select(DB::raw("
          SELECT 
          opos_terminal.*,
          HOUR(opos_terminal.start_work) as starthour,
          HOUR(opos_terminal.end_work) as endhour,
          opos_logterminal.id as log_id

          FROM 
          opos_terminal 
          JOIN opos_locationterminal on opos_locationterminal.terminal_id=opos_terminal.id
          LEFT JOIN opos_logterminal on opos_logterminal.terminal_id=opos_terminal.id AND DATE(opos_logterminal.created_at)=CURDATE()
          WHERE 
          opos_locationterminal.location_id=$location_id
          AND opos_terminal.deleted_at IS NULL
          AND opos_logterminal.deleted_at IS NULL 
          GROUP BY opos_terminal.id
        "));
        $members=DB::table('member')->
		leftJoin('users','users.id','=','member.user_id')->
		join('company','member.company_id','=','company.id')->
		where('company.owner_user_id',$user_id)->
		where('member.type','member')->
		select(DB::raw("
			member.*,
			users.first_name as users_first_name,
			users.last_name as users_last_name,
			users.id as user_id
			"))
		->orderBy('created_at','DESC')
		->get();

        //get subcategory count for terminal id
        $merchant = Merchant::where('user_id','=',$user_id)->first();
        $merchant_id = $merchant->id;
        $subcategory = DB::select(DB::raw(
			"select count(distinct(subcat_level_1.id)) as level1_id_count ".
			"from ( ".
			   "select p.subcat_id, p.subcat_level, count(p.id) as pcount ". 
				"from product as p ".
				"join merchantproduct as mp ".
					"on p.id = mp.product_id ".
					"and mp.merchant_id = ".$merchant_id." ". 
				// "join locationproduct as lp ".
				//     "on p.id = lp.product_id ".
				//     "and lp.location_id = ".$location_id." ".
				"GROUP BY p.subcat_id ". 
			") as subcat ".
			"join subcat_level_1 ".
				"on id = ( case ". 
					"WHEN subcat_level = 1 then subcat_id ".
					"WHEN subcat_level = 2 then ( ".
						"select subcat_level_1_id ".
						"from subcat_level_2 as s2 ".
						"where s2.id = subcat_id) ". 
					"WHEN subcat_level = 3 then ( ".
						"select subcat_level_1_id ".
						"from subcat_level_3 as s3 ".
						"where s3.id = subcat_id)". 
					"end ) ".
			// "GROUP by subcat_level_1.id ". 
			"ORDER by subcat_level_1.name"));

        //select created time from location terminal
        $terminal_id =DB::table('opos_locationterminal')->select('terminal_id')
        ->where('location_id',$location_id)
        ->whereNull('deleted_at')
        ->orderBy('id','DESC')
        ->first();

        // $starttimes = '00:00:00' ;
        // $endtimes = '23:59:59';

        $starttimes = date('Y-m-d 00:00:00');
        $endtimes =date('Y-m-d 23:59:59');

        //convert Datetime to date only
        if(!empty($terminal_id->terminal_id)){
		      $Eodtimes = app('App\Http\Controllers\OposEodController')->eod_times($terminal_id->terminal_id);
         
		      $starttimes = date('Y-m-d H:i:s',
				  $Eodtimes['starttimes']);

		      $endtimes = date('Y-m-d H:i:s',
				  strtotime("+5 mins",$Eodtimes['endtimes']));
        }
        
        //passing that time to eod field and get eod value
       
        $eod=DB::table('opos_eod')->
			where('location_id',$location_id)->
			whereNull('deleted_at')->
			whereBetween('opos_eod.eod', array($starttimes , $endtimes))->
			first();
      if(empty($eod)){
        $starttimes = date('Y-m-d 00:00:00');
        $endtimes =date('Y-m-d 23:59:59');
      }
        
        $start_work='00:00:00';
        $end_work='23:59:59';

       
        if (!empty($terminal)) {
			$start_work=$terminal[0]->start_work;
			$end_work=$terminal[0]->end_work;
        }
        if(count($subcategory) > 0 &&
		   isset($subcategory[0]->level1_id_count)) {
            $subcat_count = $subcategory[0]->level1_id_count;

        } else {
            $subcat_count = 0;
		}
 
      return View::make('seller.terminal-list')->
			with([
                'terminal'=>$terminal,
                "id"=>$location_id,
                "selluser"=>$selluser,
                "staffs"=>$members,
                "subcat_count" => $subcat_count,
                "branch"=>$branch,
                "eod"=>$eod,
                'location_id'=>$location_id,
                'start_work'=>$start_work,
                'end_work'=>$end_work,
                'endtimes'=>$endtimes
			]);
    }

    
    public function viewProductDefination(){
        return view('seller.productdefinition');
    }
    
    // public function addWithoutValues($location){
    public function addWithoutValues(Request $request){
      $data = $request->all();

      $opsterminal=new \App\Models\OposTerminal();
      
      $oposLocationTerminal=new \App\Models\OposLocationTerminal();
      $opsterminal->name="";
      $opsterminal->start_work=$data['starttime'];
      $opsterminal->end_work= $data['endtime'];
      $opsterminal->save();
     
      $oposLocationTerminal->terminal_id=$opsterminal->id;
      $oposLocationTerminal->location_id=$data['id'];
      $oposLocationTerminal->save();

      return response()->json(["status" => "success"]);

      // return back();
    }
    

 public function updateValue(Request $request){
    $name=$request->input("name");
    $id=$request->input("id");
    $value=$request->input("value");
    $oposterminal=\App\Models\OposTerminal::find($id);
    if(!empty($name)){
		$oposterminal->{$name}=$value;
    }
    $oposterminal->save();
    return response()->json(["Data Saved Successfully",$oposterminal]);
 }
 
 public function deleteValue(Request $request){
     //return $request->id;exit;
     $ret["status"]="failure";

	 if(!empty($request->id)) {
		 $terminal=\App\Models\OposTerminal::find($request->id);
		 //return $terminal;
		 if(!empty($terminal)){
			 \App\Models\OposLocationTerminal::where("terminal_id","=",$request->id)->delete();
			 \App\Models\OposTerminalUsers::where("terminal_id","=",$request->id)->delete();
		 
			 $terminal->delete();
			 $ret["status"]="success";
			 return response()->json($ret);
			 //return back();
		 }

     } else {
		 return back()->withErrors(["message"=>"ID cannot be null"]);
     } 
 }
 
	 public function assignUser(Request $request){
        $oposTerminalUsers=new \App\Models\OposTerminalUsers();
        $oposTerminalUsers
                ->where("user_id","=",$request->input("value"))
                ->where("terminal_id","=",$request->input("id"))
                ->delete();
        $oposTerminalUsers->terminal_id=$request->input("id");
        $oposTerminalUsers->user_id=$request->input("value");
        $oposTerminalUsers->save();
        return back();
     
 }
 
 public function getTerminalUserData(Request $request){
	$id = $request->input("id");

	/* WARNING: This is explode during ADMIN access!! */
	$user_id = \Auth::id();

	$company_id=DB::table("company")->select("company.id as company_id")
		->leftJoin("users","company.owner_user_id","=","users.id")
		->where("users.id","=",$user_id)
		->first()->company_id;
	Log::debug('company_id='.$company_id);
	

	$data=\App\Models\OposTerminal::where("id","=",$id)->first();
/*	$members= DB::table('role_users')->distinct()->
		leftJoin('users','users.id','=','role_users.user_id')->
		leftJoin('roles','role_users.role_id','=','roles.id')->
		leftJoin("member","member.email","=","users.email")->
		where('role_users.company_id',"=",$company_id)->
		where("member.status","=",'active')->
		where(DB::raw("users.id IS NOT NULL"))->
		where("roles.slug","=",'opu')->
		orWhere("roles.slug","=","opm")->
		orWhere("roles.slug","=","spu")->
		orWhere("roles.slug","=","spm")->
		select(DB::raw("
			users.*,
			users.first_name as users_first_name,
			users.last_name as users_last_name,
			users.id as user_id
			"))
                ->groupBy("users.id")
		->get();
 * 
 */
	$members=DB::select(DB::raw("select
		concat(u.first_name,' ',u.last_name) as name,
		u.email,
                u.id as user_id
	from
		role_users ru,
		roles r,
		users u,
		member m
	where
		m.email=u.email and
		ru.user_id=u.id and
		ru.role_id=r.id and
		(r.slug='opu' or r.slug='opm' or
		 r.slug='spu' or r.slug='spm') and
		m.status='active' and
		ru.company_id=$company_id
	group by
		u.id"));

	Log::debug($members);

	$selected= \App\Models\OposTerminalUsers::select("user_id")->
	 	where("terminal_id","=",$id)->get();

    $selected_users=[];
    foreach($selected as $s){
        $selected_users[]=$s->user_id;
    }
    
	return response()->json([
		"terminal_data"=>$data,
		"user_data"=>$members,
		"selected_users"=>$selected_users
	]);
 }
 
 public function saveTerminalUserData(Request $request){
    $id = $request->input("id");
   $users= $request->input("user_id");
  
   $hardware_addr=$request->input("hardware_addr");
   $ip_addr=$request->input("ip_addr");
   $user_id = \Auth::id();
   
     \App\Models\OposTerminal::where("id","=",$id)
             ->update(["hardware_addr"=>$hardware_addr,"ip_addr"=>$ip_addr]);
     \App\Models\OposTerminalUsers::where("terminal_id","=",$id)
             ->delete();
     $user_array=[];
     if(!empty($users)){
     foreach($users as $user){
         $user_array[]=['user_id'=>$user,"terminal_id"=>$id];
     }
   
     \App\Models\OposTerminalUsers::insert($user_array);
     }
     return response()->json(["message"=>"Saved Successfully !"]);
 }

 
	public function saveTerminalData(Request $request){
		$terminal_data=$request->input("terminal_d");
		if(!empty($terminal_data)){
            /*Validation Block*/
           
			foreach($terminal_data as $key=> $data){

				$values= [
				"name"=>!empty($data["name"])?$data["name"]:"",
				"start_work"=>!empty($data["start_work"])?$data["start_work"]:"",
                "close_work"=>!empty($data["close_work"])?$data["close_work"]:"",
				"end_work"=>!empty($data["end_work"])?$data["end_work"]:"",
				"counter"=>!empty($data["counter"])?$data["counter"]:""
				];

				\App\Models\OposTerminal::where("id","=",$key)->
				update($values);
			}
		}
		return response()->json(["message"=>"updated successfully !"]);
	}

  public function getSubCategories(Request $request){
      $merchant_id = \Auth::id();
      $categories= \App\Models\Product::select(DB::raw("subcat.name as subcat_name,"
              . "count(*) as total_product"))
              ->leftJoin("subcat_level_1 as subcat",
                      'subcat.id',"=",'product.subcat_id')    
              ->leftJoin("merchanttproduct as product_merchant",
                      'product_merchant.tproduct_id',"=",'product.id')            
              ->where("product.subcat_level","=",1)
              ->where("subcat.name","!=",1)
//              ->where("product_merchant.merchant_id","=",$merchant_id)
              ->groupBy("subcat.id")
              ->get();
//      dd($categories->toArray());
              
      return response()->json(["data"=>$categories]);
  }
  //-----------------------------------------
  // Created by Zurez
  //-----------------------------------------
  
  public function update_terminal(Request $r,$uid=NULL)
  {
      $ret=array();
      $ret["status"]="failure";
      if(!Auth::check()){return "";}
      $user_id=Auth::user()->id;
      if(!empty($uid) and Auth::user()->hasRole("adm")){
          $user_id=$uid;
      }
      try{
          switch ($r->action) {
              case 'update_sst':
                  return $this->update_sst($r);
                  break;
              case 'update':
                # code...
                DB::table("opos_terminal")
                ->where('id',$r->terminal_id)
                ->update([
                  "updated_at"=>Carbon::now(),
                  
                  "name"=>$r->name,
                  "counter"=>$r->counter
                ]);
                return "ok";
                break;
              case 'update_mode':
                # code...
                DB::table("opos_terminal")
                ->where('id',$r->terminal_id)
                ->update([
                  "updated_at"=>Carbon::now(),
                  "mode"=>$r->mode
                ]);
                return ucfirst($r->mode);
                break;
              case 'reset':
                # code...
                DB::table("opos_terminal")
                ->where('id',$r->terminal_id)
                ->update([
                  "updated_at"=>Carbon::now(),
                  "start_work"=>null,
                  "close_work"=>null,
                  "end_work"=>null
                ]);
                return "ok";
                break;
              case 'reset_logo':
                # code...
                DB::table("opos_terminal")
                ->where('id',$r->terminal_id)
                ->update([
                  "updated_at"=>Carbon::now(),
                  "local_logo"=>null
                ]);
                return "ok";
                break;
              case 'onblurupdate':
                # code...
                DB::table("opos_terminal")
                ->where('id',$r->terminal_id)
                ->update([
                  "updated_at"=>Carbon::now(),
                  
              
                  "name"=>$r->name,
                  "counter"=>$r->counter
                ]);
                return "ok";
                break;
              default:
                  # code...
                  break;
          }
          
          $ret["status"]="success";
        
      }
      catch(\Exception $e){
          $ret["short_message"]=$e->getMessage();
          Log::error("Error @ ".$e->getLine()." file ".$e->getFile()." ".$e->getMessage());
      }
      return response()->json($ret);
  }
  
  public function update_sst($r)
  {
      DB::table('opos_terminal')
      ->where('id',$r->terminal_id)
      ->update([
        "updated_at"=>Carbon::now(),
        "servicetax"=>$r->servicetax
    ]);
      return "ok";
  }

  public function update_all_terminal(Request $r)
  {
    $location_id=$r->location_id;
    
    $start_work=$r->start_work;
    $end_work=$r->end_work;
    if (empty($location_id)) {
      return "missing location_id";
    }

    $terminals=DB::table('opos_locationterminal')
    ->where('location_id',$location_id)
    ->whereNull('deleted_at')
    ->get();

   // dd($start_work,$end_work);

    foreach ($terminals as $terminal) {
      
      DB::table("opos_terminal")
                ->where('id',$terminal->terminal_id)
                ->update([
                  "updated_at"=>Carbon::now(),
                  "start_work"=>$start_work,
                  "close_work"=>null,
                  "end_work"=>$end_work
                ]);

    }
    
    return response()->json(['status'=>'success']);

  }
}
