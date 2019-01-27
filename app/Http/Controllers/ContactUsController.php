<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\ContactUsRepo;
use App\Http\Requests\ContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Validator;
use Input;

class ContactUsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function __construct(ContactUsRepo $repo) {
		$this->repo = $repo;
	}

	public function index() {
		return view('contact');
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
     * Get all contactUss
     *
     * @method Ajax Get
     */
    public function getContactUs() {
        $contactUs = contactUs::all('id', 'name', 'phone', 'remarks', 'email')->toArray();
        $contactUss = array();
        foreach ($contactUs as $key => $value) {
            if (empty($contactUss[$key])) {
                $contactUss[$key] = array();
            }
            $contactUss[$key]['text'] = $value['name'];
            $contactUss[$key]['name'] = $value['name'];
            $contactUss[$key]['phone'] = $value['phone'];
            $contactUss[$key]['remarks'] = $value['remarks'];
            $contactUss[$key]['email'] = $value['email'];
            $contactUss[$key]['data-contactUs-id'] = $value['id'];
        }
        return response()->json($contactUss);
    }

    public function getContactUsTable() {
        return view('admin/contactUsTree');
    }

    /**
     * Add new contactUs or subcontactUs
     *
     * @method Ajax POST
     */
    public function postNewcontactUs(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $contactUsData = array(
                'name' => $formData['name'],
                'phone' => $formData['phone'],
                'remarks' => $formData['remarks'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            contactUs::insert($contactUsData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new contactUs or subcontactUs
     *
     * @method Ajax POST
     */
    public function postEditcontactUs(Request $request) {

        $formData = Input::all();

        $contactUsData = array(
            'name' => $formData['name'],
            'phone' => $formData['phone'],
            'remarks' => $formData['remarks'],
            'email' => $formData['email'],
        );

        contactUs::where('id', '=', $formData['data-contactUs-id'])->update($contactUsData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new contactUs or subcontactUs
     *
     * @method Ajax POST
     */
    public function removeContactUs() {
        $formData = Input::all();
        contactUs::where('id', '=', $formData['data-contactUs-id'])->delete();

        echo "success";
        exit();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ContactUsRequest $request) {
		$input = $request->except("_token");

		$validator = Validator::make($input, [
			'name' => 'required',
			'phone' => 'required|min:0',
			'email' => 'required|email',
		]);

		if ($validator->fails()) {
			return redirect('contactus')
				->withErrors($validator)
				->withInput();
		}
		$this->repo->create($input);
		return redirect('contactus')->with(array('success' => 'Thank you. We Will notify you.'));
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
	public function update(ContactUsRepo $request, $id) {
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
