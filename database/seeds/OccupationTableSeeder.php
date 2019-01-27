<?php

use Illuminate\Database\Seeder;

class OccupationTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('occupation')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('occupation')->insert(array (
			7 => 
			array (
				'name' => 'Account And Promotion Clerk',
				'description' => 'Account And Promotion Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'name' => 'Accountant',
				'description' => 'Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'name' => 'Accountant W17 Junior Assistant',
				'description' => 'Accountant W17 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'name' => 'Accountant W27 Assistant',
				'description' => 'Accountant W27 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'name' => 'Accountant W41',
				'description' => 'Accountant W41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'name' => 'Account Assistant Officer',
				'description' => 'Account Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'name' => 'Account Clerk',
				'description' => 'Account Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'name' => 'Accounting Machine Clerk',
				'description' => 'Accounting Machine Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'name' => 'Accounting Payable Clerk',
				'description' => 'Accounting Payable Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'name' => 'Accounting Receivable Clerk',
				'description' => 'Accounting Receivable Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'name' => 'Account Manager',
				'description' => 'Account Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'name' => 'Account Officer/Executive',
				'description' => 'Account Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'name' => 'Account Supervisor',
				'description' => 'Account Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'name' => 'Acetylene Plant Operator',
				'description' => 'Acetylene Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'name' => 'Acid Plant Operator',
				'description' => 'Acid Plant Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'name' => 'Acoustical Insulator',
				'description' => 'Acoustical Insulator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'name' => 'Acoustics Physicist',
				'description' => 'Acoustics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'name' => 'Acrobat',
				'description' => 'Acrobat',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'name' => 'Acting Sub Lieutenant',
				'description' => 'Acting Sub Lieutenant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'name' => 'Actor',
				'description' => 'Actor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'name' => 'Actuarial Assistant',
				'description' => 'Actuarial Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'name' => 'Actuarial Clerk',
				'description' => 'Actuarial Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'name' => 'Actuarial Science Mathematician',
				'description' => 'Actuarial Science Mathematician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'name' => 'Actuary W41 Officer',
				'description' => 'Actuary W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'name' => 'Acupuncturist',
				'description' => 'Acupuncturist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'name' => 'Addressing Machine Clerk',
				'description' => 'Addressing Machine Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'name' => 'Adjustment Clerk',
				'description' => 'Adjustment Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'name' => 'Administrative And Accounting Clerk',
				'description' => 'Administrative And Accounting Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'name' => 'Administrative And Diplomatic M41 Officer',
				'description' => 'Administrative And Diplomatic M41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'name' => 'Administrative Clerical/Operation N17 Assistant',
				'description' => 'Administrative Clerical/Operation N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'name' => 'Administrative Clerk',
				'description' => 'Administrative Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'name' => 'Administrative Executive',
				'description' => 'Administrative Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'name' => 'Administrative FinanceW17 Assistant',
				'description' => 'Administrative FinanceW17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'name' => 'Administrative Manager',
				'description' => 'Administrative Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'name' => 'Administrative N27 Assistant Officer',
				'description' => 'Administrative N27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'name' => 'Administrative N41 Officer',
				'description' => 'Administrative N41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
			'name' => 'Administrative (Secretarial) Assistant',
			'description' => 'Administrative (Secretarial) Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'name' => 'Administrative Secretary',
				'description' => 'Administrative Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'name' => 'Administrative Secretary N17 Assistant',
				'description' => 'Administrative Secretary N17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'name' => 'Administrative Supervisor',
				'description' => 'Administrative Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'name' => 'Administrator Assistant',
				'description' => 'Administrator Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'name' => 'Admiral',
				'description' => 'Admiral',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'name' => 'Admiral Of The Fleet',
				'description' => 'Admiral Of The Fleet',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'name' => 'Admission Secretary',
				'description' => 'Admission Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'name' => 'Adult Education Teacher',
				'description' => 'Adult Education Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'name' => 'Advertising Clerk',
				'description' => 'Advertising Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'name' => 'Advertising Copywriter',
				'description' => 'Advertising Copywriter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'name' => 'Advertising Executive Account',
				'description' => 'Advertising Executive Account',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'name' => 'Advertising Illustrator',
				'description' => 'Advertising Illustrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'name' => 'Advertising Manager',
				'description' => 'Advertising Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'name' => 'Advertising Model',
				'description' => 'Advertising Model',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'name' => 'Advocate',
				'description' => 'Advocate',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'name' => 'Advocate L41',
				'description' => 'Advocate L41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'name' => 'Aerialist/Trapeze Performer',
				'description' => 'Aerialist/Trapeze Performer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'name' => 'Aerial Photographer',
				'description' => 'Aerial Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'name' => 'Aerial Surveyor',
				'description' => 'Aerial Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'name' => 'Aerodynamicist',
				'description' => 'Aerodynamicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
			'name' => 'Aeronautical)',
			'description' => 'Aeronautical)',
			'created_at' => $now,
			'updated_at' => $now,
			),
			67 => 
			array (
				'name' => 'Aeronautical Engineer',
				'description' => 'Aeronautical Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
			'name' => 'Aeronautical (Mechanical) And Equipment Engineering Assistant',
			'description' => 'Aeronautical (Mechanical) And Equipment Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
			'name' => 'Aerospace (Telecommunications) Engineer',
			'description' => 'Aerospace (Telecommunications) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'name' => 'Aesthetician',
				'description' => 'Aesthetician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'name' => 'After Sales Service Adviser',
				'description' => 'After Sales Service Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),

			array (
				'name' => 'Anaesthetist',
				'description' => 'Anaesthetist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'name' => 'Analyst Programmer',
				'description' => 'Analyst Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'name' => 'Analytical Chemist',
				'description' => 'Analytical Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'name' => 'Anatomist',
				'description' => 'Anatomist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'name' => 'Anatomy Technician',
				'description' => 'Anatomy Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'name' => 'Animation/Computer Games/Multimedia Programmer',
				'description' => 'Animation/Computer Games/Multimedia Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'name' => 'Animator',
				'description' => 'Animator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'name' => 'Applications Programmer',
				'description' => 'Applications Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'name' => 'Applied Mathematics Mathematician',
				'description' => 'Applied Mathematics Mathematician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'name' => 'Applied Statistics Statistician',
				'description' => 'Applied Statistics Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'name' => 'Appointments Clerk',
				'description' => 'Appointments Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'name' => 'Appraiser',
				'description' => 'Appraiser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'name' => 'Appraiser W17 Assistant',
				'description' => 'Appraiser W17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'name' => 'Appraiser W27 Assistant Officer',
				'description' => 'Appraiser W27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'name' => 'Appraiser W41 Officer',
				'description' => 'Appraiser W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'name' => 'Architect J41',
				'description' => 'Architect J41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'name' => 'Architectural Draughtsperson',
				'description' => 'Architectural Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'name' => 'Architecture J17 Technician',
				'description' => 'Architecture J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'name' => 'Architecture J29 Technical Assistant',
				'description' => 'Architecture J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'name' => 'Archives S17 Assistant',
				'description' => 'Archives S17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'name' => 'Archives S27 Assistant Officer',
				'description' => 'Archives S27 Assistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),

			200 => 
			array (
				'name' => 'Athlete',
				'description' => 'Athlete',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'name' => 'Attorney General',
				'description' => 'Attorney General',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'name' => 'Auction Clerk',
				'description' => 'Auction Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'name' => 'Auctioneer',
				'description' => 'Auctioneer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'name' => 'Audio And Video Equipment Engineer',
				'description' => 'Audio And Video Equipment Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'name' => 'Audio And Video Equipment Technician',
				'description' => 'Audio And Video Equipment Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'name' => 'Audiologists',
				'description' => 'Audiologists',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'name' => 'Audio Typist',
				'description' => 'Audio Typist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'name' => 'Audio-Visual Aids Operator',
				'description' => 'Audio-Visual Aids Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'name' => 'Audio-Visual And Other Teaching Aids Specialist',
				'description' => 'Audio-Visual And Other Teaching Aids Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'name' => 'Audio-Visual Equipment Assembler',
				'description' => 'Audio-Visual Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'name' => 'Audio-Visual Librarian',
				'description' => 'Audio-Visual Librarian',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'name' => 'Audio-Visual N17 Technician',
				'description' => 'Audio-Visual N17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'name' => 'Audio/Visual Operator',
				'description' => 'Audio/Visual Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'name' => 'Audio-Visual Teaching Specialist',
				'description' => 'Audio-Visual Teaching Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'name' => 'Audit And Risk Assessment Executive',
				'description' => 'Audit And Risk Assessment Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'name' => 'Audit And Risk Assessment Manager',
				'description' => 'Audit And Risk Assessment Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'name' => 'Audit Clerk',
				'description' => 'Audit Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'name' => 'Audit Executive',
				'description' => 'Audit Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'name' => 'Auditing Accountant',
				'description' => 'Auditing Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'name' => 'Audit Manager',
				'description' => 'Audit Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'name' => 'Auditor',
				'description' => 'Auditor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'name' => 'Auditor Computer',
				'description' => 'Auditor Computer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'name' => 'Auditor W17 Junior Assistant',
				'description' => 'Auditor W17 Junior Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'name' => 'Auditor W27 Assistant',
				'description' => 'Auditor W27 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'name' => 'Auditor W41',
				'description' => 'Auditor W41',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'name' => 'Author',
				'description' => 'Author',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'name' => 'Auto-Clipper Operator',
				'description' => 'Auto-Clipper Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'name' => 'Automation Engineer',
				'description' => 'Automation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'name' => 'Automation/Robot Technician',
				'description' => 'Automation/Robot Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'name' => 'Automobile Assembler',
				'description' => 'Automobile Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),

			253 => 
			array (
				'name' => 'Bank Accounting Analyst',
				'description' => 'Bank Accounting Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 => 
			array (
				'name' => 'Bank Assistant',
				'description' => 'Bank Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 => 
			array (
				'name' => 'Bank Clerk',
				'description' => 'Bank Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 => 
			array (
				'name' => 'Banking Clerk, Clearing House',
				'description' => 'Banking Clerk, Clearing House',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 => 
			array (
				'name' => 'Bankruptcy Officer',
				'description' => 'Bankruptcy Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 => 
			array (
				'name' => 'Bank Teller',
				'description' => 'Bank Teller',
				'created_at' => $now,
				'updated_at' => $now,
			),

			389 => 
			array (
				'name' => 'Builder',
				'description' => 'Builder',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'name' => 'Building Architect',
				'description' => 'Building Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'name' => 'Building Assistant Surveyor',
				'description' => 'Building Assistant Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'name' => 'Building Caretaker',
				'description' => 'Building Caretaker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'name' => 'Building Concierge',
				'description' => 'Building Concierge',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'name' => 'Building Electrician',
				'description' => 'Building Electrician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'name' => 'Building Exteriors Cleaner',
				'description' => 'Building Exteriors Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'name' => 'Building Exteriors Sandblaster',
				'description' => 'Building Exteriors Sandblaster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'name' => 'Building Glazier',
				'description' => 'Building Glazier',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'name' => 'Building Inspector',
				'description' => 'Building Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'name' => 'Building Insulator',
				'description' => 'Building Insulator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'name' => 'Building J29 Technical Assistant Surveyor',
				'description' => 'Building J29 Technical Assistant Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'name' => 'Building J41 Surveyor',
				'description' => 'Building J41 Surveyor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'name' => 'Building Maintenance Worker',
				'description' => 'Building Maintenance Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'name' => 'Building Materials Technologist',
				'description' => 'Building Materials Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),

			412 => 
			array (
				'name' => 'Business And Economics Statistician',
				'description' => 'Business And Economics Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 => 
			array (
				'name' => 'Business Consultant',
				'description' => 'Business Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 => 
			array (
				'name' => 'Business Development Executive',
				'description' => 'Business Development Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 => 
			array (
				'name' => 'Business Efficiency Specialist',
				'description' => 'Business Efficiency Specialist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 => 
			array (
			'name' => 'Business (Information Technology) Analyst',
			'description' => 'Business (Information Technology) Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 => 
			array (
				'name' => 'Business Services/Advertising Salesperson',
				'description' => 'Business Services/Advertising Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 => 
			array (
				'name' => 'Business Services And Administration Managers Not Elsewhere Classified',
				'description' => 'Business Services And Administration Managers Not Elsewhere Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 => 
			array (
				'name' => 'Business Services/Development Manager',
				'description' => 'Business Services/Development Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 => 
			array (
			'name' => 'Business Services (Except Advertising) Representative',
			'description' => 'Business Services (Except Advertising) Representative',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 => 
			array (
				'name' => 'Business Services Information Scientist',
				'description' => 'Business Services Information Scientist',
				'created_at' => $now,
				'updated_at' => $now,
			),

			54 => 
			array (
				'name' => 'Chief Executive Officer',
				'description' => 'Chief Executive Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'name' => 'Chief Finance Officer',
				'description' => 'Chief Finance Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'name' => 'Chief Hookman Supervisor',
				'description' => 'Chief Hookman Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'name' => 'Chief Hostess',
				'description' => 'Chief Hostess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'name' => 'Chief Minister',
				'description' => 'Chief Minister',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'name' => 'Chief Operating Officer',
				'description' => 'Chief Operating Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'name' => 'Chief Petty Officer',
				'description' => 'Chief Petty Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'name' => 'Chief Secretary',
				'description' => 'Chief Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),

			89 => 
			array (
				'name' => 'Civil/Aerodome Construction Engineer',
				'description' => 'Civil/Aerodome Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'name' => 'Civil/Bridge Construction Engineer',
				'description' => 'Civil/Bridge Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'name' => 'Civil/Building Construction Engineer',
				'description' => 'Civil/Building Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'name' => 'Civil/Building Structure Engineer',
				'description' => 'Civil/Building Structure Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'name' => 'Civil/Chimney Construction Engineer',
				'description' => 'Civil/Chimney Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'name' => 'Civil/Construction Engineer',
				'description' => 'Civil/Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'name' => 'Civil Defence KP17 Assistant',
				'description' => 'Civil Defence KP17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'name' => 'Civil Defence KP27 Ssistant Officer',
				'description' => 'Civil Defence KP27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'name' => 'Civil Defence KP41 Officer',
				'description' => 'Civil Defence KP41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'name' => 'Civil Defence Officer',
				'description' => 'Civil Defence Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'name' => 'Civil/Dock And Harbour Construction Engineer',
				'description' => 'Civil/Dock And Harbour Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'name' => 'Civil/Dredging Engineer',
				'description' => 'Civil/Dredging Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'name' => 'Civil Engineer',
				'description' => 'Civil Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'name' => 'Civil Engineering Assistant',
				'description' => 'Civil Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'name' => 'Civil/Geothechnic Engineer',
				'description' => 'Civil/Geothechnic Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'name' => 'Civil/Highway And Street Construction Engineer',
				'description' => 'Civil/Highway And Street Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'name' => 'Civil/Highways And Road Engineer',
				'description' => 'Civil/Highways And Road Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'name' => 'Civil/Hydraulics Engineer',
				'description' => 'Civil/Hydraulics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'name' => 'Civil/Hydrology Engineer',
				'description' => 'Civil/Hydrology Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'name' => 'Civilian Relation KP19 Officer',
				'description' => 'Civilian Relation KP19 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'name' => 'Civil/Irrigation Engineer',
				'description' => 'Civil/Irrigation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'name' => 'Civil J29 Technical Assistant',
				'description' => 'Civil J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'name' => 'Civil J41 Engineer',
				'description' => 'Civil J41 Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'name' => 'Civil Lawyer',
				'description' => 'Civil Lawyer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'name' => 'Civil/Public Health Engineer',
				'description' => 'Civil/Public Health Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'name' => 'Civil/Railway Construction Engineer',
				'description' => 'Civil/Railway Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'name' => 'Civil/Road Construction Engineer',
				'description' => 'Civil/Road Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'name' => 'Civil/Sanitary Engineer',
				'description' => 'Civil/Sanitary Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'name' => 'Civil Service Commissioner',
				'description' => 'Civil Service Commissioner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'name' => 'Civil Service Commission Officer',
				'description' => 'Civil Service Commission Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'name' => 'Civil Service Inspector',
				'description' => 'Civil Service Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'name' => 'Civil/Soil Mechanics Engineer',
				'description' => 'Civil/Soil Mechanics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'name' => 'Civil/Structural Engineer',
				'description' => 'Civil/Structural Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'name' => 'Civil/Tower Construction Engineer',
				'description' => 'Civil/Tower Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'name' => 'Civil/Tunnel Construction Engineer',
				'description' => 'Civil/Tunnel Construction Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'name' => 'Claim Clerk',
				'description' => 'Claim Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'name' => 'Claims Assessor',
				'description' => 'Claims Assessor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'name' => 'Claims Executive',
				'description' => 'Claims Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'name' => 'Claims Inspector',
				'description' => 'Claims Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'name' => 'Classification Clerk',
				'description' => 'Classification Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'name' => 'Classified',
				'description' => 'Classified',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'name' => 'Classified Advertising Clerk',
				'description' => 'Classified Advertising Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'name' => 'Clay Mixer',
				'description' => 'Clay Mixer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'name' => 'Cleaning Manager',
				'description' => 'Cleaning Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'name' => 'Clearing And Forwarding Agent',
				'description' => 'Clearing And Forwarding Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'name' => 'Clerical/Aircraft Dispatcher',
				'description' => 'Clerical/Aircraft Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'name' => 'Clerical/Air Transport Service Controller',
				'description' => 'Clerical/Air Transport Service Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'name' => 'Clerical/Boat Dispatcher',
				'description' => 'Clerical/Boat Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'name' => 'Clerical/Bus Dispatcher',
				'description' => 'Clerical/Bus Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
			'name' => 'Clerical/Director) Clerk, Compilation/Directory (Compiler',
			'description' => 'Clerical/Director) Clerk, Compilation/Directory (Compiler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'name' => 'Clerical/Gas Pipeline Dispatcher',
				'description' => 'Clerical/Gas Pipeline Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'name' => 'Clerical/Mail Controller',
				'description' => 'Clerical/Mail Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'name' => 'Clerical/Mail Depot Controller',
				'description' => 'Clerical/Mail Depot Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'name' => 'Clerical/Oil Pipelinge Dispatcher',
				'description' => 'Clerical/Oil Pipelinge Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'name' => 'Clerical/Postal Service Controller',
				'description' => 'Clerical/Postal Service Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'name' => 'Clerical Proof-Reader',
				'description' => 'Clerical Proof-Reader',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'name' => 'Clerical/Railway Dispatcher',
				'description' => 'Clerical/Railway Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'name' => 'Clerical/Railway Service Controller',
				'description' => 'Clerical/Railway Service Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
			'name' => 'Clerical/Road Transport (Except Bus And Truck) Dispatcher',
			'description' => 'Clerical/Road Transport (Except Bus And Truck) Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'name' => 'Clerical/Road Transport Services Controller',
				'description' => 'Clerical/Road Transport Services Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'name' => 'Clerical/Road Transport Services Inspector',
				'description' => 'Clerical/Road Transport Services Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'name' => 'Clerical Supervisor',
				'description' => 'Clerical Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'name' => 'Clerical/Train Controller',
				'description' => 'Clerical/Train Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'name' => 'Clerical/Train Dispatcher',
				'description' => 'Clerical/Train Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'name' => 'Clerical/Truck Dispatcher',
				'description' => 'Clerical/Truck Dispatcher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'name' => 'Clerk',
				'description' => 'Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'name' => 'Clerk Chief',
				'description' => 'Clerk Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'name' => 'Clerk-Of-Work',
				'description' => 'Clerk-Of-Work',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'name' => 'Clerk/Sea Transport Services Controller',
				'description' => 'Clerk/Sea Transport Services Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'name' => 'Climatologist',
				'description' => 'Climatologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'name' => 'Clinical Biochemist',
				'description' => 'Clinical Biochemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'name' => 'Clinical Instructor',
				'description' => 'Clinical Instructor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'name' => 'Clinical Pathologist',
				'description' => 'Clinical Pathologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'name' => 'Clinic Assistant',
				'description' => 'Clinic Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'name' => 'Cloakroom Attendant',
				'description' => 'Cloakroom Attendant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'name' => 'Clock Assembler',
				'description' => 'Clock Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'name' => 'Clock Production Machine Operator',
				'description' => 'Clock Production Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'name' => 'Clog Maker',
				'description' => 'Clog Maker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'name' => 'Cloth Designer',
				'description' => 'Cloth Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'name' => 'Clown',
				'description' => 'Clown',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'name' => 'Club Host',
				'description' => 'Club Host',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'name' => 'Club Hostess',
				'description' => 'Club Hostess',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'name' => 'Clubhouse Supervisor',
				'description' => 'Clubhouse Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'name' => 'Club Manager',
				'description' => 'Club Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'name' => 'Coastal Fishery Worker',
				'description' => 'Coastal Fishery Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'name' => 'Coastguard',
				'description' => 'Coastguard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'name' => 'Coastguard A17',
				'description' => 'Coastguard A17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'name' => 'Coating Machine Operator',
				'description' => 'Coating Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'name' => 'Cobbler',
				'description' => 'Cobbler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'name' => 'Cocoa-Bean Processing Machine Operator',
				'description' => 'Cocoa-Bean Processing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'name' => 'Cocoa Farm Worker',
				'description' => 'Cocoa Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'name' => 'Coconut Farm Worker',
				'description' => 'Coconut Farm Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'name' => 'Coconut Planter',
				'description' => 'Coconut Planter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
			'name' => 'Coding (Data-Processing) Clerk',
			'description' => 'Coding (Data-Processing) Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'name' => 'Coding/Statistics Clerk',
				'description' => 'Coding/Statistics Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'name' => 'College Faculty Head',
				'description' => 'College Faculty Head',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'name' => 'College Lecturer',
				'description' => 'College Lecturer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'name' => 'College Or University Registrar',
				'description' => 'College Or University Registrar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'name' => 'College Principal',
				'description' => 'College Principal',
				'created_at' => $now,
				'updated_at' => $now,
			),

			207 => 
			array (
				'name' => 'Communication/Except Computer Analyst',
				'description' => 'Communication/Except Computer Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'name' => 'Communication Programmer',
				'description' => 'Communication Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'name' => 'Communications Assistant',
				'description' => 'Communications Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'name' => 'Communications/Computer Analyst',
				'description' => 'Communications/Computer Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'name' => 'Communications Manager',
				'description' => 'Communications Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),

			229 => 
			array (
				'name' => 'Computer Applications Engineer',
				'description' => 'Computer Applications Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'name' => 'Computer Assistant',
				'description' => 'Computer Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'name' => 'Computer Consultant',
				'description' => 'Computer Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'name' => 'Computer Database Assistant',
				'description' => 'Computer Database Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'name' => 'Computer Engineer',
				'description' => 'Computer Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'name' => 'Computer Engineering Assistant',
				'description' => 'Computer Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'name' => 'Computer Engineering Assistant',
				'description' => 'Computer Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'name' => 'Computer FT17 Technician',
				'description' => 'Computer FT17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'name' => 'Computer Hardware Engineer',
				'description' => 'Computer Hardware Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'name' => 'Computer Help Desk Operator',
				'description' => 'Computer Help Desk Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 => 
			array (
				'name' => 'Computer Network Technician',
				'description' => 'Computer Network Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 => 
			array (
				'name' => 'Computer Operator',
				'description' => 'Computer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 => 
			array (
				'name' => 'Computer Peripheral Equipment/Console Operator',
				'description' => 'Computer Peripheral Equipment/Console Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 => 
			array (
				'name' => 'Computer Peripheral Equipment/High-Speed Printer Operator',
				'description' => 'Computer Peripheral Equipment/High-Speed Printer Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 => 
			array (
				'name' => 'Computer Peripheral Equipment Operator',
				'description' => 'Computer Peripheral Equipment Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 => 
			array (
				'name' => 'Computer Programmer',
				'description' => 'Computer Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 => 
			array (
				'name' => 'Computer Programming Assistant',
				'description' => 'Computer Programming Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 => 
			array (
				'name' => 'Computer Services Manager',
				'description' => 'Computer Services Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 => 
			array (
				'name' => 'Computer Software Engineer',
				'description' => 'Computer Software Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 => 
			array (
				'name' => 'Computer Systems Administrator',
				'description' => 'Computer Systems Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 => 
			array (
				'name' => 'Computer/Systems Analyst Assistant',
				'description' => 'Computer/Systems Analyst Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 => 
			array (
				'name' => 'Computer Systems Engineer',
				'description' => 'Computer Systems Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 => 
			array (
				'name' => 'Computer Technician',
				'description' => 'Computer Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 => 
			array (
				'name' => 'Computer/Users’ Services Assistant',
				'description' => 'Computer/Users’ Services Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 => 
			array (
				'name' => 'Computer/Visualizer Artist',
				'description' => 'Computer/Visualizer Artist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 => 
			array (
				'name' => 'Corporate Affairs Executive',
				'description' => 'Corporate Affairs Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 => 
			array (
				'name' => 'Corporate Communication Executive',
				'description' => 'Corporate Communication Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 => 
			array (
				'name' => 'Corporate Financial',
				'description' => 'Corporate Financial',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 => 
			array (
				'name' => 'Correspondence Assistant',
				'description' => 'Correspondence Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 => 
			array (
				'name' => 'Correspondence Clerk',
				'description' => 'Correspondence Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 => 
			array (
				'name' => 'Correspondence Teacher',
				'description' => 'Correspondence Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 => 
			array (
				'name' => 'Corrosion Chemist',
				'description' => 'Corrosion Chemist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 => 
			array (
				'name' => 'Cosmologist',
				'description' => 'Cosmologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 => 
			array (
				'name' => 'Cost Accountant',
				'description' => 'Cost Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 => 
			array (
				'name' => 'Cost Clerk',
				'description' => 'Cost Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 => 
			array (
				'name' => 'Cost Computing Clerk',
				'description' => 'Cost Computing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 => 
			array (
				'name' => 'Cost Controller',
				'description' => 'Cost Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 => 
			array (
				'name' => 'Cost Evaluation Engineer',
				'description' => 'Cost Evaluation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 => 
			array (
				'name' => 'Costing Assistant',
				'description' => 'Costing Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 => 
			array (
				'name' => 'Costing Manager',
				'description' => 'Costing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 => 
			array (
				'name' => 'Costing Officer/Executive',
				'description' => 'Costing Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 => 
			array (
				'name' => 'Cotton-Mixing Machine Operator',
				'description' => 'Cotton-Mixing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 => 
			array (
				'name' => 'Counselor',
				'description' => 'Counselor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 => 
			array (
				'name' => 'Counselor Assistant',
				'description' => 'Counselor Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 => 
			array (
				'name' => 'Counter Enquiries Clerk',
				'description' => 'Counter Enquiries Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 => 
			array (
				'name' => 'Counter Sales/Promoter Assistant',
				'description' => 'Counter Sales/Promoter Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 => 
			array (
				'name' => 'Court Clerk',
				'description' => 'Court Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 => 
			array (
				'name' => 'Court Receiver And Liquidator',
				'description' => 'Court Receiver And Liquidator',
				'created_at' => $now,
				'updated_at' => $now,
			),

			361 => 
			array (
				'name' => 'Customer-Complaints Clerk',
				'description' => 'Customer-Complaints Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 => 
			array (
				'name' => 'Customer Contact Centre',
				'description' => 'Customer Contact Centre',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 => 
			array (
				'name' => 'Customer Service Manager',
				'description' => 'Customer Service Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 => 
			array (
				'name' => 'Customer Service N17 Officer',
				'description' => 'Customer Service N17 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 => 
			array (
				'name' => 'Customer Service Officer/Executive',
				'description' => 'Customer Service Officer/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 => 
			array (
				'name' => 'Customer Service Supervisor',
				'description' => 'Customer Service Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 => 
			array (
				'name' => 'Custom Inspector',
				'description' => 'Custom Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 => 
			array (
				'name' => 'Customs W27 Ssistant Superintendent',
				'description' => 'Customs W27 Ssistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 => 
			array (
				'name' => 'Customs W41 Superintendent',
				'description' => 'Customs W41 Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 => 
			array (
				'name' => 'Custom W17 Junior Assistant Superintendent',
				'description' => 'Custom W17 Junior Assistant Superintendent',
				'created_at' => $now,
				'updated_at' => $now,
			),

			392 => 
			array (
				'name' => 'Database Administrator',
				'description' => 'Database Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'name' => 'Database Architect',
				'description' => 'Database Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'name' => 'Database/Computer Analyst',
				'description' => 'Database/Computer Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'name' => 'Database Designer',
				'description' => 'Database Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'name' => 'Data-Base Programmer',
				'description' => 'Data-Base Programmer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'name' => 'Data Entry/Computer',
				'description' => 'Data Entry/Computer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'name' => 'Data Entry/Electronic Mail',
				'description' => 'Data Entry/Electronic Mail',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'name' => 'Data Entry Supervisor',
				'description' => 'Data Entry Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'name' => 'Data Processing F11 Machine Operator',
				'description' => 'Data Processing F11 Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'name' => 'Data Processing Manager',
				'description' => 'Data Processing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),

			486 => 
			array (
				'name' => 'Documentation Officer',
				'description' => 'Documentation Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 => 
			array (
				'name' => 'Document Controller',
				'description' => 'Document Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 => 
			array (
				'name' => 'Document Controller Officer',
				'description' => 'Document Controller Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 => 
			array (
				'name' => 'Document Coordinator',
				'description' => 'Document Coordinator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 => 
			array (
				'name' => 'Document Duplication Clerk',
				'description' => 'Document Duplication Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),

		));
		\DB::table('occupation')->insert(array (
			92 => 
			array (
			'name' => 'Electronic Data Processing (PDE) Administrator',
			'description' => 'Electronic Data Processing (PDE) Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
			'name' => 'Electronic Data Processing (PDE) Analyst',
			'description' => 'Electronic Data Processing (PDE) Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'name' => 'Electronic Equipment Assembler',
				'description' => 'Electronic Equipment Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'name' => 'Electronics/Computer And Related Electronic Equipment Fitter',
				'description' => 'Electronics/Computer And Related Electronic Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'name' => 'Electronics/Computer Hardware Design Engineer',
				'description' => 'Electronics/Computer Hardware Design Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'name' => 'Electronics Engineer',
				'description' => 'Electronics Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'name' => 'Electronics Engineering Assistant',
				'description' => 'Electronics Engineering Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'name' => 'Electronics Fitter',
				'description' => 'Electronics Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'name' => 'Electronics/Industrial Equipment Fitter',
				'description' => 'Electronics/Industrial Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'name' => 'Electronics/Information Engineering Engineer',
				'description' => 'Electronics/Information Engineering Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'name' => 'Electronics/Instrumentation Engineer',
				'description' => 'Electronics/Instrumentation Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'name' => 'Electronics J29 Technical Assistant',
				'description' => 'Electronics J29 Technical Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'name' => 'Electronics J41 Engineer',
				'description' => 'Electronics J41 Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'name' => 'Electronics/Medical Equipment Fitter',
				'description' => 'Electronics/Medical Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'name' => 'Electronics/Meteorological Equipment Fitter',
				'description' => 'Electronics/Meteorological Equipment Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'name' => 'Electronics Physicist',
				'description' => 'Electronics Physicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'name' => 'Electronics Repairer',
				'description' => 'Electronics Repairer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'name' => 'Electronics/Semiconductors Engineer',
				'description' => 'Electronics/Semiconductors Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'name' => 'Electronics/Signaling System Fitter',
				'description' => 'Electronics/Signaling System Fitter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'name' => 'Electroplater',
				'description' => 'Electroplater',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'name' => 'Electroplating/Metal Machine Operator',
				'description' => 'Electroplating/Metal Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),

			144 => 
			array (
				'name' => 'Engineering/Automobile Technician',
				'description' => 'Engineering/Automobile Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'name' => 'Engineering/Chemical Estimator',
				'description' => 'Engineering/Chemical Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
			'name' => 'Engineering/Chemical (Petroleum) Technician',
			'description' => 'Engineering/Chemical (Petroleum) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'name' => 'Engineering/Chemical Technician',
				'description' => 'Engineering/Chemical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'name' => 'Engineering/Chemical Technologist',
				'description' => 'Engineering/Chemical Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'name' => 'Engineering/Civil Draughtsperson',
				'description' => 'Engineering/Civil Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'name' => 'Engineering/Civil Estimator',
				'description' => 'Engineering/Civil Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'name' => 'Engineering/Civil J17 Technician',
				'description' => 'Engineering/Civil J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'name' => 'Engineering/Civil Technician',
				'description' => 'Engineering/Civil Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'name' => 'Engineering Civil Technologist',
				'description' => 'Engineering Civil Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'name' => 'Engineering Clerk',
				'description' => 'Engineering Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'name' => 'Engineering Designer',
				'description' => 'Engineering Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'name' => 'Engineering/Electrical Draughtsperson',
				'description' => 'Engineering/Electrical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
			'name' => 'Engineering/Electrical (Electric Power Transmission) Technician',
			'description' => 'Engineering/Electrical (Electric Power Transmission) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'name' => 'Engineering/Electrical Estimator',
				'description' => 'Engineering/Electrical Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
			'name' => 'Engineering/Electrical (High Voltage) Technician',
			'description' => 'Engineering/Electrical (High Voltage) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'name' => 'Engineering/Electrical J17 Technician',
				'description' => 'Engineering/Electrical J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'name' => 'Engineering/Electrical Technician',
				'description' => 'Engineering/Electrical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'name' => 'Engineering/Electrical Technologist',
				'description' => 'Engineering/Electrical Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'name' => 'Engineering/Electronics Draughtsperson',
				'description' => 'Engineering/Electronics Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'name' => 'Engineering/Electronics Estimator',
				'description' => 'Engineering/Electronics Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'name' => 'Engineering/Electronics J17 Technician',
				'description' => 'Engineering/Electronics J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'name' => 'Engineering/Electronics Technician',
				'description' => 'Engineering/Electronics Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'name' => 'Engineering/Electronics Technologist',
				'description' => 'Engineering/Electronics Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'name' => 'Engineering Geologist',
				'description' => 'Engineering Geologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'name' => 'Engineering/Heating And Ventilation Systems Draughtsperson',
				'description' => 'Engineering/Heating And Ventilation Systems Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'name' => 'Engineering Illustrator',
				'description' => 'Engineering Illustrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'name' => 'Engineering/Industrial Efficiency Technician',
				'description' => 'Engineering/Industrial Efficiency Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'name' => 'Engineering/Industrial Layout Technician',
				'description' => 'Engineering/Industrial Layout Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'name' => 'Engineering/Marine Draughtsperson',
				'description' => 'Engineering/Marine Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'name' => 'Engineering/Marine Technician',
				'description' => 'Engineering/Marine Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
			'name' => 'Engineering/Mechanical (Agriculture) Technician',
			'description' => 'Engineering/Mechanical (Agriculture) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'name' => 'Engineering/Mechanical Draughtsperson',
				'description' => 'Engineering/Mechanical Draughtsperson',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'name' => 'Engineering/Mechanical Estimator',
				'description' => 'Engineering/Mechanical Estimator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
			'name' => 'Engineering/Mechanical (Industrial Machinery And Tools) Technician',
			'description' => 'Engineering/Mechanical (Industrial Machinery And Tools) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
			'name' => 'Engineering/Mechanical (Instruments) Technician',
			'description' => 'Engineering/Mechanical (Instruments) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'name' => 'Engineering/Mechanical J17 Technician',
				'description' => 'Engineering/Mechanical J17 Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
			'name' => 'Engineering/Mechanical (Lubrication) Technician',
			'description' => 'Engineering/Mechanical (Lubrication) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
			'name' => 'Engineering/Mechanical (Motors And Engines) Technician',
			'description' => 'Engineering/Mechanical (Motors And Engines) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
			'name' => 'Engineering/Mechanical (Ship Construction) Technician',
			'description' => 'Engineering/Mechanical (Ship Construction) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'name' => 'Engineering/Mechanical Technician',
				'description' => 'Engineering/Mechanical Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'name' => 'Engineering/Mechanical Technologist',
				'description' => 'Engineering/Mechanical Technologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'name' => 'Engineering/Methods Technician',
				'description' => 'Engineering/Methods Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'name' => 'Engineering/Mining Technician',
				'description' => 'Engineering/Mining Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'name' => 'Engineering/Petroleum Technician',
				'description' => 'Engineering/Petroleum Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'name' => 'Engineering/Planning Technician',
				'description' => 'Engineering/Planning Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'name' => 'Engineering/Process Technician',
				'description' => 'Engineering/Process Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'name' => 'Engineering/Production Technician',
				'description' => 'Engineering/Production Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'name' => 'Engineering/Refrigeration And Air-Conditioning System And Equipment Technician',
				'description' => 'Engineering/Refrigeration And Air-Conditioning System And Equipment Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'name' => 'Engineering/Safety Technician',
				'description' => 'Engineering/Safety Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'name' => 'Engineering Statistician',
				'description' => 'Engineering Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
			'name' => 'Engineering/Systems (Except Computers) Technician',
			'description' => 'Engineering/Systems (Except Computers) Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'name' => 'Engineering/Telecomunications Technician',
				'description' => 'Engineering/Telecomunications Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'name' => 'Engineering/Time And Motion Study Technician',
				'description' => 'Engineering/Time And Motion Study Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'name' => 'Engineering/Value Technician',
				'description' => 'Engineering/Value Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'name' => 'Engineering/Work Study Technician',
				'description' => 'Engineering/Work Study Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),


			337 => 
			array (
				'name' => 'Finance Clerk',
				'description' => 'Finance Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 => 
			array (
				'name' => 'Finance Executive',
				'description' => 'Finance Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 => 
			array (
				'name' => 'Finance Manager',
				'description' => 'Finance Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 => 
			array (
				'name' => 'Finance Statistician',
				'description' => 'Finance Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 => 
			array (
				'name' => 'Finance W41 Officer',
				'description' => 'Finance W41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 => 
			array (
				'name' => 'Financial Analyst',
				'description' => 'Financial Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 => 
			array (
				'name' => 'Financial And Institution Manager',
				'description' => 'Financial And Institution Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 => 
			array (
				'name' => 'Financial And Insurance Branch Manager',
				'description' => 'Financial And Insurance Branch Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 => 
			array (
				'name' => 'Financial And Investment Adviser',
				'description' => 'Financial And Investment Adviser',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 => 
			array (
				'name' => 'Financial Assistant',
				'description' => 'Financial Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 => 
			array (
				'name' => 'Financial Controller',
				'description' => 'Financial Controller',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 => 
			array (
				'name' => 'Financial Planner',
				'description' => 'Financial Planner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 => 
			array (
				'name' => 'Financial Supervisor',
				'description' => 'Financial Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (
			376 => 
			array (
				'name' => 'Insurance Adjuster',
				'description' => 'Insurance Adjuster',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 => 
			array (
				'name' => 'Insurance/Adjustment Assistant',
				'description' => 'Insurance/Adjustment Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 => 
			array (
				'name' => 'Insurance Agent',
				'description' => 'Insurance Agent',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 => 
			array (
				'name' => 'Insurance Assessor',
				'description' => 'Insurance Assessor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 => 
			array (
				'name' => 'Insurance Broker',
				'description' => 'Insurance Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 => 
			array (
				'name' => 'Insurance Claims Arbitrator',
				'description' => 'Insurance Claims Arbitrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 => 
			array (
				'name' => 'Insurance/Claims Assistant',
				'description' => 'Insurance/Claims Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 => 
			array (
				'name' => 'Insurance Manager',
				'description' => 'Insurance Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 => 
			array (
				'name' => 'Insurance/Policy Assistant',
				'description' => 'Insurance/Policy Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 => 
			array (
				'name' => 'Insurance Underwriter',
				'description' => 'Insurance Underwriter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 => 
			array (
				'name' => 'Insurance/Underwriting Assistant',
				'description' => 'Insurance/Underwriting Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 => 
			array (
				'name' => 'Insurance/Underwriting Assistant Supervisor',
				'description' => 'Insurance/Underwriting Assistant Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 => 
			array (
				'name' => 'Insurance Underwriting Clerk',
				'description' => 'Insurance Underwriting Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 => 
			array (
				'name' => 'Intelligence Officer',
				'description' => 'Intelligence Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 => 
			array (
				'name' => 'Interior Architect',
				'description' => 'Interior Architect',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 => 
			array (
				'name' => 'Interior Decoration Designer',
				'description' => 'Interior Decoration Designer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 => 
			array (
				'name' => 'Interior Decorator',
				'description' => 'Interior Decorator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 => 
			array (
				'name' => 'Internal Combustion Engine Engineer',
				'description' => 'Internal Combustion Engine Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 => 
			array (
				'name' => 'Internal Medicine Physician',
				'description' => 'Internal Medicine Physician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 => 
			array (
				'name' => 'Internal Security Guard',
				'description' => 'Internal Security Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 => 
			array (
				'name' => 'Interpreter',
				'description' => 'Interpreter',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 => 
			array (
				'name' => 'Interpreter L17',
				'description' => 'Interpreter L17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 => 
			array (
				'name' => 'Interventional Radiologist',
				'description' => 'Interventional Radiologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 => 
			array (
				'name' => 'Inventory Clerk',
				'description' => 'Inventory Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 => 
			array (
				'name' => 'Inventory Purchasing Clerk',
				'description' => 'Inventory Purchasing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 => 
			array (
				'name' => 'Investigation KR17 Assistant',
				'description' => 'Investigation KR17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 => 
			array (
				'name' => 'Investigation KR29 Ssistant Officer',
				'description' => 'Investigation KR29 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 => 
			array (
				'name' => 'Investigation KR41 Officer',
				'description' => 'Investigation KR41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 => 
			array (
				'name' => 'Investment Broker',
				'description' => 'Investment Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 => 
			array (
				'name' => 'Investment Clerk',
				'description' => 'Investment Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),

			138 => 
			array (
				'name' => 'Management Accountant',
				'description' => 'Management Accountant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'name' => 'Management Consultant',
				'description' => 'Management Consultant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'name' => 'Management Information Systems Clerk',
				'description' => 'Management Information Systems Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
			'name' => 'Management Information Systems (MIS) Analyst',
			'description' => 'Management Information Systems (MIS) Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
			'name' => 'Management Information Systems (MIS) Engineer',
			'description' => 'Management Information Systems (MIS) Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'name' => 'Management Information Systems Supervisor',
				'description' => 'Management Information Systems Supervisor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'name' => 'Management Trainee',
				'description' => 'Management Trainee',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'name' => 'Managing Director',
				'description' => 'Managing Director',
				'created_at' => $now,
				'updated_at' => $now,
			),

			175 => 
			array (
				'name' => 'Marketing Clerk',
				'description' => 'Marketing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'name' => 'Marketing Executive',
				'description' => 'Marketing Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'name' => 'Marketing Manager',
				'description' => 'Marketing Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'name' => 'Marketing Research Analyst/Executive',
				'description' => 'Marketing Research Analyst/Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'name' => 'Marketing Salesman/Salesgirl',
				'description' => 'Marketing Salesman/Salesgirl',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'name' => 'Market Research/Business Analyst',
				'description' => 'Market Research/Business Analyst',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'name' => 'Market Research Enumerator',
				'description' => 'Market Research Enumerator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'name' => 'Market Research Interview',
				'description' => 'Market Research Interview',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'name' => 'Market Research Manager',
				'description' => 'Market Research Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'name' => 'Market Research Statistician',
				'description' => 'Market Research Statistician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'name' => 'Market Salesperson',
				'description' => 'Market Salesperson',
				'created_at' => $now,
				'updated_at' => $now,
			),

			430 => 
			array (
				'name' => 'Network Administrator',
				'description' => 'Network Administrator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 => 
			array (
				'name' => 'Network Communications Executive',
				'description' => 'Network Communications Executive',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 => 
			array (
				'name' => 'Network Driver',
				'description' => 'Network Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 => 
			array (
				'name' => 'Network Engineer',
				'description' => 'Network Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 => 
			array (
				'name' => 'Network Operator',
				'description' => 'Network Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 => 
			array (
				'name' => 'Network Support Technician',
				'description' => 'Network Support Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),

		));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'name' => 'Office Chief',
				'description' => 'Office Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'name' => 'Office Cleaner',
				'description' => 'Office Cleaner',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'name' => 'Office Clerk',
				'description' => 'Office Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'name' => 'Office Guard',
				'description' => 'Office Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'name' => 'Office Machinery Assembler',
				'description' => 'Office Machinery Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'name' => 'Office Machinery Mechanic',
				'description' => 'Office Machinery Mechanic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
			'name' => 'Office (PAP) N1 General Worker',
			'description' => 'Office (PAP) N1 General Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'name' => 'Officer/Manager Driver',
				'description' => 'Officer/Manager Driver',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'name' => 'Office/Supervisor Cashier',
				'description' => 'Office/Supervisor Cashier',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('occupation')->insert(array (

					446 => 
					array (
						'name' => 'Sales Admin Clerk',
						'description' => 'Sales Admin Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					447 => 
					array (
						'name' => 'Sales Administrative Executive',
						'description' => 'Sales Administrative Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					448 => 
					array (
						'name' => 'Sales And Marketing Clerk',
						'description' => 'Sales And Marketing Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					449 => 
					array (
						'name' => 'Sales And Marketing Manager',
						'description' => 'Sales And Marketing Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					450 => 
					array (
						'name' => 'Sales And Marketing Professionals',
						'description' => 'Sales And Marketing Professionals',
						'created_at' => $now,
						'updated_at' => $now,
					),
					451 => 
					array (
						'name' => 'Sales Assistant',
						'description' => 'Sales Assistant',
						'created_at' => $now,
						'updated_at' => $now,
					),
					452 => 
					array (
						'name' => 'Sales Associate',
						'description' => 'Sales Associate',
						'created_at' => $now,
						'updated_at' => $now,
					),
					453 => 
					array (
						'name' => 'Sales Clerk',
						'description' => 'Sales Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					454 => 
					array (
						'name' => 'Sales Co-Coordinator',
						'description' => 'Sales Co-Coordinator',
						'created_at' => $now,
						'updated_at' => $now,
					),
					455 => 
					array (
						'name' => 'Sales Counter Clerk',
						'description' => 'Sales Counter Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					456 => 
					array (
						'name' => 'Sales Engineer',
						'description' => 'Sales Engineer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					457 => 
					array (
						'name' => 'Sales/Engineering Agent',
						'description' => 'Sales/Engineering Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
					458 => 
					array (
						'name' => 'Sales Executive',
						'description' => 'Sales Executive',
						'created_at' => $now,
						'updated_at' => $now,
					),
					459 => 
					array (
						'name' => 'Sales Manager',
						'description' => 'Sales Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					460 => 
					array (
						'name' => 'Sales Order Clerk',
						'description' => 'Sales Order Clerk',
						'created_at' => $now,
						'updated_at' => $now,
					),
					461 => 
					array (
						'name' => 'Salesperson Telemarketer',
						'description' => 'Salesperson Telemarketer',
						'created_at' => $now,
						'updated_at' => $now,
					),
					462 => 
					array (
						'name' => 'Sales Promoter',
						'description' => 'Sales Promoter',
						'created_at' => $now,
						'updated_at' => $now,
					),
					463 => 
					array (
						'name' => 'Sales Promotion Manager',
						'description' => 'Sales Promotion Manager',
						'created_at' => $now,
						'updated_at' => $now,
					),
					464 => 
					array (
						'name' => 'Sales Promotion Method Specialist',
						'description' => 'Sales Promotion Method Specialist',
						'created_at' => $now,
						'updated_at' => $now,
					),
					465 => 
					array (
						'name' => 'Sales Representative',
						'description' => 'Sales Representative',
						'created_at' => $now,
						'updated_at' => $now,
					),
					466 => 
					array (
						'name' => 'Sales Secretary',
						'description' => 'Sales Secretary',
						'created_at' => $now,
						'updated_at' => $now,
					),
					467 => 
					array (
						'name' => 'Sales Supervisor',
						'description' => 'Sales Supervisor',
						'created_at' => $now,
						'updated_at' => $now,
					),
					468 => 
					array (
						'name' => 'Sales/Technical Agent',
						'description' => 'Sales/Technical Agent',
						'created_at' => $now,
						'updated_at' => $now,
					),
				));
		\DB::table('occupation')->insert(array (
			0 => 
			array (
				'name' => 'School Inspector',
				'description' => 'School Inspector',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'name' => 'School Principal',
				'description' => 'School Principal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'name' => 'School Secretary',
				'description' => 'School Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
			'name' => 'Science (Nuclear Research) C27 Ssistant Officer',
			'description' => 'Science (Nuclear Research) C27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
			'name' => 'Science (Radiology) Officer',
			'description' => 'Science (Radiology) Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'name' => 'Scientific Photographer',
				'description' => 'Scientific Photographer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'name' => 'Scrap Handler',
				'description' => 'Scrap Handler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'name' => 'Scribes',
				'description' => 'Scribes',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'name' => 'Script Writer',
				'description' => 'Script Writer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'name' => 'Sculptor',
				'description' => 'Sculptor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'name' => 'Sealing Machine Operator',
				'description' => 'Sealing Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'name' => 'Seamless Pipe And Tube Drawer',
				'description' => 'Seamless Pipe And Tube Drawer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'name' => 'Seamless Pipe And Tube Machine Operator',
				'description' => 'Seamless Pipe And Tube Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'name' => 'Seamstress',
				'description' => 'Seamstress',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'name' => 'Seasoning/Wood Machine Operator',
				'description' => 'Seasoning/Wood Machine Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'name' => 'Seaweed Gatherer',
				'description' => 'Seaweed Gatherer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'name' => 'Secondary Education Teacher',
				'description' => 'Secondary Education Teacher',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'name' => 'Second Lieutenant',
				'description' => 'Second Lieutenant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'name' => 'Secretary',
				'description' => 'Secretary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'name' => 'Securities Broker',
				'description' => 'Securities Broker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'name' => 'Securities Clerk',
				'description' => 'Securities Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'name' => 'Security Guard Chief',
				'description' => 'Security Guard Chief',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'name' => 'Security Guard KP11',
				'description' => 'Security Guard KP11',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'name' => 'Security KP17 Assistant',
				'description' => 'Security KP17 Assistant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'name' => 'Security KP27 Ssistant Officer',
				'description' => 'Security KP27 Ssistant Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'name' => 'Security KP41 Officer',
				'description' => 'Security KP41 Officer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'name' => 'Security Manager',
				'description' => 'Security Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'name' => 'Security/Private Guard',
				'description' => 'Security/Private Guard',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'name' => 'Security Sergeant Major',
				'description' => 'Security Sergeant Major',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'name' => 'Seismologist',
				'description' => 'Seismologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'name' => 'Seismology Geophysicist',
				'description' => 'Seismology Geophysicist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'name' => 'Self-Service Restaurant Manager',
				'description' => 'Self-Service Restaurant Manager',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'name' => 'Semi-Conductor Assembler',
				'description' => 'Semi-Conductor Assembler',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'name' => 'Semi-Conductor Engineer',
				'description' => 'Semi-Conductor Engineer',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'name' => 'Semi-Conductor Technician',
				'description' => 'Semi-Conductor Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'name' => 'Senator',
				'description' => 'Senator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'name' => 'Separator/Chemical And Related Processes Operator',
				'description' => 'Separator/Chemical And Related Processes Operator',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'name' => 'Serang',
				'description' => 'Serang',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'name' => 'Serang A17',
				'description' => 'Serang A17',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'name' => 'Sergeant',
				'description' => 'Sergeant',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'name' => 'Sericulture Worker',
				'description' => 'Sericulture Worker',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'name' => 'Serologist',
				'description' => 'Serologist',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'name' => 'Serology Technician',
				'description' => 'Serology Technician',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'name' => 'Service Assistant Sewing Clerk',
				'description' => 'Service Assistant Sewing Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'name' => 'Service Clerk',
				'description' => 'Service Clerk',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'name' => 'Servicer Telephone And Telegraph',
				'description' => 'Servicer Telephone And Telegraph',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
			'name' => 'Services)',
		'description' => 'Services)',
		'created_at' => $now,
		'updated_at' => $now,
	),
	47 => 
	array (
		'name' => 'Sessions Court Judge',
		'description' => 'Sessions Court Judge',
		'created_at' => $now,
		'updated_at' => $now,
	),
	48 => 
	array (
		'name' => 'Sewage Plant Operator',
		'description' => 'Sewage Plant Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	49 => 
	array (
		'name' => 'Sewer',
		'description' => 'Sewer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	50 => 
	array (
		'name' => 'Sewerage And Sanitary Engineer',
		'description' => 'Sewerage And Sanitary Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	51 => 
	array (
		'name' => 'Sewing Machine Assembler',
		'description' => 'Sewing Machine Assembler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	52 => 
	array (
		'name' => 'Sewing Machine Operator',
		'description' => 'Sewing Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	53 => 
	array (
		'name' => 'Sewing Operator',
		'description' => 'Sewing Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	54 => 
	array (
		'name' => 'Sewing Worker',
		'description' => 'Sewing Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	55 => 
	array (
		'name' => 'Sexton',
		'description' => 'Sexton',
		'created_at' => $now,
		'updated_at' => $now,
	),
	56 => 
	array (
		'name' => 'Shaping Machine Setter-Operator',
		'description' => 'Shaping Machine Setter-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	57 => 
	array (
		'name' => 'Share And Stock Registration Clerk',
		'description' => 'Share And Stock Registration Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	58 => 
	array (
		'name' => 'Sharpening/Metal Machine Operator',
		'description' => 'Sharpening/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	59 => 
	array (
		'name' => 'Shearing/Metal Machine Operator',
		'description' => 'Shearing/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	60 => 
	array (
		'name' => 'Sheet Metal Marker',
		'description' => 'Sheet Metal Marker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	61 => 
	array (
		'name' => 'Sheet Metal Worker',
		'description' => 'Sheet Metal Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	62 => 
	array (
		'name' => 'Sheet Rubber Maker',
		'description' => 'Sheet Rubber Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	63 => 
	array (
		'name' => 'Shellfish Gatherer',
		'description' => 'Shellfish Gatherer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	64 => 
	array (
		'name' => 'Shift Supervisor',
		'description' => 'Shift Supervisor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	65 => 
	array (
		'name' => 'Ship/Cabin Stewardess',
		'description' => 'Ship/Cabin Stewardess',
		'created_at' => $now,
		'updated_at' => $now,
	),
	66 => 
	array (
		'name' => 'Ship Captain/Master',
		'description' => 'Ship Captain/Master',
		'created_at' => $now,
		'updated_at' => $now,
	),
	67 => 
	array (
		'name' => 'Ship Carpenter',
		'description' => 'Ship Carpenter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	68 => 
	array (
		'name' => 'Ship Chief Steward',
		'description' => 'Ship Chief Steward',
		'created_at' => $now,
		'updated_at' => $now,
	),
	69 => 
	array (
		'name' => 'Ship Chief Stewardess',
		'description' => 'Ship Chief Stewardess',
		'created_at' => $now,
		'updated_at' => $now,
	),
	70 => 
	array (
		'name' => 'Ship Construction Engineer',
		'description' => 'Ship Construction Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	71 => 
	array (
		'name' => 'Ship Cook',
		'description' => 'Ship Cook',
		'created_at' => $now,
		'updated_at' => $now,
	),
	72 => 
	array (
		'name' => 'Ship/Deck Officer',
		'description' => 'Ship/Deck Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	73 => 
	array (
		'name' => 'Ship Electrician',
		'description' => 'Ship Electrician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	74 => 
	array (
		'name' => 'Ship Engineer',
		'description' => 'Ship Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	75 => 
	array (
		'name' => 'Ship Fireperson',
		'description' => 'Ship Fireperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	76 => 
	array (
		'name' => 'Ship Joiner',
		'description' => 'Ship Joiner',
		'created_at' => $now,
		'updated_at' => $now,
	),
	77 => 
	array (
		'name' => 'Ship Mechanic',
		'description' => 'Ship Mechanic',
		'created_at' => $now,
		'updated_at' => $now,
	),
	78 => 
	array (
		'name' => 'Ship/Mess/Cabin Steward',
		'description' => 'Ship/Mess/Cabin Steward',
		'created_at' => $now,
		'updated_at' => $now,
	),
	79 => 
	array (
		'name' => 'Ship/Mess Stewardess',
		'description' => 'Ship/Mess Stewardess',
		'created_at' => $now,
		'updated_at' => $now,
	),
	80 => 
	array (
		'name' => 'Ship Navigator',
		'description' => 'Ship Navigator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	81 => 
	array (
		'name' => 'Ship Pilot',
		'description' => 'Ship Pilot',
		'created_at' => $now,
		'updated_at' => $now,
	),
	82 => 
	array (
		'name' => 'Shipping Agent',
		'description' => 'Shipping Agent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	83 => 
	array (
		'name' => 'Shipping And Purchasing Clerk',
		'description' => 'Shipping And Purchasing Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	84 => 
	array (
		'name' => 'Shipping Assistant',
		'description' => 'Shipping Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	85 => 
	array (
		'name' => 'Shipping Clerk',
		'description' => 'Shipping Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	86 => 
	array (
		'name' => 'Shipping Coordinator',
		'description' => 'Shipping Coordinator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	87 => 
	array (
		'name' => 'Shipping Executive',
		'description' => 'Shipping Executive',
		'created_at' => $now,
		'updated_at' => $now,
	),
	88 => 
	array (
		'name' => 'Ship Plater',
		'description' => 'Ship Plater',
		'created_at' => $now,
		'updated_at' => $now,
	),
	89 => 
	array (
		'name' => 'Ship Purser',
		'description' => 'Ship Purser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	90 => 
	array (
		'name' => 'Ship Quatermaster',
		'description' => 'Ship Quatermaster',
		'created_at' => $now,
		'updated_at' => $now,
	),
	91 => 
	array (
		'name' => 'Ship Rigger',
		'description' => 'Ship Rigger',
		'created_at' => $now,
		'updated_at' => $now,
	),
	92 => 
	array (
		'name' => 'Ship’S Cabin Attendant',
		'description' => 'Ship’S Cabin Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	93 => 
	array (
		'name' => 'Ship’S Hull Painter',
		'description' => 'Ship’S Hull Painter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	94 => 
	array (
		'name' => 'Ships Radio Officer',
		'description' => 'Ships Radio Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	95 => 
	array (
		'name' => 'Shipyard',
		'description' => 'Shipyard',
		'created_at' => $now,
		'updated_at' => $now,
	),
	96 => 
	array (
		'name' => 'Shoe Designer',
		'description' => 'Shoe Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	97 => 
	array (
		'name' => 'Shoemaker',
		'description' => 'Shoemaker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	98 => 
	array (
		'name' => 'Shoe Pattern-Maker',
		'description' => 'Shoe Pattern-Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	99 => 
	array (
		'name' => 'Shoe Production Machine Operator',
		'description' => 'Shoe Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	100 => 
	array (
		'name' => 'Shop Assistant',
		'description' => 'Shop Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	101 => 
	array (
		'name' => 'Shopkeeper',
		'description' => 'Shopkeeper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	102 => 
	array (
		'name' => 'Shopping Centre Manager',
		'description' => 'Shopping Centre Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	103 => 
	array (
		'name' => 'Shorthand Typist',
		'description' => 'Shorthand Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	104 => 
	array (
		'name' => 'Shot Firer',
		'description' => 'Shot Firer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	105 => 
	array (
		'name' => 'Shuffle-Car/Mine Operator',
		'description' => 'Shuffle-Car/Mine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	106 => 
	array (
		'name' => 'Siak/Nuja',
		'description' => 'Siak/Nuja',
		'created_at' => $now,
		'updated_at' => $now,
	),
	107 => 
	array (
		'name' => 'Sidang',
		'description' => 'Sidang',
		'created_at' => $now,
		'updated_at' => $now,
	),
	108 => 
	array (
		'name' => 'Sieving/Chemical And Related Processes Machine Operator',
		'description' => 'Sieving/Chemical And Related Processes Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	109 => 
	array (
		'name' => 'Signal/Railway Engineer',
		'description' => 'Signal/Railway Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	110 => 
	array (
		'name' => 'Signpainter',
		'description' => 'Signpainter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	111 => 
	array (
		'name' => 'Silicon Chip Production Machine Operator',
		'description' => 'Silicon Chip Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	112 => 
	array (
		'name' => 'Silk Reeler',
		'description' => 'Silk Reeler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	113 => 
	array (
		'name' => 'Silk-Screen Printer',
		'description' => 'Silk-Screen Printer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	114 => 
	array (
		'name' => 'Silkworm Cooker',
		'description' => 'Silkworm Cooker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	115 => 
	array (
		'name' => 'Silkworm Raiser',
		'description' => 'Silkworm Raiser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	116 => 
	array (
		'name' => 'Silversmith',
		'description' => 'Silversmith',
		'created_at' => $now,
		'updated_at' => $now,
	),
	117 => 
	array (
		'name' => 'Silviculture Technician',
		'description' => 'Silviculture Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	118 => 
	array (
		'name' => 'Silviculturist',
		'description' => 'Silviculturist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	119 => 
	array (
		'name' => 'Simultaneous Interpreter N41',
		'description' => 'Simultaneous Interpreter N41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	120 => 
	array (
		'name' => 'Singers And Composers Other Musician',
		'description' => 'Singers And Composers Other Musician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	121 => 
	array (
		'name' => 'Singer/Vocalist',
		'description' => 'Singer/Vocalist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	122 => 
	array (
		'name' => 'Sister',
		'description' => 'Sister',
		'created_at' => $now,
		'updated_at' => $now,
	),
	123 => 
	array (
		'name' => 'Site Clerk',
		'description' => 'Site Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	124 => 
	array (
		'name' => 'Site Coordinator',
		'description' => 'Site Coordinator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	125 => 
	array (
		'name' => 'Site Engineer',
		'description' => 'Site Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	126 => 
	array (
		'name' => 'Site General Worker',
		'description' => 'Site General Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	127 => 
	array (
		'name' => 'Site Manager',
		'description' => 'Site Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	128 => 
	array (
		'name' => 'Site Supervisor',
		'description' => 'Site Supervisor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	129 => 
	array (
		'name' => 'Ski Instructor',
		'description' => 'Ski Instructor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	130 => 
	array (
		'name' => 'Skilled/Mixed Animal Husbandry Farm Worker',
		'description' => 'Skilled/Mixed Animal Husbandry Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	131 => 
	array (
		'name' => 'Skin Doctor',
		'description' => 'Skin Doctor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	132 => 
	array (
		'name' => 'Skipper',
		'description' => 'Skipper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	133 => 
	array (
		'name' => 'Slate And Tile Roofer',
		'description' => 'Slate And Tile Roofer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	134 => 
	array (
		'name' => 'Slaughterer',
		'description' => 'Slaughterer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	135 => 
	array (
		'name' => 'Sleeping Car Attendant',
		'description' => 'Sleeping Car Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	136 => 
	array (
	'name' => 'Smelting/Metal (Blast Furnace) Furnace-Operator',
	'description' => 'Smelting/Metal (Blast Furnace) Furnace-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	137 => 
	array (
		'name' => 'Smokehouse/Rubber Attendant',
		'description' => 'Smokehouse/Rubber Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	138 => 
	array (
		'name' => 'Smokehouse Stoker',
		'description' => 'Smokehouse Stoker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	139 => 
	array (
		'name' => 'Snack-Bar Manager',
		'description' => 'Snack-Bar Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	140 => 
	array (
		'name' => 'Snake Charmer',
		'description' => 'Snake Charmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	141 => 
	array (
		'name' => 'Snake Farm Worker',
		'description' => 'Snake Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	142 => 
	array (
		'name' => 'Snooker Attendant',
		'description' => 'Snooker Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	143 => 
	array (
		'name' => 'Soap Maker',
		'description' => 'Soap Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	144 => 
	array (
		'name' => 'Social And Economics Data Enumerator',
		'description' => 'Social And Economics Data Enumerator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	145 => 
	array (
		'name' => 'Social Benefits Officer',
		'description' => 'Social Benefits Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	146 => 
	array (
		'name' => 'Social Development S17 Assistant',
		'description' => 'Social Development S17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	147 => 
	array (
		'name' => 'Social Development S27 Ssistant Officer',
		'description' => 'Social Development S27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	148 => 
	array (
		'name' => 'Social Development S41 Officer',
		'description' => 'Social Development S41 Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	149 => 
	array (
		'name' => 'Social Ecologist',
		'description' => 'Social Ecologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	150 => 
	array (
		'name' => 'Social Escort',
		'description' => 'Social Escort',
		'created_at' => $now,
		'updated_at' => $now,
	),
	151 => 
	array (
		'name' => 'Social Pathology Sociologist',
		'description' => 'Social Pathology Sociologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	152 => 
	array (
		'name' => 'Social Researcher N17 Assistant',
		'description' => 'Social Researcher N17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	153 => 
	array (
		'name' => 'Social Research N27 Ssistant Officer',
		'description' => 'Social Research N27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	154 => 
	array (
		'name' => 'Social Research N41 Officer',
		'description' => 'Social Research N41 Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	155 => 
	array (
		'name' => 'Social Science Statistician',
		'description' => 'Social Science Statistician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	156 => 
	array (
		'name' => 'Social Security Claims Appeals Referee',
		'description' => 'Social Security Claims Appeals Referee',
		'created_at' => $now,
		'updated_at' => $now,
	),
	157 => 
	array (
		'name' => 'Social Security Claims Officer',
		'description' => 'Social Security Claims Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	158 => 
	array (
		'name' => 'Social Welfare Worker',
		'description' => 'Social Welfare Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	159 => 
	array (
		'name' => 'Social Worker',
		'description' => 'Social Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	160 => 
	array (
		'name' => 'Social Work Manager',
		'description' => 'Social Work Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	161 => 
	array (
		'name' => 'Sociologist',
		'description' => 'Sociologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	162 => 
	array (
		'name' => 'Soft-Drinks Production Machine Operator',
		'description' => 'Soft-Drinks Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	163 => 
	array (
		'name' => 'Soft Furnishing Maker',
		'description' => 'Soft Furnishing Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	164 => 
	array (
		'name' => 'Software Designer',
		'description' => 'Software Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	165 => 
	array (
		'name' => 'Software Developer',
		'description' => 'Software Developer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	166 => 
	array (
		'name' => 'Software Programmer',
		'description' => 'Software Programmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	167 => 
	array (
		'name' => 'Software Tester',
		'description' => 'Software Tester',
		'created_at' => $now,
		'updated_at' => $now,
	),
	168 => 
	array (
		'name' => 'Soil Bacteriologist',
		'description' => 'Soil Bacteriologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	169 => 
	array (
		'name' => 'Soil Botanist',
		'description' => 'Soil Botanist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	170 => 
	array (
		'name' => 'Soil Conservationist',
		'description' => 'Soil Conservationist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	171 => 
	array (
		'name' => 'Soil Laboratory Assistant',
		'description' => 'Soil Laboratory Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	172 => 
	array (
		'name' => 'Soil Science Technician',
		'description' => 'Soil Science Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	173 => 
	array (
		'name' => 'Soil Scientist',
		'description' => 'Soil Scientist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	174 => 
	array (
		'name' => 'Soil Surveyor',
		'description' => 'Soil Surveyor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	175 => 
	array (
		'name' => 'Soil Technician',
		'description' => 'Soil Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	176 => 
	array (
		'name' => 'Solderer',
		'description' => 'Solderer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	177 => 
	array (
		'name' => 'Solicitor',
		'description' => 'Solicitor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	178 => 
	array (
		'name' => 'Solicitor L41',
		'description' => 'Solicitor L41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	179 => 
	array (
		'name' => 'Solicitor’S Assistant',
		'description' => 'Solicitor’S Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	180 => 
	array (
		'name' => 'Solid-State Physicist',
		'description' => 'Solid-State Physicist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	181 => 
	array (
		'name' => 'Solution Man',
		'description' => 'Solution Man',
		'created_at' => $now,
		'updated_at' => $now,
	),
	182 => 
	array (
		'name' => 'Song Writer',
		'description' => 'Song Writer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	183 => 
	array (
		'name' => 'Sonographer',
		'description' => 'Sonographer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	184 => 
	array (
		'name' => 'Sorter',
		'description' => 'Sorter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	185 => 
	array (
		'name' => 'Sound And Image Operator, Recording Equipment',
		'description' => 'Sound And Image Operator, Recording Equipment',
		'created_at' => $now,
		'updated_at' => $now,
	),
	186 => 
	array (
		'name' => 'Sound Editor',
		'description' => 'Sound Editor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	187 => 
	array (
		'name' => 'Sound-Effects Technician',
		'description' => 'Sound-Effects Technician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	188 => 
	array (
		'name' => 'Sound Mixer',
		'description' => 'Sound Mixer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	189 => 
	array (
		'name' => 'Sound Physicist',
		'description' => 'Sound Physicist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	190 => 
	array (
		'name' => 'Sound-Proofing Insulation Worker',
		'description' => 'Sound-Proofing Insulation Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	191 => 
	array (
		'name' => 'Sound Systems Engineer',
		'description' => 'Sound Systems Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	192 => 
	array (
		'name' => 'Soup Powder Production Machine Operator',
		'description' => 'Soup Powder Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	193 => 
	array (
		'name' => 'Sous Chef',
		'description' => 'Sous Chef',
		'created_at' => $now,
		'updated_at' => $now,
	),
	194 => 
	array (
		'name' => 'Speaker',
		'description' => 'Speaker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	195 => 
	array (
		'name' => 'Special Education/For The Blind Teacher',
		'description' => 'Special Education/For The Blind Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	196 => 
	array (
		'name' => 'Special Education/For The Deaf Teacher',
		'description' => 'Special Education/For The Deaf Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	197 => 
	array (
		'name' => 'Special Education/For The Dumb Teacher',
		'description' => 'Special Education/For The Dumb Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	198 => 
	array (
		'name' => 'Special Education/For The Mentally Handicapped Teacher',
		'description' => 'Special Education/For The Mentally Handicapped Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	199 => 
	array (
		'name' => 'Special Education/For The Physically Handicapped Teacher',
		'description' => 'Special Education/For The Physically Handicapped Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	200 => 
	array (
		'name' => 'Special-Interest Organization Secretary-General',
		'description' => 'Special-Interest Organization Secretary-General',
		'created_at' => $now,
		'updated_at' => $now,
	),
	201 => 
	array (
		'name' => 'Special-Interest Organization Senior Official',
		'description' => 'Special-Interest Organization Senior Official',
		'created_at' => $now,
		'updated_at' => $now,
	),
	202 => 
	array (
		'name' => 'Specialist Graphics And Sound/Computer',
		'description' => 'Specialist Graphics And Sound/Computer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	203 => 
	array (
		'name' => 'Specialized Nurse',
		'description' => 'Specialized Nurse',
		'created_at' => $now,
		'updated_at' => $now,
	),
	204 => 
	array (
		'name' => 'Speech Therapist',
		'description' => 'Speech Therapist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	205 => 
	array (
		'name' => 'Spice Farm Worker',
		'description' => 'Spice Farm Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	206 => 
	array (
		'name' => 'Spice Miller',
		'description' => 'Spice Miller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	207 => 
	array (
		'name' => 'Spice Mixer',
		'description' => 'Spice Mixer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	208 => 
	array (
		'name' => 'Spinning And Winding Machine Operators Other Fibre Preparing',
		'description' => 'Spinning And Winding Machine Operators Other Fibre Preparing',
		'created_at' => $now,
		'updated_at' => $now,
	),
	209 => 
	array (
		'name' => 'Spinning/Metal Machine Operator',
		'description' => 'Spinning/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	210 => 
	array (
		'name' => 'Splicing/Cable And Rope Machine Operator',
		'description' => 'Splicing/Cable And Rope Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	211 => 
	array (
		'name' => 'Splitters And Carvers Other Stonemasons, Stone Cutters',
		'description' => 'Splitters And Carvers Other Stonemasons, Stone Cutters',
		'created_at' => $now,
		'updated_at' => $now,
	),
	212 => 
	array (
		'name' => 'Splitting/Stone Machine Operator',
		'description' => 'Splitting/Stone Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	213 => 
	array (
		'name' => 'Sporting Activities Manager',
		'description' => 'Sporting Activities Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	214 => 
	array (
		'name' => 'Sports Agent',
		'description' => 'Sports Agent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	215 => 
	array (
		'name' => 'Sports And Recreation Manager',
		'description' => 'Sports And Recreation Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	216 => 
	array (
		'name' => 'Sports Attendant',
		'description' => 'Sports Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	217 => 
	array (
		'name' => 'Sports Centre Manager',
		'description' => 'Sports Centre Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	218 => 
	array (
		'name' => 'Sports Coach',
		'description' => 'Sports Coach',
		'created_at' => $now,
		'updated_at' => $now,
	),
	219 => 
	array (
		'name' => 'Sports Equipment/Footwear Maker',
		'description' => 'Sports Equipment/Footwear Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	220 => 
	array (
		'name' => 'Sports Equipment/Metal Machine Operator',
		'description' => 'Sports Equipment/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	221 => 
	array (
		'name' => 'Sports Equipment/Wood Maker',
		'description' => 'Sports Equipment/Wood Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	222 => 
	array (
		'name' => 'Sports/Games Team Manager',
		'description' => 'Sports/Games Team Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	223 => 
	array (
		'name' => 'Sports Manager',
		'description' => 'Sports Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	224 => 
	array (
		'name' => 'Sports Official',
		'description' => 'Sports Official',
		'created_at' => $now,
		'updated_at' => $now,
	),
	225 => 
	array (
		'name' => 'Sportsperson',
		'description' => 'Sportsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	226 => 
	array (
		'name' => 'Sportsperson And Related Associate Professionals Other Athletes',
		'description' => 'Sportsperson And Related Associate Professionals Other Athletes',
		'created_at' => $now,
		'updated_at' => $now,
	),
	227 => 
	array (
		'name' => 'Sports Promoter',
		'description' => 'Sports Promoter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	228 => 
	array (
		'name' => 'Sports Trainer',
		'description' => 'Sports Trainer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	229 => 
	array (
		'name' => 'Spray-Dried/Chemical And Related Processes Operator',
		'description' => 'Spray-Dried/Chemical And Related Processes Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	230 => 
	array (
		'name' => 'Sprayer Worker',
		'description' => 'Sprayer Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	231 => 
	array (
		'name' => 'Spray Painter',
		'description' => 'Spray Painter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	232 => 
	array (
		'name' => 'Sprying/Metal Machine Operator',
		'description' => 'Sprying/Metal Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	233 => 
	array (
		'name' => 'Stadium Manager',
		'description' => 'Stadium Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	234 => 
	array (
		'name' => 'Staff Sergeant',
		'description' => 'Staff Sergeant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	235 => 
	array (
		'name' => 'Staff Training Officer',
		'description' => 'Staff Training Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	236 => 
	array (
		'name' => 'Staff Vocational Training Officer',
		'description' => 'Staff Vocational Training Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	237 => 
	array (
		'name' => 'Stage And Studio Carpenter',
		'description' => 'Stage And Studio Carpenter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	238 => 
	array (
		'name' => 'Stage And Studio Electrician',
		'description' => 'Stage And Studio Electrician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	239 => 
	array (
		'name' => 'Stage Director',
		'description' => 'Stage Director',
		'created_at' => $now,
		'updated_at' => $now,
	),
	240 => 
	array (
		'name' => 'Stage Manager',
		'description' => 'Stage Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	241 => 
	array (
		'name' => 'Stage Producer',
		'description' => 'Stage Producer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	242 => 
	array (
		'name' => 'Staining/Leather Machine Operator',
		'description' => 'Staining/Leather Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	243 => 
	array (
		'name' => 'Stamping/Metal Press-Operator',
		'description' => 'Stamping/Metal Press-Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	244 => 
	array (
		'name' => 'Starching Machine Operator',
		'description' => 'Starching Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	245 => 
	array (
		'name' => 'State Assemblyman',
		'description' => 'State Assemblyman',
		'created_at' => $now,
		'updated_at' => $now,
	),
	246 => 
	array (
		'name' => 'Stationary Engine Operator',
		'description' => 'Stationary Engine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	247 => 
	array (
		'name' => 'Station N19 Manager',
		'description' => 'Station N19 Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	248 => 
	array (
		'name' => 'Statistical Clerk',
		'description' => 'Statistical Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	249 => 
	array (
		'name' => 'Statistical E27 Ssistant Officer',
		'description' => 'Statistical E27 Ssistant Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	250 => 
	array (
		'name' => 'Statistical Officer',
		'description' => 'Statistical Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	251 => 
	array (
		'name' => 'Statistical Typist',
		'description' => 'Statistical Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	252 => 
	array (
		'name' => 'Statistician',
		'description' => 'Statistician',
		'created_at' => $now,
		'updated_at' => $now,
	),
	253 => 
	array (
		'name' => 'Statistician E17 Assistant',
		'description' => 'Statistician E17 Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	254 => 
	array (
		'name' => 'Statistician E41',
		'description' => 'Statistician E41',
		'created_at' => $now,
		'updated_at' => $now,
	),
	255 => 
	array (
		'name' => 'Statistician Superintendent',
		'description' => 'Statistician Superintendent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	256 => 
	array (
		'name' => 'Statutory Board Executive Officer',
		'description' => 'Statutory Board Executive Officer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	257 => 
	array (
		'name' => 'Statutory Board Senior Official',
		'description' => 'Statutory Board Senior Official',
		'created_at' => $now,
		'updated_at' => $now,
	),
	258 => 
	array (
		'name' => 'Steam Engine Operator',
		'description' => 'Steam Engine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	259 => 
	array (
		'name' => 'Steel Bender',
		'description' => 'Steel Bender',
		'created_at' => $now,
		'updated_at' => $now,
	),
	260 => 
	array (
		'name' => 'Steel Continuous-Mill Roller, Steel/Cold-Roller',
		'description' => 'Steel Continuous-Mill Roller, Steel/Cold-Roller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	261 => 
	array (
		'name' => 'Steel Converting Converter Blowing Operator',
		'description' => 'Steel Converting Converter Blowing Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	262 => 
	array (
		'name' => 'Steel Hot-Roller',
		'description' => 'Steel Hot-Roller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	263 => 
	array (
		'name' => 'Steeplejack',
		'description' => 'Steeplejack',
		'created_at' => $now,
		'updated_at' => $now,
	),
	264 => 
	array (
		'name' => 'Stencil/Silk-Screen Cutter',
		'description' => 'Stencil/Silk-Screen Cutter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	265 => 
	array (
		'name' => 'Stenographer',
		'description' => 'Stenographer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	266 => 
	array (
		'name' => 'Stenography Secretary',
		'description' => 'Stenography Secretary',
		'created_at' => $now,
		'updated_at' => $now,
	),
	267 => 
	array (
		'name' => 'Stenography/Typing Secretary',
		'description' => 'Stenography/Typing Secretary',
		'created_at' => $now,
		'updated_at' => $now,
	),
	268 => 
	array (
		'name' => 'Stenography Typist',
		'description' => 'Stenography Typist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	269 => 
	array (
		'name' => 'Stereotyper',
		'description' => 'Stereotyper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	270 => 
	array (
		'name' => 'Sterilizer/Dairy Products Operator',
		'description' => 'Sterilizer/Dairy Products Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	271 => 
	array (
		'name' => 'Sterilizing Oil Palm Attendant',
		'description' => 'Sterilizing Oil Palm Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	272 => 
	array (
		'name' => 'Steroids Biochemist',
		'description' => 'Steroids Biochemist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	273 => 
	array (
		'name' => 'Stevedore',
		'description' => 'Stevedore',
		'created_at' => $now,
		'updated_at' => $now,
	),
	274 => 
	array (
	'name' => 'Still/Batch (Chemical Processes Except Petroleum And Natural Gas) Operator',
	'description' => 'Still/Batch (Chemical Processes Except Petroleum And Natural Gas) Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	275 => 
	array (
		'name' => 'Still/Chemical Processes Operator',
		'description' => 'Still/Chemical Processes Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	276 => 
	array (
	'name' => 'Still/Continuous (Chemical Processes Except Petroleum And Natural Gas) Operator',
	'description' => 'Still/Continuous (Chemical Processes Except Petroleum And Natural Gas) Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	277 => 
	array (
	'name' => 'Stillman (Petroleum Refining)',
	'description' => 'Stillman (Petroleum Refining)',
		'created_at' => $now,
		'updated_at' => $now,
	),
	278 => 
	array (
		'name' => 'Still/Turpentine Operator',
		'description' => 'Still/Turpentine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	279 => 
	array (
		'name' => 'Stock And Shares Broker',
		'description' => 'Stock And Shares Broker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	280 => 
	array (
		'name' => 'Stockbroker Clerk',
		'description' => 'Stockbroker Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	281 => 
	array (
		'name' => 'Stock Clerk',
		'description' => 'Stock Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	282 => 
	array (
		'name' => 'Stock Control Clerk',
		'description' => 'Stock Control Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	283 => 
	array (
		'name' => 'Stock Filler',
		'description' => 'Stock Filler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	284 => 
	array (
		'name' => 'Stock Handler',
		'description' => 'Stock Handler',
		'created_at' => $now,
		'updated_at' => $now,
	),
	285 => 
	array (
		'name' => 'Stock Record Clerk',
		'description' => 'Stock Record Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	286 => 
	array (
		'name' => 'Stone And Other Mineral Products Machine Operators Other Cement',
		'description' => 'Stone And Other Mineral Products Machine Operators Other Cement',
		'created_at' => $now,
		'updated_at' => $now,
	),
	287 => 
	array (
		'name' => 'Stone Articles Handicraft Worker',
		'description' => 'Stone Articles Handicraft Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	288 => 
	array (
		'name' => 'Stone Carver',
		'description' => 'Stone Carver',
		'created_at' => $now,
		'updated_at' => $now,
	),
	289 => 
	array (
		'name' => 'Stone Cutter And Finisher',
		'description' => 'Stone Cutter And Finisher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	290 => 
	array (
		'name' => 'Stone Dresser',
		'description' => 'Stone Dresser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	291 => 
	array (
		'name' => 'Stone Grader',
		'description' => 'Stone Grader',
		'created_at' => $now,
		'updated_at' => $now,
	),
	292 => 
	array (
		'name' => 'Stone Grinder',
		'description' => 'Stone Grinder',
		'created_at' => $now,
		'updated_at' => $now,
	),
	293 => 
	array (
		'name' => 'Stone Polisher',
		'description' => 'Stone Polisher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	294 => 
	array (
		'name' => 'Stone Processing Machine Operator',
		'description' => 'Stone Processing Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	295 => 
	array (
		'name' => 'Stone Sawyer',
		'description' => 'Stone Sawyer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	296 => 
	array (
		'name' => 'Stone Splitter',
		'description' => 'Stone Splitter',
		'created_at' => $now,
		'updated_at' => $now,
	),
	297 => 
	array (
		'name' => 'Stone Worker',
		'description' => 'Stone Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	298 => 
	array (
		'name' => 'Stonework Layout Man',
		'description' => 'Stonework Layout Man',
		'created_at' => $now,
		'updated_at' => $now,
	),
	299 => 
	array (
		'name' => 'Storage Manager',
		'description' => 'Storage Manager',
		'created_at' => $now,
		'updated_at' => $now,
	),
	300 => 
	array (
		'name' => 'Store Assistant',
		'description' => 'Store Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	301 => 
	array (
		'name' => 'Store Attendant',
		'description' => 'Store Attendant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	302 => 
	array (
		'name' => 'Store Cashier',
		'description' => 'Store Cashier',
		'created_at' => $now,
		'updated_at' => $now,
	),
	303 => 
	array (
		'name' => 'Store Clerk',
		'description' => 'Store Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	304 => 
	array (
		'name' => 'Store Controller',
		'description' => 'Store Controller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	305 => 
	array (
		'name' => 'Store Coordinator',
		'description' => 'Store Coordinator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	306 => 
	array (
		'name' => 'Store Detective',
		'description' => 'Store Detective',
		'created_at' => $now,
		'updated_at' => $now,
	),
	307 => 
	array (
		'name' => 'Store Engineering Executive',
		'description' => 'Store Engineering Executive',
		'created_at' => $now,
		'updated_at' => $now,
	),
	308 => 
	array (
		'name' => 'Store Executive',
		'description' => 'Store Executive',
		'created_at' => $now,
		'updated_at' => $now,
	),
	309 => 
	array (
		'name' => 'Store Hand',
		'description' => 'Store Hand',
		'created_at' => $now,
		'updated_at' => $now,
	),
	310 => 
	array (
		'name' => 'Storekeeper',
		'description' => 'Storekeeper',
		'created_at' => $now,
		'updated_at' => $now,
	),
	311 => 
	array (
		'name' => 'Store Operator',
		'description' => 'Store Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	312 => 
	array (
		'name' => 'Store Receiving Assistant',
		'description' => 'Store Receiving Assistant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	313 => 
	array (
		'name' => 'Store Supervisor',
		'description' => 'Store Supervisor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	314 => 
	array (
		'name' => 'Store Worker',
		'description' => 'Store Worker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	315 => 
	array (
		'name' => 'Story Teller',
		'description' => 'Story Teller',
		'created_at' => $now,
		'updated_at' => $now,
	),
	316 => 
	array (
		'name' => 'Stratigraph',
		'description' => 'Stratigraph',
		'created_at' => $now,
		'updated_at' => $now,
	),
	317 => 
	array (
		'name' => 'Stratigraphy Geologist',
		'description' => 'Stratigraphy Geologist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	318 => 
	array (
		'name' => 'Straw Production Machine Operator',
		'description' => 'Straw Production Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	319 => 
	array (
		'name' => 'Street/Food Vendor',
		'description' => 'Street/Food Vendor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	320 => 
	array (
		'name' => 'Street/Non-Food Products Vendor',
		'description' => 'Street/Non-Food Products Vendor',
		'created_at' => $now,
		'updated_at' => $now,
	),
	321 => 
	array (
		'name' => 'Street Stall Salesperson',
		'description' => 'Street Stall Salesperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	322 => 
	array (
		'name' => 'Stringed-Musical Instrument Maker',
		'description' => 'Stringed-Musical Instrument Maker',
		'created_at' => $now,
		'updated_at' => $now,
	),
	323 => 
	array (
		'name' => 'Stripping And Cutting/Wire Machine Operator',
		'description' => 'Stripping And Cutting/Wire Machine Operator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	324 => 
	array (
		'name' => 'Structural Draughtsperson',
		'description' => 'Structural Draughtsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	325 => 
	array (
		'name' => 'Structural Metal Erector',
		'description' => 'Structural Metal Erector',
		'created_at' => $now,
		'updated_at' => $now,
	),

	364 => 
	array (
		'name' => 'Systems Administrator',
		'description' => 'Systems Administrator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	365 => 
	array (
		'name' => 'Systems/Computer Analyst',
		'description' => 'Systems/Computer Analyst',
		'created_at' => $now,
		'updated_at' => $now,
	),
	366 => 
	array (
		'name' => 'Systems Computer Designer',
		'description' => 'Systems Computer Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	367 => 
	array (
		'name' => 'Systems Consultant',
		'description' => 'Systems Consultant',
		'created_at' => $now,
		'updated_at' => $now,
	),
	368 => 
	array (
		'name' => 'Systems Engineer',
		'description' => 'Systems Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	369 => 
	array (
		'name' => 'Systems/Except Computers Analyst',
		'description' => 'Systems/Except Computers Analyst',
		'created_at' => $now,
		'updated_at' => $now,
	),
	370 => 
	array (
		'name' => 'Systems/Except Computers Designer',
		'description' => 'Systems/Except Computers Designer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	371 => 
	array (
		'name' => 'Systems/Except Computers Engineer',
		'description' => 'Systems/Except Computers Engineer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	372 => 
	array (
		'name' => 'Systems Programmer',
		'description' => 'Systems Programmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	373 => 
	array (
		'name' => 'Systems Tester',
		'description' => 'Systems Tester',
		'created_at' => $now,
		'updated_at' => $now,
	),

	403 => 
	array (
		'name' => 'Technical Adviser',
		'description' => 'Technical Adviser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	404 => 
	array (
		'name' => 'Technical Clerk',
		'description' => 'Technical Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),
	405 => 
	array (
		'name' => 'Technical Draughtsperson',
		'description' => 'Technical Draughtsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	406 => 
	array (
		'name' => 'Technical Illustration Draughtsperson',
		'description' => 'Technical Illustration Draughtsperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	407 => 
	array (
		'name' => 'Technical Illustrator',
		'description' => 'Technical Illustrator',
		'created_at' => $now,
		'updated_at' => $now,
	),
	408 => 
	array (
		'name' => 'Technical Information Information Scientist',
		'description' => 'Technical Information Information Scientist',
		'created_at' => $now,
		'updated_at' => $now,
	),
	409 => 
	array (
		'name' => 'Technical Marine Superintendent',
		'description' => 'Technical Marine Superintendent',
		'created_at' => $now,
		'updated_at' => $now,
	),
	410 => 
	array (
		'name' => 'Technical Programmer',
		'description' => 'Technical Programmer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	411 => 
	array (
		'name' => 'Technical Salesperson',
		'description' => 'Technical Salesperson',
		'created_at' => $now,
		'updated_at' => $now,
	),
	412 => 
	array (
		'name' => 'Technical Sales Representatives',
		'description' => 'Technical Sales Representatives',
		'created_at' => $now,
		'updated_at' => $now,
	),
	413 => 
	array (
		'name' => 'Technical Service Adviser',
		'description' => 'Technical Service Adviser',
		'created_at' => $now,
		'updated_at' => $now,
	),
	414 => 
	array (
		'name' => 'Technical Teacher',
		'description' => 'Technical Teacher',
		'created_at' => $now,
		'updated_at' => $now,
	),
	415 => 
	array (
		'name' => 'Technical Writer',
		'description' => 'Technical Writer',
		'created_at' => $now,
		'updated_at' => $now,
	),
	416 => 
	array (
		'name' => 'Technician Clerk',
		'description' => 'Technician Clerk',
		'created_at' => $now,
		'updated_at' => $now,
	),

));
	}

}
