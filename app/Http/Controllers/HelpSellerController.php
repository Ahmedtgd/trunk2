<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\HelpSellerRepo;
use App\Http\Requests\HelpSellerRequest;
use Illuminate\Http\Request;
use Validator;

class HelpSellerController extends Controller {
	protected $repo;
	function __construct(HelpSellerRepo $repo) {
		$this->repo = $repo;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('helpseller');
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
	public function store(HelpSellerRequest $request) {

		$input = $request->except("_token");
		$messages = array(
			'order_id.required' => 'The order id field is required.',
			'order_id.numeric' => 'The order id field is must be a numeric.',
		);
		$validator = Validator::make($input, [
			'name' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
			'order_id' => 'required|numeric',
			'company_name' => 'required|numeric',
			'business_reg_no' => 'required|numeric',
		], $messages);

		if ($validator->fails()) {
			return redirect('sellerhelp')
				->withErrors($validator)
				->withInput();
		}

		$status = $this->repo->create($input);
		return redirect('sellerhelp')->with('success', "Thank You We Will Contact You.");
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
	public function update(HelpSellerRequest $request, $id) {
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
