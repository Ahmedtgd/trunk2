<?php

namespace App\Http\Controllers;

use App\Classes\OpenSupportQuestion;
use App\Classes\OpenSupportCategory;
use Illuminate\Http\Request;

class OpenSupportController extends Controller
{
    public function __construct(OpenSupportQuestion $question, OpenSupportCategory $category, Request $request)
    {
        $this->question = $question;
        $this->category = $category;
        $this->request = $request;
    }

	public function weaccept()
    {
		return view('weaccept');
	}
	
    public function index()
    {
        return view('opensupport',[
            'how_to' => $this->question->like('how to'),
            'what_is' => $this->question->like('what is')
        ]);
    }
}
