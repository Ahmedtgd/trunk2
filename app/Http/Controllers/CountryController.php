<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Support\Facades\Response;

class CountryController extends Controller {
    public function __construct()
    {
        $this->countryModel = new Country();
        $this->stateModel = new State();
        $this->cityModel = new City();
        $this->areaModel = new Area();
    }
    
    public function stateList($id)
    {
        if(!is_numeric($id))
        {
            $res['success'] = false;
            $res['message'] = 'Something went worng';
            return $res;
        }
        $country = $this->countryModel->getCountryCode($id);
        $data = $this->stateModel->getStatesOfCurrentCountry($country->code);
           
        $res['data'] = $data;
        $res['success'] = true;
        $res['message'] = 'Fetched Successfully';

        return Response::json(array(
                $res
            )); 
    }
	
    public function cityList($id)
    {
        if(!is_numeric($id))
        {
            $res['success'] = false;
            $res['message'] = 'Something went worng';
            return $res;
        }
        $state = $this->stateModel->getStateCode($id);
        $data = $this->cityModel->getCitiesOfCurrentState($state->code);
           
        $res['data'] = $data;
        $res['success'] = true;
        $res['message'] = 'Fetched Successfully';

        return Response::json(array(
                $res
            )); 
    }	
	
    public function areaList($id)
    {
        if(!is_numeric($id))
        {
            $res['success'] = false;
            $res['message'] = 'Something went worng';
            return $res;
        }
        $data = $this->areaModel->getAreasOfCurrentCity($id);
           
        $res['data'] = $data;
        $res['success'] = true;
        $res['message'] = 'Fetched Successfully';

        return Response::json(array(
                $res
            )); 
    }	
}