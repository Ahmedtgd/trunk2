<?php
use Illuminate\Database\Seeder;

class OcbcReturnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('ocbcgiro_return')->insert(array (
 
			1 => array (
				'code' => 'R02',
				'description' => 'Account Closed',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array (
				'code' => 'R03',
				'description' => 'No Account / Unable to Locate Account',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array (
				'code' => 'R04',
				'description' => 'Invalid Account Number',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array (
				'code' => 'R06',
				'description' => 'Returned per OFI’s Request',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => array (
				'code' => 'R07',
				'description' => 'Consumer Advises Not Authorised',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => array (
				'code' => 'R10',
				'description' => 'Authorisation Revoked by Customer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => array (
				'code' => 'R12',
				'description' => 'Branch sold to Another FI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => array (
				'code' => 'R13',
				'description' => 'RFI Not Qualified to Participate',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => array (
				'code' => 'R14',
				'description' => 'Account Holder Deceased (Representative Payee Deceased or Unable to Continue in that Capacity)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => array (
				'code' => 'R15',
				'description' => 'Beneficiary Deceased (Beneficiary or Account Holder – Other than a Representative Payee – Deceased)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => array (
				'code' => 'R16',
				'description' => 'Account Frozen',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => array (
				'code' => 'R17',
				'description' => 'File Record Edit Criteria',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => array (
				'code' => 'R18',
				'description' => 'Improper Effective Entry Date',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => array (
				'code' => 'R19',
				'description' => 'Amount Field Error',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => array (
				'code' => 'R20',
				'description' => 'Non-Transaction Account/ Dormant Account (EPF)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => array (
				'code' => 'R21',
				'description' => 'Invalid Company Identification',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => array (
				'code' => 'R22',
				'description' => 'Invalid Individual ID Number',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => array (
				'code' => 'R23',
				'description' => 'Credit Entry Refused by Receiver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => array (
				'code' => 'R24',
				'description' => 'Duplicate Entry',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => array (
				'code' => 'R25',
				'description' => 'Addenda Error',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => array (
				'code' => 'R27',
				'description' => 'Trace Number Error',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => array (
				'code' => 'R28',
				'description' => 'Transit / Routing Check Digit Errror',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => array (
				'code' => 'R29',
				'description' => 'Corporate Customer Advises Not Authorised',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => array (
				'code' => 'R68',
				'description' => 'Untimely Return',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}
}
