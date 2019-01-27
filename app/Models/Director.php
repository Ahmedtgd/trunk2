<?php

namespace App\Models;

use File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\MerchantDirector;
use App\Models\HumanCapDirector;
use App\Models\Document;

class Director extends Model
{
    //
    protected $table = 'director';
    protected $guarded = ['id'];

    /*starts relations*/

    /*director belongs to merchantbrand table with m:n */
    public function merchants()
    {
        return $this->belongsToMany('App\Models\Merchant','merchantdirector','director_id','merchant_id');
    }

    /*director belongs to stationbrand table with m:n */
    public function stations()
    {
        return $this->belongsToMany('App\Models\Station','stationdirector','director_id','station_id');
    }
	/*director belongs to stationbrand table with m:n */
    public function humancap()
    {
        return $this->belongsToMany('App\Models\HumanCap','humancapdirector','director_id','humancap_id');
    }
    /*ends relations*/
    public function getMeta()
    {
        return
            $directors =[  "id" =>  null,
                "merchant_id" =>  null, //@imran change it for merchantDirector
                // "station_id" =>  null, //@imran change it for stationDirector?Removed by Zurez
                "country_id" =>  null,
                "name" =>  null,
                "nric" =>  null,
                "photo_1" =>  null,
                "photo_2" => null,
                "deleted_at" =>  null,
                "created_at" =>  null,
                "updated_at" =>  null,
                "pivot_merchant_id" =>  null,
                "pivot_director_id" =>  null
            ];
    }

    public function store(Request $request, $user_as_merchant_model)
    {
        $userMerchantModel =  $user_as_merchant_model;

        //http://stackoverflow.com/questions/28594076/seed-multiple-rows-at-once-laravel-5
        $Dir_id = Director::orderBy('id', 'desc')->take(1)->get();
        foreach ($Dir_id as $DI) {
            $Did = $DI->id;
        }
        if (!isset($Did)) {
            $Did = 0;
        }
        $Document_id = Document::orderBy('id', 'desc')->take(1)->get();
        foreach ($Document_id as $DI) {
            $Documentid = $DI->id;
        }
        if (!isset($Documentid)) {
            $Documentid = 0;
        }

        $Documentid = $Documentid + 1;
        $Did = $Did + 1;

        $length = count($request->get('directors'));//
        $directors = $this->collectDirectorFormData($request, $user_as_merchant_model); // every key has an arr except merchant_id
	//	dd($directors);
        $director = new Director();
        $directorsRecords[] = null;
        $director_model[] = null;
        //lets create a record
        $files = $request->file('directorImages');
		//return $length;
        for($i=0;$i<$length;$i++)
        {
            if(!is_null($files[$i])){
			$files_name = $files[$i]->getClientOriginalName();
			$folder = base_path().'/public/images/director/'.$Documentid;
			$result = File::makeDirectory($folder, 0777,true,true);
			//chmod($folder,0775);
			$destination = $folder.'/';
				if ($files[$i]->move($destination, $files_name)) {

					$record = [
						'name' => $directors['name'][$i],
						'nric' => "",
						'country_id' => 0,
					];
					//end of director record

	               if(isset($userMerchantModel->station_name)){

	                    $record = [
	                    'name' => $directors['name'][$i],
	                    'nric' => $directors['nric'][$i],
	                    'country_id' => $directors['country_id'][$i],
	                //    'station_id' => $directors['merchant_id'] //@imran Change It for stationDirector
	                    ];
	
	               }else{
						 if(isset($userMerchantModel->oshop_name)){
							$record = [
							'name' => $directors['name'][$i],
							'nric' => $directors['nric'][$i],
							'country_id' => $directors['country_id'][$i],
						  //  'merchant_id' => $directors['merchant_id']//@imran Change It for merchantDirector
							];
						 } else {
							 $record = [
							'name' => $directors['name'][$i],
							'nric' => $directors['nric'][$i],
							'country_id' => $directors['country_id'][$i],
						  //  'merchant_id' => $directors['merchant_id']//@imran Change It for merchantDirector
							];
						 }
	                }

					$directorsRecords[] = $record;

					$Doc = new Document();
					$Doc->name = 'director';
					$Doc->path = $files_name;
					$Doc->save();

					$dir_doc = new DirectorDocument();
					$dir_doc->director_id = $Did;
					$dir_doc->document_id = $Documentid;

					$dir_doc->save();
				}
				$Documentid = $Documentid + 1;
				$Did = $Did +1;
			} else {
				$record = [
					'name' => $directors['name'][$i],
					'nric' => $directors['nric'][$i],
					'country_id' => $directors['country_id'][$i],
				];
				
				$dir_doc = new DirectorDocument();
				$dir_doc->director_id = $Did;
				$dir_doc->document_id = $directors['uploadFileid'][$i];

				$dir_doc->save();				
				$Did = $Did +1;
				$directorsRecords[] = $record;
			}
        }

        unset($directorsRecords[0]);// as first record is null  => $directorsRecords[] = null;  so remove it to prevent an extra entry in db
        foreach($directorsRecords as $directorSingleRecord)
        {
            //Todos change it for merchantDirectore
            $newDirector = $director->create($directorSingleRecord);
            $director_model[] = $newDirector;
            /*
             * Check If Director is a merchant Direcotr or
             * a Station Director
             */
            if(isset($userMerchantModel->station_name)){
                $stationDirector = new StationDirector();
                $stationDirector->station_id  = $directors['merchant_id'];
                $stationDirector->director_id = $newDirector->id;
                $stationDirector->save();
            }else{
				 if(isset($userMerchantModel->oshop_name)){
					$merchantDirector = new MerchantDirector();
					$merchantDirector->merchant_id = $directors['merchant_id'];
					$merchantDirector->director_id = $newDirector->id;
					$merchantDirector->save();
				 } else {
					 $humancapDirector = new HumanCapDirector();
					 $humancapDirector->humancap_id = $directors['merchant_id'];
					 $humancapDirector->director_id = $newDirector->id;
					 $humancapDirector->save();
				 }
            }
        }

        unset($director_model[0]);// as first modal is null  =>  $director_model[] = null;  so remove it to prevent an ambiguity for user(developer)

        return $director_model;
    }

    public function collectDirectorFormData(Request $request, $user_as_merchant_model)
    {
        return $director_data = [
            'name' => $request->get('directors'),
            'nric' => $request->get('nric'),
            'country_id' => $request->get('dcountry'),
            'photo_1' => "",
            'uploadFileid' => $request->get('uploadFileid'),
            'merchant_id' => $user_as_merchant_model['id']
        ];
    }

}