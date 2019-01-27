<?php

use Illuminate\Database\Seeder;

class fpx_respcode_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		\DB::table('fpx_respcode')->truncate();
		$now = \Carbon\Carbon::now()->toDateTimeString();

		\DB::table('fpx_respcode')->insert(array(
		01=>array('respcode'=>'00', 'description'=>'Approved', 'created_at'=>$now, 'updated_at'=>$now),
		02=>array('respcode'=>'03', 'description'=>'Invalid Merchant', 'created_at'=>$now, 'updated_at'=>$now),
		03=>array('respcode'=>'05', 'description'=>'Invalid Seller Or Acquiring Bank Code', 'created_at'=>$now, 'updated_at'=>$now),
		04=>array('respcode'=>'09', 'description'=>'Transaction Pending', 'created_at'=>$now, 'updated_at'=>$now),
		05=>array('respcode'=>'12', 'description'=>'Invalid Transaction', 'created_at'=>$now, 'updated_at'=>$now),
		06=>array('respcode'=>'13', 'description'=>'Invalid Amount', 'created_at'=>$now, 'updated_at'=>$now),
		07=>array('respcode'=>'14', 'description'=>'Invalid Buyer Account', 'created_at'=>$now, 'updated_at'=>$now),
		08=>array('respcode'=>'20', 'description'=>'Invalid Response', 'created_at'=>$now, 'updated_at'=>$now),
		09=>array('respcode'=>'30', 'description'=>'Format Error', 'created_at'=>$now, 'updated_at'=>$now),
		10=>array('respcode'=>'31', 'description'=>'Invalid Bank', 'created_at'=>$now, 'updated_at'=>$now),
		11=>array('respcode'=>'39', 'description'=>'No Credit Account', 'created_at'=>$now, 'updated_at'=>$now),
		12=>array('respcode'=>'45', 'description'=>'Duplicate Seller Order Number', 'created_at'=>$now, 'updated_at'=>$now),
		13=>array('respcode'=>'46', 'description'=>'Invalid Seller Exchange Or Seller', 'created_at'=>$now, 'updated_at'=>$now),
		14=>array('respcode'=>'47', 'description'=>'Invalid Currency', 'created_at'=>$now, 'updated_at'=>$now),
		15=>array('respcode'=>'48', 'description'=>'Maximum Transaction Limit Exceeded', 'created_at'=>$now, 'updated_at'=>$now),
		16=>array('respcode'=>'51', 'description'=>'Insufficient Funds', 'created_at'=>$now, 'updated_at'=>$now),
		17=>array('respcode'=>'53', 'description'=>'No Buyer Account Number', 'created_at'=>$now, 'updated_at'=>$now),
		18=>array('respcode'=>'57', 'description'=>'Transaction Not Permitted', 'created_at'=>$now, 'updated_at'=>$now),
		19=>array('respcode'=>'58', 'description'=>'Transaction To Merchant Not Permitted', 'created_at'=>$now, 'updated_at'=>$now),
		20=>array('respcode'=>'70', 'description'=>'Invalid Serial Number', 'created_at'=>$now, 'updated_at'=>$now),
		21=>array('respcode'=>'76', 'description'=>'Transaction Not Found', 'created_at'=>$now, 'updated_at'=>$now),
		22=>array('respcode'=>'77', 'description'=>'Invalid Buyer Name Or Buyer ID', 'created_at'=>$now, 'updated_at'=>$now),
		23=>array('respcode'=>'78', 'description'=>'Decryption Failed', 'created_at'=>$now, 'updated_at'=>$now),
		24=>array('respcode'=>'79', 'description'=>'Host Decline When Down', 'created_at'=>$now, 'updated_at'=>$now),
		25=>array('respcode'=>'80', 'description'=>'Buyer Cancel Transaction', 'created_at'=>$now, 'updated_at'=>$now),
		26=>array('respcode'=>'83', 'description'=>'Invalid Transaction Model', 'created_at'=>$now, 'updated_at'=>$now),
		27=>array('respcode'=>'84', 'description'=>'Invalid Transaction Type', 'created_at'=>$now, 'updated_at'=>$now),
		28=>array('respcode'=>'85', 'description'=>'Internal Error At Bank System', 'created_at'=>$now, 'updated_at'=>$now),
		29=>array('respcode'=>'87', 'description'=>'Debit Failed Exception Handling', 'created_at'=>$now, 'updated_at'=>$now),
		30=>array('respcode'=>'88', 'description'=>'Credit Failed Exception Handling', 'created_at'=>$now, 'updated_at'=>$now),
		31=>array('respcode'=>'89', 'description'=>'Transaction Not Received Exception Handling', 'created_at'=>$now, 'updated_at'=>$now),
		32=>array('respcode'=>'90', 'description'=>'Bank Internet Banking Unavailable', 'created_at'=>$now, 'updated_at'=>$now),
		33=>array('respcode'=>'92', 'description'=>'Invalid Buyer Bank', 'created_at'=>$now, 'updated_at'=>$now),
		34=>array('respcode'=>'96', 'description'=>'System Malfunction', 'created_at'=>$now, 'updated_at'=>$now),
		35=>array('respcode'=>'98', 'description'=>'MAC Error', 'created_at'=>$now, 'updated_at'=>$now),
		36=>array('respcode'=>'99', 'description'=>'Pending Authorization (Applicable for B2B model)', 'created_at'=>$now, 'updated_at'=>$now),
		37=>array('respcode'=>'BB', 'description'=>'Blocked Bank', 'created_at'=>$now, 'updated_at'=>$now),
		38=>array('respcode'=>'BC', 'description'=>'Transaction Cancelled By Customer', 'created_at'=>$now, 'updated_at'=>$now),
		39=>array('respcode'=>'FE', 'description'=>'Internal Error', 'created_at'=>$now, 'updated_at'=>$now),
		40=>array('respcode'=>'OE', 'description'=>'Transaction Rejected As Not In FPX Operating Hours', 'created_at'=>$now, 'updated_at'=>$now),
		41=>array('respcode'=>'OF', 'description'=>'Transaction Timeout', 'created_at'=>$now, 'updated_at'=>$now),
		42=>array('respcode'=>'SB', 'description'=>'Invalid Acquiring Bank Code', 'created_at'=>$now, 'updated_at'=>$now),
		43=>array('respcode'=>'XA', 'description'=>'Invalid Source IP Address (Applicable for B2B2 model)', 'created_at'=>$now, 'updated_at'=>$now),
		44=>array('respcode'=>'XB', 'description'=>'Invalid Seller Exchange IP', 'created_at'=>$now, 'updated_at'=>$now),
		45=>array('respcode'=>'XC', 'description'=>'Seller Exchange Encryption Error', 'created_at'=>$now, 'updated_at'=>$now),
		46=>array('respcode'=>'XE', 'description'=>'Invalid Message', 'created_at'=>$now, 'updated_at'=>$now),
		47=>array('respcode'=>'XF', 'description'=>'Invalid Number Of Orders', 'created_at'=>$now, 'updated_at'=>$now),
		48=>array('respcode'=>'XI', 'description'=>'Invalid Seller Exchange', 'created_at'=>$now, 'updated_at'=>$now),
		49=>array('respcode'=>'XM', 'description'=>'Invalid FPX Transaction Model', 'created_at'=>$now, 'updated_at'=>$now),
		50=>array('respcode'=>'XN', 'description'=>'Transaction Rejected Due To Duplicate Seller Exchange Order Number', 'created_at'=>$now, 'updated_at'=>$now),
		51=>array('respcode'=>'XO', 'description'=>'Duplicate Exchange Order Number', 'created_at'=>$now, 'updated_at'=>$now),
		52=>array('respcode'=>'XS', 'description'=>'Seller Does Not Belong To Exchange', 'created_at'=>$now, 'updated_at'=>$now),
		53=>array('respcode'=>'XT', 'description'=>'Invalid Transaction Type', 'created_at'=>$now, 'updated_at'=>$now),
		54=>array('respcode'=>'XW', 'description'=>'Seller Exchange Date Difference Exceeded', 'created_at'=>$now, 'updated_at'=>$now),
		55=>array('respcode'=>'1A', 'description'=>'Buyer Session Timeout At Internet Banking Login Page', 'created_at'=>$now, 'updated_at'=>$now),
		56=>array('respcode'=>'1B', 'description'=>'Buyer Failed To Provide The Necessary Info To Login To Internet Banking Login Page', 'created_at'=>$now, 'updated_at'=>$now),
		57=>array('respcode'=>'1C', 'description'=>'Buyer Choose Cancel At Login Page', 'created_at'=>$now, 'updated_at'=>$now),
		58=>array('respcode'=>'1D', 'description'=>'Buyer Session Timeout At Account Selection Page', 'created_at'=>$now, 'updated_at'=>$now),
		59=>array('respcode'=>'1E', 'description'=>'Buyer Failed To Provide The Necessary Info At Account Selection Page', 'created_at'=>$now, 'updated_at'=>$now),
		60=>array('respcode'=>'1F', 'description'=>'Buyer Choose Cancel At Account Selection Page', 'created_at'=>$now, 'updated_at'=>$now),
		61=>array('respcode'=>'1G', 'description'=>'Buyer Session Timeout At TAC Request Page', 'created_at'=>$now, 'updated_at'=>$now),
		62=>array('respcode'=>'1H', 'description'=>'Buyer Failed To Provide The Necessary Info At TAC Request Page', 'created_at'=>$now, 'updated_at'=>$now),
		63=>array('respcode'=>'1I', 'description'=>'Buyer Choose Cancel At TAC Request Page', 'created_at'=>$now, 'updated_at'=>$now),
		64=>array('respcode'=>'1J', 'description'=>'Buyer Session Timeout At Confirmation Page', 'created_at'=>$now, 'updated_at'=>$now),
		65=>array('respcode'=>'1K', 'description'=>'Buyer Failed To Provide The Necessary Info At Confirmation Page', 'created_at'=>$now, 'updated_at'=>$now),
		66=>array('respcode'=>'1L', 'description'=>'Buyer Choose Cancel At Confirmation Page', 'created_at'=>$now, 'updated_at'=>$now),
		67=>array('respcode'=>'1M', 'description'=>'Internet Banking Session Timeout.', 'created_at'=>$now, 'updated_at'=>$now),
		68=>array('respcode'=>'2A', 'description'=>'Transaction Amount Is Lower Than Minimum Limit', 'created_at'=>$now, 'updated_at'=>$now),
		));

    }
}
