<?php namespace App\Classes;

use App\Exceptions\CustomException;
use QueryException;
use Carbon;
use DB;

class OpenSupportQuestion
{
    public function all()
    {
//        return DB::table('ospt_question')->select('*')->get();

        try {
            $questions = DB::select("
            SELECT q.id, q.title, q.answer, q.status, q.description, c.name as category,  c.id as category_id,
              q.ospt_qsubcategory_id as subcategory_id
            FROM ospt_question q

            LEFT JOIN ospt_qcategory c ON q.ospt_qcategory_id = c.id
            ORDER BY q.id DESC
        ");

        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $questions;
    }

    public function store(array $data)
    {
        return DB::table('ospt_question')->insertGetId($data);
    }

    public function update($id, array $data)
    {
        return DB::table('ospt_question')->where('id', '=', $id)->update($data);
    }

    public function delete($id)
    {
        $model = DB::table('ospt_question')->where('id', '=', $id);

        if($model->first()){
            $model->delete();
            return true;
        }

        return false;
    }

    public function category($id=null)
    {
        try {
            $questions = DB::select("
            SELECT q.id, q.title, q.answer, q.status, c.id, c.name
            FROM ospt_question q

            LEFT JOIN ospt_qcategory c ON q.ospt_qcategory_id = c.id
            ORDER BY q.id
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $questions;
    }


    public function like($like){
        return DB::table('ospt_question')
            ->where('title', 'like', $like.'%')
            ->get();
    }
}