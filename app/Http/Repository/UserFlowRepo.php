<?php

/**
 * Created by PhpStorm.
 * User: mihaisolomon
 * Date: 08/04/2017
 * Time: 15:40
 */

namespace App\Http\Repository;

use Illuminate\Support\Facades\DB;

class UserFlowRepo
{
    protected $queries = null;

    public function __construct()
    {
        $today = date("Y-m-d H:i:s");

        $this->queries = [
            'year_count' => [
                'divide' => 1,
                'query' => date('Y-m-d', strtotime("$today -1 year")),
                'lap' => 'YEAR(authtracker.created_at)) as a'
            ],
            'month_count' => [
                'divide' => 12,
                'query' => date('Y-m-d', strtotime("$today -30 days")),
                'lap' => 'MONTH(authtracker.created_at)) as a'
            ],
            'day30_count' => [
                'divide' => 30,
                'query' => date('Y-m-d', strtotime("$today -24 hours")),
                'lap' => 'DAY(authtracker.created_at)) as a'
            ],
            'hours24_count' => [
                'divide' => 24,
                'query' => date('Y-m-d H:i', strtotime("$today -60 minutes")),
                'lap' => 'HOUR(authtracker.created_at)) as a'
            ],
            'minutes60_count' => [
                'divide' => 60,
                'query' => date('Y-m-d H:i', strtotime("$today -1 minutes")),
                'lap' => 'MINUTE(authtracker.created_at)) as a'
            ],
            'seconds60_count' => [
                'divide' => 60,
                'divide1' => 1,
                'query' => date('Y-m-d H:i', strtotime("$today -1 seconds")),
                'lap' => 'SECOND(authtracker.created_at)) as a'
            ]
        ];

    }

    public function count($type)
    {
        switch ($type) {

        }
    }

    protected function getQuery($nationality_code, $lap, $query)
    {
        $query = "select count(authtracker.id) as count 
                  FROM authtracker JOIN users u ON u.id= authtracker.user_id  
                    JOIN country c ON c.id= u.nationality_country_id 
                    WHERE authtracker.created_at > '{$query}' and 
                      authtracker.status='login' and 
                      c.code='{$nationality_code}'";
        return $query;
    }

    protected function getGlobalQuery($lap, $query)
    {
        $query = "SELECT count(authtracker.id) as count FROM authtracker
                     JOIN users u ON u.id= authtracker.user_id
                    JOIN country c ON c.id= u.nationality_country_id 
                      WHERE authtracker.created_at > '{$query}' and authtracker.status='login'";

        return $query;
    }

    public function countLogins($nationality_code, $extension)
    {

        $data = [];
        foreach ($this->queries as $key => $query) {
            if (strpos($extension, 'global') !== false) {
				//dump($query['lap']);
				//dump($query['query']);
                $strQuery = $this->getGlobalQuery($query['lap'], $query['query']);
            } else {
				//dump($query['lap']);
				//dump($query['query']);
                $strQuery = $this->getQuery($nationality_code, $query['lap'], $query['query']);
            }
			//dump($strQuery);
            $object_query = DB::select($strQuery);

            $data[$extension . $key] = (!is_null($object_query[0]->count)) ? round($object_query[0]->count) : 0;
        }
	//	dd($data);
        return $data;
    }

    public function countNewUsers($nationality_id, $extension)
    {
        $data = [];
        foreach ($this->queries as $key => $query) {
            $object_query = DB::table('users as u')
                ->join('buyer as b', 'u.id', '=', 'b.user_id');

            if (strpos($extension, 'global') === false) {
                $object_query->where('u.nationality_country_id', $nationality_id);
            }

            $object_query->whereDate("u.created_at", '>', $query['query']);

            $data[$extension . $key] = $object_query->count();
        }
        return $data;

    }

    public function countTerminations($nationality_id, $extension)
    {
        $data = [];
        foreach ($this->queries as $key => $query) {
            $object_query = DB::table('users as u')
                ->join('buyer as b', 'u.id', '=', 'b.user_id')
                ->where(function ($q) {
                    $q->where("b.status", "terminated");
                    $q->orwhere("b.status", "closed");
                });

            if (strpos($extension, 'global') === false) {
                $object_query->where('u.nationality_country_id', $nationality_id);
            }

            $object_query->whereDate("b.closed_date", '>', $query['query']);

            $data[$extension . $key] = $object_query->count() / $query['divide'];

        }
        return $data;
    }

    public function countTransactions($nationality_id, $extension)
    {
        $data = [];
        foreach ($this->queries as $key => $query) {
            $object_query = DB::table('porder as p')
                ->join('users as u', 'u.id', '=', 'p.user_id');

            if (strpos($extension, 'global') === false) {
                $object_query->where('u.nationality_country_id', $nationality_id);
            }

            $object_query->whereDate("p.created_at", '>', $query['query']);

            $data[$extension . $key] = $object_query->count();
        }

        return $data;
    }

    public function countSiteHits($extension)
    {
        $data = [];
        foreach ($this->queries as $key => $query) {
            $object_query = DB::table('kryptonit3_counter_page_visitor');

            $object_query->where("created_at", '>', $query['query']);
			/*dump($extension);
			dump($query['query']);
			dump($object_query->count());*/
            $data[$extension . $key] = (strpos($extension, 'hkg') !== false) ? 0 : $object_query->count();
        }
		//dd($data);
        return $data;
    }


}