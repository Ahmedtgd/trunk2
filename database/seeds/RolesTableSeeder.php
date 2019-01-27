<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('roles')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('roles')->insert(array (
			0 => array (
				'slug' => 'adm',
				'name' => 'adminstrator',
				'description' => 'Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array (
				'slug' => 'byr',
				'name' => 'buyer',
				'description' => 'Buyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'slug' => 'mer',
				'name' => 'merchant',
				'description' => 'Merchant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'slug' => 'dlr',
				'name' => 'dealer',
				'description' => 'Dealer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'slug' => 'smm',
				'name' => 'social_media_marketeer',
				'description' => 'Social Media Marketeer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => array (
				'slug' => 'mct',
				'name' => 'merchant_consultant',
				'description' => 'Merchant Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			6 => array (
				'slug' => 'mcp',
				'name' => 'merchant_professional',
				'description' => 'Merchant Professional',
				'created_at' => $now,
				'updated_at' => $now,
			), 
			7 => array (
				'slug' => 'opw',
				'name' => 'openwish',
				'description' => 'OpenWish User',
				'created_at' => $now,
				'updated_at' => $now,
			),
 			8 => array (
				'slug' => 'psh',
				'name' => 'pusher',
				'description' => 'Pusher',
				'created_at' => $now,
				'updated_at' => $now,
			), 
  			9 => array (
				'slug' => 'str',
				'name' => 'station_recruiter',
				'description' => 'Station Recruiter',
				'created_at' => $now,
				'updated_at' => $now,
			),  
   			10 => array (
				'slug' => 'sto',
				'name' => 'station_operator',
				'description' => 'Station Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),   
			11 => array (
				'slug' => 'aap',
				'name' => 'admin_approver',
				'description' => 'Admin Approver',
				'created_at' => $now,
				'updated_at' => $now,
			), 
			12 => array (
				'slug' => 'log',
				'name' => 'logistic_company',
				'description' => 'Logistic Company',
				'created_at' => $now,
				'updated_at' => $now,
			),			
 			13 => array (
				'slug' => 'emp',
				'name' => 'employee',
				'description' => 'Employee',
				'created_at' => $now,
				'updated_at' => $now,
			),			 
  			14 => array (
				'slug' => 'pur',
				'name' => 'purchaser',
				'description' => 'Corporate Purchaser',
				'created_at' => $now,
				'updated_at' => $now,
			),			  
   			15 => array (
				'slug' => 'pua',
				'name' => 'purchaser_admin',
				'description' => 'Corporate Purchaser Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),			   
			16 => array (
				'slug' => 'hro',
				'name' => 'human_resource_officer',
				'description' => 'Human Resource Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),			    
 			17 => array (
				'slug' => 'mbr',
				'name' => 'member',
				'description' => 'Member',
				'created_at' => $now,
				'updated_at' => $now,
			),			     
  			18 => array (
				'slug' => 'mba',
				'name' => 'member_admin',
				'description' => 'Member Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),			      
  			19 => array (
				'slug' => 'ebu',
				'name' => 'emp_benefit_user',
				'description' => 'Employee Benefit User',
				'created_at' => $now,
				'updated_at' => $now,
			),			      
  			20 => array (
				'slug' => 'eba',
				'name' => 'emp_benefit_admin',
				'description' => 'Employee Benefit Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),			      
   			21 => array (
				'slug' => 'hcu',
				'name' => 'humancap_user',
				'description' => 'Human Capital User',
				'created_at' => $now,
				'updated_at' => $now,
			),			       
   			22 => array (
				'slug' => 'hca',
				'name' => 'humancap_admin',
				'description' => 'HUman Capital Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),			       
			22 => array (
				'slug' => 'prm',
				'name' => 'promoter',
				'description' => 'Sales Promoter',
				'created_at' => $now,
				'updated_at' => $now,
			),			        
		));
	}
}
