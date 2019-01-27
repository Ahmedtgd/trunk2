<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Document;
use File;
use DB;

class MerchantBrand extends Model
{
    //
    protected $table =  'merchantbrand';
    //use SoftDeletes;
    //protected $dates = ['deleted_at'];
    protected $fillable = ['merchant_id', 'brand_id', 'subcat_id', 'subcat_level', 'relationship'];

    public function store($request, $merchant_id)
    {   //dd($merchant_id);
        $Document_id = Document::orderBy('id', 'desc')->take(1)->get();
        foreach ($Document_id as $DI) {
            $Did = $DI->id;
        }
        if (!isset($Did)) {
            $Did = 0;
        }
        $Did = $Did + 1;	
        $merchant_brands = array();
        //first check if category exist
		$i = 0;
		$subcats = $request->get('subcat_name'); 
		$relationships = $request->get('brand_relationship'); 
		$official = $request->get('official_distributorship'); 
		dump($subcats);

		//dd($official);
        foreach ($request->brand_name as $value) {
			$subcat = $subcats[$i];
			$subcatarr = explode('-',$subcat);
			// dump("$subcatarr". $subcatarr);
			$distributorship = 0;
			if(isset($official[$i])){
				$distributorship = $official[$i];
			}
            $isfound = MerchantBrand::where('merchant_id',$merchant_id)->where('brand_id',$value)->first();
            $subcat_id=$subcatarr[0];
            try {
            	$subcat_level=$subcatarr[1];
            } catch (\Exception $e) {
            	$subcat_level=null;
            }
			$records =[
					'merchant_id'    => $merchant_id,
					'brand_id'   => $value,
					'subcat_id'   => $subcat_id,
					'subcat_level'   => $subcat_level,
					'relationship'   => $relationships[$i],
					'official_distributorship'   => $distributorship
				];
            if($isfound){
				DB::table('merchantbrand')->where('id',$isfound->id)->update($records);
			} else {
				
				$merchant_brand = new MerchantBrand();
				$merchant_brands[] = $merchant_brand->create($records);				
			}

			$i++;
        }
		
        $Brandsfiles = $request->file('Brandsupload_attachment');
		$brands = $request->get('brand_name');
		//dd($Brandsfiles);
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
						$isbrandd = DB::table('branddocument')->where('merchant_id',$merchant_id)->where('brand_id',$brands[$i])->first();
						//dd($isbrandd);
						if(!is_null($isbrandd)){
							DB::table('branddocument')->where('id',$isbrandd->id)->delete();
						} 
						
						DB::table('branddocument')->insert(['merchant_id'=>$merchant_id,'brand_id'=>$brands[$i],'document_id'=>$Did,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);							

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
        return $merchant_brands;
    }
}
