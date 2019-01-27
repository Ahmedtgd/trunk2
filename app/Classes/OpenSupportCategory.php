<?php namespace App\Classes;

use App\Exceptions\CustomException;
use QueryException;
use Carbon;
use DB;

class OpenSupportCategory
{

    public function all()
    {
        return DB::table('ospt_qcategory')->select('*')->get();
    }

    public function find($category)
    {
        return DB::table('ospt_qcategory')->select('*')->where('id', '=', $category)->get();
    }

    public function store(array $data)
    {
        $data['slug'] = str_slug($data['name']);
        return DB::table('ospt_qcategory')->insertGetId($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = str_slug($data['name']);
        $model = DB::table('ospt_qcategory')->where('id', '=', $id);

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

            LEFT JOIN ospt_qcategory c ON q.ospt_qcategory_id = c.id
            ORDER BY q.id
        ");
        } catch(QueryException $e){
            throw new CustomException($e->getMessage());
        }

        return $questions;
    }

    public function delete($id)
    {
        $model = DB::table('ospt_qcategory')->where('id', '=', $id);

        if($model->first()){
            $model->delete();
            return true;
        }

        return false;
    }

}