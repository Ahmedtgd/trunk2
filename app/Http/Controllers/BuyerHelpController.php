<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BuyerHelpRequest;
use App\Models\BuyerHelp;
use Illuminate\Http\Request;
use Validator;
use Input;
use View;

class BuyerHelpController extends Controller {

    protected $repo;
    protected $orepo;

//    function __construct(BuyerHelpRepo $repo, OccupationRepo $orepo) {
//        $this->repo = $repo;
//        $this->orepo = $orepo;
//    }

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
        return view('buyerHelp.buyerHelp');
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
     * Get all buyerHelps
     *
     * @method Ajax Get
     */
    public function getBuyerHelp() {
        $buyerHelp = buyerHelp::all('id', 'name', 'porder_id', 'phone', 'remarks', 'email')->toArray();
        $buyerHelps = array();
        foreach ($buyerHelp as $key => $value) {
            if (empty($buyerHelps[$key])) {
                $buyerHelps[$key] = array();
            }
            $buyerHelps[$key]['text'] = $value['name'];
            $buyerHelps[$key]['porder_id'] = $value['porder_id'];
            $buyerHelps[$key]['name'] = $value['name'];
            $buyerHelps[$key]['phone'] = $value['phone'];
            $buyerHelps[$key]['remarks'] = $value['remarks'];
            $buyerHelps[$key]['email'] = $value['email'];
            $buyerHelps[$key]['data-buyerHelp-id'] = $value['id'];
        }
        return response()->json($buyerHelps);
    }

    public function getBuyerHelpTable() {
        return view('admin/buyerHelpTree');
    }

    /**
     * Add new buyerHelp or subbuyerHelp
     *
     * @method Ajax POST
     */
    public function postNewbuyerHelp(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $buyerHelpData = array(
                'name' => $formData['name'],
                'porder_id' => $formData['porder_id'],
                'phone' => $formData['phone'],
                'remarks' => $formData['remarks'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            buyerHelp::insert($buyerHelpData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new buyerHelp or subbuyerHelp
     *
     * @method Ajax POST
     */
    public function postEditbuyerHelp(Request $request) {

        $formData = Input::all();

        $buyerHelpData = array(
            'name' => $formData['name'],
            'porder_id' => $formData['porder_id'],
            'phone' => $formData['phone'],
            'remarks' => $formData['remarks'],
            'email' => $formData['email'],
        );

        buyerHelp::where('id', '=', $formData['data-buyerHelp-id'])->update($buyerHelpData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new buyerHelp or subbuyerHelp
     *
     * @method Ajax POST
     */
    public function removeBuyerHelp() {
        $formData = Input::all();
        buyerHelp::where('id', '=', $formData['data-buyerHelp-id'])->delete();

        echo "success";
        exit();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuyerHelpRequest $request) {
        $input = $request->except("_token");
        $messages = array(
            'occupation_id.required' => 'The professional field is required.',
            'occupation_id.numeric' => 'The professional field is must be a numeric.',
        );
        $validator = Validator::make($input, [
        'company' => 'required',
        'business_reg_no' => 'required|integer|min:0',
        'email' => 'required|email',
        'porder_id' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'occupation_id' => 'required|numeric',
        ], $messages);

        if ($validator->fails()) {
            return redirect('buyerHelp')
                            ->withErrors($validator)
                            ->withInput();
        }
        $status = $this->repo->create($input);
        return redirect('buyerHelp')->with('success', "Thank You We Will Contact You.");
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
    public function update(BuyerHelpRequest $request, $id) {
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
