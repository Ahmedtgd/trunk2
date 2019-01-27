<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\MlmComm;
use App\Models\MlmLevel;
use App\Models\MlmOverriding;


class MLMCommissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      return view("mlmCommissions/mlmCommissions");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request, $fieldName = null, $value = null, $mlmcommid = null)
    {
      $request_var = $request->all();
      $mlm_query = null;



      // $mlmCommissionsData = DB::table('mlmcomm')
      // ->join('mlmlevel', 'mlmcomm.id', '=', 'mlmlevel.mlmcomm_id')
      // ->join('mlmoverriding', 'mlmlevel.id', '=', 'mlmoverriding.mlmlevel_id')
      // ->where('mlmcomm.id', '=', '1')
      // // ->select('mlmcomm.id', 'mlmcomm.sales_amount', 'mlmcomm.clan_def', 'mlmcomm.family_def', 'mlmcomm.scBonus_sales', 'mlmcomm.scBonus_amount', 'mlmlevel.id', 'mlmlevel.level_no', 'mlmlevel.pers_comm', 'mlmlevel.cachv', 'mlmlevel.cachv_gbonus', 'mlmlevel.cnot_achv', 'mlmlevel.cnot_achv_gbonus', 'mlmoverriding.recruit_ovr', 'mlmoverriding.newFamily_ovr')
      // ->select('mlmoverriding.*', 'mlmlevel.*', 'mlmcomm.*')
      // ->get();

      // $w = $request;
      //  return response()->json($request_var);



//Save A Section of the form
    if(isset($request->sales_amount)    && $request->sales_amount !=="" ||
        isset($request->clan_def)       && $request->clan_def !==""     ||
        isset($request->family_def)     && $request->family_def !==""   ||
        isset($request->scBonus_sales)  && $request->scBonus_sales !==""||
        isset($request->scBonus_amount) && $request->scBonus_amount !=="" ){

        //get table query
         if(isset($request->mlmcomm_id) && $request->mlmcomm_id != ""){
              $mlmComm = MlmComm::find($request->mlmcomm_id);
          }else{
              $mlmComm = new MlmComm;
          }

        //check input fields if data exist and assign to model for saving
          if(isset($request->sales_amount) && $request->sales_amount !== ""){
            $mlmComm->sales_amount   = $request->sales_amount;
          }
          if(isset($request->clan_def) && $request->clan_def !== ""){
            $mlmComm->clan_def       = $request->clan_def;
          }
          if(isset($request->family_def) && $request->family_def !== ""){
            $mlmComm->family_def     = $request->family_def;
          }
          if(isset($request->scBonus_sales) && $request->scBonus_sales !== ""){
            $mlmComm->scBonus_sales  = $request->scBonus_sales;
          }
          if(isset($request->scBonus_amount) && $request->scBonus_amount !== ""){
            $mlmComm->scBonus_amount = $request->scBonus_amount;
          }
          $mlmComm->save();
      }

// Save B Section of the form
    if(isset($request->pers_comm_1) || isset($request->cachv_1) || isset($request->cachv_gbonus_1) || isset($request->cnot_achv_1) || isset($request->cnot_achv_gbonus_1)){
        $mlmlevel = [];
        $mlmlevel['level_no']     = '1';   //Assign level
      //check input fields if data exist and assign to array for saving
        // get mlmcomm->id
        if(isset($request->mlmcomm_id) && $request->mlmcomm_id !== ""){
          $mlmlevel['mlmcomm_id'] = $request->mlmcomm_id;
        }else{
          $mlmlevel['mlmcomm_id'] = $mlmComm->id;
        }
        if(isset($request->pers_comm_1) && $request->pers_comm_1 !== ""){
          $mlmlevel['pers_comm'] = $request->pers_comm_1;
        }
        if(isset($request->cachv_1) && $request->cachv_1 !== ""){
          $mlmlevel['cachv']     = $request->cachv_1;
        }
        if(isset($request->cachv_gbonus_1) && $request->cachv_gbonus_1 !== ""){
          $mlmlevel['cachv_gbonus']=$request->cachv_gbonus_1;
        }
        if(isset($request->cnot_achv_1) && $request->cnot_achv_1 !== ""){
          $mlmlevel['cnot_achv']   = $request->cnot_achv_1;
        }
        if(isset($request->cnot_achv_gbonus_1) && $request->cnot_achv_gbonus_1 !== ""){
          $mlmlevel['cnot_achv_gbonus']=$request->cnot_achv_gbonus_1;
        }

        //query to get mlmlevel id if editing data
        if(isset($request->mlmcomm_id) && $request->mlmcomm_id !== ""){
              $mlmLevel_id = DB::table('mlmlevel')
                              ->select('id')
                              ->where('mlmcomm_id', $request->mlmcomm_id)
                              ->where('level_no', 1)
                              ->get();
              if(isset($mlmLevel_id[0]->id) && ($mlmLevel_id[0]->id) > 0){
                $mlmLevel_id = $mlmLevel_id[0]->id;
              }else{
                $mlmLevel_id = null;
              }
          }

          // check if it is a update or insert operation and execute query
          if(isset($mlmLevel_id) && $mlmLevel_id > 0){
              DB::table('mlmlevel')
                    ->where('id', $mlmLevel_id)
                    ->update($mlmlevel);
          }else{
              $mlmLevel_id = DB::table('mlmlevel')
                              ->insertGetId($mlmlevel);
          }
      }

    //G1 Overriding section
        //check if request data exist
          if(isset($request->recruit_ovr_1) && $request->recruit_ovr_1 !=="" || isset($request->newfamily_ovr_1) && $request->newfamily_ovr_1 !== ""){
          //check input fields if data exist and/or assign to model for saving

            if(isset($request->recruit_ovr_1) && $request->recruit_ovr_1 !== ""){
                $mlmOver['recruit_ovr'] = $request->recruit_ovr_1;
              }
            if(isset($request->newfamily_ovr_1) && $request->newfamily_ovr_1 !== ""){
                $mlmOver['newfamily_ovr']   = $request->newfamily_ovr_1;
              }











              if(!isset($mlmLevel_id)){
                  $mlmLevel_id = MlmLevel::where('mlmcomm_id', $request->mlmcomm_id)
                                       ->where('level_no', 1)
                                       ->select('id')
                                       ->get();
                    if(count($mlmLevel_id) < 1){
                      // throw error
                    }
                  }else{
                    // throw error
                  }



              // check if it is a update or insert operation and execute query
            if(isset($request->mlmcomm_id) && $request->mlmcomm_id !== ""){
                $mlmOver_id = MlmOverriding::select('id')
                                    ->where($mlmLevel_id)
                                    ->get();
                 if(count($mlmOver_id))






                if(isset($mlmLevel_id) && $mlmLevel_id >= 0){
                  $mlmOver['mlmlevel_id'] = $mlmLevel_id;
                       DB::table('mlmoverriding')
                           ->where('mlmlevel_id', $mlmLevel_id)
                           ->update($mlmOver);
                  }else{



                    $mlmOver['mlmlevel_id'] = $mlmLevel_id;
                    $mlmover_id = MlmOverriding::where('mlmlevel_id', $mlmLevel_id)
                                         ->select('id')
                                         ->get();
                  }








                if(count($mlmover_id) > 0 && $mlmover_id !== ""){
                   $mlmOver['mlmlevel_id'] = $mlmLevel_id;
                   DB::table('mlmoverriding')
                      ->where('mlmlevel_id', $mlmLevel_id)
                      ->update($mlmOver);
                }else{
                  $mlmLevel_id = DB::table('mlmlevel')
                                    ->insert($mlmOver);
                }
              }
              }else{

                //throw error
              }

// return view("mlmCommissions/mlmCommissions", ['tmp' => $mlmOver]);


// return response()->json("hi");
// // Save C Section of the form
//         if(isset($request->pers_comm_2) || isset($request->cachv_2) || isset($request->cachv_gbonus_2) || isset($request->cnot_achv_2) || isset($request->cnot_achv_gbonus_2)){
//           $mlmLevel = $this->findDBTable("pers_comm", $request->mlmcomm_id, '2');
//           $tmp = $mlmLevel;
//           $mlmLevel->level_no          = 2;
//           $mlmLevel->pers_comm         = $request->pers_comm_2;
//           $mlmLevel->cachv             = $request->cachv_2;
//           $mlmLevel->cachv_gbonus      = $request->cachv_gbonus_2;
//           $mlmLevel->cnot_achv         = $request->cnot_achv_2;
//           $mlmLevel->cnot_achv_gbonus = $request->cnot_achv_gbonus_2;
//
//           if(isset($request->recruit_ovr_2) || isset($request->newfamily_ovr_2)){
//               $mlmOver = $this->findDBTable("recruit_ovr", $mlmLevel->id);
//
//               $mlmOver->recruit_ovr = $request->recruit_ovr_2;
//               $mlmOver->newfamily   = $request->newfamily_ovr_2;
//           }
//
//           $mlmLevel->save();
//           $mlmOver->save();
//           $mlmComm = null;
//         }
//
//         if(isset($request->pers_comm_1) || isset($request->cachv_1) || isset($request->cachv_gbonus_1) || isset($request->cnot_achv_1) || isset($request->cnot_achv_gbonus_1)){
//           $mlmLevel = $this->findDBTable("pers_comm", $request->mlmcomm_id, '1');
//           $tmp = $mlmLevel;
//           $mlmLevel->level_no          = 1;
//           $mlmLevel->pers_comm         = $request->pers_comm_1;
//           $mlmLevel->cachv             = $request->cachv_1;
//           $mlmLevel->cachv_gbonus      = $request->cachv_gbonus_1;
//           $mlmLevel->cnot_achv         = $request->cnot_achv_1;
//           $mlmLevel->cnot_achv_gbonus = $request->cnot_achv_gbonus_1;
//
//           $mlmLevel->save();
//           $mlmComm = null;
//         }
// $level_no = "_1";
// $f = "pers_comm" . $level_no;
// $tmp = $mlmLevel->$f;

// $request->pers_comm_2
// $request->cachv_2
// $request->cachv_gbonus_2
// $request->cnot_achv_2
// $request->cnot_achv_gbonus_2
// $request->recruit_ovr_2
// $request->newfamily_ovr_2
// $request->pers_comm_3
// $request->cachv_3
// $request->cachv_gbonus_3
// $request->cnot_achv_3
// $request->cnot_achv_gbonus_3


// $verified_re  = [];
//
//   foreach($request_var as $key => $value) {
//     $verified[$key] = $value;
//     return response()->json([$key => $value]);
//
//   }
$tmp = 0;
// $mlmComm = mlmComm::find(1)->MlmLevel()->where('level_no', '1')->first();



      return view("mlmCommissions/mlmCommissions", ['tmp' => $tmp]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /**
     * Search for Field Name in DB and retrives requested table.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function findDBTable($field_name, $id = null, $level = null){
        $mlm_query = null;
      //if column exist save column data
            // if(Schema::hasColumn('mlmcomm', '$field_name')){
            //   $mlm_query = "hi";
            //
            //   }
            //   else if(Schema::hasColumn('mlmlevel', $field_name)){
            //
            //   }else if(Schema::hasColumn('mlmoverriding', $field_name)){
            //     if(isset($id)){
            //         $mlm_query = mlmOverriding::where('mlmlevel_id' ,$id)
            //                                     ->get();
            //       }else{
            //         $mlm_query = new mlmOverriding;
            //       }
            //   }else{
            //     return false;
            //   }

              return $mlm_query;
      }






}
