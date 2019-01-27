<?php

use Illuminate\Database\Seeder;

class OccupationTableSeeder_all extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('occupation')->delete();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Abaca Farm Worker',
				'description' => 'Abaca Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Abaca Hemp Hagotan Operator',
				'description' => 'Abaca Hemp Hagotan Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 3,
			'name' => 'Abattoir (Government Services) Veterinarian',
			'description' => 'Abattoir (Government Services) Veterinarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Able Seaman',
				'description' => 'Able Seaman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Able Seaman',
				'description' => 'Able Seaman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Aborigines YP1-10 Constable',
				'description' => 'Aborigines YP1-10 Constable',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'Abrasive Coating Machine Operator',
				'description' => 'Abrasive Coating Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'Account And Promotion Clerk',
				'description' => 'Account And Promotion Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'Accountant',
				'description' => 'Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'Accountant W17 Junior Assistant',
				'description' => 'Accountant W17 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'Accountant W27 Assistant',
				'description' => 'Accountant W27 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'Accountant W41',
				'description' => 'Accountant W41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'Account Assistant Officer',
				'description' => 'Account Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'Account Clerk',
				'description' => 'Account Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'Accounting Machine Clerk',
				'description' => 'Accounting Machine Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'Accounting Payable Clerk',
				'description' => 'Accounting Payable Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 17,
				'name' => 'Accounting Receivable Clerk',
				'description' => 'Accounting Receivable Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 18,
				'name' => 'Account Manager',
				'description' => 'Account Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 19,
				'name' => 'Account Officer/Executive',
				'description' => 'Account Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 20,
				'name' => 'Account Supervisor',
				'description' => 'Account Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 21,
				'name' => 'Acetylene Plant Operator',
				'description' => 'Acetylene Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 22,
				'name' => 'Acid Plant Operator',
				'description' => 'Acid Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 23,
				'name' => 'Acoustical Insulator',
				'description' => 'Acoustical Insulator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 24,
				'name' => 'Acoustics Physicist',
				'description' => 'Acoustics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 25,
				'name' => 'Acrobat',
				'description' => 'Acrobat',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 26,
				'name' => 'Acting Sub Lieutenant',
				'description' => 'Acting Sub Lieutenant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 27,
				'name' => 'Actor',
				'description' => 'Actor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 28,
				'name' => 'Actuarial Assistant',
				'description' => 'Actuarial Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 29,
				'name' => 'Actuarial Clerk',
				'description' => 'Actuarial Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 30,
				'name' => 'Actuarial Science Mathematician',
				'description' => 'Actuarial Science Mathematician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 31,
				'name' => 'Actuary W41 Officer',
				'description' => 'Actuary W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 32,
				'name' => 'Acupuncturist',
				'description' => 'Acupuncturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 33,
				'name' => 'Addressing Machine Clerk',
				'description' => 'Addressing Machine Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 34,
				'name' => 'Adiguru - Ancient Malay Dance-Theatre',
				'description' => 'Adiguru - Ancient Malay Dance-Theatre',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 35,
				'name' => 'Adiguru - Shadow Puppet Theatre',
				'description' => 'Adiguru - Shadow Puppet Theatre',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 36,
				'name' => 'Adjustment Clerk',
				'description' => 'Adjustment Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 37,
				'name' => 'Administrative And Accounting Clerk',
				'description' => 'Administrative And Accounting Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 38,
				'name' => 'Administrative And Diplomatic M41 Officer',
				'description' => 'Administrative And Diplomatic M41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 39,
				'name' => 'Administrative Clerical/Operation N17 Assistant',
				'description' => 'Administrative Clerical/Operation N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 40,
				'name' => 'Administrative Clerk',
				'description' => 'Administrative Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 41,
				'name' => 'Administrative Executive',
				'description' => 'Administrative Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 42,
				'name' => 'Administrative FinanceW17 Assistant',
				'description' => 'Administrative FinanceW17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 43,
				'name' => 'Administrative Manager',
				'description' => 'Administrative Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 44,
				'name' => 'Administrative N27 Assistant Officer',
				'description' => 'Administrative N27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 45,
				'name' => 'Administrative N41 Officer',
				'description' => 'Administrative N41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 46,
			'name' => 'Administrative (Secretarial) Assistant',
			'description' => 'Administrative (Secretarial) Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 47,
				'name' => 'Administrative Secretary',
				'description' => 'Administrative Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 48,
				'name' => 'Administrative Secretary N17 Assistant',
				'description' => 'Administrative Secretary N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 49,
				'name' => 'Administrative Supervisor',
				'description' => 'Administrative Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 50,
				'name' => 'Administrator Assistant',
				'description' => 'Administrator Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 51,
				'name' => 'Admiral',
				'description' => 'Admiral',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 52,
				'name' => 'Admiral Of The Fleet',
				'description' => 'Admiral Of The Fleet',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 53,
				'name' => 'Admission Secretary',
				'description' => 'Admission Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 54,
				'name' => 'Adult Education Teacher',
				'description' => 'Adult Education Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 55,
				'name' => 'Advertising Clerk',
				'description' => 'Advertising Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 56,
				'name' => 'Advertising Copywriter',
				'description' => 'Advertising Copywriter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 57,
				'name' => 'Advertising Executive Account',
				'description' => 'Advertising Executive Account',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 58,
				'name' => 'Advertising Illustrator',
				'description' => 'Advertising Illustrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 59,
				'name' => 'Advertising Manager',
				'description' => 'Advertising Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 60,
				'name' => 'Advertising Model',
				'description' => 'Advertising Model',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 61,
				'name' => 'Advocate',
				'description' => 'Advocate',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 62,
				'name' => 'Advocate L41',
				'description' => 'Advocate L41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 63,
				'name' => 'Aerialist/Trapeze Performer',
				'description' => 'Aerialist/Trapeze Performer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 64,
				'name' => 'Aerial Photographer',
				'description' => 'Aerial Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 65,
				'name' => 'Aerial Surveyor',
				'description' => 'Aerial Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 66,
				'name' => 'Aerodynamicist',
				'description' => 'Aerodynamicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 67,
			'name' => 'Aeronautical)',
			'description' => 'Aeronautical)',
			'created_at' => $now,
			'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 68,
				'name' => 'Aeronautical Engineer',
				'description' => 'Aeronautical Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 69,
			'name' => 'Aeronautical (Mechanical) And Equipment Engineering Assistant',
			'description' => 'Aeronautical (Mechanical) And Equipment Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 70,
			'name' => 'Aerospace (Telecommunications) Engineer',
			'description' => 'Aerospace (Telecommunications) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 71,
				'name' => 'Aesthetician',
				'description' => 'Aesthetician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 72,
				'name' => 'After Sales Service Adviser',
				'description' => 'After Sales Service Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 73,
				'name' => 'Aged Care Services Manager',
				'description' => 'Aged Care Services Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 74,
				'name' => 'Agricultural Adviser',
				'description' => 'Agricultural Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 75,
				'name' => 'Agricultural Bacteriologist',
				'description' => 'Agricultural Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 76,
				'name' => 'Agricultural Engineer',
				'description' => 'Agricultural Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 77,
				'name' => 'Agricultural G17 Assistant',
				'description' => 'Agricultural G17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 78,
				'name' => 'Agricultural G27 Assistant Officer',
				'description' => 'Agricultural G27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 79,
				'name' => 'Agricultural G41 Officer',
				'description' => 'Agricultural G41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 80,
				'name' => 'Agricultural Machinery Assembler',
				'description' => 'Agricultural Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 81,
				'name' => 'Agricultural Manager',
				'description' => 'Agricultural Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 82,
				'name' => 'Agricultural Officer',
				'description' => 'Agricultural Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 83,
				'name' => 'Agricultural Scientist',
				'description' => 'Agricultural Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 84,
				'name' => 'Agricultural Statistician',
				'description' => 'Agricultural Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 85,
				'name' => 'Agrometeorologist',
				'description' => 'Agrometeorologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 86,
				'name' => 'Agronomist',
				'description' => 'Agronomist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 87,
				'name' => 'Agronomy Technician',
				'description' => 'Agronomy Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 88,
				'name' => 'Air-Bag Builder',
				'description' => 'Air-Bag Builder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 89,
				'name' => 'Air Cargo Officer',
				'description' => 'Air Cargo Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 90,
				'name' => 'Air-Conditioning And Refrigeration Engineer, Heating, Ventilation',
				'description' => 'Air-Conditioning And Refrigeration Engineer, Heating, Ventilation',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 91,
				'name' => 'Aircraft A29 Technical Assistant',
				'description' => 'Aircraft A29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 92,
				'name' => 'Aircraft A41 Inspector',
				'description' => 'Aircraft A41 Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 93,
				'name' => 'Aircraft/Airline Pilot',
				'description' => 'Aircraft/Airline Pilot',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 94,
				'name' => 'Aircraft Assembler',
				'description' => 'Aircraft Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 95,
				'name' => 'Aircraft Cleaner',
				'description' => 'Aircraft Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 96,
				'name' => 'Aircraft Designer',
				'description' => 'Aircraft Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 97,
				'name' => 'Aircraft Electrician',
				'description' => 'Aircraft Electrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 98,
				'name' => 'Aircraft Engineer',
				'description' => 'Aircraft Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 99,
				'name' => 'Aircraft Engine Mechanic',
				'description' => 'Aircraft Engine Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 100,
				'name' => 'Aircraft Joiner',
				'description' => 'Aircraft Joiner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 101,
				'name' => 'Aircraft Loader',
				'description' => 'Aircraft Loader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 102,
				'name' => 'Aircraft Panel Beater',
				'description' => 'Aircraft Panel Beater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 103,
				'name' => 'Aircraft Rigger',
				'description' => 'Aircraft Rigger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 104,
				'name' => 'Aircraft Sheet Metal Worker',
				'description' => 'Aircraft Sheet Metal Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 105,
				'name' => 'Aircraft Upholsterer',
				'description' => 'Aircraft Upholsterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 106,
				'name' => 'Air Hostess',
				'description' => 'Air Hostess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 107,
				'name' => 'Airport Attendant',
				'description' => 'Airport Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 108,
				'name' => 'Airport Manager',
				'description' => 'Airport Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 109,
				'name' => 'Air Traffic A41 Controller',
				'description' => 'Air Traffic A41 Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 110,
				'name' => 'Air Traffic Control A17 Assistant',
				'description' => 'Air Traffic Control A17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 111,
				'name' => 'Air Traffic Control A29 Assistant Officer',
				'description' => 'Air Traffic Control A29 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 112,
				'name' => 'Air Traffic Controller',
				'description' => 'Air Traffic Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 113,
				'name' => 'Air Traffic Safety Technician',
				'description' => 'Air Traffic Safety Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 114,
				'name' => 'Air Transport Operations Clerk',
				'description' => 'Air Transport Operations Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 115,
				'name' => 'Alcohol Technologist',
				'description' => 'Alcohol Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 116,
				'name' => 'Ambassador',
				'description' => 'Ambassador',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 117,
				'name' => 'Ambulance Driver',
				'description' => 'Ambulance Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 118,
				'name' => 'Ambulance Worker',
				'description' => 'Ambulance Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 119,
				'name' => 'Ammuition Products Machine Operator',
				'description' => 'Ammuition Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 120,
				'name' => 'Amusement Park/Recreation Attendant',
				'description' => 'Amusement Park/Recreation Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 121,
				'name' => 'Anaesthetist',
				'description' => 'Anaesthetist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 122,
				'name' => 'Analyst Programmer',
				'description' => 'Analyst Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 123,
				'name' => 'Analytical Chemist',
				'description' => 'Analytical Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 124,
				'name' => 'Anatomist',
				'description' => 'Anatomist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 125,
				'name' => 'Anatomy Technician',
				'description' => 'Anatomy Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 126,
				'name' => 'Anchovy Peeler',
				'description' => 'Anchovy Peeler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 127,
				'name' => 'Animal Caretaker',
				'description' => 'Animal Caretaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 128,
				'name' => 'Animal Circus Performer',
				'description' => 'Animal Circus Performer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 129,
				'name' => 'Animal Cytologist',
				'description' => 'Animal Cytologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 130,
				'name' => 'Animal-Drawn Vehicle Or Machinery Driver',
				'description' => 'Animal-Drawn Vehicle Or Machinery Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 131,
				'name' => 'Animal Ecologist',
				'description' => 'Animal Ecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 132,
				'name' => 'Animal Geneticist',
				'description' => 'Animal Geneticist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 133,
				'name' => 'Animal Nutritionist',
				'description' => 'Animal Nutritionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 134,
				'name' => 'Animal Pathologist',
				'description' => 'Animal Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 135,
				'name' => 'Animal Physiologist',
				'description' => 'Animal Physiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 136,
				'name' => 'Animal/Recreation Warden Park',
				'description' => 'Animal/Recreation Warden Park',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 137,
				'name' => 'Animal Scientist',
				'description' => 'Animal Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 138,
				'name' => 'Animals Taxonomist',
				'description' => 'Animals Taxonomist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 139,
				'name' => 'Animal Train Driver',
				'description' => 'Animal Train Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 140,
				'name' => 'Animation/Computer Games/Multimedia Programmer',
				'description' => 'Animation/Computer Games/Multimedia Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 141,
				'name' => 'Animator',
				'description' => 'Animator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 142,
				'name' => 'Annealing/Glass Furnace-Operator',
				'description' => 'Annealing/Glass Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 143,
				'name' => 'Anthropologist',
				'description' => 'Anthropologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 144,
				'name' => 'Anthropologists And Related Professionals Other Sociologist',
				'description' => 'Anthropologists And Related Professionals Other Sociologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 145,
				'name' => 'Anti-Drug S17 Assistant',
				'description' => 'Anti-Drug S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 146,
				'name' => 'Anti-Drug S27 Assistant Officer',
				'description' => 'Anti-Drug S27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 147,
				'name' => 'Anti-Drug S41 Officer',
				'description' => 'Anti-Drug S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 148,
				'name' => 'Apiary Worker',
				'description' => 'Apiary Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 149,
				'name' => 'Applications Programmer',
				'description' => 'Applications Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 150,
				'name' => 'Applied Mathematics Mathematician',
				'description' => 'Applied Mathematics Mathematician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 151,
				'name' => 'Applied Statistics Statistician',
				'description' => 'Applied Statistics Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 152,
				'name' => 'Appointments Clerk',
				'description' => 'Appointments Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 153,
				'name' => 'Appraiser',
				'description' => 'Appraiser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 154,
				'name' => 'Appraiser W17 Assistant',
				'description' => 'Appraiser W17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 155,
				'name' => 'Appraiser W27 Assistant Officer',
				'description' => 'Appraiser W27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 156,
				'name' => 'Appraiser W41 Officer',
				'description' => 'Appraiser W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 157,
				'name' => 'Arboriculture Technician',
				'description' => 'Arboriculture Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 158,
				'name' => 'Arboriculturist',
				'description' => 'Arboriculturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 159,
				'name' => 'Archaeologist',
				'description' => 'Archaeologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 160,
				'name' => 'Architect J41',
				'description' => 'Architect J41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 161,
				'name' => 'Architectural Draughtsperson',
				'description' => 'Architectural Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 162,
				'name' => 'Architecture J17 Technician',
				'description' => 'Architecture J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 163,
				'name' => 'Architecture J29 Technical Assistant',
				'description' => 'Architecture J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 164,
				'name' => 'Archives S17 Assistant',
				'description' => 'Archives S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 165,
				'name' => 'Archives S27 Assistant Officer',
				'description' => 'Archives S27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 166,
				'name' => 'Archivist',
				'description' => 'Archivist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 167,
				'name' => 'Archivist S41 Officer',
				'description' => 'Archivist S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 168,
				'name' => 'Armature Production Machine Operator',
				'description' => 'Armature Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 169,
				'name' => 'Armorial Designer',
				'description' => 'Armorial Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 170,
				'name' => 'Army Captain',
				'description' => 'Army Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 171,
				'name' => 'Army Lieutenant',
				'description' => 'Army Lieutenant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 172,
				'name' => 'Art Gallery Curator',
				'description' => 'Art Gallery Curator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 173,
				'name' => 'Art Gallery Guide',
				'description' => 'Art Gallery Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 174,
				'name' => 'Artificial Breeding Laboratory Assistant, Research',
				'description' => 'Artificial Breeding Laboratory Assistant, Research',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 175,
				'name' => 'Artificial Breeding Technician',
				'description' => 'Artificial Breeding Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 176,
				'name' => 'Artificial Flower Maker',
				'description' => 'Artificial Flower Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 177,
				'name' => 'Artist',
				'description' => 'Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 178,
				'name' => 'Artistic Engraver-Etcher',
				'description' => 'Artistic Engraver-Etcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 179,
				'name' => 'Artist’S Model',
				'description' => 'Artist’S Model',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 180,
				'name' => 'Asbestos-Cement Product Machine Operator',
				'description' => 'Asbestos-Cement Product Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 181,
				'name' => 'Asbestos Machine Operator',
				'description' => 'Asbestos Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 182,
				'name' => 'Asphalt Roofer',
				'description' => 'Asphalt Roofer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 183,
				'name' => 'Assayer',
				'description' => 'Assayer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 184,
				'name' => 'Assayer Metallurgist',
				'description' => 'Assayer Metallurgist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 185,
				'name' => 'Assembling Labourer',
				'description' => 'Assembling Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 186,
				'name' => 'Assistant Cashier',
				'description' => 'Assistant Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 187,
				'name' => 'Assistant Computer Systems Analyst',
				'description' => 'Assistant Computer Systems Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 188,
				'name' => 'Assistant Miller',
				'description' => 'Assistant Miller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 189,
				'name' => 'Assistant Motor Vehicle Mechanics And Repairers',
				'description' => 'Assistant Motor Vehicle Mechanics And Repairers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 190,
				'name' => 'Assistant Workshop',
				'description' => 'Assistant Workshop',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 191,
				'name' => 'Associate Professional Monk',
				'description' => 'Associate Professional Monk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 192,
				'name' => 'Associate Professional Nun',
				'description' => 'Associate Professional Nun',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 193,
				'name' => 'Associate Professional Parole Officer',
				'description' => 'Associate Professional Parole Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 194,
				'name' => 'Associate Professional Probation Officer',
				'description' => 'Associate Professional Probation Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 195,
				'name' => 'Astrologer',
				'description' => 'Astrologer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 196,
				'name' => 'Astronaut',
				'description' => 'Astronaut',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 197,
				'name' => 'Astronomer',
				'description' => 'Astronomer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 198,
				'name' => 'Astronomer Physicist',
				'description' => 'Astronomer Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 199,
				'name' => 'Astronomy Technician',
				'description' => 'Astronomy Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 200,
				'name' => 'Astrophysicist',
				'description' => 'Astrophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 201,
				'name' => 'Athlete',
				'description' => 'Athlete',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 202,
				'name' => 'Attorney General',
				'description' => 'Attorney General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 203,
				'name' => 'Auction Clerk',
				'description' => 'Auction Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 204,
				'name' => 'Auctioneer',
				'description' => 'Auctioneer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 205,
				'name' => 'Audio And Video Equipment Engineer',
				'description' => 'Audio And Video Equipment Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 206,
				'name' => 'Audio And Video Equipment Technician',
				'description' => 'Audio And Video Equipment Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 207,
				'name' => 'Audiologists',
				'description' => 'Audiologists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 208,
				'name' => 'Audio Typist',
				'description' => 'Audio Typist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 209,
				'name' => 'Audio-Visual Aids Operator',
				'description' => 'Audio-Visual Aids Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 210,
				'name' => 'Audio-Visual And Other Teaching Aids Specialist',
				'description' => 'Audio-Visual And Other Teaching Aids Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 211,
				'name' => 'Audio-Visual Equipment Assembler',
				'description' => 'Audio-Visual Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 212,
				'name' => 'Audio-Visual Librarian',
				'description' => 'Audio-Visual Librarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 213,
				'name' => 'Audio-Visual N17 Technician',
				'description' => 'Audio-Visual N17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 214,
				'name' => 'Audio/Visual Operator',
				'description' => 'Audio/Visual Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 215,
				'name' => 'Audio-Visual Teaching Specialist',
				'description' => 'Audio-Visual Teaching Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 216,
				'name' => 'Audit And Risk Assessment Executive',
				'description' => 'Audit And Risk Assessment Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 217,
				'name' => 'Audit And Risk Assessment Manager',
				'description' => 'Audit And Risk Assessment Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 218,
				'name' => 'Audit Clerk',
				'description' => 'Audit Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 219,
				'name' => 'Audit Executive',
				'description' => 'Audit Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 220,
				'name' => 'Auditing Accountant',
				'description' => 'Auditing Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 221,
				'name' => 'Audit Manager',
				'description' => 'Audit Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 222,
				'name' => 'Auditor',
				'description' => 'Auditor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 223,
				'name' => 'Auditor Computer',
				'description' => 'Auditor Computer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 224,
				'name' => 'Auditor W17 Junior Assistant',
				'description' => 'Auditor W17 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 225,
				'name' => 'Auditor W27 Assistant',
				'description' => 'Auditor W27 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 226,
				'name' => 'Auditor W41',
				'description' => 'Auditor W41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 227,
				'name' => 'Author',
				'description' => 'Author',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 228,
				'name' => 'Auto-Clipper Operator',
				'description' => 'Auto-Clipper Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 229,
				'name' => 'Automation Engineer',
				'description' => 'Automation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 230,
				'name' => 'Automation/Robot Technician',
				'description' => 'Automation/Robot Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 231,
				'name' => 'Automobile Assembler',
				'description' => 'Automobile Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 232,
				'name' => 'Automobile Engineering Assistant',
				'description' => 'Automobile Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 233,
				'name' => 'Automobile Spray-Painter',
				'description' => 'Automobile Spray-Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 234,
				'name' => 'Auto Polish Operator',
				'description' => 'Auto Polish Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 235,
				'name' => 'Auto Rickshaw Driver',
				'description' => 'Auto Rickshaw Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 236,
				'name' => 'Auto Sanding Worker',
				'description' => 'Auto Sanding Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 237,
				'name' => 'Auxiliary Police',
				'description' => 'Auxiliary Police',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 238,
				'name' => 'Awning Installer',
				'description' => 'Awning Installer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 239,
				'name' => 'Baby Amah',
				'description' => 'Baby Amah',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 240,
				'name' => 'Baby Sitter',
				'description' => 'Baby Sitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 241,
				'name' => 'Backhoe Driver',
				'description' => 'Backhoe Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 242,
				'name' => 'Back Knife Fabricator',
				'description' => 'Back Knife Fabricator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 243,
				'name' => 'Bacteriologist',
				'description' => 'Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 244,
				'name' => 'Bacteriology Technician',
				'description' => 'Bacteriology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 245,
				'name' => 'Bailiff',
				'description' => 'Bailiff',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 246,
				'name' => 'Baker',
				'description' => 'Baker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 247,
				'name' => 'Balance Maker And Repairer',
				'description' => 'Balance Maker And Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 248,
				'name' => 'Baling Press Operator',
				'description' => 'Baling Press Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 249,
				'name' => 'Ballistician',
				'description' => 'Ballistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 250,
				'name' => 'Ballistics Physicist',
				'description' => 'Ballistics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 251,
				'name' => 'Banbury-Mixer/Rubber Operator',
				'description' => 'Banbury-Mixer/Rubber Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 252,
				'name' => 'Band Conductor',
				'description' => 'Band Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 253,
				'name' => 'Band Leader',
				'description' => 'Band Leader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 254,
				'name' => 'Bank Accounting Analyst',
				'description' => 'Bank Accounting Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 255,
				'name' => 'Bank Assistant',
				'description' => 'Bank Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 256,
				'name' => 'Bank Clerk',
				'description' => 'Bank Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 257,
				'name' => 'Banking Clerk, Clearing House',
				'description' => 'Banking Clerk, Clearing House',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 258,
				'name' => 'Bankruptcy Officer',
				'description' => 'Bankruptcy Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 259,
				'name' => 'Bank Teller',
				'description' => 'Bank Teller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 260,
				'name' => 'Banquet/Hotel & Lodging Supervisor',
				'description' => 'Banquet/Hotel & Lodging Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 261,
				'name' => 'Banquet Waiter',
				'description' => 'Banquet Waiter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 262,
			'name' => 'Bar And Snack-Bar) Manager (Cafe',
			'description' => 'Bar And Snack-Bar) Manager (Cafe',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 263,
				'name' => 'Barbed-Wire Machine Operator',
				'description' => 'Barbed-Wire Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 264,
				'name' => 'Barbeque Chef',
				'description' => 'Barbeque Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 265,
				'name' => 'Barbeque Helper',
				'description' => 'Barbeque Helper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 266,
				'name' => 'Barber',
				'description' => 'Barber',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 267,
			'name' => 'Barge And Boat) Deckhand (Ship',
			'description' => 'Barge And Boat) Deckhand (Ship',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 268,
				'name' => 'Barkeeper',
				'description' => 'Barkeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 269,
				'name' => 'Barometer Maker',
				'description' => 'Barometer Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 270,
				'name' => 'Barrister',
				'description' => 'Barrister',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 271,
				'name' => 'Barrister’S Assistant',
				'description' => 'Barrister’S Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 272,
				'name' => 'Bartender',
				'description' => 'Bartender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 273,
				'name' => 'Bartender Assistant',
				'description' => 'Bartender Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 274,
				'name' => 'Basket Maker',
				'description' => 'Basket Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 275,
				'name' => 'Batch Maker',
				'description' => 'Batch Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 276,
				'name' => 'Bath Attendant',
				'description' => 'Bath Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 277,
				'name' => 'Batin',
				'description' => 'Batin',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 278,
				'name' => 'Battery Assembler',
				'description' => 'Battery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 279,
				'name' => 'Bean Curd Production Machine Operator',
				'description' => 'Bean Curd Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 280,
				'name' => 'Bean-Sprout Farm Worker',
				'description' => 'Bean-Sprout Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 281,
				'name' => 'Beater Operator',
				'description' => 'Beater Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 282,
				'name' => 'Beautician',
				'description' => 'Beautician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 283,
				'name' => 'Beautician B11',
				'description' => 'Beautician B11',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 284,
				'name' => 'Bedding Maker',
				'description' => 'Bedding Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 285,
				'name' => 'Bee Keeping Farmer',
				'description' => 'Bee Keeping Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 286,
				'name' => 'Belacan Production Machine Operator',
				'description' => 'Belacan Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 287,
				'name' => 'Bell Driver',
				'description' => 'Bell Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 288,
				'name' => 'Bench Carpenter',
				'description' => 'Bench Carpenter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 289,
				'name' => 'Bending/Metal Machine Operator',
				'description' => 'Bending/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 290,
				'name' => 'Berthing Master',
				'description' => 'Berthing Master',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 291,
				'name' => 'Betting Counter Clerk',
				'description' => 'Betting Counter Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 292,
				'name' => 'Bibliographer',
				'description' => 'Bibliographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 293,
				'name' => 'Bicycle Assembler',
				'description' => 'Bicycle Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 294,
				'name' => 'Bicycle Repairer',
				'description' => 'Bicycle Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 295,
				'name' => 'Bilal',
				'description' => 'Bilal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 296,
				'name' => 'Billboard Erector',
				'description' => 'Billboard Erector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 297,
				'name' => 'Bill Collector',
				'description' => 'Bill Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 298,
				'name' => 'Billiard Instructor',
				'description' => 'Billiard Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 299,
				'name' => 'Billing Clerk',
				'description' => 'Billing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 300,
				'name' => 'Bill Poster',
				'description' => 'Bill Poster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 301,
				'name' => 'Biochemist',
				'description' => 'Biochemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 302,
				'name' => 'Biochemistry Technician',
				'description' => 'Biochemistry Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 303,
				'name' => 'Biographer',
				'description' => 'Biographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 304,
				'name' => 'Biological Chemist',
				'description' => 'Biological Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 305,
				'name' => 'Biological Statistician',
				'description' => 'Biological Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 306,
				'name' => 'Biological Technician',
				'description' => 'Biological Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 307,
				'name' => 'Biologist',
				'description' => 'Biologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 308,
				'name' => 'Biologist,Aquatic',
				'description' => 'Biologist,Aquatic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 309,
				'name' => 'Biometrician',
				'description' => 'Biometrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 310,
				'name' => 'Biophysicist',
				'description' => 'Biophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 311,
				'name' => 'Biophysics Technician',
				'description' => 'Biophysics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 312,
				'name' => 'Biotechnologist',
				'description' => 'Biotechnologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 313,
				'name' => 'Bird And Aquatic Parks Keeper In Zoological',
				'description' => 'Bird And Aquatic Parks Keeper In Zoological',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 314,
				'name' => 'Bird And Aquatic Parks Performer/Trainer In Zoological',
				'description' => 'Bird And Aquatic Parks Performer/Trainer In Zoological',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'id' => 315,
				'name' => 'Bird Farmer',
				'description' => 'Bird Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'id' => 316,
				'name' => 'Bird’S Nest Collector',
				'description' => 'Bird’S Nest Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'id' => 317,
				'name' => 'Blacksmith',
				'description' => 'Blacksmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'id' => 318,
				'name' => 'Blaster',
				'description' => 'Blaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'id' => 319,
				'name' => 'Bleacher/Chemical Operator',
				'description' => 'Bleacher/Chemical Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'id' => 320,
				'name' => 'Bleacher Operator',
				'description' => 'Bleacher Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'id' => 321,
				'name' => 'Bleaching/Textile Machine Operator',
				'description' => 'Bleaching/Textile Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'id' => 322,
			'name' => 'Blender (Petroleum Refining)',
			'description' => 'Blender (Petroleum Refining)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 => 
			array (
				'id' => 323,
				'name' => 'Block Printer',
				'description' => 'Block Printer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 => 
			array (
				'id' => 324,
				'name' => 'Blood-Bank Technician',
				'description' => 'Blood-Bank Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 => 
			array (
				'id' => 325,
				'name' => 'Blowing/Glass Machine Operator',
				'description' => 'Blowing/Glass Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 => 
			array (
				'id' => 326,
				'name' => 'Boarding-House Manager',
				'description' => 'Boarding-House Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 => 
			array (
				'id' => 327,
			'name' => 'Boat (Liquid And Gases) Loader',
			'description' => 'Boat (Liquid And Gases) Loader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 => 
			array (
				'id' => 328,
				'name' => 'Boatswain',
				'description' => 'Boatswain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 => 
			array (
				'id' => 329,
				'name' => 'Bodyguard',
				'description' => 'Bodyguard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 => 
			array (
				'id' => 330,
				'name' => 'Boiler And Pipe Insulator',
				'description' => 'Boiler And Pipe Insulator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 => 
			array (
				'id' => 331,
				'name' => 'Boilermaker',
				'description' => 'Boilermaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 => 
			array (
				'id' => 332,
				'name' => 'Boilerman',
				'description' => 'Boilerman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 => 
			array (
				'id' => 333,
				'name' => 'Boiler Plant/Steam Operator',
				'description' => 'Boiler Plant/Steam Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 => 
			array (
				'id' => 334,
				'name' => 'Boiler Production Machine Operator',
				'description' => 'Boiler Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 => 
			array (
				'id' => 335,
				'name' => 'Boiler/Ship Operator',
				'description' => 'Boiler/Ship Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 => 
			array (
				'id' => 336,
				'name' => 'Boilersmith',
				'description' => 'Boilersmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 => 
			array (
				'id' => 337,
				'name' => 'Boiler Ssistant Superintendent',
				'description' => 'Boiler Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 => 
			array (
				'id' => 338,
				'name' => 'Boiler Superintendent',
				'description' => 'Boiler Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'id' => 339,
				'name' => 'Boiler Supervisor',
				'description' => 'Boiler Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'id' => 340,
				'name' => 'Bond Clerk',
				'description' => 'Bond Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'id' => 341,
				'name' => 'Bookbinder',
				'description' => 'Bookbinder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'id' => 342,
				'name' => 'Bookbinding Machine Operator',
				'description' => 'Bookbinding Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'id' => 343,
				'name' => 'Book Editor',
				'description' => 'Book Editor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'id' => 344,
				'name' => 'Book Embosser',
				'description' => 'Book Embosser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'id' => 345,
				'name' => 'Book Finisher',
				'description' => 'Book Finisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'id' => 346,
				'name' => 'Book Illustrator',
				'description' => 'Book Illustrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'id' => 347,
				'name' => 'Booking Clerk',
				'description' => 'Booking Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'id' => 348,
				'name' => 'Booking-Office Cashier',
				'description' => 'Booking-Office Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'id' => 349,
				'name' => 'Bookkeeper',
				'description' => 'Bookkeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'id' => 350,
				'name' => 'Bookkeeping Clerk',
				'description' => 'Bookkeeping Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 => 
			array (
				'id' => 351,
				'name' => 'Bookkeeping Machine Clerk',
				'description' => 'Bookkeeping Machine Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 => 
			array (
				'id' => 352,
				'name' => 'Book-Loan Clerk',
				'description' => 'Book-Loan Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 => 
			array (
				'id' => 353,
				'name' => 'Bookmaker',
				'description' => 'Bookmaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 => 
			array (
				'id' => 354,
				'name' => 'Border Inspector',
				'description' => 'Border Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 => 
			array (
				'id' => 355,
				'name' => 'Borer',
				'description' => 'Borer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 => 
			array (
				'id' => 356,
				'name' => 'Boring And Drilling Machine Setter-Operator',
				'description' => 'Boring And Drilling Machine Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 => 
			array (
				'id' => 357,
				'name' => 'Botanical Technician',
				'description' => 'Botanical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 => 
			array (
				'id' => 358,
				'name' => 'Botanist',
				'description' => 'Botanist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 => 
			array (
				'id' => 359,
				'name' => 'Bottle Production Machine Operator',
				'description' => 'Bottle Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 => 
			array (
				'id' => 360,
				'name' => 'Bottling Machine Operator',
				'description' => 'Bottling Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 => 
			array (
				'id' => 361,
				'name' => 'Bowling-Alley Attendant',
				'description' => 'Bowling-Alley Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 => 
			array (
				'id' => 362,
				'name' => 'Box Office Cashier',
				'description' => 'Box Office Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'id' => 363,
				'name' => 'Braid Production Machine Operator',
				'description' => 'Braid Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'id' => 364,
				'name' => 'Braille Plate Maker',
				'description' => 'Braille Plate Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'id' => 365,
				'name' => 'Brazier',
				'description' => 'Brazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'id' => 366,
				'name' => 'Bread Baker',
				'description' => 'Bread Baker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'id' => 367,
				'name' => 'Bread Production Machine Operator',
				'description' => 'Bread Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'id' => 368,
				'name' => 'Brewer',
				'description' => 'Brewer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'id' => 369,
				'name' => 'Brewing/Spirits Machine Operator',
				'description' => 'Brewing/Spirits Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'id' => 370,
				'name' => 'Brewing Technologist',
				'description' => 'Brewing Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'id' => 371,
				'name' => 'Brick And Tile Kiln-Operator',
				'description' => 'Brick And Tile Kiln-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 => 
			array (
				'id' => 372,
				'name' => 'Brick And Tile Moulder/Presser',
				'description' => 'Brick And Tile Moulder/Presser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 => 
			array (
				'id' => 373,
				'name' => 'Brick-And-Tile Production Machine Operator',
				'description' => 'Brick-And-Tile Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 => 
			array (
				'id' => 374,
				'name' => 'Brickwork Worker',
				'description' => 'Brickwork Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 => 
			array (
				'id' => 375,
				'name' => 'Bridge Instructor',
				'description' => 'Bridge Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 => 
			array (
				'id' => 376,
				'name' => 'Brigadier General',
				'description' => 'Brigadier General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 => 
			array (
				'id' => 377,
				'name' => 'Broadcasting Equipment Operator',
				'description' => 'Broadcasting Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'id' => 378,
				'name' => 'Broadcasting Equipment/Radio And Television Operator',
				'description' => 'Broadcasting Equipment/Radio And Television Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'id' => 379,
				'name' => 'Broadcast Technician',
				'description' => 'Broadcast Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'id' => 380,
				'name' => 'Brokerage Clerk',
				'description' => 'Brokerage Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'id' => 381,
				'name' => 'Broker Assistant',
				'description' => 'Broker Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'id' => 382,
				'name' => 'Broom Maker',
				'description' => 'Broom Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'id' => 383,
				'name' => 'Brush Maker',
				'description' => 'Brush Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'id' => 384,
				'name' => 'Brush Makers And Related Workers Not Elsewhere Other Basketry Weavers',
				'description' => 'Brush Makers And Related Workers Not Elsewhere Other Basketry Weavers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'id' => 385,
				'name' => 'Bucket Labourer',
				'description' => 'Bucket Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'id' => 386,
				'name' => 'Budget Manager',
				'description' => 'Budget Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'id' => 387,
				'name' => 'Buffalo Farmer',
				'description' => 'Buffalo Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'id' => 388,
				'name' => 'Buffalo Watchman',
				'description' => 'Buffalo Watchman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'id' => 389,
				'name' => 'Buffing/Metal Machine Operator',
				'description' => 'Buffing/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'id' => 390,
				'name' => 'Builder',
				'description' => 'Builder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'id' => 391,
				'name' => 'Building Architect',
				'description' => 'Building Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'id' => 392,
				'name' => 'Building Assistant Surveyor',
				'description' => 'Building Assistant Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'id' => 393,
				'name' => 'Building Caretaker',
				'description' => 'Building Caretaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'id' => 394,
				'name' => 'Building Concierge',
				'description' => 'Building Concierge',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'id' => 395,
				'name' => 'Building Electrician',
				'description' => 'Building Electrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'id' => 396,
				'name' => 'Building Exteriors Cleaner',
				'description' => 'Building Exteriors Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'id' => 397,
				'name' => 'Building Exteriors Sandblaster',
				'description' => 'Building Exteriors Sandblaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'id' => 398,
				'name' => 'Building Glazier',
				'description' => 'Building Glazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'id' => 399,
				'name' => 'Building Inspector',
				'description' => 'Building Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'id' => 400,
				'name' => 'Building Insulator',
				'description' => 'Building Insulator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'id' => 401,
				'name' => 'Building J29 Technical Assistant Surveyor',
				'description' => 'Building J29 Technical Assistant Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'id' => 402,
				'name' => 'Building J41 Surveyor',
				'description' => 'Building J41 Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'id' => 403,
				'name' => 'Building Maintenance Worker',
				'description' => 'Building Maintenance Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'id' => 404,
				'name' => 'Building Materials Technologist',
				'description' => 'Building Materials Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 => 
			array (
				'id' => 405,
				'name' => 'Building Painter',
				'description' => 'Building Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 => 
			array (
				'id' => 406,
				'name' => 'Bulldozer Operator',
				'description' => 'Bulldozer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 => 
			array (
				'id' => 407,
				'name' => 'Bullock Cart Builder',
				'description' => 'Bullock Cart Builder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 => 
			array (
				'id' => 408,
				'name' => 'Bullock-Cart Driver',
				'description' => 'Bullock-Cart Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 => 
			array (
				'id' => 409,
				'name' => 'Bundling Controller',
				'description' => 'Bundling Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 => 
			array (
				'id' => 410,
				'name' => 'Burnishing/Metal Machine Operator',
				'description' => 'Burnishing/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 => 
			array (
				'id' => 411,
				'name' => 'Bus Conductor',
				'description' => 'Bus Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 => 
			array (
				'id' => 412,
				'name' => 'Bus Driver',
				'description' => 'Bus Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 => 
			array (
				'id' => 413,
				'name' => 'Business And Economics Statistician',
				'description' => 'Business And Economics Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 => 
			array (
				'id' => 414,
				'name' => 'Business Consultant',
				'description' => 'Business Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 => 
			array (
				'id' => 415,
				'name' => 'Business Development Executive',
				'description' => 'Business Development Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 => 
			array (
				'id' => 416,
				'name' => 'Business Efficiency Specialist',
				'description' => 'Business Efficiency Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 => 
			array (
				'id' => 417,
			'name' => 'Business (Information Technology) Analyst',
			'description' => 'Business (Information Technology) Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 => 
			array (
				'id' => 418,
				'name' => 'Business Services/Advertising Salesperson',
				'description' => 'Business Services/Advertising Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 => 
			array (
				'id' => 419,
				'name' => 'Business Services And Administration Managers Not Elsewhere Classified',
				'description' => 'Business Services And Administration Managers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 => 
			array (
				'id' => 420,
				'name' => 'Business Services/Development Manager',
				'description' => 'Business Services/Development Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
				'id' => 421,
			'name' => 'Business Services (Except Advertising) Representative',
			'description' => 'Business Services (Except Advertising) Representative',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'id' => 422,
				'name' => 'Business Services Information Scientist',
				'description' => 'Business Services Information Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 => 
			array (
				'id' => 423,
				'name' => 'Bus/Interior Cleaner',
				'description' => 'Bus/Interior Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 => 
			array (
				'id' => 424,
				'name' => 'Bus Services Inspector',
				'description' => 'Bus Services Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 => 
			array (
				'id' => 425,
				'name' => 'Bus Station Master',
				'description' => 'Bus Station Master',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 => 
			array (
				'id' => 426,
				'name' => 'Butcher',
				'description' => 'Butcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 => 
			array (
				'id' => 427,
				'name' => 'Butter Products Machine Operator',
				'description' => 'Butter Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 => 
			array (
				'id' => 428,
				'name' => 'Buyer',
				'description' => 'Buyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 => 
			array (
				'id' => 429,
				'name' => 'Cabinet/Wooden Maker',
				'description' => 'Cabinet/Wooden Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 => 
			array (
				'id' => 430,
				'name' => 'Cable Car Conductor',
				'description' => 'Cable Car Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 => 
			array (
				'id' => 431,
				'name' => 'Cable Car Operator',
				'description' => 'Cable Car Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'id' => 432,
				'name' => 'Cable/Electric Jointer',
				'description' => 'Cable/Electric Jointer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'id' => 433,
				'name' => 'Cable Production Machine Operator',
				'description' => 'Cable Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'id' => 434,
				'name' => 'Cadastral Surveyor',
				'description' => 'Cadastral Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'id' => 435,
				'name' => 'CAD/CAM Technician',
				'description' => 'CAD/CAM Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'id' => 436,
				'name' => 'Caddie-Golf/Master',
				'description' => 'Caddie-Golf/Master',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 => 
			array (
				'id' => 437,
				'name' => 'Cadet',
				'description' => 'Cadet',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 => 
			array (
				'id' => 438,
				'name' => 'Cafe Manager',
				'description' => 'Cafe Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 => 
			array (
				'id' => 439,
				'name' => 'Cafeteria Cashier',
				'description' => 'Cafeteria Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 => 
			array (
				'id' => 440,
				'name' => 'Calendar/Textiles Operator',
				'description' => 'Calendar/Textiles Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 => 
			array (
				'id' => 441,
				'name' => 'Calender/Rubber Machine Operator',
				'description' => 'Calender/Rubber Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 => 
			array (
				'id' => 442,
				'name' => 'Call Centre Clerk',
				'description' => 'Call Centre Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 => 
			array (
				'id' => 443,
				'name' => 'Camera/Motion Picture Operator',
				'description' => 'Camera/Motion Picture Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 => 
			array (
				'id' => 444,
				'name' => 'Camera N11 Ssistant Operator',
				'description' => 'Camera N11 Ssistant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 => 
			array (
				'id' => 445,
				'name' => 'Camera Offset/Platemaker N17 Operator',
				'description' => 'Camera Offset/Platemaker N17 Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 => 
			array (
				'id' => 446,
				'name' => 'Camera/Television Operator',
				'description' => 'Camera/Television Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 => 
			array (
				'id' => 447,
				'name' => 'Camping Site Manager',
				'description' => 'Camping Site Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 => 
			array (
				'id' => 448,
				'name' => 'Camp Supervisor',
				'description' => 'Camp Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 => 
			array (
				'id' => 449,
				'name' => 'Camp Warden',
				'description' => 'Camp Warden',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 => 
			array (
				'id' => 450,
				'name' => 'Candle Production Machine Operator',
				'description' => 'Candle Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 => 
			array (
				'id' => 451,
				'name' => 'Cane Collector',
				'description' => 'Cane Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 => 
			array (
				'id' => 452,
				'name' => 'Canning/Fish Machine Operator',
				'description' => 'Canning/Fish Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 => 
			array (
				'id' => 453,
			'name' => 'Canning (Food Canning And Preserving) Machine Operator',
			'description' => 'Canning (Food Canning And Preserving) Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 => 
			array (
				'id' => 454,
				'name' => 'Canning/Meat/Food Machine Operator',
				'description' => 'Canning/Meat/Food Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 => 
			array (
				'id' => 455,
				'name' => 'Canteen Manager',
				'description' => 'Canteen Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 => 
			array (
				'id' => 456,
				'name' => 'Canvasser',
				'description' => 'Canvasser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 => 
			array (
				'id' => 457,
				'name' => 'Capitan',
				'description' => 'Capitan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 => 
			array (
				'id' => 458,
				'name' => 'Cap Maker',
				'description' => 'Cap Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 => 
			array (
				'id' => 459,
				'name' => 'Capping Machine Operator',
				'description' => 'Capping Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 => 
			array (
				'id' => 460,
				'name' => 'Caravan Park Manager',
				'description' => 'Caravan Park Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 => 
			array (
				'id' => 461,
			'name' => 'Carbonation Man (Malt Liquor)',
			'description' => 'Carbonation Man (Malt Liquor)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 => 
			array (
				'id' => 462,
				'name' => 'Cardboard Press-Operator',
				'description' => 'Cardboard Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 => 
			array (
				'id' => 463,
				'name' => 'Cardboard Production Machine Operator',
				'description' => 'Cardboard Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 => 
			array (
				'id' => 464,
				'name' => 'Cardboard Products Machine Operator',
				'description' => 'Cardboard Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 => 
			array (
				'id' => 465,
				'name' => 'Car Detailer',
				'description' => 'Car Detailer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 => 
			array (
				'id' => 466,
				'name' => 'Cardiac Anaesthesia Anaesthetist',
				'description' => 'Cardiac Anaesthesia Anaesthetist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 => 
			array (
				'id' => 467,
				'name' => 'Cardiologist',
				'description' => 'Cardiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 => 
			array (
				'id' => 468,
				'name' => 'Cardiology Paediatrician',
				'description' => 'Cardiology Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 => 
			array (
				'id' => 469,
				'name' => 'Cardiology Physician',
				'description' => 'Cardiology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 => 
			array (
				'id' => 470,
				'name' => 'Cardiology Surgeon',
				'description' => 'Cardiology Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 => 
			array (
				'id' => 471,
				'name' => 'Cardiothoracic Surgeon',
				'description' => 'Cardiothoracic Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 => 
			array (
				'id' => 472,
				'name' => 'Car Driver',
				'description' => 'Car Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 => 
			array (
				'id' => 473,
				'name' => 'Career Adviser',
				'description' => 'Career Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 => 
			array (
				'id' => 474,
				'name' => 'Cargo Clerk',
				'description' => 'Cargo Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 => 
			array (
				'id' => 475,
				'name' => 'Cargo/Freight/Product Handler',
				'description' => 'Cargo/Freight/Product Handler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 => 
			array (
				'id' => 476,
				'name' => 'Car Jockey',
				'description' => 'Car Jockey',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 => 
			array (
				'id' => 477,
				'name' => 'Carpenter',
				'description' => 'Carpenter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 => 
			array (
				'id' => 478,
				'name' => 'Carpet Cleaner',
				'description' => 'Carpet Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 => 
			array (
				'id' => 479,
				'name' => 'Carpet Mender',
				'description' => 'Carpet Mender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 => 
			array (
				'id' => 480,
				'name' => 'Car Salesman',
				'description' => 'Car Salesman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 => 
			array (
				'id' => 481,
				'name' => 'Cartographer',
				'description' => 'Cartographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 => 
			array (
				'id' => 482,
				'name' => 'Cartographer J41',
				'description' => 'Cartographer J41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 => 
			array (
				'id' => 483,
				'name' => 'Cartographer Marine',
				'description' => 'Cartographer Marine',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 => 
			array (
				'id' => 484,
				'name' => 'Cartographical Draughtsperson',
				'description' => 'Cartographical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 => 
			array (
				'id' => 485,
				'name' => 'Carton And Paper Box Production Machine Operator',
				'description' => 'Carton And Paper Box Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 => 
			array (
				'id' => 486,
				'name' => 'Carton Operator',
				'description' => 'Carton Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 => 
			array (
				'id' => 487,
				'name' => 'Cartoonist',
				'description' => 'Cartoonist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'id' => 488,
				'name' => 'Carving/Wood Machine Operator',
				'description' => 'Carving/Wood Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'id' => 489,
				'name' => 'Case-Hardening/Metal Furnace-Operator',
				'description' => 'Case-Hardening/Metal Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'id' => 490,
				'name' => 'Case Work Social Welfare Worker',
				'description' => 'Case Work Social Welfare Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'id' => 491,
				'name' => 'Cash Counter Clerk',
				'description' => 'Cash Counter Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 => 
			array (
				'id' => 492,
				'name' => 'Cash Desk Cashier',
				'description' => 'Cash Desk Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 => 
			array (
				'id' => 493,
				'name' => 'Cashier',
				'description' => 'Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 => 
			array (
				'id' => 494,
				'name' => 'Casino Clerk',
				'description' => 'Casino Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 => 
			array (
				'id' => 495,
				'name' => 'Casino Manager',
				'description' => 'Casino Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 => 
			array (
				'id' => 496,
				'name' => 'Cast Concrete Products Machine Operator',
				'description' => 'Cast Concrete Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 => 
			array (
				'id' => 497,
			'name' => 'Casting/Centrifugal (Cylindrical Metal Product) Machine Operator',
			'description' => 'Casting/Centrifugal (Cylindrical Metal Product) Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 => 
			array (
				'id' => 498,
			'name' => 'Casting/Continuous Rod (Non-Ferrous Metal) Machine Operator',
			'description' => 'Casting/Continuous Rod (Non-Ferrous Metal) Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 => 
			array (
				'id' => 499,
				'name' => 'Casting Finisher',
				'description' => 'Casting Finisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 => 
			array (
				'id' => 500,
				'name' => 'Casting Metal Machine Operator',
				'description' => 'Casting Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));

		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 501,
				'name' => 'Casting/Pottery And Porcelain Machine Operator',
				'description' => 'Casting/Pottery And Porcelain Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 502,
				'name' => 'Cast Stone Machine Operator',
				'description' => 'Cast Stone Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 503,
				'name' => 'Cataloguer',
				'description' => 'Cataloguer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 504,
				'name' => 'Catering Manager',
				'description' => 'Catering Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 505,
				'name' => 'Cattle Breeder',
				'description' => 'Cattle Breeder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 506,
				'name' => 'Ceiling',
				'description' => 'Ceiling',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 507,
				'name' => 'Cellophane Bag Production Machine Operator',
				'description' => 'Cellophane Bag Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 508,
				'name' => 'Cement Finisher',
				'description' => 'Cement Finisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 509,
				'name' => 'Cement Furnaceman',
				'description' => 'Cement Furnaceman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 510,
				'name' => 'Cement Product Machine Operator',
				'description' => 'Cement Product Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 511,
				'name' => 'Cement Technologist',
				'description' => 'Cement Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 512,
				'name' => 'Ceramics Dipper',
				'description' => 'Ceramics Dipper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 513,
				'name' => 'Ceramics Painter',
				'description' => 'Ceramics Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 514,
				'name' => 'Ceramics Production Machine Operator',
				'description' => 'Ceramics Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 515,
				'name' => 'Ceramics Technologist',
				'description' => 'Ceramics Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 516,
				'name' => 'Cereal Production Machine Operator',
				'description' => 'Cereal Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 517,
				'name' => 'Chambermaid',
				'description' => 'Chambermaid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 518,
				'name' => 'Chancery Head',
				'description' => 'Chancery Head',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 519,
				'name' => 'Change-Booth Cashier',
				'description' => 'Change-Booth Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 520,
				'name' => 'Charcoal Burner',
				'description' => 'Charcoal Burner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 521,
				'name' => 'Charcoal Kiln-Operator',
				'description' => 'Charcoal Kiln-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 522,
				'name' => 'Charity Collector',
				'description' => 'Charity Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 523,
				'name' => 'Chartered Accountant',
				'description' => 'Chartered Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 524,
				'name' => 'Chaser',
				'description' => 'Chaser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 525,
				'name' => 'Chauffeur',
				'description' => 'Chauffeur',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 526,
				'name' => 'Check-Out/Self Service Store Cashier',
				'description' => 'Check-Out/Self Service Store Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 527,
				'name' => 'Chef Assistant',
				'description' => 'Chef Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 528,
				'name' => 'Chefs',
				'description' => 'Chefs',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 529,
				'name' => 'Chefs De Party',
				'description' => 'Chefs De Party',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 530,
				'name' => 'Chemical And Related Processes Kiln-Operator',
				'description' => 'Chemical And Related Processes Kiln-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 531,
				'name' => 'Chemical And Related Processes Roll-Mill Operator',
				'description' => 'Chemical And Related Processes Roll-Mill Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 532,
				'name' => 'Chemical Enameller',
				'description' => 'Chemical Enameller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 533,
				'name' => 'Chemical Engineer',
				'description' => 'Chemical Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 534,
				'name' => 'Chemical Engineering Assistant',
				'description' => 'Chemical Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 535,
				'name' => 'Chemical/Fertilizer Engineer',
				'description' => 'Chemical/Fertilizer Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 536,
				'name' => 'Chemical Foam Maker',
				'description' => 'Chemical Foam Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 537,
				'name' => 'Chemical/Food Engineer',
				'description' => 'Chemical/Food Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 538,
				'name' => 'Chemical/Paints And Varnish Engineer',
				'description' => 'Chemical/Paints And Varnish Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 539,
				'name' => 'Chemical/Petroleum And Gas Engineer',
				'description' => 'Chemical/Petroleum And Gas Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 540,
			'name' => 'Chemical (Petroleum) Engineering Assistant',
			'description' => 'Chemical (Petroleum) Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 541,
				'name' => 'Chemical/Pharmaceutical Products Engineer',
				'description' => 'Chemical/Pharmaceutical Products Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 542,
				'name' => 'Chemical Proceses Roaster',
				'description' => 'Chemical Proceses Roaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 543,
				'name' => 'Chemical Process Engineer',
				'description' => 'Chemical Process Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 544,
				'name' => 'Chemical Processes Cooker',
				'description' => 'Chemical Processes Cooker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 545,
				'name' => 'Chemical Process Technologist',
				'description' => 'Chemical Process Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 546,
				'name' => 'Chemist',
				'description' => 'Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 547,
				'name' => 'Chemistry Laboratory Assistant',
				'description' => 'Chemistry Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 548,
				'name' => 'Chemistry Technician',
				'description' => 'Chemistry Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 549,
				'name' => 'Chess Instructor',
				'description' => 'Chess Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 550,
				'name' => 'Chettier/Along',
				'description' => 'Chettier/Along',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 551,
				'name' => 'Chewing-Gum Maker',
				'description' => 'Chewing-Gum Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 552,
				'name' => 'Chicken Farmer',
				'description' => 'Chicken Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 553,
				'name' => 'Chief Chefs',
				'description' => 'Chief Chefs',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 554,
				'name' => 'Chief Cook',
				'description' => 'Chief Cook',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 555,
				'name' => 'Chief Executive Officer',
				'description' => 'Chief Executive Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 556,
				'name' => 'Chief Finance Officer',
				'description' => 'Chief Finance Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 557,
				'name' => 'Chief Hookman Supervisor',
				'description' => 'Chief Hookman Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 558,
				'name' => 'Chief Hostess',
				'description' => 'Chief Hostess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 559,
				'name' => 'Chief Minister',
				'description' => 'Chief Minister',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 560,
				'name' => 'Chief Operating Officer',
				'description' => 'Chief Operating Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 561,
				'name' => 'Chief Petty Officer',
				'description' => 'Chief Petty Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 562,
				'name' => 'Chief Secretary',
				'description' => 'Chief Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 563,
				'name' => 'Chief/Ship Engineer',
				'description' => 'Chief/Ship Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 564,
				'name' => 'Chief Steward Assistant',
				'description' => 'Chief Steward Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 565,
				'name' => 'Child Care Centre Manager',
				'description' => 'Child Care Centre Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 566,
				'name' => 'Child Care Worker',
				'description' => 'Child Care Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 567,
				'name' => 'Children’S Librarian',
				'description' => 'Children’S Librarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 568,
				'name' => 'Child Welfare Social Worker',
				'description' => 'Child Welfare Social Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 569,
				'name' => 'Chinese Traditional Medicine Dispenser',
				'description' => 'Chinese Traditional Medicine Dispenser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 570,
				'name' => 'Chinese Traditional Medicine Physician',
				'description' => 'Chinese Traditional Medicine Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 571,
				'name' => 'Chipping Machine Operator',
				'description' => 'Chipping Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 572,
				'name' => 'Chiropodist',
				'description' => 'Chiropodist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 573,
				'name' => 'Chiropractor',
				'description' => 'Chiropractor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 574,
				'name' => 'Chlorine Gas Production Machine Operator',
				'description' => 'Chlorine Gas Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 575,
				'name' => 'Chlorine Plant Operator',
				'description' => 'Chlorine Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 576,
				'name' => 'Chocolate Maker',
				'description' => 'Chocolate Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 577,
				'name' => 'Chocolate Production Machine Operator',
				'description' => 'Chocolate Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 578,
				'name' => 'Choreographer',
				'description' => 'Choreographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 579,
				'name' => 'Chronometer Assembler',
				'description' => 'Chronometer Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 580,
				'name' => 'Church Priest',
				'description' => 'Church Priest',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 581,
				'name' => 'Churn/Dairy Products Attendant',
				'description' => 'Churn/Dairy Products Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 582,
				'name' => 'Churn/Dairy Products Machine Operator',
				'description' => 'Churn/Dairy Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 583,
				'name' => 'Cigarette Maker',
				'description' => 'Cigarette Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 584,
				'name' => 'Cigarette Production Machine Operator',
				'description' => 'Cigarette Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 585,
				'name' => 'Cigarette Quality Checker',
				'description' => 'Cigarette Quality Checker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 586,
				'name' => 'Cigar Maker',
				'description' => 'Cigar Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 587,
				'name' => 'Cigar Production Machine Operator',
				'description' => 'Cigar Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 588,
				'name' => 'Cinema Projectionist',
				'description' => 'Cinema Projectionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 589,
				'name' => 'Cinematographer',
				'description' => 'Cinematographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 590,
				'name' => 'Civil/Aerodome Construction Engineer',
				'description' => 'Civil/Aerodome Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 591,
				'name' => 'Civil/Bridge Construction Engineer',
				'description' => 'Civil/Bridge Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 592,
				'name' => 'Civil/Building Construction Engineer',
				'description' => 'Civil/Building Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 593,
				'name' => 'Civil/Building Structure Engineer',
				'description' => 'Civil/Building Structure Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 594,
				'name' => 'Civil/Chimney Construction Engineer',
				'description' => 'Civil/Chimney Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 595,
				'name' => 'Civil/Construction Engineer',
				'description' => 'Civil/Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 596,
				'name' => 'Civil Defence KP17 Assistant',
				'description' => 'Civil Defence KP17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 597,
				'name' => 'Civil Defence KP27 Ssistant Officer',
				'description' => 'Civil Defence KP27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 598,
				'name' => 'Civil Defence KP41 Officer',
				'description' => 'Civil Defence KP41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 599,
				'name' => 'Civil Defence Officer',
				'description' => 'Civil Defence Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 600,
				'name' => 'Civil/Dock And Harbour Construction Engineer',
				'description' => 'Civil/Dock And Harbour Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 601,
				'name' => 'Civil/Dredging Engineer',
				'description' => 'Civil/Dredging Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 602,
				'name' => 'Civil Engineer',
				'description' => 'Civil Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 603,
				'name' => 'Civil Engineering Assistant',
				'description' => 'Civil Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 604,
				'name' => 'Civil/Geothechnic Engineer',
				'description' => 'Civil/Geothechnic Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 605,
				'name' => 'Civil/Highway And Street Construction Engineer',
				'description' => 'Civil/Highway And Street Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 606,
				'name' => 'Civil/Highways And Road Engineer',
				'description' => 'Civil/Highways And Road Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 607,
				'name' => 'Civil/Hydraulics Engineer',
				'description' => 'Civil/Hydraulics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 608,
				'name' => 'Civil/Hydrology Engineer',
				'description' => 'Civil/Hydrology Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 609,
				'name' => 'Civilian Relation KP19 Officer',
				'description' => 'Civilian Relation KP19 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 610,
				'name' => 'Civil/Irrigation Engineer',
				'description' => 'Civil/Irrigation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 611,
				'name' => 'Civil J29 Technical Assistant',
				'description' => 'Civil J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 612,
				'name' => 'Civil J41 Engineer',
				'description' => 'Civil J41 Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 613,
				'name' => 'Civil Lawyer',
				'description' => 'Civil Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 614,
				'name' => 'Civil/Public Health Engineer',
				'description' => 'Civil/Public Health Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 615,
				'name' => 'Civil/Railway Construction Engineer',
				'description' => 'Civil/Railway Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 616,
				'name' => 'Civil/Road Construction Engineer',
				'description' => 'Civil/Road Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 617,
				'name' => 'Civil/Sanitary Engineer',
				'description' => 'Civil/Sanitary Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 618,
				'name' => 'Civil Service Commissioner',
				'description' => 'Civil Service Commissioner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 619,
				'name' => 'Civil Service Commission Officer',
				'description' => 'Civil Service Commission Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 620,
				'name' => 'Civil Service Inspector',
				'description' => 'Civil Service Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 621,
				'name' => 'Civil/Soil Mechanics Engineer',
				'description' => 'Civil/Soil Mechanics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 622,
				'name' => 'Civil/Structural Engineer',
				'description' => 'Civil/Structural Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 623,
				'name' => 'Civil/Tower Construction Engineer',
				'description' => 'Civil/Tower Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 624,
				'name' => 'Civil/Tunnel Construction Engineer',
				'description' => 'Civil/Tunnel Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 625,
				'name' => 'Claim Clerk',
				'description' => 'Claim Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 626,
				'name' => 'Claims Assessor',
				'description' => 'Claims Assessor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 627,
				'name' => 'Claims Executive',
				'description' => 'Claims Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 628,
				'name' => 'Claims Inspector',
				'description' => 'Claims Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 629,
				'name' => 'Classification Clerk',
				'description' => 'Classification Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 630,
				'name' => 'Classified',
				'description' => 'Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 631,
				'name' => 'Classified Advertising Clerk',
				'description' => 'Classified Advertising Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 632,
				'name' => 'Clay Mixer',
				'description' => 'Clay Mixer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 633,
				'name' => 'Cleaning Manager',
				'description' => 'Cleaning Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 634,
				'name' => 'Clearing And Forwarding Agent',
				'description' => 'Clearing And Forwarding Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 635,
				'name' => 'Clerical/Aircraft Dispatcher',
				'description' => 'Clerical/Aircraft Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 636,
				'name' => 'Clerical/Air Transport Service Controller',
				'description' => 'Clerical/Air Transport Service Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 637,
				'name' => 'Clerical/Boat Dispatcher',
				'description' => 'Clerical/Boat Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 638,
				'name' => 'Clerical/Bus Dispatcher',
				'description' => 'Clerical/Bus Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 639,
			'name' => 'Clerical/Director) Clerk, Compilation/Directory (Compiler',
			'description' => 'Clerical/Director) Clerk, Compilation/Directory (Compiler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 640,
				'name' => 'Clerical/Gas Pipeline Dispatcher',
				'description' => 'Clerical/Gas Pipeline Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 641,
				'name' => 'Clerical/Mail Controller',
				'description' => 'Clerical/Mail Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 642,
				'name' => 'Clerical/Mail Depot Controller',
				'description' => 'Clerical/Mail Depot Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 643,
				'name' => 'Clerical/Oil Pipelinge Dispatcher',
				'description' => 'Clerical/Oil Pipelinge Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 644,
				'name' => 'Clerical/Postal Service Controller',
				'description' => 'Clerical/Postal Service Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 645,
				'name' => 'Clerical Proof-Reader',
				'description' => 'Clerical Proof-Reader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 646,
				'name' => 'Clerical/Railway Dispatcher',
				'description' => 'Clerical/Railway Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 647,
				'name' => 'Clerical/Railway Service Controller',
				'description' => 'Clerical/Railway Service Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 648,
			'name' => 'Clerical/Road Transport (Except Bus And Truck) Dispatcher',
			'description' => 'Clerical/Road Transport (Except Bus And Truck) Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 649,
				'name' => 'Clerical/Road Transport Services Controller',
				'description' => 'Clerical/Road Transport Services Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 650,
				'name' => 'Clerical/Road Transport Services Inspector',
				'description' => 'Clerical/Road Transport Services Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 651,
				'name' => 'Clerical Supervisor',
				'description' => 'Clerical Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 652,
				'name' => 'Clerical/Train Controller',
				'description' => 'Clerical/Train Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 653,
				'name' => 'Clerical/Train Dispatcher',
				'description' => 'Clerical/Train Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 654,
				'name' => 'Clerical/Truck Dispatcher',
				'description' => 'Clerical/Truck Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 655,
				'name' => 'Clerk',
				'description' => 'Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 656,
				'name' => 'Clerk Chief',
				'description' => 'Clerk Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 657,
				'name' => 'Clerk-Of-Work',
				'description' => 'Clerk-Of-Work',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 658,
				'name' => 'Clerk/Sea Transport Services Controller',
				'description' => 'Clerk/Sea Transport Services Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 659,
				'name' => 'Climatologist',
				'description' => 'Climatologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 660,
				'name' => 'Clinical Biochemist',
				'description' => 'Clinical Biochemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 661,
				'name' => 'Clinical Instructor',
				'description' => 'Clinical Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 662,
				'name' => 'Clinical Pathologist',
				'description' => 'Clinical Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 663,
				'name' => 'Clinic Assistant',
				'description' => 'Clinic Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 664,
				'name' => 'Cloakroom Attendant',
				'description' => 'Cloakroom Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 665,
				'name' => 'Clock Assembler',
				'description' => 'Clock Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 666,
				'name' => 'Clock Production Machine Operator',
				'description' => 'Clock Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 667,
				'name' => 'Clog Maker',
				'description' => 'Clog Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 668,
				'name' => 'Cloth Designer',
				'description' => 'Cloth Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 669,
				'name' => 'Clown',
				'description' => 'Clown',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 670,
				'name' => 'Club Host',
				'description' => 'Club Host',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 671,
				'name' => 'Club Hostess',
				'description' => 'Club Hostess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 672,
				'name' => 'Clubhouse Supervisor',
				'description' => 'Clubhouse Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 673,
				'name' => 'Club Manager',
				'description' => 'Club Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 674,
				'name' => 'Coastal Fishery Worker',
				'description' => 'Coastal Fishery Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 675,
				'name' => 'Coastguard',
				'description' => 'Coastguard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 676,
				'name' => 'Coastguard A17',
				'description' => 'Coastguard A17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 677,
				'name' => 'Coating Machine Operator',
				'description' => 'Coating Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 678,
				'name' => 'Cobbler',
				'description' => 'Cobbler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 679,
				'name' => 'Cocoa-Bean Processing Machine Operator',
				'description' => 'Cocoa-Bean Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 680,
				'name' => 'Cocoa Farm Worker',
				'description' => 'Cocoa Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 681,
				'name' => 'Coconut Farm Worker',
				'description' => 'Coconut Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 682,
				'name' => 'Coconut Planter',
				'description' => 'Coconut Planter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 683,
			'name' => 'Coding (Data-Processing) Clerk',
			'description' => 'Coding (Data-Processing) Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 684,
				'name' => 'Coding/Statistics Clerk',
				'description' => 'Coding/Statistics Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 685,
				'name' => 'Coffee-Bean Processing Machine Operator',
				'description' => 'Coffee-Bean Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 686,
				'name' => 'Coffee Farm Worker',
				'description' => 'Coffee Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 687,
				'name' => 'Coffee Grader/Taster',
				'description' => 'Coffee Grader/Taster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 688,
				'name' => 'Coffin Maker',
				'description' => 'Coffin Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 689,
				'name' => 'Coil/Hand Winder',
				'description' => 'Coil/Hand Winder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 690,
				'name' => 'Coke Production Machine Operator',
				'description' => 'Coke Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 691,
				'name' => 'Collateral Clerk',
				'description' => 'Collateral Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 692,
				'name' => 'College Faculty Head',
				'description' => 'College Faculty Head',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 693,
				'name' => 'College Lecturer',
				'description' => 'College Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 694,
				'name' => 'College Or University Registrar',
				'description' => 'College Or University Registrar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 695,
				'name' => 'College Principal',
				'description' => 'College Principal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 696,
				'name' => 'Colonel',
				'description' => 'Colonel',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 697,
				'name' => 'Columnist',
				'description' => 'Columnist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 698,
				'name' => 'Comedy Writer',
				'description' => 'Comedy Writer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 699,
				'name' => 'Commander',
				'description' => 'Commander',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 700,
				'name' => 'Commercial Artist',
				'description' => 'Commercial Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 701,
				'name' => 'Commercial Illustration Photographer',
				'description' => 'Commercial Illustration Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 702,
				'name' => 'Commercial Products Designer',
				'description' => 'Commercial Products Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 703,
				'name' => 'Commercial Teacher',
				'description' => 'Commercial Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 704,
				'name' => 'Commis',
				'description' => 'Commis',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 705,
				'name' => 'Commissioner For Oaths',
				'description' => 'Commissioner For Oaths',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 706,
				'name' => 'Committee Executive Secretary',
				'description' => 'Committee Executive Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 707,
				'name' => 'Commodity Broker',
				'description' => 'Commodity Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 708,
				'name' => 'Communication/Except Computer Analyst',
				'description' => 'Communication/Except Computer Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 709,
				'name' => 'Communication Programmer',
				'description' => 'Communication Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 710,
				'name' => 'Communications Assistant',
				'description' => 'Communications Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 711,
				'name' => 'Communications/Computer Analyst',
				'description' => 'Communications/Computer Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 712,
				'name' => 'Communications Manager',
				'description' => 'Communications Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 713,
				'name' => 'Community Development Supervisor',
				'description' => 'Community Development Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 714,
				'name' => 'Community Social Worker',
				'description' => 'Community Social Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 715,
				'name' => 'Community U19 Nurse',
				'description' => 'Community U19 Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 716,
				'name' => 'Commutator Production Machine Operator',
				'description' => 'Commutator Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 717,
				'name' => 'Commuter Operator',
				'description' => 'Commuter Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 718,
				'name' => 'Companion',
				'description' => 'Companion',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 719,
				'name' => 'Company Accountant',
				'description' => 'Company Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 720,
				'name' => 'Company Director',
				'description' => 'Company Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 721,
				'name' => 'Company Secretary',
				'description' => 'Company Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 722,
				'name' => 'Compeer',
				'description' => 'Compeer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 723,
				'name' => 'Composite Products Assembler',
				'description' => 'Composite Products Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 724,
				'name' => 'Composition Roofer',
				'description' => 'Composition Roofer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 725,
				'name' => 'Compositor',
				'description' => 'Compositor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 726,
				'name' => 'Compounding Supervisor',
				'description' => 'Compounding Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 727,
				'name' => 'Compression Moulding/Plastics Machine Operator',
				'description' => 'Compression Moulding/Plastics Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 728,
				'name' => 'Compressor/Gas Operator',
				'description' => 'Compressor/Gas Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 729,
				'name' => 'Compressor Operator',
				'description' => 'Compressor Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 730,
				'name' => 'Computer Applications Engineer',
				'description' => 'Computer Applications Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 731,
				'name' => 'Computer Assistant',
				'description' => 'Computer Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 732,
				'name' => 'Computer Consultant',
				'description' => 'Computer Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 733,
				'name' => 'Computer Database Assistant',
				'description' => 'Computer Database Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 734,
				'name' => 'Computer Engineer',
				'description' => 'Computer Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 735,
				'name' => 'Computer Engineering Assistant',
				'description' => 'Computer Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 736,
				'name' => 'Computer Engineering Assistant',
				'description' => 'Computer Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 737,
				'name' => 'Computer FT17 Technician',
				'description' => 'Computer FT17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 738,
				'name' => 'Computer Hardware Engineer',
				'description' => 'Computer Hardware Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 739,
				'name' => 'Computer Help Desk Operator',
				'description' => 'Computer Help Desk Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 740,
				'name' => 'Computer Network Technician',
				'description' => 'Computer Network Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 741,
				'name' => 'Computer Operator',
				'description' => 'Computer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 742,
				'name' => 'Computer Peripheral Equipment/Console Operator',
				'description' => 'Computer Peripheral Equipment/Console Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 743,
				'name' => 'Computer Peripheral Equipment/High-Speed Printer Operator',
				'description' => 'Computer Peripheral Equipment/High-Speed Printer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 744,
				'name' => 'Computer Peripheral Equipment Operator',
				'description' => 'Computer Peripheral Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 745,
				'name' => 'Computer Programmer',
				'description' => 'Computer Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 746,
				'name' => 'Computer Programming Assistant',
				'description' => 'Computer Programming Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 747,
				'name' => 'Computer Services Manager',
				'description' => 'Computer Services Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 748,
				'name' => 'Computer Software Engineer',
				'description' => 'Computer Software Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 749,
				'name' => 'Computer Systems Administrator',
				'description' => 'Computer Systems Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 750,
				'name' => 'Computer/Systems Analyst Assistant',
				'description' => 'Computer/Systems Analyst Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 751,
				'name' => 'Computer Systems Engineer',
				'description' => 'Computer Systems Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 752,
				'name' => 'Computer Technician',
				'description' => 'Computer Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 753,
				'name' => 'Computer/Users’ Services Assistant',
				'description' => 'Computer/Users’ Services Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 754,
				'name' => 'Computer/Visualizer Artist',
				'description' => 'Computer/Visualizer Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 755,
				'name' => 'Concierge',
				'description' => 'Concierge',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 756,
				'name' => 'Concierge Chief',
				'description' => 'Concierge Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 757,
				'name' => 'Concrete Finishers And Related Workers Other Concrete Placers',
				'description' => 'Concrete Finishers And Related Workers Other Concrete Placers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 758,
				'name' => 'Concrete Mixer',
				'description' => 'Concrete Mixer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 759,
				'name' => 'Concrete Mixing Machine Operator',
				'description' => 'Concrete Mixing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 760,
				'name' => 'Concrete Moulding Shutterer',
				'description' => 'Concrete Moulding Shutterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 761,
				'name' => 'Concrete Shutterer',
				'description' => 'Concrete Shutterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 762,
				'name' => 'Confectionary Maker',
				'description' => 'Confectionary Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 763,
				'name' => 'Confectionery Production Machine Operator',
				'description' => 'Confectionery Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 764,
				'name' => 'Confidential Clerk',
				'description' => 'Confidential Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 765,
				'name' => 'Confidential Secretary',
				'description' => 'Confidential Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 766,
				'name' => 'Conservation S17 Assistant',
				'description' => 'Conservation S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 767,
				'name' => 'Console Operator',
				'description' => 'Console Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 768,
				'name' => 'Constructional Steel Erector',
				'description' => 'Constructional Steel Erector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 769,
				'name' => 'Construction Bricklayers',
				'description' => 'Construction Bricklayers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 770,
				'name' => 'Construction Carpenter',
				'description' => 'Construction Carpenter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 771,
				'name' => 'Construction Joiner',
				'description' => 'Construction Joiner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 772,
				'name' => 'Construction Labourer',
				'description' => 'Construction Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 773,
				'name' => 'Construction Manager',
				'description' => 'Construction Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 774,
				'name' => 'Construction Stonemason',
				'description' => 'Construction Stonemason',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 775,
				'name' => 'Construction Supervisor',
				'description' => 'Construction Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 776,
				'name' => 'Consul',
				'description' => 'Consul',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 777,
				'name' => 'Consular Official',
				'description' => 'Consular Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 778,
				'name' => 'Consul-General',
				'description' => 'Consul-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 779,
				'name' => 'Contact Centre Manager',
				'description' => 'Contact Centre Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 780,
				'name' => 'Contact-Lens Dispensing Optician',
				'description' => 'Contact-Lens Dispensing Optician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 781,
				'name' => 'Contortionist',
				'description' => 'Contortionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 782,
				'name' => 'Contract Executive',
				'description' => 'Contract Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 783,
				'name' => 'Contract Manager',
				'description' => 'Contract Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 784,
				'name' => 'Control/Food And Beverage Clerk',
				'description' => 'Control/Food And Beverage Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 785,
			'name' => 'Controlman (Petroleum Refining)',
			'description' => 'Controlman (Petroleum Refining)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 786,
				'name' => 'Converting/Steel Furnace-Operator',
				'description' => 'Converting/Steel Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 787,
				'name' => 'Conveyance Clerk',
				'description' => 'Conveyance Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 788,
				'name' => 'Conveyancing Lawyer',
				'description' => 'Conveyancing Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 789,
				'name' => 'Cook Assistant',
				'description' => 'Cook Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 790,
				'name' => 'Cooking Equipment/Chemical And Related Processes Operator',
				'description' => 'Cooking Equipment/Chemical And Related Processes Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 791,
				'name' => 'Cook N1',
				'description' => 'Cook N1',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 792,
				'name' => 'Coordinator Foreman',
				'description' => 'Coordinator Foreman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 793,
				'name' => 'Coordinator Steward',
				'description' => 'Coordinator Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 794,
				'name' => 'Coppersmith',
				'description' => 'Coppersmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 795,
			'name' => 'Core Analyst (Petroleum And Natural Gas)',
			'description' => 'Core Analyst (Petroleum And Natural Gas)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 796,
				'name' => 'Core-Blowing Machine Operator',
				'description' => 'Core-Blowing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 797,
				'name' => 'Coremaking/Metal Machine Operator',
				'description' => 'Coremaking/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 798,
				'name' => 'Coroner',
				'description' => 'Coroner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 799,
				'name' => 'Corporal',
				'description' => 'Corporal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 800,
				'name' => 'Corporate Affairs Executive',
				'description' => 'Corporate Affairs Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 801,
				'name' => 'Corporate Communication Executive',
				'description' => 'Corporate Communication Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 802,
				'name' => 'Corporate Financial',
				'description' => 'Corporate Financial',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 803,
				'name' => 'Correspondence Assistant',
				'description' => 'Correspondence Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 804,
				'name' => 'Correspondence Clerk',
				'description' => 'Correspondence Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 805,
				'name' => 'Correspondence Teacher',
				'description' => 'Correspondence Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 806,
				'name' => 'Corrosion Chemist',
				'description' => 'Corrosion Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 807,
				'name' => 'Cosmologist',
				'description' => 'Cosmologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 808,
				'name' => 'Cost Accountant',
				'description' => 'Cost Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 809,
				'name' => 'Cost Clerk',
				'description' => 'Cost Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 810,
				'name' => 'Cost Computing Clerk',
				'description' => 'Cost Computing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 811,
				'name' => 'Cost Controller',
				'description' => 'Cost Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 812,
				'name' => 'Cost Evaluation Engineer',
				'description' => 'Cost Evaluation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 813,
				'name' => 'Costing Assistant',
				'description' => 'Costing Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 814,
				'name' => 'Costing Manager',
				'description' => 'Costing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'id' => 815,
				'name' => 'Costing Officer/Executive',
				'description' => 'Costing Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'id' => 816,
				'name' => 'Cotton-Mixing Machine Operator',
				'description' => 'Cotton-Mixing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'id' => 817,
				'name' => 'Counselor',
				'description' => 'Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'id' => 818,
				'name' => 'Counselor Assistant',
				'description' => 'Counselor Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'id' => 819,
				'name' => 'Counter Enquiries Clerk',
				'description' => 'Counter Enquiries Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'id' => 820,
				'name' => 'Counter Sales/Promoter Assistant',
				'description' => 'Counter Sales/Promoter Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'id' => 821,
				'name' => 'Court Clerk',
				'description' => 'Court Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'id' => 822,
				'name' => 'Court Receiver And Liquidator',
				'description' => 'Court Receiver And Liquidator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 => 
			array (
				'id' => 823,
			'name' => 'Coverter/Chemical Processes (Except Petroleum And Natural Gas) Operator',
			'description' => 'Coverter/Chemical Processes (Except Petroleum And Natural Gas) Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 => 
			array (
				'id' => 824,
				'name' => 'Craft E11 Instructor',
				'description' => 'Craft E11 Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 => 
			array (
				'id' => 825,
				'name' => 'Crane Attendant',
				'description' => 'Crane Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 => 
			array (
				'id' => 826,
				'name' => 'Crane Operator',
				'description' => 'Crane Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 => 
			array (
				'id' => 827,
				'name' => 'Crankshaft Grinder',
				'description' => 'Crankshaft Grinder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 => 
			array (
				'id' => 828,
				'name' => 'Creative And Performing Artists Not Elsewhere Classified',
				'description' => 'Creative And Performing Artists Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 => 
			array (
				'id' => 829,
				'name' => 'Credit Clerk',
				'description' => 'Credit Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 => 
			array (
				'id' => 830,
				'name' => 'Credit Control Assistant',
				'description' => 'Credit Control Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 => 
			array (
				'id' => 831,
				'name' => 'Credit Control Clerk',
				'description' => 'Credit Control Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 => 
			array (
				'id' => 832,
				'name' => 'Credit Control Officer/Executive',
				'description' => 'Credit Control Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 => 
			array (
				'id' => 833,
				'name' => 'Credit Manager',
				'description' => 'Credit Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 => 
			array (
				'id' => 834,
				'name' => 'Credit Supervisor',
				'description' => 'Credit Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 => 
			array (
				'id' => 835,
				'name' => 'Crematorium Attendant',
				'description' => 'Crematorium Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 => 
			array (
				'id' => 836,
				'name' => 'Crewman',
				'description' => 'Crewman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 => 
			array (
				'id' => 837,
				'name' => 'Criminal Lawyer',
				'description' => 'Criminal Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 => 
			array (
				'id' => 838,
				'name' => 'Criminologist',
				'description' => 'Criminologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'id' => 839,
				'name' => 'Critic',
				'description' => 'Critic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'id' => 840,
				'name' => 'Crocodile Farm Worker',
				'description' => 'Crocodile Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'id' => 841,
				'name' => 'Crop Research Scientist',
				'description' => 'Crop Research Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'id' => 842,
				'name' => 'Crop Research Technician',
				'description' => 'Crop Research Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'id' => 843,
				'name' => 'Croupier',
				'description' => 'Croupier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'id' => 844,
				'name' => 'Croupiers And Gambling Workers Other Bookmakers',
				'description' => 'Croupiers And Gambling Workers Other Bookmakers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'id' => 845,
				'name' => 'Cruise Manager',
				'description' => 'Cruise Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'id' => 846,
				'name' => 'Cruiser Timber',
				'description' => 'Cruiser Timber',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'id' => 847,
				'name' => 'Crusher/Chemical And Related Processes Operator',
				'description' => 'Crusher/Chemical And Related Processes Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'id' => 848,
				'name' => 'Crushing/Coal Machine Operator',
				'description' => 'Crushing/Coal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'id' => 849,
				'name' => 'Cryogenic Engineer',
				'description' => 'Cryogenic Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'id' => 850,
				'name' => 'Crystallography Chemist',
				'description' => 'Crystallography Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 => 
			array (
				'id' => 851,
				'name' => 'Cultural Activities Manager',
				'description' => 'Cultural Activities Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 => 
			array (
				'id' => 852,
				'name' => 'Cultural B27 Artist',
				'description' => 'Cultural B27 Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 => 
			array (
				'id' => 853,
				'name' => 'Cultural B41 Officer',
				'description' => 'Cultural B41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 => 
			array (
				'id' => 854,
				'name' => 'Curator',
				'description' => 'Curator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 => 
			array (
				'id' => 855,
				'name' => 'Curator S27 Ssistant Officer',
				'description' => 'Curator S27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 => 
			array (
				'id' => 856,
				'name' => 'Curator S41',
				'description' => 'Curator S41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 => 
			array (
				'id' => 857,
				'name' => 'Currency Exchange Cashier',
				'description' => 'Currency Exchange Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 => 
			array (
				'id' => 858,
				'name' => 'Currency Sorter',
				'description' => 'Currency Sorter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 => 
			array (
				'id' => 859,
				'name' => 'Curricula Developer',
				'description' => 'Curricula Developer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 => 
			array (
				'id' => 860,
				'name' => 'Cushion Maker',
				'description' => 'Cushion Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 => 
			array (
				'id' => 861,
				'name' => 'Custom And Border Inspector',
				'description' => 'Custom And Border Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 => 
			array (
				'id' => 862,
				'name' => 'Customer-Complaints Clerk',
				'description' => 'Customer-Complaints Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'id' => 863,
				'name' => 'Customer Contact Centre',
				'description' => 'Customer Contact Centre',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'id' => 864,
				'name' => 'Customer Service Manager',
				'description' => 'Customer Service Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'id' => 865,
				'name' => 'Customer Service N17 Officer',
				'description' => 'Customer Service N17 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'id' => 866,
				'name' => 'Customer Service Officer/Executive',
				'description' => 'Customer Service Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'id' => 867,
				'name' => 'Customer Service Supervisor',
				'description' => 'Customer Service Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'id' => 868,
				'name' => 'Custom Inspector',
				'description' => 'Custom Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'id' => 869,
				'name' => 'Customs W27 Ssistant Superintendent',
				'description' => 'Customs W27 Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'id' => 870,
				'name' => 'Customs W41 Superintendent',
				'description' => 'Customs W41 Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'id' => 871,
				'name' => 'Custom W17 Junior Assistant Superintendent',
				'description' => 'Custom W17 Junior Assistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 => 
			array (
				'id' => 872,
				'name' => 'Cutter Supervisor',
				'description' => 'Cutter Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 => 
			array (
				'id' => 873,
				'name' => 'Cutting/Garments Machine Operator',
				'description' => 'Cutting/Garments Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 => 
			array (
				'id' => 874,
				'name' => 'Cutting Instruments Sharpener',
				'description' => 'Cutting Instruments Sharpener',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 => 
			array (
				'id' => 875,
				'name' => 'Cutting/Leather Machine Operator',
				'description' => 'Cutting/Leather Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 => 
			array (
				'id' => 876,
				'name' => 'Cutting/Metal Machine Operator',
				'description' => 'Cutting/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 => 
			array (
				'id' => 877,
				'name' => 'Cutting/Mine Machine Operator',
				'description' => 'Cutting/Mine Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'id' => 878,
				'name' => 'Cutting/Paper Machine Operator',
				'description' => 'Cutting/Paper Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'id' => 879,
				'name' => 'Cutting/Rubber Machine Operator',
				'description' => 'Cutting/Rubber Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'id' => 880,
				'name' => 'Cutting Technician',
				'description' => 'Cutting Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'id' => 881,
				'name' => 'Cutting/Textile Machine Operator',
				'description' => 'Cutting/Textile Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'id' => 882,
				'name' => 'Cutting/Veneer Lathe-Operator',
				'description' => 'Cutting/Veneer Lathe-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'id' => 883,
			'name' => 'Cylinder Filler & Tester (Compressed & Liquefied Gases)',
			'description' => 'Cylinder Filler & Tester (Compressed & Liquefied Gases)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'id' => 884,
				'name' => 'Cytology Technician',
				'description' => 'Cytology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'id' => 885,
				'name' => 'Dairy Bacteriologist',
				'description' => 'Dairy Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'id' => 886,
				'name' => 'Dairy Cream Separator',
				'description' => 'Dairy Cream Separator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'id' => 887,
				'name' => 'Dammar Collector',
				'description' => 'Dammar Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'id' => 888,
				'name' => 'Dance Arranger',
				'description' => 'Dance Arranger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'id' => 889,
				'name' => 'Dance Director',
				'description' => 'Dance Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'id' => 890,
				'name' => 'Dancer',
				'description' => 'Dancer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'id' => 891,
				'name' => 'Dang Pawara',
				'description' => 'Dang Pawara',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'id' => 892,
				'name' => 'Darkroom Worker',
				'description' => 'Darkroom Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'id' => 893,
				'name' => 'Database Administrator',
				'description' => 'Database Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'id' => 894,
				'name' => 'Database Architect',
				'description' => 'Database Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'id' => 895,
				'name' => 'Database/Computer Analyst',
				'description' => 'Database/Computer Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'id' => 896,
				'name' => 'Database Designer',
				'description' => 'Database Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'id' => 897,
				'name' => 'Data-Base Programmer',
				'description' => 'Data-Base Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'id' => 898,
				'name' => 'Data Entry/Computer',
				'description' => 'Data Entry/Computer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'id' => 899,
				'name' => 'Data Entry/Electronic Mail',
				'description' => 'Data Entry/Electronic Mail',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'id' => 900,
				'name' => 'Data Entry Supervisor',
				'description' => 'Data Entry Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'id' => 901,
				'name' => 'Data Processing F11 Machine Operator',
				'description' => 'Data Processing F11 Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'id' => 902,
				'name' => 'Data Processing Manager',
				'description' => 'Data Processing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'id' => 903,
				'name' => 'Dean',
				'description' => 'Dean',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'id' => 904,
				'name' => 'Debt Collector',
				'description' => 'Debt Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 => 
			array (
				'id' => 905,
				'name' => 'Deep-Sea Fishery Worker',
				'description' => 'Deep-Sea Fishery Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 => 
			array (
				'id' => 906,
				'name' => 'Deep-Sea Other Fishery Workers',
				'description' => 'Deep-Sea Other Fishery Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 => 
			array (
				'id' => 907,
				'name' => 'Dehairing/Hide Machine Operator',
				'description' => 'Dehairing/Hide Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 => 
			array (
				'id' => 908,
				'name' => 'Delinquency Social Worker',
				'description' => 'Delinquency Social Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 => 
			array (
				'id' => 909,
				'name' => 'Delivery And Receiving Clerk',
				'description' => 'Delivery And Receiving Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 => 
			array (
				'id' => 910,
				'name' => 'Delivery Assistant',
				'description' => 'Delivery Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 => 
			array (
				'id' => 911,
				'name' => 'Demang',
				'description' => 'Demang',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 => 
			array (
				'id' => 912,
				'name' => 'Demi Chef',
				'description' => 'Demi Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 => 
			array (
				'id' => 913,
				'name' => 'Demographer',
				'description' => 'Demographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 => 
			array (
				'id' => 914,
				'name' => 'Demography Statistician',
				'description' => 'Demography Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 => 
			array (
				'id' => 915,
				'name' => 'Demolition Labourer',
				'description' => 'Demolition Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 => 
			array (
				'id' => 916,
				'name' => 'Demolition Worker',
				'description' => 'Demolition Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 => 
			array (
				'id' => 917,
				'name' => 'Demonstrator',
				'description' => 'Demonstrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 => 
			array (
				'id' => 918,
				'name' => 'Demonstrator Farm',
				'description' => 'Demonstrator Farm',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 => 
			array (
				'id' => 919,
				'name' => 'Dental Aid',
				'description' => 'Dental Aid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 => 
			array (
				'id' => 920,
				'name' => 'Dental Assistant',
				'description' => 'Dental Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
				'id' => 921,
				'name' => 'Dental DUG45 Lecturer',
				'description' => 'Dental DUG45 Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'id' => 922,
				'name' => 'Dental Nurse',
				'description' => 'Dental Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 => 
			array (
				'id' => 923,
				'name' => 'Dental Prosthesis Maker And Repairer',
				'description' => 'Dental Prosthesis Maker And Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 => 
			array (
				'id' => 924,
				'name' => 'Dental Receptionist',
				'description' => 'Dental Receptionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 => 
			array (
				'id' => 925,
				'name' => 'Dental Surgery U11 Assistant',
				'description' => 'Dental Surgery U11 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 => 
			array (
				'id' => 926,
				'name' => 'Dental U29 Nurse',
				'description' => 'Dental U29 Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 => 
			array (
				'id' => 927,
				'name' => 'Dental U29 Technologist',
				'description' => 'Dental U29 Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 => 
			array (
				'id' => 928,
				'name' => 'Dental U41 Officer',
				'description' => 'Dental U41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 => 
			array (
				'id' => 929,
				'name' => 'Dentist',
				'description' => 'Dentist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 => 
			array (
				'id' => 930,
				'name' => 'Departmental/Store/Industrial Guard',
				'description' => 'Departmental/Store/Industrial Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 => 
			array (
				'id' => 931,
				'name' => 'Deputy Minister',
				'description' => 'Deputy Minister',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'id' => 932,
				'name' => 'Dermatologist',
				'description' => 'Dermatologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'id' => 933,
				'name' => 'Dermatology Physician',
				'description' => 'Dermatology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'id' => 934,
				'name' => 'Derrick/Oil & Gas Wells Operator',
				'description' => 'Derrick/Oil & Gas Wells Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'id' => 935,
				'name' => 'Designer B41',
				'description' => 'Designer B41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'id' => 936,
				'name' => 'Design Manager',
				'description' => 'Design Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 => 
			array (
				'id' => 937,
				'name' => 'Desktop Publishing Equipment Operator',
				'description' => 'Desktop Publishing Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 => 
			array (
				'id' => 938,
				'name' => 'Despatch Rider',
				'description' => 'Despatch Rider',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 => 
			array (
				'id' => 939,
				'name' => 'Detergent Chemist',
				'description' => 'Detergent Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 => 
			array (
				'id' => 940,
				'name' => 'Detergent Production Machine Operator',
				'description' => 'Detergent Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 => 
			array (
				'id' => 941,
				'name' => 'Diagnostic Radiologist',
				'description' => 'Diagnostic Radiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 => 
			array (
				'id' => 942,
				'name' => 'Diary Farm Worker',
				'description' => 'Diary Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 => 
			array (
				'id' => 943,
				'name' => 'Die-Casting Machine Operator',
				'description' => 'Die-Casting Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 => 
			array (
				'id' => 944,
				'name' => 'Die Draughtsperson',
				'description' => 'Die Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 => 
			array (
				'id' => 945,
				'name' => 'Diesel Engineer',
				'description' => 'Diesel Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 => 
			array (
				'id' => 946,
				'name' => 'Dietetic/Food Processing Consultant',
				'description' => 'Dietetic/Food Processing Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 => 
			array (
				'id' => 947,
				'name' => 'Dietetic U41 Officer',
				'description' => 'Dietetic U41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 => 
			array (
				'id' => 948,
				'name' => 'Dietician',
				'description' => 'Dietician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 => 
			array (
				'id' => 949,
				'name' => 'Digester Operator',
				'description' => 'Digester Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 => 
			array (
				'id' => 950,
				'name' => 'Digging Labourer',
				'description' => 'Digging Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 => 
			array (
				'id' => 951,
				'name' => 'Dim Sum Assistant Chef',
				'description' => 'Dim Sum Assistant Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 => 
			array (
				'id' => 952,
				'name' => 'Dim Sum Chef',
				'description' => 'Dim Sum Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 => 
			array (
				'id' => 953,
				'name' => 'Diplomatic Courier',
				'description' => 'Diplomatic Courier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 => 
			array (
				'id' => 954,
				'name' => 'Diplomatic Representative',
				'description' => 'Diplomatic Representative',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 => 
			array (
				'id' => 955,
				'name' => 'Dipping/Metal Machine Operator',
				'description' => 'Dipping/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 => 
			array (
				'id' => 956,
				'name' => 'Director Of Medical Services',
				'description' => 'Director Of Medical Services',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 => 
			array (
				'id' => 957,
				'name' => 'Director Of Nursing',
				'description' => 'Director Of Nursing',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 => 
			array (
				'id' => 958,
				'name' => 'Directors And Actors Other Film, Stage And Related Producers',
				'description' => 'Directors And Actors Other Film, Stage And Related Producers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 => 
			array (
				'id' => 959,
				'name' => 'Directory Compiler',
				'description' => 'Directory Compiler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 => 
			array (
				'id' => 960,
				'name' => 'Disc Jockey',
				'description' => 'Disc Jockey',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 => 
			array (
				'id' => 961,
				'name' => 'Discotheque Manager',
				'description' => 'Discotheque Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 => 
			array (
				'id' => 962,
				'name' => 'Dispatch/Air Transport Clerk',
				'description' => 'Dispatch/Air Transport Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 => 
			array (
				'id' => 963,
				'name' => 'Dispatch Assistant',
				'description' => 'Dispatch Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 => 
			array (
				'id' => 964,
				'name' => 'Display Artist',
				'description' => 'Display Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 => 
			array (
				'id' => 965,
				'name' => 'Display Decorator',
				'description' => 'Display Decorator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 => 
			array (
				'id' => 966,
				'name' => 'Display Designer',
				'description' => 'Display Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 => 
			array (
				'id' => 967,
				'name' => 'Display Manager',
				'description' => 'Display Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 => 
			array (
				'id' => 968,
				'name' => 'Display/Windows Decorator',
				'description' => 'Display/Windows Decorator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 => 
			array (
				'id' => 969,
				'name' => 'Display/Windows Designer',
				'description' => 'Display/Windows Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 => 
			array (
				'id' => 970,
				'name' => 'Distillig/Spirits Machine Operator',
				'description' => 'Distillig/Spirits Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 => 
			array (
				'id' => 971,
				'name' => 'Distribution Manager',
				'description' => 'Distribution Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 => 
			array (
				'id' => 972,
				'name' => 'Dive Boatman',
				'description' => 'Dive Boatman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 => 
			array (
				'id' => 973,
				'name' => 'Dive Master',
				'description' => 'Dive Master',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 => 
			array (
				'id' => 974,
				'name' => 'Diver',
				'description' => 'Diver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 => 
			array (
				'id' => 975,
				'name' => 'Diver Construction',
				'description' => 'Diver Construction',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 => 
			array (
				'id' => 976,
				'name' => 'Docker',
				'description' => 'Docker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 => 
			array (
				'id' => 977,
				'name' => 'Doctor Medical/Anaesthetics',
				'description' => 'Doctor Medical/Anaesthetics',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 => 
			array (
				'id' => 978,
				'name' => 'Doctor Medical/Cardiology',
				'description' => 'Doctor Medical/Cardiology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 => 
			array (
				'id' => 979,
				'name' => 'Doctor Medical/Gynaecology',
				'description' => 'Doctor Medical/Gynaecology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 => 
			array (
				'id' => 980,
				'name' => 'Doctor Medical Insurance Consultancy',
				'description' => 'Doctor Medical Insurance Consultancy',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 => 
			array (
				'id' => 981,
				'name' => 'Doctor Medical/Neurology',
				'description' => 'Doctor Medical/Neurology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 => 
			array (
				'id' => 982,
				'name' => 'Doctor Medical/Obstetrics',
				'description' => 'Doctor Medical/Obstetrics',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 => 
			array (
				'id' => 983,
				'name' => 'Doctor Medical/Ophthalmology',
				'description' => 'Doctor Medical/Ophthalmology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 => 
			array (
				'id' => 984,
				'name' => 'Doctor Medical/Psychiatry',
				'description' => 'Doctor Medical/Psychiatry',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 => 
			array (
				'id' => 985,
				'name' => 'Doctor Medical/Radiology',
				'description' => 'Doctor Medical/Radiology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 => 
			array (
				'id' => 986,
				'name' => 'Documentalist',
				'description' => 'Documentalist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 => 
			array (
				'id' => 987,
				'name' => 'Documentation Officer',
				'description' => 'Documentation Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'id' => 988,
				'name' => 'Document Controller',
				'description' => 'Document Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'id' => 989,
				'name' => 'Document Controller Officer',
				'description' => 'Document Controller Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'id' => 990,
				'name' => 'Document Coordinator',
				'description' => 'Document Coordinator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'id' => 991,
				'name' => 'Document Duplication Clerk',
				'description' => 'Document Duplication Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 => 
			array (
				'id' => 992,
				'name' => 'Dog Trainer',
				'description' => 'Dog Trainer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 => 
			array (
				'id' => 993,
				'name' => 'Doll And Stuffed-Toy Maker',
				'description' => 'Doll And Stuffed-Toy Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 => 
			array (
				'id' => 994,
				'name' => 'Domestic Charworker',
				'description' => 'Domestic Charworker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 => 
			array (
				'id' => 995,
				'name' => 'Domestic Cleaner',
				'description' => 'Domestic Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 => 
			array (
				'id' => 996,
				'name' => 'Domestic Helper',
				'description' => 'Domestic Helper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 => 
			array (
				'id' => 997,
				'name' => 'Domestic Housekeeper',
				'description' => 'Domestic Housekeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 => 
			array (
				'id' => 998,
				'name' => 'Domestic Servant',
				'description' => 'Domestic Servant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 => 
			array (
				'id' => 999,
				'name' => 'Doorman',
				'description' => 'Doorman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 => 
			array (
				'id' => 1000,
				'name' => 'Dormitory Warden',
				'description' => 'Dormitory Warden',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 1001,
				'name' => 'Dragline Operator',
				'description' => 'Dragline Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 1002,
				'name' => 'Draughting Technician',
				'description' => 'Draughting Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 1003,
				'name' => 'Draughtsperson',
				'description' => 'Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 1004,
				'name' => 'Draughtsperson J17',
				'description' => 'Draughtsperson J17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 1005,
				'name' => 'Drawing/Metal Machine Operator',
				'description' => 'Drawing/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 1006,
				'name' => 'Drawing/Wire Machine Operator',
				'description' => 'Drawing/Wire Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 1007,
				'name' => 'Dredge Operator',
				'description' => 'Dredge Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 1008,
				'name' => 'Dredging Winchman',
				'description' => 'Dredging Winchman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 1009,
				'name' => 'Dress Designer',
				'description' => 'Dress Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 1010,
				'name' => 'Dressmaker',
				'description' => 'Dressmaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 1011,
				'name' => 'Drier/Chemical And Related Processes Operator',
				'description' => 'Drier/Chemical And Related Processes Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 1012,
			'name' => 'Drilling Equipment/Cable (Oil & Gas Wells) Operator',
			'description' => 'Drilling Equipment/Cable (Oil & Gas Wells) Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 1013,
			'name' => 'Drilling Equipment/Rotary (Oil & Gas Wells) Operator',
			'description' => 'Drilling Equipment/Rotary (Oil & Gas Wells) Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 1014,
				'name' => 'Drilling Equipment/Wells Operator',
				'description' => 'Drilling Equipment/Wells Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 1015,
				'name' => 'Drilling/Mine Machine Operator',
				'description' => 'Drilling/Mine Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 1016,
				'name' => 'Drilling Plant Operator',
				'description' => 'Drilling Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 1017,
				'name' => 'Drilling/Quarry Machine Operator',
				'description' => 'Drilling/Quarry Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 1018,
				'name' => 'Drill S17 Instructor',
				'description' => 'Drill S17 Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 1019,
				'name' => 'Driver Assistant',
				'description' => 'Driver Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 1020,
				'name' => 'Driver Locomotive Assistant',
				'description' => 'Driver Locomotive Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 1021,
				'name' => 'Driver R3',
				'description' => 'Driver R3',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 1022,
				'name' => 'Driving Instructor',
				'description' => 'Driving Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 1023,
				'name' => 'Drop-Hammer Operator',
				'description' => 'Drop-Hammer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 1024,
				'name' => 'Drum Maker',
				'description' => 'Drum Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 1025,
				'name' => 'Dry-Cleaning And Pressing Manager, Laundering',
				'description' => 'Dry-Cleaning And Pressing Manager, Laundering',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 1026,
				'name' => 'Dry-Cleaning Machine Operator',
				'description' => 'Dry-Cleaning Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 1027,
				'name' => 'Dry Dock Dockmaster',
				'description' => 'Dry Dock Dockmaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 1028,
				'name' => 'Drying/Textiles Machine Operator',
				'description' => 'Drying/Textiles Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 1029,
				'name' => 'Dubbing Mixer',
				'description' => 'Dubbing Mixer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 1030,
				'name' => 'Duck Farmer',
				'description' => 'Duck Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 1031,
				'name' => 'Dulang Washer',
				'description' => 'Dulang Washer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 1032,
				'name' => 'Dumper Driver',
				'description' => 'Dumper Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 1033,
				'name' => 'Dye Chemist',
				'description' => 'Dye Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 1034,
				'name' => 'Dyeing Machine Operator',
				'description' => 'Dyeing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 1035,
				'name' => 'Dyeing/Textile Fibres Machine Operator',
				'description' => 'Dyeing/Textile Fibres Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 1036,
				'name' => 'Earth-Moving Equipment Assembler',
				'description' => 'Earth-Moving Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 1037,
				'name' => 'Earth-Moving Equipment Mechanic',
				'description' => 'Earth-Moving Equipment Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 1038,
				'name' => 'Ecologist',
				'description' => 'Ecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 1039,
				'name' => 'Ecology Botanist',
				'description' => 'Ecology Botanist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 1040,
				'name' => 'Ecology Technician',
				'description' => 'Ecology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 1041,
				'name' => 'Ecology Zoologist',
				'description' => 'Ecology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 1042,
				'name' => 'E-Commerce Adviser',
				'description' => 'E-Commerce Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 1043,
				'name' => 'Econometrician',
				'description' => 'Econometrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 1044,
				'name' => 'Econometrician Economist',
				'description' => 'Econometrician Economist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 1045,
				'name' => 'Economic Botanist',
				'description' => 'Economic Botanist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 1046,
				'name' => 'Economics Statistician',
				'description' => 'Economics Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 1047,
				'name' => 'Economist',
				'description' => 'Economist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 1048,
				'name' => 'Economy Affair E17 Assistant',
				'description' => 'Economy Affair E17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 1049,
				'name' => 'Economy Affairs E27 Ssistant Officer',
				'description' => 'Economy Affairs E27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 1050,
				'name' => 'Economy Affairs E41 Officer',
				'description' => 'Economy Affairs E41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 1051,
				'name' => 'Edible Nut Processing Machine Operator',
				'description' => 'Edible Nut Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 1052,
				'name' => 'Edible Oils Press-Operator',
				'description' => 'Edible Oils Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 1053,
				'name' => 'Editor',
				'description' => 'Editor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 1054,
				'name' => 'EDP Assistant Supervisor',
				'description' => 'EDP Assistant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 1055,
				'name' => 'EDP Operator',
				'description' => 'EDP Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 1056,
				'name' => 'EDP Supervisor',
				'description' => 'EDP Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 1057,
				'name' => 'Education Counselor',
				'description' => 'Education Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 1058,
				'name' => 'Education Manager',
				'description' => 'Education Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 1059,
				'name' => 'Education Methods Adviser',
				'description' => 'Education Methods Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 1060,
				'name' => 'Education Statistician',
				'description' => 'Education Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 1061,
				'name' => 'Education Systems Evaluator And Researcher',
				'description' => 'Education Systems Evaluator And Researcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 1062,
				'name' => 'Electrical And Instrument Supervisor',
				'description' => 'Electrical And Instrument Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 1063,
				'name' => 'Electrical Chargeman',
				'description' => 'Electrical Chargeman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 1064,
				'name' => 'Electrical/Electric Power Distribution Engineer',
				'description' => 'Electrical/Electric Power Distribution Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 1065,
				'name' => 'Electrical/Electric Power Generation Engineer',
				'description' => 'Electrical/Electric Power Generation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 1066,
				'name' => 'Electrical/Electric Power Transmission Engineer',
				'description' => 'Electrical/Electric Power Transmission Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 1067,
				'name' => 'Electrical/Electric Traction Engineer',
				'description' => 'Electrical/Electric Traction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 1068,
				'name' => 'Electrical/Electromechanical Equipment Engineer',
				'description' => 'Electrical/Electromechanical Equipment Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 1069,
				'name' => 'Electrical/Elevator And Related Equipment Fitter',
				'description' => 'Electrical/Elevator And Related Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 1070,
				'name' => 'Electrical Engineer',
				'description' => 'Electrical Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 1071,
				'name' => 'Electrical Engineering Assistant',
				'description' => 'Electrical Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 1072,
				'name' => 'Electrical Equipment Assembler',
				'description' => 'Electrical Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 1073,
				'name' => 'Electrical Fitter',
				'description' => 'Electrical Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 1074,
				'name' => 'Electrical Foreman',
				'description' => 'Electrical Foreman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 1075,
				'name' => 'Electrical/High Voltage Engineer',
				'description' => 'Electrical/High Voltage Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 1076,
			'name' => 'Electrical (High Voltage System) Engineering Assistant',
			'description' => 'Electrical (High Voltage System) Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 1077,
				'name' => 'Electrical Illumination Engineer',
				'description' => 'Electrical Illumination Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 1078,
				'name' => 'Electrical J29 Technical Assistant',
				'description' => 'Electrical J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 1079,
				'name' => 'Electrical J41 Engineer',
				'description' => 'Electrical J41 Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 1080,
				'name' => 'Electrical/Motors And Dynamos Fitter',
				'description' => 'Electrical/Motors And Dynamos Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 1081,
				'name' => 'Electrical/Office-Machinery Fitter',
				'description' => 'Electrical/Office-Machinery Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 1082,
				'name' => 'Electrical Power Line Worker',
				'description' => 'Electrical Power Line Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 1083,
				'name' => 'Electrical Supervisor',
				'description' => 'Electrical Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 1084,
				'name' => 'Electrical Switchboard Operator',
				'description' => 'Electrical Switchboard Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 1085,
				'name' => 'Electrical Systems Engineer',
				'description' => 'Electrical Systems Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 1086,
				'name' => 'Electrical Technical Assistant',
				'description' => 'Electrical Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 1087,
				'name' => 'Electrical Testing Engineer',
				'description' => 'Electrical Testing Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 1088,
				'name' => 'Electricity And Magnetism Physicist',
				'description' => 'Electricity And Magnetism Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 1089,
				'name' => 'Electric Power Load Dispatcher',
				'description' => 'Electric Power Load Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 1090,
				'name' => 'Electric-Sign Assembler',
				'description' => 'Electric-Sign Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 1091,
				'name' => 'Electrocardiograph Equipment Operator',
				'description' => 'Electrocardiograph Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 1092,
				'name' => 'Electroencephalograph Equipment Operator',
				'description' => 'Electroencephalograph Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 1093,
			'name' => 'Electronic Data Processing (PDE) Administrator',
			'description' => 'Electronic Data Processing (PDE) Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 1094,
			'name' => 'Electronic Data Processing (PDE) Analyst',
			'description' => 'Electronic Data Processing (PDE) Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 1095,
				'name' => 'Electronic Equipment Assembler',
				'description' => 'Electronic Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 1096,
				'name' => 'Electronics/Computer And Related Electronic Equipment Fitter',
				'description' => 'Electronics/Computer And Related Electronic Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 1097,
				'name' => 'Electronics/Computer Hardware Design Engineer',
				'description' => 'Electronics/Computer Hardware Design Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 1098,
				'name' => 'Electronics Engineer',
				'description' => 'Electronics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 1099,
				'name' => 'Electronics Engineering Assistant',
				'description' => 'Electronics Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 1100,
				'name' => 'Electronics Fitter',
				'description' => 'Electronics Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 1101,
				'name' => 'Electronics/Industrial Equipment Fitter',
				'description' => 'Electronics/Industrial Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 1102,
				'name' => 'Electronics/Information Engineering Engineer',
				'description' => 'Electronics/Information Engineering Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 1103,
				'name' => 'Electronics/Instrumentation Engineer',
				'description' => 'Electronics/Instrumentation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 1104,
				'name' => 'Electronics J29 Technical Assistant',
				'description' => 'Electronics J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 1105,
				'name' => 'Electronics J41 Engineer',
				'description' => 'Electronics J41 Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 1106,
				'name' => 'Electronics/Medical Equipment Fitter',
				'description' => 'Electronics/Medical Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 1107,
				'name' => 'Electronics/Meteorological Equipment Fitter',
				'description' => 'Electronics/Meteorological Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 1108,
				'name' => 'Electronics Physicist',
				'description' => 'Electronics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 1109,
				'name' => 'Electronics Repairer',
				'description' => 'Electronics Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 1110,
				'name' => 'Electronics/Semiconductors Engineer',
				'description' => 'Electronics/Semiconductors Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 1111,
				'name' => 'Electronics/Signaling System Fitter',
				'description' => 'Electronics/Signaling System Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 1112,
				'name' => 'Electroplater',
				'description' => 'Electroplater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 1113,
				'name' => 'Electroplating/Metal Machine Operator',
				'description' => 'Electroplating/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 1114,
				'name' => 'Electrotherapist',
				'description' => 'Electrotherapist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 1115,
				'name' => 'Electrotyper',
				'description' => 'Electrotyper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 1116,
				'name' => 'Elevator/Material Handling Operator',
				'description' => 'Elevator/Material Handling Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 1117,
				'name' => 'Eligibility Interviewer',
				'description' => 'Eligibility Interviewer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 1118,
				'name' => 'Eligibility Specialist',
				'description' => 'Eligibility Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 1119,
				'name' => 'Embalmer',
				'description' => 'Embalmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 1120,
				'name' => 'Embassy Diplomatic Representative',
				'description' => 'Embassy Diplomatic Representative',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 1121,
				'name' => 'Embassy Secretary',
				'description' => 'Embassy Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 1122,
				'name' => 'Embossing/Book Machine Operator',
				'description' => 'Embossing/Book Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 1123,
				'name' => 'Embossing/Plastics Machine Operator',
				'description' => 'Embossing/Plastics Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 1124,
				'name' => 'Embossing Press-Operator',
				'description' => 'Embossing Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 1125,
				'name' => 'Embryology Zoologist',
				'description' => 'Embryology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 1126,
				'name' => 'Emergency Paramedic',
				'description' => 'Emergency Paramedic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 1127,
				'name' => 'Employers’ Organization Director-General',
				'description' => 'Employers’ Organization Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 1128,
				'name' => 'Employers’ Organization President',
				'description' => 'Employers’ Organization President',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 1129,
				'name' => 'Employers’ Organization Senior Official',
				'description' => 'Employers’ Organization Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 1130,
				'name' => 'Employment Agent',
				'description' => 'Employment Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 1131,
				'name' => 'Employment Clerk',
				'description' => 'Employment Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 1132,
				'name' => 'Employment Counselor',
				'description' => 'Employment Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 1133,
				'name' => 'Endocrinologists',
				'description' => 'Endocrinologists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 1134,
				'name' => 'Endocrinology Physician',
				'description' => 'Endocrinology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 1135,
				'name' => 'Endocrinology Physiologist',
				'description' => 'Endocrinology Physiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 1136,
				'name' => 'Enforcement N27 Ssistant Officer',
				'description' => 'Enforcement N27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 1137,
				'name' => 'Enforcement N41 Officer',
				'description' => 'Enforcement N41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 1138,
				'name' => 'Enforcer N17 Assistant',
				'description' => 'Enforcer N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 1139,
			'name' => 'Engine (Boat) Technician',
			'description' => 'Engine (Boat) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 1140,
				'name' => 'Engine Driver',
				'description' => 'Engine Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 1141,
				'name' => 'Engineering/Aeronautical Draughtsperson',
				'description' => 'Engineering/Aeronautical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 1142,
			'name' => 'Engineering/Aeronautical (Mechanical) Technician',
			'description' => 'Engineering/Aeronautical (Mechanical) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 1143,
			'name' => 'Engineering/Aerospace (Mechanical) Technician',
			'description' => 'Engineering/Aerospace (Mechanical) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 1144,
			'name' => 'Engineering/Aerospace (Telecommunication) Technician',
			'description' => 'Engineering/Aerospace (Telecommunication) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 1145,
				'name' => 'Engineering/Automobile Technician',
				'description' => 'Engineering/Automobile Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 1146,
				'name' => 'Engineering/Chemical Estimator',
				'description' => 'Engineering/Chemical Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 1147,
			'name' => 'Engineering/Chemical (Petroleum) Technician',
			'description' => 'Engineering/Chemical (Petroleum) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 1148,
				'name' => 'Engineering/Chemical Technician',
				'description' => 'Engineering/Chemical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 1149,
				'name' => 'Engineering/Chemical Technologist',
				'description' => 'Engineering/Chemical Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 1150,
				'name' => 'Engineering/Civil Draughtsperson',
				'description' => 'Engineering/Civil Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 1151,
				'name' => 'Engineering/Civil Estimator',
				'description' => 'Engineering/Civil Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 1152,
				'name' => 'Engineering/Civil J17 Technician',
				'description' => 'Engineering/Civil J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 1153,
				'name' => 'Engineering/Civil Technician',
				'description' => 'Engineering/Civil Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 1154,
				'name' => 'Engineering Civil Technologist',
				'description' => 'Engineering Civil Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 1155,
				'name' => 'Engineering Clerk',
				'description' => 'Engineering Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 1156,
				'name' => 'Engineering Designer',
				'description' => 'Engineering Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 1157,
				'name' => 'Engineering/Electrical Draughtsperson',
				'description' => 'Engineering/Electrical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 1158,
			'name' => 'Engineering/Electrical (Electric Power Transmission) Technician',
			'description' => 'Engineering/Electrical (Electric Power Transmission) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 1159,
				'name' => 'Engineering/Electrical Estimator',
				'description' => 'Engineering/Electrical Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 1160,
			'name' => 'Engineering/Electrical (High Voltage) Technician',
			'description' => 'Engineering/Electrical (High Voltage) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 1161,
				'name' => 'Engineering/Electrical J17 Technician',
				'description' => 'Engineering/Electrical J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 1162,
				'name' => 'Engineering/Electrical Technician',
				'description' => 'Engineering/Electrical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 1163,
				'name' => 'Engineering/Electrical Technologist',
				'description' => 'Engineering/Electrical Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 1164,
				'name' => 'Engineering/Electronics Draughtsperson',
				'description' => 'Engineering/Electronics Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 1165,
				'name' => 'Engineering/Electronics Estimator',
				'description' => 'Engineering/Electronics Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 1166,
				'name' => 'Engineering/Electronics J17 Technician',
				'description' => 'Engineering/Electronics J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 1167,
				'name' => 'Engineering/Electronics Technician',
				'description' => 'Engineering/Electronics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 1168,
				'name' => 'Engineering/Electronics Technologist',
				'description' => 'Engineering/Electronics Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 1169,
				'name' => 'Engineering Geologist',
				'description' => 'Engineering Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 1170,
				'name' => 'Engineering/Heating And Ventilation Systems Draughtsperson',
				'description' => 'Engineering/Heating And Ventilation Systems Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 1171,
				'name' => 'Engineering Illustrator',
				'description' => 'Engineering Illustrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 1172,
				'name' => 'Engineering/Industrial Efficiency Technician',
				'description' => 'Engineering/Industrial Efficiency Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 1173,
				'name' => 'Engineering/Industrial Layout Technician',
				'description' => 'Engineering/Industrial Layout Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 1174,
				'name' => 'Engineering/Marine Draughtsperson',
				'description' => 'Engineering/Marine Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 1175,
				'name' => 'Engineering/Marine Technician',
				'description' => 'Engineering/Marine Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 1176,
			'name' => 'Engineering/Mechanical (Agriculture) Technician',
			'description' => 'Engineering/Mechanical (Agriculture) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 1177,
				'name' => 'Engineering/Mechanical Draughtsperson',
				'description' => 'Engineering/Mechanical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 1178,
				'name' => 'Engineering/Mechanical Estimator',
				'description' => 'Engineering/Mechanical Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 1179,
			'name' => 'Engineering/Mechanical (Industrial Machinery And Tools) Technician',
			'description' => 'Engineering/Mechanical (Industrial Machinery And Tools) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 1180,
			'name' => 'Engineering/Mechanical (Instruments) Technician',
			'description' => 'Engineering/Mechanical (Instruments) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 1181,
				'name' => 'Engineering/Mechanical J17 Technician',
				'description' => 'Engineering/Mechanical J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 1182,
			'name' => 'Engineering/Mechanical (Lubrication) Technician',
			'description' => 'Engineering/Mechanical (Lubrication) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 1183,
			'name' => 'Engineering/Mechanical (Motors And Engines) Technician',
			'description' => 'Engineering/Mechanical (Motors And Engines) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 1184,
			'name' => 'Engineering/Mechanical (Ship Construction) Technician',
			'description' => 'Engineering/Mechanical (Ship Construction) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 1185,
				'name' => 'Engineering/Mechanical Technician',
				'description' => 'Engineering/Mechanical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 1186,
				'name' => 'Engineering/Mechanical Technologist',
				'description' => 'Engineering/Mechanical Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 1187,
				'name' => 'Engineering/Methods Technician',
				'description' => 'Engineering/Methods Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 1188,
				'name' => 'Engineering/Mining Technician',
				'description' => 'Engineering/Mining Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 1189,
				'name' => 'Engineering/Petroleum Technician',
				'description' => 'Engineering/Petroleum Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 1190,
				'name' => 'Engineering/Planning Technician',
				'description' => 'Engineering/Planning Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 1191,
				'name' => 'Engineering/Process Technician',
				'description' => 'Engineering/Process Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 1192,
				'name' => 'Engineering/Production Technician',
				'description' => 'Engineering/Production Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 1193,
				'name' => 'Engineering/Refrigeration And Air-Conditioning System And Equipment Technician',
				'description' => 'Engineering/Refrigeration And Air-Conditioning System And Equipment Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 1194,
				'name' => 'Engineering/Safety Technician',
				'description' => 'Engineering/Safety Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 1195,
				'name' => 'Engineering Statistician',
				'description' => 'Engineering Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 1196,
			'name' => 'Engineering/Systems (Except Computers) Technician',
			'description' => 'Engineering/Systems (Except Computers) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 1197,
				'name' => 'Engineering/Telecomunications Technician',
				'description' => 'Engineering/Telecomunications Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 1198,
				'name' => 'Engineering/Time And Motion Study Technician',
				'description' => 'Engineering/Time And Motion Study Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 1199,
				'name' => 'Engineering/Value Technician',
				'description' => 'Engineering/Value Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 1200,
				'name' => 'Engineering/Work Study Technician',
				'description' => 'Engineering/Work Study Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 1201,
				'name' => 'Engine/Marine Assembler',
				'description' => 'Engine/Marine Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 1202,
				'name' => 'Engines Engineer',
				'description' => 'Engines Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 1203,
				'name' => 'Engraving/Glass Machine Operator',
				'description' => 'Engraving/Glass Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 1204,
				'name' => 'Engraving/Metal Machine Operator',
				'description' => 'Engraving/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 1205,
				'name' => 'Enterprise Chairman',
				'description' => 'Enterprise Chairman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 1206,
				'name' => 'Enterprise Director',
				'description' => 'Enterprise Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 1207,
				'name' => 'Enterprise Director-General',
				'description' => 'Enterprise Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 1208,
				'name' => 'Enterprise President',
				'description' => 'Enterprise President',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 1209,
				'name' => 'Entertainment Manager',
				'description' => 'Entertainment Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 1210,
				'name' => 'Entomological Assistant',
				'description' => 'Entomological Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 1211,
				'name' => 'Entomological Technician',
				'description' => 'Entomological Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 1212,
				'name' => 'Entomologist',
				'description' => 'Entomologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 1213,
				'name' => 'Entomology Zoologist',
				'description' => 'Entomology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 1214,
				'name' => 'Envelope & Paper Bag Production Machine Operator',
				'description' => 'Envelope & Paper Bag Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 1215,
				'name' => 'Environmental Control C27 Ssistant Officer',
				'description' => 'Environmental Control C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 1216,
				'name' => 'Environmental Health U29 Ssistant Officer',
				'description' => 'Environmental Health U29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 1217,
				'name' => 'Environmental Health U41 Officer',
				'description' => 'Environmental Health U41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 1218,
				'name' => 'Environmental Meteorologist',
				'description' => 'Environmental Meteorologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 1219,
				'name' => 'Environmental Research Scientist',
				'description' => 'Environmental Research Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 1220,
				'name' => 'Environmental Supervisor',
				'description' => 'Environmental Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 1221,
				'name' => 'Environmental Systems Manager',
				'description' => 'Environmental Systems Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 1222,
				'name' => 'Environment Control C41 Officer',
				'description' => 'Environment Control C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 1223,
				'name' => 'Environment Engineer',
				'description' => 'Environment Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 1224,
				'name' => 'Environment Protection Organization Secretary-General',
				'description' => 'Environment Protection Organization Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 1225,
				'name' => 'Envois Clerk',
				'description' => 'Envois Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 1226,
				'name' => 'Enzymes Biochemist',
				'description' => 'Enzymes Biochemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 1227,
				'name' => 'Epidemiologist',
				'description' => 'Epidemiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 1228,
				'name' => 'Epidemiology Physiologist',
				'description' => 'Epidemiology Physiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 1229,
				'name' => 'Epidemiology Veterinarian',
				'description' => 'Epidemiology Veterinarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 1230,
				'name' => 'Essayist',
				'description' => 'Essayist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 1231,
				'name' => 'Establishments',
				'description' => 'Establishments',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 1232,
				'name' => 'Estate Planner',
				'description' => 'Estate Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 1233,
				'name' => 'Estate/Plantation Checker',
				'description' => 'Estate/Plantation Checker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 1234,
				'name' => 'Estate/Plantation Clerk',
				'description' => 'Estate/Plantation Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 1235,
				'name' => 'Estate/Plantation Financial Clerk',
				'description' => 'Estate/Plantation Financial Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 1236,
				'name' => 'Estate/Plantation Inspector Quality',
				'description' => 'Estate/Plantation Inspector Quality',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 1237,
				'name' => 'Estate/Plantation Loader',
				'description' => 'Estate/Plantation Loader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 1238,
				'name' => 'Estate/Plantation Manager',
				'description' => 'Estate/Plantation Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 1239,
				'name' => 'Estate/Plantation Mandore',
				'description' => 'Estate/Plantation Mandore',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 1240,
				'name' => 'Estate/Plantation Mechanic Maintenance',
				'description' => 'Estate/Plantation Mechanic Maintenance',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 1241,
				'name' => 'Estate/Plantation Stock Clerk',
				'description' => 'Estate/Plantation Stock Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 1242,
				'name' => 'Estate/Plantation Supervisor',
				'description' => 'Estate/Plantation Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 1243,
				'name' => 'Estate/Plantation Worker',
				'description' => 'Estate/Plantation Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 1244,
				'name' => 'Estimating Clerk',
				'description' => 'Estimating Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 1245,
				'name' => 'Etching/Glass Machine Operator',
				'description' => 'Etching/Glass Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 1246,
				'name' => 'Etching/Metal Machine Operator',
				'description' => 'Etching/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 1247,
				'name' => 'Ethnologist',
				'description' => 'Ethnologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 1248,
				'name' => 'Evaluation W17 Assistant',
				'description' => 'Evaluation W17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 1249,
				'name' => 'Evaluation W27 Ssistant Officer',
				'description' => 'Evaluation W27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 1250,
				'name' => 'Evaluation W41 Officer',
				'description' => 'Evaluation W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 1251,
				'name' => 'Evaporator Operator',
				'description' => 'Evaporator Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 1252,
				'name' => 'Excaving-Shovel Operator',
				'description' => 'Excaving-Shovel Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 1253,
				'name' => 'Executive Chef',
				'description' => 'Executive Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 1254,
				'name' => 'Executive Chef Assistant',
				'description' => 'Executive Chef Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 1255,
				'name' => 'Executive Secretary',
				'description' => 'Executive Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 1256,
				'name' => 'Exhibition And Convention Consultant',
				'description' => 'Exhibition And Convention Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 1257,
				'name' => 'Exhibition And Convention Organizer',
				'description' => 'Exhibition And Convention Organizer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 1258,
				'name' => 'Exhibition Designer',
				'description' => 'Exhibition Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 1259,
				'name' => 'Explosives Production Machine Operator',
				'description' => 'Explosives Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 1260,
				'name' => 'Export Executive',
				'description' => 'Export Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 1261,
				'name' => 'Export Sales Manager',
				'description' => 'Export Sales Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 1262,
				'name' => 'Extractive Metallurgist',
				'description' => 'Extractive Metallurgist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 1263,
				'name' => 'Extractive Metallurgy Assistant',
				'description' => 'Extractive Metallurgy Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 1264,
				'name' => 'Extractive Technologist',
				'description' => 'Extractive Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 1265,
				'name' => 'Extruder Metal',
				'description' => 'Extruder Metal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 1266,
				'name' => 'Extruding/Clay Press-Operator',
				'description' => 'Extruding/Clay Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 1267,
				'name' => 'Extruding/Plastics Machine Operator',
				'description' => 'Extruding/Plastics Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 1268,
				'name' => 'Extruding/Rubber Machine Operator',
				'description' => 'Extruding/Rubber Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 1269,
				'name' => 'Extruding/Wire Machine Operator',
				'description' => 'Extruding/Wire Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 1270,
				'name' => 'Eye Specialist',
				'description' => 'Eye Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 1271,
				'name' => 'Fabric Repairer',
				'description' => 'Fabric Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 1272,
				'name' => 'Fabrics/Knitted Repairer',
				'description' => 'Fabrics/Knitted Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 1273,
				'name' => 'Facilities Engineer',
				'description' => 'Facilities Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 1274,
				'name' => 'Facilities Maintenance Clerk',
				'description' => 'Facilities Maintenance Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 1275,
				'name' => 'Facilities Maintenance Manager',
				'description' => 'Facilities Maintenance Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 1276,
				'name' => 'Facilities Supervisor',
				'description' => 'Facilities Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 1277,
				'name' => 'Factory Administrator',
				'description' => 'Factory Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 1278,
				'name' => 'Factory And Machinery J41 Inspector',
				'description' => 'Factory And Machinery J41 Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 1279,
				'name' => 'Factory & Machinery J41 Assistant Inspector',
				'description' => 'Factory & Machinery J41 Assistant Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 1280,
				'name' => 'Factory Manager',
				'description' => 'Factory Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 1281,
				'name' => 'Factory Medic',
				'description' => 'Factory Medic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 1282,
				'name' => 'Factory Tour Guide',
				'description' => 'Factory Tour Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 1283,
				'name' => 'Faith Healers',
				'description' => 'Faith Healers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 1284,
				'name' => 'Family Medicine Physician',
				'description' => 'Family Medicine Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 1285,
				'name' => 'Family Planning Officer',
				'description' => 'Family Planning Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 1286,
				'name' => 'Farm Hand',
				'description' => 'Farm Hand',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 1287,
				'name' => 'Farm Helper',
				'description' => 'Farm Helper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 1288,
				'name' => 'Farming Adviser',
				'description' => 'Farming Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 1289,
				'name' => 'Farm Tractor Driver',
				'description' => 'Farm Tractor Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 1290,
				'name' => 'Fashion Designer',
				'description' => 'Fashion Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 1291,
				'name' => 'Fashion Model',
				'description' => 'Fashion Model',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 1292,
			'name' => 'Federal Counsel (Government Service)',
			'description' => 'Federal Counsel (Government Service)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 1293,
				'name' => 'Federal Court Judge',
				'description' => 'Federal Court Judge',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 1294,
				'name' => 'Feed Grinder',
				'description' => 'Feed Grinder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 1295,
				'name' => 'Feed Mixing Machine Operator',
				'description' => 'Feed Mixing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 1296,
				'name' => 'Feldchers',
				'description' => 'Feldchers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 1297,
				'name' => 'Fermintation Equipment/Spirits Operator',
				'description' => 'Fermintation Equipment/Spirits Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 1298,
				'name' => 'Ferry Boat Conductor',
				'description' => 'Ferry Boat Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 1299,
				'name' => 'Ferry Captain',
				'description' => 'Ferry Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 1300,
				'name' => 'Ferry Hand',
				'description' => 'Ferry Hand',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 1301,
				'name' => 'Ferry Officer',
				'description' => 'Ferry Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 1302,
				'name' => 'Ferry Service Serang',
				'description' => 'Ferry Service Serang',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 1303,
				'name' => 'Fertility Obstetrician And Gynaecologist',
				'description' => 'Fertility Obstetrician And Gynaecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 1304,
				'name' => 'Fertilizer Plant Operator',
				'description' => 'Fertilizer Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 1305,
				'name' => 'Fetomaternal Medicine Obstetrician And Gynaecologist',
				'description' => 'Fetomaternal Medicine Obstetrician And Gynaecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 1306,
				'name' => 'Fiber Technologist',
				'description' => 'Fiber Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 1307,
				'name' => 'Fibre Carder',
				'description' => 'Fibre Carder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 1308,
				'name' => 'Fibre Comber',
				'description' => 'Fibre Comber',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 1309,
				'name' => 'Fibre Drawer',
				'description' => 'Fibre Drawer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 1310,
				'name' => 'Fibreglass Maker',
				'description' => 'Fibreglass Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 1311,
				'name' => 'Fibre Grader',
				'description' => 'Fibre Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 1312,
				'name' => 'Fibre Preparing Machine Operator',
				'description' => 'Fibre Preparing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 1313,
				'name' => 'Fibre Rover',
				'description' => 'Fibre Rover',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 1314,
				'name' => 'Fibre/Textiles Picker',
				'description' => 'Fibre/Textiles Picker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'id' => 1315,
				'name' => 'Fibrous Plasterer',
				'description' => 'Fibrous Plasterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'id' => 1316,
				'name' => 'Fiction Writer',
				'description' => 'Fiction Writer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'id' => 1317,
				'name' => 'Field And Factory/Oil Palm Plantation Conductor',
				'description' => 'Field And Factory/Oil Palm Plantation Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'id' => 1318,
				'name' => 'Field And Factory/Rubber Plantation Conductor',
				'description' => 'Field And Factory/Rubber Plantation Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'id' => 1319,
				'name' => 'Field Crop Farm Worker',
				'description' => 'Field Crop Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'id' => 1320,
				'name' => 'Field Enumerator',
				'description' => 'Field Enumerator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'id' => 1321,
				'name' => 'Field Marshal',
				'description' => 'Field Marshal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'id' => 1322,
				'name' => 'Filing Clerk',
				'description' => 'Filing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 => 
			array (
				'id' => 1323,
				'name' => 'Filing Clerks Supervisor',
				'description' => 'Filing Clerks Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 => 
			array (
				'id' => 1324,
				'name' => 'Filling/Container Machine Operator',
				'description' => 'Filling/Container Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 => 
			array (
				'id' => 1325,
				'name' => 'Film And Video Editor',
				'description' => 'Film And Video Editor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 => 
			array (
				'id' => 1326,
				'name' => 'Film/Color And Black And White Developer',
				'description' => 'Film/Color And Black And White Developer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 => 
			array (
				'id' => 1327,
				'name' => 'Film Lab C41 Officer',
				'description' => 'Film Lab C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 => 
			array (
				'id' => 1328,
				'name' => 'Film Laboratory C17 Assistant',
				'description' => 'Film Laboratory C17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 => 
			array (
				'id' => 1329,
				'name' => 'Film Laboratory C27 Ssistant Officer',
				'description' => 'Film Laboratory C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 => 
			array (
				'id' => 1330,
				'name' => 'Film Librarian',
				'description' => 'Film Librarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 => 
			array (
				'id' => 1331,
				'name' => 'Film Paper Production Machine Operator',
				'description' => 'Film Paper Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 => 
			array (
				'id' => 1332,
				'name' => 'Film Processing Machine Machine Operator',
				'description' => 'Film Processing Machine Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 => 
			array (
				'id' => 1333,
				'name' => 'Film-Recorder Operator',
				'description' => 'Film-Recorder Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 => 
			array (
				'id' => 1334,
				'name' => 'Film/X-Ray Developer',
				'description' => 'Film/X-Ray Developer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 => 
			array (
				'id' => 1335,
				'name' => 'Filter/Chemical And Related Processes Press-Operator',
				'description' => 'Filter/Chemical And Related Processes Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 => 
			array (
				'id' => 1336,
				'name' => 'Filtering/Clay Press-Operator',
				'description' => 'Filtering/Clay Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 => 
			array (
				'id' => 1337,
				'name' => 'Filtration Attendant',
				'description' => 'Filtration Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 => 
			array (
				'id' => 1338,
				'name' => 'Finance Clerk',
				'description' => 'Finance Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'id' => 1339,
				'name' => 'Finance Executive',
				'description' => 'Finance Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'id' => 1340,
				'name' => 'Finance Manager',
				'description' => 'Finance Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'id' => 1341,
				'name' => 'Finance Statistician',
				'description' => 'Finance Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'id' => 1342,
				'name' => 'Finance W41 Officer',
				'description' => 'Finance W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'id' => 1343,
				'name' => 'Financial Analyst',
				'description' => 'Financial Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'id' => 1344,
				'name' => 'Financial And Institution Manager',
				'description' => 'Financial And Institution Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'id' => 1345,
				'name' => 'Financial And Insurance Branch Manager',
				'description' => 'Financial And Insurance Branch Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'id' => 1346,
				'name' => 'Financial And Investment Adviser',
				'description' => 'Financial And Investment Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'id' => 1347,
				'name' => 'Financial Assistant',
				'description' => 'Financial Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'id' => 1348,
				'name' => 'Financial Controller',
				'description' => 'Financial Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'id' => 1349,
				'name' => 'Financial Planner',
				'description' => 'Financial Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'id' => 1350,
				'name' => 'Financial Supervisor',
				'description' => 'Financial Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 => 
			array (
				'id' => 1351,
				'name' => 'Fine Arts Teacher',
				'description' => 'Fine Arts Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 => 
			array (
				'id' => 1352,
				'name' => 'Fingerprint N17 Inspector',
				'description' => 'Fingerprint N17 Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 => 
			array (
				'id' => 1353,
				'name' => 'Finished Goods Storekeeper',
				'description' => 'Finished Goods Storekeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 => 
			array (
				'id' => 1354,
				'name' => 'Finished Goods Supervisor',
				'description' => 'Finished Goods Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 => 
			array (
				'id' => 1355,
				'name' => 'Finishing/Cast Metal Articles Machine Operator',
				'description' => 'Finishing/Cast Metal Articles Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 => 
			array (
				'id' => 1356,
				'name' => 'Finishing Supervisor',
				'description' => 'Finishing Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 => 
			array (
				'id' => 1357,
				'name' => 'Fire And Rescue Director-General',
				'description' => 'Fire And Rescue Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 => 
			array (
				'id' => 1358,
				'name' => 'Fire And Safety Inspector',
				'description' => 'Fire And Safety Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 => 
			array (
				'id' => 1359,
			'name' => 'Fire-Engine (Bomba) Driver',
			'description' => 'Fire-Engine (Bomba) Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 => 
			array (
				'id' => 1360,
			'name' => 'Fire-Fighter (Air Port)',
			'description' => 'Fire-Fighter (Air Port)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 => 
			array (
				'id' => 1361,
			'name' => 'Fireman (Fire Brigade)',
			'description' => 'Fireman (Fire Brigade)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 => 
			array (
				'id' => 1362,
				'name' => 'Fireman KB17 Officer',
				'description' => 'Fireman KB17 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'id' => 1363,
				'name' => 'Fireman KB29 Ssistant Superintendent',
				'description' => 'Fireman KB29 Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'id' => 1364,
				'name' => 'Fireman KB41 Superintendent',
				'description' => 'Fireman KB41 Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'id' => 1365,
				'name' => 'Fire Prevention Specialist',
				'description' => 'Fire Prevention Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'id' => 1366,
				'name' => 'Fire Watch',
				'description' => 'Fire Watch',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'id' => 1367,
				'name' => 'Fireworks Production Machine Operator',
				'description' => 'Fireworks Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'id' => 1368,
				'name' => 'First Admiral',
				'description' => 'First Admiral',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'id' => 1369,
				'name' => 'Fish Culturist',
				'description' => 'Fish Culturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'id' => 1370,
				'name' => 'Fishery Bacteriologist',
				'description' => 'Fishery Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'id' => 1371,
				'name' => 'Fishery Farm Manager',
				'description' => 'Fishery Farm Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 => 
			array (
				'id' => 1372,
				'name' => 'Fishery G17 Assistant',
				'description' => 'Fishery G17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 => 
			array (
				'id' => 1373,
				'name' => 'Fishery G27 Ssistant Officer',
				'description' => 'Fishery G27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 => 
			array (
				'id' => 1374,
				'name' => 'Fishery G41 Officer',
				'description' => 'Fishery G41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 => 
			array (
				'id' => 1375,
				'name' => 'Fishery Labourer',
				'description' => 'Fishery Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 => 
			array (
				'id' => 1376,
				'name' => 'Fish Farm Worker',
				'description' => 'Fish Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 => 
			array (
				'id' => 1377,
				'name' => 'Fish Grader',
				'description' => 'Fish Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'id' => 1378,
				'name' => 'Fish Meal Production Machine Operator',
				'description' => 'Fish Meal Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'id' => 1379,
				'name' => 'Fishmonger',
				'description' => 'Fishmonger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'id' => 1380,
				'name' => 'Fishmongers And Related Food Preparers Other Butchers',
				'description' => 'Fishmongers And Related Food Preparers Other Butchers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'id' => 1381,
				'name' => 'Fish Processing Machine Operator',
				'description' => 'Fish Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'id' => 1382,
				'name' => 'Fitter Mechanical',
				'description' => 'Fitter Mechanical',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'id' => 1383,
				'name' => 'Flame Cutter',
				'description' => 'Flame Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'id' => 1384,
				'name' => 'Flamecutting/Metal Machine Operator',
				'description' => 'Flamecutting/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'id' => 1385,
				'name' => 'Flayer',
				'description' => 'Flayer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'id' => 1386,
				'name' => 'Flesing/Hide Machine Operator',
				'description' => 'Flesing/Hide Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'id' => 1387,
				'name' => 'Flight Attendant',
				'description' => 'Flight Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'id' => 1388,
				'name' => 'Flight Engineer',
				'description' => 'Flight Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'id' => 1389,
				'name' => 'Flight Instructor',
				'description' => 'Flight Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'id' => 1390,
				'name' => 'Flight Navigator',
				'description' => 'Flight Navigator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'id' => 1391,
				'name' => 'Flight Operation Clerk',
				'description' => 'Flight Operation Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'id' => 1392,
				'name' => 'Flight Steward',
				'description' => 'Flight Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'id' => 1393,
				'name' => 'Flight Stewardess',
				'description' => 'Flight Stewardess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'id' => 1394,
				'name' => 'Float Master',
				'description' => 'Float Master',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'id' => 1395,
				'name' => 'Floor Captain',
				'description' => 'Floor Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'id' => 1396,
				'name' => 'Floor/Hotel And Lodging Steward',
				'description' => 'Floor/Hotel And Lodging Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'id' => 1397,
				'name' => 'Floor/Hotel & Lodging Supervisor',
				'description' => 'Floor/Hotel & Lodging Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'id' => 1398,
				'name' => 'Floor Steward',
				'description' => 'Floor Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'id' => 1399,
				'name' => 'Floriculture Technician',
				'description' => 'Floriculture Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'id' => 1400,
				'name' => 'Floriculturist',
				'description' => 'Floriculturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'id' => 1401,
				'name' => 'Florist',
				'description' => 'Florist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'id' => 1402,
				'name' => 'Flour Blender',
				'description' => 'Flour Blender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'id' => 1403,
				'name' => 'Flower Grower',
				'description' => 'Flower Grower',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'id' => 1404,
				'name' => 'Folding/Cloth Machine Operator',
				'description' => 'Folding/Cloth Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 => 
			array (
				'id' => 1405,
				'name' => 'Food And Beverage Administrative Captain',
				'description' => 'Food And Beverage Administrative Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 => 
			array (
				'id' => 1406,
				'name' => 'Food And Beverage Administrator',
				'description' => 'Food And Beverage Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 => 
			array (
				'id' => 1407,
				'name' => 'Food And Beverage Banquet Worker',
				'description' => 'Food And Beverage Banquet Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 => 
			array (
				'id' => 1408,
				'name' => 'Food And Beverage Barmen',
				'description' => 'Food And Beverage Barmen',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 => 
			array (
				'id' => 1409,
				'name' => 'Food And Beverage Captain',
				'description' => 'Food And Beverage Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 => 
			array (
				'id' => 1410,
				'name' => 'Food And Beverage Cashier',
				'description' => 'Food And Beverage Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 => 
			array (
				'id' => 1411,
				'name' => 'Food And Beverage Coordinator',
				'description' => 'Food And Beverage Coordinator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 => 
			array (
				'id' => 1412,
				'name' => 'Food And Beverage Guest Services Executive',
				'description' => 'Food And Beverage Guest Services Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 => 
			array (
				'id' => 1413,
				'name' => 'Food And Beverage Officer/Executive',
				'description' => 'Food And Beverage Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 => 
			array (
				'id' => 1414,
				'name' => 'Food And Beverage Personnel',
				'description' => 'Food And Beverage Personnel',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 => 
			array (
				'id' => 1415,
				'name' => 'Food And Beverage Room Service Worker',
				'description' => 'Food And Beverage Room Service Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 => 
			array (
				'id' => 1416,
				'name' => 'Food And Beverage Services Manager',
				'description' => 'Food And Beverage Services Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 => 
			array (
				'id' => 1417,
				'name' => 'Food And Beverage Supervisor',
				'description' => 'Food And Beverage Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 => 
			array (
				'id' => 1418,
				'name' => 'Food And Beverage Waiter And Waitress',
				'description' => 'Food And Beverage Waiter And Waitress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 => 
			array (
				'id' => 1419,
				'name' => 'Food And Beverage Worker',
				'description' => 'Food And Beverage Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 => 
			array (
				'id' => 1420,
				'name' => 'Food And Drinks Technologist',
				'description' => 'Food And Drinks Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
				'id' => 1421,
				'name' => 'Food Bacteriologist',
				'description' => 'Food Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'id' => 1422,
				'name' => 'Food Canning & Preserving Cook',
				'description' => 'Food Canning & Preserving Cook',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 => 
			array (
				'id' => 1423,
				'name' => 'Food Chemist',
				'description' => 'Food Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 => 
			array (
				'id' => 1424,
				'name' => 'Food Grader/Taster',
				'description' => 'Food Grader/Taster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 => 
			array (
				'id' => 1425,
				'name' => 'Food Preparer C27 Ssistant Officer',
				'description' => 'Food Preparer C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 => 
			array (
				'id' => 1426,
				'name' => 'Food Processing Technical',
				'description' => 'Food Processing Technical',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 => 
			array (
				'id' => 1427,
				'name' => 'Foodstuffs Dehydrator',
				'description' => 'Foodstuffs Dehydrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 => 
			array (
				'id' => 1428,
				'name' => 'Food Technology C27 Ssistant Officer',
				'description' => 'Food Technology C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 => 
			array (
				'id' => 1429,
				'name' => 'Food Technology C41 Officer',
				'description' => 'Food Technology C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 => 
			array (
				'id' => 1430,
				'name' => 'Footwear/Orthopedic Maker',
				'description' => 'Footwear/Orthopedic Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 => 
			array (
				'id' => 1431,
				'name' => 'Footwear Pattern-Maker',
				'description' => 'Footwear Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'id' => 1432,
				'name' => 'Footwear Production Machine Operator',
				'description' => 'Footwear Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'id' => 1433,
				'name' => 'Footwear Production/Orthopaedic Machine Operator',
				'description' => 'Footwear Production/Orthopaedic Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'id' => 1434,
				'name' => 'Footwear Production/Sports Machine Operator',
				'description' => 'Footwear Production/Sports Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'id' => 1435,
				'name' => 'Footwear Repairer',
				'description' => 'Footwear Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'id' => 1436,
				'name' => 'Footwear/Sports Maker',
				'description' => 'Footwear/Sports Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 => 
			array (
				'id' => 1437,
				'name' => 'Footwear/Surgical Maker',
				'description' => 'Footwear/Surgical Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 => 
			array (
				'id' => 1438,
				'name' => 'Forecaster-Weather',
				'description' => 'Forecaster-Weather',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 => 
			array (
				'id' => 1439,
				'name' => 'Forecaster Weather C17 Assistant',
				'description' => 'Forecaster Weather C17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 => 
			array (
				'id' => 1440,
				'name' => 'Forecaster/Weather C27 Ssistant Officer',
				'description' => 'Forecaster/Weather C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 => 
			array (
				'id' => 1441,
				'name' => 'Foreign Exchange Broker',
				'description' => 'Foreign Exchange Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 => 
			array (
				'id' => 1442,
				'name' => 'Forensic Pathologist',
				'description' => 'Forensic Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 => 
			array (
				'id' => 1443,
				'name' => 'Forest Conservator',
				'description' => 'Forest Conservator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 => 
			array (
				'id' => 1444,
				'name' => 'Forester',
				'description' => 'Forester',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 => 
			array (
				'id' => 1445,
				'name' => 'Forest G17 Ranger',
				'description' => 'Forest G17 Ranger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 => 
			array (
				'id' => 1446,
				'name' => 'Forest G27 Assistant Conservation',
				'description' => 'Forest G27 Assistant Conservation',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 => 
			array (
				'id' => 1447,
				'name' => 'Forest Guard G11',
				'description' => 'Forest Guard G11',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 => 
			array (
				'id' => 1448,
				'name' => 'Forest Ranger',
				'description' => 'Forest Ranger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 => 
			array (
				'id' => 1449,
				'name' => 'Forestry Adviser',
				'description' => 'Forestry Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 => 
			array (
				'id' => 1450,
				'name' => 'Forestry G41 Conservationist',
				'description' => 'Forestry G41 Conservationist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 => 
			array (
				'id' => 1451,
				'name' => 'Forestry Labourer',
				'description' => 'Forestry Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 => 
			array (
				'id' => 1452,
				'name' => 'Forestry Manager',
				'description' => 'Forestry Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 => 
			array (
				'id' => 1453,
				'name' => 'Forestry Officer',
				'description' => 'Forestry Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 => 
			array (
				'id' => 1454,
				'name' => 'Forestry Scientist',
				'description' => 'Forestry Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 => 
			array (
				'id' => 1455,
			'name' => 'Forestry (Skilled) Worker',
			'description' => 'Forestry (Skilled) Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 => 
			array (
				'id' => 1456,
				'name' => 'Forestry Technician',
				'description' => 'Forestry Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 => 
			array (
				'id' => 1457,
				'name' => 'Forging/Metal Machine Operator',
				'description' => 'Forging/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 => 
			array (
				'id' => 1458,
				'name' => 'Forging-Press Operator',
				'description' => 'Forging-Press Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 => 
			array (
				'id' => 1459,
				'name' => 'Forming/Metal Machine Operator',
				'description' => 'Forming/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 => 
			array (
				'id' => 1460,
				'name' => 'Fortune-Teller',
				'description' => 'Fortune-Teller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 => 
			array (
				'id' => 1461,
				'name' => 'Fortune-Tellers And Related Workers Other Astrologers',
				'description' => 'Fortune-Tellers And Related Workers Other Astrologers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 => 
			array (
				'id' => 1462,
				'name' => 'Foundry Core Checker',
				'description' => 'Foundry Core Checker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 => 
			array (
				'id' => 1463,
				'name' => 'Foundry Coremaker, Machine',
				'description' => 'Foundry Coremaker, Machine',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 => 
			array (
				'id' => 1464,
				'name' => 'Foundry Metallurgist',
				'description' => 'Foundry Metallurgist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 => 
			array (
				'id' => 1465,
				'name' => 'Foundry Moulder, Floor',
				'description' => 'Foundry Moulder, Floor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 => 
			array (
				'id' => 1466,
				'name' => 'Foundry Moulder, Pit',
				'description' => 'Foundry Moulder, Pit',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 => 
			array (
				'id' => 1467,
				'name' => 'Foundry Mould Repairer',
				'description' => 'Foundry Mould Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 => 
			array (
				'id' => 1468,
				'name' => 'Fractionation Plant Operator',
				'description' => 'Fractionation Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 => 
			array (
				'id' => 1469,
				'name' => 'Freight Clerk',
				'description' => 'Freight Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 => 
			array (
				'id' => 1470,
				'name' => 'Freight/Despatching Clerk',
				'description' => 'Freight/Despatching Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 => 
			array (
				'id' => 1471,
				'name' => 'Freight/Inward Clerk',
				'description' => 'Freight/Inward Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 => 
			array (
				'id' => 1472,
				'name' => 'Freight/Receiving Clerk',
				'description' => 'Freight/Receiving Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 => 
			array (
				'id' => 1473,
				'name' => 'Freight/Routing Clerk',
				'description' => 'Freight/Routing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 => 
			array (
				'id' => 1474,
				'name' => 'Freight/Traffic Clerk',
				'description' => 'Freight/Traffic Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 => 
			array (
				'id' => 1475,
				'name' => 'Fresh Water Biologist',
				'description' => 'Fresh Water Biologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 => 
			array (
				'id' => 1476,
				'name' => 'Front Desk Manager',
				'description' => 'Front Desk Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 => 
			array (
				'id' => 1477,
				'name' => 'Front Office Assistant',
				'description' => 'Front Office Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 => 
			array (
				'id' => 1478,
				'name' => 'Front Office Assistant Supervisor',
				'description' => 'Front Office Assistant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 => 
			array (
				'id' => 1479,
				'name' => 'Front Office Hotel Manager',
				'description' => 'Front Office Hotel Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 => 
			array (
				'id' => 1480,
				'name' => 'Front Office Officer',
				'description' => 'Front Office Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 => 
			array (
				'id' => 1481,
				'name' => 'Front Office Personnel',
				'description' => 'Front Office Personnel',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 => 
			array (
				'id' => 1482,
				'name' => 'Front Office Receptionist',
				'description' => 'Front Office Receptionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 => 
			array (
				'id' => 1483,
				'name' => 'Front Office Supervisor',
				'description' => 'Front Office Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 => 
			array (
				'id' => 1484,
				'name' => 'Fruit And Nut Trees Farm Worker',
				'description' => 'Fruit And Nut Trees Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 => 
			array (
				'id' => 1485,
				'name' => 'Fruit Juice Maker',
				'description' => 'Fruit Juice Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 => 
			array (
				'id' => 1486,
				'name' => 'Fruit Juice Production Machine Operator',
				'description' => 'Fruit Juice Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 => 
			array (
				'id' => 1487,
				'name' => 'Fruit Preserver',
				'description' => 'Fruit Preserver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'id' => 1488,
				'name' => 'Fruit Press-Operator',
				'description' => 'Fruit Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'id' => 1489,
				'name' => 'Fruit/Vegetable Grader',
				'description' => 'Fruit/Vegetable Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'id' => 1490,
				'name' => 'Fuel Technologist',
				'description' => 'Fuel Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'id' => 1491,
				'name' => 'Fund Manager',
				'description' => 'Fund Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 => 
			array (
				'id' => 1492,
				'name' => 'Funfair Attendant',
				'description' => 'Funfair Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 => 
			array (
				'id' => 1493,
				'name' => 'Furniture Designer',
				'description' => 'Furniture Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 => 
			array (
				'id' => 1494,
				'name' => 'Furniture Mover',
				'description' => 'Furniture Mover',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 => 
			array (
				'id' => 1495,
				'name' => 'Furniture Production Machine Operator',
				'description' => 'Furniture Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 => 
			array (
				'id' => 1496,
				'name' => 'Furniture/Rattan Maker',
				'description' => 'Furniture/Rattan Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 => 
			array (
				'id' => 1497,
				'name' => 'Furniture Upholsterer',
				'description' => 'Furniture Upholsterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 => 
			array (
				'id' => 1498,
				'name' => 'Furniture/Wicker Maker',
				'description' => 'Furniture/Wicker Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 => 
			array (
				'id' => 1499,
				'name' => 'Furniture/Wooden Maker',
				'description' => 'Furniture/Wooden Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 => 
			array (
				'id' => 1500,
				'name' => 'Furriers And Hatters Other Tailors, Dressmakers',
				'description' => 'Furriers And Hatters Other Tailors, Dressmakers',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 1501,
				'name' => 'Galvaniser',
				'description' => 'Galvaniser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 1502,
				'name' => 'Galvanishing/Metal Machine Operator',
				'description' => 'Galvanishing/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 1503,
				'name' => 'Gambling Activities Guard',
				'description' => 'Gambling Activities Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 1504,
				'name' => 'Game Ranger',
				'description' => 'Game Ranger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 1505,
				'name' => 'Gaming Manager',
				'description' => 'Gaming Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 1506,
				'name' => 'Garage Mechanic',
				'description' => 'Garage Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 1507,
				'name' => 'Garbage Disposal Worker',
				'description' => 'Garbage Disposal Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 1508,
				'name' => 'Garbage Systems Manager',
				'description' => 'Garbage Systems Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 1509,
				'name' => 'Gardener',
				'description' => 'Gardener',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 1510,
				'name' => 'Garment Cutter',
				'description' => 'Garment Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 1511,
				'name' => 'Garment Maker',
				'description' => 'Garment Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 1512,
				'name' => 'Garment Pattern-Maker',
				'description' => 'Garment Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 1513,
				'name' => 'Gas Plant Operator',
				'description' => 'Gas Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 1514,
				'name' => 'Gastroenterology Paediatrician',
				'description' => 'Gastroenterology Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 1515,
				'name' => 'Gastroenterology Physician',
				'description' => 'Gastroenterology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 1516,
				'name' => 'Gas Turbine Engineer',
				'description' => 'Gas Turbine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 1517,
				'name' => 'Gate Keeper',
				'description' => 'Gate Keeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 1518,
				'name' => 'Gem Polisher',
				'description' => 'Gem Polisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 1519,
				'name' => 'Gem Setter',
				'description' => 'Gem Setter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 1520,
				'name' => 'Gem Slicer',
				'description' => 'Gem Slicer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 1521,
				'name' => 'Genealogist',
				'description' => 'Genealogist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 1522,
				'name' => 'General',
				'description' => 'General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 1523,
				'name' => 'General Affairs Clerk',
				'description' => 'General Affairs Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 1524,
				'name' => 'General Affairs Section Chief',
				'description' => 'General Affairs Section Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 1525,
				'name' => 'General Amah',
				'description' => 'General Amah',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 1526,
				'name' => 'General Ledger Officer',
				'description' => 'General Ledger Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 1527,
				'name' => 'General Mining Assistant',
				'description' => 'General Mining Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 1528,
				'name' => 'General Office Clerk',
				'description' => 'General Office Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 1529,
			'name' => 'General (PTR) N11 Clerk',
			'description' => 'General (PTR) N11 Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 1530,
				'name' => 'General Radiographer, Medical',
				'description' => 'General Radiographer, Medical',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 1531,
				'name' => 'General Supervisor',
				'description' => 'General Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 1532,
				'name' => 'General Unskill Worker/Labourer',
				'description' => 'General Unskill Worker/Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 1533,
			'name' => 'General Worker/Office Boy (PRAK) R3',
			'description' => 'General Worker/Office Boy (PRAK) R3',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 1534,
			'name' => 'General Worker/Office Boy (PRA) R1',
			'description' => 'General Worker/Office Boy (PRA) R1',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 1535,
				'name' => 'Generator',
				'description' => 'Generator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 1536,
				'name' => 'Geneticist',
				'description' => 'Geneticist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 1537,
				'name' => 'Genetics Engineer',
				'description' => 'Genetics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 1538,
				'name' => 'Genetics Technician',
				'description' => 'Genetics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 1539,
				'name' => 'Geochemist C27 Ssistant Officer',
				'description' => 'Geochemist C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 1540,
				'name' => 'Geochemist C41 Officer',
				'description' => 'Geochemist C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 1541,
				'name' => 'Geodesic Surveyor',
				'description' => 'Geodesic Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 1542,
				'name' => 'Geodesist',
				'description' => 'Geodesist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 1543,
				'name' => 'Geographer',
				'description' => 'Geographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 1544,
				'name' => 'Geological Draughtsperson',
				'description' => 'Geological Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 1545,
				'name' => 'Geological Laboratory Assistant',
				'description' => 'Geological Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 1546,
				'name' => 'Geological Oceanographer',
				'description' => 'Geological Oceanographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 1547,
				'name' => 'Geological Technician',
				'description' => 'Geological Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 1548,
				'name' => 'Geologist',
				'description' => 'Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 1549,
				'name' => 'Geomagnetic Geophysicist',
				'description' => 'Geomagnetic Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 1550,
				'name' => 'Geomagnetician',
				'description' => 'Geomagnetician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 1551,
				'name' => 'Geomorphologies',
				'description' => 'Geomorphologies',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 1552,
				'name' => 'Geomorphology Geophysicist',
				'description' => 'Geomorphology Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 1553,
				'name' => 'Geophysical Oceanographer',
				'description' => 'Geophysical Oceanographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 1554,
				'name' => 'Geophysicist',
				'description' => 'Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 1555,
				'name' => 'Geophysics/Geology C41 Officer',
				'description' => 'Geophysics/Geology C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 1556,
				'name' => 'Geophysics Technician',
				'description' => 'Geophysics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 1557,
				'name' => 'Germination Equipment/Malting Operator',
				'description' => 'Germination Equipment/Malting Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 1558,
			'name' => 'Germination (Malting) Maker',
			'description' => 'Germination (Malting) Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 1559,
				'name' => 'Glass Bender',
				'description' => 'Glass Bender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 1560,
				'name' => 'Glass Blower',
				'description' => 'Glass Blower',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 1561,
				'name' => 'Glass Chemist',
				'description' => 'Glass Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 1562,
				'name' => 'Glass Cutter',
				'description' => 'Glass Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 1563,
				'name' => 'Glass Enameller',
				'description' => 'Glass Enameller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 1564,
				'name' => 'Glass Engraver',
				'description' => 'Glass Engraver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 1565,
				'name' => 'Glass Etcher',
				'description' => 'Glass Etcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 1566,
				'name' => 'Glass-Fibre Production Machine Operator',
				'description' => 'Glass-Fibre Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 1567,
				'name' => 'Glass Finisher',
				'description' => 'Glass Finisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 1568,
				'name' => 'Glass Frame Fabricator',
				'description' => 'Glass Frame Fabricator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 1569,
				'name' => 'Glass Grinder',
				'description' => 'Glass Grinder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 1570,
				'name' => 'Glass Lens Moulder',
				'description' => 'Glass Lens Moulder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 1571,
				'name' => 'Glass Mixer',
				'description' => 'Glass Mixer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 1572,
				'name' => 'Glass N17 Blower',
				'description' => 'Glass N17 Blower',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 1573,
				'name' => 'Glass Painter',
				'description' => 'Glass Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 1574,
				'name' => 'Glass Polisher',
				'description' => 'Glass Polisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 1575,
				'name' => 'Glass Production Furnace-Operator',
				'description' => 'Glass Production Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 1576,
				'name' => 'Glass Sandblaster',
				'description' => 'Glass Sandblaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 1577,
				'name' => 'Glass Technologist',
				'description' => 'Glass Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 1578,
				'name' => 'Glass Temperer',
				'description' => 'Glass Temperer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 1579,
				'name' => 'Glass Tube Maker',
				'description' => 'Glass Tube Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 1580,
				'name' => 'Glaze Maker',
				'description' => 'Glaze Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 1581,
				'name' => 'Glaze Production Machine Operator',
				'description' => 'Glaze Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 1582,
				'name' => 'Gloves Cutter',
				'description' => 'Gloves Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 1583,
				'name' => 'Gloves Pattern-Maker',
				'description' => 'Gloves Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 1584,
				'name' => 'Glue-Mixing Machine Operators',
				'description' => 'Glue-Mixing Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 1585,
				'name' => 'Gold Grader',
				'description' => 'Gold Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 1586,
				'name' => 'Goldsmith',
				'description' => 'Goldsmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 1587,
				'name' => 'Golf Clerk',
				'description' => 'Golf Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 1588,
				'name' => 'Golf Course Worker',
				'description' => 'Golf Course Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 1589,
				'name' => 'Golf Secretary',
				'description' => 'Golf Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 1590,
				'name' => 'Goods/Railway Clerk',
				'description' => 'Goods/Railway Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 1591,
				'name' => 'Goose Farmer',
				'description' => 'Goose Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 1592,
				'name' => 'Government Administration/Deputy Secretary-General',
				'description' => 'Government Administration/Deputy Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 1593,
				'name' => 'Government Administration Executive Secretary',
				'description' => 'Government Administration Executive Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 1594,
				'name' => 'Government Administration Inspector',
				'description' => 'Government Administration Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 1595,
				'name' => 'Government Administration/Regional Director-General',
				'description' => 'Government Administration/Regional Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 1596,
				'name' => 'Government Administration Secretary-General',
				'description' => 'Government Administration Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 1597,
				'name' => 'Government Administrator',
				'description' => 'Government Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 1598,
				'name' => 'Government Chief Secretary',
				'description' => 'Government Chief Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 1599,
				'name' => 'Government Department Director-General',
				'description' => 'Government Department Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 1600,
				'name' => 'Government Department Head',
				'description' => 'Government Department Head',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 1601,
				'name' => 'Government Deputy Secretary',
				'description' => 'Government Deputy Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 1602,
				'name' => 'Government Executive Officer',
				'description' => 'Government Executive Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 1603,
				'name' => 'Government High Commissioner',
				'description' => 'Government High Commissioner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 1604,
				'name' => 'Government Non-Legislative Secretary',
				'description' => 'Government Non-Legislative Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 1605,
				'name' => 'Government Registrar-General',
				'description' => 'Government Registrar-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 1606,
				'name' => 'Government Secretary-General',
				'description' => 'Government Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 1607,
				'name' => 'Government Senior Official',
				'description' => 'Government Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 1608,
				'name' => 'Grab-Bucket Operator',
				'description' => 'Grab-Bucket Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 1609,
				'name' => 'Grader And Scraper/Road Operator',
				'description' => 'Grader And Scraper/Road Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 1610,
				'name' => 'Grading Clerk',
				'description' => 'Grading Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 1611,
				'name' => 'Graduate Teacher Officer',
				'description' => 'Graduate Teacher Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 1612,
				'name' => 'Graffiti Cleaner',
				'description' => 'Graffiti Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 1613,
				'name' => 'Grain Miller',
				'description' => 'Grain Miller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 1614,
				'name' => 'Granite Cutter',
				'description' => 'Granite Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 1615,
				'name' => 'Graphic Artist',
				'description' => 'Graphic Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 1616,
				'name' => 'Graphic Designer',
				'description' => 'Graphic Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 1617,
				'name' => 'Grass Cutter',
				'description' => 'Grass Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 1618,
				'name' => 'Grave-Digger',
				'description' => 'Grave-Digger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 1619,
				'name' => 'Graving Dock Dockmaster',
				'description' => 'Graving Dock Dockmaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 1620,
				'name' => 'Greenhouse Worker',
				'description' => 'Greenhouse Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 1621,
				'name' => 'Grinders And Finishers Other Glass Makers, Cutters',
				'description' => 'Grinders And Finishers Other Glass Makers, Cutters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 1622,
				'name' => 'Grinding/Metal Machine Operator',
				'description' => 'Grinding/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 1623,
				'name' => 'Grinding/Wood Machine Operator',
				'description' => 'Grinding/Wood Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 1624,
				'name' => 'Ground Hostess',
				'description' => 'Ground Hostess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 1625,
				'name' => 'Ground Maintenance Worker',
				'description' => 'Ground Maintenance Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 1626,
				'name' => 'Groundnut Farm Worker',
				'description' => 'Groundnut Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 1627,
				'name' => 'Group Accountant',
				'description' => 'Group Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 1628,
				'name' => 'Group Work Social Worker',
				'description' => 'Group Work Social Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 1629,
				'name' => 'Guard',
				'description' => 'Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 1630,
				'name' => 'Guest-House Manager',
				'description' => 'Guest-House Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 1631,
				'name' => 'Guest Service Agent',
				'description' => 'Guest Service Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 1632,
				'name' => 'Guest Service Officer',
				'description' => 'Guest Service Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 1633,
				'name' => 'Guide Setter',
				'description' => 'Guide Setter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 1634,
				'name' => 'Gunsmith',
				'description' => 'Gunsmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 1635,
				'name' => 'Haematology Paediatrician',
				'description' => 'Haematology Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 1636,
				'name' => 'Haematology Physician',
				'description' => 'Haematology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 1637,
				'name' => 'Haematology Technician',
				'description' => 'Haematology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 1638,
				'name' => 'Hairdresser',
				'description' => 'Hairdresser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 1639,
				'name' => 'Hairstylist',
				'description' => 'Hairstylist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 1640,
				'name' => 'Halogen Gas Production Machine Operator',
				'description' => 'Halogen Gas Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 1641,
				'name' => 'Hammersmith',
				'description' => 'Hammersmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 1642,
				'name' => 'Hammersmith And Forging-Press Workers Other Blacksmith',
				'description' => 'Hammersmith And Forging-Press Workers Other Blacksmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 1643,
				'name' => 'Hand/Braid Maker',
				'description' => 'Hand/Braid Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 1644,
				'name' => 'Hand/Carton And Paper Box Maker',
				'description' => 'Hand/Carton And Paper Box Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 1645,
				'name' => 'Hand/Cloth Weaver',
				'description' => 'Hand/Cloth Weaver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 1646,
				'name' => 'Hand Crocheter',
				'description' => 'Hand Crocheter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 1647,
				'name' => 'Hand/Dish Washer',
				'description' => 'Hand/Dish Washer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 1648,
				'name' => 'Hand Dry-Cleaner',
				'description' => 'Hand Dry-Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 1649,
				'name' => 'Hand Embroiderer',
				'description' => 'Hand Embroiderer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 1650,
				'name' => 'Hand Knitter',
				'description' => 'Hand Knitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 1651,
				'name' => 'Hand Labeller',
				'description' => 'Hand Labeller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 1652,
				'name' => 'Hand Lacer',
				'description' => 'Hand Lacer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 1653,
				'name' => 'Hand Loom Threader',
				'description' => 'Hand Loom Threader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 1654,
				'name' => 'Hand/Manufacturing Washer',
				'description' => 'Hand/Manufacturing Washer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 1655,
				'name' => 'Hand/Net Maker',
				'description' => 'Hand/Net Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 1656,
				'name' => 'Hand Packer',
				'description' => 'Hand Packer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 1657,
				'name' => 'Hand Presser',
				'description' => 'Hand Presser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 1658,
				'name' => 'Hand/Vehicle Washer',
				'description' => 'Hand/Vehicle Washer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 1659,
				'name' => 'Handwriting Expert',
				'description' => 'Handwriting Expert',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 1660,
				'name' => 'Handyman',
				'description' => 'Handyman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 1661,
				'name' => 'Handyperson',
				'description' => 'Handyperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 1662,
				'name' => 'Harbour Manager',
				'description' => 'Harbour Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 1663,
				'name' => 'Harbour Master',
				'description' => 'Harbour Master',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 1664,
				'name' => 'Hardening/Metal Furnace-Operator',
				'description' => 'Hardening/Metal Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 1665,
			'name' => 'Harvester (Padi) Operator',
			'description' => 'Harvester (Padi) Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 1666,
				'name' => 'Hat And Cap Pattern-Maker',
				'description' => 'Hat And Cap Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 1667,
				'name' => 'Hatchery/Prawn Supervisor',
				'description' => 'Hatchery/Prawn Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 1668,
				'name' => 'Hatchery/Prawn Technician',
				'description' => 'Hatchery/Prawn Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 1669,
				'name' => 'Hat Maker',
				'description' => 'Hat Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 1670,
				'name' => 'Hat Making Machine Operator',
				'description' => 'Hat Making Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 1671,
			'name' => 'Hawker (Except Prepared Food Or Drinks)',
			'description' => 'Hawker (Except Prepared Food Or Drinks)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 1672,
			'name' => 'Hawker (Prepared Food And Drinks)',
			'description' => 'Hawker (Prepared Food And Drinks)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 1673,
			'name' => 'Hawker (Prepared Food And Non-Food)',
			'description' => 'Hawker (Prepared Food And Non-Food)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 1674,
				'name' => 'Head Checker Cashier',
				'description' => 'Head Checker Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 1675,
				'name' => 'Headmaster',
				'description' => 'Headmaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 1676,
				'name' => 'Headmistress',
				'description' => 'Headmistress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 1677,
				'name' => 'Head Waiter',
				'description' => 'Head Waiter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 1678,
				'name' => 'Head Waitress',
				'description' => 'Head Waitress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 1679,
				'name' => 'Health And Safety Technician',
				'description' => 'Health And Safety Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 1680,
				'name' => 'Health Associate Professionals Not Elsewhere Classified',
				'description' => 'Health Associate Professionals Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 1681,
				'name' => 'Health Educator',
				'description' => 'Health Educator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 1682,
				'name' => 'Health Manager',
				'description' => 'Health Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 1683,
				'name' => 'Health Officer',
				'description' => 'Health Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 1684,
				'name' => 'Health Statistician',
				'description' => 'Health Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 1685,
				'name' => 'Health U1 Attendant',
				'description' => 'Health U1 Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 1686,
				'name' => 'Health U41 Instructor',
				'description' => 'Health U41 Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 1687,
				'name' => 'Hearing Aid Assembler',
				'description' => 'Hearing Aid Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 1688,
				'name' => 'Heart Specialist',
				'description' => 'Heart Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 1689,
				'name' => 'Heating And Ventilation Equipment Operator',
				'description' => 'Heating And Ventilation Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 1690,
				'name' => 'Heat Physicist',
				'description' => 'Heat Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 1691,
				'name' => 'Heat-Treating/Metal Furnace-Operator',
				'description' => 'Heat-Treating/Metal Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 1692,
				'name' => 'Heat-Treating Plant/Chemical And Related Process Operator',
				'description' => 'Heat-Treating Plant/Chemical And Related Process Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 1693,
				'name' => 'Heavecrumb Process Worker',
				'description' => 'Heavecrumb Process Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 1694,
				'name' => 'Helicopter Pilot',
				'description' => 'Helicopter Pilot',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 1695,
			'name' => 'Helicopter) Royal Malaysian Air Force Pilot (Fighter, Transport',
			'description' => 'Helicopter) Royal Malaysian Air Force Pilot (Fighter, Transport',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 1696,
				'name' => 'Helmsman',
				'description' => 'Helmsman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 1697,
				'name' => 'Help Desk Technician',
				'description' => 'Help Desk Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 1698,
				'name' => 'Hepatic Surgeon',
				'description' => 'Hepatic Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 1699,
				'name' => 'Herbs & Vegetables Gatherer, Wild Fruits',
				'description' => 'Herbs & Vegetables Gatherer, Wild Fruits',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 1700,
				'name' => 'Herpetologist',
				'description' => 'Herpetologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 1701,
				'name' => 'Hide Processing Machine Operator',
				'description' => 'Hide Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 1702,
				'name' => 'High Court Judge',
				'description' => 'High Court Judge',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 1703,
				'name' => 'Higher Learning Education Services DH41 Officer',
				'description' => 'Higher Learning Education Services DH41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 1704,
				'name' => 'High Voltage/Restriction Chargeman',
				'description' => 'High Voltage/Restriction Chargeman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 1705,
				'name' => 'Histologist',
				'description' => 'Histologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 1706,
				'name' => 'Histology Botanist',
				'description' => 'Histology Botanist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 1707,
				'name' => 'Histology Technician',
				'description' => 'Histology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 1708,
				'name' => 'Histology Zoologist',
				'description' => 'Histology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 1709,
				'name' => 'Histopathologist',
				'description' => 'Histopathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 1710,
				'name' => 'Histopathology Pathologist',
				'description' => 'Histopathology Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 1711,
				'name' => 'Historian',
				'description' => 'Historian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 1712,
				'name' => 'Historian And Political Scientists Other Philosopher',
				'description' => 'Historian And Political Scientists Other Philosopher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 1713,
				'name' => 'Hod Carrier',
				'description' => 'Hod Carrier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 1714,
				'name' => 'Hoist And Related Plant Operators Other Crane',
				'description' => 'Hoist And Related Plant Operators Other Crane',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 1715,
				'name' => 'Hoisting Equipment/Construction Rigger',
				'description' => 'Hoisting Equipment/Construction Rigger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 1716,
				'name' => 'Hoisting Equipment Rigger',
				'description' => 'Hoisting Equipment Rigger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 1717,
				'name' => 'Hoist Operator',
				'description' => 'Hoist Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 1718,
				'name' => 'Home Economics Teacher',
				'description' => 'Home Economics Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 1719,
				'name' => 'Home Economist',
				'description' => 'Home Economist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 1720,
				'name' => 'Homeopath',
				'description' => 'Homeopath',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 1721,
				'name' => 'Honey Collector',
				'description' => 'Honey Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 1722,
				'name' => 'Honing Machine Setter-Operator',
				'description' => 'Honing Machine Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 1723,
				'name' => 'Hopper Operator',
				'description' => 'Hopper Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 1724,
				'name' => 'Horse Riding Instructor',
				'description' => 'Horse Riding Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 1725,
				'name' => 'Horse Trainer',
				'description' => 'Horse Trainer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 1726,
				'name' => 'Horticultural',
				'description' => 'Horticultural',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 1727,
				'name' => 'Horticultural And Nursery Growers Other Gardeners',
				'description' => 'Horticultural And Nursery Growers Other Gardeners',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 1728,
				'name' => 'Horticultural Grower',
				'description' => 'Horticultural Grower',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 1729,
				'name' => 'Horticulture Technician',
				'description' => 'Horticulture Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 1730,
				'name' => 'Hose Maker',
				'description' => 'Hose Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 1731,
				'name' => 'Hospital Administrator',
				'description' => 'Hospital Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 1732,
				'name' => 'Hospital Admissions Clerk',
				'description' => 'Hospital Admissions Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 1733,
				'name' => 'Hospital Admitting Clerks Supervisor',
				'description' => 'Hospital Admitting Clerks Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 1734,
				'name' => 'Hospital Aid',
				'description' => 'Hospital Aid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 1735,
				'name' => 'Hospital Assistant',
				'description' => 'Hospital Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 1736,
				'name' => 'Hospital Attendant',
				'description' => 'Hospital Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 1737,
				'name' => 'Hospital Dietician',
				'description' => 'Hospital Dietician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 1738,
				'name' => 'Hospital Pharmacist',
				'description' => 'Hospital Pharmacist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 1739,
				'name' => 'Hospital Worker',
				'description' => 'Hospital Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 1740,
				'name' => 'Hostel Manager',
				'description' => 'Hostel Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 1741,
				'name' => 'Hostel N17 Supervisor',
				'description' => 'Hostel N17 Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 1742,
				'name' => 'Hostel N27 Assistant Manager',
				'description' => 'Hostel N27 Assistant Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 1743,
				'name' => 'Hostel N41 Manager',
				'description' => 'Hostel N41 Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 1744,
				'name' => 'Hostel Warden',
				'description' => 'Hostel Warden',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 1745,
				'name' => 'Hot-Dip Plater',
				'description' => 'Hot-Dip Plater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 1746,
				'name' => 'Hotel And Lodging Bell Captain',
				'description' => 'Hotel And Lodging Bell Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 1747,
				'name' => 'Hotel And Other Other Cleaning And Housekeeping Supervisors In Offices',
				'description' => 'Hotel And Other Other Cleaning And Housekeeping Supervisors In Offices',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 1748,
				'name' => 'Hotel/Bellman Porter',
				'description' => 'Hotel/Bellman Porter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 1749,
				'name' => 'Hotel Chief Steward',
				'description' => 'Hotel Chief Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 1750,
				'name' => 'Hotel/Club/Cafe Cleaner',
				'description' => 'Hotel/Club/Cafe Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 1751,
				'name' => 'Hotel Detective',
				'description' => 'Hotel Detective',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 1752,
				'name' => 'Hotel Front Desk Clerk',
				'description' => 'Hotel Front Desk Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 1753,
				'name' => 'Hotel Housekeeper',
				'description' => 'Hotel Housekeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 1754,
				'name' => 'Hotel Manager',
				'description' => 'Hotel Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 1755,
				'name' => 'Hotel Operations Executive',
				'description' => 'Hotel Operations Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 1756,
				'name' => 'Hotel Receptionist',
				'description' => 'Hotel Receptionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 1757,
				'name' => 'Hotels And Catering Services Cook',
				'description' => 'Hotels And Catering Services Cook',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 1758,
				'name' => 'Hotels And Other Establishments Other Cleaners And Helpers In Offices',
				'description' => 'Hotels And Other Establishments Other Cleaners And Helpers In Offices',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 1759,
				'name' => 'House Cleaner',
				'description' => 'House Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 1760,
				'name' => 'House Helper',
				'description' => 'House Helper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 1761,
				'name' => 'Household Appliance Electrical Repairman',
				'description' => 'Household Appliance Electrical Repairman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 1762,
				'name' => 'Housekeeper Assistant',
				'description' => 'Housekeeper Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 1763,
				'name' => 'Housekeeper Executive',
				'description' => 'Housekeeper Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 1764,
			'name' => 'Housekeeper (Private Service)',
			'description' => 'Housekeeper (Private Service)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 1765,
				'name' => 'Housekeeping Administrator',
				'description' => 'Housekeeping Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 1766,
				'name' => 'Housekeeping Assistant Supervisor',
				'description' => 'Housekeeping Assistant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 1767,
				'name' => 'Housekeeping Matron',
				'description' => 'Housekeeping Matron',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 1768,
				'name' => 'Housekeeping Room Assistant',
				'description' => 'Housekeeping Room Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 1769,
				'name' => 'Housekeeping Supervisor',
				'description' => 'Housekeeping Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 1770,
				'name' => 'Housekeeping Worker',
				'description' => 'Housekeeping Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 1771,
				'name' => 'Housemaid',
				'description' => 'Housemaid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 1772,
				'name' => 'House Steward',
				'description' => 'House Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 1773,
				'name' => 'House/Traditional Materials Builder',
				'description' => 'House/Traditional Materials Builder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 1774,
				'name' => 'Hovercraft Architect',
				'description' => 'Hovercraft Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 1775,
				'name' => 'Hovercraft Conductor',
				'description' => 'Hovercraft Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 1776,
				'name' => 'Hovercraft Pilot',
				'description' => 'Hovercraft Pilot',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 1777,
				'name' => 'Humanitarian Organization Secretary-General',
				'description' => 'Humanitarian Organization Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 1778,
				'name' => 'Humanitarian Organization Senior Official',
				'description' => 'Humanitarian Organization Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 1779,
				'name' => 'Human Resource Clerk',
				'description' => 'Human Resource Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 1780,
				'name' => 'Human Resource Officer/Executive',
				'description' => 'Human Resource Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 1781,
				'name' => 'Human Resource/Personnel Manager',
				'description' => 'Human Resource/Personnel Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 1782,
				'name' => 'Human Resource Supervisor',
				'description' => 'Human Resource Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 1783,
				'name' => 'Human Resource/Training Manager',
				'description' => 'Human Resource/Training Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 1784,
				'name' => 'Human Rights Organization Secretary-General',
				'description' => 'Human Rights Organization Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 1785,
				'name' => 'Humorist',
				'description' => 'Humorist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 1786,
				'name' => 'Hunter And Trapper',
				'description' => 'Hunter And Trapper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 1787,
				'name' => 'Hunting Labourer',
				'description' => 'Hunting Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 1788,
				'name' => 'Hydraulic Hose Technician',
				'description' => 'Hydraulic Hose Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 1789,
				'name' => 'Hydrobiologist',
				'description' => 'Hydrobiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 1790,
				'name' => 'Hydrodynamics',
				'description' => 'Hydrodynamics',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 1791,
				'name' => 'Hydrodynamics Physicist',
				'description' => 'Hydrodynamics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 1792,
				'name' => 'Hydroelectric Station Operator',
				'description' => 'Hydroelectric Station Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 1793,
				'name' => 'Hydrogen Gas Production Machine Operator',
				'description' => 'Hydrogen Gas Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 1794,
				'name' => 'Hydrogeologist',
				'description' => 'Hydrogeologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 1795,
				'name' => 'Hydrographic Surveyor',
				'description' => 'Hydrographic Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 1796,
				'name' => 'Hydrologist',
				'description' => 'Hydrologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 1797,
				'name' => 'Hydrology Geophysicist',
				'description' => 'Hydrology Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 1798,
				'name' => 'Hydroponics Worker',
				'description' => 'Hydroponics Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 1799,
				'name' => 'Ice-Cream Peddler',
				'description' => 'Ice-Cream Peddler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 1800,
				'name' => 'Ice-Cream Production Machine Operator',
				'description' => 'Ice-Cream Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 1801,
				'name' => 'Ice Production Machine Operator',
				'description' => 'Ice Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 1802,
				'name' => 'Ice-Skating Rink Manager',
				'description' => 'Ice-Skating Rink Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 1803,
				'name' => 'Ichthyologist',
				'description' => 'Ichthyologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 1804,
				'name' => 'Ichthyology Zoologist',
				'description' => 'Ichthyology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 1805,
				'name' => 'ICT Security Specialist',
				'description' => 'ICT Security Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 1806,
				'name' => 'Imam',
				'description' => 'Imam',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 1807,
				'name' => 'Immigration KP17 Officer',
				'description' => 'Immigration KP17 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 1808,
				'name' => 'Immigration KP27 Ssistant Superintendent',
				'description' => 'Immigration KP27 Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 1809,
				'name' => 'Immunologist',
				'description' => 'Immunologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 1810,
				'name' => 'Impersonator',
				'description' => 'Impersonator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 1811,
				'name' => 'Import-Export Clerk',
				'description' => 'Import-Export Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 1812,
				'name' => 'Incinerator Plant Operator',
				'description' => 'Incinerator Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 1813,
			'name' => 'Incising (Wood Preserving) Machine Operator',
			'description' => 'Incising (Wood Preserving) Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 1814,
				'name' => 'Incubator Operator',
				'description' => 'Incubator Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'id' => 1815,
				'name' => 'Index Clerk',
				'description' => 'Index Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'id' => 1816,
			'name' => 'Indian Traditional Medicine (Ayurvedic) Physician',
			'description' => 'Indian Traditional Medicine (Ayurvedic) Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'id' => 1817,
			'name' => 'Indian Traditional Medicine (Homeopathic) Physician',
			'description' => 'Indian Traditional Medicine (Homeopathic) Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'id' => 1818,
				'name' => 'Industrial Bacteriologist',
				'description' => 'Industrial Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'id' => 1819,
				'name' => 'Industrial Chemist',
				'description' => 'Industrial Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'id' => 1820,
				'name' => 'Industrial Efficiency Engineer',
				'description' => 'Industrial Efficiency Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'id' => 1821,
				'name' => 'Industrial Engineer',
				'description' => 'Industrial Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'id' => 1822,
				'name' => 'Industrial Health And Safety Engineer',
				'description' => 'Industrial Health And Safety Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 => 
			array (
				'id' => 1823,
				'name' => 'Industrial Health Engineer',
				'description' => 'Industrial Health Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 => 
			array (
				'id' => 1824,
				'name' => 'Industrial Investigator',
				'description' => 'Industrial Investigator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 => 
			array (
				'id' => 1825,
				'name' => 'Industrial Layout Engineer',
				'description' => 'Industrial Layout Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 => 
			array (
				'id' => 1826,
				'name' => 'Industrial Machinery And Tools Engineer',
				'description' => 'Industrial Machinery And Tools Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 => 
			array (
				'id' => 1827,
				'name' => 'Industrial Machinery Assembler',
				'description' => 'Industrial Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 => 
			array (
				'id' => 1828,
				'name' => 'Industrial Machinery Mechanic',
				'description' => 'Industrial Machinery Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 => 
			array (
				'id' => 1829,
				'name' => 'Industrial Nurse',
				'description' => 'Industrial Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 => 
			array (
				'id' => 1830,
				'name' => 'Industrial Pharmacist',
				'description' => 'Industrial Pharmacist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 => 
			array (
				'id' => 1831,
				'name' => 'Industrial Products Designer',
				'description' => 'Industrial Products Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 => 
			array (
				'id' => 1832,
				'name' => 'Industrial Relation N17 Assistant',
				'description' => 'Industrial Relation N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 => 
			array (
				'id' => 1833,
				'name' => 'Industrial Relation S27 Ssistant Officer',
				'description' => 'Industrial Relation S27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 => 
			array (
				'id' => 1834,
				'name' => 'Industrial Relations Manager',
				'description' => 'Industrial Relations Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 => 
			array (
				'id' => 1835,
				'name' => 'Industrial Relations Officer',
				'description' => 'Industrial Relations Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 => 
			array (
				'id' => 1836,
				'name' => 'Industrial Relations S41 Officer',
				'description' => 'Industrial Relations S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 => 
			array (
				'id' => 1837,
				'name' => 'Industrial Safety Engineer',
				'description' => 'Industrial Safety Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 => 
			array (
				'id' => 1838,
				'name' => 'Industry Welfare Officer',
				'description' => 'Industry Welfare Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'id' => 1839,
				'name' => 'Inflatable Worker',
				'description' => 'Inflatable Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'id' => 1840,
			'name' => 'Information And Communications Technology (ICT) Sales Professionals',
			'description' => 'Information And Communications Technology (ICT) Sales Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'id' => 1841,
				'name' => 'Information Clerk',
				'description' => 'Information Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'id' => 1842,
				'name' => 'Information S17 Assistant',
				'description' => 'Information S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'id' => 1843,
				'name' => 'Information S27 Ssistant Officer',
				'description' => 'Information S27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'id' => 1844,
				'name' => 'Information S41 Officer',
				'description' => 'Information S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'id' => 1845,
				'name' => 'Information System Officer',
				'description' => 'Information System Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'id' => 1846,
				'name' => 'Information Systems Manager',
				'description' => 'Information Systems Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'id' => 1847,
				'name' => 'Information Systems Technician',
				'description' => 'Information Systems Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'id' => 1848,
				'name' => 'Information Technology Assistant',
				'description' => 'Information Technology Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'id' => 1849,
				'name' => 'Information Technology Clerk',
				'description' => 'Information Technology Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'id' => 1850,
				'name' => 'Information Technology Consultant',
				'description' => 'Information Technology Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 => 
			array (
				'id' => 1851,
				'name' => 'Information Technology F29 Ssistant Officer',
				'description' => 'Information Technology F29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 => 
			array (
				'id' => 1852,
				'name' => 'Information Technology F41 Officer',
				'description' => 'Information Technology F41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 => 
			array (
				'id' => 1853,
			'name' => 'Information Technology (IT) Engineer',
			'description' => 'Information Technology (IT) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 => 
			array (
				'id' => 1854,
				'name' => 'Information Technology Manager',
				'description' => 'Information Technology Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 => 
			array (
				'id' => 1855,
				'name' => 'Information Technology Programmer',
				'description' => 'Information Technology Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 => 
			array (
				'id' => 1856,
				'name' => 'Information Technology Researcher',
				'description' => 'Information Technology Researcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 => 
			array (
				'id' => 1857,
				'name' => 'Information Technology Ssistant Officer',
				'description' => 'Information Technology Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 => 
			array (
				'id' => 1858,
				'name' => 'Information Technology Support Officer',
				'description' => 'Information Technology Support Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 => 
			array (
				'id' => 1859,
				'name' => 'Information Technology Technician',
				'description' => 'Information Technology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 => 
			array (
				'id' => 1860,
				'name' => 'Ingredients Weigher',
				'description' => 'Ingredients Weigher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 => 
			array (
				'id' => 1861,
				'name' => 'Injection Moulding/Plastics Machine Operator',
				'description' => 'Injection Moulding/Plastics Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 => 
			array (
				'id' => 1862,
				'name' => 'Inland Fishery Worker',
				'description' => 'Inland Fishery Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'id' => 1863,
				'name' => 'Inland Revenue Director-General',
				'description' => 'Inland Revenue Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'id' => 1864,
				'name' => 'Inorganic Chemist',
				'description' => 'Inorganic Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'id' => 1865,
				'name' => 'Inquiries Clerk',
				'description' => 'Inquiries Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'id' => 1866,
				'name' => 'Inspector Clerical/Railway Transport Service',
				'description' => 'Inspector Clerical/Railway Transport Service',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'id' => 1867,
				'name' => 'Instructors And Officials Other Sports Coaches',
				'description' => 'Instructors And Officials Other Sports Coaches',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'id' => 1868,
				'name' => 'Instrumentalist',
				'description' => 'Instrumentalist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'id' => 1869,
				'name' => 'Instrument/Meteorological Maker',
				'description' => 'Instrument/Meteorological Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'id' => 1870,
				'name' => 'Instrument/Nautical Maker',
				'description' => 'Instrument/Nautical Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'id' => 1871,
				'name' => 'Instrument/Optical Maker And Repairer',
				'description' => 'Instrument/Optical Maker And Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 => 
			array (
				'id' => 1872,
				'name' => 'Instrument/Precision Maker And Repairer',
				'description' => 'Instrument/Precision Maker And Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 => 
			array (
				'id' => 1873,
				'name' => 'Instrument/Scientific Maker',
				'description' => 'Instrument/Scientific Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 => 
			array (
				'id' => 1874,
				'name' => 'Instrument/Surgical Maker',
				'description' => 'Instrument/Surgical Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 => 
			array (
				'id' => 1875,
				'name' => 'Insulating Machine Operator',
				'description' => 'Insulating Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 => 
			array (
				'id' => 1876,
				'name' => 'Insulation Machine Operator',
				'description' => 'Insulation Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 => 
			array (
				'id' => 1877,
				'name' => 'Insurance Adjuster',
				'description' => 'Insurance Adjuster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'id' => 1878,
				'name' => 'Insurance/Adjustment Assistant',
				'description' => 'Insurance/Adjustment Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'id' => 1879,
				'name' => 'Insurance Agent',
				'description' => 'Insurance Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'id' => 1880,
				'name' => 'Insurance Assessor',
				'description' => 'Insurance Assessor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'id' => 1881,
				'name' => 'Insurance Broker',
				'description' => 'Insurance Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'id' => 1882,
				'name' => 'Insurance Claims Arbitrator',
				'description' => 'Insurance Claims Arbitrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'id' => 1883,
				'name' => 'Insurance/Claims Assistant',
				'description' => 'Insurance/Claims Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'id' => 1884,
				'name' => 'Insurance Manager',
				'description' => 'Insurance Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'id' => 1885,
				'name' => 'Insurance/Policy Assistant',
				'description' => 'Insurance/Policy Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'id' => 1886,
				'name' => 'Insurance Underwriter',
				'description' => 'Insurance Underwriter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'id' => 1887,
				'name' => 'Insurance/Underwriting Assistant',
				'description' => 'Insurance/Underwriting Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'id' => 1888,
				'name' => 'Insurance/Underwriting Assistant Supervisor',
				'description' => 'Insurance/Underwriting Assistant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'id' => 1889,
				'name' => 'Insurance Underwriting Clerk',
				'description' => 'Insurance Underwriting Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'id' => 1890,
				'name' => 'Intelligence Officer',
				'description' => 'Intelligence Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'id' => 1891,
				'name' => 'Interior Architect',
				'description' => 'Interior Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'id' => 1892,
				'name' => 'Interior Decoration Designer',
				'description' => 'Interior Decoration Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'id' => 1893,
				'name' => 'Interior Decorator',
				'description' => 'Interior Decorator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'id' => 1894,
				'name' => 'Internal Combustion Engine Engineer',
				'description' => 'Internal Combustion Engine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'id' => 1895,
				'name' => 'Internal Medicine Physician',
				'description' => 'Internal Medicine Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'id' => 1896,
				'name' => 'Internal Security Guard',
				'description' => 'Internal Security Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'id' => 1897,
				'name' => 'Interpreter',
				'description' => 'Interpreter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'id' => 1898,
				'name' => 'Interpreter L17',
				'description' => 'Interpreter L17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'id' => 1899,
				'name' => 'Interventional Radiologist',
				'description' => 'Interventional Radiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'id' => 1900,
				'name' => 'Inventory Clerk',
				'description' => 'Inventory Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'id' => 1901,
				'name' => 'Inventory Purchasing Clerk',
				'description' => 'Inventory Purchasing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'id' => 1902,
				'name' => 'Investigation KR17 Assistant',
				'description' => 'Investigation KR17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'id' => 1903,
				'name' => 'Investigation KR29 Ssistant Officer',
				'description' => 'Investigation KR29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'id' => 1904,
				'name' => 'Investigation KR41 Officer',
				'description' => 'Investigation KR41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 => 
			array (
				'id' => 1905,
				'name' => 'Investment Broker',
				'description' => 'Investment Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 => 
			array (
				'id' => 1906,
				'name' => 'Investment Clerk',
				'description' => 'Investment Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 => 
			array (
				'id' => 1907,
				'name' => 'Ironing',
				'description' => 'Ironing',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 => 
			array (
				'id' => 1908,
				'name' => 'Iron Reinforcing Worker',
				'description' => 'Iron Reinforcing Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 => 
			array (
				'id' => 1909,
				'name' => 'Irrigator',
				'description' => 'Irrigator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 => 
			array (
				'id' => 1910,
				'name' => 'Islamic Affair Officer',
				'description' => 'Islamic Affair Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 => 
			array (
				'id' => 1911,
				'name' => 'Islamic Affairs S11 Junior Assistant',
				'description' => 'Islamic Affairs S11 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 => 
			array (
				'id' => 1912,
				'name' => 'Islamic Affairs S17 Assistant',
				'description' => 'Islamic Affairs S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 => 
			array (
				'id' => 1913,
				'name' => 'Islamic Affairs S27 Ssistant Officer',
				'description' => 'Islamic Affairs S27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 => 
			array (
				'id' => 1914,
				'name' => 'Islamic Religion Teacher',
				'description' => 'Islamic Religion Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 => 
			array (
				'id' => 1915,
				'name' => 'IT Support Worker',
				'description' => 'IT Support Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 => 
			array (
				'id' => 1916,
				'name' => 'Jacquard Card Cutter',
				'description' => 'Jacquard Card Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 => 
			array (
				'id' => 1917,
			'name' => 'Jam (Machine) Maker',
			'description' => 'Jam (Machine) Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 => 
			array (
				'id' => 1918,
				'name' => 'Janitor',
				'description' => 'Janitor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 => 
			array (
				'id' => 1919,
				'name' => 'Janitor Cleaner',
				'description' => 'Janitor Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 => 
			array (
				'id' => 1920,
				'name' => 'Jelutong Collector',
				'description' => 'Jelutong Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
				'id' => 1921,
				'name' => 'Jet Engine Engineer',
				'description' => 'Jet Engine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'id' => 1922,
				'name' => 'Jetty Attendant',
				'description' => 'Jetty Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 => 
			array (
				'id' => 1923,
				'name' => 'Jetty N3 Supervisor',
				'description' => 'Jetty N3 Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 => 
			array (
				'id' => 1924,
				'name' => 'Jeweller',
				'description' => 'Jeweller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 => 
			array (
				'id' => 1925,
				'name' => 'Jewellery Designer',
				'description' => 'Jewellery Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 => 
			array (
				'id' => 1926,
				'name' => 'Jewellery Enameller',
				'description' => 'Jewellery Enameller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 => 
			array (
				'id' => 1927,
				'name' => 'Jewellery Engraver',
				'description' => 'Jewellery Engraver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 => 
			array (
				'id' => 1928,
				'name' => 'Jewellery Production Machine Operator',
				'description' => 'Jewellery Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 => 
			array (
				'id' => 1929,
				'name' => 'Jewellery Repairer',
				'description' => 'Jewellery Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 => 
			array (
				'id' => 1930,
				'name' => 'Jig And Fixture Maker',
				'description' => 'Jig And Fixture Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 => 
			array (
				'id' => 1931,
				'name' => 'Jig Tender',
				'description' => 'Jig Tender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'id' => 1932,
				'name' => 'Jig & Tool Draughtsperson',
				'description' => 'Jig & Tool Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'id' => 1933,
				'name' => 'Job Analyst',
				'description' => 'Job Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'id' => 1934,
				'name' => 'Jobber',
				'description' => 'Jobber',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'id' => 1935,
				'name' => 'Job Evaluator',
				'description' => 'Job Evaluator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'id' => 1936,
				'name' => 'Job Placement Officer',
				'description' => 'Job Placement Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 => 
			array (
				'id' => 1937,
				'name' => 'Jockey',
				'description' => 'Jockey',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 => 
			array (
				'id' => 1938,
				'name' => 'Joss Paper Production Machine Operator',
				'description' => 'Joss Paper Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 => 
			array (
				'id' => 1939,
				'name' => 'Journalist',
				'description' => 'Journalist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 => 
			array (
				'id' => 1940,
				'name' => 'Journalist S41',
				'description' => 'Journalist S41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 => 
			array (
				'id' => 1941,
				'name' => 'Judge’S Clerk',
				'description' => 'Judge’S Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 => 
			array (
				'id' => 1942,
				'name' => 'Juggler',
				'description' => 'Juggler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 => 
			array (
				'id' => 1943,
				'name' => 'Juice Taster',
				'description' => 'Juice Taster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 => 
			array (
				'id' => 1944,
				'name' => 'Junior Able Seaman',
				'description' => 'Junior Able Seaman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 => 
			array (
				'id' => 1945,
				'name' => 'Junior Assistant Machinery Inspector J17',
				'description' => 'Junior Assistant Machinery Inspector J17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 => 
			array (
				'id' => 1946,
				'name' => 'Justowriter',
				'description' => 'Justowriter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 => 
			array (
				'id' => 1947,
				'name' => 'Kadhi',
				'description' => 'Kadhi',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 => 
			array (
				'id' => 1948,
				'name' => 'Kelong Fishery Worker',
				'description' => 'Kelong Fishery Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 => 
			array (
				'id' => 1949,
				'name' => 'Kesatria S17 Assistant',
				'description' => 'Kesatria S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 => 
			array (
				'id' => 1950,
				'name' => 'Kesatria S27 Ssistant Officer',
				'description' => 'Kesatria S27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 => 
			array (
				'id' => 1951,
				'name' => 'Kesatria S41 Officer',
				'description' => 'Kesatria S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 => 
			array (
				'id' => 1952,
				'name' => 'Keysmith',
				'description' => 'Keysmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 => 
			array (
				'id' => 1953,
				'name' => 'Kindergarten Teacher',
				'description' => 'Kindergarten Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 => 
			array (
				'id' => 1954,
				'name' => 'Kindergarten Worker',
				'description' => 'Kindergarten Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 => 
			array (
				'id' => 1955,
				'name' => 'Kiosk Salesperson',
				'description' => 'Kiosk Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 => 
			array (
				'id' => 1956,
				'name' => 'Kitchen Administrator',
				'description' => 'Kitchen Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 => 
			array (
				'id' => 1957,
				'name' => 'Kitchen Coordinator',
				'description' => 'Kitchen Coordinator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 => 
			array (
				'id' => 1958,
				'name' => 'Kitchen Helper',
				'description' => 'Kitchen Helper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 => 
			array (
				'id' => 1959,
				'name' => 'Kitchen/Hotel Clerk',
				'description' => 'Kitchen/Hotel Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 => 
			array (
				'id' => 1960,
				'name' => 'Knitting Machine Operator',
				'description' => 'Knitting Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 => 
			array (
				'id' => 1961,
				'name' => 'Labelling Machine Operator',
				'description' => 'Labelling Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 => 
			array (
				'id' => 1962,
				'name' => 'Laboratory Attendant',
				'description' => 'Laboratory Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 => 
			array (
				'id' => 1963,
			'name' => 'Laboratory (Physical Science) Technician',
			'description' => 'Laboratory (Physical Science) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 => 
			array (
				'id' => 1964,
				'name' => 'Laboratory Research Estate/Plantation Conductor',
				'description' => 'Laboratory Research Estate/Plantation Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 => 
			array (
				'id' => 1965,
				'name' => 'Labourer Farm',
				'description' => 'Labourer Farm',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 => 
			array (
				'id' => 1966,
				'name' => 'Labour Management Relations Conciliator',
				'description' => 'Labour Management Relations Conciliator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 => 
			array (
				'id' => 1967,
				'name' => 'Lace Production Machine Operator',
				'description' => 'Lace Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 => 
			array (
				'id' => 1968,
				'name' => 'Laminating-Machine/Rubber Operator',
				'description' => 'Laminating-Machine/Rubber Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 => 
			array (
				'id' => 1969,
				'name' => 'Laminating/Plastics Press-Operator',
				'description' => 'Laminating/Plastics Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 => 
			array (
				'id' => 1970,
				'name' => 'Lance Corporal',
				'description' => 'Lance Corporal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 => 
			array (
				'id' => 1971,
				'name' => 'Land Administrative N17 Assistant',
				'description' => 'Land Administrative N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 => 
			array (
				'id' => 1972,
				'name' => 'Land Administrative N27 Ssistant Officer',
				'description' => 'Land Administrative N27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 => 
			array (
				'id' => 1973,
				'name' => 'Land Clearer',
				'description' => 'Land Clearer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 => 
			array (
				'id' => 1974,
				'name' => 'Land N17 Ssistant Officer',
				'description' => 'Land N17 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 => 
			array (
				'id' => 1975,
				'name' => 'Land Planning G17 Supervisor',
				'description' => 'Land Planning G17 Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 => 
			array (
				'id' => 1976,
				'name' => 'Land Planning G27 Ssistant Officer',
				'description' => 'Land Planning G27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 => 
			array (
				'id' => 1977,
				'name' => 'Land Planning G41 Officer',
				'description' => 'Land Planning G41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 => 
			array (
				'id' => 1978,
				'name' => 'Landscape Architect',
				'description' => 'Landscape Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 => 
			array (
				'id' => 1979,
				'name' => 'Landscape Artist',
				'description' => 'Landscape Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 => 
			array (
				'id' => 1980,
				'name' => 'Landscape J17 Technician',
				'description' => 'Landscape J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 => 
			array (
				'id' => 1981,
				'name' => 'Landscape J29 Technical Assistant',
				'description' => 'Landscape J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 => 
			array (
				'id' => 1982,
				'name' => 'Landscape J41 Architect',
				'description' => 'Landscape J41 Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 => 
			array (
				'id' => 1983,
				'name' => 'Landscape Labourer',
				'description' => 'Landscape Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 => 
			array (
				'id' => 1984,
				'name' => 'Land Surveyor',
				'description' => 'Land Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 => 
			array (
				'id' => 1985,
				'name' => 'Language Planner S41 Officer',
				'description' => 'Language Planner S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 => 
			array (
				'id' => 1986,
				'name' => 'Language Teacher',
				'description' => 'Language Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 => 
			array (
				'id' => 1987,
				'name' => 'Lapping/Metal Machine Operator',
				'description' => 'Lapping/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'id' => 1988,
				'name' => 'Latex Tank Cleaner',
				'description' => 'Latex Tank Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'id' => 1989,
				'name' => 'Lathe Setter-Operator',
				'description' => 'Lathe Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'id' => 1990,
				'name' => 'Lathe/Stone Setter-Operator',
				'description' => 'Lathe/Stone Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'id' => 1991,
				'name' => 'Laundering Machine Operator',
				'description' => 'Laundering Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 => 
			array (
				'id' => 1992,
			'name' => 'Laundress (Household)',
			'description' => 'Laundress (Household)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 => 
			array (
				'id' => 1993,
				'name' => 'Laundry And Dry Cleaning Workers',
				'description' => 'Laundry And Dry Cleaning Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 => 
			array (
				'id' => 1994,
				'name' => 'Laundry Assistant Supervisor',
				'description' => 'Laundry Assistant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 => 
			array (
				'id' => 1995,
				'name' => 'Laundry Attendant',
				'description' => 'Laundry Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 => 
			array (
				'id' => 1996,
				'name' => 'Laundry Supervisor',
				'description' => 'Laundry Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 => 
			array (
				'id' => 1997,
				'name' => 'Lavatory Attendant',
				'description' => 'Lavatory Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 => 
			array (
				'id' => 1998,
				'name' => 'Law/Legal Clerk',
				'description' => 'Law/Legal Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 => 
			array (
				'id' => 1999,
				'name' => 'Lawyer',
				'description' => 'Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 => 
			array (
				'id' => 2000,
				'name' => 'Layer Firebrick',
				'description' => 'Layer Firebrick',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 2001,
				'name' => 'Lay Osteopath',
				'description' => 'Lay Osteopath',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 2002,
				'name' => 'Lead Burner',
				'description' => 'Lead Burner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 2003,
				'name' => 'Leaded-Glass Glazier',
				'description' => 'Leaded-Glass Glazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 2004,
				'name' => 'Leading Rate',
				'description' => 'Leading Rate',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 2005,
				'name' => 'Lead Production Machine Operator',
				'description' => 'Lead Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 2006,
				'name' => 'Leather And Related Materials Handicraft Workers In Textile',
				'description' => 'Leather And Related Materials Handicraft Workers In Textile',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 2007,
				'name' => 'Leather Chemist',
				'description' => 'Leather Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 2008,
				'name' => 'Leather Garment Cutter',
				'description' => 'Leather Garment Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 2009,
				'name' => 'Leather Goods Maker',
				'description' => 'Leather Goods Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 2010,
				'name' => 'Leather Products Assembler',
				'description' => 'Leather Products Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 2011,
				'name' => 'Leather Technologist',
				'description' => 'Leather Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 2012,
				'name' => 'Ledger Bookkeeper',
				'description' => 'Ledger Bookkeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 2013,
				'name' => 'Ledger Clerk',
				'description' => 'Ledger Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 2014,
				'name' => 'Legal Administrative S17 Assistant',
				'description' => 'Legal Administrative S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 2015,
				'name' => 'Legal Adviser',
				'description' => 'Legal Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 2016,
				'name' => 'Legal Aid Bureau L41 Legal Officer',
				'description' => 'Legal Aid Bureau L41 Legal Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 2017,
				'name' => 'Legal And Risk Management Manager',
				'description' => 'Legal And Risk Management Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 2018,
				'name' => 'Legal Drafter L41',
				'description' => 'Legal Drafter L41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 2019,
				'name' => 'Legal L29 Assistant',
				'description' => 'Legal L29 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 2020,
				'name' => 'Legal L41 Adviser',
				'description' => 'Legal L41 Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 2021,
				'name' => 'Legal Officer/Executive',
				'description' => 'Legal Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 2022,
				'name' => 'Legal Secretary',
				'description' => 'Legal Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 2023,
				'name' => 'Legislative Official',
				'description' => 'Legislative Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 2024,
				'name' => 'Lexicographer',
				'description' => 'Lexicographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 2025,
				'name' => 'Librarian',
				'description' => 'Librarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 2026,
				'name' => 'Librarian S17 Junior Assistant',
				'description' => 'Librarian S17 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 2027,
				'name' => 'Librarian S27 Assistant',
				'description' => 'Librarian S27 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 2028,
				'name' => 'Librarian S41',
				'description' => 'Librarian S41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 2029,
				'name' => 'Library Assistant',
				'description' => 'Library Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 2030,
				'name' => 'Library Clerk',
				'description' => 'Library Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 2031,
				'name' => 'Library Executive',
				'description' => 'Library Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 2032,
				'name' => 'Library Filer',
				'description' => 'Library Filer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 2033,
				'name' => 'Licensing Inspector',
				'description' => 'Licensing Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 2034,
				'name' => 'Licensing Officer',
				'description' => 'Licensing Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 2035,
				'name' => 'Lieutenant Colonel',
				'description' => 'Lieutenant Colonel',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 2036,
				'name' => 'Lieutenant Commander',
				'description' => 'Lieutenant Commander',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 2037,
				'name' => 'Lieutenant General',
				'description' => 'Lieutenant General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 2038,
				'name' => 'Life-Boatman',
				'description' => 'Life-Boatman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 2039,
				'name' => 'Lifeguard',
				'description' => 'Lifeguard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 2040,
				'name' => 'Lifeguard N1',
				'description' => 'Lifeguard N1',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 2041,
				'name' => 'Lift Attendant',
				'description' => 'Lift Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 2042,
				'name' => 'Lighterman',
				'description' => 'Lighterman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 2043,
				'name' => 'Light House A1 Keeper',
				'description' => 'Light House A1 Keeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 2044,
				'name' => 'Light House Keeper',
				'description' => 'Light House Keeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 2045,
				'name' => 'Light Physicist',
				'description' => 'Light Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 2046,
				'name' => 'Line Leader',
				'description' => 'Line Leader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 2047,
				'name' => 'Linen Housekeeping Assistant',
				'description' => 'Linen Housekeeping Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 2048,
				'name' => 'Linen Maid',
				'description' => 'Linen Maid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 2049,
				'name' => 'Linen Supply/Hotel And Lodging Clerk',
				'description' => 'Linen Supply/Hotel And Lodging Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 2050,
				'name' => 'Linoleum Production Machine Operator',
				'description' => 'Linoleum Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 2051,
				'name' => 'Liquefaction Plant/Gases Operator',
				'description' => 'Liquefaction Plant/Gases Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 2052,
				'name' => 'Liquidator',
				'description' => 'Liquidator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 2053,
				'name' => 'Liquor Grader/Taster',
				'description' => 'Liquor Grader/Taster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 2054,
				'name' => 'Liquor Production Machine Operator',
				'description' => 'Liquor Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 2055,
				'name' => 'List/Address Clerk',
				'description' => 'List/Address Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 2056,
				'name' => 'List/Mail Clerk',
				'description' => 'List/Mail Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 2057,
				'name' => 'Literary Agent',
				'description' => 'Literary Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 2058,
				'name' => 'Lithographic Draughtsperson',
				'description' => 'Lithographic Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 2059,
				'name' => 'Litigation Lawyer',
				'description' => 'Litigation Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 2060,
				'name' => 'Livestock Farm Worker',
				'description' => 'Livestock Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 2061,
				'name' => 'Load Sheet Officer',
				'description' => 'Load Sheet Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 2062,
				'name' => 'Loan Officer',
				'description' => 'Loan Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 2063,
				'name' => 'Local Sales Clerk',
				'description' => 'Local Sales Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 2064,
				'name' => 'Locksmith',
				'description' => 'Locksmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 2065,
				'name' => 'Locomotive Driver',
				'description' => 'Locomotive Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 2066,
				'name' => 'Locomotive Engine Engineer',
				'description' => 'Locomotive Engine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 2067,
				'name' => 'Lodging-House Manager',
				'description' => 'Lodging-House Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 2068,
				'name' => 'Log Checker',
				'description' => 'Log Checker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 2069,
				'name' => 'Log Driver',
				'description' => 'Log Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 2070,
				'name' => 'Logger',
				'description' => 'Logger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 2071,
				'name' => 'Logging Chokerman',
				'description' => 'Logging Chokerman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 2072,
				'name' => 'Logging Clerk',
				'description' => 'Logging Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 2073,
				'name' => 'Logging Feller',
				'description' => 'Logging Feller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 2074,
				'name' => 'Logging G17 Instructor',
				'description' => 'Logging G17 Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 2075,
				'name' => 'Logging High Climber',
				'description' => 'Logging High Climber',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 2076,
				'name' => 'Logging Rigger',
				'description' => 'Logging Rigger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 2077,
				'name' => 'Logging Scaler',
				'description' => 'Logging Scaler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 2078,
				'name' => 'Logging Signalman',
				'description' => 'Logging Signalman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 2079,
				'name' => 'Log Grader',
				'description' => 'Log Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 2080,
				'name' => 'Log-Grapple Operator',
				'description' => 'Log-Grapple Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 2081,
				'name' => 'Logistic Clerk',
				'description' => 'Logistic Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 2082,
				'name' => 'Logistic Supervisor',
				'description' => 'Logistic Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 2083,
				'name' => 'Log Marker',
				'description' => 'Log Marker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 2084,
				'name' => 'Log Peeler',
				'description' => 'Log Peeler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 2085,
				'name' => 'Log-Raft Maker',
				'description' => 'Log-Raft Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 2086,
				'name' => 'Logs Officer',
				'description' => 'Logs Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 2087,
				'name' => 'Log Supervisor',
				'description' => 'Log Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 2088,
				'name' => 'Log Yard Technician',
				'description' => 'Log Yard Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 2089,
				'name' => 'Loom Fixer',
				'description' => 'Loom Fixer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 2090,
				'name' => 'Loose Fruit Harvester',
				'description' => 'Loose Fruit Harvester',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 2091,
				'name' => 'Lorry Driver',
				'description' => 'Lorry Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 2092,
				'name' => 'Lorry/Van/Truck Attendant',
				'description' => 'Lorry/Van/Truck Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 2093,
				'name' => 'LRT/ ERL/Monorail Operation Officer/Controller',
				'description' => 'LRT/ ERL/Monorail Operation Officer/Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 2094,
				'name' => 'LRT Railway Supervisor',
				'description' => 'LRT Railway Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 2095,
				'name' => 'Lubrication Engineer',
				'description' => 'Lubrication Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 2096,
			'name' => 'Luggage/Baggage (Except Hotel) Porter',
			'description' => 'Luggage/Baggage (Except Hotel) Porter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 2097,
				'name' => 'Lyricist',
				'description' => 'Lyricist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 2098,
				'name' => 'Machine Attendant',
				'description' => 'Machine Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 2099,
				'name' => 'Machine Crocheter',
				'description' => 'Machine Crocheter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 2100,
				'name' => 'Machine Embroiderer',
				'description' => 'Machine Embroiderer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 2101,
				'name' => 'Machine Leather Sewer',
				'description' => 'Machine Leather Sewer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 2102,
				'name' => 'Machine Metal-Printing Roller-Engraver',
				'description' => 'Machine Metal-Printing Roller-Engraver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 2103,
				'name' => 'Machine Operator Boring Equipment/Well',
				'description' => 'Machine Operator Boring Equipment/Well',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 2104,
				'name' => 'Machine Operator Pharmaceutical Products',
				'description' => 'Machine Operator Pharmaceutical Products',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 2105,
				'name' => 'Machinery Filter',
				'description' => 'Machinery Filter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 2106,
				'name' => 'Machinery Mechanic',
				'description' => 'Machinery Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 2107,
				'name' => 'Machine Tool Assembler',
				'description' => 'Machine Tool Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 2108,
				'name' => 'Machine-Tool Mechanic',
				'description' => 'Machine-Tool Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 2109,
				'name' => 'Machine Tools Sharpener',
				'description' => 'Machine Tools Sharpener',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 2110,
				'name' => 'Magician',
				'description' => 'Magician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 2111,
				'name' => 'Magistrate',
				'description' => 'Magistrate',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 2112,
				'name' => 'Magistrate L41',
				'description' => 'Magistrate L41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 2113,
				'name' => 'Mahout',
				'description' => 'Mahout',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 2114,
				'name' => 'Mail Clerk',
				'description' => 'Mail Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 2115,
				'name' => 'Mail/Despatch Clerk',
				'description' => 'Mail/Despatch Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 2116,
				'name' => 'Mail/Sorting Clerk',
				'description' => 'Mail/Sorting Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 2117,
				'name' => 'Maintenance Attendant',
				'description' => 'Maintenance Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 2118,
				'name' => 'Maintenance Clerk',
				'description' => 'Maintenance Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 2119,
				'name' => 'Maintenance/Dam Labourer',
				'description' => 'Maintenance/Dam Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 2120,
				'name' => 'Maintenance Electrician',
				'description' => 'Maintenance Electrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 2121,
				'name' => 'Maintenance Engineer',
				'description' => 'Maintenance Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 2122,
				'name' => 'Maintenance Executive',
				'description' => 'Maintenance Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 2123,
				'name' => 'Maintenance Fitter',
				'description' => 'Maintenance Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 2124,
				'name' => 'Maintenance Foreman',
				'description' => 'Maintenance Foreman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 2125,
				'name' => 'Maintenance Labourer',
				'description' => 'Maintenance Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 2126,
				'name' => 'Maintenance Manager',
				'description' => 'Maintenance Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 2127,
				'name' => 'Maintenance Supervisor',
				'description' => 'Maintenance Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 2128,
				'name' => 'Maintenance Technician',
				'description' => 'Maintenance Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 2129,
				'name' => 'Maintenance Worker',
				'description' => 'Maintenance Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 2130,
				'name' => 'Maintenance Worker Workshop',
				'description' => 'Maintenance Worker Workshop',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 2131,
				'name' => 'Major',
				'description' => 'Major',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 2132,
				'name' => 'Major General',
				'description' => 'Major General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 2133,
				'name' => 'Mak Andam',
				'description' => 'Mak Andam',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 2134,
				'name' => 'Make-Up Artist',
				'description' => 'Make-Up Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 2135,
				'name' => 'Malay Cuisine Chef',
				'description' => 'Malay Cuisine Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 2136,
				'name' => 'Malay Traditional Medicine Physician',
				'description' => 'Malay Traditional Medicine Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 2137,
				'name' => 'Mammalgist',
				'description' => 'Mammalgist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 2138,
				'name' => 'Mammalogy Zoologist',
				'description' => 'Mammalogy Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 2139,
				'name' => 'Management Accountant',
				'description' => 'Management Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 2140,
				'name' => 'Management Consultant',
				'description' => 'Management Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 2141,
				'name' => 'Management Information Systems Clerk',
				'description' => 'Management Information Systems Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 2142,
			'name' => 'Management Information Systems (MIS) Analyst',
			'description' => 'Management Information Systems (MIS) Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 2143,
			'name' => 'Management Information Systems (MIS) Engineer',
			'description' => 'Management Information Systems (MIS) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 2144,
				'name' => 'Management Information Systems Supervisor',
				'description' => 'Management Information Systems Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 2145,
				'name' => 'Management Trainee',
				'description' => 'Management Trainee',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 2146,
				'name' => 'Managing Director',
				'description' => 'Managing Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 2147,
				'name' => 'Mandore Worker',
				'description' => 'Mandore Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 2148,
				'name' => 'Manicurist',
				'description' => 'Manicurist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 2149,
				'name' => 'Manufactured Articles Painter',
				'description' => 'Manufactured Articles Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 2150,
				'name' => 'Manufactured Articles Varnisher',
				'description' => 'Manufactured Articles Varnisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 2151,
				'name' => 'Manufacturing Executive',
				'description' => 'Manufacturing Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 2152,
				'name' => 'Manufacturing Labourer',
				'description' => 'Manufacturing Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 2153,
				'name' => 'Manufacturing Manager',
				'description' => 'Manufacturing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 2154,
				'name' => 'Manufacturing Supervisor',
				'description' => 'Manufacturing Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 2155,
				'name' => 'Manuring Worker',
				'description' => 'Manuring Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 2156,
				'name' => 'Map And Chart Mounter',
				'description' => 'Map And Chart Mounter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 2157,
				'name' => 'Map Maker',
				'description' => 'Map Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 2158,
				'name' => 'Marble Setter',
				'description' => 'Marble Setter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 2159,
				'name' => 'Margarine Plant Operator',
				'description' => 'Margarine Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 2160,
				'name' => 'Margarine Processing Machine Operator',
				'description' => 'Margarine Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 2161,
				'name' => 'Marine A29 Ssistant Officer',
				'description' => 'Marine A29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 2162,
				'name' => 'Marine A41 Officer',
				'description' => 'Marine A41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 2163,
				'name' => 'Marine Architect',
				'description' => 'Marine Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 2164,
				'name' => 'Marine Biologist',
				'description' => 'Marine Biologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 2165,
				'name' => 'Marine Engine A1/A11 Mechanic',
				'description' => 'Marine Engine A1/A11 Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 2166,
				'name' => 'Marine Engineer',
				'description' => 'Marine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 2167,
				'name' => 'Marine Engineering Assistant',
				'description' => 'Marine Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 2168,
				'name' => 'Marine Engine Mechanic',
				'description' => 'Marine Engine Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 2169,
				'name' => 'Marine Geologist',
				'description' => 'Marine Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 2170,
				'name' => 'Marine Meteorologist',
				'description' => 'Marine Meteorologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 2171,
			'name' => 'Marine Superintendent (Deck)',
			'description' => 'Marine Superintendent (Deck)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 2172,
				'name' => 'Marine Surveyor',
				'description' => 'Marine Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 2173,
				'name' => 'Maritime X13 Superintendent Officer',
				'description' => 'Maritime X13 Superintendent Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 2174,
				'name' => 'Maritime X1 Ssistant Superintendent',
				'description' => 'Maritime X1 Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 2175,
				'name' => 'Market Garden Worker',
				'description' => 'Market Garden Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 2176,
				'name' => 'Marketing Clerk',
				'description' => 'Marketing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 2177,
				'name' => 'Marketing Executive',
				'description' => 'Marketing Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 2178,
				'name' => 'Marketing Manager',
				'description' => 'Marketing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 2179,
				'name' => 'Marketing Research Analyst/Executive',
				'description' => 'Marketing Research Analyst/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 2180,
				'name' => 'Marketing Salesman/Salesgirl',
				'description' => 'Marketing Salesman/Salesgirl',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 2181,
				'name' => 'Market Research/Business Analyst',
				'description' => 'Market Research/Business Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 2182,
				'name' => 'Market Research Enumerator',
				'description' => 'Market Research Enumerator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 2183,
				'name' => 'Market Research Interview',
				'description' => 'Market Research Interview',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 2184,
				'name' => 'Market Research Manager',
				'description' => 'Market Research Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 2185,
				'name' => 'Market Research Statistician',
				'description' => 'Market Research Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 2186,
				'name' => 'Market Salesperson',
				'description' => 'Market Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 2187,
				'name' => 'Marking Equipment/Road Operator',
				'description' => 'Marking Equipment/Road Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 2188,
				'name' => 'Marquetry Inlayer',
				'description' => 'Marquetry Inlayer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 2189,
				'name' => 'Marriage Counselor',
				'description' => 'Marriage Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 2190,
				'name' => 'Mascular Therapy',
				'description' => 'Mascular Therapy',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 2191,
				'name' => 'Mason',
				'description' => 'Mason',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 2192,
				'name' => 'Massage Therapist',
				'description' => 'Massage Therapist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 2193,
			'name' => 'Masseur (Non-Medical)',
			'description' => 'Masseur (Non-Medical)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 2194,
				'name' => 'Master Of Ceremonies',
				'description' => 'Master Of Ceremonies',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 2195,
				'name' => 'Match/Chemical And Related Processes Compounder',
				'description' => 'Match/Chemical And Related Processes Compounder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 2196,
				'name' => 'Match Production Machine Operator',
				'description' => 'Match Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 2197,
				'name' => 'Material Handler',
				'description' => 'Material Handler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 2198,
				'name' => 'Material Storekeeper',
				'description' => 'Material Storekeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 2199,
				'name' => 'Material Store Technician',
				'description' => 'Material Store Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 2200,
				'name' => 'Mathematical And Actual Associate Professionals Other Statistical',
				'description' => 'Mathematical And Actual Associate Professionals Other Statistical',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 2201,
				'name' => 'Mathematical Assistant',
				'description' => 'Mathematical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 2202,
				'name' => 'Mathematical Statistician',
				'description' => 'Mathematical Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 2203,
				'name' => 'Mathematician',
				'description' => 'Mathematician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 2204,
				'name' => 'Matlting/Spirit Kiln-Operator',
				'description' => 'Matlting/Spirit Kiln-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 2205,
				'name' => 'Mattres Cutter',
				'description' => 'Mattres Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 2206,
				'name' => 'Mattres Maker',
				'description' => 'Mattres Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 2207,
				'name' => 'Mattres Pattern-Maker',
				'description' => 'Mattres Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 2208,
				'name' => 'Mattress Production Machine Operator',
				'description' => 'Mattress Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 2209,
				'name' => 'Mat Weaver',
				'description' => 'Mat Weaver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 2210,
				'name' => 'Mayor/Datuk Bandar',
				'description' => 'Mayor/Datuk Bandar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 2211,
				'name' => 'Meal Processing Machine Operator',
				'description' => 'Meal Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 2212,
				'name' => 'Meat/Fish Curer',
				'description' => 'Meat/Fish Curer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 2213,
				'name' => 'Meat/Fish Pickler',
				'description' => 'Meat/Fish Pickler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 2214,
				'name' => 'Meat/Fish Salter',
				'description' => 'Meat/Fish Salter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 2215,
				'name' => 'Meat Grader',
				'description' => 'Meat Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 2216,
				'name' => 'Meat Machine Operator',
				'description' => 'Meat Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 2217,
				'name' => 'Mechanical/Aeronautics Engineer',
				'description' => 'Mechanical/Aeronautics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 2218,
				'name' => 'Mechanical/Aerospace Engineer',
				'description' => 'Mechanical/Aerospace Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 2219,
				'name' => 'Mechanical/Agriculture Engineer',
				'description' => 'Mechanical/Agriculture Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 2220,
				'name' => 'Mechanical/Automotive Engineer',
				'description' => 'Mechanical/Automotive Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 2221,
				'name' => 'Mechanical/Diesel Engineer',
				'description' => 'Mechanical/Diesel Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 2222,
				'name' => 'Mechanical Engineer',
				'description' => 'Mechanical Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 2223,
				'name' => 'Mechanical Engineering Assistant',
				'description' => 'Mechanical Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 2224,
				'name' => 'Mechanical Foreman',
				'description' => 'Mechanical Foreman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 2225,
				'name' => 'Mechanical/Gas Turbine Engineer',
				'description' => 'Mechanical/Gas Turbine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 2226,
				'name' => 'Mechanical/Instruments Engineer',
				'description' => 'Mechanical/Instruments Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 2227,
				'name' => 'Mechanical J29 Technical Assistant',
				'description' => 'Mechanical J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 2228,
				'name' => 'Mechanical J41 Engineer',
				'description' => 'Mechanical J41 Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 2229,
			'name' => 'Mechanical/Motors And Engine (Except Marine) Engineer',
			'description' => 'Mechanical/Motors And Engine (Except Marine) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 2230,
			'name' => 'Mechanical/Motors And Engines (Marine) Engineer',
			'description' => 'Mechanical/Motors And Engines (Marine) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 2231,
				'name' => 'Mechanical/Naval Engineer',
				'description' => 'Mechanical/Naval Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 2232,
				'name' => 'Mechanical/Nuclear Power Engineer',
				'description' => 'Mechanical/Nuclear Power Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 2233,
				'name' => 'Mechanic Chief',
				'description' => 'Mechanic Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 2234,
				'name' => 'Mechanics And Services Other Electronics Fitters',
				'description' => 'Mechanics And Services Other Electronics Fitters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 2235,
				'name' => 'Mechanics Physicist',
				'description' => 'Mechanics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 2236,
				'name' => 'Mechantronics Engineer',
				'description' => 'Mechantronics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 2237,
				'name' => 'Mechatronics Technician',
				'description' => 'Mechatronics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 2238,
				'name' => 'Media Interviewer',
				'description' => 'Media Interviewer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 2239,
				'name' => 'Media Planner',
				'description' => 'Media Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 2240,
				'name' => 'Medical Assistant',
				'description' => 'Medical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 2241,
				'name' => 'Medical Bacteriologist',
				'description' => 'Medical Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 2242,
				'name' => 'Medical Doctor',
				'description' => 'Medical Doctor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 2243,
				'name' => 'Medical DU45 Lecturer',
				'description' => 'Medical DU45 Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 2244,
				'name' => 'Medical Laboratory Assistant',
				'description' => 'Medical Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 2245,
				'name' => 'Medical LaboratoryU29 Technologist',
				'description' => 'Medical LaboratoryU29 Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 2246,
				'name' => 'Medical Matron',
				'description' => 'Medical Matron',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 2247,
			'name' => 'Medical (Medical Administration) Manager',
			'description' => 'Medical (Medical Administration) Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 2248,
				'name' => 'Medical Officer',
				'description' => 'Medical Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 2249,
				'name' => 'Medical Oncologist',
				'description' => 'Medical Oncologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 2250,
				'name' => 'Medical Pathologist',
				'description' => 'Medical Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 2251,
				'name' => 'Medical Photographer',
				'description' => 'Medical Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 2252,
				'name' => 'Medical Physicist',
				'description' => 'Medical Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 2253,
				'name' => 'Medical Practitioner',
				'description' => 'Medical Practitioner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 2254,
				'name' => 'Medical Receptionist',
				'description' => 'Medical Receptionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 2255,
				'name' => 'Medical Records Unit Supervisor',
				'description' => 'Medical Records Unit Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 2256,
				'name' => 'Medical Rehabilitation U41 Officer',
				'description' => 'Medical Rehabilitation U41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 2257,
				'name' => 'Medical Sales Representatives',
				'description' => 'Medical Sales Representatives',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 2258,
				'name' => 'Medical Science Technician',
				'description' => 'Medical Science Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 2259,
				'name' => 'Medical Secretary',
				'description' => 'Medical Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 2260,
				'name' => 'Medical Social Worker',
				'description' => 'Medical Social Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 2261,
				'name' => 'Medical U19 Technician',
				'description' => 'Medical U19 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 2262,
				'name' => 'Medical U29 Assistant',
				'description' => 'Medical U29 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 2263,
				'name' => 'Medical U41 Officer',
				'description' => 'Medical U41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 2264,
				'name' => 'Medical X-Ray Equipment Operator',
				'description' => 'Medical X-Ray Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 2265,
				'name' => 'Meeting Herald N27',
				'description' => 'Meeting Herald N27',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 2266,
				'name' => 'Melting/Metal Furnace-Operator',
				'description' => 'Melting/Metal Furnace-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 2267,
				'name' => 'Member Of Parliamentarian',
				'description' => 'Member Of Parliamentarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 2268,
				'name' => 'Merry-Go-Round Operator',
				'description' => 'Merry-Go-Round Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 2269,
				'name' => 'Messenger/Courier',
				'description' => 'Messenger/Courier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 2270,
				'name' => 'Metal Annealer',
				'description' => 'Metal Annealer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 2271,
				'name' => 'Metal Cleaner',
				'description' => 'Metal Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 2272,
				'name' => 'Metal Coremaker',
				'description' => 'Metal Coremaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 2273,
				'name' => 'Metal Drawer',
				'description' => 'Metal Drawer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 2274,
				'name' => 'Metal/Except Forging Press-Operator',
				'description' => 'Metal/Except Forging Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 2275,
				'name' => 'Metal Finisher',
				'description' => 'Metal Finisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 2276,
				'name' => 'Metal Foundry Pattern-Maker',
				'description' => 'Metal Foundry Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 2277,
				'name' => 'Metal Grinder',
				'description' => 'Metal Grinder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 2278,
				'name' => 'Metallurgical Chemist',
				'description' => 'Metallurgical Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 2279,
				'name' => 'Metallurgy/Assaying Technician',
				'description' => 'Metallurgy/Assaying Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 2280,
				'name' => 'Metallurgy/Extractive Technician',
				'description' => 'Metallurgy/Extractive Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 2281,
				'name' => 'Metallurgy/Foundry Technician',
				'description' => 'Metallurgy/Foundry Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 2282,
				'name' => 'Metallurgy Laboratory Assistant',
				'description' => 'Metallurgy Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 2283,
				'name' => 'Metallurgy/Physical Technician',
				'description' => 'Metallurgy/Physical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 2284,
				'name' => 'Metallurgy/Radioactive Minerals Technician',
				'description' => 'Metallurgy/Radioactive Minerals Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 2285,
				'name' => 'Metallurgy Technician',
				'description' => 'Metallurgy Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 2286,
				'name' => 'Metal Manipulator, Rolling-Mill',
				'description' => 'Metal Manipulator, Rolling-Mill',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 2287,
				'name' => 'Metal Marker',
				'description' => 'Metal Marker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 2288,
				'name' => 'Metal Moulder',
				'description' => 'Metal Moulder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 2289,
				'name' => 'Metal Painter',
				'description' => 'Metal Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 2290,
				'name' => 'Metal Polisher',
				'description' => 'Metal Polisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 2291,
				'name' => 'Metal Products Assembler',
				'description' => 'Metal Products Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 2292,
				'name' => 'Metal Products Machine Operator',
				'description' => 'Metal Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 2293,
				'name' => 'Metal Roofer',
				'description' => 'Metal Roofer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 2294,
				'name' => 'Metal Sandblaster',
				'description' => 'Metal Sandblaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 2295,
				'name' => 'Metal Shipwright',
				'description' => 'Metal Shipwright',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 2296,
				'name' => 'Metal Spray-Painter',
				'description' => 'Metal Spray-Painter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 2297,
				'name' => 'Metal Temperer',
				'description' => 'Metal Temperer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 2298,
				'name' => 'Metal Testing Engineer',
				'description' => 'Metal Testing Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 2299,
				'name' => 'Metal Varnisher',
				'description' => 'Metal Varnisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 2300,
				'name' => 'Metal-Wind Musical Instrument Maker',
				'description' => 'Metal-Wind Musical Instrument Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 2301,
				'name' => 'Metalworking Machine Setter-Operator',
				'description' => 'Metalworking Machine Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 2302,
				'name' => 'Metalwork/Ornamental Designer',
				'description' => 'Metalwork/Ornamental Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 2303,
				'name' => 'Meteorological Assistant',
				'description' => 'Meteorological Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 2304,
				'name' => 'Meteorological Officer',
				'description' => 'Meteorological Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 2305,
				'name' => 'Meteorological Technician',
				'description' => 'Meteorological Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 2306,
				'name' => 'Meteorologist',
				'description' => 'Meteorologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 2307,
				'name' => 'Meteorologist-Climatology',
				'description' => 'Meteorologist-Climatology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 2308,
				'name' => 'Meteorologist-Weather Forecasting',
				'description' => 'Meteorologist-Weather Forecasting',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 2309,
				'name' => 'Meteorology C41 Officer',
				'description' => 'Meteorology C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 2310,
				'name' => 'Meter Reader',
				'description' => 'Meter Reader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 2311,
				'name' => 'Meter Readers And Related Workers Other Vending Machine Operators',
				'description' => 'Meter Readers And Related Workers Other Vending Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 2312,
				'name' => 'Microbiologist',
				'description' => 'Microbiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 2313,
				'name' => 'Microelectronics Equipment Assembler',
				'description' => 'Microelectronics Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 2314,
				'name' => 'Micropalaeontology',
				'description' => 'Micropalaeontology',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'id' => 2315,
				'name' => 'Micropalaeontology Geologist',
				'description' => 'Micropalaeontology Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'id' => 2316,
				'name' => 'Microphotography',
				'description' => 'Microphotography',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'id' => 2317,
				'name' => 'Microphotography Photographer',
				'description' => 'Microphotography Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'id' => 2318,
				'name' => 'Midshipmen',
				'description' => 'Midshipmen',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'id' => 2319,
				'name' => 'Midwife',
				'description' => 'Midwife',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'id' => 2320,
				'name' => 'Milinder',
				'description' => 'Milinder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'id' => 2321,
				'name' => 'Milker',
				'description' => 'Milker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'id' => 2322,
				'name' => 'Milk Powder Production Machine Operator',
				'description' => 'Milk Powder Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 => 
			array (
				'id' => 2323,
				'name' => 'Mill/Foodgrains Attendant',
				'description' => 'Mill/Foodgrains Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 => 
			array (
				'id' => 2324,
				'name' => 'Milling Machine Setter-Operator',
				'description' => 'Milling Machine Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 => 
			array (
				'id' => 2325,
				'name' => 'Milling/Mineral Machine Operator',
				'description' => 'Milling/Mineral Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 => 
			array (
				'id' => 2326,
				'name' => 'Milling/Mustard Seeds Machine Operator',
				'description' => 'Milling/Mustard Seeds Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 => 
			array (
				'id' => 2327,
				'name' => 'Milling/Rubber Machine Operator',
				'description' => 'Milling/Rubber Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 => 
			array (
				'id' => 2328,
				'name' => 'Milling/Stone Machine Operator',
				'description' => 'Milling/Stone Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 => 
			array (
				'id' => 2329,
				'name' => 'Mill Office Clerk',
				'description' => 'Mill Office Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 => 
			array (
				'id' => 2330,
				'name' => 'Mill/Rubber Attendant',
				'description' => 'Mill/Rubber Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 => 
			array (
				'id' => 2331,
				'name' => 'Mill Table Operator',
				'description' => 'Mill Table Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 => 
			array (
				'id' => 2332,
				'name' => 'Mimic',
				'description' => 'Mimic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 => 
			array (
				'id' => 2333,
				'name' => 'Mine Engine Driver',
				'description' => 'Mine Engine Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 => 
			array (
				'id' => 2334,
				'name' => 'Miner',
				'description' => 'Miner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 => 
			array (
				'id' => 2335,
				'name' => 'Mineralogist',
				'description' => 'Mineralogist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 => 
			array (
				'id' => 2336,
				'name' => 'Minerals Floatation Worker',
				'description' => 'Minerals Floatation Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 => 
			array (
				'id' => 2337,
				'name' => 'Mine Sampler',
				'description' => 'Mine Sampler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 => 
			array (
				'id' => 2338,
				'name' => 'Mine Surveyor',
				'description' => 'Mine Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'id' => 2339,
				'name' => 'Mining C17 Assistant',
				'description' => 'Mining C17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'id' => 2340,
				'name' => 'Mining C27 Ssistant Officer',
				'description' => 'Mining C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'id' => 2341,
				'name' => 'Mining C41 Officer',
				'description' => 'Mining C41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'id' => 2342,
				'name' => 'Mining/Coal Engineer',
				'description' => 'Mining/Coal Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'id' => 2343,
				'name' => 'Mining/Continuous Machine Operator',
				'description' => 'Mining/Continuous Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'id' => 2344,
				'name' => 'Mining/Diamonds Engineer',
				'description' => 'Mining/Diamonds Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'id' => 2345,
				'name' => 'Mining Draughtsperson',
				'description' => 'Mining Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'id' => 2346,
				'name' => 'Mining Engineer',
				'description' => 'Mining Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'id' => 2347,
				'name' => 'Mining Geologist',
				'description' => 'Mining Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'id' => 2348,
				'name' => 'Mining Labourer',
				'description' => 'Mining Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'id' => 2349,
				'name' => 'Mining Machinery Assembler',
				'description' => 'Mining Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'id' => 2350,
				'name' => 'Mining Machinery Mechanic',
				'description' => 'Mining Machinery Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 => 
			array (
				'id' => 2351,
				'name' => 'Mining/Metal Engineer',
				'description' => 'Mining/Metal Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 => 
			array (
				'id' => 2352,
				'name' => 'Mining/Non Metal Engineer',
				'description' => 'Mining/Non Metal Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 => 
			array (
				'id' => 2353,
				'name' => 'Mining/Petroleum And Natural Gas Engineer',
				'description' => 'Mining/Petroleum And Natural Gas Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 => 
			array (
				'id' => 2354,
				'name' => 'Mining Supervisor',
				'description' => 'Mining Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 => 
			array (
				'id' => 2355,
				'name' => 'Minister',
				'description' => 'Minister',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 => 
			array (
				'id' => 2356,
				'name' => 'Minting/Metal Machine Operator',
				'description' => 'Minting/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 => 
			array (
				'id' => 2357,
				'name' => 'Mirror Silverer',
				'description' => 'Mirror Silverer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 => 
			array (
				'id' => 2358,
			'name' => 'Mixed Crop Grower (No Husbandry)',
			'description' => 'Mixed Crop Grower (No Husbandry)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 => 
			array (
				'id' => 2359,
			'name' => 'Mixed Product Farmer (Crops And Husbandry)',
			'description' => 'Mixed Product Farmer (Crops And Husbandry)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 => 
			array (
				'id' => 2360,
			'name' => 'Mixer Hand (Chemical And Related Processes)',
			'description' => 'Mixer Hand (Chemical And Related Processes)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 => 
			array (
				'id' => 2361,
				'name' => 'Mixing/Abrasives Machine Operator',
				'description' => 'Mixing/Abrasives Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 => 
			array (
				'id' => 2362,
				'name' => 'Mixing And Blending/Chemical And Related Processes Machine Operator',
				'description' => 'Mixing And Blending/Chemical And Related Processes Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'id' => 2363,
				'name' => 'Mixing/Clay Machine Operator',
				'description' => 'Mixing/Clay Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'id' => 2364,
				'name' => 'Mixing/Glass Machine Operator',
				'description' => 'Mixing/Glass Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'id' => 2365,
				'name' => 'Mixing/Plastics Machine Operator',
				'description' => 'Mixing/Plastics Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'id' => 2366,
				'name' => 'Modeling Teacher',
				'description' => 'Modeling Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'id' => 2367,
				'name' => 'Model/Wooden Maker',
				'description' => 'Model/Wooden Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'id' => 2368,
				'name' => 'Molecular Bacteriologist',
				'description' => 'Molecular Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'id' => 2369,
				'name' => 'Money Changer',
				'description' => 'Money Changer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'id' => 2370,
				'name' => 'Money-Lender',
				'description' => 'Money-Lender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'id' => 2371,
				'name' => 'Mono-Rail Operator',
				'description' => 'Mono-Rail Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 => 
			array (
				'id' => 2372,
				'name' => 'Monument Carver-Setter',
				'description' => 'Monument Carver-Setter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 => 
			array (
				'id' => 2373,
				'name' => 'Mortgage Clerk',
				'description' => 'Mortgage Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 => 
			array (
				'id' => 2374,
				'name' => 'Mortgage Officer',
				'description' => 'Mortgage Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 => 
			array (
				'id' => 2375,
				'name' => 'Mortuary Attendant',
				'description' => 'Mortuary Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 => 
			array (
				'id' => 2376,
				'name' => 'Mosaic Cutter-Setter',
				'description' => 'Mosaic Cutter-Setter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 => 
			array (
				'id' => 2377,
				'name' => 'Mosquito Coil Production Machine Operator',
				'description' => 'Mosquito Coil Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'id' => 2378,
				'name' => 'Motel Manager',
				'description' => 'Motel Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'id' => 2379,
				'name' => 'Motion Picture Assistant',
				'description' => 'Motion Picture Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'id' => 2380,
				'name' => 'Motion Picture Director',
				'description' => 'Motion Picture Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'id' => 2381,
				'name' => 'Motion Picture Producer',
				'description' => 'Motion Picture Producer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'id' => 2382,
				'name' => 'Motion Picture Set Decorator',
				'description' => 'Motion Picture Set Decorator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'id' => 2383,
				'name' => 'Motor-Car Designer',
				'description' => 'Motor-Car Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'id' => 2384,
				'name' => 'Motor Coach Driver',
				'description' => 'Motor Coach Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'id' => 2385,
				'name' => 'Motor-Cycle Assembler',
				'description' => 'Motor-Cycle Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'id' => 2386,
				'name' => 'Motor-Cycle Mechanic',
				'description' => 'Motor-Cycle Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'id' => 2387,
				'name' => 'Motorcyclist',
				'description' => 'Motorcyclist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'id' => 2388,
				'name' => 'Motor Engineer',
				'description' => 'Motor Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'id' => 2389,
				'name' => 'Motorized Farm Equipment Operator',
				'description' => 'Motorized Farm Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'id' => 2390,
				'name' => 'Motorized Tricycle Driver',
				'description' => 'Motorized Tricycle Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'id' => 2391,
				'name' => 'Motor Maintenance Clerk',
				'description' => 'Motor Maintenance Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'id' => 2392,
				'name' => 'Motors And Engines (Except Marine And Engineering Assistant, Mechanical',
					'description' => 'Motors And Engines (Except Marine And Engineering Assistant, Mechanical',
						'created_at' => $now,
						'updated_at' => $now,
					),
					392 => 
					array (
						'id' => 2393,
						'name' => 'Motor Vehicle Mechanic',
						'description' => 'Motor Vehicle Mechanic',
						'created_at' => $now,
						'updated_at' => $now,
					),
					393 => 
					array (
						'id' => 2394,
						'name' => 'Motor/Vehicles A17 Examiner',
						'description' => 'Motor/Vehicles A17 Examiner',
						'created_at' => $now,
						'updated_at' => $now,
					),
					394 => 
					array (
						'id' => 2395,
						'name' => 'Moulding/Metal Machine Operator',
						'description' => 'Moulding/Metal Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					395 => 
					array (
						'id' => 2396,
						'name' => 'Moulding Operator',
						'description' => 'Moulding Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					396 => 
					array (
						'id' => 2397,
						'name' => 'Moulding/Rubber Press-Operator',
						'description' => 'Moulding/Rubber Press-Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					397 => 
					array (
						'id' => 2398,
						'name' => 'Mould Maker',
						'description' => 'Mould Maker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					398 => 
					array (
						'id' => 2399,
						'name' => 'Mufti',
						'description' => 'Mufti',
						'created_at' => $now,
						'updated_at' => $now,
					),
					399 => 
					array (
						'id' => 2400,
						'name' => 'Multimedia Programmer',
						'description' => 'Multimedia Programmer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					400 => 
					array (
						'id' => 2401,
						'name' => 'Multi-Media Software Developer',
						'description' => 'Multi-Media Software Developer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					401 => 
					array (
						'id' => 2402,
						'name' => 'Municipal Accountant',
						'description' => 'Municipal Accountant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					402 => 
					array (
						'id' => 2403,
						'name' => 'Museum Curator',
						'description' => 'Museum Curator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					403 => 
					array (
						'id' => 2404,
						'name' => 'Museum Guide',
						'description' => 'Museum Guide',
						'created_at' => $now,
						'updated_at' => $now,
					),
					404 => 
					array (
						'id' => 2405,
						'name' => 'Museum S17 Assistant',
						'description' => 'Museum S17 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					405 => 
					array (
						'id' => 2406,
						'name' => 'Mushroom Farm Worker',
						'description' => 'Mushroom Farm Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					406 => 
					array (
						'id' => 2407,
						'name' => 'Musical Instrument Turner',
						'description' => 'Musical Instrument Turner',
						'created_at' => $now,
						'updated_at' => $now,
					),
					407 => 
					array (
						'id' => 2408,
						'name' => 'Musical Performance Agent',
						'description' => 'Musical Performance Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					408 => 
					array (
						'id' => 2409,
						'name' => 'Music Arranger',
						'description' => 'Music Arranger',
						'created_at' => $now,
						'updated_at' => $now,
					),
					409 => 
					array (
						'id' => 2410,
						'name' => 'Music Composer',
						'description' => 'Music Composer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					410 => 
					array (
						'id' => 2411,
						'name' => 'Music Director',
						'description' => 'Music Director',
						'created_at' => $now,
						'updated_at' => $now,
					),
					411 => 
					array (
						'id' => 2412,
						'name' => 'Musician',
						'description' => 'Musician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					412 => 
					array (
						'id' => 2413,
						'name' => 'Musician B41',
						'description' => 'Musician B41',
						'created_at' => $now,
						'updated_at' => $now,
					),
					413 => 
					array (
						'id' => 2414,
						'name' => 'Musicologist',
						'description' => 'Musicologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					414 => 
					array (
						'id' => 2415,
						'name' => 'Music Teacher',
						'description' => 'Music Teacher',
						'created_at' => $now,
						'updated_at' => $now,
					),
					415 => 
					array (
						'id' => 2416,
						'name' => 'Mycologist',
						'description' => 'Mycologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					416 => 
					array (
						'id' => 2417,
						'name' => 'Mycology Botanist',
						'description' => 'Mycology Botanist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					417 => 
					array (
						'id' => 2418,
						'name' => 'Nail Production Machine Operator',
						'description' => 'Nail Production Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					418 => 
					array (
						'id' => 2419,
						'name' => 'Nanny',
						'description' => 'Nanny',
						'created_at' => $now,
						'updated_at' => $now,
					),
					419 => 
					array (
						'id' => 2420,
					'name' => 'Natural Gas)',
				'description' => 'Natural Gas)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
				'id' => 2421,
				'name' => 'Natural Gas Production And Distribution Engineer',
				'description' => 'Natural Gas Production And Distribution Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'id' => 2422,
				'name' => 'Naturopath',
				'description' => 'Naturopath',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 => 
			array (
				'id' => 2423,
				'name' => 'Naval Architect',
				'description' => 'Naval Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 => 
			array (
				'id' => 2424,
				'name' => 'Navy Captain',
				'description' => 'Navy Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 => 
			array (
				'id' => 2425,
				'name' => 'Navy Lieutenant',
				'description' => 'Navy Lieutenant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 => 
			array (
				'id' => 2426,
				'name' => 'Needle Production Machine Operator',
				'description' => 'Needle Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 => 
			array (
				'id' => 2427,
			'name' => 'Negotiator (Property)',
			'description' => 'Negotiator (Property)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 => 
			array (
				'id' => 2428,
				'name' => 'Nephrology Paediatrician',
				'description' => 'Nephrology Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 => 
			array (
				'id' => 2429,
				'name' => 'Nephrology Physician',
				'description' => 'Nephrology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 => 
			array (
				'id' => 2430,
				'name' => 'Net Production Machine Operator',
				'description' => 'Net Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 => 
			array (
				'id' => 2431,
				'name' => 'Network Administrator',
				'description' => 'Network Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'id' => 2432,
				'name' => 'Network Communications Executive',
				'description' => 'Network Communications Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'id' => 2433,
				'name' => 'Network Driver',
				'description' => 'Network Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'id' => 2434,
				'name' => 'Network Engineer',
				'description' => 'Network Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'id' => 2435,
				'name' => 'Network Operator',
				'description' => 'Network Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'id' => 2436,
				'name' => 'Network Support Technician',
				'description' => 'Network Support Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 => 
			array (
				'id' => 2437,
				'name' => 'Neurologist',
				'description' => 'Neurologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 => 
			array (
				'id' => 2438,
				'name' => 'Neurology Paediatrician',
				'description' => 'Neurology Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 => 
			array (
				'id' => 2439,
				'name' => 'Neurology Physician',
				'description' => 'Neurology Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 => 
			array (
				'id' => 2440,
				'name' => 'Neurology Physiologist',
				'description' => 'Neurology Physiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 => 
			array (
				'id' => 2441,
				'name' => 'Neuropathologist',
				'description' => 'Neuropathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 => 
			array (
				'id' => 2442,
				'name' => 'Neuropathology Pathologist',
				'description' => 'Neuropathology Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 => 
			array (
				'id' => 2443,
				'name' => 'Neurosurgeon',
				'description' => 'Neurosurgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 => 
			array (
				'id' => 2444,
				'name' => 'Neurosurgery Surgeon',
				'description' => 'Neurosurgery Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 => 
			array (
				'id' => 2445,
				'name' => 'Newscaster/Commentator',
				'description' => 'Newscaster/Commentator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 => 
			array (
				'id' => 2446,
				'name' => 'Newspaper/Leaflets Deliverer',
				'description' => 'Newspaper/Leaflets Deliverer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 => 
			array (
				'id' => 2447,
				'name' => 'Newspapers Vendor',
				'description' => 'Newspapers Vendor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 => 
			array (
				'id' => 2448,
				'name' => 'News Photographer',
				'description' => 'News Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 => 
			array (
				'id' => 2449,
				'name' => 'News Reporter',
				'description' => 'News Reporter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 => 
			array (
				'id' => 2450,
			'name' => 'Newsvendor (Street)',
			'description' => 'Newsvendor (Street)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 => 
			array (
				'id' => 2451,
				'name' => 'Night Auditor',
				'description' => 'Night Auditor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 => 
			array (
				'id' => 2452,
				'name' => 'Night Club Dancer',
				'description' => 'Night Club Dancer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 => 
			array (
				'id' => 2453,
				'name' => 'Night Soil Carrier',
				'description' => 'Night Soil Carrier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 => 
			array (
				'id' => 2454,
				'name' => 'Night Watchman',
				'description' => 'Night Watchman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 => 
			array (
				'id' => 2455,
				'name' => 'Non-Government Administration Executive Secretary',
				'description' => 'Non-Government Administration Executive Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 => 
			array (
				'id' => 2456,
				'name' => 'Non-Graduate Teacher DGA29 Officer',
				'description' => 'Non-Graduate Teacher DGA29 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 => 
			array (
				'id' => 2457,
				'name' => 'Noodle Maker',
				'description' => 'Noodle Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 => 
			array (
				'id' => 2458,
				'name' => 'Noodle Production Machine Operator',
				'description' => 'Noodle Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 => 
			array (
				'id' => 2459,
				'name' => 'Nose And Throat Specialist Ear',
				'description' => 'Nose And Throat Specialist Ear',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 => 
			array (
				'id' => 2460,
				'name' => 'Nose And Throat Surgeon, Ear',
				'description' => 'Nose And Throat Surgeon, Ear',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 => 
			array (
				'id' => 2461,
				'name' => 'Notary',
				'description' => 'Notary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 => 
			array (
				'id' => 2462,
				'name' => 'Notice Server N3',
				'description' => 'Notice Server N3',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 => 
			array (
				'id' => 2463,
				'name' => 'Novelist',
				'description' => 'Novelist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 => 
			array (
				'id' => 2464,
				'name' => 'Nuclear/Atomic/Molecular Physicist',
				'description' => 'Nuclear/Atomic/Molecular Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 => 
			array (
				'id' => 2465,
				'name' => 'Nuclear Chemist',
				'description' => 'Nuclear Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 => 
			array (
				'id' => 2466,
				'name' => 'Nuclear Medicine Radiologist',
				'description' => 'Nuclear Medicine Radiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 => 
			array (
				'id' => 2467,
				'name' => 'Nuclear Power Engineer',
				'description' => 'Nuclear Power Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 => 
			array (
				'id' => 2468,
				'name' => 'Numerologist',
				'description' => 'Numerologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 => 
			array (
				'id' => 2469,
				'name' => 'Nurse',
				'description' => 'Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 => 
			array (
				'id' => 2470,
				'name' => 'Nurse Instructor',
				'description' => 'Nurse Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 => 
			array (
				'id' => 2471,
				'name' => 'Nursery School Assistant',
				'description' => 'Nursery School Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 => 
			array (
				'id' => 2472,
				'name' => 'Nursery School Attendant',
				'description' => 'Nursery School Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 => 
			array (
				'id' => 2473,
				'name' => 'Nursery Teacher',
				'description' => 'Nursery Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 => 
			array (
				'id' => 2474,
				'name' => 'Nursery Worker',
				'description' => 'Nursery Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 => 
			array (
				'id' => 2475,
				'name' => 'Nurse Tutor',
				'description' => 'Nurse Tutor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 => 
			array (
				'id' => 2476,
				'name' => 'Nurse U11 Assistant',
				'description' => 'Nurse U11 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 => 
			array (
				'id' => 2477,
				'name' => 'Nurse U29',
				'description' => 'Nurse U29',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 => 
			array (
				'id' => 2478,
				'name' => 'Nursing Aides',
				'description' => 'Nursing Aides',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 => 
			array (
				'id' => 2479,
				'name' => 'Nursing/Home Aid',
				'description' => 'Nursing/Home Aid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 => 
			array (
				'id' => 2480,
				'name' => 'Nursing/Medical Aid',
				'description' => 'Nursing/Medical Aid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 => 
			array (
				'id' => 2481,
				'name' => 'Nut Production/Metal Machine Operator',
				'description' => 'Nut Production/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 => 
			array (
				'id' => 2482,
				'name' => 'Nutritionist',
				'description' => 'Nutritionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 => 
			array (
				'id' => 2483,
				'name' => 'Nut Roaster',
				'description' => 'Nut Roaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 => 
			array (
				'id' => 2484,
				'name' => 'NWP Modeling Meteorologist',
				'description' => 'NWP Modeling Meteorologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 => 
			array (
				'id' => 2485,
				'name' => 'Obstetrician And Gynaecologist',
				'description' => 'Obstetrician And Gynaecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 => 
			array (
				'id' => 2486,
				'name' => 'Occupational Analyst',
				'description' => 'Occupational Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 => 
			array (
				'id' => 2487,
				'name' => 'Occupational Guidance Officer',
				'description' => 'Occupational Guidance Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'id' => 2488,
				'name' => 'Occupational Health And Safety Inspector',
				'description' => 'Occupational Health And Safety Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'id' => 2489,
				'name' => 'Occupational Health And Safety Manager',
				'description' => 'Occupational Health And Safety Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'id' => 2490,
				'name' => 'Occupational Health Nurse',
				'description' => 'Occupational Health Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'id' => 2491,
				'name' => 'Occupational Safety And Health Officer',
				'description' => 'Occupational Safety And Health Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 => 
			array (
				'id' => 2492,
				'name' => 'Occupational Therapist',
				'description' => 'Occupational Therapist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 => 
			array (
				'id' => 2493,
				'name' => 'Oceanographer',
				'description' => 'Oceanographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 => 
			array (
				'id' => 2494,
				'name' => 'Oceanography Geologist',
				'description' => 'Oceanography Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 => 
			array (
				'id' => 2495,
				'name' => 'Oceanography Geophysicist',
				'description' => 'Oceanography Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 => 
			array (
				'id' => 2496,
				'name' => 'Oceanography Technician',
				'description' => 'Oceanography Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 => 
			array (
				'id' => 2497,
				'name' => 'Odd-Jobbing Labourer',
				'description' => 'Odd-Jobbing Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 => 
			array (
				'id' => 2498,
				'name' => 'Odd-Job Person',
				'description' => 'Odd-Job Person',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 => 
			array (
				'id' => 2499,
				'name' => 'Office Boy',
				'description' => 'Office Boy',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 => 
			array (
				'id' => 2500,
				'name' => 'Office Cash Clerk',
				'description' => 'Office Cash Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 2501,
				'name' => 'Office Chief',
				'description' => 'Office Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 2502,
				'name' => 'Office Cleaner',
				'description' => 'Office Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 2503,
				'name' => 'Office Clerk',
				'description' => 'Office Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 2504,
				'name' => 'Office Guard',
				'description' => 'Office Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 2505,
				'name' => 'Office Machinery Assembler',
				'description' => 'Office Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 2506,
				'name' => 'Office Machinery Mechanic',
				'description' => 'Office Machinery Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 2507,
			'name' => 'Office (PAP) N1 General Worker',
			'description' => 'Office (PAP) N1 General Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 2508,
				'name' => 'Officer/Manager Driver',
				'description' => 'Officer/Manager Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 2509,
				'name' => 'Office/Supervisor Cashier',
				'description' => 'Office/Supervisor Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 2510,
			'name' => 'Official Assignee (High Court)',
			'description' => 'Official Assignee (High Court)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 2511,
				'name' => 'Official Electoral',
				'description' => 'Official Electoral',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 2512,
				'name' => 'Oil And Gas Well Acidiser',
				'description' => 'Oil And Gas Well Acidiser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 2513,
				'name' => 'Oil And Gas Wells Shooter',
				'description' => 'Oil And Gas Wells Shooter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 2514,
				'name' => 'Oiler And Greaser/Ship',
				'description' => 'Oiler And Greaser/Ship',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 2515,
				'name' => 'Oil Expeller',
				'description' => 'Oil Expeller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 2516,
				'name' => 'Oil Geologist',
				'description' => 'Oil Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 2517,
				'name' => 'Oil Grader',
				'description' => 'Oil Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 2518,
				'name' => 'Oil Palm Farm Worker',
				'description' => 'Oil Palm Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 2519,
				'name' => 'Oil Palm Grader',
				'description' => 'Oil Palm Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 2520,
				'name' => 'Oil Seed/Palm Oil Miller',
				'description' => 'Oil Seed/Palm Oil Miller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 2521,
				'name' => 'Oil Technologist',
				'description' => 'Oil Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 2522,
				'name' => 'Old Metal Collector',
				'description' => 'Old Metal Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 2523,
				'name' => 'Old Newspaper Collector',
				'description' => 'Old Newspaper Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 2524,
				'name' => 'Olericulture Technician',
				'description' => 'Olericulture Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 2525,
				'name' => 'Olericulturist',
				'description' => 'Olericulturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 2526,
				'name' => 'Oncology Obstetrician And Gynaecologist',
				'description' => 'Oncology Obstetrician And Gynaecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 2527,
				'name' => 'Oncology Paediatrician',
				'description' => 'Oncology Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 2528,
				'name' => 'Operation Clerk',
				'description' => 'Operation Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 2529,
				'name' => 'Operation Manager',
				'description' => 'Operation Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 2530,
				'name' => 'Operation Research Analyst',
				'description' => 'Operation Research Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 2531,
				'name' => 'Operation Supervisor',
				'description' => 'Operation Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 2532,
				'name' => 'Operation Theatre Nurse',
				'description' => 'Operation Theatre Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 2533,
				'name' => 'Operator Camera/Driver',
				'description' => 'Operator Camera/Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 2534,
				'name' => 'Operator Camera/Driver N3',
				'description' => 'Operator Camera/Driver N3',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 2535,
				'name' => 'Operator Magnetic-Separator',
				'description' => 'Operator Magnetic-Separator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 2536,
				'name' => 'Ophtalmic Optician',
				'description' => 'Ophtalmic Optician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 2537,
				'name' => 'Ophthalmologist',
				'description' => 'Ophthalmologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 2538,
				'name' => 'Ophthalmology Surgeon',
				'description' => 'Ophthalmology Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 2539,
				'name' => 'Opinion Polling Enumerator',
				'description' => 'Opinion Polling Enumerator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 2540,
				'name' => 'Opinion-Polling Statistician',
				'description' => 'Opinion-Polling Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 2541,
				'name' => 'Optical Glass Cutter',
				'description' => 'Optical Glass Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 2542,
				'name' => 'Optician',
				'description' => 'Optician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 2543,
				'name' => 'Optometrists',
				'description' => 'Optometrists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 2544,
				'name' => 'Optometrists U41',
				'description' => 'Optometrists U41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 2545,
				'name' => 'Oral/Dentistry Surgeon',
				'description' => 'Oral/Dentistry Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 2546,
				'name' => 'Oral Surgery Dentist',
				'description' => 'Oral Surgery Dentist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 2547,
				'name' => 'Orchestra Conductor',
				'description' => 'Orchestra Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 2548,
				'name' => 'Orchestrator',
				'description' => 'Orchestrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 2549,
				'name' => 'Order Management Clerk',
				'description' => 'Order Management Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 2550,
				'name' => 'Order/Material Clerk',
				'description' => 'Order/Material Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 2551,
				'name' => 'Organic Chemist',
				'description' => 'Organic Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 2552,
				'name' => 'Organization And Methods Analyst',
				'description' => 'Organization And Methods Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 2553,
				'name' => 'Organization And Methods Engineer',
				'description' => 'Organization And Methods Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 2554,
				'name' => 'Organization Chairman',
				'description' => 'Organization Chairman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 2555,
				'name' => 'Organization Chief Executive',
				'description' => 'Organization Chief Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 2556,
				'name' => 'Organization Director',
				'description' => 'Organization Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 2557,
				'name' => 'Organization Director-General',
				'description' => 'Organization Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 2558,
				'name' => 'Organization Managing-Director',
				'description' => 'Organization Managing-Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 2559,
				'name' => 'Organization President',
				'description' => 'Organization President',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 2560,
				'name' => 'Orientation Of The Blind Therapist',
				'description' => 'Orientation Of The Blind Therapist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 2561,
				'name' => 'Ornamental Plasterer',
				'description' => 'Ornamental Plasterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 2562,
				'name' => 'Ornamental Sheet Metal Worker',
				'description' => 'Ornamental Sheet Metal Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 2563,
				'name' => 'Ornithologist',
				'description' => 'Ornithologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 2564,
				'name' => 'Ornithology Zoologist',
				'description' => 'Ornithology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 2565,
				'name' => 'Orthodontist',
				'description' => 'Orthodontist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 2566,
				'name' => 'Orthodontistry Dentist',
				'description' => 'Orthodontistry Dentist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 2567,
				'name' => 'Orthoepist',
				'description' => 'Orthoepist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 2568,
				'name' => 'Orthopaedist',
				'description' => 'Orthopaedist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 2569,
				'name' => 'Orthopedic Appliance Maker And Repairer',
				'description' => 'Orthopedic Appliance Maker And Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 2570,
				'name' => 'Orthopedic Nurse',
				'description' => 'Orthopedic Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 2571,
				'name' => 'Orthopedic Surgeon',
				'description' => 'Orthopedic Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 2572,
				'name' => 'Orthopedic Technician',
				'description' => 'Orthopedic Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 2573,
				'name' => 'Orthophonist',
				'description' => 'Orthophonist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 2574,
				'name' => 'Orthoptist',
				'description' => 'Orthoptist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 2575,
				'name' => 'Osteopath',
				'description' => 'Osteopath',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 2576,
				'name' => 'Osteopathic Surgeon',
				'description' => 'Osteopathic Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 2577,
				'name' => 'Ostrich Farmer',
				'description' => 'Ostrich Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 2578,
				'name' => 'Other Accountants',
				'description' => 'Other Accountants',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 2579,
				'name' => 'Other Accounting And Bookkeeping Clerk',
				'description' => 'Other Accounting And Bookkeeping Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 2580,
				'name' => 'Other Actor',
				'description' => 'Other Actor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 2581,
				'name' => 'Other Advertising And Marketing Professional',
				'description' => 'Other Advertising And Marketing Professional',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 2582,
				'name' => 'Other Agriculture And Industrial Machinery Mechanics And Repairers',
				'description' => 'Other Agriculture And Industrial Machinery Mechanics And Repairers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 2583,
				'name' => 'Other Aircraft Engine Mechanics And Repairers',
				'description' => 'Other Aircraft Engine Mechanics And Repairers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 2584,
				'name' => 'Other Animal Keepers And Trainers',
				'description' => 'Other Animal Keepers And Trainers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 2585,
				'name' => 'Other Apiarists And Sericulturists',
				'description' => 'Other Apiarists And Sericulturists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 2586,
				'name' => 'Other Aquaculture Workers',
				'description' => 'Other Aquaculture Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 2587,
				'name' => 'Other Author And Related Writers',
				'description' => 'Other Author And Related Writers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 2588,
				'name' => 'Other Bank Teller And Related Clerks',
				'description' => 'Other Bank Teller And Related Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 2589,
				'name' => 'Other Bartender',
				'description' => 'Other Bartender',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 2590,
				'name' => 'Other Beauticians And Related Workers',
				'description' => 'Other Beauticians And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 2591,
				'name' => 'Other Bookbinding Machine Operators',
				'description' => 'Other Bookbinding Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 2592,
				'name' => 'Other Bricklayers And Related Workers',
				'description' => 'Other Bricklayers And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 2593,
				'name' => 'Other Broadcasting Technicians',
				'description' => 'Other Broadcasting Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 2594,
				'name' => 'Other Building Architects',
				'description' => 'Other Building Architects',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 2595,
				'name' => 'Other Building Caretakers',
				'description' => 'Other Building Caretakers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 2596,
				'name' => 'Other Building Construction Labourers',
				'description' => 'Other Building Construction Labourers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 2597,
				'name' => 'Other Building Frame And Related Trades Workers Not Elsewhere Classified',
				'description' => 'Other Building Frame And Related Trades Workers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 2598,
				'name' => 'Other Building Structure Cleaners',
				'description' => 'Other Building Structure Cleaners',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 2599,
				'name' => 'Other Business Services Agents',
				'description' => 'Other Business Services Agents',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 2600,
				'name' => 'Other Buyers And Purchasing Officers',
				'description' => 'Other Buyers And Purchasing Officers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 2601,
				'name' => 'Other Cabinet-Makers And Related Workers',
				'description' => 'Other Cabinet-Makers And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 2602,
				'name' => 'Other Carpenters And Joiners',
				'description' => 'Other Carpenters And Joiners',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 2603,
				'name' => 'Other Cartographer And Surveyors',
				'description' => 'Other Cartographer And Surveyors',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 2604,
				'name' => 'Other Cashiers And Ticket Clerks',
				'description' => 'Other Cashiers And Ticket Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 2605,
				'name' => 'Other Charcoal Burners And Related Workers',
				'description' => 'Other Charcoal Burners And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 2606,
				'name' => 'Other Chemical And Physical Science Technicians',
				'description' => 'Other Chemical And Physical Science Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 2607,
				'name' => 'Other Chemical Engineering Technicians',
				'description' => 'Other Chemical Engineering Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 2608,
				'name' => 'Other Chemical Engineers',
				'description' => 'Other Chemical Engineers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 2609,
				'name' => 'Other Chemist',
				'description' => 'Other Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 2610,
				'name' => 'Other Child Care Workers',
				'description' => 'Other Child Care Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 2611,
				'name' => 'Other Civil Engineers',
				'description' => 'Other Civil Engineers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 2612,
				'name' => 'Other Clerical Support Workers Not Elsewhere Classified',
				'description' => 'Other Clerical Support Workers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 2613,
				'name' => 'Other Client Information Workers Not Elsewhere Classified',
				'description' => 'Other Client Information Workers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 2614,
				'name' => 'Other Commercial Sales Representative',
				'description' => 'Other Commercial Sales Representative',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 2615,
				'name' => 'Other Companions And Valets',
				'description' => 'Other Companions And Valets',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 2616,
				'name' => 'Other Contact Centre Information Clerks',
				'description' => 'Other Contact Centre Information Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 2617,
				'name' => 'Other Cooks',
				'description' => 'Other Cooks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 2618,
				'name' => 'Other Creative Or Performing Artists',
				'description' => 'Other Creative Or Performing Artists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 2619,
				'name' => 'Other Crop Farm Labourers',
				'description' => 'Other Crop Farm Labourers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 2620,
				'name' => 'Other Dancers And Choreographers',
				'description' => 'Other Dancers And Choreographers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 2621,
				'name' => 'Other Database Designers And Administrators',
				'description' => 'Other Database Designers And Administrators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 2622,
				'name' => 'Other Data Entry Operators',
				'description' => 'Other Data Entry Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 2623,
				'name' => 'Other Debt-Collectors And Related Workers Not Elsewhere Classified',
				'description' => 'Other Debt-Collectors And Related Workers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 2624,
				'name' => 'Other Dentists',
				'description' => 'Other Dentists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 2625,
				'name' => 'Other Dieticians And Nutritionists',
				'description' => 'Other Dieticians And Nutritionists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 2626,
				'name' => 'Other Domestic Cleaners And Helpers',
				'description' => 'Other Domestic Cleaners And Helpers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 2627,
				'name' => 'Other Domestic Housekeeper',
				'description' => 'Other Domestic Housekeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 2628,
				'name' => 'Other Door To Door Salespersons',
				'description' => 'Other Door To Door Salespersons',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 2629,
				'name' => 'Other Earth-Moving And Related Machinery Operators',
				'description' => 'Other Earth-Moving And Related Machinery Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 2630,
				'name' => 'Other Economic-Interest Organization Senior Official',
				'description' => 'Other Economic-Interest Organization Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 2631,
				'name' => 'Other Economists',
				'description' => 'Other Economists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 2632,
				'name' => 'Other Electrical Engineer',
				'description' => 'Other Electrical Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 2633,
				'name' => 'Other Electrical Engineering Technicians',
				'description' => 'Other Electrical Engineering Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 2634,
				'name' => 'Other Electronics Engineering Technicians',
				'description' => 'Other Electronics Engineering Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 2635,
				'name' => 'Other Electronics Engineers',
				'description' => 'Other Electronics Engineers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 2636,
				'name' => 'Other Enquiry Clerks',
				'description' => 'Other Enquiry Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 2637,
				'name' => 'Other Environmental And Occupational Health And Hygiene Professionals',
				'description' => 'Other Environmental And Occupational Health And Hygiene Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 2638,
				'name' => 'Other Environmental Protection Professionals',
				'description' => 'Other Environmental Protection Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 2639,
				'name' => 'Other Fashion And Models',
				'description' => 'Other Fashion And Models',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 2640,
				'name' => 'Other Fibre Preparers',
				'description' => 'Other Fibre Preparers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 2641,
				'name' => 'Other Field Crop And Plantation Growers',
				'description' => 'Other Field Crop And Plantation Growers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 2642,
				'name' => 'Other Filing And Copying Clerks',
				'description' => 'Other Filing And Copying Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 2643,
				'name' => 'Other Financial Analysts',
				'description' => 'Other Financial Analysts',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 2644,
				'name' => 'Other Fire-Fighters',
				'description' => 'Other Fire-Fighters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 2645,
				'name' => 'Other Fishery And Aquaculture Labourers',
				'description' => 'Other Fishery And Aquaculture Labourers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 2646,
				'name' => 'Other Floor Layers And Tile Setters',
				'description' => 'Other Floor Layers And Tile Setters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 2647,
				'name' => 'Other Food And Beverage Tasters And Graders',
				'description' => 'Other Food And Beverage Tasters And Graders',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 2648,
				'name' => 'Other Food Service Counter Attendants',
				'description' => 'Other Food Service Counter Attendants',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 2649,
				'name' => 'Other Forestry And Related Workers',
				'description' => 'Other Forestry And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 2650,
				'name' => 'Other Forestry Labourers',
				'description' => 'Other Forestry Labourers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 2651,
				'name' => 'Other Fur And Leather Preparing Machine Operators',
				'description' => 'Other Fur And Leather Preparing Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 2652,
				'name' => 'Other Garbage And Recycling Collectors',
				'description' => 'Other Garbage And Recycling Collectors',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 2653,
				'name' => 'Other Garden And Horticultural Labourers',
				'description' => 'Other Garden And Horticultural Labourers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 2654,
				'name' => 'Other Garment And Related Pattern-Makers And Cutters',
				'description' => 'Other Garment And Related Pattern-Makers And Cutters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 2655,
				'name' => 'Other Generalist Medical Practitioners',
				'description' => 'Other Generalist Medical Practitioners',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 2656,
				'name' => 'Other General Office Clerks',
				'description' => 'Other General Office Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 2657,
				'name' => 'Other Geologists And Geophysicists',
				'description' => 'Other Geologists And Geophysicists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 2658,
				'name' => 'Other Glass And Ceramics Kiln And Related Machine Operators',
				'description' => 'Other Glass And Ceramics Kiln And Related Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 2659,
				'name' => 'Other Glaziers',
				'description' => 'Other Glaziers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 2660,
				'name' => 'Other Hairdresser',
				'description' => 'Other Hairdresser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 2661,
				'name' => 'Other Health Care Assistants',
				'description' => 'Other Health Care Assistants',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 2662,
				'name' => 'Other Health Services Managers',
				'description' => 'Other Health Services Managers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 2663,
				'name' => 'Other Heavy Truck And Lorry Drivers',
				'description' => 'Other Heavy Truck And Lorry Drivers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 2664,
				'name' => 'Other Home-Based Personal Care Workers',
				'description' => 'Other Home-Based Personal Care Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 2665,
				'name' => 'Other Hotel Managers',
				'description' => 'Other Hotel Managers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 2666,
				'name' => 'Other Hotel Receptionist',
				'description' => 'Other Hotel Receptionist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 2667,
				'name' => 'Other House Building And Related Workers Not Elsewhere Classified',
				'description' => 'Other House Building And Related Workers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 2668,
				'name' => 'Other Industry And Production Engineer',
				'description' => 'Other Industry And Production Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 2669,
				'name' => 'Other Information And Communications Technology Installers And Services',
				'description' => 'Other Information And Communications Technology Installers And Services',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 2670,
				'name' => 'Other Inland And Coastal Water Fishery Workers',
				'description' => 'Other Inland And Coastal Water Fishery Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 2671,
				'name' => 'Other Instructors',
				'description' => 'Other Instructors',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 2672,
				'name' => 'Other Insulation Workers',
				'description' => 'Other Insulation Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 2673,
				'name' => 'Other Interior Designer And Decorators',
				'description' => 'Other Interior Designer And Decorators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 2674,
				'name' => 'Other Jewellery And Precious-Metal Workers',
				'description' => 'Other Jewellery And Precious-Metal Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 2675,
				'name' => 'Other Journalist',
				'description' => 'Other Journalist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 2676,
				'name' => 'Other Judges',
				'description' => 'Other Judges',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 2677,
				'name' => 'Other Landscape Architect',
				'description' => 'Other Landscape Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 2678,
				'name' => 'Other Lawyer',
				'description' => 'Other Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 2679,
				'name' => 'Other Legal Professionals Not Elsewhere Classified',
				'description' => 'Other Legal Professionals Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 2680,
				'name' => 'Other Legislator',
				'description' => 'Other Legislator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 2681,
				'name' => 'Other Librarians And Related Professionals',
				'description' => 'Other Librarians And Related Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 2682,
				'name' => 'Other Library Clerks',
				'description' => 'Other Library Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 2683,
				'name' => 'Other Life Science Technicians',
				'description' => 'Other Life Science Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 2684,
				'name' => 'Other Livestock And Dairy Producers',
				'description' => 'Other Livestock And Dairy Producers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 2685,
				'name' => 'Other Machine-Tool Setter-Operators',
				'description' => 'Other Machine-Tool Setter-Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 2686,
				'name' => 'Other Mail Carriers And Sorting Clerks',
				'description' => 'Other Mail Carriers And Sorting Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 2687,
				'name' => 'Other Management And Organization Analysts',
				'description' => 'Other Management And Organization Analysts',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 2688,
				'name' => 'Other Manufacturing Labourers Not Elsewhere Classified',
				'description' => 'Other Manufacturing Labourers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 2689,
				'name' => 'Other Market Gardeners And Crop Growers',
				'description' => 'Other Market Gardeners And Crop Growers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 2690,
				'name' => 'Other Material And Freight Handling Worker',
				'description' => 'Other Material And Freight Handling Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 2691,
				'name' => 'Other Mechanical Engineering Technicians',
				'description' => 'Other Mechanical Engineering Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 2692,
				'name' => 'Other Mechanical Engineers',
				'description' => 'Other Mechanical Engineers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 2693,
				'name' => 'Other Mechanical Machinery Assemblers',
				'description' => 'Other Mechanical Machinery Assemblers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 2694,
				'name' => 'Other Medical Assistant',
				'description' => 'Other Medical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 2695,
				'name' => 'Other Messengers And Porters',
				'description' => 'Other Messengers And Porters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 2696,
				'name' => 'Other Metal Processing And Finishing Plant Operators',
				'description' => 'Other Metal Processing And Finishing Plant Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 2697,
				'name' => 'Other Metal Working Machine Tool Setters And Operators',
				'description' => 'Other Metal Working Machine Tool Setters And Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 2698,
				'name' => 'Other Meteorologist',
				'description' => 'Other Meteorologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 2699,
				'name' => 'Other Mineral And Stone Processing Plant Operators',
				'description' => 'Other Mineral And Stone Processing Plant Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 2700,
				'name' => 'Other Miners And Quarries',
				'description' => 'Other Miners And Quarries',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 2701,
				'name' => 'Other Mining And Metallurgical Technicians',
				'description' => 'Other Mining And Metallurgical Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 2702,
				'name' => 'Other Mining And Quaryying Workers',
				'description' => 'Other Mining And Quaryying Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 2703,
				'name' => 'Other Mining Engineers And Metallurgist',
				'description' => 'Other Mining Engineers And Metallurgist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 2704,
				'name' => 'Other Mixed Crop And Livestock Farm Labourers',
				'description' => 'Other Mixed Crop And Livestock Farm Labourers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 2705,
				'name' => 'Other Motorized Farm And Forestry Plant Operators',
				'description' => 'Other Motorized Farm And Forestry Plant Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 2706,
				'name' => 'Other Motor Vehicle Mechanics And Repairs',
				'description' => 'Other Motor Vehicle Mechanics And Repairs',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 2707,
				'name' => 'Other Musical Instrument Makers And Turners',
				'description' => 'Other Musical Instrument Makers And Turners',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 2708,
			'name' => 'Other Nursing Associate Professionals (Except Dental)',
			'description' => 'Other Nursing Associate Professionals (Except Dental)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 2709,
				'name' => 'Other Painters Related Workers',
				'description' => 'Other Painters Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 2710,
				'name' => 'Other Paper Products Machine Operators',
				'description' => 'Other Paper Products Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 2711,
				'name' => 'Other Pawnbrokers And Money-Lenders',
				'description' => 'Other Pawnbrokers And Money-Lenders',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 2712,
				'name' => 'Other Personnel And Careers Professionals',
				'description' => 'Other Personnel And Careers Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 2713,
				'name' => 'Other Personnel Clerks',
				'description' => 'Other Personnel Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 2714,
				'name' => 'Other Pet Groomers And Animal Care Workers',
				'description' => 'Other Pet Groomers And Animal Care Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 2715,
				'name' => 'Other Petroleum And Natural Gas Refining Plant Operators',
				'description' => 'Other Petroleum And Natural Gas Refining Plant Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 2716,
				'name' => 'Other Pharmacist',
				'description' => 'Other Pharmacist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 2717,
				'name' => 'Other Photographer',
				'description' => 'Other Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 2718,
				'name' => 'Other Photographic Products Machine Operator And Related',
				'description' => 'Other Photographic Products Machine Operator And Related',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 2719,
				'name' => 'Other Physical And Engineering Science Technicians Not Elsewhere Classified',
				'description' => 'Other Physical And Engineering Science Technicians Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 2720,
				'name' => 'Other Physicist And Astronomers',
				'description' => 'Other Physicist And Astronomers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 2721,
				'name' => 'Other Physiotherapy Technician And Assistants',
				'description' => 'Other Physiotherapy Technician And Assistants',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 2722,
				'name' => 'Other Plasterers',
				'description' => 'Other Plasterers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 2723,
				'name' => 'Other Plastics Product Machine Operators',
				'description' => 'Other Plastics Product Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 2724,
				'name' => 'Other Plumbers And Pipe Fitters',
				'description' => 'Other Plumbers And Pipe Fitters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 2725,
				'name' => 'Other Police Officers',
				'description' => 'Other Police Officers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 2726,
				'name' => 'Other Policy Administration Professional',
				'description' => 'Other Policy Administration Professional',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 2727,
				'name' => 'Other Potters And Related Workers',
				'description' => 'Other Potters And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 2728,
				'name' => 'Other Poultry Producers',
				'description' => 'Other Poultry Producers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 2729,
				'name' => 'Other Precision Instrument Makers And Repairers',
				'description' => 'Other Precision Instrument Makers And Repairers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 2730,
				'name' => 'Other Pre-Press Technicians',
				'description' => 'Other Pre-Press Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 2731,
				'name' => 'Other Printers',
				'description' => 'Other Printers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 2732,
				'name' => 'Other Print Finishing And Binding Workers',
				'description' => 'Other Print Finishing And Binding Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 2733,
				'name' => 'Other Printing And Photo Engravers And Etchers',
				'description' => 'Other Printing And Photo Engravers And Etchers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 2734,
				'name' => 'Other Printing Paper Machine Operators',
				'description' => 'Other Printing Paper Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 2735,
				'name' => 'Other Prison Guards',
				'description' => 'Other Prison Guards',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 2736,
				'name' => 'Other Product And Garment Designers',
				'description' => 'Other Product And Garment Designers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 2737,
				'name' => 'Other Production Clerks',
				'description' => 'Other Production Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 2738,
				'name' => 'Other Programmers',
				'description' => 'Other Programmers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 2739,
				'name' => 'Other Protective Service And Related Workers Not Elsewhere Classified',
				'description' => 'Other Protective Service And Related Workers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 2740,
				'name' => 'Other Public Relation Professional',
				'description' => 'Other Public Relation Professional',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 2741,
				'name' => 'Other Pulp And Papermaking Plant Operators',
				'description' => 'Other Pulp And Papermaking Plant Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 2742,
				'name' => 'Other Railway Braker And Related Workers',
				'description' => 'Other Railway Braker And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 2743,
				'name' => 'Other Railway Engine And LRT Train Drivers',
				'description' => 'Other Railway Engine And LRT Train Drivers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 2744,
				'name' => 'Other Receptionists',
				'description' => 'Other Receptionists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 2745,
				'name' => 'Other Religion Teachers',
				'description' => 'Other Religion Teachers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 2746,
				'name' => 'Other Religious Associate Professionals',
				'description' => 'Other Religious Associate Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 2747,
				'name' => 'Other Religious Professional',
				'description' => 'Other Religious Professional',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 2748,
				'name' => 'Other Restaurant Managers',
				'description' => 'Other Restaurant Managers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 2749,
				'name' => 'Other Riggers And Cable Splicer',
				'description' => 'Other Riggers And Cable Splicer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 2750,
				'name' => 'Other Roofers',
				'description' => 'Other Roofers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 2751,
				'name' => 'Other Rubber Processing Workers',
				'description' => 'Other Rubber Processing Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 2752,
				'name' => 'Other Rubber Production Machine Operators',
				'description' => 'Other Rubber Production Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 2753,
				'name' => 'Other Sales Demonstrators',
				'description' => 'Other Sales Demonstrators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 2754,
				'name' => 'Other Sales Supervisor',
				'description' => 'Other Sales Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 2755,
				'name' => 'Other Scribes And Related Workers',
				'description' => 'Other Scribes And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 2756,
				'name' => 'Other Secretaries Not Elsewhere Classified',
				'description' => 'Other Secretaries Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 2757,
				'name' => 'Other Securities And Finance Dealers And Brokers',
				'description' => 'Other Securities And Finance Dealers And Brokers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 2758,
				'name' => 'Other Security Guards',
				'description' => 'Other Security Guards',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 2759,
				'name' => 'Other Senior Government Officials',
				'description' => 'Other Senior Government Officials',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 2760,
				'name' => 'Other Senior Officials Of Special – Interest Organizations',
				'description' => 'Other Senior Officials Of Special – Interest Organizations',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 2761,
				'name' => 'Other Service Station Attendants',
				'description' => 'Other Service Station Attendants',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 2762,
				'name' => 'Other Sewing Machine Operators',
				'description' => 'Other Sewing Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 2763,
				'name' => 'Other Sheet Metal Workers',
				'description' => 'Other Sheet Metal Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 2764,
				'name' => 'Other Ship’S Deck Crew And Related Workers',
				'description' => 'Other Ship’S Deck Crew And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 2765,
				'name' => 'Other Ship’S Deck Officers And Pilot',
				'description' => 'Other Ship’S Deck Officers And Pilot',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 2766,
				'name' => 'Other Ship’S Engineers',
				'description' => 'Other Ship’S Engineers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 2767,
				'name' => 'Other Shoemakers And Related Workers',
				'description' => 'Other Shoemakers And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 2768,
				'name' => 'Other Shoemaking And Related Machine Operators',
				'description' => 'Other Shoemaking And Related Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 2769,
				'name' => 'Other Shopkeeper',
				'description' => 'Other Shopkeeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 2770,
				'name' => 'Other Shop Sales Assistants',
				'description' => 'Other Shop Sales Assistants',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 2771,
				'name' => 'Others Metal Moulders And Coremakers',
				'description' => 'Others Metal Moulders And Coremakers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 2772,
				'name' => 'Other Social Work Associate Professionals',
				'description' => 'Other Social Work Associate Professionals',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 2773,
				'name' => 'Other Software Developer',
				'description' => 'Other Software Developer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 2774,
				'name' => 'Other Spray Painters And Varnishers',
				'description' => 'Other Spray Painters And Varnishers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 2775,
				'name' => 'Other Stall And Market Salespersons',
				'description' => 'Other Stall And Market Salespersons',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 2776,
				'name' => 'Other Statisticians',
				'description' => 'Other Statisticians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 2777,
				'name' => 'Other Steam Engine And Boiler Operators',
				'description' => 'Other Steam Engine And Boiler Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 2778,
				'name' => 'Other Stock Clerks',
				'description' => 'Other Stock Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 2779,
				'name' => 'Others Transport Clerks',
				'description' => 'Others Transport Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 2780,
				'name' => 'Other Street Food Salespersons',
				'description' => 'Other Street Food Salespersons',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 2781,
				'name' => 'Other Structural Metal Preparers And Erectors',
				'description' => 'Other Structural Metal Preparers And Erectors',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 2782,
				'name' => 'Other Systems Analysts',
				'description' => 'Other Systems Analysts',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 2783,
				'name' => 'Other Teachers’ Aids',
				'description' => 'Other Teachers’ Aids',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 2784,
				'name' => 'Other Technical And Medical Sales',
				'description' => 'Other Technical And Medical Sales',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 2785,
				'name' => 'Other Telecommunication Engineers',
				'description' => 'Other Telecommunication Engineers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 2786,
				'name' => 'Other Telecommunications Engineering Technicians',
				'description' => 'Other Telecommunications Engineering Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 2787,
				'name' => 'Other Telephone Switchboard Operators',
				'description' => 'Other Telephone Switchboard Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 2788,
				'name' => 'Other Textile And Leather Products Machine Operator Not Elsewhere Classified',
				'description' => 'Other Textile And Leather Products Machine Operator Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 2789,
				'name' => 'Other Textile Treating Machine Operators',
				'description' => 'Other Textile Treating Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 2790,
				'name' => 'Other Tobacco Preparers And Tobacco Products Makers',
				'description' => 'Other Tobacco Preparers And Tobacco Products Makers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 2791,
				'name' => 'Other Toolmakers And Related Workers',
				'description' => 'Other Toolmakers And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 2792,
				'name' => 'Other Town And Traffic Planners',
				'description' => 'Other Town And Traffic Planners',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 2793,
				'name' => 'Other Traditional Chiefs And Heads Of Village',
				'description' => 'Other Traditional Chiefs And Heads Of Village',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 2794,
				'name' => 'Other Traditional Medicine Practitioner',
				'description' => 'Other Traditional Medicine Practitioner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 2795,
				'name' => 'Other Transport Conductors And Related Workers',
				'description' => 'Other Transport Conductors And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 2796,
				'name' => 'Other Transport Controllers',
				'description' => 'Other Transport Controllers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 2797,
				'name' => 'Other Transport Technicians',
				'description' => 'Other Transport Technicians',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 2798,
				'name' => 'Other Travel Attendants And Travel Stewards',
				'description' => 'Other Travel Attendants And Travel Stewards',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 2799,
				'name' => 'Other Travel Consultants And Related Clerks',
				'description' => 'Other Travel Consultants And Related Clerks',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 2800,
				'name' => 'Other Travel Guides',
				'description' => 'Other Travel Guides',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 2801,
				'name' => 'Other Tree And Shrub Crop Growers',
				'description' => 'Other Tree And Shrub Crop Growers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 2802,
				'name' => 'Other Undertakers And Embalmers',
				'description' => 'Other Undertakers And Embalmers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 2803,
				'name' => 'Other Upholsterers And Related Workers',
				'description' => 'Other Upholsterers And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 2804,
				'name' => 'Other Vehicle Cleaner And Related Workers',
				'description' => 'Other Vehicle Cleaner And Related Workers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 2805,
				'name' => 'Other Veterinarian',
				'description' => 'Other Veterinarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 2806,
				'name' => 'Other Visual Artists',
				'description' => 'Other Visual Artists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 2807,
				'name' => 'Other Vocational Education Teacher',
				'description' => 'Other Vocational Education Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 2808,
				'name' => 'Other Waiter And Waitress',
				'description' => 'Other Waiter And Waitress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 2809,
				'name' => 'Other Weaving And Knitting Machine Operators',
				'description' => 'Other Weaving And Knitting Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 2810,
				'name' => 'Other Web And Multimedia Developer',
				'description' => 'Other Web And Multimedia Developer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 2811,
				'name' => 'Other Welders And Flame Cutters',
				'description' => 'Other Welders And Flame Cutters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 2812,
				'name' => 'Other Wood Processing Plant Operators',
				'description' => 'Other Wood Processing Plant Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 2813,
				'name' => 'Other Wood Products Machine Operators',
				'description' => 'Other Wood Products Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 2814,
				'name' => 'Other Wood Treaters',
				'description' => 'Other Wood Treaters',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'id' => 2815,
				'name' => 'Other Word Processor And Related Operators',
				'description' => 'Other Word Processor And Related Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'id' => 2816,
				'name' => 'Otolaryngologist',
				'description' => 'Otolaryngologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'id' => 2817,
				'name' => 'Outdoor Adventure Guides',
				'description' => 'Outdoor Adventure Guides',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'id' => 2818,
				'name' => 'Outlet Supervisor',
				'description' => 'Outlet Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'id' => 2819,
				'name' => 'Oxidizer',
				'description' => 'Oxidizer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'id' => 2820,
				'name' => 'Oxygen Plant Operator',
				'description' => 'Oxygen Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'id' => 2821,
				'name' => 'Oyster Diver',
				'description' => 'Oyster Diver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'id' => 2822,
				'name' => 'Oyster Farm Worker',
				'description' => 'Oyster Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 => 
			array (
				'id' => 2823,
				'name' => 'Package Designer',
				'description' => 'Package Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 => 
			array (
				'id' => 2824,
				'name' => 'Packaging Supervisor',
				'description' => 'Packaging Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 => 
			array (
				'id' => 2825,
				'name' => 'Packaging Technologist',
				'description' => 'Packaging Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 => 
			array (
				'id' => 2826,
				'name' => 'Packer',
				'description' => 'Packer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 => 
			array (
				'id' => 2827,
				'name' => 'Packing Clerk',
				'description' => 'Packing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 => 
			array (
				'id' => 2828,
				'name' => 'Packing Machine Operator',
				'description' => 'Packing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 => 
			array (
				'id' => 2829,
				'name' => 'Packing Operator',
				'description' => 'Packing Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 => 
			array (
				'id' => 2830,
				'name' => 'Padi Farm Worker',
				'description' => 'Padi Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 => 
			array (
				'id' => 2831,
				'name' => 'Padi Grader/Examiner/Sorter',
				'description' => 'Padi Grader/Examiner/Sorter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 => 
			array (
				'id' => 2832,
				'name' => 'Paediatrician',
				'description' => 'Paediatrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 => 
			array (
				'id' => 2833,
				'name' => 'Paediatric Nurse',
				'description' => 'Paediatric Nurse',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 => 
			array (
				'id' => 2834,
				'name' => 'Paediatric Surgeon',
				'description' => 'Paediatric Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 => 
			array (
				'id' => 2835,
				'name' => 'Paint Chemist',
				'description' => 'Paint Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 => 
			array (
				'id' => 2836,
				'name' => 'Painting Artist',
				'description' => 'Painting Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 => 
			array (
				'id' => 2837,
				'name' => 'Paint-Mixing Machine Operators',
				'description' => 'Paint-Mixing Machine Operators',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 => 
			array (
				'id' => 2838,
				'name' => 'Paint Technologist',
				'description' => 'Paint Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'id' => 2839,
				'name' => 'Palaeontologist',
				'description' => 'Palaeontologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'id' => 2840,
				'name' => 'Palaeontology Geologist',
				'description' => 'Palaeontology Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'id' => 2841,
				'name' => 'Palmist',
				'description' => 'Palmist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'id' => 2842,
				'name' => 'Paperboard Products Assembler',
				'description' => 'Paperboard Products Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'id' => 2843,
				'name' => 'Paper Cutter',
				'description' => 'Paper Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'id' => 2844,
				'name' => 'Papermaking Machine Operator',
				'description' => 'Papermaking Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'id' => 2845,
				'name' => 'Paper Pattern-Maker',
				'description' => 'Paper Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'id' => 2846,
				'name' => 'Paper Products Machine Operator',
				'description' => 'Paper Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'id' => 2847,
				'name' => 'Paper Pulp Cutter',
				'description' => 'Paper Pulp Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'id' => 2848,
				'name' => 'Paper-Pulp Plant Operator',
				'description' => 'Paper-Pulp Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'id' => 2849,
				'name' => 'Paper Pulp Valve Operator',
				'description' => 'Paper Pulp Valve Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'id' => 2850,
				'name' => 'Paper Searcher',
				'description' => 'Paper Searcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 => 
			array (
				'id' => 2851,
				'name' => 'Paper Technologist',
				'description' => 'Paper Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 => 
			array (
				'id' => 2852,
				'name' => 'Paraffin Plant Operator',
				'description' => 'Paraffin Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 => 
			array (
				'id' => 2853,
				'name' => 'Parasitological Assistant',
				'description' => 'Parasitological Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 => 
			array (
				'id' => 2854,
				'name' => 'Parasitologist',
				'description' => 'Parasitologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 => 
			array (
				'id' => 2855,
				'name' => 'Parasitology Zoologist',
				'description' => 'Parasitology Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 => 
			array (
				'id' => 2856,
				'name' => 'Parker Cashier',
				'description' => 'Parker Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 => 
			array (
				'id' => 2857,
				'name' => 'Park/Estate G17 Assistant',
				'description' => 'Park/Estate G17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 => 
			array (
				'id' => 2858,
				'name' => 'Park/Estate G27 Assistant Manager',
				'description' => 'Park/Estate G27 Assistant Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 => 
			array (
				'id' => 2859,
				'name' => 'Park/Estate G41 Manager',
				'description' => 'Park/Estate G41 Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 => 
			array (
				'id' => 2860,
				'name' => 'Parking Attendant',
				'description' => 'Parking Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 => 
			array (
				'id' => 2861,
				'name' => 'Parks And Land Care Manager, Environment',
				'description' => 'Parks And Land Care Manager, Environment',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 => 
			array (
				'id' => 2862,
				'name' => 'Park Sweeper',
				'description' => 'Park Sweeper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'id' => 2863,
				'name' => 'Parliamentarian',
				'description' => 'Parliamentarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'id' => 2864,
				'name' => 'Parliamentary Drafter',
				'description' => 'Parliamentary Drafter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'id' => 2865,
				'name' => 'Parliament Herald N3',
				'description' => 'Parliament Herald N3',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'id' => 2866,
				'name' => 'Parquetry Worker',
				'description' => 'Parquetry Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'id' => 2867,
				'name' => 'Passenger Train Guard',
				'description' => 'Passenger Train Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'id' => 2868,
				'name' => 'Passport Checking Officer',
				'description' => 'Passport Checking Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'id' => 2869,
				'name' => 'Passport Issuing Officer',
				'description' => 'Passport Issuing Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'id' => 2870,
				'name' => 'Pasta Production Machine Operator',
				'description' => 'Pasta Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'id' => 2871,
			'name' => 'Pasteurizer (Brewery) Attendant',
			'description' => 'Pasteurizer (Brewery) Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 => 
			array (
				'id' => 2872,
				'name' => 'Pastry Baker',
				'description' => 'Pastry Baker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 => 
			array (
				'id' => 2873,
				'name' => 'Pastry Chef',
				'description' => 'Pastry Chef',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 => 
			array (
				'id' => 2874,
				'name' => 'Pastry – Cooks And Confectionery Makers Other Bakers',
				'description' => 'Pastry – Cooks And Confectionery Makers Other Bakers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 => 
			array (
				'id' => 2875,
				'name' => 'Pastry Production Machine Operator',
				'description' => 'Pastry Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 => 
			array (
				'id' => 2876,
				'name' => 'Patent Agent',
				'description' => 'Patent Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 => 
			array (
				'id' => 2877,
				'name' => 'Patent Q41 Inspector',
				'description' => 'Patent Q41 Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'id' => 2878,
				'name' => 'Patent Roofing Glazier',
				'description' => 'Patent Roofing Glazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'id' => 2879,
				'name' => 'Pathologist',
				'description' => 'Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'id' => 2880,
				'name' => 'Pathology Technician',
				'description' => 'Pathology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'id' => 2881,
				'name' => 'Pattern-Making/Leather Machine Operator',
				'description' => 'Pattern-Making/Leather Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'id' => 2882,
				'name' => 'Pattern-Making/Textiles Machine Operator',
				'description' => 'Pattern-Making/Textiles Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'id' => 2883,
				'name' => 'Paviour',
				'description' => 'Paviour',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'id' => 2884,
				'name' => 'Pawnbroker',
				'description' => 'Pawnbroker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'id' => 2885,
				'name' => 'Paymaster',
				'description' => 'Paymaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'id' => 2886,
				'name' => 'Payment Collector',
				'description' => 'Payment Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'id' => 2887,
				'name' => 'Payroll Clerk',
				'description' => 'Payroll Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'id' => 2888,
				'name' => 'Peanut Butter Maker',
				'description' => 'Peanut Butter Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'id' => 2889,
				'name' => 'Pearl Culturist',
				'description' => 'Pearl Culturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'id' => 2890,
				'name' => 'Pearl Diver',
				'description' => 'Pearl Diver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'id' => 2891,
				'name' => 'Pedal Vehicle Driver',
				'description' => 'Pedal Vehicle Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'id' => 2892,
				'name' => 'Pedler',
				'description' => 'Pedler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'id' => 2893,
				'name' => 'Pedodontist',
				'description' => 'Pedodontist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'id' => 2894,
				'name' => 'Pedodontistry Dentist',
				'description' => 'Pedodontistry Dentist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'id' => 2895,
				'name' => 'Pelletising Machine Operator',
				'description' => 'Pelletising Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'id' => 2896,
				'name' => 'Pencil Production Machine Operator',
				'description' => 'Pencil Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'id' => 2897,
				'name' => 'Penggawa',
				'description' => 'Penggawa',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'id' => 2898,
				'name' => 'Penghulu',
				'description' => 'Penghulu',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'id' => 2899,
				'name' => 'Penologist',
				'description' => 'Penologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'id' => 2900,
				'name' => 'Performer/Trainer In Crocodile Farm',
				'description' => 'Performer/Trainer In Crocodile Farm',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'id' => 2901,
				'name' => 'Periodontist',
				'description' => 'Periodontist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'id' => 2902,
				'name' => 'Periodontistry Dentist',
				'description' => 'Periodontistry Dentist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'id' => 2903,
				'name' => 'Personal Assistant',
				'description' => 'Personal Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'id' => 2904,
				'name' => 'Personal Care Manager',
				'description' => 'Personal Care Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 => 
			array (
				'id' => 2905,
				'name' => 'Personal Computer Support Technician',
				'description' => 'Personal Computer Support Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 => 
			array (
				'id' => 2906,
				'name' => 'Personal Driver',
				'description' => 'Personal Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 => 
			array (
				'id' => 2907,
				'name' => 'Personnel Assistant',
				'description' => 'Personnel Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 => 
			array (
				'id' => 2908,
				'name' => 'Personnel Clerk',
				'description' => 'Personnel Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 => 
			array (
				'id' => 2909,
				'name' => 'Personnel Clerks Supervisor',
				'description' => 'Personnel Clerks Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 => 
			array (
				'id' => 2910,
				'name' => 'Personnel Consultant',
				'description' => 'Personnel Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 => 
			array (
				'id' => 2911,
				'name' => 'Personnel Officer',
				'description' => 'Personnel Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 => 
			array (
				'id' => 2912,
				'name' => 'Personnel Safety Officer',
				'description' => 'Personnel Safety Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 => 
			array (
				'id' => 2913,
				'name' => 'Personnel Specialist',
				'description' => 'Personnel Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 => 
			array (
				'id' => 2914,
				'name' => 'Pest Exterminator',
				'description' => 'Pest Exterminator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 => 
			array (
				'id' => 2915,
				'name' => 'Petai Collector',
				'description' => 'Petai Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 => 
			array (
				'id' => 2916,
				'name' => 'Petition Writer',
				'description' => 'Petition Writer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 => 
			array (
				'id' => 2917,
				'name' => 'Petroleum And Gas Well Drilling Rigger',
				'description' => 'Petroleum And Gas Well Drilling Rigger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 => 
			array (
				'id' => 2918,
				'name' => 'Petroleum And Gas Wells Cementer',
				'description' => 'Petroleum And Gas Wells Cementer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 => 
			array (
				'id' => 2919,
				'name' => 'Petroleum And Natural Gas Extraction Assistant',
				'description' => 'Petroleum And Natural Gas Extraction Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 => 
			array (
				'id' => 2920,
				'name' => 'Petroleum And Natural Gas Extraction Technician',
				'description' => 'Petroleum And Natural Gas Extraction Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
				'id' => 2921,
				'name' => 'Petroleum Chemist',
				'description' => 'Petroleum Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'id' => 2922,
				'name' => 'Petroleum Geologist',
				'description' => 'Petroleum Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 => 
			array (
				'id' => 2923,
				'name' => 'Petroleum Refining Desulphuriser Operator',
				'description' => 'Petroleum Refining Desulphuriser Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 => 
			array (
				'id' => 2924,
				'name' => 'Petroleum Refining Laboratory Assistant',
				'description' => 'Petroleum Refining Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 => 
			array (
				'id' => 2925,
				'name' => 'Petroleum Refining Technician',
				'description' => 'Petroleum Refining Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 => 
			array (
				'id' => 2926,
				'name' => 'Petrologist',
				'description' => 'Petrologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 => 
			array (
				'id' => 2927,
				'name' => 'Petrology Geologist',
				'description' => 'Petrology Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 => 
			array (
				'id' => 2928,
				'name' => 'Petrol Pump/Station Attendant',
				'description' => 'Petrol Pump/Station Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 => 
			array (
				'id' => 2929,
				'name' => 'Petrol Pump/Station Cashier',
				'description' => 'Petrol Pump/Station Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 => 
			array (
				'id' => 2930,
				'name' => 'Petty Officer',
				'description' => 'Petty Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 => 
			array (
				'id' => 2931,
				'name' => 'Pewtersmith',
				'description' => 'Pewtersmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'id' => 2932,
				'name' => 'Pharmaceutical Assistant',
				'description' => 'Pharmaceutical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'id' => 2933,
				'name' => 'Pharmaceutical Bacteriologist',
				'description' => 'Pharmaceutical Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'id' => 2934,
				'name' => 'Pharmaceutical Chemist',
				'description' => 'Pharmaceutical Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'id' => 2935,
				'name' => 'Pharmaceutical Laboratory Assistant',
				'description' => 'Pharmaceutical Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'id' => 2936,
				'name' => 'Pharmacist',
				'description' => 'Pharmacist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 => 
			array (
				'id' => 2937,
				'name' => 'Pharmacist U29 Assistant',
				'description' => 'Pharmacist U29 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 => 
			array (
				'id' => 2938,
				'name' => 'Pharmacologists',
				'description' => 'Pharmacologists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 => 
			array (
				'id' => 2939,
				'name' => 'Pharmacology Technician',
				'description' => 'Pharmacology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 => 
			array (
				'id' => 2940,
				'name' => 'Pharmacy Aid',
				'description' => 'Pharmacy Aid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 => 
			array (
				'id' => 2941,
				'name' => 'Pharmacy U41 Officer',
				'description' => 'Pharmacy U41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 => 
			array (
				'id' => 2942,
				'name' => 'Philogist',
				'description' => 'Philogist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 => 
			array (
				'id' => 2943,
				'name' => 'Philosopher',
				'description' => 'Philosopher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 => 
			array (
				'id' => 2944,
				'name' => 'Photocopying Clerk',
				'description' => 'Photocopying Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 => 
			array (
				'id' => 2945,
				'name' => 'Photo-Engraver',
				'description' => 'Photo-Engraver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 => 
			array (
				'id' => 2946,
				'name' => 'Photo Finisher',
				'description' => 'Photo Finisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 => 
			array (
				'id' => 2947,
				'name' => 'Photogrammetrist',
				'description' => 'Photogrammetrist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 => 
			array (
				'id' => 2948,
			'name' => 'Photograph Developing (Colour And Black & White) Machine Operator',
			'description' => 'Photograph Developing (Colour And Black & White) Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 => 
			array (
				'id' => 2949,
				'name' => 'Photograph Enlarging Machine Operator',
				'description' => 'Photograph Enlarging Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 => 
			array (
				'id' => 2950,
				'name' => 'Photographer',
				'description' => 'Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 => 
			array (
				'id' => 2951,
				'name' => 'Photographer B27',
				'description' => 'Photographer B27',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 => 
			array (
				'id' => 2952,
				'name' => 'Photographic Equipment Maker',
				'description' => 'Photographic Equipment Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 => 
			array (
				'id' => 2953,
				'name' => 'Photographic Film Production Machine Operator',
				'description' => 'Photographic Film Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 => 
			array (
				'id' => 2954,
				'name' => 'Photographic Plate Production Machine Operator',
				'description' => 'Photographic Plate Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 => 
			array (
				'id' => 2955,
				'name' => 'Photographic Products Machine Operator',
				'description' => 'Photographic Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 => 
			array (
				'id' => 2956,
				'name' => 'Photographic Surveyor',
				'description' => 'Photographic Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 => 
			array (
				'id' => 2957,
			'name' => 'Photography (Motion Picture) Director',
			'description' => 'Photography (Motion Picture) Director',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 => 
			array (
				'id' => 2958,
				'name' => 'Photography Printing Machine Operator',
				'description' => 'Photography Printing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 => 
			array (
				'id' => 2959,
				'name' => 'Photo-Journalist',
				'description' => 'Photo-Journalist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 => 
			array (
				'id' => 2960,
				'name' => 'Physical Chemist',
				'description' => 'Physical Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 => 
			array (
				'id' => 2961,
				'name' => 'Physical Fitness Instructor',
				'description' => 'Physical Fitness Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 => 
			array (
				'id' => 2962,
				'name' => 'Physical Metallurgist',
				'description' => 'Physical Metallurgist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 => 
			array (
				'id' => 2963,
				'name' => 'Physical Metallurgy Assistant',
				'description' => 'Physical Metallurgy Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 => 
			array (
				'id' => 2964,
				'name' => 'Physical Science Laboratory Assistant',
				'description' => 'Physical Science Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 => 
			array (
				'id' => 2965,
				'name' => 'Physical Science Statistician',
				'description' => 'Physical Science Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 => 
			array (
				'id' => 2966,
				'name' => 'Physical Science Technician',
				'description' => 'Physical Science Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 => 
			array (
				'id' => 2967,
				'name' => 'Physical Therapist',
				'description' => 'Physical Therapist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 => 
			array (
				'id' => 2968,
				'name' => 'Physician',
				'description' => 'Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 => 
			array (
				'id' => 2969,
				'name' => 'Physicist',
				'description' => 'Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 => 
			array (
				'id' => 2970,
				'name' => 'Physics Laboratory Assistant',
				'description' => 'Physics Laboratory Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 => 
			array (
				'id' => 2971,
				'name' => 'Physics Technician',
				'description' => 'Physics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 => 
			array (
				'id' => 2972,
				'name' => 'Physiologists',
				'description' => 'Physiologists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 => 
			array (
				'id' => 2973,
				'name' => 'Physiology Technician',
				'description' => 'Physiology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 => 
			array (
				'id' => 2974,
				'name' => 'Physiotherapist',
				'description' => 'Physiotherapist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 => 
			array (
				'id' => 2975,
				'name' => 'Physiotherapist U29',
				'description' => 'Physiotherapist U29',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 => 
			array (
				'id' => 2976,
				'name' => 'Physiotherapy Masseur',
				'description' => 'Physiotherapy Masseur',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 => 
			array (
				'id' => 2977,
				'name' => 'Piano Maker',
				'description' => 'Piano Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 => 
			array (
				'id' => 2978,
				'name' => 'Picture Frame Maker',
				'description' => 'Picture Frame Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 => 
			array (
				'id' => 2979,
				'name' => 'Pig Farm Worker',
				'description' => 'Pig Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 => 
			array (
				'id' => 2980,
				'name' => 'Pile-Driver Operator',
				'description' => 'Pile-Driver Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 => 
			array (
				'id' => 2981,
				'name' => 'Pilot A41',
				'description' => 'Pilot A41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 => 
			array (
				'id' => 2982,
				'name' => 'Pilot Examiner Officer A41',
				'description' => 'Pilot Examiner Officer A41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 => 
			array (
				'id' => 2983,
				'name' => 'Pineapple Farm Worker',
				'description' => 'Pineapple Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 => 
			array (
				'id' => 2984,
				'name' => 'Pipe And Drain Layer',
				'description' => 'Pipe And Drain Layer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 => 
			array (
				'id' => 2985,
				'name' => 'Pipe And Tube/Aircraft Fitter',
				'description' => 'Pipe And Tube/Aircraft Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 => 
			array (
				'id' => 2986,
				'name' => 'Pipe Fitter',
				'description' => 'Pipe Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 => 
			array (
				'id' => 2987,
				'name' => 'Pipe/Marine Fitter',
				'description' => 'Pipe/Marine Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'id' => 2988,
				'name' => 'Pipe Production Machine Operator',
				'description' => 'Pipe Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'id' => 2989,
				'name' => 'Pipe/Sewerage Fitter',
				'description' => 'Pipe/Sewerage Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'id' => 2990,
				'name' => 'Pipe/Ventilation Fitter',
				'description' => 'Pipe/Ventilation Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'id' => 2991,
				'name' => 'Pipe/Water Supply Fitter',
				'description' => 'Pipe/Water Supply Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 => 
			array (
				'id' => 2992,
				'name' => 'Pisciculture Zoologist',
				'description' => 'Pisciculture Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 => 
			array (
				'id' => 2993,
				'name' => 'Pisciculturist',
				'description' => 'Pisciculturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 => 
			array (
				'id' => 2994,
				'name' => 'Planning And Distribution Executive',
				'description' => 'Planning And Distribution Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 => 
			array (
				'id' => 2995,
				'name' => 'Planning Engineer',
				'description' => 'Planning Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 => 
			array (
				'id' => 2996,
				'name' => 'Planning Machine Setter-Operator',
				'description' => 'Planning Machine Setter-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 => 
			array (
				'id' => 2997,
				'name' => 'Planning/Material Clerk',
				'description' => 'Planning/Material Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 => 
			array (
				'id' => 2998,
				'name' => 'Planning/Production Clerk',
				'description' => 'Planning/Production Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 => 
			array (
				'id' => 2999,
				'name' => 'Plant Cytologist',
				'description' => 'Plant Cytologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 => 
			array (
				'id' => 3000,
				'name' => 'Plant Ecologist',
				'description' => 'Plant Ecologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 3001,
				'name' => 'Plant Geneticist',
				'description' => 'Plant Geneticist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 3002,
				'name' => 'Plant Guide',
				'description' => 'Plant Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 3003,
				'name' => 'Plant Histologist',
				'description' => 'Plant Histologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 3004,
				'name' => 'Planting Adviser',
				'description' => 'Planting Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 3005,
				'name' => 'Plant Maintenance Mechanic',
				'description' => 'Plant Maintenance Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 3006,
				'name' => 'Plant Nursery Technician',
				'description' => 'Plant Nursery Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 3007,
				'name' => 'Plant Pathologist',
				'description' => 'Plant Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 3008,
				'name' => 'Plant Physiologist',
				'description' => 'Plant Physiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 3009,
				'name' => 'Plant Supervisor',
				'description' => 'Plant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 3010,
				'name' => 'Plant Taxonomist',
				'description' => 'Plant Taxonomist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 3011,
				'name' => 'Plasterer',
				'description' => 'Plasterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 3012,
				'name' => 'Plastic And Reconstructive Surgeon',
				'description' => 'Plastic And Reconstructive Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 3013,
				'name' => 'Plastic Production Machine Operator',
				'description' => 'Plastic Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 3014,
				'name' => 'Plastic Product Machine Operator',
				'description' => 'Plastic Product Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 3015,
				'name' => 'Plastics Chemist',
				'description' => 'Plastics Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 3016,
				'name' => 'Plastics Products Assembler',
				'description' => 'Plastics Products Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 3017,
				'name' => 'Plastics Technologist',
				'description' => 'Plastics Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 3018,
				'name' => 'Plate-Glass Glazier',
				'description' => 'Plate-Glass Glazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 3019,
				'name' => 'Plate-Glass Polisher',
				'description' => 'Plate-Glass Polisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 3020,
				'name' => 'Playwright',
				'description' => 'Playwright',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 3021,
				'name' => 'Plumber',
				'description' => 'Plumber',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 3022,
				'name' => 'Plywood Core Layer',
				'description' => 'Plywood Core Layer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 3023,
				'name' => 'Plywood Inspection Supervisor',
				'description' => 'Plywood Inspection Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 3024,
				'name' => 'Plywood Press-Operator',
				'description' => 'Plywood Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 3025,
				'name' => 'Podiatrist',
				'description' => 'Podiatrist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 3026,
				'name' => 'Poet',
				'description' => 'Poet',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 3027,
				'name' => 'Police Constable',
				'description' => 'Police Constable',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 3028,
				'name' => 'Police Detective',
				'description' => 'Police Detective',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 3029,
				'name' => 'Police Inspector',
				'description' => 'Police Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 3030,
				'name' => 'Police Inspector-General',
				'description' => 'Police Inspector-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 3031,
				'name' => 'Police Officer',
				'description' => 'Police Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 3032,
				'name' => 'Police Patrolman',
				'description' => 'Police Patrolman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 3033,
				'name' => 'Police Patrolwoman',
				'description' => 'Police Patrolwoman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 3034,
				'name' => 'Police Superintendent',
				'description' => 'Police Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 3035,
				'name' => 'Police Volunteer',
				'description' => 'Police Volunteer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 3036,
				'name' => 'Police YT1-10 Constable',
				'description' => 'Police YT1-10 Constable',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 3037,
			'name' => 'Police (YY11) Senior Official',
			'description' => 'Police (YY11) Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 3038,
				'name' => 'Policy Analyst',
				'description' => 'Policy Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 3039,
				'name' => 'Policy And Planning Manager',
				'description' => 'Policy And Planning Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 3040,
				'name' => 'Political Editor',
				'description' => 'Political Editor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 3041,
				'name' => 'Political Party Chairman',
				'description' => 'Political Party Chairman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 3042,
				'name' => 'Political Party Leader',
				'description' => 'Political Party Leader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 3043,
				'name' => 'Political Party Organization Senior Official',
				'description' => 'Political Party Organization Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 3044,
				'name' => 'Political Party President',
				'description' => 'Political Party President',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 3045,
				'name' => 'Political Party Secretary-General',
				'description' => 'Political Party Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 3046,
				'name' => 'Political Philosopher',
				'description' => 'Political Philosopher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 3047,
				'name' => 'Political Scientist',
				'description' => 'Political Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 3048,
				'name' => 'Political Worker',
				'description' => 'Political Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 3049,
				'name' => 'Polymer Chemist',
				'description' => 'Polymer Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 3050,
				'name' => 'Polymer Technologist',
				'description' => 'Polymer Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 3051,
				'name' => 'Polytechnic Lecturer',
				'description' => 'Polytechnic Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 3052,
				'name' => 'Pomologist',
				'description' => 'Pomologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 3053,
				'name' => 'Pomology Technician',
				'description' => 'Pomology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 3054,
				'name' => 'Port Captain',
				'description' => 'Port Captain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 3055,
				'name' => 'Postal Clerk',
				'description' => 'Postal Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 3056,
				'name' => 'Poster Designer',
				'description' => 'Poster Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 3057,
				'name' => 'Postman/Post Woman',
				'description' => 'Postman/Post Woman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 3058,
				'name' => 'Postmaster',
				'description' => 'Postmaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 3059,
				'name' => 'Potter',
				'description' => 'Potter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 3060,
				'name' => 'Pottery And Porcelain Caster',
				'description' => 'Pottery And Porcelain Caster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 3061,
				'name' => 'Pottery And Porcelain Jiggerer',
				'description' => 'Pottery And Porcelain Jiggerer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 3062,
				'name' => 'Pottery And Porcelain Kiln-Operator',
				'description' => 'Pottery And Porcelain Kiln-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 3063,
				'name' => 'Pottery And Porcelain Machine Operator',
				'description' => 'Pottery And Porcelain Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 3064,
				'name' => 'Pottery And Porcelain Modeller',
				'description' => 'Pottery And Porcelain Modeller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 3065,
				'name' => 'Pottery And Porcelain Mould Maker',
				'description' => 'Pottery And Porcelain Mould Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 3066,
				'name' => 'Pottery And Porcelain Presser',
				'description' => 'Pottery And Porcelain Presser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 3067,
				'name' => 'Pottery And Porcelain Thrower',
				'description' => 'Pottery And Porcelain Thrower',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 3068,
				'name' => 'Pottery And Porcelain Turner',
				'description' => 'Pottery And Porcelain Turner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 3069,
				'name' => 'Pottery Clay Maker',
				'description' => 'Pottery Clay Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 3070,
				'name' => 'Poultry Farm Worker',
				'description' => 'Poultry Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 3071,
				'name' => 'Poultry Hatchery Work',
				'description' => 'Poultry Hatchery Work',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 3072,
				'name' => 'Poultry Inseminator',
				'description' => 'Poultry Inseminator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 3073,
				'name' => 'Poultry Vaccinator',
				'description' => 'Poultry Vaccinator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 3074,
				'name' => 'Power Distribution And Transmission Engineer',
				'description' => 'Power Distribution And Transmission Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 3075,
				'name' => 'Power Generating Plant Operator',
				'description' => 'Power Generating Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 3076,
				'name' => 'Power Generation Engineer',
				'description' => 'Power Generation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 3077,
				'name' => 'Power Plant Clerk',
				'description' => 'Power Plant Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 3078,
				'name' => 'Prawn Farm Worker',
				'description' => 'Prawn Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 3079,
				'name' => 'Preacher',
				'description' => 'Preacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 3080,
				'name' => 'Precious Metal Roller',
				'description' => 'Precious Metal Roller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 3081,
				'name' => 'Precision Instrument Assembler',
				'description' => 'Precision Instrument Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 3082,
				'name' => 'Precision Wood Sawyer',
				'description' => 'Precision Wood Sawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 3083,
				'name' => 'Pre-Primary Teacher',
				'description' => 'Pre-Primary Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 3084,
				'name' => 'Presentation Support Assistant',
				'description' => 'Presentation Support Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 3085,
				'name' => 'President/Chairman Industrial Court',
				'description' => 'President/Chairman Industrial Court',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 3086,
				'name' => 'Press Clipper',
				'description' => 'Press Clipper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 3087,
				'name' => 'Press Editor',
				'description' => 'Press Editor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 3088,
				'name' => 'Pressing/Glass Machine Operator',
				'description' => 'Pressing/Glass Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 3089,
				'name' => 'Pressing/Laundry Machine Operator',
				'description' => 'Pressing/Laundry Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 3090,
				'name' => 'Press Liaison Officer',
				'description' => 'Press Liaison Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 3091,
				'name' => 'Press Officer',
				'description' => 'Press Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 3092,
				'name' => 'Press Photographer',
				'description' => 'Press Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 3093,
				'name' => 'Pre-University Teacher',
				'description' => 'Pre-University Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 3094,
				'name' => 'Price Inspector',
				'description' => 'Price Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 3095,
				'name' => 'Primary Education Teacher',
				'description' => 'Primary Education Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 3096,
				'name' => 'Prime Minister',
				'description' => 'Prime Minister',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 3097,
				'name' => 'Printer',
				'description' => 'Printer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 3098,
				'name' => 'Printing/Cylinder Press-Operator',
				'description' => 'Printing/Cylinder Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 3099,
				'name' => 'Printing/Direct Lithographic Press-Operator',
				'description' => 'Printing/Direct Lithographic Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 3100,
				'name' => 'Printing/Lithographic Stone Engraver',
				'description' => 'Printing/Lithographic Stone Engraver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 3101,
				'name' => 'Printing Machinery Assembler',
				'description' => 'Printing Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 3102,
				'name' => 'Printing/Metal Plate Engraver',
				'description' => 'Printing/Metal Plate Engraver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 3103,
				'name' => 'Printing/Metal Plate Etcher',
				'description' => 'Printing/Metal Plate Etcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 3104,
				'name' => 'Printing/Offset Press-Operator',
				'description' => 'Printing/Offset Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 3105,
				'name' => 'Printing Operator',
				'description' => 'Printing Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 3106,
				'name' => 'Printing Plate Router',
				'description' => 'Printing Plate Router',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 3107,
				'name' => 'Printing/Rotary Press-Operator',
				'description' => 'Printing/Rotary Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 3108,
				'name' => 'Printing/Rotogravure Press-Operator',
				'description' => 'Printing/Rotogravure Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 3109,
				'name' => 'Printing Technologist',
				'description' => 'Printing Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 3110,
				'name' => 'Printing/Wallpaper Press-Operator',
				'description' => 'Printing/Wallpaper Press-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 3111,
				'name' => 'Prison Director-General',
				'description' => 'Prison Director-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 3112,
				'name' => 'Prison Guard',
				'description' => 'Prison Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 3113,
				'name' => 'Prison KX11 Officer',
				'description' => 'Prison KX11 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 3114,
				'name' => 'Prison KX27 Ssistant Superintendent',
				'description' => 'Prison KX27 Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 3115,
				'name' => 'Prison KX41 Superintendent',
				'description' => 'Prison KX41 Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 3116,
				'name' => 'Prison Warden',
				'description' => 'Prison Warden',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 3117,
				'name' => 'Private',
				'description' => 'Private',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 3118,
				'name' => 'Private Detective',
				'description' => 'Private Detective',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 3119,
				'name' => 'Private Investigator',
				'description' => 'Private Investigator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 3120,
				'name' => 'Private Service Cook',
				'description' => 'Private Service Cook',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 3121,
				'name' => 'Probate Clerk',
				'description' => 'Probate Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 3122,
				'name' => 'Probation Welfare Officer',
				'description' => 'Probation Welfare Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 3123,
				'name' => 'Process Engineer',
				'description' => 'Process Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 3124,
				'name' => 'Processing And Refining/Sugar Operator',
				'description' => 'Processing And Refining/Sugar Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 3125,
				'name' => 'Processing/Dairy Products Machine Operator',
				'description' => 'Processing/Dairy Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 3126,
				'name' => 'Process Server',
				'description' => 'Process Server',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 3127,
				'name' => 'Procurement Agent',
				'description' => 'Procurement Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 3128,
				'name' => 'Procurement Clerk',
				'description' => 'Procurement Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 3129,
				'name' => 'Producer B41',
				'description' => 'Producer B41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 3130,
				'name' => 'Product/Brand Executive',
				'description' => 'Product/Brand Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 3131,
				'name' => 'Product/Brand Manager',
				'description' => 'Product/Brand Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 3132,
				'name' => 'Production Administrative Clerk',
				'description' => 'Production Administrative Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 3133,
				'name' => 'Production And Operation/Agricultural Manager',
				'description' => 'Production And Operation/Agricultural Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 3134,
				'name' => 'Production And Operation/Business Manager',
				'description' => 'Production And Operation/Business Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 3135,
				'name' => 'Production And Operation/Cleaning Manager',
				'description' => 'Production And Operation/Cleaning Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 3136,
				'name' => 'Production And Operation/Communications Manager',
				'description' => 'Production And Operation/Communications Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 3137,
			'name' => 'Production And Operation/Communications (Postal Services) Manager',
			'description' => 'Production And Operation/Communications (Postal Services) Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 3138,
				'name' => 'Production And Operation/Communications (Telecommunication Manager',
					'description' => 'Production And Operation/Communications (Telecommunication Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					138 => 
					array (
						'id' => 3139,
						'name' => 'Production And Operation/Construction Manager',
						'description' => 'Production And Operation/Construction Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					139 => 
					array (
						'id' => 3140,
						'name' => 'Production And Operation/Cultural Activities Manager',
						'description' => 'Production And Operation/Cultural Activities Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					140 => 
					array (
						'id' => 3141,
						'name' => 'Production And Operation/Education Manager',
						'description' => 'Production And Operation/Education Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					141 => 
					array (
						'id' => 3142,
						'name' => 'Production And Operation/Extra Territorial Organization Manager',
						'description' => 'Production And Operation/Extra Territorial Organization Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					142 => 
					array (
						'id' => 3143,
						'name' => 'Production And Operation/Fishery Manager',
						'description' => 'Production And Operation/Fishery Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					143 => 
					array (
						'id' => 3144,
						'name' => 'Production And Operation/Forestry Manager',
						'description' => 'Production And Operation/Forestry Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					144 => 
					array (
						'id' => 3145,
						'name' => 'Production And Operation/Health Manager',
						'description' => 'Production And Operation/Health Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					145 => 
					array (
						'id' => 3146,
						'name' => 'Production And Operation/Hotel Manager',
						'description' => 'Production And Operation/Hotel Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					146 => 
					array (
						'id' => 3147,
						'name' => 'Production And Operation/Manufacturing Manager',
						'description' => 'Production And Operation/Manufacturing Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					147 => 
					array (
						'id' => 3148,
						'name' => 'Production And Operation/Mining And Quarry Manager',
						'description' => 'Production And Operation/Mining And Quarry Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					148 => 
					array (
						'id' => 3149,
						'name' => 'Production And Operation/Personal Care Manager',
						'description' => 'Production And Operation/Personal Care Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					149 => 
					array (
						'id' => 3150,
						'name' => 'Production And Operation/Recreation Manager',
						'description' => 'Production And Operation/Recreation Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					150 => 
					array (
						'id' => 3151,
						'name' => 'Production And Operation/Restaurant Manager',
						'description' => 'Production And Operation/Restaurant Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					151 => 
					array (
						'id' => 3152,
						'name' => 'Production And Operation/Retail Trade Manager',
						'description' => 'Production And Operation/Retail Trade Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					152 => 
					array (
						'id' => 3153,
					'name' => 'Production And Operation/Retail Trade (Store) Manager',
					'description' => 'Production And Operation/Retail Trade (Store) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					153 => 
					array (
						'id' => 3154,
					'name' => 'Production And Operation/Retail Trade (Supermarket) Manager',
					'description' => 'Production And Operation/Retail Trade (Supermarket) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					154 => 
					array (
						'id' => 3155,
						'name' => 'Production And Operation/Social Work Manager',
						'description' => 'Production And Operation/Social Work Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					155 => 
					array (
						'id' => 3156,
						'name' => 'Production And Operation/Sporting Activities Manager',
						'description' => 'Production And Operation/Sporting Activities Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					156 => 
					array (
						'id' => 3157,
						'name' => 'Production And Operation/Stage Manager',
						'description' => 'Production And Operation/Stage Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					157 => 
					array (
						'id' => 3158,
						'name' => 'Production And Operation/Storage Manager',
						'description' => 'Production And Operation/Storage Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					158 => 
					array (
						'id' => 3159,
					'name' => 'Production And Operation/Transport (Freight Traffic) Manager',
					'description' => 'Production And Operation/Transport (Freight Traffic) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					159 => 
					array (
						'id' => 3160,
						'name' => 'Production And Operation/Transport Manager',
						'description' => 'Production And Operation/Transport Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					160 => 
					array (
						'id' => 3161,
					'name' => 'Production And Operation/Transport (Passenger Traffic) Manager',
					'description' => 'Production And Operation/Transport (Passenger Traffic) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					161 => 
					array (
						'id' => 3162,
					'name' => 'Production And Operation/Transport (Pipeline) Manager',
					'description' => 'Production And Operation/Transport (Pipeline) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					162 => 
					array (
						'id' => 3163,
						'name' => 'Production And Operation/Travel Agency Manager',
						'description' => 'Production And Operation/Travel Agency Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					163 => 
					array (
						'id' => 3164,
					'name' => 'Production And Operation/Wholesale Trade (Export) Manager',
					'description' => 'Production And Operation/Wholesale Trade (Export) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					164 => 
					array (
						'id' => 3165,
					'name' => 'Production And Operation/Wholesale Trade (Import) Manager',
					'description' => 'Production And Operation/Wholesale Trade (Import) Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					165 => 
					array (
						'id' => 3166,
						'name' => 'Production And Operation/Wholesale Trade Manager',
						'description' => 'Production And Operation/Wholesale Trade Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					166 => 
					array (
						'id' => 3167,
						'name' => 'Production Assistant',
						'description' => 'Production Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					167 => 
					array (
						'id' => 3168,
						'name' => 'Production Control Clerk',
						'description' => 'Production Control Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					168 => 
					array (
						'id' => 3169,
						'name' => 'Production Engineer',
						'description' => 'Production Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					169 => 
					array (
						'id' => 3170,
						'name' => 'Production Engineering Assistant',
						'description' => 'Production Engineering Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					170 => 
					array (
						'id' => 3171,
						'name' => 'Production Executive',
						'description' => 'Production Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					171 => 
					array (
						'id' => 3172,
						'name' => 'Production Purchasing Buyer',
						'description' => 'Production Purchasing Buyer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					172 => 
					array (
						'id' => 3173,
						'name' => 'Production Sales Administrative Clerk',
						'description' => 'Production Sales Administrative Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					173 => 
					array (
						'id' => 3174,
						'name' => 'Production Supervisor',
						'description' => 'Production Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					174 => 
					array (
						'id' => 3175,
						'name' => 'Professional Social Worker',
						'description' => 'Professional Social Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					175 => 
					array (
						'id' => 3176,
						'name' => 'Programme Preparer',
						'description' => 'Programme Preparer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					176 => 
					array (
						'id' => 3177,
						'name' => 'Programme/Radio & Television Manager',
						'description' => 'Programme/Radio & Television Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					177 => 
					array (
						'id' => 3178,
						'name' => 'Programmer Analyst',
						'description' => 'Programmer Analyst',
						'created_at' => $now,
						'updated_at' => $now,
					),
					178 => 
					array (
						'id' => 3179,
						'name' => 'Project Engineer',
						'description' => 'Project Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					179 => 
					array (
						'id' => 3180,
						'name' => 'Project Executive',
						'description' => 'Project Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					180 => 
					array (
						'id' => 3181,
						'name' => 'Project Manager',
						'description' => 'Project Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					181 => 
					array (
						'id' => 3182,
						'name' => 'Project Supervisor',
						'description' => 'Project Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					182 => 
					array (
						'id' => 3183,
						'name' => 'Promptor',
						'description' => 'Promptor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					183 => 
					array (
						'id' => 3184,
						'name' => 'Proofreader',
						'description' => 'Proofreader',
						'created_at' => $now,
						'updated_at' => $now,
					),
					184 => 
					array (
						'id' => 3185,
						'name' => 'Proof-Reading And Related Clerks Other Coding',
						'description' => 'Proof-Reading And Related Clerks Other Coding',
						'created_at' => $now,
						'updated_at' => $now,
					),
					185 => 
					array (
						'id' => 3186,
						'name' => 'Property Agent',
						'description' => 'Property Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					186 => 
					array (
						'id' => 3187,
						'name' => 'Property Clerk',
						'description' => 'Property Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					187 => 
					array (
						'id' => 3188,
						'name' => 'Property Executive',
						'description' => 'Property Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					188 => 
					array (
						'id' => 3189,
						'name' => 'Property Manager',
						'description' => 'Property Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					189 => 
					array (
						'id' => 3190,
						'name' => 'Prosecutor',
						'description' => 'Prosecutor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					190 => 
					array (
						'id' => 3191,
						'name' => 'Prosecutor L41',
						'description' => 'Prosecutor L41',
						'created_at' => $now,
						'updated_at' => $now,
					),
					191 => 
					array (
						'id' => 3192,
						'name' => 'Prostheist',
						'description' => 'Prostheist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					192 => 
					array (
						'id' => 3193,
						'name' => 'Prosthetic Technician',
						'description' => 'Prosthetic Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					193 => 
					array (
						'id' => 3194,
						'name' => 'Prosthodontistry',
						'description' => 'Prosthodontistry',
						'created_at' => $now,
						'updated_at' => $now,
					),
					194 => 
					array (
						'id' => 3195,
						'name' => 'Prosthodontistry Dentist',
						'description' => 'Prosthodontistry Dentist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					195 => 
					array (
						'id' => 3196,
						'name' => 'Proteins Biochemist',
						'description' => 'Proteins Biochemist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					196 => 
					array (
						'id' => 3197,
						'name' => 'Pruner Worker',
						'description' => 'Pruner Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					197 => 
					array (
						'id' => 3198,
						'name' => 'Psychiatric Nurse',
						'description' => 'Psychiatric Nurse',
						'created_at' => $now,
						'updated_at' => $now,
					),
					198 => 
					array (
						'id' => 3199,
						'name' => 'Psychiatric Social Worker',
						'description' => 'Psychiatric Social Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					199 => 
					array (
						'id' => 3200,
						'name' => 'Psychiatrist',
						'description' => 'Psychiatrist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					200 => 
					array (
						'id' => 3201,
						'name' => 'Psychologists',
						'description' => 'Psychologists',
						'created_at' => $now,
						'updated_at' => $now,
					),
					201 => 
					array (
						'id' => 3202,
						'name' => 'Psychologist S27 Assistant',
						'description' => 'Psychologist S27 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					202 => 
					array (
						'id' => 3203,
						'name' => 'Psychologists S41',
						'description' => 'Psychologists S41',
						'created_at' => $now,
						'updated_at' => $now,
					),
					203 => 
					array (
						'id' => 3204,
						'name' => 'Public Accountant',
						'description' => 'Public Accountant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					204 => 
					array (
						'id' => 3205,
						'name' => 'Public Area Attendant',
						'description' => 'Public Area Attendant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					205 => 
					array (
						'id' => 3206,
						'name' => 'Public Area Housekeeping Worker',
						'description' => 'Public Area Housekeeping Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					206 => 
					array (
						'id' => 3207,
						'name' => 'Publication Clerk',
						'description' => 'Publication Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					207 => 
					array (
						'id' => 3208,
						'name' => 'Publication N17 Assistant',
						'description' => 'Publication N17 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					208 => 
					array (
						'id' => 3209,
						'name' => 'Publication N27 Ssistant Officer',
						'description' => 'Publication N27 Ssistant Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					209 => 
					array (
						'id' => 3210,
						'name' => 'Publication N41 Officer',
						'description' => 'Publication N41 Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					210 => 
					array (
						'id' => 3211,
						'name' => 'Public Health/Dental Nurse',
						'description' => 'Public Health/Dental Nurse',
						'created_at' => $now,
						'updated_at' => $now,
					),
					211 => 
					array (
						'id' => 3212,
						'name' => 'Public Health Dietician',
						'description' => 'Public Health Dietician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					212 => 
					array (
						'id' => 3213,
						'name' => 'Public Health Inspector',
						'description' => 'Public Health Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					213 => 
					array (
						'id' => 3214,
					'name' => 'Public Health (Medical) Nurse',
					'description' => 'Public Health (Medical) Nurse',
						'created_at' => $now,
						'updated_at' => $now,
					),
					214 => 
					array (
						'id' => 3215,
						'name' => 'Public Health Nutritionist',
						'description' => 'Public Health Nutritionist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					215 => 
					array (
						'id' => 3216,
						'name' => 'Public Health U11 Assistant',
						'description' => 'Public Health U11 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					216 => 
					array (
						'id' => 3217,
						'name' => 'Public Health Veterinarian',
						'description' => 'Public Health Veterinarian',
						'created_at' => $now,
						'updated_at' => $now,
					),
					217 => 
					array (
						'id' => 3218,
						'name' => 'Publicity Agent',
						'description' => 'Publicity Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					218 => 
					array (
						'id' => 3219,
						'name' => 'Publicity Writer',
						'description' => 'Publicity Writer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					219 => 
					array (
						'id' => 3220,
						'name' => 'Public Opinion Interviewer',
						'description' => 'Public Opinion Interviewer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					220 => 
					array (
						'id' => 3221,
						'name' => 'Public Relations Manager',
						'description' => 'Public Relations Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					221 => 
					array (
						'id' => 3222,
						'name' => 'Public Relations Officer/Executive',
						'description' => 'Public Relations Officer/Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					222 => 
					array (
						'id' => 3223,
						'name' => 'Public Trustee',
						'description' => 'Public Trustee',
						'created_at' => $now,
						'updated_at' => $now,
					),
					223 => 
					array (
						'id' => 3224,
						'name' => 'Public Writer',
						'description' => 'Public Writer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					224 => 
					array (
						'id' => 3225,
						'name' => 'Pug-Mill/Clay Operator',
						'description' => 'Pug-Mill/Clay Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					225 => 
					array (
						'id' => 3226,
						'name' => 'Pulling Equipment/Oil & Gas Wells Operator',
						'description' => 'Pulling Equipment/Oil & Gas Wells Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					226 => 
					array (
						'id' => 3227,
						'name' => 'Pulverising/Chemical And Related Processes Machine Operator',
						'description' => 'Pulverising/Chemical And Related Processes Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					227 => 
					array (
						'id' => 3228,
						'name' => 'Pumping Station Operator',
						'description' => 'Pumping Station Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					228 => 
					array (
						'id' => 3229,
						'name' => 'Pumping-Station/Petroleum And Natural Gas Operator',
						'description' => 'Pumping-Station/Petroleum And Natural Gas Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					229 => 
					array (
						'id' => 3230,
					'name' => 'Pumpman (Petroleum Refining)',
					'description' => 'Pumpman (Petroleum Refining)',
						'created_at' => $now,
						'updated_at' => $now,
					),
					230 => 
					array (
						'id' => 3231,
						'name' => 'Punching/Metal Press-Operator',
						'description' => 'Punching/Metal Press-Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					231 => 
					array (
						'id' => 3232,
						'name' => 'Pupils Management N17 Assistant',
						'description' => 'Pupils Management N17 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					232 => 
					array (
						'id' => 3233,
						'name' => 'Purchasing Buyer',
						'description' => 'Purchasing Buyer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					233 => 
					array (
						'id' => 3234,
						'name' => 'Purchasing Manager',
						'description' => 'Purchasing Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					234 => 
					array (
						'id' => 3235,
						'name' => 'Purchasing/Material Clerk',
						'description' => 'Purchasing/Material Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					235 => 
					array (
						'id' => 3236,
						'name' => 'Purchasing Officer/Executive',
						'description' => 'Purchasing Officer/Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					236 => 
					array (
						'id' => 3237,
						'name' => 'Pure Mathematics Mathematician',
						'description' => 'Pure Mathematics Mathematician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					237 => 
					array (
						'id' => 3238,
						'name' => 'Quality And Ecology Clerk',
						'description' => 'Quality And Ecology Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					238 => 
					array (
						'id' => 3239,
						'name' => 'Quality Assurance Analyst',
						'description' => 'Quality Assurance Analyst',
						'created_at' => $now,
						'updated_at' => $now,
					),
					239 => 
					array (
						'id' => 3240,
						'name' => 'Quality Assurance Clerk',
						'description' => 'Quality Assurance Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					240 => 
					array (
						'id' => 3241,
						'name' => 'Quality Assurance Engineer',
						'description' => 'Quality Assurance Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					241 => 
					array (
						'id' => 3242,
						'name' => 'Quality Assurance Executive',
						'description' => 'Quality Assurance Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					242 => 
					array (
						'id' => 3243,
						'name' => 'Quality Assurance Manager',
						'description' => 'Quality Assurance Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					243 => 
					array (
						'id' => 3244,
						'name' => 'Quality Checker/Tester',
						'description' => 'Quality Checker/Tester',
						'created_at' => $now,
						'updated_at' => $now,
					),
					244 => 
					array (
						'id' => 3245,
						'name' => 'Quality Control Chemist',
						'description' => 'Quality Control Chemist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					245 => 
					array (
						'id' => 3246,
						'name' => 'Quality Control Clerk',
						'description' => 'Quality Control Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					246 => 
					array (
						'id' => 3247,
						'name' => 'Quality Control Engineer',
						'description' => 'Quality Control Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					247 => 
					array (
						'id' => 3248,
						'name' => 'Quality Control Manager',
						'description' => 'Quality Control Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					248 => 
					array (
						'id' => 3249,
						'name' => 'Quality Control Officer/Executive',
						'description' => 'Quality Control Officer/Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					249 => 
					array (
						'id' => 3250,
						'name' => 'Quality Control Supervisor',
						'description' => 'Quality Control Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					250 => 
					array (
						'id' => 3251,
						'name' => 'Quality Control Technician',
						'description' => 'Quality Control Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					251 => 
					array (
						'id' => 3252,
						'name' => 'Quality Product Inspector',
						'description' => 'Quality Product Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					252 => 
					array (
						'id' => 3253,
						'name' => 'Quantity J41 Surveyor',
						'description' => 'Quantity J41 Surveyor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					253 => 
					array (
						'id' => 3254,
						'name' => 'Quantity Surveyor',
						'description' => 'Quantity Surveyor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					254 => 
					array (
						'id' => 3255,
						'name' => 'Quantity Surveyor J17 Technician',
						'description' => 'Quantity Surveyor J17 Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					255 => 
					array (
						'id' => 3256,
						'name' => 'Quantity Surveyor J29 Technical Assistant',
						'description' => 'Quantity Surveyor J29 Technical Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					256 => 
					array (
						'id' => 3257,
						'name' => 'Quantity Surveyor Technician',
						'description' => 'Quantity Surveyor Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					257 => 
					array (
						'id' => 3258,
						'name' => 'Quarier',
						'description' => 'Quarier',
						'created_at' => $now,
						'updated_at' => $now,
					),
					258 => 
					array (
						'id' => 3259,
						'name' => 'Quarrying Labourer',
						'description' => 'Quarrying Labourer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					259 => 
					array (
						'id' => 3260,
						'name' => 'Quarry Sampler',
						'description' => 'Quarry Sampler',
						'created_at' => $now,
						'updated_at' => $now,
					),
					260 => 
					array (
						'id' => 3261,
						'name' => 'Quilt Maker',
						'description' => 'Quilt Maker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					261 => 
					array (
						'id' => 3262,
						'name' => 'Rabbit Breeder',
						'description' => 'Rabbit Breeder',
						'created_at' => $now,
						'updated_at' => $now,
					),
					262 => 
					array (
						'id' => 3263,
						'name' => 'Racecourse Manager',
						'description' => 'Racecourse Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					263 => 
					array (
						'id' => 3264,
						'name' => 'Race Track Cashier',
						'description' => 'Race Track Cashier',
						'created_at' => $now,
						'updated_at' => $now,
					),
					264 => 
					array (
						'id' => 3265,
						'name' => 'Radioactive Minerals Metallurgist',
						'description' => 'Radioactive Minerals Metallurgist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					265 => 
					array (
						'id' => 3266,
						'name' => 'Radio And Television Announcers',
						'description' => 'Radio And Television Announcers',
						'created_at' => $now,
						'updated_at' => $now,
					),
					266 => 
					array (
						'id' => 3267,
						'name' => 'Radio And Television Broadcasting Director',
						'description' => 'Radio And Television Broadcasting Director',
						'created_at' => $now,
						'updated_at' => $now,
					),
					267 => 
					array (
						'id' => 3268,
						'name' => 'Radio And Television Director',
						'description' => 'Radio And Television Director',
						'created_at' => $now,
						'updated_at' => $now,
					),
					268 => 
					array (
						'id' => 3269,
						'name' => 'Radio And Television Manager, Broadcasting',
						'description' => 'Radio And Television Manager, Broadcasting',
						'created_at' => $now,
						'updated_at' => $now,
					),
					269 => 
					array (
						'id' => 3270,
						'name' => 'Radio And Television News Broadcasting Editor',
						'description' => 'Radio And Television News Broadcasting Editor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					270 => 
					array (
						'id' => 3271,
						'name' => 'Radio Astronomer',
						'description' => 'Radio Astronomer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					271 => 
					array (
						'id' => 3272,
						'name' => 'Radio Equipment/Flight Operator',
						'description' => 'Radio Equipment/Flight Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					272 => 
					array (
						'id' => 3273,
						'name' => 'Radio Equipment/Land-Base Operator',
						'description' => 'Radio Equipment/Land-Base Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					273 => 
					array (
						'id' => 3274,
						'name' => 'Radiographer',
						'description' => 'Radiographer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					274 => 
					array (
						'id' => 3275,
						'name' => 'Radiologist',
						'description' => 'Radiologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					275 => 
					array (
						'id' => 3276,
						'name' => 'Radio Or Television Story Teller',
						'description' => 'Radio Or Television Story Teller',
						'created_at' => $now,
						'updated_at' => $now,
					),
					276 => 
					array (
						'id' => 3277,
						'name' => 'Radiotherapy Oncologist',
						'description' => 'Radiotherapy Oncologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					277 => 
					array (
						'id' => 3278,
						'name' => 'Radiotherapy Radiologist',
						'description' => 'Radiotherapy Radiologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					278 => 
					array (
						'id' => 3279,
						'name' => 'Railway And Road Vehicle Loader',
						'description' => 'Railway And Road Vehicle Loader',
						'created_at' => $now,
						'updated_at' => $now,
					),
					279 => 
					array (
						'id' => 3280,
						'name' => 'Railway Braker',
						'description' => 'Railway Braker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					280 => 
					array (
						'id' => 3281,
						'name' => 'Railway Cable Rigger',
						'description' => 'Railway Cable Rigger',
						'created_at' => $now,
						'updated_at' => $now,
					),
					281 => 
					array (
						'id' => 3282,
						'name' => 'Railway Carriage Upholsterer',
						'description' => 'Railway Carriage Upholsterer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					282 => 
					array (
						'id' => 3283,
						'name' => 'Railway Dining Car Waiter',
						'description' => 'Railway Dining Car Waiter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					283 => 
					array (
						'id' => 3284,
						'name' => 'Railway Dining Car Waitress',
						'description' => 'Railway Dining Car Waitress',
						'created_at' => $now,
						'updated_at' => $now,
					),
					284 => 
					array (
						'id' => 3285,
						'name' => 'Railway Engine Driver',
						'description' => 'Railway Engine Driver',
						'created_at' => $now,
						'updated_at' => $now,
					),
					285 => 
					array (
						'id' => 3286,
						'name' => 'Railway Engine Fireperson',
						'description' => 'Railway Engine Fireperson',
						'created_at' => $now,
						'updated_at' => $now,
					),
					286 => 
					array (
						'id' => 3287,
						'name' => 'Railway Gateman',
						'description' => 'Railway Gateman',
						'created_at' => $now,
						'updated_at' => $now,
					),
					287 => 
					array (
						'id' => 3288,
						'name' => 'Railway Guard',
						'description' => 'Railway Guard',
						'created_at' => $now,
						'updated_at' => $now,
					),
					288 => 
					array (
						'id' => 3289,
						'name' => 'Railway Inspector',
						'description' => 'Railway Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					289 => 
					array (
						'id' => 3290,
						'name' => 'Railway Officer Claims',
						'description' => 'Railway Officer Claims',
						'created_at' => $now,
						'updated_at' => $now,
					),
					290 => 
					array (
						'id' => 3291,
						'name' => 'Railway Officer Commercial',
						'description' => 'Railway Officer Commercial',
						'created_at' => $now,
						'updated_at' => $now,
					),
					291 => 
					array (
						'id' => 3292,
						'name' => 'Railway Pointsman',
						'description' => 'Railway Pointsman',
						'created_at' => $now,
						'updated_at' => $now,
					),
					292 => 
					array (
						'id' => 3293,
						'name' => 'Railway Services Supervisor',
						'description' => 'Railway Services Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					293 => 
					array (
						'id' => 3294,
						'name' => 'Railway Shunter',
						'description' => 'Railway Shunter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					294 => 
					array (
						'id' => 3295,
						'name' => 'Railway Signaller',
						'description' => 'Railway Signaller',
						'created_at' => $now,
						'updated_at' => $now,
					),
					295 => 
					array (
						'id' => 3296,
						'name' => 'Railways Permanent-Way Inspector',
						'description' => 'Railways Permanent-Way Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					296 => 
					array (
						'id' => 3297,
						'name' => 'Railway Station Master',
						'description' => 'Railway Station Master',
						'created_at' => $now,
						'updated_at' => $now,
					),
					297 => 
					array (
						'id' => 3298,
						'name' => 'Railway Trackman',
						'description' => 'Railway Trackman',
						'created_at' => $now,
						'updated_at' => $now,
					),
					298 => 
					array (
						'id' => 3299,
						'name' => 'Railway Yard Coupler',
						'description' => 'Railway Yard Coupler',
						'created_at' => $now,
						'updated_at' => $now,
					),
					299 => 
					array (
						'id' => 3300,
						'name' => 'Ram Controller',
						'description' => 'Ram Controller',
						'created_at' => $now,
						'updated_at' => $now,
					),
					300 => 
					array (
						'id' => 3301,
						'name' => 'Ramp Attendant',
						'description' => 'Ramp Attendant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					301 => 
					array (
						'id' => 3302,
						'name' => 'Rating Clerk',
						'description' => 'Rating Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					302 => 
					array (
						'id' => 3303,
						'name' => 'Raw Material Clerk',
						'description' => 'Raw Material Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					303 => 
					array (
						'id' => 3304,
						'name' => 'Raw Material Store Clerk',
						'description' => 'Raw Material Store Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					304 => 
					array (
						'id' => 3305,
					'name' => 'Reactor-Convertor (Chemical Processes)',
					'description' => 'Reactor-Convertor (Chemical Processes)',
						'created_at' => $now,
						'updated_at' => $now,
					),
					305 => 
					array (
						'id' => 3306,
						'name' => 'Real Estate Agent',
						'description' => 'Real Estate Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					306 => 
					array (
						'id' => 3307,
					'name' => 'Realtor (Property)',
					'description' => 'Realtor (Property)',
						'created_at' => $now,
						'updated_at' => $now,
					),
					307 => 
					array (
						'id' => 3308,
						'name' => 'Reaming/Metal Machine Operator',
						'description' => 'Reaming/Metal Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					308 => 
					array (
						'id' => 3309,
						'name' => 'Rear Admiral',
						'description' => 'Rear Admiral',
						'created_at' => $now,
						'updated_at' => $now,
					),
					309 => 
					array (
						'id' => 3310,
						'name' => 'Receiving Clerk',
						'description' => 'Receiving Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					310 => 
					array (
						'id' => 3311,
						'name' => 'Receptionist',
						'description' => 'Receptionist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					311 => 
					array (
						'id' => 3312,
						'name' => 'Records Custodian',
						'description' => 'Records Custodian',
						'created_at' => $now,
						'updated_at' => $now,
					),
					312 => 
					array (
						'id' => 3313,
						'name' => 'Records/Personnel Clerk',
						'description' => 'Records/Personnel Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					313 => 
					array (
						'id' => 3314,
						'name' => 'Recreation Assistant Supervisor',
						'description' => 'Recreation Assistant Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					314 => 
					array (
						'id' => 3315,
						'name' => 'Recreation Manager',
						'description' => 'Recreation Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					315 => 
					array (
						'id' => 3316,
						'name' => 'Recreation Supervisor',
						'description' => 'Recreation Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					316 => 
					array (
						'id' => 3317,
						'name' => 'Red Crescent Organization Secretary-General',
						'description' => 'Red Crescent Organization Secretary-General',
						'created_at' => $now,
						'updated_at' => $now,
					),
					317 => 
					array (
						'id' => 3318,
						'name' => 'Red Cross Organization Secretary-General',
						'description' => 'Red Cross Organization Secretary-General',
						'created_at' => $now,
						'updated_at' => $now,
					),
					318 => 
					array (
						'id' => 3319,
						'name' => 'Reed Weaving Handicraft Worker',
						'description' => 'Reed Weaving Handicraft Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					319 => 
					array (
						'id' => 3320,
						'name' => 'Refining/Non-Ferrous Metal Furnace-Operator',
						'description' => 'Refining/Non-Ferrous Metal Furnace-Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					320 => 
					array (
						'id' => 3321,
						'name' => 'Refining/Oils And Fats Machine Operator',
						'description' => 'Refining/Oils And Fats Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					321 => 
					array (
						'id' => 3322,
					'name' => 'Refining/Steel (Open-Hearth Furnace) Furnace-Operator',
					'description' => 'Refining/Steel (Open-Hearth Furnace) Furnace-Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					322 => 
					array (
						'id' => 3323,
						'name' => 'Refreshment-Room Manager',
						'description' => 'Refreshment-Room Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					323 => 
					array (
						'id' => 3324,
						'name' => 'Refreshments Theatre Vendor',
						'description' => 'Refreshments Theatre Vendor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					324 => 
					array (
						'id' => 3325,
						'name' => 'Refrigeration And Air-Conditioning Equipment Assembler',
						'description' => 'Refrigeration And Air-Conditioning Equipment Assembler',
						'created_at' => $now,
						'updated_at' => $now,
					),
					325 => 
					array (
						'id' => 3326,
						'name' => 'Refrigeration And Air-Conditioning Equipment Insulator',
						'description' => 'Refrigeration And Air-Conditioning Equipment Insulator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					326 => 
					array (
						'id' => 3327,
						'name' => 'Refrigeration And Air-Conditioning Equipment Mechanic',
						'description' => 'Refrigeration And Air-Conditioning Equipment Mechanic',
						'created_at' => $now,
						'updated_at' => $now,
					),
					327 => 
					array (
						'id' => 3328,
						'name' => 'Refrigeration System Operator',
						'description' => 'Refrigeration System Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					328 => 
					array (
						'id' => 3329,
						'name' => 'Registrar Of Court',
						'description' => 'Registrar Of Court',
						'created_at' => $now,
						'updated_at' => $now,
					),
					329 => 
					array (
						'id' => 3330,
						'name' => 'Registration KP17 Assistant',
						'description' => 'Registration KP17 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					330 => 
					array (
						'id' => 3331,
						'name' => 'Registration KP27 Ssistant Officer',
						'description' => 'Registration KP27 Ssistant Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					331 => 
					array (
						'id' => 3332,
						'name' => 'Registration KP41 Officer',
						'description' => 'Registration KP41 Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					332 => 
					array (
						'id' => 3333,
						'name' => 'Registry Clerk',
						'description' => 'Registry Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					333 => 
					array (
						'id' => 3334,
						'name' => 'Rehabilitation Workers N1',
						'description' => 'Rehabilitation Workers N1',
						'created_at' => $now,
						'updated_at' => $now,
					),
					334 => 
					array (
						'id' => 3335,
						'name' => 'Reheating/Metal Furnace-Operator',
						'description' => 'Reheating/Metal Furnace-Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					335 => 
					array (
						'id' => 3336,
						'name' => 'Reinforced Concreter',
						'description' => 'Reinforced Concreter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					336 => 
					array (
						'id' => 3337,
						'name' => 'RELA Officer',
						'description' => 'RELA Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					337 => 
					array (
						'id' => 3338,
						'name' => 'Religious Officer',
						'description' => 'Religious Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					338 => 
					array (
						'id' => 3339,
						'name' => 'Remedial/Professional Teacher',
						'description' => 'Remedial/Professional Teacher',
						'created_at' => $now,
						'updated_at' => $now,
					),
					339 => 
					array (
						'id' => 3340,
						'name' => 'Rental/Audio Visual Equipment Clerk',
						'description' => 'Rental/Audio Visual Equipment Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					340 => 
					array (
						'id' => 3341,
						'name' => 'Rental/Car/Limousine Clerk',
						'description' => 'Rental/Car/Limousine Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					341 => 
					array (
						'id' => 3342,
						'name' => 'Rental Clerk',
						'description' => 'Rental Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					342 => 
					array (
						'id' => 3343,
						'name' => 'Rental/Costume Clerk',
						'description' => 'Rental/Costume Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					343 => 
					array (
						'id' => 3344,
						'name' => 'Rental/Heavy Vehicles Clerk',
						'description' => 'Rental/Heavy Vehicles Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					344 => 
					array (
						'id' => 3345,
						'name' => 'Rental/Video Tapes Clerk',
						'description' => 'Rental/Video Tapes Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					345 => 
					array (
						'id' => 3346,
						'name' => 'Rent Collector',
						'description' => 'Rent Collector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					346 => 
					array (
						'id' => 3347,
						'name' => 'Repairers And Cable Jointers Other Electrical Line Installers',
						'description' => 'Repairers And Cable Jointers Other Electrical Line Installers',
						'created_at' => $now,
						'updated_at' => $now,
					),
					347 => 
					array (
						'id' => 3348,
						'name' => 'Reporter/Journalist S17 Assistant',
						'description' => 'Reporter/Journalist S17 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					348 => 
					array (
						'id' => 3349,
						'name' => 'Reporter/Reporter Assistant',
						'description' => 'Reporter/Reporter Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					349 => 
					array (
						'id' => 3350,
						'name' => 'Research And Development Manager',
						'description' => 'Research And Development Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					350 => 
					array (
						'id' => 3351,
						'name' => 'Research And Information Analyst',
						'description' => 'Research And Information Analyst',
						'created_at' => $now,
						'updated_at' => $now,
					),
					351 => 
					array (
						'id' => 3352,
						'name' => 'Research Assistant',
						'description' => 'Research Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					352 => 
					array (
						'id' => 3353,
						'name' => 'Research/Botanical Laboratory Assistant',
						'description' => 'Research/Botanical Laboratory Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					353 => 
					array (
						'id' => 3354,
					'name' => 'Research Development (Chemical Or Related Product) Chemist',
					'description' => 'Research Development (Chemical Or Related Product) Chemist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					354 => 
					array (
						'id' => 3355,
						'name' => 'Research Engineer',
						'description' => 'Research Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					355 => 
					array (
						'id' => 3356,
						'name' => 'Researcher Q17 Assistant',
						'description' => 'Researcher Q17 Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					356 => 
					array (
						'id' => 3357,
						'name' => 'Research/Food And Beverage Clerk',
						'description' => 'Research/Food And Beverage Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					357 => 
					array (
						'id' => 3358,
						'name' => 'Research Nutritionist',
						'description' => 'Research Nutritionist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					358 => 
					array (
						'id' => 3359,
						'name' => 'Research Q27 Ssistant Officer',
						'description' => 'Research Q27 Ssistant Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					359 => 
					array (
						'id' => 3360,
						'name' => 'Research Q41 Officer',
						'description' => 'Research Q41 Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					360 => 
					array (
						'id' => 3361,
						'name' => 'Research/Zoological Laboratory Assistant',
						'description' => 'Research/Zoological Laboratory Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					361 => 
					array (
						'id' => 3362,
						'name' => 'Reservation Assistant',
						'description' => 'Reservation Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					362 => 
					array (
						'id' => 3363,
						'name' => 'Reservation Assistant Supervisor',
						'description' => 'Reservation Assistant Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					363 => 
					array (
						'id' => 3364,
						'name' => 'Reservation Supervisor',
						'description' => 'Reservation Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					364 => 
					array (
						'id' => 3365,
						'name' => 'Resident/Civil Engineering Engineer',
						'description' => 'Resident/Civil Engineering Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					365 => 
					array (
						'id' => 3366,
						'name' => 'Respiratory Medicine Physician',
						'description' => 'Respiratory Medicine Physician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					366 => 
					array (
						'id' => 3367,
						'name' => 'Respiratory Paediatrician',
						'description' => 'Respiratory Paediatrician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					367 => 
					array (
						'id' => 3368,
						'name' => 'Restaurant Cashier',
						'description' => 'Restaurant Cashier',
						'created_at' => $now,
						'updated_at' => $now,
					),
					368 => 
					array (
						'id' => 3369,
						'name' => 'Restaurant Manager',
						'description' => 'Restaurant Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					369 => 
					array (
						'id' => 3370,
						'name' => 'Restaurant Supervisor',
						'description' => 'Restaurant Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					370 => 
					array (
						'id' => 3371,
						'name' => 'Restorer Painting',
						'description' => 'Restorer Painting',
						'created_at' => $now,
						'updated_at' => $now,
					),
					371 => 
					array (
						'id' => 3372,
						'name' => 'Restroom Attendant',
						'description' => 'Restroom Attendant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					372 => 
					array (
						'id' => 3373,
						'name' => 'Retailer',
						'description' => 'Retailer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					373 => 
					array (
						'id' => 3374,
						'name' => 'Retail Pharmacist',
						'description' => 'Retail Pharmacist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					374 => 
					array (
						'id' => 3375,
						'name' => 'Retail Trade/Chain Store Manager',
						'description' => 'Retail Trade/Chain Store Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					375 => 
					array (
						'id' => 3376,
						'name' => 'Retail Trade/Discount Store Manager',
						'description' => 'Retail Trade/Discount Store Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					376 => 
					array (
						'id' => 3377,
						'name' => 'Retail Trade/Mail-Order Store Manager',
						'description' => 'Retail Trade/Mail-Order Store Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					377 => 
					array (
						'id' => 3378,
						'name' => 'Retail Trade Merchant',
						'description' => 'Retail Trade Merchant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					378 => 
					array (
						'id' => 3379,
						'name' => 'Retail Trade/Self-Service Store Manager',
						'description' => 'Retail Trade/Self-Service Store Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					379 => 
					array (
						'id' => 3380,
						'name' => 'Retail Trade/Shop Manager',
						'description' => 'Retail Trade/Shop Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					380 => 
					array (
						'id' => 3381,
						'name' => 'Retort/Chemical And Related Processes Operator',
						'description' => 'Retort/Chemical And Related Processes Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					381 => 
					array (
						'id' => 3382,
						'name' => 'Retort Operator',
						'description' => 'Retort Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					382 => 
					array (
						'id' => 3383,
						'name' => 'Revenue Assessor',
						'description' => 'Revenue Assessor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					383 => 
					array (
						'id' => 3384,
						'name' => 'Rheologist',
						'description' => 'Rheologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					384 => 
					array (
						'id' => 3385,
						'name' => 'Rheology Physicist',
						'description' => 'Rheology Physicist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					385 => 
					array (
						'id' => 3386,
						'name' => 'Rheumatology Physician',
						'description' => 'Rheumatology Physician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					386 => 
					array (
						'id' => 3387,
						'name' => 'Rice Miller',
						'description' => 'Rice Miller',
						'created_at' => $now,
						'updated_at' => $now,
					),
					387 => 
					array (
						'id' => 3388,
						'name' => 'Riveter',
						'description' => 'Riveter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					388 => 
					array (
						'id' => 3389,
						'name' => 'Riveting Machine Operator',
						'description' => 'Riveting Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					389 => 
					array (
						'id' => 3390,
						'name' => 'Rivet Production Machine Operator',
						'description' => 'Rivet Production Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					390 => 
					array (
						'id' => 3391,
						'name' => 'Road Making Machine Operator',
						'description' => 'Road Making Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					391 => 
					array (
						'id' => 3392,
						'name' => 'Road Roller Operator',
						'description' => 'Road Roller Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					392 => 
					array (
						'id' => 3393,
						'name' => 'Road Sweeper',
						'description' => 'Road Sweeper',
						'created_at' => $now,
						'updated_at' => $now,
					),
					393 => 
					array (
						'id' => 3394,
						'name' => 'Road Transport Service Supervisor',
						'description' => 'Road Transport Service Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					394 => 
					array (
						'id' => 3395,
						'name' => 'Roasting Equipment/Chemical And Related Processes Operator',
						'description' => 'Roasting Equipment/Chemical And Related Processes Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					395 => 
					array (
						'id' => 3396,
						'name' => 'Robotics Engineer',
						'description' => 'Robotics Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					396 => 
					array (
						'id' => 3397,
						'name' => 'Rollerboy',
						'description' => 'Rollerboy',
						'created_at' => $now,
						'updated_at' => $now,
					),
					397 => 
					array (
						'id' => 3398,
						'name' => 'Rolling Mill/Non-Ferrous Metal Operator',
						'description' => 'Rolling Mill/Non-Ferrous Metal Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					398 => 
					array (
						'id' => 3399,
						'name' => 'Room Attendant',
						'description' => 'Room Attendant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					399 => 
					array (
						'id' => 3400,
						'name' => 'Room Boy',
						'description' => 'Room Boy',
						'created_at' => $now,
						'updated_at' => $now,
					),
					400 => 
					array (
						'id' => 3401,
						'name' => 'Room Service Clerk',
						'description' => 'Room Service Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					401 => 
					array (
						'id' => 3402,
						'name' => 'Rope And Cable Splicer',
						'description' => 'Rope And Cable Splicer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					402 => 
					array (
						'id' => 3403,
						'name' => 'Rope-Laying Machine Operator',
						'description' => 'Rope-Laying Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					403 => 
					array (
						'id' => 3404,
						'name' => 'Rotary Drum Filterer',
						'description' => 'Rotary Drum Filterer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					404 => 
					array (
						'id' => 3405,
						'name' => 'Rotary Technician',
						'description' => 'Rotary Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					405 => 
					array (
						'id' => 3406,
						'name' => 'Roving And Spinning Instructor',
						'description' => 'Roving And Spinning Instructor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					406 => 
					array (
						'id' => 3407,
						'name' => 'Royal Malaysian Air Force Administrative Officer/Law And Legal Officer',
						'description' => 'Royal Malaysian Air Force Administrative Officer/Law And Legal Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					407 => 
					array (
						'id' => 3408,
						'name' => 'Royal Malaysian Air Force Aeronautical Engineer',
						'description' => 'Royal Malaysian Air Force Aeronautical Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					408 => 
					array (
						'id' => 3409,
						'name' => 'Royal Malaysian Air Force Airframe/Engine/Electrical/Avionic Technician',
						'description' => 'Royal Malaysian Air Force Airframe/Engine/Electrical/Avionic Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					409 => 
					array (
						'id' => 3410,
						'name' => 'Royal Malaysian Air Force Airquatermaster',
						'description' => 'Royal Malaysian Air Force Airquatermaster',
						'created_at' => $now,
						'updated_at' => $now,
					),
					410 => 
					array (
						'id' => 3411,
						'name' => 'Royal Malaysian Air Force Air Surveillance Technician',
						'description' => 'Royal Malaysian Air Force Air Surveillance Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					411 => 
					array (
						'id' => 3412,
						'name' => 'Royal Malaysian Air Force Communication/Software/Computer Engineer',
						'description' => 'Royal Malaysian Air Force Communication/Software/Computer Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					412 => 
					array (
						'id' => 3413,
						'name' => 'Royal Malaysian Air Force Electron Technician',
						'description' => 'Royal Malaysian Air Force Electron Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					413 => 
					array (
						'id' => 3414,
						'name' => 'Royal Malaysian Air Force Fire Fighter',
						'description' => 'Royal Malaysian Air Force Fire Fighter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					414 => 
					array (
						'id' => 3415,
						'name' => 'Royal Malaysian Air Force Flight Engineer',
						'description' => 'Royal Malaysian Air Force Flight Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					415 => 
					array (
						'id' => 3416,
						'name' => 'Royal Malaysian Air Force HF Radio Operator',
						'description' => 'Royal Malaysian Air Force HF Radio Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					416 => 
					array (
						'id' => 3417,
						'name' => 'Royal Malaysian Air Force Movement Clerk/Statistic Clerk/Flight Planning',
						'description' => 'Royal Malaysian Air Force Movement Clerk/Statistic Clerk/Flight Planning',
						'created_at' => $now,
						'updated_at' => $now,
					),
					417 => 
					array (
						'id' => 3418,
						'name' => 'Royal Malaysian Air Force Navigator',
						'description' => 'Royal Malaysian Air Force Navigator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					418 => 
					array (
						'id' => 3419,
						'name' => 'Royal Malaysian Air Force Special Force Officer',
						'description' => 'Royal Malaysian Air Force Special Force Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					419 => 
					array (
						'id' => 3420,
						'name' => 'Royal Malaysian Air Force Stewardess',
						'description' => 'Royal Malaysian Air Force Stewardess',
						'created_at' => $now,
						'updated_at' => $now,
					),
					420 => 
					array (
						'id' => 3421,
						'name' => 'Royal Malaysian Air Force Weapon Sensor Officer',
						'description' => 'Royal Malaysian Air Force Weapon Sensor Officer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					421 => 
					array (
						'id' => 3422,
						'name' => 'Royal Malaysian Air Force Workshop/Carpenters/Clerk Technician',
						'description' => 'Royal Malaysian Air Force Workshop/Carpenters/Clerk Technician',
						'created_at' => $now,
						'updated_at' => $now,
					),
					422 => 
					array (
						'id' => 3423,
						'name' => 'Rubber Chemist',
						'description' => 'Rubber Chemist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					423 => 
					array (
						'id' => 3424,
						'name' => 'Rubber Coagulator',
						'description' => 'Rubber Coagulator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					424 => 
					array (
						'id' => 3425,
						'name' => 'Rubber Farm Worker',
						'description' => 'Rubber Farm Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					425 => 
					array (
						'id' => 3426,
						'name' => 'Rubber Foam Maker',
						'description' => 'Rubber Foam Maker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					426 => 
					array (
						'id' => 3427,
						'name' => 'Rubber Products Assembler',
						'description' => 'Rubber Products Assembler',
						'created_at' => $now,
						'updated_at' => $now,
					),
					427 => 
					array (
						'id' => 3428,
						'name' => 'Rubber Products Machine Operator',
						'description' => 'Rubber Products Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					428 => 
					array (
						'id' => 3429,
						'name' => 'Rubber Sheet Clipper And Sorter',
						'description' => 'Rubber Sheet Clipper And Sorter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					429 => 
					array (
						'id' => 3430,
						'name' => 'Rubber Stamp Production Machine Operator',
						'description' => 'Rubber Stamp Production Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					430 => 
					array (
						'id' => 3431,
					'name' => 'Rubber Tapper (Plantation)',
					'description' => 'Rubber Tapper (Plantation)',
						'created_at' => $now,
						'updated_at' => $now,
					),
					431 => 
					array (
						'id' => 3432,
						'name' => 'Rubber Technologist',
						'description' => 'Rubber Technologist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					432 => 
					array (
						'id' => 3433,
						'name' => 'Sack Maker',
						'description' => 'Sack Maker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					433 => 
					array (
						'id' => 3434,
						'name' => 'Safe Deposit Clerk',
						'description' => 'Safe Deposit Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					434 => 
					array (
						'id' => 3435,
						'name' => 'Safety And Health/Consumer Protection Inspector',
						'description' => 'Safety And Health/Consumer Protection Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					435 => 
					array (
						'id' => 3436,
						'name' => 'Safety And Health/Pollution Inspector',
						'description' => 'Safety And Health/Pollution Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					436 => 
					array (
						'id' => 3437,
						'name' => 'Safety Manager',
						'description' => 'Safety Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					437 => 
					array (
						'id' => 3438,
						'name' => 'Safety Promoter',
						'description' => 'Safety Promoter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					438 => 
					array (
						'id' => 3439,
						'name' => 'Safety/Vehicles Inspector',
						'description' => 'Safety/Vehicles Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					439 => 
					array (
						'id' => 3440,
						'name' => 'Sago Production Machine Operator',
						'description' => 'Sago Production Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					440 => 
					array (
						'id' => 3441,
						'name' => 'Sail Cutter',
						'description' => 'Sail Cutter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					441 => 
					array (
						'id' => 3442,
						'name' => 'Sailing Instructor',
						'description' => 'Sailing Instructor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					442 => 
					array (
						'id' => 3443,
						'name' => 'Sailor',
						'description' => 'Sailor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					443 => 
					array (
						'id' => 3444,
						'name' => 'Sailor A1/A3',
						'description' => 'Sailor A1/A3',
						'created_at' => $now,
						'updated_at' => $now,
					),
					444 => 
					array (
						'id' => 3445,
						'name' => 'Sails Pattern-Maker',
						'description' => 'Sails Pattern-Maker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					445 => 
					array (
						'id' => 3446,
						'name' => 'Salaries Clerk',
						'description' => 'Salaries Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					446 => 
					array (
						'id' => 3447,
						'name' => 'Sales Admin Clerk',
						'description' => 'Sales Admin Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					447 => 
					array (
						'id' => 3448,
						'name' => 'Sales Administrative Executive',
						'description' => 'Sales Administrative Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					448 => 
					array (
						'id' => 3449,
						'name' => 'Sales And Marketing Clerk',
						'description' => 'Sales And Marketing Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					449 => 
					array (
						'id' => 3450,
						'name' => 'Sales And Marketing Manager',
						'description' => 'Sales And Marketing Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					450 => 
					array (
						'id' => 3451,
						'name' => 'Sales And Marketing Professionals',
						'description' => 'Sales And Marketing Professionals',
						'created_at' => $now,
						'updated_at' => $now,
					),
					451 => 
					array (
						'id' => 3452,
						'name' => 'Sales Assistant',
						'description' => 'Sales Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					452 => 
					array (
						'id' => 3453,
						'name' => 'Sales Associate',
						'description' => 'Sales Associate',
						'created_at' => $now,
						'updated_at' => $now,
					),
					453 => 
					array (
						'id' => 3454,
						'name' => 'Sales Clerk',
						'description' => 'Sales Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					454 => 
					array (
						'id' => 3455,
						'name' => 'Sales Co-Coordinator',
						'description' => 'Sales Co-Coordinator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					455 => 
					array (
						'id' => 3456,
						'name' => 'Sales Counter Clerk',
						'description' => 'Sales Counter Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					456 => 
					array (
						'id' => 3457,
						'name' => 'Sales Engineer',
						'description' => 'Sales Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					457 => 
					array (
						'id' => 3458,
						'name' => 'Sales/Engineering Agent',
						'description' => 'Sales/Engineering Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					458 => 
					array (
						'id' => 3459,
						'name' => 'Sales Executive',
						'description' => 'Sales Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					459 => 
					array (
						'id' => 3460,
						'name' => 'Sales Manager',
						'description' => 'Sales Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					460 => 
					array (
						'id' => 3461,
						'name' => 'Sales Order Clerk',
						'description' => 'Sales Order Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					461 => 
					array (
						'id' => 3462,
						'name' => 'Salesperson Telemarketer',
						'description' => 'Salesperson Telemarketer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					462 => 
					array (
						'id' => 3463,
						'name' => 'Sales Promoter',
						'description' => 'Sales Promoter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					463 => 
					array (
						'id' => 3464,
						'name' => 'Sales Promotion Manager',
						'description' => 'Sales Promotion Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					464 => 
					array (
						'id' => 3465,
						'name' => 'Sales Promotion Method Specialist',
						'description' => 'Sales Promotion Method Specialist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					465 => 
					array (
						'id' => 3466,
						'name' => 'Sales Representative',
						'description' => 'Sales Representative',
						'created_at' => $now,
						'updated_at' => $now,
					),
					466 => 
					array (
						'id' => 3467,
						'name' => 'Sales Secretary',
						'description' => 'Sales Secretary',
						'created_at' => $now,
						'updated_at' => $now,
					),
					467 => 
					array (
						'id' => 3468,
						'name' => 'Sales Supervisor',
						'description' => 'Sales Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					468 => 
					array (
						'id' => 3469,
						'name' => 'Sales/Technical Agent',
						'description' => 'Sales/Technical Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					469 => 
					array (
						'id' => 3470,
						'name' => 'Salvage Frogman/Diver',
						'description' => 'Salvage Frogman/Diver',
						'created_at' => $now,
						'updated_at' => $now,
					),
					470 => 
					array (
						'id' => 3471,
						'name' => 'Sandblaster Equipment Machine Operator',
						'description' => 'Sandblaster Equipment Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					471 => 
					array (
						'id' => 3472,
						'name' => 'Sandblasting Equipment/Glass Operator',
						'description' => 'Sandblasting Equipment/Glass Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					472 => 
					array (
						'id' => 3473,
						'name' => 'Sander Operator',
						'description' => 'Sander Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					473 => 
					array (
						'id' => 3474,
						'name' => 'Sanding Operator',
						'description' => 'Sanding Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					474 => 
					array (
						'id' => 3475,
						'name' => 'Sanitarian',
						'description' => 'Sanitarian',
						'created_at' => $now,
						'updated_at' => $now,
					),
					475 => 
					array (
						'id' => 3476,
						'name' => 'Sanitary Inspector',
						'description' => 'Sanitary Inspector',
						'created_at' => $now,
						'updated_at' => $now,
					),
					476 => 
					array (
						'id' => 3477,
						'name' => 'Satellite-Instruction Facilitator',
						'description' => 'Satellite-Instruction Facilitator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					477 => 
					array (
						'id' => 3478,
						'name' => 'Sauce Production Machine Operator',
						'description' => 'Sauce Production Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					478 => 
					array (
						'id' => 3479,
						'name' => 'Sauces And Condiments Preserver',
						'description' => 'Sauces And Condiments Preserver',
						'created_at' => $now,
						'updated_at' => $now,
					),
					479 => 
					array (
						'id' => 3480,
						'name' => 'Sausage Maker',
						'description' => 'Sausage Maker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					480 => 
					array (
						'id' => 3481,
						'name' => 'Sausage Production Machine Operator',
						'description' => 'Sausage Production Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					481 => 
					array (
						'id' => 3482,
						'name' => 'Saw Doctor',
						'description' => 'Saw Doctor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					482 => 
					array (
						'id' => 3483,
						'name' => 'Sawing/Metal Machine Operator',
						'description' => 'Sawing/Metal Machine Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					483 => 
					array (
						'id' => 3484,
						'name' => 'Sawing Worker',
						'description' => 'Sawing Worker',
						'created_at' => $now,
						'updated_at' => $now,
					),
					484 => 
					array (
						'id' => 3485,
						'name' => 'Sawmill Controller',
						'description' => 'Sawmill Controller',
						'created_at' => $now,
						'updated_at' => $now,
					),
					485 => 
					array (
						'id' => 3486,
						'name' => 'Sawmill Log Yard Exchange',
						'description' => 'Sawmill Log Yard Exchange',
						'created_at' => $now,
						'updated_at' => $now,
					),
					486 => 
					array (
						'id' => 3487,
						'name' => 'Sawmill Operator',
						'description' => 'Sawmill Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					487 => 
					array (
						'id' => 3488,
						'name' => 'Sawmill Sawyer',
						'description' => 'Sawmill Sawyer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					488 => 
					array (
						'id' => 3489,
						'name' => 'Sawmill Ssistant Superintendent',
						'description' => 'Sawmill Ssistant Superintendent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					489 => 
					array (
						'id' => 3490,
						'name' => 'Sawmill Superintendent',
						'description' => 'Sawmill Superintendent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					490 => 
					array (
						'id' => 3491,
						'name' => 'Sawmill Supervisor',
						'description' => 'Sawmill Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					491 => 
					array (
						'id' => 3492,
						'name' => 'Saw Repairer',
						'description' => 'Saw Repairer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					492 => 
					array (
						'id' => 3493,
						'name' => 'Saw Sharpener',
						'description' => 'Saw Sharpener',
						'created_at' => $now,
						'updated_at' => $now,
					),
					493 => 
					array (
						'id' => 3494,
						'name' => 'Sawyer Master',
						'description' => 'Sawyer Master',
						'created_at' => $now,
						'updated_at' => $now,
					),
					494 => 
					array (
						'id' => 3495,
						'name' => 'Scaffolder',
						'description' => 'Scaffolder',
						'created_at' => $now,
						'updated_at' => $now,
					),
					495 => 
					array (
						'id' => 3496,
						'name' => 'Scanning And Filming Assistant',
						'description' => 'Scanning And Filming Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					496 => 
					array (
						'id' => 3497,
						'name' => 'Scanning Equipment Operator',
						'description' => 'Scanning Equipment Operator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					497 => 
					array (
						'id' => 3498,
						'name' => 'Scenery Designer',
						'description' => 'Scenery Designer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					498 => 
					array (
						'id' => 3499,
						'name' => 'School/Dental Nurse',
						'description' => 'School/Dental Nurse',
						'created_at' => $now,
						'updated_at' => $now,
					),
					499 => 
					array (
						'id' => 3500,
						'name' => 'School Director',
						'description' => 'School Director',
						'created_at' => $now,
						'updated_at' => $now,
					),
				));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 3501,
				'name' => 'School Inspector',
				'description' => 'School Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 3502,
				'name' => 'School Principal',
				'description' => 'School Principal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 3503,
				'name' => 'School Secretary',
				'description' => 'School Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 3504,
			'name' => 'Science (Nuclear Research) C27 Ssistant Officer',
			'description' => 'Science (Nuclear Research) C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 3505,
			'name' => 'Science (Radiology) Officer',
			'description' => 'Science (Radiology) Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 3506,
				'name' => 'Scientific Photographer',
				'description' => 'Scientific Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 3507,
				'name' => 'Scrap Handler',
				'description' => 'Scrap Handler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 3508,
				'name' => 'Scribes',
				'description' => 'Scribes',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 3509,
				'name' => 'Script Writer',
				'description' => 'Script Writer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 3510,
				'name' => 'Sculptor',
				'description' => 'Sculptor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 3511,
				'name' => 'Sealing Machine Operator',
				'description' => 'Sealing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 3512,
				'name' => 'Seamless Pipe And Tube Drawer',
				'description' => 'Seamless Pipe And Tube Drawer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 3513,
				'name' => 'Seamless Pipe And Tube Machine Operator',
				'description' => 'Seamless Pipe And Tube Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 3514,
				'name' => 'Seamstress',
				'description' => 'Seamstress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 3515,
				'name' => 'Seasoning/Wood Machine Operator',
				'description' => 'Seasoning/Wood Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 3516,
				'name' => 'Seaweed Gatherer',
				'description' => 'Seaweed Gatherer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 3517,
				'name' => 'Secondary Education Teacher',
				'description' => 'Secondary Education Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 3518,
				'name' => 'Second Lieutenant',
				'description' => 'Second Lieutenant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 3519,
				'name' => 'Secretary',
				'description' => 'Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 3520,
				'name' => 'Securities Broker',
				'description' => 'Securities Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 3521,
				'name' => 'Securities Clerk',
				'description' => 'Securities Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 3522,
				'name' => 'Security Guard Chief',
				'description' => 'Security Guard Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 3523,
				'name' => 'Security Guard KP11',
				'description' => 'Security Guard KP11',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 3524,
				'name' => 'Security KP17 Assistant',
				'description' => 'Security KP17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 3525,
				'name' => 'Security KP27 Ssistant Officer',
				'description' => 'Security KP27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 3526,
				'name' => 'Security KP41 Officer',
				'description' => 'Security KP41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 3527,
				'name' => 'Security Manager',
				'description' => 'Security Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 3528,
				'name' => 'Security/Private Guard',
				'description' => 'Security/Private Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 3529,
				'name' => 'Security Sergeant Major',
				'description' => 'Security Sergeant Major',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 3530,
				'name' => 'Seismologist',
				'description' => 'Seismologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 3531,
				'name' => 'Seismology Geophysicist',
				'description' => 'Seismology Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 3532,
				'name' => 'Self-Service Restaurant Manager',
				'description' => 'Self-Service Restaurant Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 3533,
				'name' => 'Semi-Conductor Assembler',
				'description' => 'Semi-Conductor Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 3534,
				'name' => 'Semi-Conductor Engineer',
				'description' => 'Semi-Conductor Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 3535,
				'name' => 'Semi-Conductor Technician',
				'description' => 'Semi-Conductor Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 3536,
				'name' => 'Senator',
				'description' => 'Senator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 3537,
				'name' => 'Separator/Chemical And Related Processes Operator',
				'description' => 'Separator/Chemical And Related Processes Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 3538,
				'name' => 'Serang',
				'description' => 'Serang',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 3539,
				'name' => 'Serang A17',
				'description' => 'Serang A17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 3540,
				'name' => 'Sergeant',
				'description' => 'Sergeant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 3541,
				'name' => 'Sericulture Worker',
				'description' => 'Sericulture Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 3542,
				'name' => 'Serologist',
				'description' => 'Serologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 3543,
				'name' => 'Serology Technician',
				'description' => 'Serology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 3544,
				'name' => 'Service Assistant Sewing Clerk',
				'description' => 'Service Assistant Sewing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 3545,
				'name' => 'Service Clerk',
				'description' => 'Service Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 3546,
				'name' => 'Servicer Telephone And Telegraph',
				'description' => 'Servicer Telephone And Telegraph',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 3547,
			'name' => 'Services)',
		'description' => 'Services)',
		'created_at' => $now,
		'updated_at' => $now,
	),
	47 => 
	array (
		'id' => 3548,
		'name' => 'Sessions Court Judge',
		'description' => 'Sessions Court Judge',
		'created_at' => $now,
		'updated_at' => $now,
	),
	48 => 
	array (
		'id' => 3549,
		'name' => 'Sewage Plant Operator',
		'description' => 'Sewage Plant Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	49 => 
	array (
		'id' => 3550,
		'name' => 'Sewer',
		'description' => 'Sewer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	50 => 
	array (
		'id' => 3551,
		'name' => 'Sewerage And Sanitary Engineer',
		'description' => 'Sewerage And Sanitary Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	51 => 
	array (
		'id' => 3552,
		'name' => 'Sewing Machine Assembler',
		'description' => 'Sewing Machine Assembler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	52 => 
	array (
		'id' => 3553,
		'name' => 'Sewing Machine Operator',
		'description' => 'Sewing Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	53 => 
	array (
		'id' => 3554,
		'name' => 'Sewing Operator',
		'description' => 'Sewing Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	54 => 
	array (
		'id' => 3555,
		'name' => 'Sewing Worker',
		'description' => 'Sewing Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	55 => 
	array (
		'id' => 3556,
		'name' => 'Sexton',
		'description' => 'Sexton',
		'created_at' => $now,
		'updated_at' => $now,
	),
	56 => 
	array (
		'id' => 3557,
		'name' => 'Shaping Machine Setter-Operator',
		'description' => 'Shaping Machine Setter-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	57 => 
	array (
		'id' => 3558,
		'name' => 'Share And Stock Registration Clerk',
		'description' => 'Share And Stock Registration Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	58 => 
	array (
		'id' => 3559,
		'name' => 'Sharpening/Metal Machine Operator',
		'description' => 'Sharpening/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	59 => 
	array (
		'id' => 3560,
		'name' => 'Shearing/Metal Machine Operator',
		'description' => 'Shearing/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	60 => 
	array (
		'id' => 3561,
		'name' => 'Sheet Metal Marker',
		'description' => 'Sheet Metal Marker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	61 => 
	array (
		'id' => 3562,
		'name' => 'Sheet Metal Worker',
		'description' => 'Sheet Metal Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	62 => 
	array (
		'id' => 3563,
		'name' => 'Sheet Rubber Maker',
		'description' => 'Sheet Rubber Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	63 => 
	array (
		'id' => 3564,
		'name' => 'Shellfish Gatherer',
		'description' => 'Shellfish Gatherer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	64 => 
	array (
		'id' => 3565,
		'name' => 'Shift Supervisor',
		'description' => 'Shift Supervisor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	65 => 
	array (
		'id' => 3566,
		'name' => 'Ship/Cabin Stewardess',
		'description' => 'Ship/Cabin Stewardess',
		'created_at' => $now,
		'updated_at' => $now,
	),
	66 => 
	array (
		'id' => 3567,
		'name' => 'Ship Captain/Master',
		'description' => 'Ship Captain/Master',
		'created_at' => $now,
		'updated_at' => $now,
	),
	67 => 
	array (
		'id' => 3568,
		'name' => 'Ship Carpenter',
		'description' => 'Ship Carpenter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	68 => 
	array (
		'id' => 3569,
		'name' => 'Ship Chief Steward',
		'description' => 'Ship Chief Steward',
		'created_at' => $now,
		'updated_at' => $now,
	),
	69 => 
	array (
		'id' => 3570,
		'name' => 'Ship Chief Stewardess',
		'description' => 'Ship Chief Stewardess',
		'created_at' => $now,
		'updated_at' => $now,
	),
	70 => 
	array (
		'id' => 3571,
		'name' => 'Ship Construction Engineer',
		'description' => 'Ship Construction Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	71 => 
	array (
		'id' => 3572,
		'name' => 'Ship Cook',
		'description' => 'Ship Cook',
		'created_at' => $now,
		'updated_at' => $now,
	),
	72 => 
	array (
		'id' => 3573,
		'name' => 'Ship/Deck Officer',
		'description' => 'Ship/Deck Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	73 => 
	array (
		'id' => 3574,
		'name' => 'Ship Electrician',
		'description' => 'Ship Electrician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	74 => 
	array (
		'id' => 3575,
		'name' => 'Ship Engineer',
		'description' => 'Ship Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	75 => 
	array (
		'id' => 3576,
		'name' => 'Ship Fireperson',
		'description' => 'Ship Fireperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	76 => 
	array (
		'id' => 3577,
		'name' => 'Ship Joiner',
		'description' => 'Ship Joiner',
		'created_at' => $now,
		'updated_at' => $now,
	),
	77 => 
	array (
		'id' => 3578,
		'name' => 'Ship Mechanic',
		'description' => 'Ship Mechanic',
		'created_at' => $now,
		'updated_at' => $now,
	),
	78 => 
	array (
		'id' => 3579,
		'name' => 'Ship/Mess/Cabin Steward',
		'description' => 'Ship/Mess/Cabin Steward',
		'created_at' => $now,
		'updated_at' => $now,
	),
	79 => 
	array (
		'id' => 3580,
		'name' => 'Ship/Mess Stewardess',
		'description' => 'Ship/Mess Stewardess',
		'created_at' => $now,
		'updated_at' => $now,
	),
	80 => 
	array (
		'id' => 3581,
		'name' => 'Ship Navigator',
		'description' => 'Ship Navigator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	81 => 
	array (
		'id' => 3582,
		'name' => 'Ship Pilot',
		'description' => 'Ship Pilot',
		'created_at' => $now,
		'updated_at' => $now,
	),
	82 => 
	array (
		'id' => 3583,
		'name' => 'Shipping Agent',
		'description' => 'Shipping Agent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	83 => 
	array (
		'id' => 3584,
		'name' => 'Shipping And Purchasing Clerk',
		'description' => 'Shipping And Purchasing Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	84 => 
	array (
		'id' => 3585,
		'name' => 'Shipping Assistant',
		'description' => 'Shipping Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	85 => 
	array (
		'id' => 3586,
		'name' => 'Shipping Clerk',
		'description' => 'Shipping Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	86 => 
	array (
		'id' => 3587,
		'name' => 'Shipping Coordinator',
		'description' => 'Shipping Coordinator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	87 => 
	array (
		'id' => 3588,
		'name' => 'Shipping Executive',
		'description' => 'Shipping Executive',
		'created_at' => $now,
		'updated_at' => $now,
	),
	88 => 
	array (
		'id' => 3589,
		'name' => 'Ship Plater',
		'description' => 'Ship Plater',
		'created_at' => $now,
		'updated_at' => $now,
	),
	89 => 
	array (
		'id' => 3590,
		'name' => 'Ship Purser',
		'description' => 'Ship Purser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	90 => 
	array (
		'id' => 3591,
		'name' => 'Ship Quatermaster',
		'description' => 'Ship Quatermaster',
		'created_at' => $now,
		'updated_at' => $now,
	),
	91 => 
	array (
		'id' => 3592,
		'name' => 'Ship Rigger',
		'description' => 'Ship Rigger',
		'created_at' => $now,
		'updated_at' => $now,
	),
	92 => 
	array (
		'id' => 3593,
		'name' => 'Ship’S Cabin Attendant',
		'description' => 'Ship’S Cabin Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	93 => 
	array (
		'id' => 3594,
		'name' => 'Ship’S Hull Painter',
		'description' => 'Ship’S Hull Painter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	94 => 
	array (
		'id' => 3595,
		'name' => 'Ships Radio Officer',
		'description' => 'Ships Radio Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	95 => 
	array (
		'id' => 3596,
		'name' => 'Shipyard',
		'description' => 'Shipyard',
		'created_at' => $now,
		'updated_at' => $now,
	),
	96 => 
	array (
		'id' => 3597,
		'name' => 'Shoe Designer',
		'description' => 'Shoe Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	97 => 
	array (
		'id' => 3598,
		'name' => 'Shoemaker',
		'description' => 'Shoemaker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	98 => 
	array (
		'id' => 3599,
		'name' => 'Shoe Pattern-Maker',
		'description' => 'Shoe Pattern-Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	99 => 
	array (
		'id' => 3600,
		'name' => 'Shoe Production Machine Operator',
		'description' => 'Shoe Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	100 => 
	array (
		'id' => 3601,
		'name' => 'Shop Assistant',
		'description' => 'Shop Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	101 => 
	array (
		'id' => 3602,
		'name' => 'Shopkeeper',
		'description' => 'Shopkeeper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	102 => 
	array (
		'id' => 3603,
		'name' => 'Shopping Centre Manager',
		'description' => 'Shopping Centre Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	103 => 
	array (
		'id' => 3604,
		'name' => 'Shorthand Typist',
		'description' => 'Shorthand Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	104 => 
	array (
		'id' => 3605,
		'name' => 'Shot Firer',
		'description' => 'Shot Firer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	105 => 
	array (
		'id' => 3606,
		'name' => 'Shuffle-Car/Mine Operator',
		'description' => 'Shuffle-Car/Mine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	106 => 
	array (
		'id' => 3607,
		'name' => 'Siak/Nuja',
		'description' => 'Siak/Nuja',
		'created_at' => $now,
		'updated_at' => $now,
	),
	107 => 
	array (
		'id' => 3608,
		'name' => 'Sidang',
		'description' => 'Sidang',
		'created_at' => $now,
		'updated_at' => $now,
	),
	108 => 
	array (
		'id' => 3609,
		'name' => 'Sieving/Chemical And Related Processes Machine Operator',
		'description' => 'Sieving/Chemical And Related Processes Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	109 => 
	array (
		'id' => 3610,
		'name' => 'Signal/Railway Engineer',
		'description' => 'Signal/Railway Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	110 => 
	array (
		'id' => 3611,
		'name' => 'Signpainter',
		'description' => 'Signpainter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	111 => 
	array (
		'id' => 3612,
		'name' => 'Silicon Chip Production Machine Operator',
		'description' => 'Silicon Chip Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	112 => 
	array (
		'id' => 3613,
		'name' => 'Silk Reeler',
		'description' => 'Silk Reeler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	113 => 
	array (
		'id' => 3614,
		'name' => 'Silk-Screen Printer',
		'description' => 'Silk-Screen Printer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	114 => 
	array (
		'id' => 3615,
		'name' => 'Silkworm Cooker',
		'description' => 'Silkworm Cooker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	115 => 
	array (
		'id' => 3616,
		'name' => 'Silkworm Raiser',
		'description' => 'Silkworm Raiser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	116 => 
	array (
		'id' => 3617,
		'name' => 'Silversmith',
		'description' => 'Silversmith',
		'created_at' => $now,
		'updated_at' => $now,
	),
	117 => 
	array (
		'id' => 3618,
		'name' => 'Silviculture Technician',
		'description' => 'Silviculture Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	118 => 
	array (
		'id' => 3619,
		'name' => 'Silviculturist',
		'description' => 'Silviculturist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	119 => 
	array (
		'id' => 3620,
		'name' => 'Simultaneous Interpreter N41',
		'description' => 'Simultaneous Interpreter N41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	120 => 
	array (
		'id' => 3621,
		'name' => 'Singers And Composers Other Musician',
		'description' => 'Singers And Composers Other Musician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	121 => 
	array (
		'id' => 3622,
		'name' => 'Singer/Vocalist',
		'description' => 'Singer/Vocalist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	122 => 
	array (
		'id' => 3623,
		'name' => 'Sister',
		'description' => 'Sister',
		'created_at' => $now,
		'updated_at' => $now,
	),
	123 => 
	array (
		'id' => 3624,
		'name' => 'Site Clerk',
		'description' => 'Site Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	124 => 
	array (
		'id' => 3625,
		'name' => 'Site Coordinator',
		'description' => 'Site Coordinator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	125 => 
	array (
		'id' => 3626,
		'name' => 'Site Engineer',
		'description' => 'Site Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	126 => 
	array (
		'id' => 3627,
		'name' => 'Site General Worker',
		'description' => 'Site General Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	127 => 
	array (
		'id' => 3628,
		'name' => 'Site Manager',
		'description' => 'Site Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	128 => 
	array (
		'id' => 3629,
		'name' => 'Site Supervisor',
		'description' => 'Site Supervisor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	129 => 
	array (
		'id' => 3630,
		'name' => 'Ski Instructor',
		'description' => 'Ski Instructor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	130 => 
	array (
		'id' => 3631,
		'name' => 'Skilled/Mixed Animal Husbandry Farm Worker',
		'description' => 'Skilled/Mixed Animal Husbandry Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	131 => 
	array (
		'id' => 3632,
		'name' => 'Skin Doctor',
		'description' => 'Skin Doctor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	132 => 
	array (
		'id' => 3633,
		'name' => 'Skipper',
		'description' => 'Skipper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	133 => 
	array (
		'id' => 3634,
		'name' => 'Slate And Tile Roofer',
		'description' => 'Slate And Tile Roofer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	134 => 
	array (
		'id' => 3635,
		'name' => 'Slaughterer',
		'description' => 'Slaughterer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	135 => 
	array (
		'id' => 3636,
		'name' => 'Sleeping Car Attendant',
		'description' => 'Sleeping Car Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	136 => 
	array (
		'id' => 3637,
	'name' => 'Smelting/Metal (Blast Furnace) Furnace-Operator',
	'description' => 'Smelting/Metal (Blast Furnace) Furnace-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	137 => 
	array (
		'id' => 3638,
		'name' => 'Smokehouse/Rubber Attendant',
		'description' => 'Smokehouse/Rubber Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	138 => 
	array (
		'id' => 3639,
		'name' => 'Smokehouse Stoker',
		'description' => 'Smokehouse Stoker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	139 => 
	array (
		'id' => 3640,
		'name' => 'Snack-Bar Manager',
		'description' => 'Snack-Bar Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	140 => 
	array (
		'id' => 3641,
		'name' => 'Snake Charmer',
		'description' => 'Snake Charmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	141 => 
	array (
		'id' => 3642,
		'name' => 'Snake Farm Worker',
		'description' => 'Snake Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	142 => 
	array (
		'id' => 3643,
		'name' => 'Snooker Attendant',
		'description' => 'Snooker Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	143 => 
	array (
		'id' => 3644,
		'name' => 'Soap Maker',
		'description' => 'Soap Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	144 => 
	array (
		'id' => 3645,
		'name' => 'Social And Economics Data Enumerator',
		'description' => 'Social And Economics Data Enumerator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	145 => 
	array (
		'id' => 3646,
		'name' => 'Social Benefits Officer',
		'description' => 'Social Benefits Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	146 => 
	array (
		'id' => 3647,
		'name' => 'Social Development S17 Assistant',
		'description' => 'Social Development S17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	147 => 
	array (
		'id' => 3648,
		'name' => 'Social Development S27 Ssistant Officer',
		'description' => 'Social Development S27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	148 => 
	array (
		'id' => 3649,
		'name' => 'Social Development S41 Officer',
		'description' => 'Social Development S41 Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	149 => 
	array (
		'id' => 3650,
		'name' => 'Social Ecologist',
		'description' => 'Social Ecologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	150 => 
	array (
		'id' => 3651,
		'name' => 'Social Escort',
		'description' => 'Social Escort',
		'created_at' => $now,
		'updated_at' => $now,
	),
	151 => 
	array (
		'id' => 3652,
		'name' => 'Social Pathology Sociologist',
		'description' => 'Social Pathology Sociologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	152 => 
	array (
		'id' => 3653,
		'name' => 'Social Researcher N17 Assistant',
		'description' => 'Social Researcher N17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	153 => 
	array (
		'id' => 3654,
		'name' => 'Social Research N27 Ssistant Officer',
		'description' => 'Social Research N27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	154 => 
	array (
		'id' => 3655,
		'name' => 'Social Research N41 Officer',
		'description' => 'Social Research N41 Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	155 => 
	array (
		'id' => 3656,
		'name' => 'Social Science Statistician',
		'description' => 'Social Science Statistician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	156 => 
	array (
		'id' => 3657,
		'name' => 'Social Security Claims Appeals Referee',
		'description' => 'Social Security Claims Appeals Referee',
		'created_at' => $now,
		'updated_at' => $now,
	),
	157 => 
	array (
		'id' => 3658,
		'name' => 'Social Security Claims Officer',
		'description' => 'Social Security Claims Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	158 => 
	array (
		'id' => 3659,
		'name' => 'Social Welfare Worker',
		'description' => 'Social Welfare Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	159 => 
	array (
		'id' => 3660,
		'name' => 'Social Worker',
		'description' => 'Social Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	160 => 
	array (
		'id' => 3661,
		'name' => 'Social Work Manager',
		'description' => 'Social Work Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	161 => 
	array (
		'id' => 3662,
		'name' => 'Sociologist',
		'description' => 'Sociologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	162 => 
	array (
		'id' => 3663,
		'name' => 'Soft-Drinks Production Machine Operator',
		'description' => 'Soft-Drinks Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	163 => 
	array (
		'id' => 3664,
		'name' => 'Soft Furnishing Maker',
		'description' => 'Soft Furnishing Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	164 => 
	array (
		'id' => 3665,
		'name' => 'Software Designer',
		'description' => 'Software Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	165 => 
	array (
		'id' => 3666,
		'name' => 'Software Developer',
		'description' => 'Software Developer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	166 => 
	array (
		'id' => 3667,
		'name' => 'Software Programmer',
		'description' => 'Software Programmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	167 => 
	array (
		'id' => 3668,
		'name' => 'Software Tester',
		'description' => 'Software Tester',
		'created_at' => $now,
		'updated_at' => $now,
	),
	168 => 
	array (
		'id' => 3669,
		'name' => 'Soil Bacteriologist',
		'description' => 'Soil Bacteriologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	169 => 
	array (
		'id' => 3670,
		'name' => 'Soil Botanist',
		'description' => 'Soil Botanist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	170 => 
	array (
		'id' => 3671,
		'name' => 'Soil Conservationist',
		'description' => 'Soil Conservationist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	171 => 
	array (
		'id' => 3672,
		'name' => 'Soil Laboratory Assistant',
		'description' => 'Soil Laboratory Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	172 => 
	array (
		'id' => 3673,
		'name' => 'Soil Science Technician',
		'description' => 'Soil Science Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	173 => 
	array (
		'id' => 3674,
		'name' => 'Soil Scientist',
		'description' => 'Soil Scientist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	174 => 
	array (
		'id' => 3675,
		'name' => 'Soil Surveyor',
		'description' => 'Soil Surveyor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	175 => 
	array (
		'id' => 3676,
		'name' => 'Soil Technician',
		'description' => 'Soil Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	176 => 
	array (
		'id' => 3677,
		'name' => 'Solderer',
		'description' => 'Solderer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	177 => 
	array (
		'id' => 3678,
		'name' => 'Solicitor',
		'description' => 'Solicitor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	178 => 
	array (
		'id' => 3679,
		'name' => 'Solicitor L41',
		'description' => 'Solicitor L41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	179 => 
	array (
		'id' => 3680,
		'name' => 'Solicitor’S Assistant',
		'description' => 'Solicitor’S Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	180 => 
	array (
		'id' => 3681,
		'name' => 'Solid-State Physicist',
		'description' => 'Solid-State Physicist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	181 => 
	array (
		'id' => 3682,
		'name' => 'Solution Man',
		'description' => 'Solution Man',
		'created_at' => $now,
		'updated_at' => $now,
	),
	182 => 
	array (
		'id' => 3683,
		'name' => 'Song Writer',
		'description' => 'Song Writer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	183 => 
	array (
		'id' => 3684,
		'name' => 'Sonographer',
		'description' => 'Sonographer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	184 => 
	array (
		'id' => 3685,
		'name' => 'Sorter',
		'description' => 'Sorter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	185 => 
	array (
		'id' => 3686,
		'name' => 'Sound And Image Operator, Recording Equipment',
		'description' => 'Sound And Image Operator, Recording Equipment',
		'created_at' => $now,
		'updated_at' => $now,
	),
	186 => 
	array (
		'id' => 3687,
		'name' => 'Sound Editor',
		'description' => 'Sound Editor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	187 => 
	array (
		'id' => 3688,
		'name' => 'Sound-Effects Technician',
		'description' => 'Sound-Effects Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	188 => 
	array (
		'id' => 3689,
		'name' => 'Sound Mixer',
		'description' => 'Sound Mixer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	189 => 
	array (
		'id' => 3690,
		'name' => 'Sound Physicist',
		'description' => 'Sound Physicist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	190 => 
	array (
		'id' => 3691,
		'name' => 'Sound-Proofing Insulation Worker',
		'description' => 'Sound-Proofing Insulation Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	191 => 
	array (
		'id' => 3692,
		'name' => 'Sound Systems Engineer',
		'description' => 'Sound Systems Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	192 => 
	array (
		'id' => 3693,
		'name' => 'Soup Powder Production Machine Operator',
		'description' => 'Soup Powder Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	193 => 
	array (
		'id' => 3694,
		'name' => 'Sous Chef',
		'description' => 'Sous Chef',
		'created_at' => $now,
		'updated_at' => $now,
	),
	194 => 
	array (
		'id' => 3695,
		'name' => 'Speaker',
		'description' => 'Speaker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	195 => 
	array (
		'id' => 3696,
		'name' => 'Special Education/For The Blind Teacher',
		'description' => 'Special Education/For The Blind Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	196 => 
	array (
		'id' => 3697,
		'name' => 'Special Education/For The Deaf Teacher',
		'description' => 'Special Education/For The Deaf Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	197 => 
	array (
		'id' => 3698,
		'name' => 'Special Education/For The Dumb Teacher',
		'description' => 'Special Education/For The Dumb Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	198 => 
	array (
		'id' => 3699,
		'name' => 'Special Education/For The Mentally Handicapped Teacher',
		'description' => 'Special Education/For The Mentally Handicapped Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	199 => 
	array (
		'id' => 3700,
		'name' => 'Special Education/For The Physically Handicapped Teacher',
		'description' => 'Special Education/For The Physically Handicapped Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	200 => 
	array (
		'id' => 3701,
		'name' => 'Special-Interest Organization Secretary-General',
		'description' => 'Special-Interest Organization Secretary-General',
		'created_at' => $now,
		'updated_at' => $now,
	),
	201 => 
	array (
		'id' => 3702,
		'name' => 'Special-Interest Organization Senior Official',
		'description' => 'Special-Interest Organization Senior Official',
		'created_at' => $now,
		'updated_at' => $now,
	),
	202 => 
	array (
		'id' => 3703,
		'name' => 'Specialist Graphics And Sound/Computer',
		'description' => 'Specialist Graphics And Sound/Computer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	203 => 
	array (
		'id' => 3704,
		'name' => 'Specialized Nurse',
		'description' => 'Specialized Nurse',
		'created_at' => $now,
		'updated_at' => $now,
	),
	204 => 
	array (
		'id' => 3705,
		'name' => 'Speech Therapist',
		'description' => 'Speech Therapist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	205 => 
	array (
		'id' => 3706,
		'name' => 'Spice Farm Worker',
		'description' => 'Spice Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	206 => 
	array (
		'id' => 3707,
		'name' => 'Spice Miller',
		'description' => 'Spice Miller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	207 => 
	array (
		'id' => 3708,
		'name' => 'Spice Mixer',
		'description' => 'Spice Mixer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	208 => 
	array (
		'id' => 3709,
		'name' => 'Spinning And Winding Machine Operators Other Fibre Preparing',
		'description' => 'Spinning And Winding Machine Operators Other Fibre Preparing',
		'created_at' => $now,
		'updated_at' => $now,
	),
	209 => 
	array (
		'id' => 3710,
		'name' => 'Spinning/Metal Machine Operator',
		'description' => 'Spinning/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	210 => 
	array (
		'id' => 3711,
		'name' => 'Splicing/Cable And Rope Machine Operator',
		'description' => 'Splicing/Cable And Rope Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	211 => 
	array (
		'id' => 3712,
		'name' => 'Splitters And Carvers Other Stonemasons, Stone Cutters',
		'description' => 'Splitters And Carvers Other Stonemasons, Stone Cutters',
		'created_at' => $now,
		'updated_at' => $now,
	),
	212 => 
	array (
		'id' => 3713,
		'name' => 'Splitting/Stone Machine Operator',
		'description' => 'Splitting/Stone Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	213 => 
	array (
		'id' => 3714,
		'name' => 'Sporting Activities Manager',
		'description' => 'Sporting Activities Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	214 => 
	array (
		'id' => 3715,
		'name' => 'Sports Agent',
		'description' => 'Sports Agent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	215 => 
	array (
		'id' => 3716,
		'name' => 'Sports And Recreation Manager',
		'description' => 'Sports And Recreation Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	216 => 
	array (
		'id' => 3717,
		'name' => 'Sports Attendant',
		'description' => 'Sports Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	217 => 
	array (
		'id' => 3718,
		'name' => 'Sports Centre Manager',
		'description' => 'Sports Centre Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	218 => 
	array (
		'id' => 3719,
		'name' => 'Sports Coach',
		'description' => 'Sports Coach',
		'created_at' => $now,
		'updated_at' => $now,
	),
	219 => 
	array (
		'id' => 3720,
		'name' => 'Sports Equipment/Footwear Maker',
		'description' => 'Sports Equipment/Footwear Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	220 => 
	array (
		'id' => 3721,
		'name' => 'Sports Equipment/Metal Machine Operator',
		'description' => 'Sports Equipment/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	221 => 
	array (
		'id' => 3722,
		'name' => 'Sports Equipment/Wood Maker',
		'description' => 'Sports Equipment/Wood Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	222 => 
	array (
		'id' => 3723,
		'name' => 'Sports/Games Team Manager',
		'description' => 'Sports/Games Team Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	223 => 
	array (
		'id' => 3724,
		'name' => 'Sports Manager',
		'description' => 'Sports Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	224 => 
	array (
		'id' => 3725,
		'name' => 'Sports Official',
		'description' => 'Sports Official',
		'created_at' => $now,
		'updated_at' => $now,
	),
	225 => 
	array (
		'id' => 3726,
		'name' => 'Sportsperson',
		'description' => 'Sportsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	226 => 
	array (
		'id' => 3727,
		'name' => 'Sportsperson And Related Associate Professionals Other Athletes',
		'description' => 'Sportsperson And Related Associate Professionals Other Athletes',
		'created_at' => $now,
		'updated_at' => $now,
	),
	227 => 
	array (
		'id' => 3728,
		'name' => 'Sports Promoter',
		'description' => 'Sports Promoter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	228 => 
	array (
		'id' => 3729,
		'name' => 'Sports Trainer',
		'description' => 'Sports Trainer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	229 => 
	array (
		'id' => 3730,
		'name' => 'Spray-Dried/Chemical And Related Processes Operator',
		'description' => 'Spray-Dried/Chemical And Related Processes Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	230 => 
	array (
		'id' => 3731,
		'name' => 'Sprayer Worker',
		'description' => 'Sprayer Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	231 => 
	array (
		'id' => 3732,
		'name' => 'Spray Painter',
		'description' => 'Spray Painter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	232 => 
	array (
		'id' => 3733,
		'name' => 'Sprying/Metal Machine Operator',
		'description' => 'Sprying/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	233 => 
	array (
		'id' => 3734,
		'name' => 'Stadium Manager',
		'description' => 'Stadium Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	234 => 
	array (
		'id' => 3735,
		'name' => 'Staff Sergeant',
		'description' => 'Staff Sergeant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	235 => 
	array (
		'id' => 3736,
		'name' => 'Staff Training Officer',
		'description' => 'Staff Training Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	236 => 
	array (
		'id' => 3737,
		'name' => 'Staff Vocational Training Officer',
		'description' => 'Staff Vocational Training Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	237 => 
	array (
		'id' => 3738,
		'name' => 'Stage And Studio Carpenter',
		'description' => 'Stage And Studio Carpenter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	238 => 
	array (
		'id' => 3739,
		'name' => 'Stage And Studio Electrician',
		'description' => 'Stage And Studio Electrician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	239 => 
	array (
		'id' => 3740,
		'name' => 'Stage Director',
		'description' => 'Stage Director',
		'created_at' => $now,
		'updated_at' => $now,
	),
	240 => 
	array (
		'id' => 3741,
		'name' => 'Stage Manager',
		'description' => 'Stage Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	241 => 
	array (
		'id' => 3742,
		'name' => 'Stage Producer',
		'description' => 'Stage Producer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	242 => 
	array (
		'id' => 3743,
		'name' => 'Staining/Leather Machine Operator',
		'description' => 'Staining/Leather Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	243 => 
	array (
		'id' => 3744,
		'name' => 'Stamping/Metal Press-Operator',
		'description' => 'Stamping/Metal Press-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	244 => 
	array (
		'id' => 3745,
		'name' => 'Starching Machine Operator',
		'description' => 'Starching Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	245 => 
	array (
		'id' => 3746,
		'name' => 'State Assemblyman',
		'description' => 'State Assemblyman',
		'created_at' => $now,
		'updated_at' => $now,
	),
	246 => 
	array (
		'id' => 3747,
		'name' => 'Stationary Engine Operator',
		'description' => 'Stationary Engine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	247 => 
	array (
		'id' => 3748,
		'name' => 'Station N19 Manager',
		'description' => 'Station N19 Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	248 => 
	array (
		'id' => 3749,
		'name' => 'Statistical Clerk',
		'description' => 'Statistical Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	249 => 
	array (
		'id' => 3750,
		'name' => 'Statistical E27 Ssistant Officer',
		'description' => 'Statistical E27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	250 => 
	array (
		'id' => 3751,
		'name' => 'Statistical Officer',
		'description' => 'Statistical Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	251 => 
	array (
		'id' => 3752,
		'name' => 'Statistical Typist',
		'description' => 'Statistical Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	252 => 
	array (
		'id' => 3753,
		'name' => 'Statistician',
		'description' => 'Statistician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	253 => 
	array (
		'id' => 3754,
		'name' => 'Statistician E17 Assistant',
		'description' => 'Statistician E17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	254 => 
	array (
		'id' => 3755,
		'name' => 'Statistician E41',
		'description' => 'Statistician E41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	255 => 
	array (
		'id' => 3756,
		'name' => 'Statistician Superintendent',
		'description' => 'Statistician Superintendent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	256 => 
	array (
		'id' => 3757,
		'name' => 'Statutory Board Executive Officer',
		'description' => 'Statutory Board Executive Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	257 => 
	array (
		'id' => 3758,
		'name' => 'Statutory Board Senior Official',
		'description' => 'Statutory Board Senior Official',
		'created_at' => $now,
		'updated_at' => $now,
	),
	258 => 
	array (
		'id' => 3759,
		'name' => 'Steam Engine Operator',
		'description' => 'Steam Engine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	259 => 
	array (
		'id' => 3760,
		'name' => 'Steel Bender',
		'description' => 'Steel Bender',
		'created_at' => $now,
		'updated_at' => $now,
	),
	260 => 
	array (
		'id' => 3761,
		'name' => 'Steel Continuous-Mill Roller, Steel/Cold-Roller',
		'description' => 'Steel Continuous-Mill Roller, Steel/Cold-Roller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	261 => 
	array (
		'id' => 3762,
		'name' => 'Steel Converting Converter Blowing Operator',
		'description' => 'Steel Converting Converter Blowing Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	262 => 
	array (
		'id' => 3763,
		'name' => 'Steel Hot-Roller',
		'description' => 'Steel Hot-Roller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	263 => 
	array (
		'id' => 3764,
		'name' => 'Steeplejack',
		'description' => 'Steeplejack',
		'created_at' => $now,
		'updated_at' => $now,
	),
	264 => 
	array (
		'id' => 3765,
		'name' => 'Stencil/Silk-Screen Cutter',
		'description' => 'Stencil/Silk-Screen Cutter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	265 => 
	array (
		'id' => 3766,
		'name' => 'Stenographer',
		'description' => 'Stenographer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	266 => 
	array (
		'id' => 3767,
		'name' => 'Stenography Secretary',
		'description' => 'Stenography Secretary',
		'created_at' => $now,
		'updated_at' => $now,
	),
	267 => 
	array (
		'id' => 3768,
		'name' => 'Stenography/Typing Secretary',
		'description' => 'Stenography/Typing Secretary',
		'created_at' => $now,
		'updated_at' => $now,
	),
	268 => 
	array (
		'id' => 3769,
		'name' => 'Stenography Typist',
		'description' => 'Stenography Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	269 => 
	array (
		'id' => 3770,
		'name' => 'Stereotyper',
		'description' => 'Stereotyper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	270 => 
	array (
		'id' => 3771,
		'name' => 'Sterilizer/Dairy Products Operator',
		'description' => 'Sterilizer/Dairy Products Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	271 => 
	array (
		'id' => 3772,
		'name' => 'Sterilizing Oil Palm Attendant',
		'description' => 'Sterilizing Oil Palm Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	272 => 
	array (
		'id' => 3773,
		'name' => 'Steroids Biochemist',
		'description' => 'Steroids Biochemist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	273 => 
	array (
		'id' => 3774,
		'name' => 'Stevedore',
		'description' => 'Stevedore',
		'created_at' => $now,
		'updated_at' => $now,
	),
	274 => 
	array (
		'id' => 3775,
	'name' => 'Still/Batch (Chemical Processes Except Petroleum And Natural Gas) Operator',
	'description' => 'Still/Batch (Chemical Processes Except Petroleum And Natural Gas) Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	275 => 
	array (
		'id' => 3776,
		'name' => 'Still/Chemical Processes Operator',
		'description' => 'Still/Chemical Processes Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	276 => 
	array (
		'id' => 3777,
	'name' => 'Still/Continuous (Chemical Processes Except Petroleum And Natural Gas) Operator',
	'description' => 'Still/Continuous (Chemical Processes Except Petroleum And Natural Gas) Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	277 => 
	array (
		'id' => 3778,
	'name' => 'Stillman (Petroleum Refining)',
	'description' => 'Stillman (Petroleum Refining)',
		'created_at' => $now,
		'updated_at' => $now,
	),
	278 => 
	array (
		'id' => 3779,
		'name' => 'Still/Turpentine Operator',
		'description' => 'Still/Turpentine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	279 => 
	array (
		'id' => 3780,
		'name' => 'Stock And Shares Broker',
		'description' => 'Stock And Shares Broker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	280 => 
	array (
		'id' => 3781,
		'name' => 'Stockbroker Clerk',
		'description' => 'Stockbroker Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	281 => 
	array (
		'id' => 3782,
		'name' => 'Stock Clerk',
		'description' => 'Stock Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	282 => 
	array (
		'id' => 3783,
		'name' => 'Stock Control Clerk',
		'description' => 'Stock Control Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	283 => 
	array (
		'id' => 3784,
		'name' => 'Stock Filler',
		'description' => 'Stock Filler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	284 => 
	array (
		'id' => 3785,
		'name' => 'Stock Handler',
		'description' => 'Stock Handler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	285 => 
	array (
		'id' => 3786,
		'name' => 'Stock Record Clerk',
		'description' => 'Stock Record Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	286 => 
	array (
		'id' => 3787,
		'name' => 'Stone And Other Mineral Products Machine Operators Other Cement',
		'description' => 'Stone And Other Mineral Products Machine Operators Other Cement',
		'created_at' => $now,
		'updated_at' => $now,
	),
	287 => 
	array (
		'id' => 3788,
		'name' => 'Stone Articles Handicraft Worker',
		'description' => 'Stone Articles Handicraft Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	288 => 
	array (
		'id' => 3789,
		'name' => 'Stone Carver',
		'description' => 'Stone Carver',
		'created_at' => $now,
		'updated_at' => $now,
	),
	289 => 
	array (
		'id' => 3790,
		'name' => 'Stone Cutter And Finisher',
		'description' => 'Stone Cutter And Finisher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	290 => 
	array (
		'id' => 3791,
		'name' => 'Stone Dresser',
		'description' => 'Stone Dresser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	291 => 
	array (
		'id' => 3792,
		'name' => 'Stone Grader',
		'description' => 'Stone Grader',
		'created_at' => $now,
		'updated_at' => $now,
	),
	292 => 
	array (
		'id' => 3793,
		'name' => 'Stone Grinder',
		'description' => 'Stone Grinder',
		'created_at' => $now,
		'updated_at' => $now,
	),
	293 => 
	array (
		'id' => 3794,
		'name' => 'Stone Polisher',
		'description' => 'Stone Polisher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	294 => 
	array (
		'id' => 3795,
		'name' => 'Stone Processing Machine Operator',
		'description' => 'Stone Processing Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	295 => 
	array (
		'id' => 3796,
		'name' => 'Stone Sawyer',
		'description' => 'Stone Sawyer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	296 => 
	array (
		'id' => 3797,
		'name' => 'Stone Splitter',
		'description' => 'Stone Splitter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	297 => 
	array (
		'id' => 3798,
		'name' => 'Stone Worker',
		'description' => 'Stone Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	298 => 
	array (
		'id' => 3799,
		'name' => 'Stonework Layout Man',
		'description' => 'Stonework Layout Man',
		'created_at' => $now,
		'updated_at' => $now,
	),
	299 => 
	array (
		'id' => 3800,
		'name' => 'Storage Manager',
		'description' => 'Storage Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	300 => 
	array (
		'id' => 3801,
		'name' => 'Store Assistant',
		'description' => 'Store Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	301 => 
	array (
		'id' => 3802,
		'name' => 'Store Attendant',
		'description' => 'Store Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	302 => 
	array (
		'id' => 3803,
		'name' => 'Store Cashier',
		'description' => 'Store Cashier',
		'created_at' => $now,
		'updated_at' => $now,
	),
	303 => 
	array (
		'id' => 3804,
		'name' => 'Store Clerk',
		'description' => 'Store Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	304 => 
	array (
		'id' => 3805,
		'name' => 'Store Controller',
		'description' => 'Store Controller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	305 => 
	array (
		'id' => 3806,
		'name' => 'Store Coordinator',
		'description' => 'Store Coordinator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	306 => 
	array (
		'id' => 3807,
		'name' => 'Store Detective',
		'description' => 'Store Detective',
		'created_at' => $now,
		'updated_at' => $now,
	),
	307 => 
	array (
		'id' => 3808,
		'name' => 'Store Engineering Executive',
		'description' => 'Store Engineering Executive',
		'created_at' => $now,
		'updated_at' => $now,
	),
	308 => 
	array (
		'id' => 3809,
		'name' => 'Store Executive',
		'description' => 'Store Executive',
		'created_at' => $now,
		'updated_at' => $now,
	),
	309 => 
	array (
		'id' => 3810,
		'name' => 'Store Hand',
		'description' => 'Store Hand',
		'created_at' => $now,
		'updated_at' => $now,
	),
	310 => 
	array (
		'id' => 3811,
		'name' => 'Storekeeper',
		'description' => 'Storekeeper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	311 => 
	array (
		'id' => 3812,
		'name' => 'Store Operator',
		'description' => 'Store Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	312 => 
	array (
		'id' => 3813,
		'name' => 'Store Receiving Assistant',
		'description' => 'Store Receiving Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	313 => 
	array (
		'id' => 3814,
		'name' => 'Store Supervisor',
		'description' => 'Store Supervisor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	314 => 
	array (
		'id' => 3815,
		'name' => 'Store Worker',
		'description' => 'Store Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	315 => 
	array (
		'id' => 3816,
		'name' => 'Story Teller',
		'description' => 'Story Teller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	316 => 
	array (
		'id' => 3817,
		'name' => 'Stratigraph',
		'description' => 'Stratigraph',
		'created_at' => $now,
		'updated_at' => $now,
	),
	317 => 
	array (
		'id' => 3818,
		'name' => 'Stratigraphy Geologist',
		'description' => 'Stratigraphy Geologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	318 => 
	array (
		'id' => 3819,
		'name' => 'Straw Production Machine Operator',
		'description' => 'Straw Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	319 => 
	array (
		'id' => 3820,
		'name' => 'Street/Food Vendor',
		'description' => 'Street/Food Vendor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	320 => 
	array (
		'id' => 3821,
		'name' => 'Street/Non-Food Products Vendor',
		'description' => 'Street/Non-Food Products Vendor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	321 => 
	array (
		'id' => 3822,
		'name' => 'Street Stall Salesperson',
		'description' => 'Street Stall Salesperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	322 => 
	array (
		'id' => 3823,
		'name' => 'Stringed-Musical Instrument Maker',
		'description' => 'Stringed-Musical Instrument Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	323 => 
	array (
		'id' => 3824,
		'name' => 'Stripping And Cutting/Wire Machine Operator',
		'description' => 'Stripping And Cutting/Wire Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	324 => 
	array (
		'id' => 3825,
		'name' => 'Structural Draughtsperson',
		'description' => 'Structural Draughtsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	325 => 
	array (
		'id' => 3826,
		'name' => 'Structural Metal Erector',
		'description' => 'Structural Metal Erector',
		'created_at' => $now,
		'updated_at' => $now,
	),
	326 => 
	array (
		'id' => 3827,
		'name' => 'Structural Metal Marker',
		'description' => 'Structural Metal Marker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	327 => 
	array (
		'id' => 3828,
		'name' => 'Structural Metal Preparer',
		'description' => 'Structural Metal Preparer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	328 => 
	array (
		'id' => 3829,
		'name' => 'Structural Steel Painter',
		'description' => 'Structural Steel Painter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	329 => 
	array (
		'id' => 3830,
		'name' => 'Stucco Plasterer',
		'description' => 'Stucco Plasterer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	330 => 
	array (
		'id' => 3831,
		'name' => 'Studio Equipment/Radio And Television Operator',
		'description' => 'Studio Equipment/Radio And Television Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	331 => 
	array (
		'id' => 3832,
		'name' => 'Sub-Assembly Manual Operator',
		'description' => 'Sub-Assembly Manual Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	332 => 
	array (
		'id' => 3833,
		'name' => 'Sub Lieutenant',
		'description' => 'Sub Lieutenant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	333 => 
	array (
		'id' => 3834,
		'name' => 'Sugarcane Farm Worker',
		'description' => 'Sugarcane Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	334 => 
	array (
		'id' => 3835,
		'name' => 'Sulphur Burner',
		'description' => 'Sulphur Burner',
		'created_at' => $now,
		'updated_at' => $now,
	),
	335 => 
	array (
		'id' => 3836,
		'name' => 'Summon Server',
		'description' => 'Summon Server',
		'created_at' => $now,
		'updated_at' => $now,
	),
	336 => 
	array (
		'id' => 3837,
		'name' => 'Sundries And Toiletries Worker',
		'description' => 'Sundries And Toiletries Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	337 => 
	array (
		'id' => 3838,
		'name' => 'Sundries Worker',
		'description' => 'Sundries Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	338 => 
	array (
		'id' => 3839,
		'name' => 'Supercalender/Paper Operator',
		'description' => 'Supercalender/Paper Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	339 => 
	array (
		'id' => 3840,
		'name' => 'Superintendent/Ground Master',
		'description' => 'Superintendent/Ground Master',
		'created_at' => $now,
		'updated_at' => $now,
	),
	340 => 
	array (
		'id' => 3841,
		'name' => 'Supermarket Manager',
		'description' => 'Supermarket Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	341 => 
	array (
		'id' => 3842,
		'name' => 'Supervisor Steward',
		'description' => 'Supervisor Steward',
		'created_at' => $now,
		'updated_at' => $now,
	),
	342 => 
	array (
		'id' => 3843,
		'name' => 'Supplies Manager',
		'description' => 'Supplies Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	343 => 
	array (
		'id' => 3844,
		'name' => 'Supply Clerk',
		'description' => 'Supply Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	344 => 
	array (
		'id' => 3845,
		'name' => 'Surgeon',
		'description' => 'Surgeon',
		'created_at' => $now,
		'updated_at' => $now,
	),
	345 => 
	array (
		'id' => 3846,
		'name' => 'Surgery Veterinarian',
		'description' => 'Surgery Veterinarian',
		'created_at' => $now,
		'updated_at' => $now,
	),
	346 => 
	array (
		'id' => 3847,
		'name' => 'Surgical Pathologist',
		'description' => 'Surgical Pathologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	347 => 
	array (
		'id' => 3848,
		'name' => 'Survey Interviewer',
		'description' => 'Survey Interviewer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	348 => 
	array (
		'id' => 3849,
		'name' => 'Surveyor',
		'description' => 'Surveyor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	349 => 
	array (
		'id' => 3850,
		'name' => 'Surveyor Assistant',
		'description' => 'Surveyor Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	350 => 
	array (
		'id' => 3851,
		'name' => 'Surveyor J17 Technician',
		'description' => 'Surveyor J17 Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	351 => 
	array (
		'id' => 3852,
		'name' => 'Surveyor J29 Technical Assistant',
		'description' => 'Surveyor J29 Technical Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	352 => 
	array (
		'id' => 3853,
		'name' => 'Surveyor J41',
		'description' => 'Surveyor J41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	353 => 
	array (
		'id' => 3854,
		'name' => 'Surveyor Technical Assistant',
		'description' => 'Surveyor Technical Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	354 => 
	array (
		'id' => 3855,
		'name' => 'Survey Statistics',
		'description' => 'Survey Statistics',
		'created_at' => $now,
		'updated_at' => $now,
	),
	355 => 
	array (
		'id' => 3856,
		'name' => 'Swimming Coach',
		'description' => 'Swimming Coach',
		'created_at' => $now,
		'updated_at' => $now,
	),
	356 => 
	array (
		'id' => 3857,
		'name' => 'Swimming Pool Attendant',
		'description' => 'Swimming Pool Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	357 => 
	array (
		'id' => 3858,
		'name' => 'Swimming Pool Cleaner',
		'description' => 'Swimming Pool Cleaner',
		'created_at' => $now,
		'updated_at' => $now,
	),
	358 => 
	array (
		'id' => 3859,
		'name' => 'Syariah LS27 Ssistant Officer',
		'description' => 'Syariah LS27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	359 => 
	array (
		'id' => 3860,
		'name' => 'Syariah LS41 Officer',
		'description' => 'Syariah LS41 Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	360 => 
	array (
		'id' => 3861,
		'name' => 'Syariah S17 Assistant',
		'description' => 'Syariah S17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	361 => 
	array (
		'id' => 3862,
		'name' => 'Synthetic Yarn Maker',
		'description' => 'Synthetic Yarn Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	362 => 
	array (
		'id' => 3863,
		'name' => 'Syrup Maker',
		'description' => 'Syrup Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	363 => 
	array (
		'id' => 3864,
		'name' => 'Syrup-Mixing Plant Operator',
		'description' => 'Syrup-Mixing Plant Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	364 => 
	array (
		'id' => 3865,
		'name' => 'Systems Administrator',
		'description' => 'Systems Administrator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	365 => 
	array (
		'id' => 3866,
		'name' => 'Systems/Computer Analyst',
		'description' => 'Systems/Computer Analyst',
		'created_at' => $now,
		'updated_at' => $now,
	),
	366 => 
	array (
		'id' => 3867,
		'name' => 'Systems Computer Designer',
		'description' => 'Systems Computer Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	367 => 
	array (
		'id' => 3868,
		'name' => 'Systems Consultant',
		'description' => 'Systems Consultant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	368 => 
	array (
		'id' => 3869,
		'name' => 'Systems Engineer',
		'description' => 'Systems Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	369 => 
	array (
		'id' => 3870,
		'name' => 'Systems/Except Computers Analyst',
		'description' => 'Systems/Except Computers Analyst',
		'created_at' => $now,
		'updated_at' => $now,
	),
	370 => 
	array (
		'id' => 3871,
		'name' => 'Systems/Except Computers Designer',
		'description' => 'Systems/Except Computers Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	371 => 
	array (
		'id' => 3872,
		'name' => 'Systems/Except Computers Engineer',
		'description' => 'Systems/Except Computers Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	372 => 
	array (
		'id' => 3873,
		'name' => 'Systems Programmer',
		'description' => 'Systems Programmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	373 => 
	array (
		'id' => 3874,
		'name' => 'Systems Tester',
		'description' => 'Systems Tester',
		'created_at' => $now,
		'updated_at' => $now,
	),
	374 => 
	array (
		'id' => 3875,
		'name' => 'Tableting/Plastics Machine Operator',
		'description' => 'Tableting/Plastics Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	375 => 
	array (
		'id' => 3876,
		'name' => 'Tacky Timber Operator',
		'description' => 'Tacky Timber Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	376 => 
	array (
		'id' => 3877,
		'name' => 'Tailor',
		'description' => 'Tailor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	377 => 
	array (
		'id' => 3878,
		'name' => 'Tally Clerk',
		'description' => 'Tally Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	378 => 
	array (
		'id' => 3879,
		'name' => 'Tamping Machinery/Construction Operator',
		'description' => 'Tamping Machinery/Construction Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	379 => 
	array (
		'id' => 3880,
		'name' => 'Tanker Driver',
		'description' => 'Tanker Driver',
		'created_at' => $now,
		'updated_at' => $now,
	),
	380 => 
	array (
		'id' => 3881,
		'name' => 'Tanners And Fellmonger Pelt Dressers',
		'description' => 'Tanners And Fellmonger Pelt Dressers',
		'created_at' => $now,
		'updated_at' => $now,
	),
	381 => 
	array (
		'id' => 3882,
		'name' => 'Tanning Machine Operator',
		'description' => 'Tanning Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	382 => 
	array (
		'id' => 3883,
		'name' => 'Tapioca Farm Worker',
		'description' => 'Tapioca Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	383 => 
	array (
		'id' => 3884,
		'name' => 'Tapioca Miller',
		'description' => 'Tapioca Miller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	384 => 
	array (
		'id' => 3885,
		'name' => 'Tattoo Artist',
		'description' => 'Tattoo Artist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	385 => 
	array (
		'id' => 3886,
		'name' => 'Tattooist',
		'description' => 'Tattooist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	386 => 
	array (
		'id' => 3887,
		'name' => 'Tax Accountant',
		'description' => 'Tax Accountant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	387 => 
	array (
		'id' => 3888,
		'name' => 'Tax Clerk',
		'description' => 'Tax Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	388 => 
	array (
		'id' => 3889,
		'name' => 'Tax Consultant',
		'description' => 'Tax Consultant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	389 => 
	array (
		'id' => 3890,
		'name' => 'Tax/Estimator Ssistant Officer',
		'description' => 'Tax/Estimator Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	390 => 
	array (
		'id' => 3891,
		'name' => 'Taxi And Van Drivers Other Car',
		'description' => 'Taxi And Van Drivers Other Car',
		'created_at' => $now,
		'updated_at' => $now,
	),
	391 => 
	array (
		'id' => 3892,
		'name' => 'Taxidermist',
		'description' => 'Taxidermist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	392 => 
	array (
		'id' => 3893,
		'name' => 'Taxi Driver',
		'description' => 'Taxi Driver',
		'created_at' => $now,
		'updated_at' => $now,
	),
	393 => 
	array (
		'id' => 3894,
		'name' => 'Taxonomist',
		'description' => 'Taxonomist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	394 => 
	array (
		'id' => 3895,
		'name' => 'Taxonomy Botanist',
		'description' => 'Taxonomy Botanist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	395 => 
	array (
		'id' => 3896,
		'name' => 'Taxonomy Zoologist',
		'description' => 'Taxonomy Zoologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	396 => 
	array (
		'id' => 3897,
		'name' => 'Teacher For The Exceptionally Intelligent',
		'description' => 'Teacher For The Exceptionally Intelligent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	397 => 
	array (
		'id' => 3898,
		'name' => 'Teachers\' Aids',
		'description' => 'Teachers\' Aids',
		'created_at' => $now,
		'updated_at' => $now,
	),
	398 => 
	array (
		'id' => 3899,
		'name' => 'Teaching Aids Specialist',
		'description' => 'Teaching Aids Specialist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	399 => 
	array (
		'id' => 3900,
		'name' => 'Tea Farm Worker',
		'description' => 'Tea Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	400 => 
	array (
		'id' => 3901,
		'name' => 'Tea Grader/Taster',
		'description' => 'Tea Grader/Taster',
		'created_at' => $now,
		'updated_at' => $now,
	),
	401 => 
	array (
		'id' => 3902,
		'name' => 'Tea Lady',
		'description' => 'Tea Lady',
		'created_at' => $now,
		'updated_at' => $now,
	),
	402 => 
	array (
		'id' => 3903,
		'name' => 'Tea-Leaf Processing Machine Operator',
		'description' => 'Tea-Leaf Processing Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	403 => 
	array (
		'id' => 3904,
		'name' => 'Technical Adviser',
		'description' => 'Technical Adviser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	404 => 
	array (
		'id' => 3905,
		'name' => 'Technical Clerk',
		'description' => 'Technical Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	405 => 
	array (
		'id' => 3906,
		'name' => 'Technical Draughtsperson',
		'description' => 'Technical Draughtsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	406 => 
	array (
		'id' => 3907,
		'name' => 'Technical Illustration Draughtsperson',
		'description' => 'Technical Illustration Draughtsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	407 => 
	array (
		'id' => 3908,
		'name' => 'Technical Illustrator',
		'description' => 'Technical Illustrator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	408 => 
	array (
		'id' => 3909,
		'name' => 'Technical Information Information Scientist',
		'description' => 'Technical Information Information Scientist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	409 => 
	array (
		'id' => 3910,
		'name' => 'Technical Marine Superintendent',
		'description' => 'Technical Marine Superintendent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	410 => 
	array (
		'id' => 3911,
		'name' => 'Technical Programmer',
		'description' => 'Technical Programmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	411 => 
	array (
		'id' => 3912,
		'name' => 'Technical Salesperson',
		'description' => 'Technical Salesperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	412 => 
	array (
		'id' => 3913,
		'name' => 'Technical Sales Representatives',
		'description' => 'Technical Sales Representatives',
		'created_at' => $now,
		'updated_at' => $now,
	),
	413 => 
	array (
		'id' => 3914,
		'name' => 'Technical Service Adviser',
		'description' => 'Technical Service Adviser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	414 => 
	array (
		'id' => 3915,
		'name' => 'Technical Teacher',
		'description' => 'Technical Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	415 => 
	array (
		'id' => 3916,
		'name' => 'Technical Writer',
		'description' => 'Technical Writer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	416 => 
	array (
		'id' => 3917,
		'name' => 'Technician Clerk',
		'description' => 'Technician Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	417 => 
	array (
		'id' => 3918,
		'name' => 'Telecine Operator',
		'description' => 'Telecine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	418 => 
	array (
		'id' => 3919,
		'name' => 'Telecommunications/Aerospace Engineer',
		'description' => 'Telecommunications/Aerospace Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	419 => 
	array (
		'id' => 3920,
		'name' => 'Telecommunications Engineering Assistant',
		'description' => 'Telecommunications Engineering Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	420 => 
	array (
		'id' => 3921,
		'name' => 'Telecommunications Equipment Operator',
		'description' => 'Telecommunications Equipment Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	421 => 
	array (
		'id' => 3922,
		'name' => 'Telecommunication Service Operator',
		'description' => 'Telecommunication Service Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	422 => 
	array (
		'id' => 3923,
		'name' => 'Telecommunications/Microwave Engineer',
		'description' => 'Telecommunications/Microwave Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	423 => 
	array (
		'id' => 3924,
		'name' => 'Telecommunications/Radar Engineer',
		'description' => 'Telecommunications/Radar Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	424 => 
	array (
		'id' => 3925,
		'name' => 'Telecommunications/Radio Engineer',
		'description' => 'Telecommunications/Radio Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	425 => 
	array (
		'id' => 3926,
		'name' => 'Telecommunications/Signal Systems Engineer',
		'description' => 'Telecommunications/Signal Systems Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	426 => 
	array (
		'id' => 3927,
		'name' => 'Telecommunications Technologist, Engineering',
		'description' => 'Telecommunications Technologist, Engineering',
		'created_at' => $now,
		'updated_at' => $now,
	),
	427 => 
	array (
		'id' => 3928,
		'name' => 'Telecommunications/Telegraph Engineer',
		'description' => 'Telecommunications/Telegraph Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	428 => 
	array (
		'id' => 3929,
		'name' => 'Telecommunications/Telephone Engineer',
		'description' => 'Telecommunications/Telephone Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	429 => 
	array (
		'id' => 3930,
		'name' => 'Telecommunications/Television Engineer',
		'description' => 'Telecommunications/Television Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	430 => 
	array (
		'id' => 3931,
		'name' => 'Telemarketer',
		'description' => 'Telemarketer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	431 => 
	array (
		'id' => 3932,
		'name' => 'Telephone And Telegraph Installer',
		'description' => 'Telephone And Telegraph Installer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	432 => 
	array (
		'id' => 3933,
		'name' => 'Telephone And Telegraph Mechanic',
		'description' => 'Telephone And Telegraph Mechanic',
		'created_at' => $now,
		'updated_at' => $now,
	),
	433 => 
	array (
		'id' => 3934,
	'name' => 'Telephone (Private Branch Exchange) Operator',
	'description' => 'Telephone (Private Branch Exchange) Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	434 => 
	array (
		'id' => 3935,
		'name' => 'Telephone Receptionist',
		'description' => 'Telephone Receptionist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	435 => 
	array (
		'id' => 3936,
		'name' => 'Telephone Switchboard-Operator',
		'description' => 'Telephone Switchboard-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	436 => 
	array (
		'id' => 3937,
		'name' => 'Telephone/Telegraph/TV Cable Line Worker',
		'description' => 'Telephone/Telegraph/TV Cable Line Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	437 => 
	array (
		'id' => 3938,
	'name' => 'Telephone (Telephone Exchange) Operator',
	'description' => 'Telephone (Telephone Exchange) Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	438 => 
	array (
		'id' => 3939,
		'name' => 'Telephone Wireman',
		'description' => 'Telephone Wireman',
		'created_at' => $now,
		'updated_at' => $now,
	),
	439 => 
	array (
		'id' => 3940,
		'name' => 'Telephonist',
		'description' => 'Telephonist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	440 => 
	array (
		'id' => 3941,
		'name' => 'Telesales Clerk',
		'description' => 'Telesales Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	441 => 
	array (
		'id' => 3942,
		'name' => 'Tele-Typist',
		'description' => 'Tele-Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	442 => 
	array (
		'id' => 3943,
		'name' => 'Television And Other Media Other Announcers On Radio',
		'description' => 'Television And Other Media Other Announcers On Radio',
		'created_at' => $now,
		'updated_at' => $now,
	),
	443 => 
	array (
		'id' => 3944,
		'name' => 'Television Producer',
		'description' => 'Television Producer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	444 => 
	array (
		'id' => 3945,
		'name' => 'Tempering/Glass Furnace-Operator',
		'description' => 'Tempering/Glass Furnace-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	445 => 
	array (
		'id' => 3946,
		'name' => 'Temple Priest',
		'description' => 'Temple Priest',
		'created_at' => $now,
		'updated_at' => $now,
	),
	446 => 
	array (
		'id' => 3947,
		'name' => 'Tennis Coach',
		'description' => 'Tennis Coach',
		'created_at' => $now,
		'updated_at' => $now,
	),
	447 => 
	array (
		'id' => 3948,
		'name' => 'Tent And Awning Maker, Sail',
		'description' => 'Tent And Awning Maker, Sail',
		'created_at' => $now,
		'updated_at' => $now,
	),
	448 => 
	array (
		'id' => 3949,
		'name' => 'Tent Cutter',
		'description' => 'Tent Cutter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	449 => 
	array (
		'id' => 3950,
		'name' => 'Tents Pattern-Maker',
		'description' => 'Tents Pattern-Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	450 => 
	array (
		'id' => 3951,
		'name' => 'Terrazzo Tile Machine Operator',
		'description' => 'Terrazzo Tile Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	451 => 
	array (
		'id' => 3952,
		'name' => 'Terrazzo Worker',
		'description' => 'Terrazzo Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	452 => 
	array (
		'id' => 3953,
		'name' => 'Territorial Army',
		'description' => 'Territorial Army',
		'created_at' => $now,
		'updated_at' => $now,
	),
	453 => 
	array (
		'id' => 3954,
		'name' => 'Test Technician',
		'description' => 'Test Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	454 => 
	array (
		'id' => 3955,
		'name' => 'Textile Card Grinder',
		'description' => 'Textile Card Grinder',
		'created_at' => $now,
		'updated_at' => $now,
	),
	455 => 
	array (
		'id' => 3956,
		'name' => 'Textile Chemist',
		'description' => 'Textile Chemist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	456 => 
	array (
		'id' => 3957,
		'name' => 'Textile Crimp-Setter',
		'description' => 'Textile Crimp-Setter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	457 => 
	array (
		'id' => 3958,
		'name' => 'Textile Designer',
		'description' => 'Textile Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	458 => 
	array (
		'id' => 3959,
		'name' => 'Textile Design Tracer',
		'description' => 'Textile Design Tracer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	459 => 
	array (
		'id' => 3960,
		'name' => 'Textile Machinery Assembler',
		'description' => 'Textile Machinery Assembler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	460 => 
	array (
		'id' => 3961,
		'name' => 'Textile Printer',
		'description' => 'Textile Printer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	461 => 
	array (
		'id' => 3962,
		'name' => 'Textile Products Assembler',
		'description' => 'Textile Products Assembler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	462 => 
	array (
		'id' => 3963,
		'name' => 'Textile Sizer',
		'description' => 'Textile Sizer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	463 => 
	array (
		'id' => 3964,
		'name' => 'Textile Technologist',
		'description' => 'Textile Technologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	464 => 
	array (
		'id' => 3965,
		'name' => 'Thatcher',
		'description' => 'Thatcher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	465 => 
	array (
		'id' => 3966,
		'name' => 'Theatre Cashier',
		'description' => 'Theatre Cashier',
		'created_at' => $now,
		'updated_at' => $now,
	),
	466 => 
	array (
		'id' => 3967,
		'name' => 'Theatre Producer',
		'description' => 'Theatre Producer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	467 => 
	array (
		'id' => 3968,
		'name' => 'Theatrical Agent',
		'description' => 'Theatrical Agent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	468 => 
	array (
		'id' => 3969,
		'name' => 'Theatrical Director',
		'description' => 'Theatrical Director',
		'created_at' => $now,
		'updated_at' => $now,
	),
	469 => 
	array (
		'id' => 3970,
		'name' => 'Theatrical Set Designer',
		'description' => 'Theatrical Set Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	470 => 
	array (
		'id' => 3971,
		'name' => 'Theoretical Physicist',
		'description' => 'Theoretical Physicist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	471 => 
	array (
		'id' => 3972,
		'name' => 'Therapeutic Dietician',
		'description' => 'Therapeutic Dietician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	472 => 
	array (
		'id' => 3973,
		'name' => 'Therapeutic Masseur',
		'description' => 'Therapeutic Masseur',
		'created_at' => $now,
		'updated_at' => $now,
	),
	473 => 
	array (
		'id' => 3974,
		'name' => 'Thermodynamics',
		'description' => 'Thermodynamics',
		'created_at' => $now,
		'updated_at' => $now,
	),
	474 => 
	array (
		'id' => 3975,
		'name' => 'Thermodynamics Physicist',
		'description' => 'Thermodynamics Physicist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	475 => 
	array (
		'id' => 3976,
		'name' => 'Thoracic Surgeon',
		'description' => 'Thoracic Surgeon',
		'created_at' => $now,
		'updated_at' => $now,
	),
	476 => 
	array (
		'id' => 3977,
		'name' => 'Thread And Yarn Spinner',
		'description' => 'Thread And Yarn Spinner',
		'created_at' => $now,
		'updated_at' => $now,
	),
	477 => 
	array (
		'id' => 3978,
		'name' => 'Thread And Yarn Winder',
		'description' => 'Thread And Yarn Winder',
		'created_at' => $now,
		'updated_at' => $now,
	),
	478 => 
	array (
		'id' => 3979,
		'name' => 'Thread Grinder',
		'description' => 'Thread Grinder',
		'created_at' => $now,
		'updated_at' => $now,
	),
	479 => 
	array (
		'id' => 3980,
		'name' => 'Ticket Inspector',
		'description' => 'Ticket Inspector',
		'created_at' => $now,
		'updated_at' => $now,
	),
	480 => 
	array (
		'id' => 3981,
	'name' => 'Ticket Issuing (Except Travel) Clerk',
	'description' => 'Ticket Issuing (Except Travel) Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	481 => 
	array (
		'id' => 3982,
		'name' => 'Ticket Issuing/Travel Clerk',
		'description' => 'Ticket Issuing/Travel Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	482 => 
	array (
		'id' => 3983,
		'name' => 'Ticket Usher Collector',
		'description' => 'Ticket Usher Collector',
		'created_at' => $now,
		'updated_at' => $now,
	),
	483 => 
	array (
		'id' => 3984,
		'name' => 'Tig Welder',
		'description' => 'Tig Welder',
		'created_at' => $now,
		'updated_at' => $now,
	),
	484 => 
	array (
		'id' => 3985,
		'name' => 'Tile/Composition Layer',
		'description' => 'Tile/Composition Layer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	485 => 
	array (
		'id' => 3986,
		'name' => 'Tile Setter',
		'description' => 'Tile Setter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	486 => 
	array (
		'id' => 3987,
		'name' => 'Timber Carrier Driver',
		'description' => 'Timber Carrier Driver',
		'created_at' => $now,
		'updated_at' => $now,
	),
	487 => 
	array (
		'id' => 3988,
		'name' => 'Timber Grader',
		'description' => 'Timber Grader',
		'created_at' => $now,
		'updated_at' => $now,
	),
	488 => 
	array (
		'id' => 3989,
		'name' => 'Time And Motion Engineer',
		'description' => 'Time And Motion Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	489 => 
	array (
		'id' => 3990,
		'name' => 'Time And Motion Study Engineering Assistant',
		'description' => 'Time And Motion Study Engineering Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	490 => 
	array (
		'id' => 3991,
		'name' => 'Times Clerk',
		'description' => 'Times Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	491 => 
	array (
		'id' => 3992,
		'name' => 'Tin Mine Worker',
		'description' => 'Tin Mine Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	492 => 
	array (
		'id' => 3993,
		'name' => 'Tin Ore Dresser',
		'description' => 'Tin Ore Dresser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	493 => 
	array (
		'id' => 3994,
		'name' => 'Tinsmith',
		'description' => 'Tinsmith',
		'created_at' => $now,
		'updated_at' => $now,
	),
	494 => 
	array (
		'id' => 3995,
		'name' => 'Tire Technologist',
		'description' => 'Tire Technologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	495 => 
	array (
		'id' => 3996,
		'name' => 'Tissue Technician',
		'description' => 'Tissue Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	496 => 
	array (
		'id' => 3997,
		'name' => 'Tobacco Curer',
		'description' => 'Tobacco Curer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	497 => 
	array (
		'id' => 3998,
		'name' => 'Tobacco Dryer',
		'description' => 'Tobacco Dryer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	498 => 
	array (
		'id' => 3999,
		'name' => 'Tobacco Farm Worker',
		'description' => 'Tobacco Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	499 => 
	array (
		'id' => 4000,
		'name' => 'Tobacco Grader',
		'description' => 'Tobacco Grader',
		'created_at' => $now,
		'updated_at' => $now,
	),
));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'id' => 4001,
				'name' => 'Tobacco Production Machine Operator',
				'description' => 'Tobacco Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 4002,
				'name' => 'Tobacco Stripper',
				'description' => 'Tobacco Stripper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 4003,
				'name' => 'Toddy/Nira Tapper',
				'description' => 'Toddy/Nira Tapper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 4004,
				'name' => 'Toiletry Products Machine Operator',
				'description' => 'Toiletry Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 4005,
				'name' => 'Toll Collection Clerk',
				'description' => 'Toll Collection Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 4006,
				'name' => 'Tool And Die Maker',
				'description' => 'Tool And Die Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 4007,
				'name' => 'Tooling Clerk',
				'description' => 'Tooling Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 4008,
				'name' => 'Tool Production Machine Operator',
				'description' => 'Tool Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 4009,
				'name' => 'Toolsmith',
				'description' => 'Toolsmith',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 4010,
				'name' => 'Topographical Draughtsperson',
				'description' => 'Topographical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 4011,
				'name' => 'Topographic Surveyor',
				'description' => 'Topographic Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 4012,
				'name' => 'Tourist Guide',
				'description' => 'Tourist Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 4013,
				'name' => 'Tourist Officer',
				'description' => 'Tourist Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 4014,
				'name' => 'Towing Driver',
				'description' => 'Towing Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 4015,
				'name' => 'Town Planner',
				'description' => 'Town Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 4016,
				'name' => 'Toxicologist',
				'description' => 'Toxicologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 4017,
				'name' => 'Toxicology Pharmacologist',
				'description' => 'Toxicology Pharmacologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 4018,
				'name' => 'Toy Production/Metal Machine Operator',
				'description' => 'Toy Production/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 4019,
				'name' => 'Toy/Wooden Maker',
				'description' => 'Toy/Wooden Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 4020,
				'name' => 'Tracer',
				'description' => 'Tracer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 4021,
				'name' => 'Tradesman K1 R17',
				'description' => 'Tradesman K1 R17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 4022,
				'name' => 'Tradesman K2 R11',
				'description' => 'Tradesman K2 R11',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 4023,
				'name' => 'Tradesman K3 R9',
				'description' => 'Tradesman K3 R9',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 4024,
				'name' => 'Trade Union Leader',
				'description' => 'Trade Union Leader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 4025,
				'name' => 'Trade Union Senior Official',
				'description' => 'Trade Union Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 4026,
				'name' => 'Traffic Clerk',
				'description' => 'Traffic Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 4027,
				'name' => 'Traffic Engineer',
				'description' => 'Traffic Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 4028,
				'name' => 'Traffic Man',
				'description' => 'Traffic Man',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 4029,
				'name' => 'Traffic Planner',
				'description' => 'Traffic Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 4030,
			'name' => 'Traffic Supervisor (Ships Cargo)',
			'description' => 'Traffic Supervisor (Ships Cargo)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 4031,
				'name' => 'Traffic Warden',
				'description' => 'Traffic Warden',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 4032,
				'name' => 'Traffic Woman',
				'description' => 'Traffic Woman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 4033,
				'name' => 'Train Conductor',
				'description' => 'Train Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 4034,
				'name' => 'Train/ERL Operator',
				'description' => 'Train/ERL Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 4035,
				'name' => 'Training E17 Junior Assistant Officer',
				'description' => 'Training E17 Junior Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 4036,
				'name' => 'Training E27 Ssistant Officer',
				'description' => 'Training E27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 4037,
				'name' => 'Training E41 Officer',
				'description' => 'Training E41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 4038,
				'name' => 'Train/LRT Operator',
				'description' => 'Train/LRT Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 4039,
				'name' => 'Train Steward',
				'description' => 'Train Steward',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 4040,
				'name' => 'Train Stewardess',
				'description' => 'Train Stewardess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 4041,
				'name' => 'Tram And Related Drivers Other Bus',
				'description' => 'Tram And Related Drivers Other Bus',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 4042,
				'name' => 'Tram Conductor',
				'description' => 'Tram Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 4043,
				'name' => 'Tram Driver',
				'description' => 'Tram Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 4044,
				'name' => 'Translator',
				'description' => 'Translator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 4045,
				'name' => 'Transmission/Electric Power Engineer',
				'description' => 'Transmission/Electric Power Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 4046,
				'name' => 'Transmitting Equipment/Radio And Television Operator',
				'description' => 'Transmitting Equipment/Radio And Television Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 4047,
				'name' => 'Transplant Surgeon',
				'description' => 'Transplant Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 4048,
				'name' => 'Transport Clerk',
				'description' => 'Transport Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 4049,
				'name' => 'Transport Manager',
				'description' => 'Transport Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 4050,
				'name' => 'Trapping Labourer',
				'description' => 'Trapping Labourer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 4051,
				'name' => 'Traumatology Surgeon',
				'description' => 'Traumatology Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 4052,
				'name' => 'Travel Agency Clerk',
				'description' => 'Travel Agency Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 4053,
				'name' => 'Travel Agency Manager',
				'description' => 'Travel Agency Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 4054,
				'name' => 'Travel/Air Lines Clerk',
				'description' => 'Travel/Air Lines Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 4055,
				'name' => 'Travel Clerk',
				'description' => 'Travel Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 4056,
				'name' => 'Travel Consultant',
				'description' => 'Travel Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 4057,
				'name' => 'Travel/Game Park Guide',
				'description' => 'Travel/Game Park Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 4058,
				'name' => 'Travel Guide',
				'description' => 'Travel Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 4059,
				'name' => 'Traveling Salesman/Salesgirl',
				'description' => 'Traveling Salesman/Salesgirl',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 4060,
				'name' => 'Traveling Salesperson',
				'description' => 'Traveling Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 4061,
				'name' => 'Travel Organizer',
				'description' => 'Travel Organizer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 4062,
				'name' => 'Travel/Sightseeing Guide',
				'description' => 'Travel/Sightseeing Guide',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 4063,
				'name' => 'Treasury Manager',
				'description' => 'Treasury Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 4064,
				'name' => 'Treater/Petroleum And Natural Gas Refining Operator',
				'description' => 'Treater/Petroleum And Natural Gas Refining Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 4065,
				'name' => 'Treater/Radioactive Waste Operator',
				'description' => 'Treater/Radioactive Waste Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 4066,
				'name' => 'Treating Equipment/Crude Oil Operator',
				'description' => 'Treating Equipment/Crude Oil Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 4067,
				'name' => 'Treating/Wood Machine Operator',
				'description' => 'Treating/Wood Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 4068,
				'name' => 'Tree And Shrub Crop Farm Worker',
				'description' => 'Tree And Shrub Crop Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 4069,
				'name' => 'Tree Cutter',
				'description' => 'Tree Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 4070,
				'name' => 'Trench Digging Machine Operator',
				'description' => 'Trench Digging Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 4071,
			'name' => 'Tribe Leader (Ketua Anak Negeri)',
			'description' => 'Tribe Leader (Ketua Anak Negeri)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 4072,
				'name' => 'Trishaw Pedaller',
				'description' => 'Trishaw Pedaller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 4073,
				'name' => 'Trolley Boy',
				'description' => 'Trolley Boy',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 4074,
				'name' => 'Trommel Attendant',
				'description' => 'Trommel Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 4075,
				'name' => 'Truck Driver',
				'description' => 'Truck Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 4076,
				'name' => 'Truck/Fork-Lift Operator',
				'description' => 'Truck/Fork-Lift Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 4077,
				'name' => 'Truck/Industrial Operator',
				'description' => 'Truck/Industrial Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 4078,
				'name' => 'Truck/Lifting Operator',
				'description' => 'Truck/Lifting Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 4079,
				'name' => 'Trust Officer',
				'description' => 'Trust Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 4080,
				'name' => 'Tuai Rumah',
				'description' => 'Tuai Rumah',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 4081,
				'name' => 'Tug Hand',
				'description' => 'Tug Hand',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 4082,
				'name' => 'Turbine Operator',
				'description' => 'Turbine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 4083,
				'name' => 'Turf/Golf Technical',
				'description' => 'Turf/Golf Technical',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 4084,
				'name' => 'Turkey Farmer',
				'description' => 'Turkey Farmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 4085,
				'name' => 'Turtle-Egg Collector',
				'description' => 'Turtle-Egg Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 4086,
				'name' => 'Twisting/Thread And Yarn Machine Operator',
				'description' => 'Twisting/Thread And Yarn Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 4087,
				'name' => 'Typesetter',
				'description' => 'Typesetter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 4088,
				'name' => 'Typing Secretary',
				'description' => 'Typing Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 4089,
				'name' => 'Typist',
				'description' => 'Typist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 4090,
				'name' => 'Typographical Designer',
				'description' => 'Typographical Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 4091,
				'name' => 'Tyre Production Machine Operator',
				'description' => 'Tyre Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 4092,
				'name' => 'Tyre Retreader',
				'description' => 'Tyre Retreader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 4093,
				'name' => 'UiTM DM41 Lecturer',
				'description' => 'UiTM DM41 Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 4094,
				'name' => 'Ultrasonographer',
				'description' => 'Ultrasonographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 4095,
				'name' => 'Umbrella Cutter',
				'description' => 'Umbrella Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 4096,
				'name' => 'Umbrella Maker',
				'description' => 'Umbrella Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 4097,
				'name' => 'Umbrella Pattern-Maker',
				'description' => 'Umbrella Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 4098,
				'name' => 'Umpire',
				'description' => 'Umpire',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 4099,
				'name' => 'Underground Cable Layer',
				'description' => 'Underground Cable Layer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 4100,
				'name' => 'Underground Timberman',
				'description' => 'Underground Timberman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 4101,
				'name' => 'Undertaker',
				'description' => 'Undertaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 4102,
				'name' => 'Underwater Logging',
				'description' => 'Underwater Logging',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 4103,
				'name' => 'Underwater Worker',
				'description' => 'Underwater Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 4104,
				'name' => 'University Chancellor',
				'description' => 'University Chancellor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 4105,
				'name' => 'University/College Professor',
				'description' => 'University/College Professor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 4106,
				'name' => 'University Dean Of Faculty',
				'description' => 'University Dean Of Faculty',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 4107,
				'name' => 'University DS45 Lecturer',
				'description' => 'University DS45 Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 4108,
				'name' => 'University Faculty Head',
				'description' => 'University Faculty Head',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 4109,
				'name' => 'University Leader',
				'description' => 'University Leader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 4110,
				'name' => 'University Lecturer',
				'description' => 'University Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 4111,
				'name' => 'University Principal',
				'description' => 'University Principal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 4112,
				'name' => 'University Tutor',
				'description' => 'University Tutor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 4113,
				'name' => 'University Vice Chancellor',
				'description' => 'University Vice Chancellor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 4114,
				'name' => 'Unneling Machinery/Construction Operator',
				'description' => 'Unneling Machinery/Construction Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 4115,
				'name' => 'Urban And Rural Planner',
				'description' => 'Urban And Rural Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 4116,
				'name' => 'Urban And Rural Planning J17 Technician',
				'description' => 'Urban And Rural Planning J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 4117,
				'name' => 'Urban And Rural Planning J29 Ssistant Officer',
				'description' => 'Urban And Rural Planning J29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 4118,
				'name' => 'Urban And Rural Planning J41 Officer',
				'description' => 'Urban And Rural Planning J41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 4119,
				'name' => 'Urologist',
				'description' => 'Urologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 4120,
				'name' => 'Urology Surgeon',
				'description' => 'Urology Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 4121,
				'name' => 'Ustaz/Ustazah',
				'description' => 'Ustaz/Ustazah',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 4122,
				'name' => 'Vacuum Pan/Chemical And Related Processes (Except Petroleum And Operator',
			'description' => 'Vacuum Pan/Chemical And Related Processes (Except Petroleum And Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 4123,
				'name' => 'Vacuum Pan/Condensed Milk Operator',
				'description' => 'Vacuum Pan/Condensed Milk Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 4124,
				'name' => 'Vacuum Plastic-Forming Machine Operator',
				'description' => 'Vacuum Plastic-Forming Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 4125,
				'name' => 'Valet',
				'description' => 'Valet',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 4126,
				'name' => 'Valuer',
				'description' => 'Valuer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 4127,
				'name' => 'Valuers And Auctioneers Other Appraisers',
				'description' => 'Valuers And Auctioneers Other Appraisers',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 4128,
				'name' => 'Van Driver',
				'description' => 'Van Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 4129,
				'name' => 'Vascular Surgeon',
				'description' => 'Vascular Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 4130,
				'name' => 'Vegetable Farm Worker',
				'description' => 'Vegetable Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 4131,
				'name' => 'Vegetable Juice Maker',
				'description' => 'Vegetable Juice Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 4132,
				'name' => 'Vegetable Juice Production Machine Operator',
				'description' => 'Vegetable Juice Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 4133,
				'name' => 'Vegetable Preserver',
				'description' => 'Vegetable Preserver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 4134,
				'name' => 'Vegetable Processing Machine Operator',
				'description' => 'Vegetable Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 4135,
				'name' => 'Vehicle Electrician',
				'description' => 'Vehicle Electrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 4136,
				'name' => 'Vehicle Foreman',
				'description' => 'Vehicle Foreman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 4137,
				'name' => 'Vehicle Glazier',
				'description' => 'Vehicle Glazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 4138,
				'name' => 'Vehicle Panel Beater',
				'description' => 'Vehicle Panel Beater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 4139,
				'name' => 'Vehicles Cleaner',
				'description' => 'Vehicles Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 4140,
				'name' => 'Vehicle Sheet Metal Worker',
				'description' => 'Vehicle Sheet Metal Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 4141,
				'name' => 'Vehicle Upholsterer',
				'description' => 'Vehicle Upholsterer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 4142,
				'name' => 'Vending Machine/Money Collector',
				'description' => 'Vending Machine/Money Collector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 4143,
				'name' => 'Veneer Applier',
				'description' => 'Veneer Applier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 4144,
				'name' => 'Veneer Cutter',
				'description' => 'Veneer Cutter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 4145,
				'name' => 'Veneer Dryer Operator',
				'description' => 'Veneer Dryer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 4146,
				'name' => 'Veneer Grader',
				'description' => 'Veneer Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 4147,
				'name' => 'Veneer Lathe Feeder',
				'description' => 'Veneer Lathe Feeder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 4148,
				'name' => 'Veneer Setter',
				'description' => 'Veneer Setter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 4149,
				'name' => 'Venereologist',
				'description' => 'Venereologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 4150,
				'name' => 'Ventriloquist',
				'description' => 'Ventriloquist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 4151,
				'name' => 'Verbatim/Hansard Reporter',
				'description' => 'Verbatim/Hansard Reporter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 4152,
				'name' => 'Verbatim Reporter',
				'description' => 'Verbatim Reporter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 4153,
				'name' => 'Versifier',
				'description' => 'Versifier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 4154,
				'name' => 'Veterinarian',
				'description' => 'Veterinarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 4155,
				'name' => 'Veterinary Aid',
				'description' => 'Veterinary Aid',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 4156,
				'name' => 'Veterinary/Artificial Insemination Assistant',
				'description' => 'Veterinary/Artificial Insemination Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 4157,
				'name' => 'Veterinary Assistant',
				'description' => 'Veterinary Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 4158,
				'name' => 'Veterinary Attendant',
				'description' => 'Veterinary Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 4159,
				'name' => 'Veterinary Bacteriologist',
				'description' => 'Veterinary Bacteriologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 4160,
				'name' => 'Veterinary G17 Assistant',
				'description' => 'Veterinary G17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 4161,
				'name' => 'Veterinary G27 Ssistant Officer',
				'description' => 'Veterinary G27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 4162,
				'name' => 'Veterinary G41 Officer',
				'description' => 'Veterinary G41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 4163,
				'name' => 'Veterinary Pathologist',
				'description' => 'Veterinary Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 4164,
				'name' => 'Veterinary Pharmacologist',
				'description' => 'Veterinary Pharmacologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 4165,
				'name' => 'Veterinary Surgeon',
				'description' => 'Veterinary Surgeon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 4166,
				'name' => 'Veterinary Vaccinator',
				'description' => 'Veterinary Vaccinator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 4167,
				'name' => 'Vice Admiral',
				'description' => 'Vice Admiral',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 4168,
				'name' => 'Video And Radar Equipment Fitter, Electronics/Radio, Television',
				'description' => 'Video And Radar Equipment Fitter, Electronics/Radio, Television',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 4169,
				'name' => 'Video Tape-Recorder Operator',
				'description' => 'Video Tape-Recorder Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 4170,
				'name' => 'Village Chief',
				'description' => 'Village Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 4171,
				'name' => 'Village Healer',
				'description' => 'Village Healer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 4172,
				'name' => 'Vinegar Making Machine Operator',
				'description' => 'Vinegar Making Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 4173,
				'name' => 'Virologist',
				'description' => 'Virologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 4174,
				'name' => 'Visual Merchandiser',
				'description' => 'Visual Merchandiser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 4175,
				'name' => 'Visual Teaching Aids Specialist',
				'description' => 'Visual Teaching Aids Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 4176,
				'name' => 'Vocal Group Conductor',
				'description' => 'Vocal Group Conductor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 4177,
				'name' => 'Vocational Guidance Counselor',
				'description' => 'Vocational Guidance Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 4178,
				'name' => 'Vocational Student Counselor',
				'description' => 'Vocational Student Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 4179,
				'name' => 'Vocational Teacher',
				'description' => 'Vocational Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 4180,
				'name' => 'Vocational Training J17 Assistant',
				'description' => 'Vocational Training J17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 4181,
				'name' => 'Vocational Training J29 Ssistant Officer',
				'description' => 'Vocational Training J29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 4182,
				'name' => 'Vocational Training J41 Officer',
				'description' => 'Vocational Training J41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 4183,
				'name' => 'Wafer-Baking Machine Operator',
				'description' => 'Wafer-Baking Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 4184,
				'name' => 'Wage Inspector',
				'description' => 'Wage Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 4185,
				'name' => 'Wages Clerk',
				'description' => 'Wages Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 4186,
				'name' => 'Waiter',
				'description' => 'Waiter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 4187,
				'name' => 'Waitress',
				'description' => 'Waitress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 4188,
				'name' => 'Wall/Ceiling Paperhanger',
				'description' => 'Wall/Ceiling Paperhanger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 4189,
				'name' => 'Wallpaper Printer',
				'description' => 'Wallpaper Printer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 4190,
				'name' => 'Wardrobe Assistant',
				'description' => 'Wardrobe Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 4191,
				'name' => 'Wardrobe N17 Supervisor',
				'description' => 'Wardrobe N17 Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 4192,
				'name' => 'Warehouse Assistant',
				'description' => 'Warehouse Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 4193,
				'name' => 'Warehouse Clerk',
				'description' => 'Warehouse Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 4194,
				'name' => 'Warehouse Executive',
				'description' => 'Warehouse Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 4195,
				'name' => 'Warehouse Manager',
				'description' => 'Warehouse Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 4196,
				'name' => 'Warehouse Operator',
				'description' => 'Warehouse Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 4197,
				'name' => 'Warehouse Porter',
				'description' => 'Warehouse Porter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 4198,
				'name' => 'Warehouse Technician',
				'description' => 'Warehouse Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 4199,
				'name' => 'Warehouse Worker',
				'description' => 'Warehouse Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 4200,
			'name' => 'Warping/Beam (Textile Weaving) Machine Operator',
			'description' => 'Warping/Beam (Textile Weaving) Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 4201,
				'name' => 'Warrant Officer I',
				'description' => 'Warrant Officer I',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 4202,
				'name' => 'Warrant Officer II',
				'description' => 'Warrant Officer II',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 4203,
				'name' => 'Warrant Officers Class 1',
				'description' => 'Warrant Officers Class 1',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 4204,
				'name' => 'Warrant Officers Class 2',
				'description' => 'Warrant Officers Class 2',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 4205,
				'name' => 'Washing And Shrinking/Textiles Machine Operator',
				'description' => 'Washing And Shrinking/Textiles Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 4206,
				'name' => 'Washing/Chemical And Related Material Machine Operator',
				'description' => 'Washing/Chemical And Related Material Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 4207,
				'name' => 'Washing Operator',
				'description' => 'Washing Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 4208,
				'name' => 'Watch And Clock Maker And Repairer',
				'description' => 'Watch And Clock Maker And Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 4209,
				'name' => 'Watch Assembler',
				'description' => 'Watch Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 4210,
				'name' => 'Watchman',
				'description' => 'Watchman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 4211,
				'name' => 'Watchman R1',
				'description' => 'Watchman R1',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 4212,
				'name' => 'Watch Production Machine Operator',
				'description' => 'Watch Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 4213,
				'name' => 'Water And Sanitary Manager, Electricity',
				'description' => 'Water And Sanitary Manager, Electricity',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 4214,
				'name' => 'Water J17 Inspector',
				'description' => 'Water J17 Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 4215,
				'name' => 'Water Purification Chemist',
				'description' => 'Water Purification Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 4216,
				'name' => 'Water Supply J17 Superintendent',
				'description' => 'Water Supply J17 Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 4217,
				'name' => 'Water Treatment And Related Plant Operators Not Elsewhere Classified Incinerator',
				'description' => 'Water Treatment And Related Plant Operators Not Elsewhere Classified Incinerator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 4218,
				'name' => 'Water Treatment Plant Operator',
				'description' => 'Water Treatment Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 4219,
				'name' => 'Water Treatment Plant R3 Operator',
				'description' => 'Water Treatment Plant R3 Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 4220,
				'name' => 'Weaving/Carpet Machine Operator',
				'description' => 'Weaving/Carpet Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 4221,
				'name' => 'Weaving Instructor',
				'description' => 'Weaving Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 4222,
				'name' => 'Weaving Machine Operator',
				'description' => 'Weaving Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 4223,
				'name' => 'Web Designer',
				'description' => 'Web Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 4224,
				'name' => 'Webmaster',
				'description' => 'Webmaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 4225,
				'name' => 'Website Administrator',
				'description' => 'Website Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 4226,
				'name' => 'Website Architect',
				'description' => 'Website Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 4227,
				'name' => 'Web Site/Internet/Intranet Developer',
				'description' => 'Web Site/Internet/Intranet Developer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 4228,
				'name' => 'Website Technician',
				'description' => 'Website Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 4229,
				'name' => 'Weeder Worker',
				'description' => 'Weeder Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 4230,
				'name' => 'Weighbridge Clerk',
				'description' => 'Weighbridge Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 4231,
				'name' => 'Weighbridge-Security Controller',
				'description' => 'Weighbridge-Security Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 4232,
				'name' => 'Weighing Clerk',
				'description' => 'Weighing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 4233,
				'name' => 'Weight And Measures Inspector',
				'description' => 'Weight And Measures Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 4234,
				'name' => 'Welder',
				'description' => 'Welder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 4235,
				'name' => 'Welder Foreman',
				'description' => 'Welder Foreman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 4236,
				'name' => 'Welding/Metal Machine Operator',
				'description' => 'Welding/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 4237,
				'name' => 'Welding Technologist',
				'description' => 'Welding Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 4238,
				'name' => 'Well Acidising Treater',
				'description' => 'Well Acidising Treater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 4239,
				'name' => 'Well Digger',
				'description' => 'Well Digger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'id' => 4240,
				'name' => 'Wet Timber Sawing Operator',
				'description' => 'Wet Timber Sawing Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'id' => 4241,
				'name' => 'Wharfinger',
				'description' => 'Wharfinger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'id' => 4242,
				'name' => 'Whitewasher',
				'description' => 'Whitewasher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'id' => 4243,
				'name' => 'Wholesale And Retail Salesperson',
				'description' => 'Wholesale And Retail Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'id' => 4244,
				'name' => 'Wholesaler',
				'description' => 'Wholesaler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'id' => 4245,
				'name' => 'Wholesale Trade/Export Manager',
				'description' => 'Wholesale Trade/Export Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'id' => 4246,
				'name' => 'Wholesale Trade/Import Manager',
				'description' => 'Wholesale Trade/Import Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'id' => 4247,
				'name' => 'Wholesale Trade Manager',
				'description' => 'Wholesale Trade Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'id' => 4248,
				'name' => 'Wholesale Trade Merchant',
				'description' => 'Wholesale Trade Merchant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'id' => 4249,
				'name' => 'Wig Maker',
				'description' => 'Wig Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'id' => 4250,
				'name' => 'Wildlife G11 Junior Assistant',
				'description' => 'Wildlife G11 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'id' => 4251,
				'name' => 'Wildlife G17 Assistant',
				'description' => 'Wildlife G17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'id' => 4252,
				'name' => 'Wild Life G27 Ssistant Officer',
				'description' => 'Wild Life G27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'id' => 4253,
				'name' => 'Wild Life G41 Officer',
				'description' => 'Wild Life G41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'id' => 4254,
				'name' => 'Wild Life Protection Organization Secretary-General',
				'description' => 'Wild Life Protection Organization Secretary-General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'id' => 4255,
				'name' => 'Wild Life Warden',
				'description' => 'Wild Life Warden',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'id' => 4256,
				'name' => 'Winch Operator',
				'description' => 'Winch Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'id' => 4257,
			'name' => 'Winch-Truck (Logging) Driver',
			'description' => 'Winch-Truck (Logging) Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'id' => 4258,
				'name' => 'Window Cleaner',
				'description' => 'Window Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'id' => 4259,
				'name' => 'Wine Grader/Taster',
				'description' => 'Wine Grader/Taster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 => 
			array (
				'id' => 4260,
				'name' => 'Wire Cutting Technician',
				'description' => 'Wire Cutting Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 => 
			array (
				'id' => 4261,
				'name' => 'Wire Drawer',
				'description' => 'Wire Drawer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 => 
			array (
				'id' => 4262,
				'name' => 'Wire Goods Production Machine Operator',
				'description' => 'Wire Goods Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 => 
			array (
				'id' => 4263,
				'name' => 'Wireless Operator',
				'description' => 'Wireless Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 => 
			array (
				'id' => 4264,
				'name' => 'Wireman',
				'description' => 'Wireman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 => 
			array (
				'id' => 4265,
				'name' => 'Wiring/Electric Machine Operator',
				'description' => 'Wiring/Electric Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 => 
			array (
				'id' => 4266,
				'name' => 'Women Welfare Organizer',
				'description' => 'Women Welfare Organizer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 => 
			array (
				'id' => 4267,
				'name' => 'Wood Analyst',
				'description' => 'Wood Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 => 
			array (
				'id' => 4268,
				'name' => 'Wood Anatomist',
				'description' => 'Wood Anatomist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 => 
			array (
				'id' => 4269,
				'name' => 'Wood Boatbuilder',
				'description' => 'Wood Boatbuilder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 => 
			array (
				'id' => 4270,
				'name' => 'Wood Carver',
				'description' => 'Wood Carver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 => 
			array (
				'id' => 4271,
				'name' => 'Wooden Articles Handicraft Worker',
				'description' => 'Wooden Articles Handicraft Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 => 
			array (
				'id' => 4272,
				'name' => 'Wood Grader',
				'description' => 'Wood Grader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 => 
			array (
				'id' => 4273,
			'name' => 'Wood (Hand) Turner',
			'description' => 'Wood (Hand) Turner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 => 
			array (
				'id' => 4274,
				'name' => 'Wood Impregnator',
				'description' => 'Wood Impregnator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 => 
			array (
				'id' => 4275,
				'name' => 'Wood Lacquerer',
				'description' => 'Wood Lacquerer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 => 
			array (
				'id' => 4276,
			'name' => 'Wood (Machine) Turner',
			'description' => 'Wood (Machine) Turner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 => 
			array (
				'id' => 4277,
				'name' => 'Wood Machinist',
				'description' => 'Wood Machinist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 => 
			array (
				'id' => 4278,
				'name' => 'Wood Patterns Pattern-Maker',
				'description' => 'Wood Patterns Pattern-Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 => 
			array (
				'id' => 4279,
				'name' => 'Wood Polisher',
				'description' => 'Wood Polisher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 => 
			array (
				'id' => 4280,
				'name' => 'Wood Products Assembler',
				'description' => 'Wood Products Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 => 
			array (
				'id' => 4281,
				'name' => 'Wood Products Machine Operator',
				'description' => 'Wood Products Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 => 
			array (
				'id' => 4282,
				'name' => 'Wood Sawyer',
				'description' => 'Wood Sawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 => 
			array (
				'id' => 4283,
				'name' => 'Wood Seasoner',
				'description' => 'Wood Seasoner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 => 
			array (
				'id' => 4284,
				'name' => 'Wood-Shingle Roofer',
				'description' => 'Wood-Shingle Roofer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 => 
			array (
				'id' => 4285,
				'name' => 'Wood Shipwright',
				'description' => 'Wood Shipwright',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 => 
			array (
				'id' => 4286,
				'name' => 'Wood Technologist',
				'description' => 'Wood Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 => 
			array (
				'id' => 4287,
				'name' => 'Wood Treater',
				'description' => 'Wood Treater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 => 
			array (
				'id' => 4288,
				'name' => 'Wood-Wind Musical Instrument Maker',
				'description' => 'Wood-Wind Musical Instrument Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 => 
			array (
				'id' => 4289,
				'name' => 'Wood-Wool Machine Operator',
				'description' => 'Wood-Wool Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 => 
			array (
				'id' => 4290,
				'name' => 'Woodworking Lathe-Operator',
				'description' => 'Woodworking Lathe-Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 => 
			array (
				'id' => 4291,
				'name' => 'Wood Working Machinery Assembler',
				'description' => 'Wood Working Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 => 
			array (
				'id' => 4292,
				'name' => 'Woodworking Marker',
				'description' => 'Woodworking Marker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 => 
			array (
				'id' => 4293,
				'name' => 'Wool Carder',
				'description' => 'Wool Carder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 => 
			array (
				'id' => 4294,
				'name' => 'Word Processing Clerk',
				'description' => 'Word Processing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 => 
			array (
				'id' => 4295,
				'name' => 'Word Processing Secretary',
				'description' => 'Word Processing Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 => 
			array (
				'id' => 4296,
				'name' => 'Workers’ Organization Senior Official',
				'description' => 'Workers’ Organization Senior Official',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 => 
			array (
				'id' => 4297,
				'name' => 'Workshop Structural Steel Worker',
				'description' => 'Workshop Structural Steel Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 => 
			array (
				'id' => 4298,
				'name' => 'Workshop Supervisor',
				'description' => 'Workshop Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 => 
			array (
				'id' => 4299,
				'name' => 'Work Study Engineer',
				'description' => 'Work Study Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'id' => 4300,
				'name' => 'Wrapping Machine Operator',
				'description' => 'Wrapping Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'id' => 4301,
				'name' => 'X-Ray U29 Technician',
				'description' => 'X-Ray U29 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'id' => 4302,
				'name' => 'Yacht Skipper',
				'description' => 'Yacht Skipper',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'id' => 4303,
				'name' => 'Yarder Operator',
				'description' => 'Yarder Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'id' => 4304,
				'name' => 'Yardman',
				'description' => 'Yardman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'id' => 4305,
				'name' => 'Yardmaster Railway',
				'description' => 'Yardmaster Railway',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'id' => 4306,
				'name' => 'Yeast Maker',
				'description' => 'Yeast Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'id' => 4307,
				'name' => 'Yeast Making Machine Operator',
				'description' => 'Yeast Making Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'id' => 4308,
				'name' => 'Youth And Sport S17 Assistant',
				'description' => 'Youth And Sport S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'id' => 4309,
				'name' => 'Youth & Sport S27 Ssistant Officer',
				'description' => 'Youth & Sport S27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'id' => 4310,
				'name' => 'Youth & Sport S41 Officer',
				'description' => 'Youth & Sport S41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'id' => 4311,
				'name' => 'Zip Production Machine Operator',
				'description' => 'Zip Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'id' => 4312,
				'name' => 'Zoological Technician',
				'description' => 'Zoological Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'id' => 4313,
				'name' => 'Zoologist',
				'description' => 'Zoologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'id' => 4314,
				'name' => 'Zoologist And Related Professionals Other Biologist, Botanist',
				'description' => 'Zoologist And Related Professionals Other Biologist, Botanist',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}

}
