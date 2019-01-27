<?php
namespace App\Classes;

use DB;
use Log;
use Carbon;

class Barcode
{
	public function verify($anArrayOfBarcodes=[],$merchant_id)
	{
		Log::debug('***** verify() *****');

		$ret=[];
		//$barcodeString=implode(",",$anArrayOfBarcodes);

		$barcodeString='';
		for ($i=0; $i < sizeof($anArrayOfBarcodes); $i++) { 
			$b="";
			if ($i!=0) {
				$b=',';
			}
		
			$b.="'".$anArrayOfBarcodes[$i]."'";
			$barcodeString.=$b;
		}

		Log::debug('***** barcodeString *****');
		Log::debug($barcodeString);

	
		try {
			$ret=DB::select(DB::raw("
				SELECT 

				bc_management.barcode,
				product.name

				FROM 
				bc_management 
				JOIN productbc ON productbc.bc_management_id=bc_management.id
				JOIN product ON productbc.product_id=product.id
				JOIN merchantproduct on merchantproduct.product_id=product.id 

				WHERE 
				merchantproduct.merchant_id=$merchant_id

				AND bc_management.barcode IN ($barcodeString)
				AND bc_management.deleted_at IS NULL 
				AND productbc.deleted_at IS NULL 
				AND product.deleted_at IS NULL 
				AND merchantproduct.deleted_at IS NULL 
			"));

			Log::debug('***** Barcode::verify(): $ret *****');
			Log::debug(json_encode($ret));

			
		} catch (\Exception $e) {
			Log::error('Error @ '.$e->getLine().' file '.
				$e->getFile().' '.$e->getMessage());
			$ret=$e->getMessage();
		}

		return $ret;
	}
}

