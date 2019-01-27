<?php namespace App\Classes;

use App\Exceptions\CustomException;
use QueryException;
use Carbon;
use DB;

class OpenSupportSubCategory
{

    public function all($category)
    {
        return DB::table('ospt_qsubcategory')->select('*')->where('parent_id', '=', $category)->get();
    }

    public function find($category, $id)
    {
        $model = DB::table('ospt_qsubcategory')->where('id', '=', $id)->where('parent_id', '=', $category);

       return $model->first();
    }

    public function store(array $data)
    {
        $data['slug'] = str_slug($data['name']);
        return DB::table('ospt_qsubcategory')->insertGetId($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = str_slug($data['name']);
        $model = DB::table('ospt_qsubcategory')->where('id', '=', $id);

        if(count($data) && $model->first())
        {
            if(is_array($data)) $model->update($data);
            return true;
        }

        return false;
    }

    public function questions($id=null)
    {
        try {
            $questions = DB::select("
            SELECT q.id, q.title, q.answer, q.status, c.id, c.name
            FROM ospt_question q

            LEFT JOIN ospt_qsubcategory c ON q.ospt_qsubcategory_id = c.id
            ORDER BY q.id
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $questions;
    }

    public function delete($category, $id)
    {
        $model = DB::table('ospt_qsubcategory')->where('id', '=', $id)->where('parent_id', '=', $category);

        if($model->first()){
            $model->delete();
            return true;
        }

        return false;
    }

}