<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected  $table = 'specification';
	protected $fillable = ['name','description'];

	public function category() {
        return $this->belongsTo('Categoryspec');
    }
   public function subCatLevel1()
	{
		return $this->belongsTo('App\Models\SubCatLevel1');
	}
	
	   public function subCatLevel1Spec()
	{
		return $this->belongsTo('App\Models\SubCatLevel1Spec','spec_id');
	}
	
	  public function productspecs()
    {
        return $this->hasMany('App\Models\Productspec');
    }
	//store specification
	public function storespecification()
	{
		$spec = new Specification();

		$specificationRecords[] = null;
		$specification_model[] = null;
		$specification_name = ['sku','color','model','size','weight','warranty','warranty_type'];
		$specification_description = ['SKU','Colour','Model','Size (L x W x H)','Weight','Warranty Period','Warranty Type'];

		for($i = 0;$i<count($specification_name);$i++) {
			$records = [
				'name' 			=> $specification_name[$i],
				'description' 	=> $specification_description[$i],
			];
			$specificationRecords[] = $records;
		}
		unset($specificationRecords[0]);// as first record is null  => $specificationRecords[] = null;  so remove it to prevent an extra entry in db

		foreach($specificationRecords as $specificationSingleRecords)
		{
			$specification_model[] = $spec->create($specificationSingleRecords);
		}

		unset($specification_model[0]);// as first modal is null  =>  $specification_model[] = null;  so remove it to prevent an ambiguity for user(developer)

		return $specification_model;
	}
}
