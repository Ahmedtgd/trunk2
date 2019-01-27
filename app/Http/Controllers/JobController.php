<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\JobRepo;
use App\Http\Requests\JobsRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use Validator;
use Input;

class JobController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected $repo;
	function __construct(JobRepo $repo) {
		$this->repo = $repo;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('job_portal');
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
     * Get all jobs
     *
     * @method Ajax Get
     */
    public function getJob() {
		$job = Job::all('id', 'name', 'phone', 'position_applied', 'remarks', 'email')->toArray();
        $jobs = array();
        foreach ($job as $key => $value) {
            if (empty($jobs[$key])) {
                $jobs[$key] = array();
            }
            $jobs[$key]['text'] = $value['name'];
            $jobs[$key]['name'] = $value['name'];
            $jobs[$key]['phone'] = $value['phone'];
            $jobs[$key]['remarks'] = $value['remarks'];
            $jobs[$key]['position_applied'] = $value['position_applied'];
            $jobs[$key]['email'] = $value['email'];
            $jobs[$key]['data-job-id'] = $value['id'];
        }
        return response()->json($jobs);
    }

    public function getJobTable() {
        return view('admin/jobTree');
    }

    /**
     * Add new job or subjob
     *
     * @method Ajax POST
     */
    public function postNewjob(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $jobData = array(
                'name' => $formData['name'],
                'phone' => $formData['phone'],
                'remarks' => $formData['remarks'],
                'position_applied' => $formData['position_applied'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            job::insert($jobData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new job or subjob
     *
	 * @method Ajax
	 */
    public function postEditjob(Request $request) {

        $formData = Input::all();

        $jobData = array(
            'name' => $formData['name'],
            'phone' => $formData['phone'],
            'remarks' => $formData['remarks'],
            'position_applied' => $formData['position_applied'],
            'email' => $formData['email'],
        );

        job::where('id', '=', $formData['data-job-id'])->update($jobData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new job or subjob
     *
	 * @method Ajax
     */
    public function removeJob() {
        $formData = Input::all();
        job::where('id', '=', $formData['data-job-id'])->delete();

        echo "success";
        exit();
    }
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(JobsRequest $request) {

		$input = $request->except("_token");
		$formData = Input::all();
                
                
		$validator = Validator::make($input, [
			'name' => 'required',
			'phone' => 'required',
			'email' => 'required|email',
			'position_applied' => 'required',
		]);

		if ($validator->fails()) {
			return redirect('job')
				->withErrors($validator)
				->withInput();
		}


		Job::create($formData);

		return view('job_portal')->with(array('success' => 'Thank you. We Will notify you.'));

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
