<?php

namespace App\Http\Repository;

use App\Models\HelpBuyer as HelpBuyer;

class HelpBuyerRepo {
	protected $model;

	function __construct(HelpBuyer $model) {
		$this->model = $model;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return get all records
	 */
	public function index() {
		$object = $this->model->where("deleted_at", null);
		return $object->get();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($input) {
		return $this->model->create($input);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return data base on id
	 */
	public function find($id) {
		return $this->model->find($id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @return data base on id
	 */
	public function findOrFail($id) {
		return $this->model->findOrFail($id);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  $input  $id
	 * @return model
	 */
	public function update($input, $id) {
		return $this->model->update($input)->where($id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return true or false
	 */
	public function destroy($id) {
		return $this->model->delete($id);
	}
}