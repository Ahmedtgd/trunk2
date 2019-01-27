<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{


    public function wallet_management()
    {
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        $query="SELECT wt.*, ut.first_name, ut.last_name FROM wallet AS wt JOIN users AS ut ON ut.id = wt.user_id WHERE wt.deleted_at IS NULL";
        $wallets=DB::select(DB::raw($query));
        return view('wallet.wallet_management', compact(['selluser','wallets']));
    }

    public function show_warranty(){
        //return view('raw.show_warranty');
    }

    public function wallet_transaction(Request $request){
    	if (!$request->ajax()) {
            return;
        }
        $walletId = $request->walletId;
    	$query="SELECT * FROM walletlog WHERE deleted_at IS NULL AND wallet_id = $walletId";
    	$walletTrans=DB::select(DB::raw($query));
    	#echo "<pre>"; print_r($walletTrans); die;
        return view('wallet.wallet_transaction', compact(['walletTrans']));
    }

    public function show_chitno(){
        //return view('raw.show_chitno');
    }





    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
}
