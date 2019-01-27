<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\TermsAndConditionRepo;
use App\Http\Requests\TermsAndConditionRequest;
use App\Models\Fsection_a;
use App\Models\Globals;
use Auth;
use Illuminate\Support\Facades\Request;
use Redirect;

class TermsAndCondition extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function __construct(TermsAndConditionRepo $repo) {
		$this->repo = $repo;
	}

	public function index() {
		$data    = Fsection_a::find(1);
        $content = $data['terms_and_conditions'];
		return view('terms_cond', ['content' => $content]);
	}
	public function show_TC_modal($role="")
	{
		$data    = Fsection_a::find(1);
        if ($role=="buy") {
        	# code...
        	$content = $data['terms_and_conditions'];
        }
        if ($role=="mer") {
        	$content=Globals::first()->merchant_agreement;
        	// if (is_null($content)) {
        	// 	$content=$data['terms_and_conditions'];
        	// }
        }
		
		if ($role=="hc") {
        	$content=Globals::first()->merchant_agreement;
        	// if (is_null($content)) {
        	// 	$content=$data['terms_and_conditions'];
        	// }
        }
		
      	if ($role=="sta") {
      		$content=Globals::first()->station_agreement;
      		// if (is_null($content)) {
      		// 	$content=$data['terms_and_conditions'];
      		// }
      	}
        return view('tc_modal')->with('content',$content)->with('role',$role);
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(TermsAndConditionRequest $request) {
		$user_id = isset(Auth::user()->id) ? Auth::user()->id : 0;
		$ipaddress = Request::getClientIp();
		$input = $request->except("_token");
		if (isset($input['agree']) && ($input['agree'] == "Agree")) {
			$input['agree'] = '1';
			$input['user_id'] = $user_id;
			$input['ipaddress'] = $ipaddress;
			$this->repo->create($input);
			return Redirect::to("/");
		} elseif (isset($input['disagree']) && ($input['disagree'] == "Disagree")) {
			$input['agree'] = '0';
			$input['user_id'] = $user_id;
			$input['ipaddress'] = $ipaddress;
			unset($input['disagree']);
			$this->repo->create($input);
			return Redirect::to("/");
		}
		return Redirect::back()->with("unsuccess", "Woops Something is wrong..!");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}
}
