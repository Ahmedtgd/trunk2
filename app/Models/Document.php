<?php

namespace App\Models;

use File;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class Document extends Model
{
    protected $table ="document";

    public function merchant()
    {
        return $this->belongsToMany('App\Models\Merchant','merchantdocument','document_id','merchant_id');
    }

    public function station()
    {
        return $this->belongsToMany('App\Models\Station','stationdocument','document_id','station_id');
    }
	
	public function humancap()
    {
        return $this->belongsToMany('App\Models\HumanCap','humancapdocument','document_id','humancap_id');
    }

    public function store(Request $request,$user_as_merchant_model)
    {
        $user_model = $user_as_merchant_model;

        
        $user_id = $user_as_merchant_model['id'];
        /*
        * Get product last id from document table
        */
        $Document_id = Document::orderBy('id', 'desc')->take(1)->get();
        foreach ($Document_id as $DI) {
            $Did = $DI->id;
        }
        if (!isset($Did)) {
            $Did = 0;
        }
        $Did = $Did + 1;
        $documents = $request; // every key has an arr except merchant_id
		$length = $request->get('uploadFileDoc');
        $files = $request->file('Regupload_attachment');
        $names = $request->get('uploadFileBRName');//Brand
	/*	dump($length);
		dump($files);
		dd($names);*/

        if(count($length) > 0) {
            for ($i = 0; $i < count($length); $i++) {
                if(!is_null($files[$i])){
					$files_name = $files[$i]->getClientOriginalName();
					$folder = base_path() . '/public/images/document/' . $Did;

					$result = File::makeDirectory($folder,0777, true, true);
					//dd($result);
					//chmod($folder,0775);
					$destination = $folder. '/';

					if ($files[$i]->move($destination, $files_name)) {
						
						$doc = new Document();
						$doc->name = 'registration';
						$doc->path = $files_name;
						$doc->save();

						if (isset($user_model->station_name)){
							if(isset($names[$i])) {
								if($names[$i] != "0"){
									$old_doc = DB::table('document')->join('stationdocument','document.id','=','stationdocument.document_id')->where('path',$length[$i])->where('station_id',$user_id)->first();
									if(!is_null($old_doc)){
										DB::table('stationdocument')->where('document_id',$old_doc->document_id)->delete();
									}
								}
							}
							//dd($user_id);
							$Stadoc = new StationDocument();
							$Stadoc->station_id = $user_id;
							$Stadoc->document_id = $Did;
							$Stadoc->save();
							//dd($Stadoc);
							$Did = $Did + 1;
						}else{
							if (isset($user_model->oshop_name)){
								if(isset($names[$i])) {
									if($names[$i] != "0"){
										$old_doc = DB::table('document')->join('merchantdocument','document.id','=','merchantdocument.document_id')->where('path',$length[$i])->where('merchant_id',$user_id)->first();
										//dd($old_doc);
										if(!is_null($old_doc)){
											DB::table('merchantdocument')->where('document_id',$old_doc->document_id)->delete();
										}
									}
								}
								$Merdoc = new MerchantDocument();
								$Merdoc->merchant_id = $user_id;
								$Merdoc->document_id = $Did;
								$Merdoc->save();
								$Did = $Did + 1;
							} else {
								if(isset($names[$i])) {
									if($names[$i] != "0"){
										$old_doc = DB::table('document')->join('humancapdocument','document.id','=','humancapdocument.document_id')->where('path',$length[$i])->where('merchant_id',$user_id)->first();
										//dd($old_doc);
										if(!is_null($old_doc)){
											DB::table('humancapdocument')->where('document_id',$old_doc->document_id)->delete();
										}
									}
								}
								$Merdoc = new HumanCapDocument();
								$Merdoc->humancap_id = $user_id;
								$Merdoc->document_id = $Did;
								$Merdoc->save();
								$Did = $Did + 1;
							}
						}
					}
				} else {
				//	if($names[$i] != "0"){
					/*	$doc = new Document();
						$doc->name = 'registration';
						$doc->path = $names[$i];
						$doc->save();	
						
						if (isset($user_model->station_name)){
							$Stadoc = new StationDocument();
							$Stadoc->station_id = $user_id;
							$Stadoc->document_id = $Did;
							$Stadoc->save();
							$Did = $Did + 1;
						}else{
							$Merdoc = new MerchantDocument();
							$Merdoc->merchant_id = $user_id;
							$Merdoc->document_id = $Did;
							$Merdoc->save();
							$Did = $Did + 1;
						}	*/					
				//	}	
				}
            }
        }
        $Remarksfiles = $request->file('Remarksupload_attachment');
        $Remarksfilesname = $request->get('uploadFileRem');
		$lengthrem = $request->get('uploadFileDocRem');
		/*dump($Remarksfiles);
		dd($Remarksfilesname);*/
        if(count($Remarksfilesname) > 0)
        {
            for ($i = 0; $i < count($Remarksfilesname); $i++) {
				if(!is_null($Remarksfiles[$i])){
					$files_name1 = $Remarksfiles[$i]->getClientOriginalName();

					$folder = base_path() . '/public/images/document/' . $Did;
					$result1 = File::makeDirectory($folder, 0777, true, true);

					//chmod($folder,0775);
					$destination1 = $folder. '/';

					if ($Remarksfiles[$i]->move($destination1, $files_name1)) {
						$doc = new Document();
						$doc->name = 'remarks';
						$doc->path = $files_name1;
						$doc->save();

						if (isset($user_model->station_name)){
							if(isset($lengthrem[$i])) {
								if($lengthrem[$i] != "0"){
									$old_doc = DB::table('document')->join('stationdocument','document.id','=','stationdocument.document_id')->where('station_id',$user_id)->where('path',$lengthrem[$i])->first();
									if(!is_null($old_doc)){
										DB::table('stationdocument')->where('document_id',$old_doc->document_id)->delete();
									}
								}
							}
							$Stadoc = new StationDocument();
							$Stadoc->station_id = $user_id;
							$Stadoc->document_id = $Did;
							$Stadoc->save();
							$Did = $Did + 1;
						}else{
							if(isset($lengthrem[$i])) {
								if($lengthrem[$i] != "0"){
									$old_doc = DB::table('document')->join('merchantdocument','document.id','=','merchantdocument.document_id')->where('merchant_id',$user_id)->where('path',$lengthrem[$i])->first();
									if(!is_null($old_doc)){
										DB::table('merchantdocument')->where('document_id',$old_doc->document_id)->delete();
									}
								}
							}
							$Merdoc = new MerchantDocument();
							$Merdoc->merchant_id = $user_id;
							$Merdoc->document_id = $Did;
							$Merdoc->save();
							$Did = $Did + 1;
						}
					}
				} else {
					/*	$doc = new Document();
						$doc->name = 'remarks';
						$doc->path = $Remarksfilesname[$i];
						$doc->save();

						if (isset($user_model->station_name)){
							$Stadoc = new StationDocument();
							$Stadoc->station_id = $user_id;
							$Stadoc->document_id = $Did;
							$Stadoc->save();
							$Did = $Did + 1;
						}else{
							$Merdoc = new MerchantDocument();
							$Merdoc->merchant_id = $user_id;
							$Merdoc->document_id = $Did;
							$Merdoc->save();
							$Did = $Did + 1;
						}	*/				
				}
            }
        }		
    }
}


