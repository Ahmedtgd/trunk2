<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\NewsLetterRequest;
use App\Http\Repository\NewsLetterRepo;
use App\Http\Controllers\Controller;
use Input;
use Validator;
use View;

use App\Models\Newsletter;
use App\Models\Product;
use App\Http\Requests;


class NewsLetterController extends Controller
{
    protected $repo;
    function __construct(NewsLetterRepo $repo) {
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('newsletter');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
/**
     * Get all newsletters
     *
     * @method Ajax Get
     */
    public function getNewsletter() {
        $newsletter = newsletter::all('id', 'full_name', 'contact_number', 'email')->toArray();
        $newsletters = array();
        foreach ($newsletter as $key => $value) {
            if (empty($newsletters[$key])) {
                $newsletters[$key] = array();
            }
            $newsletters[$key]['text'] = $value['full_name'];
            $newsletters[$key]['full_name'] = $value['full_name'];
            $newsletters[$key]['contact_number'] = $value['contact_number'];
            $newsletters[$key]['email'] = $value['email'];
            $newsletters[$key]['data-newsletter-id'] = $value['id'];
        }
//        print_r($newsletters);
        return response()->json($newsletters);
    }

    public function getNewsletterTable() {
        return view('admin/newsletterTree');
    }

    /**
     * Add new newsletter or subnewsletter
     *
     * @method Ajax POST
     */
    public function postNewnewsletter(Request $request) {

        $formData = Input::all();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        if (!empty($formData)) {

            $newsletterData = array(
                'full_name' => $formData['full_name'],
                'contact_number' => $formData['contact_number'],
                'email' => $formData['email'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            newsletter::insert($newsletterData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new newsletter or subnewsletter
     *
     * @method Ajax POST
     */
    public function postEditnewsletter(Request $request) {

        $formData = Input::all();

        $newsletterData = array(
            'full_name' => $formData['full_name'],
            'contact_number' => $formData['contact_number'],
            'email' => $formData['email']
        );

        newsletter::where('id', '=', $formData['data-newsletter-id'])->update($newsletterData);

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new newsletter or subnewsletter
     *
     * @method Ajax POST
     */
    public function removeNewsletter() {
        $formData = Input::all();
        newsletter::where('id', '=', $formData['data-newsletter-id'])->delete();

        echo "success";
        exit();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsLetterRequest $request)
    {

        $input = $request->except("_token");

        $validator = Validator::make($input,[
            'full_name' => 'required',
            'contact_number' => 'required|numeric|min:0',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return redirect('newsletter')
                    ->withErrors($validator)
                    ->withInput();
        }
        $this->repo->create($input);
        return redirect('newsletter')->with(array('success'=>'Record successfully inserted.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
