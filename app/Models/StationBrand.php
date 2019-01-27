<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Document;
use File;
use DB;

class StationBrand extends Model
{
    protected $table = 'stationbrand';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = ['station_id', 'brand_id', 'subcat_id', 'subcat_level', 'relationship'];

    public function store($request, $station_id)
    {
		
        $Document_id = Document::orderBy('id', 'desc')->take(1)->get();
        foreach ($Document_id as $DI) {
            $Did = $DI->id;
        }
        if (!isset($Did)) {
            $Did = 0;
        }
        $Did = $Did + 1;	
        $station_brands = array();
        //first check if category exist
		$i = 0;
		$subcats = $request->get('subcat_name'); 
		$relationships = $request->get('brand_relationship');		
        foreach ($request->brand_name as $value) {
			$subcat = $subcats[$i];
			$subcatarr = explode('-',$subcat);
            $isfound = StationBrand::where('station_id',$station_id)->where('brand_id',$value)->first();
			$records =[
					'station_id'    => $station_id,
					'brand_id'   => $value,
					'subcat_id'   => $subcatarr[0],
					'subcat_level'   => $subcatarr[1],
					'relationship'   => $relationships[$i],
				];
            if($isfound){
				DB::table('stationbrand')->where('id',$isfound->id)->update($records);
			} else {
				
				$station_brand = new StationBrand();
				$station_brands[] = $station_brand->create($records);				
			}

			$i++;			
		}
		
        $Brandsfiles = $request->file('Brandsupload_attachment');
		$brands = $request->get('brand_name');
        if(count($Brandsfiles) > 0)
        {
            for ($i = 0; $i < count($Brandsfiles); $i++) {
				if(!is_null($Brandsfiles[$i])){
					$files_name1 = $Brandsfiles[$i]->getClientOriginalName();

					$folder = base_path() . '/public/images/document/' . $Did;
					$result1 = File::makeDirectory($folder, 0777, true, true);

					//chmod($folder,0775);
					$destination1 = $folder. '/';

					if ($Brandsfiles[$i]->move($destination1, $files_name1)) {
						$doc = new Document();
						$doc->name = 'brand';
						$doc->path = $files_name1;
						$doc->save();
						$isbrandd = DB::table('branddocument')->where('merchant_id',$station_id)->where('brand_id',$brands[$i])->first();
						if(!is_null($isbrandd )){
							DB::table('branddocument')->where('merchant_id',$isbrandd->id)->update(['document_id'=>$Did,'updated_at'=>date('Y-m-d H:i:s')]);
						} else {
							DB::table('branddocument')->insert(['merchant_id'=>$station_id,'brand_id'=>$brands[$i],'document_id'=>$Did,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);							
						}

						$Did = $Did + 1;
					/*	if (isset($user_model->station_name)){
							$Stadoc = new StationDocument();
							$Stadoc->station_id = $user_id;
							$Stadoc->document_id = $Did;
							$Stadoc->save();
							
						}else{
							$Merdoc = new MerchantDocument();
							$Merdoc->merchant_id = $user_id;
							$Merdoc->document_id = $Did;
							$Merdoc->save();
							$Did = $Did + 1;
						}*/
					}
				}
            }
        }		
    }
}
