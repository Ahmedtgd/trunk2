<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TermsCondition;
use Auth;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Redirect;
use Input;

class TermsAndConditionController extends Controller {

    protected $repo;

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('privacy');
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
     * Get all termsnConditions
     *
     * @method Ajax Get
     */
    public function getTermsAndCondition() {
        $termsnCondition = termsCondition::all('id', 'ipaddress', 'agree')->toArray();
        $termsnConditions = array();
        foreach ($termsnCondition as $key => $value) {
            if (empty($termsnConditions[$key])) {
                $termsnConditions[$key] = array();
            }
            $termsnConditions[$key]['text'] = $value['ipaddress'];
            $termsnConditions[$key]['ip_address'] = $value['ipaddress'];
            $termsnConditions[$key]['agree'] = $value['agree'];
            $termsnConditions[$key]['data-termsandcondition-id'] = $value['id'];
        }
        
        return response()->json($termsnConditions);
    }

    public function getTermsAndConditionTable() {
        return view('admin/termsConditionTree');
    }

    /**
     * Add new termsnCondition or subtermsnCondition
     *<b style="cursor:pointer;" data-toggle="collapse" href="#collapseExample" class aria-expanded="true"> Table Management</b>
     * @method Ajax POST
     */
    public function postNewTermsAndCondition(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $termsnConditionData = array(
                'ipaddress' => $formData['ip_address'],
                'agree' => $formData['agree'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            termsCondition::insert($termsnConditionData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new termsnCondition or subtermsnCondition
     *
     * @method Ajax POST
     */
    public function postEditTermsAndCondition(Request $request) {

        $formData = Input::all();
        $termsnConditionData = array(
            'ipaddress' => $formData['ip_address'],
            'agree' => $formData['agree'],
        );

        termsCondition::where('id', '=', $formData['data-termsandcondition-id'])->update($termsnConditionData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new termsnCondition or subtermsnCondition
     *
     * @method Ajax POST
     */
    public function removeTermsAndCondition() {
        $formData = Input::all();
        termscondition::where('id', '=', $formData['data-termsandcondition-id'])->delete();

        echo "success";
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrivacyRequest $request) {
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
        return Redirect::back()->with("unsuccess", "Error! Something is wrong..!");
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
