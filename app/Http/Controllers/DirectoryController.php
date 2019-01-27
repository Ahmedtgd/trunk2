<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repository\DirectoryRepo;
use App\Http\Repository\OccupationRepo;
use App\Http\Requests\DirectoryRequest;
use App\Models\Directory;
use Illuminate\Http\Request;
use Validator;
use Input;
use View;

class DirectoryController extends Controller {

    protected $repo;
    protected $orepo;

    function __construct(DirectoryRepo $repo, OccupationRepo $orepo) {
        $this->repo = $repo;
        $this->orepo = $orepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $object = $this->repo->index();
        $professional = $this->orepo->lists()->toArray();
        \View::share("directories", $this->createIndex($object));
        \View::share("professional", $professional);
        return view('directory.directory');
    }

    public function createIndex($object)
    {
        $final = array();
        foreach ($object->toArray() as $key => $value) {
            if (isset($value['occupation_name'])) {
                if (strtolower($value['occupation_name'][0]) == "a" ||
                    strtolower($value['occupation_name'][0]) == "b" ||
                    strtolower($value['occupation_name'][0]) == "c" ||
                    strtolower($value['occupation_name'][0]) == "d"
                ) {
                    $final['A-D'][] = $value;
                } else if (strtolower($value['occupation_name'][0]) == "e" || strtolower($value['occupation_name'][0]) == "f" || strtolower($value['occupation_name'][0]) == "g" || strtolower($value['occupation_name'][0]) == "h") {
                    $final['E-H'][] = $value;
                } else if (strtolower($value['occupation_name'][0]) == "i" || strtolower($value['occupation_name'][0]) == "j" || strtolower($value['occupation_name'][0]) == "k" || strtolower($value['occupation_name'][0]) == "l") {
                    $final['I-L'][] = $value;
                } else if (strtolower($value['occupation_name'][0]) == "m" || strtolower($value['occupation_name'][0]) == "n" || strtolower($value['occupation_name'][0]) == "o" || strtolower($value['occupation_name'][0]) == "p") {
                    $final['M-P'][] = $value;
                } else if (strtolower($value['occupation_name'][0]) == "q" || strtolower($value['occupation_name'][0]) == "r" || strtolower($value['occupation_name'][0]) == "s" || strtolower($value['occupation_name'][0]) == "t") {
                    $final['Q-T'][] = $value;
                } else if (strtolower($value['occupation_name'][0]) == "u" || strtolower($value['occupation_name'][0]) == "v" || strtolower($value['occupation_name'][0]) == "w" || strtolower($value['occupation_name'][0]) == "x") {
                    $final['U-X'][] = $value;
                } else if (strtolower($value['occupation_name'][0]) == "y" || strtolower($value['occupation_name'][0]) == "z") {
                    $final['Y-Z'][] = $value;
                }
            }
        }
        return $final;
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
     * Get all directorys
     *
     * @method Ajax Get
     */
    public function getDirectory() {
        $directory = directory::all('id', 'occupation_id', 'company', 'business_reg_no', 'name', 'phone', 'address', 'email')->toArray();
        $directorys = array();
        foreach ($directory as $key => $value) {
            if (empty($directorys[$key])) {
                $directorys[$key] = array();
            }
            $directorys[$key]['text'] = $value['name'];
            $directorys[$key]['occupation_id'] = $value['occupation_id'];
            $directorys[$key]['company'] = $value['company'];
            $directorys[$key]['business_reg_no'] = $value['business_reg_no'];
            $directorys[$key]['name'] = $value['name'];
            $directorys[$key]['phone'] = $value['phone'];
            $directorys[$key]['address'] = $value['address'];
            $directorys[$key]['email'] = $value['email'];
            $directorys[$key]['data-directory-id'] = $value['id'];
        }
        return response()->json($directorys);
    }

    public function getDirectoryTable() {
        return view('admin/DirectoryTree');
    }

    /**
     * Add new directory or subdirectory
     *
     * @method Ajax POST
     */
    public function postNewdirectory(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $directoryData = array(
                'occupation_id' => $formData['occupation_id'],
                'company' => $formData['company'],
                'business_reg_no' => $formData['business_reg_no'],
                'name' => $formData['name'],
                'phone' => $formData['phone'],
                'address' => $formData['address'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            directory::insert($directoryData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new directory or subdirectory
     *
     * @method Ajax POST
     */
    public function postEditdirectory(Request $request) {

        $formData = Input::all();

        $directoryData = array(
            'occupation_id' => $formData['occupation_id'],
            'company' => $formData['company'],
            'business_reg_no' => $formData['business_reg_no'],
            'name' => $formData['name'],
            'phone' => $formData['phone'],
            'address' => $formData['address'],
            'email' => $formData['email'],
        );

        directory::where('id', '=', $formData['data-directory-id'])->update($directoryData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new directory or subdirectory
     *
     * @method Ajax POST
     */
    public function removeDirectory() {
        $formData = Input::all();
        directory::where('id', '=', $formData['data-directory-id'])->delete();

        echo "success";
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DirectoryRequest $request) {
        $input = $request->except("_token");
        $messages = array(
            'occupation_id.required' => 'The professional field is required.',
            'occupation_id.numeric' => 'The professional field is must be a numeric.',
        );
        $validator = Validator::make($input, [
        'company' => 'required',
        'business_reg_no' => 'required|integer|min:0',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required',
        'occupation_id' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect('directory')
                            ->withErrors($validator)
                            ->withInput();
        }
        $status = $this->repo->create($input);
        return redirect('directory')->with('success', "Thank You We Will Contact You.");
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
    public function update(DirectoryRequest $request, $id) {
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
