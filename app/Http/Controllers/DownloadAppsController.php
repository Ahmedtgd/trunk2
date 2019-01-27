<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repository\DownloadAppRepo;
use App\Http\Requests\DownloadAppRequest;
use Validator;
use View;
use Input;
use App\Models\DownloadApp;
use App\Models\Product;
use App\HttpC\Requests;

class DownloadAppsController extends Controller {

    protected $repo;

    function __construct(DownloadAppRepo $repo) {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('download');
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
     * Get all downloadappss
     *
     * @method Ajax Get
     */
    public function getDownloadApps() {
        $downloadapps = downloadapp::all('id', 'full_name', 'contact_number', 'email')->toArray();
        $downloadappss = array();
        foreach ($downloadapps as $key => $value) {
            if (empty($downloadappss[$key])) {
                $downloadappss[$key] = array();
            }
            $downloadappss[$key]['text'] = $value['full_name'];
            $downloadappss[$key]['full_name'] = $value['full_name'];
            $downloadappss[$key]['contact_number'] = $value['contact_number'];
            $downloadappss[$key]['email'] = $value['email'];
            $downloadappss[$key]['data-downloadapps-id'] = $value['id'];
        }
//        print_r($downloadappss);
        return response()->json($downloadappss);
    }

    public function getDownloadAppsTable() {
        return view('admin/DownloadAppsTree');
    }

    /**
     * Add new downloadapps or subdownloadapps
     *
     * @method Ajax POST
     */
    public function postNewdownloadapps(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $downloadappsData = array(
                'full_name' => $formData['full_name'],
                'contact_number' => $formData['contact_number'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            downloadapp::insert($downloadappsData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new downloadapps or subdownloadapps
     *
     * @method Ajax POST
     */
    public function postEditdownloadapps(Request $request) {

        $formData = Input::all();

        $downloadappsData = array(
            'full_name' => $formData['full_name'],
            'contact_number' => $formData['contact_number'],
            'email' => $formData['email']
        );

        downloadapp::where('id', '=', $formData['data-downloadapps-id'])->update($downloadappsData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new downloadapps or subdownloadapps
     *
     * @method Ajax POST
     */
    public function removeDownloadApps() {
        $formData = Input::all();
        downloadapp::where('id', '=', $formData['data-downloadapps-id'])->delete();

        echo "success";
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DownloadAppRequest $request) {
        $input = $request->except("_token");

        $validator = Validator::make($input, [
        'full_name' => 'required',
        'contact_number' => 'required|numeric|min:0',
        'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect('downloads')
                            ->withErrors($validator)
                            ->withInput();
        }
        $this->repo->create($input);
        return redirect('downloads')->with(array('success' => 'Thank you. We Will notify you.'));
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
