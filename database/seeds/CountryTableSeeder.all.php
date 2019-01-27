<?php

use Illuminate\Database\Seeder;

class CountryTableSeederAll extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('country')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('country')->insert(array (
			0 => 
			array (
				'id' => 1,
				'code' => 'ABW',
				'name' => 'Aruba',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 => 
			array (
				'id' => 2,
				'code' => 'AFG',
				'name' => 'Afghanistan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 => 
			array (
				'id' => 3,
				'code' => 'AGO',
				'name' => 'Angola',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 => 
			array (
				'id' => 4,
				'code' => 'AIA',
				'name' => 'Anguilla',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 => 
			array (
				'id' => 5,
				'code' => 'ALB',
				'name' => 'Albania',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 => 
			array (
				'id' => 6,
				'code' => 'AND',
				'name' => 'Andorra',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 => 
			array (
				'id' => 7,
				'code' => 'ANT',
				'name' => 'Netherlands Antilles',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 => 
			array (
				'id' => 8,
				'code' => 'ARE',
				'name' => 'United Arab Emirates',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 => 
			array (
				'id' => 9,
				'code' => 'ARG',
				'name' => 'Argentina',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 => 
			array (
				'id' => 10,
				'code' => 'ARM',
				'name' => 'Armenia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 => 
			array (
				'id' => 11,
				'code' => 'ASM',
				'name' => 'American Samoa',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 => 
			array (
				'id' => 12,
				'code' => 'ATA',
				'name' => 'Antarctica',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 => 
			array (
				'id' => 13,
				'code' => 'ATF',
				'name' => 'French Southern territories',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 => 
			array (
				'id' => 14,
				'code' => 'ATG',
				'name' => 'Antigua and Barbuda',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 => 
			array (
				'id' => 15,
				'code' => 'AUS',
				'name' => 'Australia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 => 
			array (
				'id' => 16,
				'code' => 'AUT',
				'name' => 'Austria',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 => 
			array (
				'id' => 17,
				'code' => 'AZE',
				'name' => 'Azerbaijan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 => 
			array (
				'id' => 18,
				'code' => 'BDI',
				'name' => 'Burundi',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 => 
			array (
				'id' => 19,
				'code' => 'BEL',
				'name' => 'Belgium',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 => 
			array (
				'id' => 20,
				'code' => 'BEN',
				'name' => 'Benin',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 => 
			array (
				'id' => 21,
				'code' => 'BFA',
				'name' => 'Burkina Faso',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 => 
			array (
				'id' => 22,
				'code' => 'BGD',
				'name' => 'Bangladesh',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 => 
			array (
				'id' => 23,
				'code' => 'BGR',
				'name' => 'Bulgaria',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 => 
			array (
				'id' => 24,
				'code' => 'BHR',
				'name' => 'Bahrain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 => 
			array (
				'id' => 25,
				'code' => 'BHS',
				'name' => 'Bahamas',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 => 
			array (
				'id' => 26,
				'code' => 'BIH',
				'name' => 'Bosnia and Herzegovina',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 => 
			array (
				'id' => 27,
				'code' => 'BLR',
				'name' => 'Belarus',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 => 
			array (
				'id' => 28,
				'code' => 'BLZ',
				'name' => 'Belize',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 => 
			array (
				'id' => 29,
				'code' => 'BMU',
				'name' => 'Bermuda',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 => 
			array (
				'id' => 30,
				'code' => 'BOL',
				'name' => 'Bolivia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 => 
			array (
				'id' => 31,
				'code' => 'BRA',
				'name' => 'Brazil',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 => 
			array (
				'id' => 32,
				'code' => 'BRB',
				'name' => 'Barbados',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 => 
			array (
				'id' => 33,
				'code' => 'BRN',
				'name' => 'Brunei',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 => 
			array (
				'id' => 34,
				'code' => 'BTN',
				'name' => 'Bhutan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 => 
			array (
				'id' => 35,
				'code' => 'BVT',
				'name' => 'Bouvet Island',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 => 
			array (
				'id' => 36,
				'code' => 'BWA',
				'name' => 'Botswana',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 => 
			array (
				'id' => 37,
				'code' => 'CAF',
				'name' => 'Central African Republic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 => 
			array (
				'id' => 38,
				'code' => 'CAN',
				'name' => 'Canada',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 => 
			array (
				'id' => 39,
				'code' => 'CCK',
			'name' => 'Cocos (Keeling) Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 => 
			array (
				'id' => 40,
				'code' => 'CHE',
				'name' => 'Switzerland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 => 
			array (
				'id' => 41,
				'code' => 'CHL',
				'name' => 'Chile',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 => 
			array (
				'id' => 42,
				'code' => 'CHN',
				'name' => 'China',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 => 
			array (
				'id' => 43,
				'code' => 'CIV',
				'name' => 'Côte d’Ivoire',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 => 
			array (
				'id' => 44,
				'code' => 'CMR',
				'name' => 'Cameroon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 => 
			array (
				'id' => 45,
				'code' => 'COD',
				'name' => 'Congo, The Democratic Republic of the',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 => 
			array (
				'id' => 46,
				'code' => 'COG',
				'name' => 'Congo',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 => 
			array (
				'id' => 47,
				'code' => 'COK',
				'name' => 'Cook Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 => 
			array (
				'id' => 48,
				'code' => 'COL',
				'name' => 'Colombia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 => 
			array (
				'id' => 49,
				'code' => 'COM',
				'name' => 'Comoros',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 => 
			array (
				'id' => 50,
				'code' => 'CPV',
				'name' => 'Cape Verde',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 => 
			array (
				'id' => 51,
				'code' => 'CRI',
				'name' => 'Costa Rica',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 => 
			array (
				'id' => 52,
				'code' => 'CUB',
				'name' => 'Cuba',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 => 
			array (
				'id' => 53,
				'code' => 'CXR',
				'name' => 'Christmas Island',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 => 
			array (
				'id' => 54,
				'code' => 'CYM',
				'name' => 'Cayman Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 => 
			array (
				'id' => 55,
				'code' => 'CYP',
				'name' => 'Cyprus',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 => 
			array (
				'id' => 56,
				'code' => 'CZE',
				'name' => 'Czech Republic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 => 
			array (
				'id' => 57,
				'code' => 'DEU',
				'name' => 'Germany',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 => 
			array (
				'id' => 58,
				'code' => 'DJI',
				'name' => 'Djibouti',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 => 
			array (
				'id' => 59,
				'code' => 'DMA',
				'name' => 'Dominica',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 => 
			array (
				'id' => 60,
				'code' => 'DNK',
				'name' => 'Denmark',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 => 
			array (
				'id' => 61,
				'code' => 'DOM',
				'name' => 'Dominican Republic',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 => 
			array (
				'id' => 62,
				'code' => 'DZA',
				'name' => 'Algeria',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 => 
			array (
				'id' => 63,
				'code' => 'ECU',
				'name' => 'Ecuador',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 => 
			array (
				'id' => 64,
				'code' => 'EGY',
				'name' => 'Egypt',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 => 
			array (
				'id' => 65,
				'code' => 'ERI',
				'name' => 'Eritrea',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 => 
			array (
				'id' => 66,
				'code' => 'ESH',
				'name' => 'Western Sahara',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 => 
			array (
				'id' => 67,
				'code' => 'ESP',
				'name' => 'Spain',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 => 
			array (
				'id' => 68,
				'code' => 'EST',
				'name' => 'Estonia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 => 
			array (
				'id' => 69,
				'code' => 'ETH',
				'name' => 'Ethiopia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 => 
			array (
				'id' => 70,
				'code' => 'FIN',
				'name' => 'Finland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 => 
			array (
				'id' => 71,
				'code' => 'FJI',
				'name' => 'Fiji Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 => 
			array (
				'id' => 72,
				'code' => 'FLK',
				'name' => 'Falkland Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 => 
			array (
				'id' => 73,
				'code' => 'FRA',
				'name' => 'France',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 => 
			array (
				'id' => 74,
				'code' => 'FRO',
				'name' => 'Faroe Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 => 
			array (
				'id' => 75,
				'code' => 'FSM',
				'name' => 'Micronesia, Federated States of',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 => 
			array (
				'id' => 76,
				'code' => 'GAB',
				'name' => 'Gabon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 => 
			array (
				'id' => 77,
				'code' => 'GBR',
				'name' => 'United Kingdom',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 => 
			array (
				'id' => 78,
				'code' => 'GEO',
				'name' => 'Georgia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 => 
			array (
				'id' => 79,
				'code' => 'GHA',
				'name' => 'Ghana',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 => 
			array (
				'id' => 80,
				'code' => 'GIB',
				'name' => 'Gibraltar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 => 
			array (
				'id' => 81,
				'code' => 'GIN',
				'name' => 'Guinea',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 => 
			array (
				'id' => 82,
				'code' => 'GLP',
				'name' => 'Guadeloupe',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 => 
			array (
				'id' => 83,
				'code' => 'GMB',
				'name' => 'Gambia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 => 
			array (
				'id' => 84,
				'code' => 'GNB',
				'name' => 'Guinea-Bissau',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 => 
			array (
				'id' => 85,
				'code' => 'GNQ',
				'name' => 'Equatorial Guinea',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 => 
			array (
				'id' => 86,
				'code' => 'GRC',
				'name' => 'Greece',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 => 
			array (
				'id' => 87,
				'code' => 'GRD',
				'name' => 'Grenada',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 => 
			array (
				'id' => 88,
				'code' => 'GRL',
				'name' => 'Greenland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 => 
			array (
				'id' => 89,
				'code' => 'GTM',
				'name' => 'Guatemala',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 => 
			array (
				'id' => 90,
				'code' => 'GUF',
				'name' => 'French Guiana',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 => 
			array (
				'id' => 91,
				'code' => 'GUM',
				'name' => 'Guam',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 => 
			array (
				'id' => 92,
				'code' => 'GUY',
				'name' => 'Guyana',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 => 
			array (
				'id' => 93,
				'code' => 'HKG',
				'name' => 'Hong Kong',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 => 
			array (
				'id' => 94,
				'code' => 'HMD',
				'name' => 'Heard Island and McDonald Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 => 
			array (
				'id' => 95,
				'code' => 'HND',
				'name' => 'Honduras',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 => 
			array (
				'id' => 96,
				'code' => 'HRV',
				'name' => 'Croatia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 => 
			array (
				'id' => 97,
				'code' => 'HTI',
				'name' => 'Haiti',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 => 
			array (
				'id' => 98,
				'code' => 'HUN',
				'name' => 'Hungary',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 => 
			array (
				'id' => 99,
				'code' => 'IDN',
				'name' => 'Indonesia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 => 
			array (
				'id' => 100,
				'code' => 'IND',
				'name' => 'India',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 => 
			array (
				'id' => 101,
				'code' => 'IOT',
				'name' => 'British Indian Ocean Territory',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 => 
			array (
				'id' => 102,
				'code' => 'IRL',
				'name' => 'Ireland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 => 
			array (
				'id' => 103,
				'code' => 'IRN',
				'name' => 'Iran',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 => 
			array (
				'id' => 104,
				'code' => 'IRQ',
				'name' => 'Iraq',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 => 
			array (
				'id' => 105,
				'code' => 'ISL',
				'name' => 'Iceland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 => 
			array (
				'id' => 106,
				'code' => 'ISR',
				'name' => 'Israel',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 => 
			array (
				'id' => 107,
				'code' => 'ITA',
				'name' => 'Italy',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 => 
			array (
				'id' => 108,
				'code' => 'JAM',
				'name' => 'Jamaica',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 => 
			array (
				'id' => 109,
				'code' => 'JOR',
				'name' => 'Jordan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 => 
			array (
				'id' => 110,
				'code' => 'JPN',
				'name' => 'Japan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 => 
			array (
				'id' => 111,
				'code' => 'KAZ',
				'name' => 'Kazakstan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 => 
			array (
				'id' => 112,
				'code' => 'KEN',
				'name' => 'Kenya',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 => 
			array (
				'id' => 113,
				'code' => 'KGZ',
				'name' => 'Kyrgyzstan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 => 
			array (
				'id' => 114,
				'code' => 'KHM',
				'name' => 'Cambodia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 => 
			array (
				'id' => 115,
				'code' => 'KIR',
				'name' => 'Kiribati',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 => 
			array (
				'id' => 116,
				'code' => 'KNA',
				'name' => 'Saint Kitts and Nevis',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 => 
			array (
				'id' => 117,
				'code' => 'KOR',
				'name' => 'South Korea',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 => 
			array (
				'id' => 118,
				'code' => 'KWT',
				'name' => 'Kuwait',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 => 
			array (
				'id' => 119,
				'code' => 'LAO',
				'name' => 'Laos',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 => 
			array (
				'id' => 120,
				'code' => 'LBN',
				'name' => 'Lebanon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 => 
			array (
				'id' => 121,
				'code' => 'LBR',
				'name' => 'Liberia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 => 
			array (
				'id' => 122,
				'code' => 'LBY',
				'name' => 'Libyan Arab Jamahiriya',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 => 
			array (
				'id' => 123,
				'code' => 'LCA',
				'name' => 'Saint Lucia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 => 
			array (
				'id' => 124,
				'code' => 'LIE',
				'name' => 'Liechtenstein',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 => 
			array (
				'id' => 125,
				'code' => 'LKA',
				'name' => 'Sri Lanka',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 => 
			array (
				'id' => 126,
				'code' => 'LSO',
				'name' => 'Lesotho',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 => 
			array (
				'id' => 127,
				'code' => 'LTU',
				'name' => 'Lithuania',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 => 
			array (
				'id' => 128,
				'code' => 'LUX',
				'name' => 'Luxembourg',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 => 
			array (
				'id' => 129,
				'code' => 'LVA',
				'name' => 'Latvia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 => 
			array (
				'id' => 130,
				'code' => 'MAC',
				'name' => 'Macao',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 => 
			array (
				'id' => 131,
				'code' => 'MAR',
				'name' => 'Morocco',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 => 
			array (
				'id' => 132,
				'code' => 'MCO',
				'name' => 'Monaco',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 => 
			array (
				'id' => 133,
				'code' => 'MDA',
				'name' => 'Moldova',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 => 
			array (
				'id' => 134,
				'code' => 'MDG',
				'name' => 'Madagascar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 => 
			array (
				'id' => 135,
				'code' => 'MDV',
				'name' => 'Maldives',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 => 
			array (
				'id' => 136,
				'code' => 'MEX',
				'name' => 'Mexico',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 => 
			array (
				'id' => 137,
				'code' => 'MHL',
				'name' => 'Marshall Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 => 
			array (
				'id' => 138,
				'code' => 'MKD',
				'name' => 'Macedonia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 => 
			array (
				'id' => 139,
				'code' => 'MLI',
				'name' => 'Mali',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 => 
			array (
				'id' => 140,
				'code' => 'MLT',
				'name' => 'Malta',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 => 
			array (
				'id' => 141,
				'code' => 'MMR',
				'name' => 'Myanmar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 => 
			array (
				'id' => 142,
				'code' => 'MNG',
				'name' => 'Mongolia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 => 
			array (
				'id' => 143,
				'code' => 'MNP',
				'name' => 'Northern Mariana Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 => 
			array (
				'id' => 144,
				'code' => 'MOZ',
				'name' => 'Mozambique',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 => 
			array (
				'id' => 145,
				'code' => 'MRT',
				'name' => 'Mauritania',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 => 
			array (
				'id' => 146,
				'code' => 'MSR',
				'name' => 'Montserrat',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 => 
			array (
				'id' => 147,
				'code' => 'MTQ',
				'name' => 'Martinique',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 => 
			array (
				'id' => 148,
				'code' => 'MUS',
				'name' => 'Mauritius',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 => 
			array (
				'id' => 149,
				'code' => 'MWI',
				'name' => 'Malawi',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 => 
			array (
				'id' => 150,
				'code' => 'MYS',
				'name' => 'Malaysia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 => 
			array (
				'id' => 151,
				'code' => 'MYT',
				'name' => 'Mayotte',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 => 
			array (
				'id' => 152,
				'code' => 'NAM',
				'name' => 'Namibia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 => 
			array (
				'id' => 153,
				'code' => 'NCL',
				'name' => 'New Caledonia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 => 
			array (
				'id' => 154,
				'code' => 'NER',
				'name' => 'Niger',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 => 
			array (
				'id' => 155,
				'code' => 'NFK',
				'name' => 'Norfolk Island',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 => 
			array (
				'id' => 156,
				'code' => 'NGA',
				'name' => 'Nigeria',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 => 
			array (
				'id' => 157,
				'code' => 'NIC',
				'name' => 'Nicaragua',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 => 
			array (
				'id' => 158,
				'code' => 'NIU',
				'name' => 'Niue',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 => 
			array (
				'id' => 159,
				'code' => 'NLD',
				'name' => 'Netherlands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 => 
			array (
				'id' => 160,
				'code' => 'NOR',
				'name' => 'Norway',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 => 
			array (
				'id' => 161,
				'code' => 'NPL',
				'name' => 'Nepal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 => 
			array (
				'id' => 162,
				'code' => 'NRU',
				'name' => 'Nauru',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 => 
			array (
				'id' => 163,
				'code' => 'NZL',
				'name' => 'New Zealand',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 => 
			array (
				'id' => 164,
				'code' => 'OMN',
				'name' => 'Oman',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 => 
			array (
				'id' => 165,
				'code' => 'PAK',
				'name' => 'Pakistan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 => 
			array (
				'id' => 166,
				'code' => 'PAN',
				'name' => 'Panama',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 => 
			array (
				'id' => 167,
				'code' => 'PCN',
				'name' => 'Pitcairn',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 => 
			array (
				'id' => 168,
				'code' => 'PER',
				'name' => 'Peru',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 => 
			array (
				'id' => 169,
				'code' => 'PHL',
				'name' => 'Philippines',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 => 
			array (
				'id' => 170,
				'code' => 'PLW',
				'name' => 'Palau',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 => 
			array (
				'id' => 171,
				'code' => 'PNG',
				'name' => 'Papua New Guinea',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 => 
			array (
				'id' => 172,
				'code' => 'POL',
				'name' => 'Poland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 => 
			array (
				'id' => 173,
				'code' => 'PRI',
				'name' => 'Puerto Rico',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 => 
			array (
				'id' => 174,
				'code' => 'PRK',
				'name' => 'North Korea',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 => 
			array (
				'id' => 175,
				'code' => 'PRT',
				'name' => 'Portugal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 => 
			array (
				'id' => 176,
				'code' => 'PRY',
				'name' => 'Paraguay',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 => 
			array (
				'id' => 177,
				'code' => 'PSE',
				'name' => 'Palestine',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 => 
			array (
				'id' => 178,
				'code' => 'PYF',
				'name' => 'French Polynesia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 => 
			array (
				'id' => 179,
				'code' => 'QAT',
				'name' => 'Qatar',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 => 
			array (
				'id' => 180,
				'code' => 'REU',
				'name' => 'Réunion',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 => 
			array (
				'id' => 181,
				'code' => 'ROM',
				'name' => 'Romania',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 => 
			array (
				'id' => 182,
				'code' => 'RUS',
				'name' => 'Russian Federation',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 => 
			array (
				'id' => 183,
				'code' => 'RWA',
				'name' => 'Rwanda',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 => 
			array (
				'id' => 184,
				'code' => 'SAU',
				'name' => 'Saudi Arabia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 => 
			array (
				'id' => 185,
				'code' => 'SDN',
				'name' => 'Sudan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 => 
			array (
				'id' => 186,
				'code' => 'SEN',
				'name' => 'Senegal',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 => 
			array (
				'id' => 187,
				'code' => 'SGP',
				'name' => 'Singapore',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 => 
			array (
				'id' => 188,
				'code' => 'SGS',
				'name' => 'South Georgia and the South Sandwich Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 => 
			array (
				'id' => 189,
				'code' => 'SHN',
				'name' => 'Saint Helena',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 => 
			array (
				'id' => 190,
				'code' => 'SJM',
				'name' => 'Svalbard and Jan Mayen',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 => 
			array (
				'id' => 191,
				'code' => 'SLB',
				'name' => 'Solomon Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 => 
			array (
				'id' => 192,
				'code' => 'SLE',
				'name' => 'Sierra Leone',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 => 
			array (
				'id' => 193,
				'code' => 'SLV',
				'name' => 'El Salvador',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 => 
			array (
				'id' => 194,
				'code' => 'SMR',
				'name' => 'San Marino',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 => 
			array (
				'id' => 195,
				'code' => 'SOM',
				'name' => 'Somalia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 => 
			array (
				'id' => 196,
				'code' => 'SPM',
				'name' => 'Saint Pierre and Miquelon',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 => 
			array (
				'id' => 197,
				'code' => 'STP',
				'name' => 'Sao Tome and Principe',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 => 
			array (
				'id' => 198,
				'code' => 'SUR',
				'name' => 'Suriname',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 => 
			array (
				'id' => 199,
				'code' => 'SVK',
				'name' => 'Slovakia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 => 
			array (
				'id' => 200,
				'code' => 'SVN',
				'name' => 'Slovenia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 => 
			array (
				'id' => 201,
				'code' => 'SWE',
				'name' => 'Sweden',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 => 
			array (
				'id' => 202,
				'code' => 'SWZ',
				'name' => 'Swaziland',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 => 
			array (
				'id' => 203,
				'code' => 'SYC',
				'name' => 'Seychelles',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 => 
			array (
				'id' => 204,
				'code' => 'SYR',
				'name' => 'Syria',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 => 
			array (
				'id' => 205,
				'code' => 'TCA',
				'name' => 'Turks and Caicos Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 => 
			array (
				'id' => 206,
				'code' => 'TCD',
				'name' => 'Chad',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 => 
			array (
				'id' => 207,
				'code' => 'TGO',
				'name' => 'Togo',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 => 
			array (
				'id' => 208,
				'code' => 'THA',
				'name' => 'Thailand',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 => 
			array (
				'id' => 209,
				'code' => 'TJK',
				'name' => 'Tajikistan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 => 
			array (
				'id' => 210,
				'code' => 'TKL',
				'name' => 'Tokelau',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 => 
			array (
				'id' => 211,
				'code' => 'TKM',
				'name' => 'Turkmenistan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 => 
			array (
				'id' => 212,
				'code' => 'TMP',
				'name' => 'East Timor',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 => 
			array (
				'id' => 213,
				'code' => 'TON',
				'name' => 'Tonga',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 => 
			array (
				'id' => 214,
				'code' => 'TTO',
				'name' => 'Trinidad and Tobago',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 => 
			array (
				'id' => 215,
				'code' => 'TUN',
				'name' => 'Tunisia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 => 
			array (
				'id' => 216,
				'code' => 'TUR',
				'name' => 'Turkey',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 => 
			array (
				'id' => 217,
				'code' => 'TUV',
				'name' => 'Tuvalu',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 => 
			array (
				'id' => 218,
				'code' => 'TWN',
				'name' => 'Taiwan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 => 
			array (
				'id' => 219,
				'code' => 'TZA',
				'name' => 'Tanzania',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 => 
			array (
				'id' => 220,
				'code' => 'UGA',
				'name' => 'Uganda',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 => 
			array (
				'id' => 221,
				'code' => 'UKR',
				'name' => 'Ukraine',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 => 
			array (
				'id' => 222,
				'code' => 'UMI',
				'name' => 'United States Minor Outlying Islands',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 => 
			array (
				'id' => 223,
				'code' => 'URY',
				'name' => 'Uruguay',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 => 
			array (
				'id' => 224,
				'code' => 'USA',
				'name' => 'United States',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 => 
			array (
				'id' => 225,
				'code' => 'UZB',
				'name' => 'Uzbekistan',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 => 
			array (
				'id' => 226,
				'code' => 'VAT',
			'name' => 'Holy See (Vatican City State)',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 => 
			array (
				'id' => 227,
				'code' => 'VCT',
				'name' => 'Saint Vincent and the Grenadines',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 => 
			array (
				'id' => 228,
				'code' => 'VEN',
				'name' => 'Venezuela',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 => 
			array (
				'id' => 229,
				'code' => 'VGB',
				'name' => 'Virgin Islands, British',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 => 
			array (
				'id' => 230,
				'code' => 'VIR',
				'name' => 'Virgin Islands, U.S.',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 => 
			array (
				'id' => 231,
				'code' => 'VNM',
				'name' => 'Vietnam',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 => 
			array (
				'id' => 232,
				'code' => 'VUT',
				'name' => 'Vanuatu',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 => 
			array (
				'id' => 233,
				'code' => 'WLF',
				'name' => 'Wallis and Futuna',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 => 
			array (
				'id' => 234,
				'code' => 'WSM',
				'name' => 'Samoa',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 => 
			array (
				'id' => 235,
				'code' => 'YEM',
				'name' => 'Yemen',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 => 
			array (
				'id' => 236,
				'code' => 'YUG',
				'name' => 'Yugoslavia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 => 
			array (
				'id' => 237,
				'code' => 'ZAF',
				'name' => 'South Africa',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 => 
			array (
				'id' => 238,
				'code' => 'ZMB',
				'name' => 'Zambia',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 => 
			array (
				'id' => 239,
				'code' => 'ZWE',
				'name' => 'Zimbabwe',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
	}

}
