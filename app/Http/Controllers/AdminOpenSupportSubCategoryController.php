<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Classes\OpenSupportQuestion;
use App\Classes\OpenSupportCategory;
use App\Classes\OpenSupportSubCategory;
use Illuminate\Http\Request;

class AdminOpenSupportSubCategoryController extends Controller
{
    public function __construct(OpenSupportCategory $category, OpenSupportSubCategory $sub_category, Request $request)
    {
        $this->category = $category;
        $this->sub_category = $sub_category;
        $this->request = $request;
    }

    public function getIndex($category)
    {
        $sub_categories = collect($this->sub_category->all($category));
        $category = collect($this->category->find($category))->first();

        if($this->request->wantsJson()){
            return response()->json([
                'data' => [
                    'category' => $category,
                    'sub_categories' => $sub_categories
                ],
                'status' => true
            ]);
        }

        return view('admin.general.opensupport_subcategory', [
            'category' => $category,
            'sub_categories' => $sub_categories
        ]);
    }

    public function postStore($category=null)
    {
        $sub_category = $this->request->only(['name', 'description', 'status', 'parent_id']);

        $validator = \Validator::make($sub_category, [
            'name' => 'min:3'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }else{

            if($sub_category = $this->sub_category->store($sub_category)){
                return response()->json([
                    'data' => collect($this->sub_category->all($category)),
                    'message' => 'Sub-category has been added. Add more below',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Sub-category could not be saved'
                ]);
            }
        }
    }


    public function postUpdate($id, $category=null)
    {
        $sub_category = $this->request->only(['name', 'description', 'status', 'parent_id']);

        $validator = \Validator::make($sub_category, [
            'name' => 'min:3'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }else{
            if($sub_category = $this->sub_category->update($id, $sub_category)){
                return response()->json([
                    'data' => collect($this->sub_category->all($category)),
                    'message' => 'Sub-category updated successfully',
                    'status' => true
                ]);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Sub-category could not be updated'
                ]);
            }
        }
    }


    /**
     * @param $id
     * @return mixed
     * @throws \App\Exceptions\CustomException
     */
    public function getDelete($category, $id)
    {
        if($sub_category = $this->sub_category->delete($category, $id)){
            return response()->json([
                'data' => collect($this->sub_category->all($category)),
                'message' => 'Sub-category has been deleted',
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Sub-category could not be deleted'
            ]);
        }
    }

    public function getById($category, $id)
    {
        if($sub_category = $this->sub_category->find($category, $id)){
            return response()->json([
                'data' => collect($sub_category),
                'status' => true
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Sub-category not found'
            ]);
        }
    }
}
