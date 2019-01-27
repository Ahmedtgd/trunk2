<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\User;
use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\MerchantDebitNote;
use App\DebitNote;
use App\DebitNoteItem;
use Crypt;
use App\Station;
use Log;

class DebitNoteController extends Controller
{
    public function debitNote()
    {
        $user_id= Auth::user()->id;
        $selluser = User::find($user_id);
        return view('debitnote.debitnote',compact(['selluser']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveDebitNotes(Request $request)
    {
       
        $user_id  =  Auth::user()->id;
        $merchant  =  \App\Models\Merchant::where('user_id',$user_id)->first();

        $next_debit_note_no = DebitNote::nextDebitNoteNo($merchant->id);
//--------------------------dave--------------------------//
foreach($request->debit_note as $key => $item) {
    $u_id = $item['dealer_id'];
    }
        $db_note = new DebitNote;
        $db_note->debitnote_no =  $next_debit_note_no;
        $db_note->save();

  //--------------------------dave--------------------------//      
        $mrchnt_db_note = new MerchantDebitNote;
        $mrchnt_db_note->merchant_id = $merchant->id;
        $mrchnt_db_note->debitnote_id = $db_note->id;
  //--------------------------dave--------------------------//
        $mrchnt_db_note->save();

        $currentDateTime = $db_note->created_at;
        $total = 0;

        //Log::debug($request->debit_note);

        foreach ($request->debit_note as $key => $item) {
            $total += str_replace( ',', '',$item['total']);
            $items[$key] = [
                'debitnote_id'  => $db_note->id,
                'debitnoteitem_no' => $item['item_no'],
                'description'   => $item['description'],
                'total'         => (str_replace( ',', '',$item['total']))*100,
                'created_at'    => $currentDateTime,
                'updated_at'    => $currentDateTime,
            ];
        }

        //Log::debug('tatal-'.$total);

        $db_note->total = ($total)*100;
        //--------------------changed by dave---------------------//
        $db_note->dealer_user_id = $u_id;
        //--------------------changed by dave---------------------//
        $db_note->save();

        DB::table('debitnoteitem')->insert($items);

        $data = [
            'id'            => $db_note->id,
            //--------------------changed by dave---------------------//
            'dealer_id'       => $u_id,
            //--------------------changed by dave---------------------//
            'debitnote_no'  => $db_note->debitnote_no,
            'merchant_id'   => $merchant->id,
            'merchant_name' => $merchant->company_name,
            'total'         => number_format($db_note->total/100, 2),
        ];

        //Log::debug('db note-'.$db_note->id);

        //Log::debug($request);

        return response()->json([
            'status'    => 200,
            'result'    => 'success',
            'data'      => $data,
            'view_content' => $this->viewDebitNote($db_note->id,$request)
        ]);
    }

    public function viewDebitNote($debit_note_id,Request $request)
    {
    //--------------------changed by dave---------------------//
        if(($request->get('dealer_id'))=== Null)
        {
            foreach($request->debit_note as $key => $item) {
                $u_id = $item['dealer_id'];
                }
                $user_id = $u_id;
        }
        else{
            $user_id = $request->get('dealer_id');
        }
    //--------------------changed by dave---------------------//    
       

       

        $debit_note = DebitNote::join('merchantdebitnote', 'merchantdebitnote.debitnote_id', '=', 'debitnote.id')
            ->join('merchant', 'merchant.id', '=', 'merchantdebitnote.merchant_id')
            ->join('users','merchant.user_id','=','users.id')
            ->join('station','users.id','=','station.user_id')
            ->leftJoin('address', 'merchant.address_id', '=', 'address.id')
            ->where('debitnote.id', $debit_note_id)
            ->selectRaw('debitnote.*,
                station.id as station_id,
                merchantdebitnote.merchant_id,
                merchant.user_id,
                merchant.company_name,
                merchant.business_reg_no,
                users.first_name,
                users.last_name,
                merchant.user_id as staff_id,
                address.line1,
                address.line2,
                address.line3,
                address.line4'
            )
            ->first();

/*
        $dealer_info = null;
        if ($user_id) {
            $dealer_info = \DB::table('users as u')
				->join('merchant','u.id','=','merchant.user_id')
				->join('stationterm as st','u.id','=','st.creditor_user_id')
				->leftJoin('address', 'merchant.address_id', '=', 'address.id')
				->where('u.id',$user_id)
				->selectRaw('merchant.company_name,
					st.credit_limit AS balance,
					merchant.business_reg_no,
					merchant.user_id as staff_id,
					address.line1,
					address.line2,
					address.line3,
					address.line4'
				)
				->first();
        }
*/
//-----------------------------change  by dave-------------------------------------------------//
$dealer_info = null;
if ($user_id) {
    $dealer_info = \DB::table('station as s')
        ->join('merchant','s.user_id','=','merchant.user_id')
        ->leftJoin('stationterm as st','s.user_id','=','st.creditor_user_id')
        ->leftJoin('address', 'merchant.address_id', '=', 'address.id')
        ->where('s.user_id',$user_id)
        ->selectRaw('merchant.company_name,
            st.credit_limit AS balance,
            merchant.business_reg_no,
            merchant.user_id as staff_id,
            address.line1,
            address.line2,
            address.line3,
            address.line4'
        )
        ->first();
}

//-----------------------------change  by dave-------------------------------------------------//

$items = $debit_note ? DebitNoteItem::where('debitnote_id', $debit_note->id)->get() : collect();

     
        return view('debitnote.debitnote_view', [
            'debit_note' => $debit_note,
            'dealer_info' => $dealer_info,
            'items' => $items,
        ])->render();
  
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