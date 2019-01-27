<?php

use Illuminate\Database\Seeder;

class DirectorySeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::table('directory')->truncate();

		$now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('directory')->insert(array(
			0 => array(
				'id' => 1,
				'occupation_id' => 9,
				'company' => 'Michael Page International (Malaysia) Sdn Bhd (914741-W)',
				'business_reg_no' => 0001,
				'name' => 'Michael Page International (Malaysia) Sdn Bhd (914741-W)',
				'phone' => '+603 2302 4000',
				'address' => 'Level 27 Integra Tower, The Intermark, 348 Jalan Tun Razak, Kuala Lumpur, Malaysia',
				'email' => 'Test1@gmail.com',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => array(
				'id' => 2,
				'occupation_id' => 9,
				'company' => 'Michael Page International (Malaysia) Sdn Bhd (914741-W)',
				'business_reg_no' => 0002,
				'name' => 'Michael Page International (Malaysia) Sdn Bhd (914741-W)',
				'phone' => '+603 2302 4000',
				'address' => ' Level 27 Integra Tower, The Intermark, 348 Jalan Tun Razak, Kuala Lumpur, Malaysia',
				'email' => 'Test2@gmail.com',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => array(
				'id' => 3,
				'occupation_id' => 10,
				'company' => 'Ideoimage Sdn Bhd ',
				'business_reg_no' => 0003,
				'name' => 'Ideoimage Sdn Bhd ',
				'phone' => '+603 7728 9033',
				'address' => 'E-1-1, Jalan PJU 8/1, Neo Damansara Perdana, Petaling Jaya, 47820, Selangro, Malaysia / info@ideoimage.com.my',
				'email' => 'Test3@gmail.com',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => array(
				'id' => 4,
				'occupation_id' => 10,
				'company' => 'Art Dimension Marketing Sdn Bhd',
				'business_reg_no' => 0004,
				'name' => 'Art Dimension Marketing Sdn Bhd',
				'phone' => '+603 9133 3614',
				'address' => 'No 20-0-5, Jalan 2/101 C Cheras Business Center Kuala Lumpur, Malaysia',
				'email' => 'Test4@gmail.com',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => array(
				'id' => 5,
				'occupation_id' => 11,
				'company' => 'ATSA Architecture',
				'business_reg_no' => 0005,
				'name' => 'ATSA Architecture',
				'phone' => '+603 7727 1877',
				'address' => 'No.54, Jalan Tun Mohd Fuad 3, Taman Tun Dr. Ismail, 60000, Kuala Lumpur, Malaysia ',
				'email' => 'Test5@gmail.com',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}
}
