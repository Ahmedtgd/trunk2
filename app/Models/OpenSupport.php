<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class OpenSupport extends Model
{
    protected $table = "opensupport";

public static function saveData($data = null)
{
	try
 	{
 	$dateTime	=date('Y-m-d H:i:s');
	$result		=DB::table('opensupport')
       			->insert([
            	'full_name' 			=> $data['name'],
            	'contact_number' 		=> $data['contact'],
            	'email' 				=> $data['email'],
            	'as_a' 					=> $data['asEmail'],
            	'company_name'			=> $data['CName'],
            	'corporate_number'		=> $data['cNumber'],
            	'corporate_email'		=> $data['cEmail'],
            	'corporate_billing_address'	=> $data['billingAddress'],
            	// 'order_id'				=> $data['orderId'],
            	'remark'				=> $data['remark'],
            	'type'					=> $data['type'],
            	'created_at'			=> $dateTime,
            	]);
if ($result) {
				return true;
			}
			else
			{
				return false;

			}
            	
            	}

			 catch(\Exception $e)
			 {
					return $e;
			 }     

}
 
}
