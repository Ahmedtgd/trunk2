<?php

use Illuminate\Database\Seeder;

class merchant_commission_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('merchant')->
			where('company_name','like','Ideal Vision%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Grayns Malaysia%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Supreme Global%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Moneual%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Y&C Beauty%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Aimedia%')->
			update(['osmall_commission'=>7.00, 'commission_type'=>'std']);
		/* Not found */
		\DB::table('merchant')->
			where('company_name','like','Pioneer%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','SaintInk%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Perfect%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','EMW%')->
			update(['osmall_commission'=>20.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','E Century%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Afiintra%')->
			update(['osmall_commission'=>5.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Mobilehaus%')->
			update(['osmall_commission'=>5.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Konwa%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','IT Network Distribution%')->
			update(['osmall_commission'=>15.00,'commission_type'=>'std',
				'b2b_osmall_commission'=>10.00,'b2b_commission_type'=>'std'
			]);
		/* Not found */
		\DB::table('merchant')->
			where('company_name','like','Mationz%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Winston%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Limehill%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Global IT Zone%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Xun Xin%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Nature Himmel%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','My ShopNSave%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','E Wheels%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','The Loot%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Safety%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','Ban%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','G-Max%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
		\DB::table('merchant')->
			where('company_name','like','De Cario%')->
			update(['osmall_commission'=>15.00, 'commission_type'=>'std']);

 		/* Distexpress: Variable Commission
		 * 10% for Mobile Phones & Tablet Accessories (e.g. Spigen)
		 * 15% for others (e.g. Aftershokz) */
		\DB::table('merchant')->
			where('company_name','like','Distexpress%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'var']);

  		/* Lau Malaysia Distribution: Variable Commission
		 *  7%	for Camera/Action Camera, Camera/Optics Binoculars,
		 *		Headphone & Earphone, Camera/Accessories/Dry Cabinets,
		 *		Camera/Accessories/Cases/Bags
		 * 10%	for others */
		\DB::table('merchant')->
			where('company_name','like','Lau Malaysia%')->
			update(['osmall_commission'=>7.00, 'commission_type'=>'var']);

		/* Sat Oct 28 19:29:43 MYT 2017 */
  		\DB::table('merchant')->
			where('company_name','like','Novoz%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']); 

   		/* Lau Malaysia Distribution: Variable Commission
		 *  1%	for Cameras
		 *  7%	for others */ 
 		\DB::table('merchant')->
			where('company_name','like','YL Camera%')->
			update(['osmall_commission'=>7.00, 'commission_type'=>'var']);

 		\DB::table('merchant')->
			where('company_name','like','ESP%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
 		\DB::table('merchant')->
			where('company_name','like','Nan Hua%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
 		\DB::table('merchant')->
			where('company_name','like','Coco Paradise%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);
 		\DB::table('merchant')->
			where('company_name','like','Since Baby%')->
			update(['osmall_commission'=>10.00, 'commission_type'=>'std']);

    }
}
