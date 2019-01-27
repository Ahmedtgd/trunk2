<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Classes\OpenSupportQuestion;
use App\Classes\OpenSupportCategory;
use Illuminate\Http\Request;

class AdminOpenSupportController extends Controller
{
    public function __construct(OpenSupportQuestion $question, OpenSupportCategory $category, Request $request)
    {
    
        $this->question = $question;
        $this->category = $category;
        $this->request = $request;

    }

    public function getIndex()
    {
        $questions = collect($this->question->all());
        $categories = collect($this->category->all());

       if($this->request->wantsJson()){
            return response()->json([
                'data' => [
                    'questions' => $questions,
                    'categories' => $categories
                ],
                'status' => true
            ]);
        }


      return view('admin.general.opensupport', [
            'questions' => $questions,
            'categories' => $categories
        ]);
    }

    public function postStore()
    {
        $question = $this->request->only(['title', 'answer', 'status', 'ospt_qcategory_id', 'ospt_qsubcategory_id']);

        $validator = \Validator::make($question, [
            'title' => 'min:3',
            'category' => 'numeric',
            'answer' => 'min:3',
            'status' => 'alpha'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }else{

            if($question = $this->question->store($question)){
                return response()->json([
                    'data' => collect($this->question->all()),
                    'message' => 'Question has been added. Add more below',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Question could not be saved'
                ]);
            }
        }
    }


    public function postUpdate($id)
    {
        $question = $this->request->only(['title', 'answer', 'status', 'ospt_qcategory_id', 'ospt_qsubcategory_id']);

        $validator = \Validator::make($question, [
            'title' => 'min:3',
            'category' => 'numeric',
            'answer' => 'min:3',
            'status' => 'alpha'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }else{
            if($question = $this->question->update($id, $question)){
                return response()->json([
                    'data' => collect($this->question->all()),
                    'message' => 'Question updated successfully',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Question could not be updated'
                ]);
            }
        }
    }


    /**
     * @param $id
     * @return mixed
     * @throws \App\Exceptions\CustomException
     */
    public function getDelete($id)
    {
        if($question = $this->question->delete($id)){
            return response()->json([
                'data' => collect($this->question->all()),
                'message' => 'Question has been deleted',
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Question could not be deleted'
            ]);
        }
    }

}
