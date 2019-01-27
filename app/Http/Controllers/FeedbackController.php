<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\FeedbackRepo;
use App\Http\Requests\FeedbackRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Validator;
use Input;

class FeedbackController extends Controller {

    protected $repo;

    function __construct(FeedbackRepo $repo) {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $position = array("1" => "Merchant", "2" => "SMM", "3" => "Buyer", "4" => "Visitor", "5" => "Dealer");
        view()->share('position', $position);
        return view('feedback');
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
     * Get all feedbacks
     *
     * @method Ajax Get
     */
    public function getFeedback() {
        $feedback = feedback::all('id', 'name', 'phone', 'remarks','address', 'email', 'company_name',
                'company_phone','company_address','company_email')->toArray();
        $feedbacks = array();
        foreach ($feedback as $key => $value) {
            if (empty($feedbacks[$key])) {
                $feedbacks[$key] = array();
            }
            $feedbacks[$key]['text'] = $value['name'];
            $feedbacks[$key]['name'] = $value['name'];
            $feedbacks[$key]['company_name'] = $value['company_name'];
            $feedbacks[$key]['company_phone'] = $value['company_phone'];
            $feedbacks[$key]['company_address'] = $value['company_address'];
            $feedbacks[$key]['company_email'] = $value['company_email'];
            $feedbacks[$key]['name'] = $value['name'];
            $feedbacks[$key]['phone'] = $value['phone'];
            $feedbacks[$key]['remarks'] = $value['remarks'];
            $feedbacks[$key]['address'] = $value['address'];
            $feedbacks[$key]['email'] = $value['email'];
            $feedbacks[$key]['data-feedback-id'] = $value['id'];
        }
        return response()->json($feedbacks);
    }

    public function getFeedbackTable() {
        return view('admin/feedbackTree');
    }

    /**
     * Add new feedback or subfeedback
     *
     * @method Ajax POST
     */
    public function postNewfeedback(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $feedbackData = array(
                'name' => $formData['name'],
                'company_name' => $formData['company_name'],
                'company_address' => $formData['company_address'],
                'company_phone' => $formData['company_phone'],
                'company_email' => $formData['company_email'],
                'phone' => $formData['phone'],
                'remarks' => $formData['remarks'],
                'address' => $formData['address'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            feedback::insert($feedbackData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new feedback or subfeedback
     *
     * @method Ajax POST
     */
    public function postEditfeedback(Request $request) {

        $formData = Input::all();

        $feedbackData = array(
            'name' => $formData['name'],
            'company_name' => $formData['company_name'],
            'company_address' => $formData['company_address'],
            'company_phone' => $formData['company_phone'],
            'company_email' => $formData['company_email'],
            'phone' => $formData['phone'],
            'remarks' => $formData['remarks'],
            'address' => $formData['address'],
            'email' => $formData['email'],
        );

        feedback::where('id', '=', $formData['data-feedback-id'])->update($feedbackData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new feedback or subfeedback
     *
     * @method Ajax POST
     */
    public function removeFeedback() {
        $formData = Input::all();
        feedback::where('id', '=', $formData['data-feedback-id'])->delete();

        echo "success";
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeedbackRequest $request) {
        $input = $request->except("_token");
        $messages = array(
            'role_id.required' => 'The position field is required.',
            'role_id.numeric' => 'The position field is must be a numeric.',
        );
        $validator = Validator::make($input, [
        'name' => 'required',
        'phone' => 'required|numeric|min:0',
        'email' => 'required|email',
        'company_name' => 'required',
        'company_phone' => 'required|numeric',
        'company_email' => 'required|email',
        'company_address' => 'required',
        'role_id' => 'required|numeric|min:0',
        ], $messages);

        if ($validator->fails()) {
            return redirect('feedback')
                            ->withErrors($validator)
                            ->withInput();
        }
        $this->repo->create($input);
        return redirect('feedback')->with(array('success' => 'Thank you. We Will notify you.'));
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
