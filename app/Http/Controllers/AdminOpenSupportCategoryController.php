<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Classes\OpenSupportQuestion;
use App\Classes\OpenSupportCategory;
use Illuminate\Http\Request;

class AdminOpenSupportCategoryController extends Controller
{
    public function __construct(OpenSupportCategory $category, Request $request)
    {
        $this->category = $category;
        $this->request = $request;
    }

    public function getIndex()
    {
        $categories = collect($this->category->all());

        if($this->request->wantsJson()){
            return response()->json([
                'data' => [
                    'categories' => $categories
                ],
                'status' => true
            ]);
        }

        return view('admin.general.opensupport_category', [
            'categories' => $categories
        ]);
    }

    public function postStore()
    {
        $category = $this->request->only(['name', 'description', 'status']);

        $validator = \Validator::make($category, [
            'name' => 'min:3'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }else{

            if($category = $this->category->store($category)){
                return response()->json([
                    'data' => collect($this->category->all()),
                    'message' => 'Category has been added. Add more below',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Category could not be saved'
                ]);
            }
        }
    }


    public function postUpdate($id)
    {
        $category = $this->request->only(['name', 'description', 'status']);

        $validator = \Validator::make($category, [
            'name' => 'min:3'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }else{
            if($category = $this->category->update($id, $category)){
                return response()->json([
                    'data' => collect($this->category->all()),
                    'message' => 'Category updated successfully',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Category could not be updated'
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
        if($category = $this->category->delete($id)){
            return response()->json([
                'data' => collect($this->category->all()),
                'message' => 'Category has been deleted',
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Category could not be deleted'
            ]);
        }
    }
}
