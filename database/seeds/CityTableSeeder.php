<?php

use Illuminate\Database\Seeder;

class CityTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('city')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 1,
				'name' => 'Kabul',
				'state_code' => '',
				'country_code' => 'AFG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 2,
				'name' => 'Qandahar',
				'state_code' => '',
				'country_code' => 'AFG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 3,
				'name' => 'Herat',
				'state_code' => '',
				'country_code' => 'AFG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 4,
				'name' => 'Mazar-e-Sharif',
				'state_code' => '',
				'country_code' => 'AFG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 5,
				'name' => 'Amsterdam',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 6,
				'name' => 'Rotterdam',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 7,
				'name' => 'Haag',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 8,
				'name' => 'Utrecht',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 9,
				'name' => 'Eindhoven',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 10,
				'name' => 'Tilburg',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 11,
				'name' => 'Groningen',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 12,
				'name' => 'Breda',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 13,
				'name' => 'Apeldoorn',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 14,
				'name' => 'Nijmegen',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 15,
				'name' => 'Enschede',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 16,
				'name' => 'Haarlem',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 17,
				'name' => 'Almere',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 18,
				'name' => 'Arnhem',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 19,
				'name' => 'Zaanstad',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 20,
				'name' => '´s-Hertogenbosch',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 21,
				'name' => 'Amersfoort',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 22,
				'name' => 'Maastricht',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 23,
				'name' => 'Dordrecht',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 24,
				'name' => 'Leiden',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 25,
				'name' => 'Haarlemmermeer',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 26,
				'name' => 'Zoetermeer',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 27,
				'name' => 'Emmen',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 28,
				'name' => 'Zwolle',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 29,
				'name' => 'Ede',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 30,
				'name' => 'Delft',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 31,
				'name' => 'Heerlen',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 32,
				'name' => 'Alkmaar',
				'state_code' => '',
				'country_code' => 'NLD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 33,
				'name' => 'Willemstad',
				'state_code' => '',
				'country_code' => 'ANT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 34,
				'name' => 'Tirana',
				'state_code' => '',
				'country_code' => 'ALB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 35,
				'name' => 'Alger',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 36,
				'name' => 'Oran',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 37,
				'name' => 'Constantine',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 38,
				'name' => 'Annaba',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 39,
				'name' => 'Batna',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 40,
				'name' => 'Sétif',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 41,
				'name' => 'Sidi Bel Abbès',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 42,
				'name' => 'Skikda',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 43,
				'name' => 'Biskra',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 44,
			'name' => 'Blida (el-Boulaida)',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 45,
				'name' => 'Béjaïa',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 46,
				'name' => 'Mostaganem',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 47,
				'name' => 'Tébessa',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 48,
			'name' => 'Tlemcen (Tilimsen)',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 49,
				'name' => 'Béchar',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 50,
				'name' => 'Tiaret',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 51,
			'name' => 'Ech-Chleff (el-Asnam)',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 52,
				'name' => 'Ghardaïa',
				'state_code' => '',
				'country_code' => 'DZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 53,
				'name' => 'Tafuna',
				'state_code' => '',
				'country_code' => 'ASM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 54,
				'name' => 'Fagatogo',
				'state_code' => '',
				'country_code' => 'ASM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 55,
				'name' => 'Andorra la Vella',
				'state_code' => '',
				'country_code' => 'AND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 56,
				'name' => 'Luanda',
				'state_code' => '',
				'country_code' => 'AGO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 57,
				'name' => 'Huambo',
				'state_code' => '',
				'country_code' => 'AGO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 58,
				'name' => 'Lobito',
				'state_code' => '',
				'country_code' => 'AGO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 59,
				'name' => 'Benguela',
				'state_code' => '',
				'country_code' => 'AGO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 60,
				'name' => 'Namibe',
				'state_code' => '',
				'country_code' => 'AGO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 61,
				'name' => 'South Hill',
				'state_code' => '',
				'country_code' => 'AIA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 62,
				'name' => 'The Valley',
				'state_code' => '',
				'country_code' => 'AIA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 63,
				'name' => 'Saint John´s',
				'state_code' => '',
				'country_code' => 'ATG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 64,
				'name' => 'Dubai',
				'state_code' => '',
				'country_code' => 'ARE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 65,
				'name' => 'Abu Dhabi',
				'state_code' => '',
				'country_code' => 'ARE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 66,
				'name' => 'Sharja',
				'state_code' => '',
				'country_code' => 'ARE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 67,
				'name' => 'al-Ayn',
				'state_code' => '',
				'country_code' => 'ARE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 68,
				'name' => 'Ajman',
				'state_code' => '',
				'country_code' => 'ARE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 69,
				'name' => 'Buenos Aires',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 70,
				'name' => 'La Matanza',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 71,
				'name' => 'Córdoba',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 72,
				'name' => 'Rosario',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 73,
				'name' => 'Lomas de Zamora',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 74,
				'name' => 'Quilmes',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 75,
				'name' => 'Almirante Brown',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 76,
				'name' => 'La Plata',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 77,
				'name' => 'Mar del Plata',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 78,
				'name' => 'San Miguel de Tucumán',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 79,
				'name' => 'Lanús',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 80,
				'name' => 'Merlo',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 81,
				'name' => 'General San Martín',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 82,
				'name' => 'Salta',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 83,
				'name' => 'Moreno',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 84,
				'name' => 'Santa Fé',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 85,
				'name' => 'Avellaneda',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 86,
				'name' => 'Tres de Febrero',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 87,
				'name' => 'Morón',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 88,
				'name' => 'Florencio Varela',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 89,
				'name' => 'San Isidro',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 90,
				'name' => 'Tigre',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 91,
				'name' => 'Malvinas Argentinas',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 92,
				'name' => 'Vicente López',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 93,
				'name' => 'Berazategui',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 94,
				'name' => 'Corrientes',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 95,
				'name' => 'San Miguel',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 96,
				'name' => 'Bahía Blanca',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 97,
				'name' => 'Esteban Echeverría',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 98,
				'name' => 'Resistencia',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 99,
				'name' => 'José C. Paz',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 100,
				'name' => 'Paraná',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 101,
				'name' => 'Godoy Cruz',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 102,
				'name' => 'Posadas',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 103,
				'name' => 'Guaymallén',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 104,
				'name' => 'Santiago del Estero',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 105,
				'name' => 'San Salvador de Jujuy',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 106,
				'name' => 'Hurlingham',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 107,
				'name' => 'Neuquén',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 108,
				'name' => 'Ituzaingó',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 109,
				'name' => 'San Fernando',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 110,
				'name' => 'Formosa',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 111,
				'name' => 'Las Heras',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 112,
				'name' => 'La Rioja',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 113,
				'name' => 'San Fernando del Valle de Cata',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 114,
				'name' => 'Río Cuarto',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 115,
				'name' => 'Comodoro Rivadavia',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 116,
				'name' => 'Mendoza',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 117,
				'name' => 'San Nicolás de los Arroyos',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 118,
				'name' => 'San Juan',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 119,
				'name' => 'Escobar',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 120,
				'name' => 'Concordia',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 121,
				'name' => 'Pilar',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 122,
				'name' => 'San Luis',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 123,
				'name' => 'Ezeiza',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 124,
				'name' => 'San Rafael',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 125,
				'name' => 'Tandil',
				'state_code' => '',
				'country_code' => 'ARG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 126,
				'name' => 'Yerevan',
				'state_code' => '',
				'country_code' => 'ARM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 127,
				'name' => 'Gjumri',
				'state_code' => '',
				'country_code' => 'ARM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 128,
				'name' => 'Vanadzor',
				'state_code' => '',
				'country_code' => 'ARM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 129,
				'name' => 'Oranjestad',
				'state_code' => '',
				'country_code' => 'ABW',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 130,
				'name' => 'Sydney',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 131,
				'name' => 'Melbourne',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 132,
				'name' => 'Brisbane',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 133,
				'name' => 'Perth',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 134,
				'name' => 'Adelaide',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 135,
				'name' => 'Canberra',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 136,
				'name' => 'Gold Coast',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 137,
				'name' => 'Newcastle',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 138,
				'name' => 'Central Coast',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 139,
				'name' => 'Wollongong',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 140,
				'name' => 'Hobart',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 141,
				'name' => 'Geelong',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 142,
				'name' => 'Townsville',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 143,
				'name' => 'Cairns',
				'state_code' => '',
				'country_code' => 'AUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 144,
				'name' => 'Baku',
				'state_code' => '',
				'country_code' => 'AZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 145,
				'name' => 'Gäncä',
				'state_code' => '',
				'country_code' => 'AZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 146,
				'name' => 'Sumqayit',
				'state_code' => '',
				'country_code' => 'AZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 147,
				'name' => 'Mingäçevir',
				'state_code' => '',
				'country_code' => 'AZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 148,
				'name' => 'Nassau',
				'state_code' => '',
				'country_code' => 'BHS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 149,
				'name' => 'al-Manama',
				'state_code' => '',
				'country_code' => 'BHR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 150,
				'name' => 'Dhaka',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 151,
				'name' => 'Chittagong',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 152,
				'name' => 'Khulna',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 153,
				'name' => 'Rajshahi',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 154,
				'name' => 'Narayanganj',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 155,
				'name' => 'Rangpur',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 156,
				'name' => 'Mymensingh',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 157,
				'name' => 'Barisal',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 158,
				'name' => 'Tungi',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 159,
				'name' => 'Jessore',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 160,
				'name' => 'Comilla',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 161,
				'name' => 'Nawabganj',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 162,
				'name' => 'Dinajpur',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 163,
				'name' => 'Bogra',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 164,
				'name' => 'Sylhet',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 165,
				'name' => 'Brahmanbaria',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 166,
				'name' => 'Tangail',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 167,
				'name' => 'Jamalpur',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 168,
				'name' => 'Pabna',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 169,
				'name' => 'Naogaon',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 170,
				'name' => 'Sirajganj',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 171,
				'name' => 'Narsinghdi',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 172,
				'name' => 'Saidpur',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 173,
				'name' => 'Gazipur',
				'state_code' => '',
				'country_code' => 'BGD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 174,
				'name' => 'Bridgetown',
				'state_code' => '',
				'country_code' => 'BRB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 175,
				'name' => 'Antwerpen',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 176,
				'name' => 'Gent',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 177,
				'name' => 'Charleroi',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 178,
				'name' => 'Liège',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 179,
				'name' => 'Bruxelles [Brussel]',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 180,
				'name' => 'Brugge',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 181,
				'name' => 'Schaerbeek',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 182,
				'name' => 'Namur',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 183,
				'name' => 'Mons',
				'state_code' => '',
				'country_code' => 'BEL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 184,
				'name' => 'Belize City',
				'state_code' => '',
				'country_code' => 'BLZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 185,
				'name' => 'Belmopan',
				'state_code' => '',
				'country_code' => 'BLZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 186,
				'name' => 'Cotonou',
				'state_code' => '',
				'country_code' => 'BEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 187,
				'name' => 'Porto-Novo',
				'state_code' => '',
				'country_code' => 'BEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 188,
				'name' => 'Djougou',
				'state_code' => '',
				'country_code' => 'BEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 189,
				'name' => 'Parakou',
				'state_code' => '',
				'country_code' => 'BEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 190,
				'name' => 'Saint George',
				'state_code' => '',
				'country_code' => 'BMU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 191,
				'name' => 'Hamilton',
				'state_code' => '',
				'country_code' => 'BMU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 192,
				'name' => 'Thimphu',
				'state_code' => '',
				'country_code' => 'BTN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 193,
				'name' => 'Santa Cruz de la Sierra',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 194,
				'name' => 'La Paz',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 195,
				'name' => 'El Alto',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 196,
				'name' => 'Cochabamba',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 197,
				'name' => 'Oruro',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 198,
				'name' => 'Sucre',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 199,
				'name' => 'Potosí',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 200,
				'name' => 'Tarija',
				'state_code' => '',
				'country_code' => 'BOL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 201,
				'name' => 'Sarajevo',
				'state_code' => '',
				'country_code' => 'BIH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 202,
				'name' => 'Banja Luka',
				'state_code' => '',
				'country_code' => 'BIH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 203,
				'name' => 'Zenica',
				'state_code' => '',
				'country_code' => 'BIH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 204,
				'name' => 'Gaborone',
				'state_code' => '',
				'country_code' => 'BWA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 205,
				'name' => 'Francistown',
				'state_code' => '',
				'country_code' => 'BWA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 206,
				'name' => 'São Paulo',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 207,
				'name' => 'Rio de Janeiro',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 208,
				'name' => 'Salvador',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 209,
				'name' => 'Belo Horizonte',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 210,
				'name' => 'Fortaleza',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 211,
				'name' => 'Brasília',
				'state_code' => 'BR07',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 212,
				'name' => 'Curitiba',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 213,
				'name' => 'Recife',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 214,
				'name' => 'Porto Alegre',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 215,
				'name' => 'Manaus',
				'state_code' => 'BR04',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 216,
				'name' => 'Belém',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 217,
				'name' => 'Guarulhos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 218,
				'name' => 'Goiânia',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 219,
				'name' => 'Campinas',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 220,
				'name' => 'São Gonçalo',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 221,
				'name' => 'Nova Iguaçu',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 222,
				'name' => 'São Luís',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 223,
				'name' => 'Maceió',
				'state_code' => 'BR02',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 224,
				'name' => 'Duque de Caxias',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 225,
				'name' => 'São Bernardo do Campo',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 226,
				'name' => 'Teresina',
				'state_code' => 'BR20',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 227,
				'name' => 'Natal',
				'state_code' => 'BR22',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 228,
				'name' => 'Osasco',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 229,
				'name' => 'Campo Grande',
				'state_code' => 'BR11',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 230,
				'name' => 'Santo André',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 231,
				'name' => 'João Pessoa',
				'state_code' => 'BR17',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 232,
				'name' => 'Jaboatão dos Guararapes',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 233,
				'name' => 'Contagem',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 234,
				'name' => 'São José dos Campos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 235,
				'name' => 'Uberlândia',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 236,
				'name' => 'Feira de Santana',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 237,
				'name' => 'Ribeirão Preto',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 238,
				'name' => 'Sorocaba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 239,
				'name' => 'Niterói',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 240,
				'name' => 'Cuiabá',
				'state_code' => 'BR14',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 241,
				'name' => 'Juiz de Fora',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 242,
				'name' => 'Aracaju',
				'state_code' => 'BR28',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 243,
				'name' => 'São João de Meriti',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 244,
				'name' => 'Londrina',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 245,
				'name' => 'Joinville',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 246,
				'name' => 'Belford Roxo',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 247,
				'name' => 'Santos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 248,
				'name' => 'Ananindeua',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 249,
				'name' => 'Campos dos Goytacazes',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 250,
				'name' => 'Mauá',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 251,
				'name' => 'Carapicuíba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 252,
				'name' => 'Olinda',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 253,
				'name' => 'Campina Grande',
				'state_code' => 'BR17',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 254,
				'name' => 'São José do Rio Preto',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 255,
				'name' => 'Caxias do Sul',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 256,
				'name' => 'Moji das Cruzes',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 257,
				'name' => 'Diadema',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 258,
				'name' => 'Aparecida de Goiânia',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 259,
				'name' => 'Piracicaba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 260,
				'name' => 'Cariacica',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 261,
				'name' => 'Vila Velha',
				'state_code' => 'BR08',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 262,
				'name' => 'Pelotas',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 263,
				'name' => 'Bauru',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 264,
				'name' => 'Porto Velho',
				'state_code' => 'BR24',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 265,
				'name' => 'Serra',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 266,
				'name' => 'Betim',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 267,
				'name' => 'Jundíaí',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 268,
				'name' => 'Canoas',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 269,
				'name' => 'Franca',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 270,
				'name' => 'São Vicente',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 271,
				'name' => 'Maringá',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 272,
				'name' => 'Montes Claros',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 273,
				'name' => 'Anápolis',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 274,
				'name' => 'Florianópolis',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 275,
				'name' => 'Petrópolis',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 276,
				'name' => 'Itaquaquecetuba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 277,
				'name' => 'Vitória',
				'state_code' => 'BR08',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 278,
				'name' => 'Ponta Grossa',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 279,
				'name' => 'Rio Branco',
				'state_code' => 'BR01',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 280,
				'name' => 'Foz do Iguaçu',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 281,
				'name' => 'Macapá',
				'state_code' => 'BR03',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 282,
				'name' => 'Ilhéus',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 283,
				'name' => 'Vitória da Conquista',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 284,
				'name' => 'Uberaba',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 285,
				'name' => 'Paulista',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 286,
				'name' => 'Limeira',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 287,
				'name' => 'Blumenau',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 288,
				'name' => 'Caruaru',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 289,
				'name' => 'Santarém',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 290,
				'name' => 'Volta Redonda',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 291,
				'name' => 'Novo Hamburgo',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 292,
				'name' => 'Caucaia',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 293,
				'name' => 'Santa Maria',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 294,
				'name' => 'Cascavel',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 295,
				'name' => 'Guarujá',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 296,
				'name' => 'Ribeirão das Neves',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 297,
				'name' => 'Governador Valadares',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 298,
				'name' => 'Taubaté',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 299,
				'name' => 'Imperatriz',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 300,
				'name' => 'Gravataí',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 301,
				'name' => 'Embu',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 302,
				'name' => 'Mossoró',
				'state_code' => 'BR22',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 303,
				'name' => 'Várzea Grande',
				'state_code' => 'BR14',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 304,
				'name' => 'Petrolina',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 305,
				'name' => 'Barueri',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 306,
				'name' => 'Viamão',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 307,
				'name' => 'Ipatinga',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 308,
				'name' => 'Juazeiro',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 309,
				'name' => 'Juazeiro do Norte',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 310,
				'name' => 'Taboão da Serra',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 311,
				'name' => 'São José dos Pinhais',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 312,
				'name' => 'Magé',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 313,
				'name' => 'Suzano',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 314,
				'name' => 'São Leopoldo',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 315,
				'name' => 'Marília',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 316,
				'name' => 'São Carlos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 317,
				'name' => 'Sumaré',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 318,
				'name' => 'Presidente Prudente',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 319,
				'name' => 'Divinópolis',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 320,
				'name' => 'Sete Lagoas',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 321,
				'name' => 'Rio Grande',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 322,
				'name' => 'Itabuna',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 323,
				'name' => 'Jequié',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 324,
				'name' => 'Arapiraca',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 325,
				'name' => 'Colombo',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 326,
				'name' => 'Americana',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 327,
				'name' => 'Alvorada',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 328,
				'name' => 'Araraquara',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 329,
				'name' => 'Itaboraí',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 330,
				'name' => 'Santa Bárbara d´Oeste',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 331,
				'name' => 'Nova Friburgo',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 332,
				'name' => 'Jacareí',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 333,
				'name' => 'Araçatuba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 334,
				'name' => 'Barra Mansa',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 335,
				'name' => 'Praia Grande',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 336,
				'name' => 'Marabá',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 337,
				'name' => 'Criciúma',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 338,
				'name' => 'Boa Vista',
				'state_code' => 'BR25',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 339,
				'name' => 'Passo Fundo',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 340,
				'name' => 'Dourados',
				'state_code' => 'BR11',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 341,
				'name' => 'Santa Luzia',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 342,
				'name' => 'Rio Claro',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 343,
				'name' => 'Maracanaú',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 344,
				'name' => 'Guarapuava',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 345,
				'name' => 'Rondonópolis',
				'state_code' => 'BR14',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 346,
				'name' => 'São José',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 347,
				'name' => 'Cachoeiro de Itapemirim',
				'state_code' => 'BR08',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 348,
				'name' => 'Nilópolis',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 349,
				'name' => 'Itapevi',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 350,
				'name' => 'Cabo de Santo Agostinho',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 351,
				'name' => 'Camaçari',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 352,
				'name' => 'Sobral',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 353,
				'name' => 'Itajaí',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 354,
				'name' => 'Chapecó',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 355,
				'name' => 'Cotia',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 356,
				'name' => 'Lages',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 357,
				'name' => 'Ferraz de Vasconcelos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 358,
				'name' => 'Indaiatuba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 359,
				'name' => 'Hortolândia',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 360,
				'name' => 'Caxias',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 361,
				'name' => 'São Caetano do Sul',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 362,
				'name' => 'Itu',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 363,
				'name' => 'Nossa Senhora do Socorro',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 364,
				'name' => 'Parnaíba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 365,
				'name' => 'Poços de Caldas',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 366,
				'name' => 'Teresópolis',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 367,
				'name' => 'Barreiras',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 368,
				'name' => 'Castanhal',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 369,
				'name' => 'Alagoinhas',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 370,
				'name' => 'Itapecerica da Serra',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 371,
				'name' => 'Uruguaiana',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 372,
				'name' => 'Paranaguá',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 373,
				'name' => 'Ibirité',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 374,
				'name' => 'Timon',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 375,
				'name' => 'Luziânia',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 376,
				'name' => 'Macaé',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 377,
				'name' => 'Teófilo Otoni',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 378,
				'name' => 'Moji-Guaçu',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 379,
				'name' => 'Palmas',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 380,
				'name' => 'Pindamonhangaba',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 381,
				'name' => 'Francisco Morato',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 382,
				'name' => 'Bagé',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 383,
				'name' => 'Sapucaia do Sul',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 384,
				'name' => 'Cabo Frio',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 385,
				'name' => 'Itapetininga',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 386,
				'name' => 'Patos de Minas',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 387,
				'name' => 'Camaragibe',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 388,
				'name' => 'Bragança Paulista',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 389,
				'name' => 'Queimados',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 390,
				'name' => 'Araguaína',
				'state_code' => 'BR31',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 391,
				'name' => 'Garanhuns',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 392,
				'name' => 'Vitória de Santo Antão',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 393,
				'name' => 'Santa Rita',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 394,
				'name' => 'Barbacena',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 395,
				'name' => 'Abaetetuba',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 396,
				'name' => 'Jaú',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 397,
				'name' => 'Lauro de Freitas',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 398,
				'name' => 'Franco da Rocha',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 399,
				'name' => 'Teixeira de Freitas',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 400,
				'name' => 'Varginha',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 401,
				'name' => 'Ribeirão Pires',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 402,
				'name' => 'Sabará',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 403,
				'name' => 'Catanduva',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 404,
				'name' => 'Rio Verde',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 405,
				'name' => 'Botucatu',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 406,
				'name' => 'Colatina',
				'state_code' => 'BR08',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 407,
				'name' => 'Santa Cruz do Sul',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 408,
				'name' => 'Linhares',
				'state_code' => 'BR08',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 409,
				'name' => 'Apucarana',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 410,
				'name' => 'Barretos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 411,
				'name' => 'Guaratinguetá',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 412,
				'name' => 'Cachoeirinha',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 413,
				'name' => 'Codó',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 414,
				'name' => 'Jaraguá do Sul',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 415,
				'name' => 'Cubatão',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 416,
				'name' => 'Itabira',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 417,
				'name' => 'Itaituba',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 418,
				'name' => 'Araras',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 419,
				'name' => 'Resende',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 420,
				'name' => 'Atibaia',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 421,
				'name' => 'Pouso Alegre',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 422,
				'name' => 'Toledo',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 423,
				'name' => 'Crato',
				'state_code' => 'BR06',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 424,
				'name' => 'Passos',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 425,
				'name' => 'Araguari',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 426,
				'name' => 'São José de Ribamar',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 427,
				'name' => 'Pinhais',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 428,
				'name' => 'Sertãozinho',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 429,
				'name' => 'Conselheiro Lafaiete',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 430,
				'name' => 'Paulo Afonso',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 431,
				'name' => 'Angra dos Reis',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 432,
				'name' => 'Eunápolis',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 433,
				'name' => 'Salto',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 434,
				'name' => 'Ourinhos',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 435,
				'name' => 'Parnamirim',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 436,
				'name' => 'Jacobina',
				'state_code' => 'BR05',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 437,
				'name' => 'Coronel Fabriciano',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 438,
				'name' => 'Birigui',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 439,
				'name' => 'Tatuí',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 440,
				'name' => 'Ji-Paraná',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 441,
				'name' => 'Bacabal',
				'state_code' => 'BR13',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 442,
				'name' => 'Cametá',
				'state_code' => 'BR16',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 443,
				'name' => 'Guaíba',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 444,
				'name' => 'São Lourenço da Mata',
				'state_code' => 'BR30',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 445,
				'name' => 'Santana do Livramento',
				'state_code' => 'BR23',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 446,
				'name' => 'Votorantim',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 447,
				'name' => 'Campo Largo',
				'state_code' => 'BR18',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 448,
				'name' => 'Patos',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 449,
				'name' => 'Ituiutaba',
				'state_code' => 'BR15',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 450,
				'name' => 'Corumbá',
				'state_code' => 'BR11',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 451,
				'name' => 'Palhoça',
				'state_code' => 'BR26',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 452,
				'name' => 'Barra do Piraí',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 453,
				'name' => 'Bento Gonçalves',
				'state_code' => 'BR21',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 454,
				'name' => 'Poá',
				'state_code' => 'BR27',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 455,
				'name' => 'Águas Lindas de Goiás',
				'state_code' => 'BR29',
				'country_code' => 'BRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 456,
				'name' => 'London',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 457,
				'name' => 'Birmingham',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 458,
				'name' => 'Glasgow',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 459,
				'name' => 'Liverpool',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 460,
				'name' => 'Edinburgh',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 461,
				'name' => 'Sheffield',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 462,
				'name' => 'Manchester',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 463,
				'name' => 'Leeds',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 464,
				'name' => 'Bristol',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 465,
				'name' => 'Cardiff',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 466,
				'name' => 'Coventry',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 467,
				'name' => 'Leicester',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 468,
				'name' => 'Bradford',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 469,
				'name' => 'Belfast',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 470,
				'name' => 'Nottingham',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 471,
				'name' => 'Kingston upon Hull',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 472,
				'name' => 'Plymouth',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 473,
				'name' => 'Stoke-on-Trent',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 474,
				'name' => 'Wolverhampton',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 475,
				'name' => 'Derby',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 476,
				'name' => 'Swansea',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 477,
				'name' => 'Southampton',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 478,
				'name' => 'Aberdeen',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 479,
				'name' => 'Northampton',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 480,
				'name' => 'Dudley',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 481,
				'name' => 'Portsmouth',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 482,
				'name' => 'Newcastle upon Tyne',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 483,
				'name' => 'Sunderland',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 484,
				'name' => 'Luton',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 485,
				'name' => 'Swindon',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 486,
				'name' => 'Southend-on-Sea',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 487,
				'name' => 'Walsall',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 488,
				'name' => 'Bournemouth',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 489,
				'name' => 'Peterborough',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 490,
				'name' => 'Brighton',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 491,
				'name' => 'Blackpool',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 492,
				'name' => 'Dundee',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 493,
				'name' => 'West Bromwich',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 494,
				'name' => 'Reading',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 495,
			'name' => 'Oldbury/Smethwick (Warley)',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 496,
				'name' => 'Middlesbrough',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 497,
				'name' => 'Huddersfield',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 498,
				'name' => 'Oxford',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 499,
				'name' => 'Poole',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 500,
				'name' => 'Bolton',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 501,
				'name' => 'Blackburn',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 502,
				'name' => 'Newport',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 503,
				'name' => 'Preston',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 504,
				'name' => 'Stockport',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 505,
				'name' => 'Norwich',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 506,
				'name' => 'Rotherham',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 507,
				'name' => 'Cambridge',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 508,
				'name' => 'Watford',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 509,
				'name' => 'Ipswich',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 510,
				'name' => 'Slough',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 511,
				'name' => 'Exeter',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 512,
				'name' => 'Cheltenham',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 513,
				'name' => 'Gloucester',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 514,
				'name' => 'Saint Helens',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 515,
				'name' => 'Sutton Coldfield',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 516,
				'name' => 'York',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 517,
				'name' => 'Oldham',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 518,
				'name' => 'Basildon',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 519,
				'name' => 'Worthing',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 520,
				'name' => 'Chelmsford',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 521,
				'name' => 'Colchester',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 522,
				'name' => 'Crawley',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 523,
				'name' => 'Gillingham',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 524,
				'name' => 'Solihull',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 525,
				'name' => 'Rochdale',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 526,
				'name' => 'Birkenhead',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 527,
				'name' => 'Worcester',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 528,
				'name' => 'Hartlepool',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 529,
				'name' => 'Halifax',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 530,
				'name' => 'Woking/Byfleet',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 531,
				'name' => 'Southport',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 532,
				'name' => 'Maidstone',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 533,
				'name' => 'Eastbourne',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 534,
				'name' => 'Grimsby',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 535,
				'name' => 'Saint Helier',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 536,
				'name' => 'Douglas',
				'state_code' => '',
				'country_code' => 'GBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 537,
				'name' => 'Road Town',
				'state_code' => '',
				'country_code' => 'VGB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 538,
				'name' => 'Bandar Seri Begawan',
				'state_code' => '',
				'country_code' => 'BRN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 539,
				'name' => 'Sofija',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 540,
				'name' => 'Plovdiv',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 541,
				'name' => 'Varna',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 542,
				'name' => 'Burgas',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 543,
				'name' => 'Ruse',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 544,
				'name' => 'Stara Zagora',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 545,
				'name' => 'Pleven',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 546,
				'name' => 'Sliven',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 547,
				'name' => 'Dobric',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 548,
				'name' => 'Šumen',
				'state_code' => '',
				'country_code' => 'BGR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 549,
				'name' => 'Ouagadougou',
				'state_code' => '',
				'country_code' => 'BFA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 550,
				'name' => 'Bobo-Dioulasso',
				'state_code' => '',
				'country_code' => 'BFA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 551,
				'name' => 'Koudougou',
				'state_code' => '',
				'country_code' => 'BFA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 552,
				'name' => 'Bujumbura',
				'state_code' => '',
				'country_code' => 'BDI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 553,
				'name' => 'George Town',
				'state_code' => '',
				'country_code' => 'CYM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 554,
				'name' => 'Santiago de Chile',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 555,
				'name' => 'Puente Alto',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 556,
				'name' => 'Viña del Mar',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 557,
				'name' => 'Valparaíso',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 558,
				'name' => 'Talcahuano',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 559,
				'name' => 'Antofagasta',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 560,
				'name' => 'San Bernardo',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 561,
				'name' => 'Temuco',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 562,
				'name' => 'Concepción',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 563,
				'name' => 'Rancagua',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 564,
				'name' => 'Arica',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 565,
				'name' => 'Talca',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 566,
				'name' => 'Chillán',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 567,
				'name' => 'Iquique',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 568,
				'name' => 'Los Angeles',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 569,
				'name' => 'Puerto Montt',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 570,
				'name' => 'Coquimbo',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 571,
				'name' => 'Osorno',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 572,
				'name' => 'La Serena',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 573,
				'name' => 'Calama',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 574,
				'name' => 'Valdivia',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 575,
				'name' => 'Punta Arenas',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 576,
				'name' => 'Copiapó',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 577,
				'name' => 'Quilpué',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 578,
				'name' => 'Curicó',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 579,
				'name' => 'Ovalle',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 580,
				'name' => 'Coronel',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 581,
				'name' => 'San Pedro de la Paz',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 582,
				'name' => 'Melipilla',
				'state_code' => '',
				'country_code' => 'CHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 583,
				'name' => 'Avarua',
				'state_code' => '',
				'country_code' => 'COK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 584,
				'name' => 'San José',
				'state_code' => '',
				'country_code' => 'CRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 585,
				'name' => 'Djibouti',
				'state_code' => '',
				'country_code' => 'DJI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 586,
				'name' => 'Roseau',
				'state_code' => '',
				'country_code' => 'DMA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 587,
				'name' => 'Santo Domingo de Guzmán',
				'state_code' => '',
				'country_code' => 'DOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 588,
				'name' => 'Santiago de los Caballeros',
				'state_code' => '',
				'country_code' => 'DOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 589,
				'name' => 'La Romana',
				'state_code' => '',
				'country_code' => 'DOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 590,
				'name' => 'San Pedro de Macorís',
				'state_code' => '',
				'country_code' => 'DOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 591,
				'name' => 'San Francisco de Macorís',
				'state_code' => '',
				'country_code' => 'DOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 592,
				'name' => 'San Felipe de Puerto Plata',
				'state_code' => '',
				'country_code' => 'DOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 593,
				'name' => 'Guayaquil',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 594,
				'name' => 'Quito',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 595,
				'name' => 'Cuenca',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 596,
				'name' => 'Machala',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 597,
				'name' => 'Santo Domingo de los Colorados',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 598,
				'name' => 'Portoviejo',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 599,
				'name' => 'Ambato',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 600,
				'name' => 'Manta',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 601,
				'name' => 'Duran [Eloy Alfaro]',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 602,
				'name' => 'Ibarra',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 603,
				'name' => 'Quevedo',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 604,
				'name' => 'Milagro',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 605,
				'name' => 'Loja',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 606,
				'name' => 'Ríobamba',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 607,
				'name' => 'Esmeraldas',
				'state_code' => '',
				'country_code' => 'ECU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 608,
				'name' => 'Cairo',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 609,
				'name' => 'Alexandria',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 610,
				'name' => 'Giza',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 611,
				'name' => 'Shubra al-Khayma',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 612,
				'name' => 'Port Said',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 613,
				'name' => 'Suez',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 614,
				'name' => 'al-Mahallat al-Kubra',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 615,
				'name' => 'Tanta',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 616,
				'name' => 'al-Mansura',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 617,
				'name' => 'Luxor',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 618,
				'name' => 'Asyut',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 619,
				'name' => 'Bahtim',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 620,
				'name' => 'Zagazig',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 621,
				'name' => 'al-Faiyum',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 622,
				'name' => 'Ismailia',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 623,
				'name' => 'Kafr al-Dawwar',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 624,
				'name' => 'Assuan',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 625,
				'name' => 'Damanhur',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 626,
				'name' => 'al-Minya',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 627,
				'name' => 'Bani Suwayf',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 628,
				'name' => 'Qina',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 629,
				'name' => 'Sawhaj',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 630,
				'name' => 'Shibin al-Kawm',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 631,
				'name' => 'Bulaq al-Dakrur',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 632,
				'name' => 'Banha',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 633,
				'name' => 'Warraq al-Arab',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 634,
				'name' => 'Kafr al-Shaykh',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 635,
				'name' => 'Mallawi',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 636,
				'name' => 'Bilbays',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 637,
				'name' => 'Mit Ghamr',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 638,
				'name' => 'al-Arish',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 639,
				'name' => 'Talkha',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 640,
				'name' => 'Qalyub',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 641,
				'name' => 'Jirja',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 642,
				'name' => 'Idfu',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 643,
				'name' => 'al-Hawamidiya',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 644,
				'name' => 'Disuq',
				'state_code' => '',
				'country_code' => 'EGY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 645,
				'name' => 'San Salvador',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 646,
				'name' => 'Santa Ana',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 647,
				'name' => 'Mejicanos',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 648,
				'name' => 'Soyapango',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 649,
				'name' => 'San Miguel',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 650,
				'name' => 'Nueva San Salvador',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 651,
				'name' => 'Apopa',
				'state_code' => '',
				'country_code' => 'SLV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 652,
				'name' => 'Asmara',
				'state_code' => '',
				'country_code' => 'ERI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 653,
				'name' => 'Madrid',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 654,
				'name' => 'Barcelona',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 655,
				'name' => 'Valencia',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 656,
				'name' => 'Sevilla',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 657,
				'name' => 'Zaragoza',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 658,
				'name' => 'Málaga',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 659,
				'name' => 'Bilbao',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 660,
				'name' => 'Las Palmas de Gran Canaria',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 661,
				'name' => 'Murcia',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 662,
				'name' => 'Palma de Mallorca',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 663,
				'name' => 'Valladolid',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 664,
				'name' => 'Córdoba',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 665,
				'name' => 'Vigo',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 666,
				'name' => 'Alicante [Alacant]',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 667,
				'name' => 'Gijón',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 668,
				'name' => 'L´Hospitalet de Llobregat',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 669,
				'name' => 'Granada',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 670,
			'name' => 'A Coruña (La Coruña)',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 671,
				'name' => 'Vitoria-Gasteiz',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 672,
				'name' => 'Santa Cruz de Tenerife',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 673,
				'name' => 'Badalona',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 674,
				'name' => 'Oviedo',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 675,
				'name' => 'Móstoles',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 676,
				'name' => 'Elche [Elx]',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 677,
				'name' => 'Sabadell',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 678,
				'name' => 'Santander',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 679,
				'name' => 'Jerez de la Frontera',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 680,
				'name' => 'Pamplona [Iruña]',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 681,
				'name' => 'Donostia-San Sebastián',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 682,
				'name' => 'Cartagena',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 683,
				'name' => 'Leganés',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 684,
				'name' => 'Fuenlabrada',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 685,
				'name' => 'Almería',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 686,
				'name' => 'Terrassa',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 687,
				'name' => 'Alcalá de Henares',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 688,
				'name' => 'Burgos',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 689,
				'name' => 'Salamanca',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 690,
				'name' => 'Albacete',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 691,
				'name' => 'Getafe',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 692,
				'name' => 'Cádiz',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 693,
				'name' => 'Alcorcón',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 694,
				'name' => 'Huelva',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 695,
				'name' => 'León',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 696,
				'name' => 'Castellón de la Plana [Castell',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 697,
				'name' => 'Badajoz',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 698,
				'name' => '[San Cristóbal de] la Laguna',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 699,
				'name' => 'Logroño',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 700,
				'name' => 'Santa Coloma de Gramenet',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 701,
				'name' => 'Tarragona',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 702,
			'name' => 'Lleida (Lérida)',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 703,
				'name' => 'Jaén',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 704,
			'name' => 'Ourense (Orense)',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 705,
				'name' => 'Mataró',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 706,
				'name' => 'Algeciras',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 707,
				'name' => 'Marbella',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 708,
				'name' => 'Barakaldo',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 709,
				'name' => 'Dos Hermanas',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 710,
				'name' => 'Santiago de Compostela',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 711,
				'name' => 'Torrejón de Ardoz',
				'state_code' => '',
				'country_code' => 'ESP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 712,
				'name' => 'Cape Town',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 713,
				'name' => 'Soweto',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 714,
				'name' => 'Johannesburg',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 715,
				'name' => 'Port Elizabeth',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 716,
				'name' => 'Pretoria',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 717,
				'name' => 'Inanda',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 718,
				'name' => 'Durban',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 719,
				'name' => 'Vanderbijlpark',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 720,
				'name' => 'Kempton Park',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 721,
				'name' => 'Alberton',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 722,
				'name' => 'Pinetown',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 723,
				'name' => 'Pietermaritzburg',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 724,
				'name' => 'Benoni',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 725,
				'name' => 'Randburg',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 726,
				'name' => 'Umlazi',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 727,
				'name' => 'Bloemfontein',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 728,
				'name' => 'Vereeniging',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 729,
				'name' => 'Wonderboom',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 730,
				'name' => 'Roodepoort',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 731,
				'name' => 'Boksburg',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 732,
				'name' => 'Klerksdorp',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 733,
				'name' => 'Soshanguve',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 734,
				'name' => 'Newcastle',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 735,
				'name' => 'East London',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 736,
				'name' => 'Welkom',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 737,
				'name' => 'Kimberley',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 738,
				'name' => 'Uitenhage',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 739,
				'name' => 'Chatsworth',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 740,
				'name' => 'Mdantsane',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 741,
				'name' => 'Krugersdorp',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 742,
				'name' => 'Botshabelo',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 743,
				'name' => 'Brakpan',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 744,
				'name' => 'Witbank',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 745,
				'name' => 'Oberholzer',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 746,
				'name' => 'Germiston',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 747,
				'name' => 'Springs',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 748,
				'name' => 'Westonaria',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 749,
				'name' => 'Randfontein',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 750,
				'name' => 'Paarl',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 751,
				'name' => 'Potchefstroom',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 752,
				'name' => 'Rustenburg',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 753,
				'name' => 'Nigel',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 754,
				'name' => 'George',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 755,
				'name' => 'Ladysmith',
				'state_code' => '',
				'country_code' => 'ZAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 756,
				'name' => 'Addis Abeba',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 757,
				'name' => 'Dire Dawa',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 758,
				'name' => 'Nazret',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 759,
				'name' => 'Gonder',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 760,
				'name' => 'Dese',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 761,
				'name' => 'Mekele',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 762,
				'name' => 'Bahir Dar',
				'state_code' => '',
				'country_code' => 'ETH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 763,
				'name' => 'Stanley',
				'state_code' => '',
				'country_code' => 'FLK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 764,
				'name' => 'Suva',
				'state_code' => '',
				'country_code' => 'FJI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 765,
				'name' => 'Quezon',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 766,
				'name' => 'Manila',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 767,
				'name' => 'Kalookan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 768,
				'name' => 'Davao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 769,
				'name' => 'Cebu',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 770,
				'name' => 'Zamboanga',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 771,
				'name' => 'Pasig',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 772,
				'name' => 'Valenzuela',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 773,
				'name' => 'Las Piñas',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 774,
				'name' => 'Antipolo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 775,
				'name' => 'Taguig',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 776,
				'name' => 'Cagayan de Oro',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 777,
				'name' => 'Parañaque',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 778,
				'name' => 'Makati',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 779,
				'name' => 'Bacolod',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 780,
				'name' => 'General Santos',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 781,
				'name' => 'Marikina',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 782,
				'name' => 'Dasmariñas',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 783,
				'name' => 'Muntinlupa',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 784,
				'name' => 'Iloilo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 785,
				'name' => 'Pasay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 786,
				'name' => 'Malabon',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 787,
				'name' => 'San José del Monte',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 788,
				'name' => 'Bacoor',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 789,
				'name' => 'Iligan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 790,
				'name' => 'Calamba',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 791,
				'name' => 'Mandaluyong',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 792,
				'name' => 'Butuan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 793,
				'name' => 'Angeles',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 794,
				'name' => 'Tarlac',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 795,
				'name' => 'Mandaue',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 796,
				'name' => 'Baguio',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 797,
				'name' => 'Batangas',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 798,
				'name' => 'Cainta',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 799,
				'name' => 'San Pedro',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 800,
				'name' => 'Navotas',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 801,
				'name' => 'Cabanatuan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 802,
				'name' => 'San Fernando',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 803,
				'name' => 'Lipa',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 804,
				'name' => 'Lapu-Lapu',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 805,
				'name' => 'San Pablo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 806,
				'name' => 'Biñan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 807,
				'name' => 'Taytay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 808,
				'name' => 'Lucena',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 809,
				'name' => 'Imus',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 810,
				'name' => 'Olongapo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 811,
				'name' => 'Binangonan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 812,
				'name' => 'Santa Rosa',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 813,
				'name' => 'Tagum',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 814,
				'name' => 'Tacloban',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 815,
				'name' => 'Malolos',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 816,
				'name' => 'Mabalacat',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 817,
				'name' => 'Cotabato',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 818,
				'name' => 'Meycauayan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 819,
				'name' => 'Puerto Princesa',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 820,
				'name' => 'Legazpi',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 821,
				'name' => 'Silang',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 822,
				'name' => 'Ormoc',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 823,
				'name' => 'San Carlos',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 824,
				'name' => 'Kabankalan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 825,
				'name' => 'Talisay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 826,
				'name' => 'Valencia',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 827,
				'name' => 'Calbayog',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 828,
				'name' => 'Santa Maria',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 829,
				'name' => 'Pagadian',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 830,
				'name' => 'Cadiz',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 831,
				'name' => 'Bago',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 832,
				'name' => 'Toledo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 833,
				'name' => 'Naga',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 834,
				'name' => 'San Mateo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 835,
				'name' => 'Panabo',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 836,
				'name' => 'Koronadal',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 837,
				'name' => 'Marawi',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 838,
				'name' => 'Dagupan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 839,
				'name' => 'Sagay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 840,
				'name' => 'Roxas',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 841,
				'name' => 'Lubao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 842,
				'name' => 'Digos',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 843,
				'name' => 'San Miguel',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 844,
				'name' => 'Malaybalay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 845,
				'name' => 'Tuguegarao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 846,
				'name' => 'Ilagan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 847,
				'name' => 'Baliuag',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 848,
				'name' => 'Surigao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 849,
				'name' => 'San Carlos',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 850,
				'name' => 'San Juan del Monte',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 851,
				'name' => 'Tanauan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 852,
				'name' => 'Concepcion',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 853,
			'name' => 'Rodriguez (Montalban)',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 854,
				'name' => 'Sariaya',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 855,
				'name' => 'Malasiqui',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 856,
				'name' => 'General Mariano Alvarez',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 857,
				'name' => 'Urdaneta',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 858,
				'name' => 'Hagonoy',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 859,
				'name' => 'San Jose',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 860,
				'name' => 'Polomolok',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 861,
				'name' => 'Santiago',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 862,
				'name' => 'Tanza',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 863,
				'name' => 'Ozamis',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 864,
				'name' => 'Mexico',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 865,
				'name' => 'San Jose',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 866,
				'name' => 'Silay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 867,
				'name' => 'General Trias',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 868,
				'name' => 'Tabaco',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 869,
				'name' => 'Cabuyao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 870,
				'name' => 'Calapan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 871,
				'name' => 'Mati',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 872,
				'name' => 'Midsayap',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 873,
				'name' => 'Cauayan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 874,
				'name' => 'Gingoog',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 875,
				'name' => 'Dumaguete',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 876,
				'name' => 'San Fernando',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 877,
				'name' => 'Arayat',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 878,
			'name' => 'Bayawan (Tulong)',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 879,
				'name' => 'Kidapawan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 880,
			'name' => 'Daraga (Locsin)',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 881,
				'name' => 'Marilao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 882,
				'name' => 'Malita',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 883,
				'name' => 'Dipolog',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 884,
				'name' => 'Cavite',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 885,
				'name' => 'Danao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 886,
				'name' => 'Bislig',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 887,
				'name' => 'Talavera',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 888,
				'name' => 'Guagua',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 889,
				'name' => 'Bayambang',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 890,
				'name' => 'Nasugbu',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 891,
				'name' => 'Baybay',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 892,
				'name' => 'Capas',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 893,
				'name' => 'Sultan Kudarat',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 894,
				'name' => 'Laoag',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 895,
				'name' => 'Bayugan',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 896,
				'name' => 'Malungon',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 897,
				'name' => 'Santa Cruz',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 898,
				'name' => 'Sorsogon',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 899,
				'name' => 'Candelaria',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 900,
				'name' => 'Ligao',
				'state_code' => '',
				'country_code' => 'PHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 901,
				'name' => 'Tórshavn',
				'state_code' => '',
				'country_code' => 'FRO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 902,
				'name' => 'Libreville',
				'state_code' => '',
				'country_code' => 'GAB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 903,
				'name' => 'Serekunda',
				'state_code' => '',
				'country_code' => 'GMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 904,
				'name' => 'Banjul',
				'state_code' => '',
				'country_code' => 'GMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 905,
				'name' => 'Tbilisi',
				'state_code' => '',
				'country_code' => 'GEO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 906,
				'name' => 'Kutaisi',
				'state_code' => '',
				'country_code' => 'GEO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 907,
				'name' => 'Rustavi',
				'state_code' => '',
				'country_code' => 'GEO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 908,
				'name' => 'Batumi',
				'state_code' => '',
				'country_code' => 'GEO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 909,
				'name' => 'Sohumi',
				'state_code' => '',
				'country_code' => 'GEO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 910,
				'name' => 'Accra',
				'state_code' => '',
				'country_code' => 'GHA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 911,
				'name' => 'Kumasi',
				'state_code' => '',
				'country_code' => 'GHA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 912,
				'name' => 'Tamale',
				'state_code' => '',
				'country_code' => 'GHA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 913,
				'name' => 'Tema',
				'state_code' => '',
				'country_code' => 'GHA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 914,
				'name' => 'Sekondi-Takoradi',
				'state_code' => '',
				'country_code' => 'GHA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 915,
				'name' => 'Gibraltar',
				'state_code' => '',
				'country_code' => 'GIB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 916,
				'name' => 'Saint George´s',
				'state_code' => '',
				'country_code' => 'GRD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 917,
				'name' => 'Nuuk',
				'state_code' => '',
				'country_code' => 'GRL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 918,
				'name' => 'Les Abymes',
				'state_code' => '',
				'country_code' => 'GLP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 919,
				'name' => 'Basse-Terre',
				'state_code' => '',
				'country_code' => 'GLP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 920,
				'name' => 'Tamuning',
				'state_code' => '',
				'country_code' => 'GUM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 921,
				'name' => 'Agaña',
				'state_code' => '',
				'country_code' => 'GUM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 922,
				'name' => 'Ciudad de Guatemala',
				'state_code' => '',
				'country_code' => 'GTM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 923,
				'name' => 'Mixco',
				'state_code' => '',
				'country_code' => 'GTM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 924,
				'name' => 'Villa Nueva',
				'state_code' => '',
				'country_code' => 'GTM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 925,
				'name' => 'Quetzaltenango',
				'state_code' => '',
				'country_code' => 'GTM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 926,
				'name' => 'Conakry',
				'state_code' => '',
				'country_code' => 'GIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 927,
				'name' => 'Bissau',
				'state_code' => '',
				'country_code' => 'GNB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 928,
				'name' => 'Georgetown',
				'state_code' => '',
				'country_code' => 'GUY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 929,
				'name' => 'Port-au-Prince',
				'state_code' => '',
				'country_code' => 'HTI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 930,
				'name' => 'Carrefour',
				'state_code' => '',
				'country_code' => 'HTI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 931,
				'name' => 'Delmas',
				'state_code' => '',
				'country_code' => 'HTI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 932,
				'name' => 'Le-Cap-Haïtien',
				'state_code' => '',
				'country_code' => 'HTI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 933,
				'name' => 'Tegucigalpa',
				'state_code' => '',
				'country_code' => 'HND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 934,
				'name' => 'San Pedro Sula',
				'state_code' => '',
				'country_code' => 'HND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 935,
				'name' => 'La Ceiba',
				'state_code' => '',
				'country_code' => 'HND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 936,
				'name' => 'Kowloon and New Kowloon',
				'state_code' => '',
				'country_code' => 'HKG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 937,
				'name' => 'Victoria',
				'state_code' => '',
				'country_code' => 'HKG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 938,
				'name' => 'Longyearbyen',
				'state_code' => '',
				'country_code' => 'SJM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 939,
				'name' => 'Jakarta',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 940,
				'name' => 'Surabaya',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 941,
				'name' => 'Bandung',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 942,
				'name' => 'Medan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 943,
				'name' => 'Palembang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 944,
				'name' => 'Tangerang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 945,
				'name' => 'Semarang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 946,
				'name' => 'Ujung Pandang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 947,
				'name' => 'Malang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 948,
				'name' => 'Bandar Lampung',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 949,
				'name' => 'Bekasi',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 950,
				'name' => 'Padang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 951,
				'name' => 'Surakarta',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 952,
				'name' => 'Banjarmasin',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 953,
				'name' => 'Pekan Baru',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 954,
				'name' => 'Denpasar',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 955,
				'name' => 'Yogyakarta',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 956,
				'name' => 'Pontianak',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 957,
				'name' => 'Samarinda',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 958,
				'name' => 'Jambi',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 959,
				'name' => 'Depok',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 960,
				'name' => 'Cimahi',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 961,
				'name' => 'Balikpapan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 962,
				'name' => 'Manado',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 963,
				'name' => 'Mataram',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 964,
				'name' => 'Pekalongan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 965,
				'name' => 'Tegal',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 966,
				'name' => 'Bogor',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 967,
				'name' => 'Ciputat',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 968,
				'name' => 'Pondokgede',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 969,
				'name' => 'Cirebon',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 970,
				'name' => 'Kediri',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 971,
				'name' => 'Ambon',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 972,
				'name' => 'Jember',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 973,
				'name' => 'Cilacap',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 974,
				'name' => 'Cimanggis',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 975,
				'name' => 'Pematang Siantar',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 976,
				'name' => 'Purwokerto',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 977,
				'name' => 'Ciomas',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 978,
				'name' => 'Tasikmalaya',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 979,
				'name' => 'Madiun',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 980,
				'name' => 'Bengkulu',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 981,
				'name' => 'Karawang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 982,
				'name' => 'Banda Aceh',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 983,
				'name' => 'Palu',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 984,
				'name' => 'Pasuruan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 985,
				'name' => 'Kupang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 986,
				'name' => 'Tebing Tinggi',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 987,
				'name' => 'Percut Sei Tuan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 988,
				'name' => 'Binjai',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 989,
				'name' => 'Sukabumi',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 990,
				'name' => 'Waru',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 991,
				'name' => 'Pangkal Pinang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 992,
				'name' => 'Magelang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 993,
				'name' => 'Blitar',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 994,
				'name' => 'Serang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 995,
				'name' => 'Probolinggo',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 996,
				'name' => 'Cilegon',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 997,
				'name' => 'Cianjur',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 998,
				'name' => 'Ciparay',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 999,
				'name' => 'Lhokseumawe',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 1000,
				'name' => 'Taman',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 1001,
				'name' => 'Depok',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 1002,
				'name' => 'Citeureup',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 1003,
				'name' => 'Pemalang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 1004,
				'name' => 'Klaten',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 1005,
				'name' => 'Salatiga',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 1006,
				'name' => 'Cibinong',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 1007,
				'name' => 'Palangka Raya',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 1008,
				'name' => 'Mojokerto',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 1009,
				'name' => 'Purwakarta',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 1010,
				'name' => 'Garut',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 1011,
				'name' => 'Kudus',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 1012,
				'name' => 'Kendari',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 1013,
				'name' => 'Jaya Pura',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 1014,
				'name' => 'Gorontalo',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 1015,
				'name' => 'Majalaya',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 1016,
				'name' => 'Pondok Aren',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 1017,
				'name' => 'Jombang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 1018,
				'name' => 'Sunggal',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 1019,
				'name' => 'Batam',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 1020,
				'name' => 'Padang Sidempuan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 1021,
				'name' => 'Sawangan',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 1022,
				'name' => 'Banyuwangi',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 1023,
				'name' => 'Tanjung Pinang',
				'state_code' => '',
				'country_code' => 'IDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 1024,
			'name' => 'Mumbai (Bombay)',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 1025,
				'name' => 'Delhi',
				'state_code' => 'IN28',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 1026,
				'name' => 'Calcutta [Kolkata]',
				'state_code' => 'IN36',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 1027,
			'name' => 'Chennai (Madras)',
				'state_code' => 'IN36',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 1028,
				'name' => 'Hyderabad',
				'state_code' => 'IN32',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 1029,
				'name' => 'Ahmedabad',
				'state_code' => 'IN12',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 1030,
				'name' => 'Bangalore',
				'state_code' => 'IN17',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 1031,
				'name' => 'Kanpur',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 1032,
				'name' => 'Nagpur',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 1033,
				'name' => 'Lucknow',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 1034,
				'name' => 'Pune',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 1035,
				'name' => 'Surat',
				'state_code' => 'IN12',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 1036,
				'name' => 'Jaipur',
				'state_code' => 'IN29',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 1037,
				'name' => 'Indore',
				'state_code' => 'IN20',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 1038,
				'name' => 'Bhopal',
				'state_code' => 'IN20',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 1039,
				'name' => 'Ludhiana',
				'state_code' => 'IN28',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 1040,
			'name' => 'Vadodara (Baroda)',
				'state_code' => 'IN12',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 1041,
				'name' => 'Kalyan',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 1042,
				'name' => 'Madurai',
				'state_code' => 'IN31',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 1043,
			'name' => 'Haora (Howrah)',
				'state_code' => 'IN36',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 1044,
			'name' => 'Varanasi (Benares)',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 1045,
				'name' => 'Patna',
				'state_code' => 'IN5',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 1046,
				'name' => 'Srinagar',
				'state_code' => 'IN15',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 1047,
				'name' => 'Agra',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 1048,
				'name' => 'Coimbatore',
				'state_code' => 'IN31',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 1049,
			'name' => 'Thane (Thana)',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 1050,
				'name' => 'Allahabad',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 1051,
				'name' => 'Meerut',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 1052,
				'name' => 'Vishakhapatnam',
				'state_code' => 'IN2',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 1053,
				'name' => 'Jabalpur',
				'state_code' => 'IN20',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 1054,
				'name' => 'Amritsar',
				'state_code' => 'IN28',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 1055,
				'name' => 'Faridabad',
				'state_code' => 'IN13',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 1056,
				'name' => 'Vijayawada',
				'state_code' => 'IN2',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 1057,
				'name' => 'Gwalior',
				'state_code' => 'IN20',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 1058,
				'name' => 'Jodhpur',
				'state_code' => 'IN29',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 1059,
			'name' => 'Nashik (Nasik)',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 1060,
				'name' => 'Hubli-Dharwad',
				'state_code' => 'IN17',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 1061,
			'name' => 'Solapur (Sholapur)',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 1062,
				'name' => 'Ranchi',
				'state_code' => 'IN16',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 1063,
				'name' => 'Bareilly',
				'state_code' => 'IN34',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 1064,
			'name' => 'Guwahati (Gauhati)',
				'state_code' => 'IN4',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 1065,
			'name' => 'Shambajinagar (Aurangabad)',
				'state_code' => 'IN21',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 1066,
			'name' => 'Cochin (Kochi)',
				'state_code' => 'IN18',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 1067,
				'name' => 'Rajkot',
				'state_code' => 'IN12',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 1068,
				'name' => 'Kota',
				'state_code' => 'IN29',
				'country_code' => 'IND',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 1069,
				'name' => 'Thiruvananthapuram (Trivandrum',
					'state_code' => 'IN18',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				69 =>
				array (
					'id' => 1070,
					'name' => 'Pimpri-Chinchwad',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				70 =>
				array (
					'id' => 1071,
				'name' => 'Jalandhar (Jullundur)',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				71 =>
				array (
					'id' => 1072,
					'name' => 'Gorakhpur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				72 =>
				array (
					'id' => 1073,
					'name' => 'Chandigarh',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				73 =>
				array (
					'id' => 1074,
					'name' => 'Mysore',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				74 =>
				array (
					'id' => 1075,
					'name' => 'Aligarh',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				75 =>
				array (
					'id' => 1076,
					'name' => 'Guntur',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				76 =>
				array (
					'id' => 1077,
					'name' => 'Jamshedpur',
					'state_code' => 'IN16',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				77 =>
				array (
					'id' => 1078,
					'name' => 'Ghaziabad',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				78 =>
				array (
					'id' => 1079,
					'name' => 'Warangal',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				79 =>
				array (
					'id' => 1080,
					'name' => 'Raipur',
					'state_code' => 'IN7',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				80 =>
				array (
					'id' => 1081,
					'name' => 'Moradabad',
					'state_code' => 'in34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				81 =>
				array (
					'id' => 1082,
					'name' => 'Durgapur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				82 =>
				array (
					'id' => 1083,
					'name' => 'Amravati',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				83 =>
				array (
					'id' => 1084,
				'name' => 'Calicut (Kozhikode)',
					'state_code' => 'IN18',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				84 =>
				array (
					'id' => 1085,
					'name' => 'Bikaner',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				85 =>
				array (
					'id' => 1086,
					'name' => 'Bhubaneswar',
					'state_code' => 'IN26',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				86 =>
				array (
					'id' => 1087,
					'name' => 'Kolhapur',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				87 =>
				array (
					'id' => 1088,
				'name' => 'Kataka (Cuttack)',
					'state_code' => 'IN26',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				88 =>
				array (
					'id' => 1089,
					'name' => 'Ajmer',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				89 =>
				array (
					'id' => 1090,
					'name' => 'Bhavnagar',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				90 =>
				array (
					'id' => 1091,
					'name' => 'Tiruchirapalli',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				91 =>
				array (
					'id' => 1092,
					'name' => 'Bhilai',
					'state_code' => 'IN7',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				92 =>
				array (
					'id' => 1093,
					'name' => 'Bhiwandi',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				93 =>
				array (
					'id' => 1094,
					'name' => 'Saharanpur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				94 =>
				array (
					'id' => 1095,
					'name' => 'Ulhasnagar',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				95 =>
				array (
					'id' => 1096,
					'name' => 'Salem',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				96 =>
				array (
					'id' => 1097,
					'name' => 'Ujjain',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				97 =>
				array (
					'id' => 1098,
					'name' => 'Malegaon',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				98 =>
				array (
					'id' => 1099,
					'name' => 'Jamnagar',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				99 =>
				array (
					'id' => 1100,
					'name' => 'Bokaro Steel City',
					'state_code' => 'IN16',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				100 =>
				array (
					'id' => 1101,
					'name' => 'Akola',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				101 =>
				array (
					'id' => 1102,
					'name' => 'Belgaum',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				102 =>
				array (
					'id' => 1103,
					'name' => 'Rajahmundry',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				103 =>
				array (
					'id' => 1104,
					'name' => 'Nellore',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				104 =>
				array (
					'id' => 1105,
					'name' => 'Udaipur',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				105 =>
				array (
					'id' => 1106,
					'name' => 'New Bombay',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				106 =>
				array (
					'id' => 1107,
					'name' => 'Bhatpara',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				107 =>
				array (
					'id' => 1108,
					'name' => 'Gulbarga',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				108 =>
				array (
					'id' => 1109,
					'name' => 'New Delhi',
					'state_code' => 'IN10',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				109 =>
				array (
					'id' => 1110,
					'name' => 'Jhansi',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				110 =>
				array (
					'id' => 1111,
					'name' => 'Gaya',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				111 =>
				array (
					'id' => 1112,
					'name' => 'Kakinada',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				112 =>
				array (
					'id' => 1113,
				'name' => 'Dhule (Dhulia)',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				113 =>
				array (
					'id' => 1114,
					'name' => 'Panihati',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				114 =>
				array (
					'id' => 1115,
				'name' => 'Nanded (Nander)',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				115 =>
				array (
					'id' => 1116,
					'name' => 'Mangalore',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				116 =>
				array (
					'id' => 1117,
					'name' => 'Dehra Dun',
					'state_code' => 'IN35',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				117 =>
				array (
					'id' => 1118,
					'name' => 'Kamarhati',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				118 =>
				array (
					'id' => 1119,
					'name' => 'Davangere',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				119 =>
				array (
					'id' => 1120,
					'name' => 'Asansol',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				120 =>
				array (
					'id' => 1121,
					'name' => 'Bhagalpur',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				121 =>
				array (
					'id' => 1122,
					'name' => 'Bellary',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				122 =>
				array (
					'id' => 1123,
				'name' => 'Barddhaman (Burdwan)',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				123 =>
				array (
					'id' => 1124,
					'name' => 'Rampur',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				124 =>
				array (
					'id' => 1125,
					'name' => 'Jalgaon',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				125 =>
				array (
					'id' => 1126,
					'name' => 'Muzaffarpur',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				126 =>
				array (
					'id' => 1127,
					'name' => 'Nizamabad',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				127 =>
				array (
					'id' => 1128,
					'name' => 'Muzaffarnagar',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				128 =>
				array (
					'id' => 1129,
					'name' => 'Patiala',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				129 =>
				array (
					'id' => 1130,
					'name' => 'Shahjahanpur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				130 =>
				array (
					'id' => 1131,
					'name' => 'Kurnool',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				131 =>
				array (
					'id' => 1132,
				'name' => 'Tiruppur (Tirupper)',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				132 =>
				array (
					'id' => 1133,
					'name' => 'Rohtak',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				133 =>
				array (
					'id' => 1134,
					'name' => 'South Dum Dum',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				134 =>
				array (
					'id' => 1135,
					'name' => 'Mathura',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				135 =>
				array (
					'id' => 1136,
					'name' => 'Chandrapur',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				136 =>
				array (
					'id' => 1137,
				'name' => 'Barahanagar (Baranagar)',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				137 =>
				array (
					'id' => 1138,
					'name' => 'Darbhanga',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				138 =>
				array (
					'id' => 1139,
				'name' => 'Siliguri (Shiliguri)',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				139 =>
				array (
					'id' => 1140,
					'name' => 'Raurkela',
					'state_code' => 'IN26',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				140 =>
				array (
					'id' => 1141,
					'name' => 'Ambattur',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				141 =>
				array (
					'id' => 1142,
					'name' => 'Panipat',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				142 =>
				array (
					'id' => 1143,
					'name' => 'Firozabad',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				143 =>
				array (
					'id' => 1144,
					'name' => 'Ichalkaranji',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				144 =>
				array (
					'id' => 1145,
					'name' => 'Jammu',
					'state_code' => 'IN15',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				145 =>
				array (
					'id' => 1146,
					'name' => 'Ramagundam',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				146 =>
				array (
					'id' => 1147,
					'name' => 'Eluru',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				147 =>
				array (
					'id' => 1148,
					'name' => 'Brahmapur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				148 =>
				array (
					'id' => 1149,
					'name' => 'Alwar',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				149 =>
				array (
					'id' => 1150,
					'name' => 'Pondicherry',
					'state_code' => 'IN27',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				150 =>
				array (
					'id' => 1151,
					'name' => 'Thanjavur',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				151 =>
				array (
					'id' => 1152,
					'name' => 'Bihar Sharif',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				152 =>
				array (
					'id' => 1153,
					'name' => 'Tuticorin',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				153 =>
				array (
					'id' => 1154,
					'name' => 'Imphal',
					'state_code' => 'IN22',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				154 =>
				array (
					'id' => 1155,
					'name' => 'Latur',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				155 =>
				array (
					'id' => 1156,
					'name' => 'Sagar',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				156 =>
				array (
					'id' => 1157,
					'name' => 'Farrukhabad-cum-Fatehgarh',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				157 =>
				array (
					'id' => 1158,
					'name' => 'Sangli',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				158 =>
				array (
					'id' => 1159,
					'name' => 'Parbhani',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				159 =>
				array (
					'id' => 1160,
					'name' => 'Nagercoil',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				160 =>
				array (
					'id' => 1161,
					'name' => 'Bijapur',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				161 =>
				array (
					'id' => 1162,
					'name' => 'Kukatpally',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				162 =>
				array (
					'id' => 1163,
					'name' => 'Bally',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				163 =>
				array (
					'id' => 1164,
					'name' => 'Bhilwara',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				164 =>
				array (
					'id' => 1165,
					'name' => 'Ratlam',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				165 =>
				array (
					'id' => 1166,
					'name' => 'Avadi',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				166 =>
				array (
					'id' => 1167,
					'name' => 'Dindigul',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				167 =>
				array (
					'id' => 1168,
					'name' => 'Ahmednagar',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				168 =>
				array (
					'id' => 1169,
					'name' => 'Bilaspur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				169 =>
				array (
					'id' => 1170,
					'name' => 'Shimoga',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				170 =>
				array (
					'id' => 1171,
					'name' => 'Kharagpur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				171 =>
				array (
					'id' => 1172,
					'name' => 'Mira Bhayandar',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				172 =>
				array (
					'id' => 1173,
					'name' => 'Vellore',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				173 =>
				array (
					'id' => 1174,
					'name' => 'Jalna',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				174 =>
				array (
					'id' => 1175,
					'name' => 'Burnpur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				175 =>
				array (
					'id' => 1176,
					'name' => 'Anantapur',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				176 =>
				array (
					'id' => 1177,
				'name' => 'Allappuzha (Alleppey)',
					'state_code' => 'IN18',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				177 =>
				array (
					'id' => 1178,
					'name' => 'Tirupati',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				178 =>
				array (
					'id' => 1179,
					'name' => 'Karnal',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				179 =>
				array (
					'id' => 1180,
					'name' => 'Burhanpur',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				180 =>
				array (
					'id' => 1181,
				'name' => 'Hisar (Hissar)',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				181 =>
				array (
					'id' => 1182,
					'name' => 'Tiruvottiyur',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				182 =>
				array (
					'id' => 1183,
					'name' => 'Mirzapur-cum-Vindhyachal',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				183 =>
				array (
					'id' => 1184,
					'name' => 'Secunderabad',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				184 =>
				array (
					'id' => 1185,
					'name' => 'Nadiad',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				185 =>
				array (
					'id' => 1186,
					'name' => 'Dewas',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				186 =>
				array (
					'id' => 1187,
				'name' => 'Murwara (Katni)',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				187 =>
				array (
					'id' => 1188,
					'name' => 'Ganganagar',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				188 =>
				array (
					'id' => 1189,
					'name' => 'Vizianagaram',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				189 =>
				array (
					'id' => 1190,
					'name' => 'Erode',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				190 =>
				array (
					'id' => 1191,
				'name' => 'Machilipatnam (Masulipatam)',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				191 =>
				array (
					'id' => 1192,
				'name' => 'Bhatinda (Bathinda)',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				192 =>
				array (
					'id' => 1193,
					'name' => 'Raichur',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				193 =>
				array (
					'id' => 1194,
					'name' => 'Agartala',
					'state_code' => 'IN33',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				194 =>
				array (
					'id' => 1195,
				'name' => 'Arrah (Ara)',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				195 =>
				array (
					'id' => 1196,
					'name' => 'Satna',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				196 =>
				array (
					'id' => 1197,
					'name' => 'Lalbahadur Nagar',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				197 =>
				array (
					'id' => 1198,
					'name' => 'Aizawl',
					'state_code' => 'IN24',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				198 =>
				array (
					'id' => 1199,
					'name' => 'Uluberia',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				199 =>
				array (
					'id' => 1200,
					'name' => 'Katihar',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				200 =>
				array (
					'id' => 1201,
					'name' => 'Cuddalore',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				201 =>
				array (
					'id' => 1202,
					'name' => 'Hugli-Chinsurah',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				202 =>
				array (
					'id' => 1203,
					'name' => 'Dhanbad',
					'state_code' => 'IN16',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				203 =>
				array (
					'id' => 1204,
					'name' => 'Raiganj',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				204 =>
				array (
					'id' => 1205,
					'name' => 'Sambhal',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				205 =>
				array (
					'id' => 1206,
					'name' => 'Durg',
					'state_code' => 'IN7',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				206 =>
				array (
					'id' => 1207,
				'name' => 'Munger (Monghyr)',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				207 =>
				array (
					'id' => 1208,
					'name' => 'Kanchipuram',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				208 =>
				array (
					'id' => 1209,
					'name' => 'North Dumdum',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				209 =>
				array (
					'id' => 1210,
					'name' => 'Karimnagar',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				210 =>
				array (
					'id' => 1211,
					'name' => 'Bharatpur',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				211 =>
				array (
					'id' => 1212,
					'name' => 'Sikar',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				212 =>
				array (
					'id' => 1213,
				'name' => 'Hardwar (Haridwar)',
					'state_code' => 'IN35',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				213 =>
				array (
					'id' => 1214,
					'name' => 'Dabgram',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				214 =>
				array (
					'id' => 1215,
					'name' => 'Morena',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				215 =>
				array (
					'id' => 1216,
					'name' => 'Noida',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				216 =>
				array (
					'id' => 1217,
					'name' => 'Hapur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				217 =>
				array (
					'id' => 1218,
					'name' => 'Bhusawal',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				218 =>
				array (
					'id' => 1219,
					'name' => 'Khandwa',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				219 =>
				array (
					'id' => 1220,
					'name' => 'Yamuna Nagar',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				220 =>
				array (
					'id' => 1221,
				'name' => 'Sonipat (Sonepat)',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				221 =>
				array (
					'id' => 1222,
					'name' => 'Tenali',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				222 =>
				array (
					'id' => 1223,
					'name' => 'Raurkela Civil Township',
					'state_code' => 'IN26',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				223 =>
				array (
					'id' => 1224,
				'name' => 'Kollam (Quilon)',
					'state_code' => 'IN18',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				224 =>
				array (
					'id' => 1225,
					'name' => 'Kumbakonam',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				225 =>
				array (
					'id' => 1226,
				'name' => 'Ingraj Bazar (English Bazar)',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				226 =>
				array (
					'id' => 1227,
					'name' => 'Tumkur',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				227 =>
				array (
					'id' => 1228,
					'name' => 'Amroha',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				228 =>
				array (
					'id' => 1229,
					'name' => 'Serampore',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				229 =>
				array (
					'id' => 1230,
					'name' => 'Chapra',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				230 =>
				array (
					'id' => 1231,
					'name' => 'Pali',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				231 =>
				array (
					'id' => 1232,
					'name' => 'Maunath Bhanjan',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				232 =>
				array (
					'id' => 1233,
					'name' => 'Adoni',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				233 =>
				array (
					'id' => 1234,
					'name' => 'Jaunpur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				234 =>
				array (
					'id' => 1235,
					'name' => 'Tirunelveli',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				235 =>
				array (
					'id' => 1236,
					'name' => 'Bahraich',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				236 =>
				array (
					'id' => 1237,
					'name' => 'Gadag Betigeri',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				237 =>
				array (
					'id' => 1238,
					'name' => 'Proddatur',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				238 =>
				array (
					'id' => 1239,
					'name' => 'Chittoor',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				239 =>
				array (
					'id' => 1240,
					'name' => 'Barrackpur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				240 =>
				array (
					'id' => 1241,
				'name' => 'Bharuch (Broach)',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				241 =>
				array (
					'id' => 1242,
					'name' => 'Naihati',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				242 =>
				array (
					'id' => 1243,
					'name' => 'Shillong',
					'state_code' => 'IN23',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				243 =>
				array (
					'id' => 1244,
					'name' => 'Sambalpur',
					'state_code' => 'IN26',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				244 =>
				array (
					'id' => 1245,
					'name' => 'Junagadh',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				245 =>
				array (
					'id' => 1246,
					'name' => 'Rae Bareli',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				246 =>
				array (
					'id' => 1247,
					'name' => 'Rewa',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				247 =>
				array (
					'id' => 1248,
					'name' => 'Gurgaon',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				248 =>
				array (
					'id' => 1249,
					'name' => 'Khammam',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				249 =>
				array (
					'id' => 1250,
					'name' => 'Bulandshahr',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				250 =>
				array (
					'id' => 1251,
					'name' => 'Navsari',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				251 =>
				array (
					'id' => 1252,
					'name' => 'Malkajgiri',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				252 =>
				array (
					'id' => 1253,
				'name' => 'Midnapore (Medinipur)',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				253 =>
				array (
					'id' => 1254,
					'name' => 'Miraj',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				254 =>
				array (
					'id' => 1255,
					'name' => 'Raj Nandgaon',
					'state_code' => 'IN7',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				255 =>
				array (
					'id' => 1256,
					'name' => 'Alandur',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				256 =>
				array (
					'id' => 1257,
					'name' => 'Puri',
					'state_code' => 'IN26',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				257 =>
				array (
					'id' => 1258,
					'name' => 'Navadwip',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				258 =>
				array (
					'id' => 1259,
					'name' => 'Sirsa',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				259 =>
				array (
					'id' => 1260,
					'name' => 'Korba',
					'state_code' => 'IN7',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				260 =>
				array (
					'id' => 1261,
					'name' => 'Faizabad',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				261 =>
				array (
					'id' => 1262,
					'name' => 'Etawah',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				262 =>
				array (
					'id' => 1263,
					'name' => 'Pathankot',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				263 =>
				array (
					'id' => 1264,
					'name' => 'Gandhinagar',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				264 =>
				array (
					'id' => 1265,
				'name' => 'Palghat (Palakkad)',
					'state_code' => 'IN18',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				265 =>
				array (
					'id' => 1266,
					'name' => 'Veraval',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				266 =>
				array (
					'id' => 1267,
					'name' => 'Hoshiarpur',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				267 =>
				array (
					'id' => 1268,
					'name' => 'Ambala',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				268 =>
				array (
					'id' => 1269,
					'name' => 'Sitapur',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				269 =>
				array (
					'id' => 1270,
					'name' => 'Bhiwani',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				270 =>
				array (
					'id' => 1271,
					'name' => 'Cuddapah',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				271 =>
				array (
					'id' => 1272,
					'name' => 'Bhimavaram',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				272 =>
				array (
					'id' => 1273,
					'name' => 'Krishnanagar',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				273 =>
				array (
					'id' => 1274,
					'name' => 'Chandannagar',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				274 =>
				array (
					'id' => 1275,
					'name' => 'Mandya',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				275 =>
				array (
					'id' => 1276,
					'name' => 'Dibrugarh',
					'state_code' => 'IN4',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				276 =>
				array (
					'id' => 1277,
					'name' => 'Nandyal',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				277 =>
				array (
					'id' => 1278,
					'name' => 'Balurghat',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				278 =>
				array (
					'id' => 1279,
					'name' => 'Neyveli',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				279 =>
				array (
					'id' => 1280,
					'name' => 'Fatehpur',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				280 =>
				array (
					'id' => 1281,
					'name' => 'Mahbubnagar',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				281 =>
				array (
					'id' => 1282,
					'name' => 'Budaun',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				282 =>
				array (
					'id' => 1283,
					'name' => 'Porbandar',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				283 =>
				array (
					'id' => 1284,
					'name' => 'Silchar',
					'state_code' => 'IN4',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				284 =>
				array (
					'id' => 1285,
				'name' => 'Berhampore (Baharampur)',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				285 =>
				array (
					'id' => 1286,
				'name' => 'Purnea (Purnia)',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				286 =>
				array (
					'id' => 1287,
					'name' => 'Bankura',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				287 =>
				array (
					'id' => 1288,
					'name' => 'Rajapalaiyam',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				288 =>
				array (
					'id' => 1289,
					'name' => 'Titagarh',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				289 =>
				array (
					'id' => 1290,
					'name' => 'Halisahar',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				290 =>
				array (
					'id' => 1291,
					'name' => 'Hathras',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				291 =>
				array (
					'id' => 1292,
				'name' => 'Bhir (Bid)',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				292 =>
				array (
					'id' => 1293,
					'name' => 'Pallavaram',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				293 =>
				array (
					'id' => 1294,
					'name' => 'Anand',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				294 =>
				array (
					'id' => 1295,
					'name' => 'Mango',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				295 =>
				array (
					'id' => 1296,
					'name' => 'Santipur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				296 =>
				array (
					'id' => 1297,
					'name' => 'Bhind',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				297 =>
				array (
					'id' => 1298,
					'name' => 'Gondiya',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				298 =>
				array (
					'id' => 1299,
					'name' => 'Tiruvannamalai',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				299 =>
				array (
					'id' => 1300,
				'name' => 'Yeotmal (Yavatmal)',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				300 =>
				array (
					'id' => 1301,
					'name' => 'Kulti-Barakar',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				301 =>
				array (
					'id' => 1302,
					'name' => 'Moga',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				302 =>
				array (
					'id' => 1303,
					'name' => 'Shivapuri',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				303 =>
				array (
					'id' => 1304,
					'name' => 'Bidar',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				304 =>
				array (
					'id' => 1305,
					'name' => 'Guntakal',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				305 =>
				array (
					'id' => 1306,
					'name' => 'Unnao',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				306 =>
				array (
					'id' => 1307,
					'name' => 'Barasat',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				307 =>
				array (
					'id' => 1308,
					'name' => 'Tambaram',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				308 =>
				array (
					'id' => 1309,
					'name' => 'Abohar',
					'state_code' => 'IN28',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				309 =>
				array (
					'id' => 1310,
					'name' => 'Pilibhit',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				310 =>
				array (
					'id' => 1311,
					'name' => 'Valparai',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				311 =>
				array (
					'id' => 1312,
					'name' => 'Gonda',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				312 =>
				array (
					'id' => 1313,
					'name' => 'Surendranagar',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				313 =>
				array (
					'id' => 1314,
					'name' => 'Qutubullapur',
					'state_code' => 'IN32',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				314 =>
				array (
					'id' => 1315,
					'name' => 'Beawar',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				315 =>
				array (
					'id' => 1316,
					'name' => 'Hindupur',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				316 =>
				array (
					'id' => 1317,
					'name' => 'Gandhidham',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				317 =>
				array (
					'id' => 1318,
					'name' => 'Haldwani-cum-Kathgodam',
					'state_code' => 'IN35',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				318 =>
				array (
					'id' => 1319,
				'name' => 'Tellicherry (Thalassery)',
					'state_code' => 'IN18',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				319 =>
				array (
					'id' => 1320,
					'name' => 'Wardha',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				320 =>
				array (
					'id' => 1321,
					'name' => 'Rishra',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				321 =>
				array (
					'id' => 1322,
					'name' => 'Bhuj',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				322 =>
				array (
					'id' => 1323,
					'name' => 'Modinagar',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				323 =>
				array (
					'id' => 1324,
					'name' => 'Gudivada',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				324 =>
				array (
					'id' => 1325,
					'name' => 'Basirhat',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				325 =>
				array (
					'id' => 1326,
					'name' => 'Uttarpara-Kotrung',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				326 =>
				array (
					'id' => 1327,
					'name' => 'Ongole',
					'state_code' => 'IN2',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				327 =>
				array (
					'id' => 1328,
					'name' => 'North Barrackpur',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				328 =>
				array (
					'id' => 1329,
					'name' => 'Guna',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				329 =>
				array (
					'id' => 1330,
					'name' => 'Haldia',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				330 =>
				array (
					'id' => 1331,
					'name' => 'Habra',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				331 =>
				array (
					'id' => 1332,
					'name' => 'Kanchrapara',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				332 =>
				array (
					'id' => 1333,
					'name' => 'Tonk',
					'state_code' => 'IN29',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				333 =>
				array (
					'id' => 1334,
					'name' => 'Champdani',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				334 =>
				array (
					'id' => 1335,
					'name' => 'Orai',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				335 =>
				array (
					'id' => 1336,
					'name' => 'Pudukkottai',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				336 =>
				array (
					'id' => 1337,
					'name' => 'Sasaram',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				337 =>
				array (
					'id' => 1338,
					'name' => 'Hazaribag',
					'state_code' => 'IN16',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				338 =>
				array (
					'id' => 1339,
					'name' => 'Palayankottai',
					'state_code' => 'IN31',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				339 =>
				array (
					'id' => 1340,
					'name' => 'Banda',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				340 =>
				array (
					'id' => 1341,
					'name' => 'Godhra',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				341 =>
				array (
					'id' => 1342,
					'name' => 'Hospet',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				342 =>
				array (
					'id' => 1343,
					'name' => 'Ashoknagar-Kalyangarh',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				343 =>
				array (
					'id' => 1344,
					'name' => 'Achalpur',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				344 =>
				array (
					'id' => 1345,
					'name' => 'Patan',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				345 =>
				array (
					'id' => 1346,
					'name' => 'Mandasor',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				346 =>
				array (
					'id' => 1347,
					'name' => 'Damoh',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				347 =>
				array (
					'id' => 1348,
					'name' => 'Satara',
					'state_code' => 'IN21',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				348 =>
				array (
					'id' => 1349,
					'name' => 'Meerut Cantonment',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				349 =>
				array (
					'id' => 1350,
					'name' => 'Dehri',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				350 =>
				array (
					'id' => 1351,
					'name' => 'Delhi Cantonment',
					'state_code' => 'IN10',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				351 =>
				array (
					'id' => 1352,
					'name' => 'Chhindwara',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				352 =>
				array (
					'id' => 1353,
					'name' => 'Bansberia',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				353 =>
				array (
					'id' => 1354,
					'name' => 'Nagaon',
					'state_code' => 'IN4',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				354 =>
				array (
					'id' => 1355,
					'name' => 'Kanpur Cantonment',
					'state_code' => 'IN34',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				355 =>
				array (
					'id' => 1356,
					'name' => 'Vidisha',
					'state_code' => 'IN20',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				356 =>
				array (
					'id' => 1357,
					'name' => 'Bettiah',
					'state_code' => 'IN5',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				357 =>
				array (
					'id' => 1358,
					'name' => 'Purulia',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				358 =>
				array (
					'id' => 1359,
					'name' => 'Hassan',
					'state_code' => 'IN17',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				359 =>
				array (
					'id' => 1360,
					'name' => 'Ambala Sadar',
					'state_code' => 'IN13',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				360 =>
				array (
					'id' => 1361,
					'name' => 'Baidyabati',
					'state_code' => 'IN36',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				361 =>
				array (
					'id' => 1362,
					'name' => 'Morvi',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				362 =>
				array (
					'id' => 1363,
					'name' => 'Raigarh',
					'state_code' => 'IN7',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				363 =>
				array (
					'id' => 1364,
					'name' => 'Vejalpur',
					'state_code' => 'IN12',
					'country_code' => 'IND',
					'created_at' => $now,
					'updated_at' => $now,
				),
				364 =>
				array (
					'id' => 1365,
					'name' => 'Baghdad',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				365 =>
				array (
					'id' => 1366,
					'name' => 'Mosul',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				366 =>
				array (
					'id' => 1367,
					'name' => 'Irbil',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				367 =>
				array (
					'id' => 1368,
					'name' => 'Kirkuk',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				368 =>
				array (
					'id' => 1369,
					'name' => 'Basra',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				369 =>
				array (
					'id' => 1370,
					'name' => 'al-Sulaymaniya',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				370 =>
				array (
					'id' => 1371,
					'name' => 'al-Najaf',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				371 =>
				array (
					'id' => 1372,
					'name' => 'Karbala',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				372 =>
				array (
					'id' => 1373,
					'name' => 'al-Hilla',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				373 =>
				array (
					'id' => 1374,
					'name' => 'al-Nasiriya',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				374 =>
				array (
					'id' => 1375,
					'name' => 'al-Amara',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				375 =>
				array (
					'id' => 1376,
					'name' => 'al-Diwaniya',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				376 =>
				array (
					'id' => 1377,
					'name' => 'al-Ramadi',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				377 =>
				array (
					'id' => 1378,
					'name' => 'al-Kut',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				378 =>
				array (
					'id' => 1379,
					'name' => 'Baquba',
					'state_code' => '',
					'country_code' => 'IRQ',
					'created_at' => $now,
					'updated_at' => $now,
				),
				379 =>
				array (
					'id' => 1380,
					'name' => 'Teheran',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				380 =>
				array (
					'id' => 1381,
					'name' => 'Mashhad',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				381 =>
				array (
					'id' => 1382,
					'name' => 'Esfahan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				382 =>
				array (
					'id' => 1383,
					'name' => 'Tabriz',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				383 =>
				array (
					'id' => 1384,
					'name' => 'Shiraz',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				384 =>
				array (
					'id' => 1385,
					'name' => 'Karaj',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				385 =>
				array (
					'id' => 1386,
					'name' => 'Ahvaz',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				386 =>
				array (
					'id' => 1387,
					'name' => 'Qom',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				387 =>
				array (
					'id' => 1388,
					'name' => 'Kermanshah',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				388 =>
				array (
					'id' => 1389,
					'name' => 'Urmia',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				389 =>
				array (
					'id' => 1390,
					'name' => 'Zahedan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				390 =>
				array (
					'id' => 1391,
					'name' => 'Rasht',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				391 =>
				array (
					'id' => 1392,
					'name' => 'Hamadan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				392 =>
				array (
					'id' => 1393,
					'name' => 'Kerman',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				393 =>
				array (
					'id' => 1394,
					'name' => 'Arak',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				394 =>
				array (
					'id' => 1395,
					'name' => 'Ardebil',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				395 =>
				array (
					'id' => 1396,
					'name' => 'Yazd',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				396 =>
				array (
					'id' => 1397,
					'name' => 'Qazvin',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				397 =>
				array (
					'id' => 1398,
					'name' => 'Zanjan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				398 =>
				array (
					'id' => 1399,
					'name' => 'Sanandaj',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				399 =>
				array (
					'id' => 1400,
					'name' => 'Bandar-e-Abbas',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				400 =>
				array (
					'id' => 1401,
					'name' => 'Khorramabad',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				401 =>
				array (
					'id' => 1402,
					'name' => 'Eslamshahr',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				402 =>
				array (
					'id' => 1403,
					'name' => 'Borujerd',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				403 =>
				array (
					'id' => 1404,
					'name' => 'Abadan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				404 =>
				array (
					'id' => 1405,
					'name' => 'Dezful',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				405 =>
				array (
					'id' => 1406,
					'name' => 'Kashan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				406 =>
				array (
					'id' => 1407,
					'name' => 'Sari',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				407 =>
				array (
					'id' => 1408,
					'name' => 'Gorgan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				408 =>
				array (
					'id' => 1409,
					'name' => 'Najafabad',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				409 =>
				array (
					'id' => 1410,
					'name' => 'Sabzevar',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				410 =>
				array (
					'id' => 1411,
					'name' => 'Khomeynishahr',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				411 =>
				array (
					'id' => 1412,
					'name' => 'Amol',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				412 =>
				array (
					'id' => 1413,
					'name' => 'Neyshabur',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				413 =>
				array (
					'id' => 1414,
					'name' => 'Babol',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				414 =>
				array (
					'id' => 1415,
					'name' => 'Khoy',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				415 =>
				array (
					'id' => 1416,
					'name' => 'Malayer',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				416 =>
				array (
					'id' => 1417,
					'name' => 'Bushehr',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				417 =>
				array (
					'id' => 1418,
					'name' => 'Qaemshahr',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				418 =>
				array (
					'id' => 1419,
					'name' => 'Qarchak',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				419 =>
				array (
					'id' => 1420,
					'name' => 'Qods',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				420 =>
				array (
					'id' => 1421,
					'name' => 'Sirjan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				421 =>
				array (
					'id' => 1422,
					'name' => 'Bojnurd',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				422 =>
				array (
					'id' => 1423,
					'name' => 'Maragheh',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				423 =>
				array (
					'id' => 1424,
					'name' => 'Birjand',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				424 =>
				array (
					'id' => 1425,
					'name' => 'Ilam',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				425 =>
				array (
					'id' => 1426,
					'name' => 'Bukan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				426 =>
				array (
					'id' => 1427,
					'name' => 'Masjed-e-Soleyman',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				427 =>
				array (
					'id' => 1428,
					'name' => 'Saqqez',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				428 =>
				array (
					'id' => 1429,
					'name' => 'Gonbad-e Qabus',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				429 =>
				array (
					'id' => 1430,
					'name' => 'Saveh',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				430 =>
				array (
					'id' => 1431,
					'name' => 'Mahabad',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				431 =>
				array (
					'id' => 1432,
					'name' => 'Varamin',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				432 =>
				array (
					'id' => 1433,
					'name' => 'Andimeshk',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				433 =>
				array (
					'id' => 1434,
					'name' => 'Khorramshahr',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				434 =>
				array (
					'id' => 1435,
					'name' => 'Shahrud',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				435 =>
				array (
					'id' => 1436,
					'name' => 'Marv Dasht',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				436 =>
				array (
					'id' => 1437,
					'name' => 'Zabol',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				437 =>
				array (
					'id' => 1438,
					'name' => 'Shahr-e Kord',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				438 =>
				array (
					'id' => 1439,
					'name' => 'Bandar-e Anzali',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				439 =>
				array (
					'id' => 1440,
					'name' => 'Rafsanjan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				440 =>
				array (
					'id' => 1441,
					'name' => 'Marand',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				441 =>
				array (
					'id' => 1442,
					'name' => 'Torbat-e Heydariyeh',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				442 =>
				array (
					'id' => 1443,
					'name' => 'Jahrom',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				443 =>
				array (
					'id' => 1444,
					'name' => 'Semnan',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				444 =>
				array (
					'id' => 1445,
					'name' => 'Miandoab',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				445 =>
				array (
					'id' => 1446,
					'name' => 'Qomsheh',
					'state_code' => '',
					'country_code' => 'IRN',
					'created_at' => $now,
					'updated_at' => $now,
				),
				446 =>
				array (
					'id' => 1447,
					'name' => 'Dublin',
					'state_code' => '',
					'country_code' => 'IRL',
					'created_at' => $now,
					'updated_at' => $now,
				),
				447 =>
				array (
					'id' => 1448,
					'name' => 'Cork',
					'state_code' => '',
					'country_code' => 'IRL',
					'created_at' => $now,
					'updated_at' => $now,
				),
				448 =>
				array (
					'id' => 1449,
					'name' => 'Reykjavík',
					'state_code' => '',
					'country_code' => 'ISL',
					'created_at' => $now,
					'updated_at' => $now,
				),
				449 =>
				array (
					'id' => 1450,
					'name' => 'Jerusalem',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				450 =>
				array (
					'id' => 1451,
					'name' => 'Tel Aviv-Jaffa',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				451 =>
				array (
					'id' => 1452,
					'name' => 'Haifa',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				452 =>
				array (
					'id' => 1453,
					'name' => 'Rishon Le Ziyyon',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				453 =>
				array (
					'id' => 1454,
					'name' => 'Beerseba',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				454 =>
				array (
					'id' => 1455,
					'name' => 'Holon',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				455 =>
				array (
					'id' => 1456,
					'name' => 'Petah Tiqwa',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				456 =>
				array (
					'id' => 1457,
					'name' => 'Ashdod',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				457 =>
				array (
					'id' => 1458,
					'name' => 'Netanya',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				458 =>
				array (
					'id' => 1459,
					'name' => 'Bat Yam',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				459 =>
				array (
					'id' => 1460,
					'name' => 'Bene Beraq',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				460 =>
				array (
					'id' => 1461,
					'name' => 'Ramat Gan',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				461 =>
				array (
					'id' => 1462,
					'name' => 'Ashqelon',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				462 =>
				array (
					'id' => 1463,
					'name' => 'Rehovot',
					'state_code' => '',
					'country_code' => 'ISR',
					'created_at' => $now,
					'updated_at' => $now,
				),
				463 =>
				array (
					'id' => 1464,
					'name' => 'Roma',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				464 =>
				array (
					'id' => 1465,
					'name' => 'Milano',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				465 =>
				array (
					'id' => 1466,
					'name' => 'Napoli',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				466 =>
				array (
					'id' => 1467,
					'name' => 'Torino',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				467 =>
				array (
					'id' => 1468,
					'name' => 'Palermo',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				468 =>
				array (
					'id' => 1469,
					'name' => 'Genova',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				469 =>
				array (
					'id' => 1470,
					'name' => 'Bologna',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				470 =>
				array (
					'id' => 1471,
					'name' => 'Firenze',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				471 =>
				array (
					'id' => 1472,
					'name' => 'Catania',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				472 =>
				array (
					'id' => 1473,
					'name' => 'Bari',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				473 =>
				array (
					'id' => 1474,
					'name' => 'Venezia',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				474 =>
				array (
					'id' => 1475,
					'name' => 'Messina',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				475 =>
				array (
					'id' => 1476,
					'name' => 'Verona',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				476 =>
				array (
					'id' => 1477,
					'name' => 'Trieste',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				477 =>
				array (
					'id' => 1478,
					'name' => 'Padova',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				478 =>
				array (
					'id' => 1479,
					'name' => 'Taranto',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				479 =>
				array (
					'id' => 1480,
					'name' => 'Brescia',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				480 =>
				array (
					'id' => 1481,
					'name' => 'Reggio di Calabria',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				481 =>
				array (
					'id' => 1482,
					'name' => 'Modena',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				482 =>
				array (
					'id' => 1483,
					'name' => 'Prato',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				483 =>
				array (
					'id' => 1484,
					'name' => 'Parma',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				484 =>
				array (
					'id' => 1485,
					'name' => 'Cagliari',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				485 =>
				array (
					'id' => 1486,
					'name' => 'Livorno',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				486 =>
				array (
					'id' => 1487,
					'name' => 'Perugia',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				487 =>
				array (
					'id' => 1488,
					'name' => 'Foggia',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				488 =>
				array (
					'id' => 1489,
					'name' => 'Reggio nell´ Emilia',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				489 =>
				array (
					'id' => 1490,
					'name' => 'Salerno',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				490 =>
				array (
					'id' => 1491,
					'name' => 'Ravenna',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				491 =>
				array (
					'id' => 1492,
					'name' => 'Ferrara',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				492 =>
				array (
					'id' => 1493,
					'name' => 'Rimini',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				493 =>
				array (
					'id' => 1494,
					'name' => 'Syrakusa',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				494 =>
				array (
					'id' => 1495,
					'name' => 'Sassari',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				495 =>
				array (
					'id' => 1496,
					'name' => 'Monza',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				496 =>
				array (
					'id' => 1497,
					'name' => 'Bergamo',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				497 =>
				array (
					'id' => 1498,
					'name' => 'Pescara',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				498 =>
				array (
					'id' => 1499,
					'name' => 'Latina',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
				499 =>
				array (
					'id' => 1500,
					'name' => 'Vicenza',
					'state_code' => '',
					'country_code' => 'ITA',
					'created_at' => $now,
					'updated_at' => $now,
				),
			));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 1501,
				'name' => 'Terni',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 1502,
				'name' => 'Forlì',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 1503,
				'name' => 'Trento',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 1504,
				'name' => 'Novara',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 1505,
				'name' => 'Piacenza',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 1506,
				'name' => 'Ancona',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 1507,
				'name' => 'Lecce',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 1508,
				'name' => 'Bolzano',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 1509,
				'name' => 'Catanzaro',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 1510,
				'name' => 'La Spezia',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 1511,
				'name' => 'Udine',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 1512,
				'name' => 'Torre del Greco',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 1513,
				'name' => 'Andria',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 1514,
				'name' => 'Brindisi',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 1515,
				'name' => 'Giugliano in Campania',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 1516,
				'name' => 'Pisa',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 1517,
				'name' => 'Barletta',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 1518,
				'name' => 'Arezzo',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 1519,
				'name' => 'Alessandria',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 1520,
				'name' => 'Cesena',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 1521,
				'name' => 'Pesaro',
				'state_code' => '',
				'country_code' => 'ITA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 1522,
				'name' => 'Dili',
				'state_code' => '',
				'country_code' => 'TMP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 1523,
				'name' => 'Wien',
				'state_code' => '',
				'country_code' => 'AUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 1524,
				'name' => 'Graz',
				'state_code' => '',
				'country_code' => 'AUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 1525,
				'name' => 'Linz',
				'state_code' => '',
				'country_code' => 'AUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 1526,
				'name' => 'Salzburg',
				'state_code' => '',
				'country_code' => 'AUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 1527,
				'name' => 'Innsbruck',
				'state_code' => '',
				'country_code' => 'AUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 1528,
				'name' => 'Klagenfurt',
				'state_code' => '',
				'country_code' => 'AUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 1529,
				'name' => 'Spanish Town',
				'state_code' => '',
				'country_code' => 'JAM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 1530,
				'name' => 'Kingston',
				'state_code' => '',
				'country_code' => 'JAM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 1531,
				'name' => 'Portmore',
				'state_code' => '',
				'country_code' => 'JAM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 1532,
				'name' => 'Tokyo',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 1533,
				'name' => 'Jokohama [Yokohama]',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 1534,
				'name' => 'Osaka',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 1535,
				'name' => 'Nagoya',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 1536,
				'name' => 'Sapporo',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 1537,
				'name' => 'Kioto',
				'state_code' => 'JP26',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 1538,
				'name' => 'Kobe',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 1539,
				'name' => 'Fukuoka',
				'state_code' => 'JP40',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 1540,
				'name' => 'Kawasaki',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 1541,
				'name' => 'Hiroshima',
				'state_code' => 'JP34',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 1542,
				'name' => 'Kitakyushu',
				'state_code' => 'JP40',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 1543,
				'name' => 'Sendai',
				'state_code' => 'JP04',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 1544,
				'name' => 'Chiba',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 1545,
				'name' => 'Sakai',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 1546,
				'name' => 'Kumamoto',
				'state_code' => 'JP43',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 1547,
				'name' => 'Okayama',
				'state_code' => 'JP33',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 1548,
				'name' => 'Sagamihara',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 1549,
				'name' => 'Hamamatsu',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 1550,
				'name' => 'Kagoshima',
				'state_code' => 'JP46',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 1551,
				'name' => 'Funabashi',
				'state_code' => 'JP42',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 1552,
				'name' => 'Higashiosaka',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 1553,
				'name' => 'Hachioji',
				'state_code' => 'JP43',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 1554,
				'name' => 'Niigata',
				'state_code' => 'JP45',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 1555,
				'name' => 'Amagasaki',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 1556,
				'name' => 'Himeji',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 1557,
				'name' => 'Shizuoka',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 1558,
				'name' => 'Urawa',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 1559,
				'name' => 'Matsuyama',
				'state_code' => 'JP38',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 1560,
				'name' => 'Matsudo',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 1561,
				'name' => 'Kanazawa',
				'state_code' => 'JP17',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 1562,
				'name' => 'Kawaguchi',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 1563,
				'name' => 'Ichikawa',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 1564,
				'name' => 'Omiya',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 1565,
				'name' => 'Utsunomiya',
				'state_code' => 'JP09',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 1566,
				'name' => 'Oita',
				'state_code' => 'JP44',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 1567,
				'name' => 'Nagasaki',
				'state_code' => 'JP42',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 1568,
				'name' => 'Yokosuka',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 1569,
				'name' => 'Kurashiki',
				'state_code' => 'JP33',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 1570,
				'name' => 'Gifu',
				'state_code' => 'JP21',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 1571,
				'name' => 'Hirakata',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 1572,
				'name' => 'Nishinomiya',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 1573,
				'name' => 'Toyonaka',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 1574,
				'name' => 'Wakayama',
				'state_code' => 'JP30',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 1575,
				'name' => 'Fukuyama',
				'state_code' => 'JP34',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 1576,
				'name' => 'Fujisawa',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 1577,
				'name' => 'Asahikawa',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 1578,
				'name' => 'Machida',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 1579,
				'name' => 'Nara',
				'state_code' => 'JP29',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 1580,
				'name' => 'Takatsuki',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 1581,
				'name' => 'Iwaki',
				'state_code' => 'JP07',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 1582,
				'name' => 'Nagano',
				'state_code' => 'JP20',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 1583,
				'name' => 'Toyohashi',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 1584,
				'name' => 'Toyota',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 1585,
				'name' => 'Suita',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 1586,
				'name' => 'Takamatsu',
				'state_code' => 'JP37',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 1587,
				'name' => 'Koriyama',
				'state_code' => 'JP07',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 1588,
				'name' => 'Okazaki',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 1589,
				'name' => 'Kawagoe',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 1590,
				'name' => 'Tokorozawa',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 1591,
				'name' => 'Toyama',
				'state_code' => 'JP16',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 1592,
				'name' => 'Kochi',
				'state_code' => 'JP39',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 1593,
				'name' => 'Kashiwa',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 1594,
				'name' => 'Akita',
				'state_code' => 'JP05',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 1595,
				'name' => 'Miyazaki',
				'state_code' => 'JP45',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 1596,
				'name' => 'Koshigaya',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 1597,
				'name' => 'Naha',
				'state_code' => 'JP47',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 1598,
				'name' => 'Aomori',
				'state_code' => 'JP02',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 1599,
				'name' => 'Hakodate',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 1600,
				'name' => 'Akashi',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 1601,
				'name' => 'Yokkaichi',
				'state_code' => 'JP24',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 1602,
				'name' => 'Fukushima',
				'state_code' => 'JP07',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 1603,
				'name' => 'Morioka',
				'state_code' => 'JP03',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 1604,
				'name' => 'Maebashi',
				'state_code' => 'JP10',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 1605,
				'name' => 'Kasugai',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 1606,
				'name' => 'Otsu',
				'state_code' => 'JP25',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 1607,
				'name' => 'Ichihara',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 1608,
				'name' => 'Yao',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 1609,
				'name' => 'Ichinomiya',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 1610,
				'name' => 'Tokushima',
				'state_code' => 'JP36',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 1611,
				'name' => 'Kakogawa',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 1612,
				'name' => 'Ibaraki',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 1613,
				'name' => 'Neyagawa',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 1614,
				'name' => 'Shimonoseki',
				'state_code' => 'JP35',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 1615,
				'name' => 'Yamagata',
				'state_code' => 'JP06',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 1616,
				'name' => 'Fukui',
				'state_code' => 'JP18',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 1617,
				'name' => 'Hiratsuka',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 1618,
				'name' => 'Mito',
				'state_code' => 'JP08',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 1619,
				'name' => 'Sasebo',
				'state_code' => 'JP42',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 1620,
				'name' => 'Hachinohe',
				'state_code' => 'JP02',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 1621,
				'name' => 'Takasaki',
				'state_code' => 'JP10',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 1622,
				'name' => 'Shimizu',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 1623,
				'name' => 'Kurume',
				'state_code' => 'JP40',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 1624,
				'name' => 'Fuji',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 1625,
				'name' => 'Soka',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 1626,
				'name' => 'Fuchu',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 1627,
				'name' => 'Chigasaki',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 1628,
				'name' => 'Atsugi',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 1629,
				'name' => 'Numazu',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 1630,
				'name' => 'Ageo',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 1631,
				'name' => 'Yamato',
				'state_code' => 'JP29',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 1632,
				'name' => 'Matsumoto',
				'state_code' => 'JP20',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 1633,
				'name' => 'Kure',
				'state_code' => 'JP34',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 1634,
				'name' => 'Takarazuka',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 1635,
				'name' => 'Kasukabe',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 1636,
				'name' => 'Chofu',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 1637,
				'name' => 'Odawara',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 1638,
				'name' => 'Kofu',
				'state_code' => 'JP19',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 1639,
				'name' => 'Kushiro',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 1640,
				'name' => 'Kishiwada',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 1641,
				'name' => 'Hitachi',
				'state_code' => 'JP08',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 1642,
				'name' => 'Nagaoka',
				'state_code' => 'JP26',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 1643,
				'name' => 'Itami',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 1644,
				'name' => 'Uji',
				'state_code' => 'JP26',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 1645,
				'name' => 'Suzuka',
				'state_code' => 'JP24',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 1646,
				'name' => 'Hirosaki',
				'state_code' => 'JP02',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 1647,
				'name' => 'Ube',
				'state_code' => 'JP35',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 1648,
				'name' => 'Kodaira',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 1649,
				'name' => 'Takaoka',
				'state_code' => 'JP16',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 1650,
				'name' => 'Obihiro',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 1651,
				'name' => 'Tomakomai',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 1652,
				'name' => 'Saga',
				'state_code' => 'JP41',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 1653,
				'name' => 'Sakura',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 1654,
				'name' => 'Kamakura',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 1655,
				'name' => 'Mitaka',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 1656,
				'name' => 'Izumi',
				'state_code' => 'JP46',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 1657,
				'name' => 'Hino',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 1658,
				'name' => 'Hadano',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 1659,
				'name' => 'Ashikaga',
				'state_code' => 'JP09',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 1660,
				'name' => 'Tsu',
				'state_code' => 'JP24',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 1661,
				'name' => 'Sayama',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 1662,
				'name' => 'Yachiyo',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 1663,
				'name' => 'Tsukuba',
				'state_code' => 'JP08',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 1664,
				'name' => 'Tachikawa',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 1665,
				'name' => 'Kumagaya',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 1666,
				'name' => 'Moriguchi',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 1667,
				'name' => 'Otaru',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 1668,
				'name' => 'Anjo',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 1669,
				'name' => 'Narashino',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 1670,
				'name' => 'Oyama',
				'state_code' => 'JP09',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 1671,
				'name' => 'Ogaki',
				'state_code' => 'JP21',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 1672,
				'name' => 'Matsue',
				'state_code' => 'JP32',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 1673,
				'name' => 'Kawanishi',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 1674,
				'name' => 'Hitachinaka',
				'state_code' => 'JP08',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 1675,
				'name' => 'Niiza',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 1676,
				'name' => 'Nagareyama',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 1677,
				'name' => 'Tottori',
				'state_code' => 'JP31',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 1678,
				'name' => 'Tama',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 1679,
				'name' => 'Iruma',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 1680,
				'name' => 'Ota',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 1681,
				'name' => 'Omuta',
				'state_code' => 'JP40',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 1682,
				'name' => 'Komaki',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 1683,
				'name' => 'Ome',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 1684,
				'name' => 'Kadoma',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 1685,
				'name' => 'Yamaguchi',
				'state_code' => 'JP35',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 1686,
				'name' => 'Higashimurayama',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 1687,
				'name' => 'Yonago',
				'state_code' => 'JP31',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 1688,
				'name' => 'Matsubara',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 1689,
				'name' => 'Musashino',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 1690,
				'name' => 'Tsuchiura',
				'state_code' => 'JP08',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 1691,
				'name' => 'Joetsu',
				'state_code' => 'JP15',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 1692,
				'name' => 'Miyakonojo',
				'state_code' => 'JP45',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 1693,
				'name' => 'Misato',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 1694,
				'name' => 'Kakamigahara',
				'state_code' => 'JP21',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 1695,
				'name' => 'Daito',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 1696,
				'name' => 'Seto',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 1697,
				'name' => 'Kariya',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 1698,
				'name' => 'Urayasu',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 1699,
				'name' => 'Beppu',
				'state_code' => 'JP44',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 1700,
				'name' => 'Niihama',
				'state_code' => 'JP38',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 1701,
				'name' => 'Minoo',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 1702,
				'name' => 'Fujieda',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 1703,
				'name' => 'Abiko',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 1704,
				'name' => 'Nobeoka',
				'state_code' => 'JP45',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 1705,
				'name' => 'Tondabayashi',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 1706,
				'name' => 'Ueda',
				'state_code' => 'JP20',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 1707,
				'name' => 'Kashihara',
				'state_code' => 'JP29',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 1708,
				'name' => 'Matsusaka',
				'state_code' => 'JP24',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 1709,
				'name' => 'Isesaki',
				'state_code' => 'JP10',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 1710,
				'name' => 'Zama',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 1711,
				'name' => 'Kisarazu',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 1712,
				'name' => 'Noda',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 1713,
				'name' => 'Ishinomaki',
				'state_code' => 'JP04',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 1714,
				'name' => 'Fujinomiya',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 1715,
				'name' => 'Kawachinagano',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 1716,
				'name' => 'Imabari',
				'state_code' => 'JP38',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 1717,
				'name' => 'Aizuwakamatsu',
				'state_code' => 'JP07',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 1718,
				'name' => 'Higashihiroshima',
				'state_code' => 'JP34',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 1719,
				'name' => 'Habikino',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 1720,
				'name' => 'Ebetsu',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 1721,
				'name' => 'Hofu',
				'state_code' => 'JP35',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 1722,
				'name' => 'Kiryu',
				'state_code' => 'JP10',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 1723,
				'name' => 'Okinawa',
				'state_code' => 'JP47',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 1724,
				'name' => 'Yaizu',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 1725,
				'name' => 'Toyokawa',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 1726,
				'name' => 'Ebina',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 1727,
				'name' => 'Asaka',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 1728,
				'name' => 'Higashikurume',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 1729,
				'name' => 'Ikoma',
				'state_code' => 'JP29',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 1730,
				'name' => 'Kitami',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 1731,
				'name' => 'Koganei',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 1732,
				'name' => 'Iwatsuki',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 1733,
				'name' => 'Mishima',
				'state_code' => 'JP22',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 1734,
				'name' => 'Handa',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 1735,
				'name' => 'Muroran',
				'state_code' => 'JP01',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 1736,
				'name' => 'Komatsu',
				'state_code' => 'JP17',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 1737,
				'name' => 'Yatsushiro',
				'state_code' => 'JP43',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 1738,
				'name' => 'Iida',
				'state_code' => 'JP20',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 1739,
				'name' => 'Tokuyama',
				'state_code' => 'JP35',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 1740,
				'name' => 'Kokubunji',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 1741,
				'name' => 'Akishima',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 1742,
				'name' => 'Iwakuni',
				'state_code' => 'JP35',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 1743,
				'name' => 'Kusatsu',
				'state_code' => 'JP25',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 1744,
				'name' => 'Kuwana',
				'state_code' => 'JP24',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 1745,
				'name' => 'Sanda',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 1746,
				'name' => 'Hikone',
				'state_code' => 'JP25',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 1747,
				'name' => 'Toda',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 1748,
				'name' => 'Tajimi',
				'state_code' => 'JP21',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 1749,
				'name' => 'Ikeda',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 1750,
				'name' => 'Fukaya',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 1751,
				'name' => 'Ise',
				'state_code' => 'JP24',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 1752,
				'name' => 'Sakata',
				'state_code' => 'JP06',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 1753,
				'name' => 'Kasuga',
				'state_code' => 'JP40',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 1754,
				'name' => 'Kamagaya',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 1755,
				'name' => 'Tsuruoka',
				'state_code' => 'JP06',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 1756,
				'name' => 'Hoya',
				'state_code' => 'JP13',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 1757,
				'name' => 'Nishio',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 1758,
				'name' => 'Tokai',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 1759,
				'name' => 'Inazawa',
				'state_code' => 'JP23',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 1760,
				'name' => 'Sakado',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 1761,
				'name' => 'Isehara',
				'state_code' => 'JP14',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 1762,
				'name' => 'Takasago',
				'state_code' => 'JP28',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 1763,
				'name' => 'Fujimi',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 1764,
				'name' => 'Urasoe',
				'state_code' => 'JP47',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 1765,
				'name' => 'Yonezawa',
				'state_code' => 'JP06',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 1766,
				'name' => 'Konan',
				'state_code' => 'JP39',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 1767,
				'name' => 'Yamatokoriyama',
				'state_code' => 'JP29',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 1768,
				'name' => 'Maizuru',
				'state_code' => 'JP26',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 1769,
				'name' => 'Onomichi',
				'state_code' => 'JP34',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 1770,
				'name' => 'Higashimatsuyama',
				'state_code' => 'JP11',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 1771,
				'name' => 'Kimitsu',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 1772,
				'name' => 'Isahaya',
				'state_code' => 'JP42',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 1773,
				'name' => 'Kanuma',
				'state_code' => 'JP09',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 1774,
				'name' => 'Izumisano',
				'state_code' => 'JP27',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 1775,
				'name' => 'Kameoka',
				'state_code' => 'JP26',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 1776,
				'name' => 'Mobara',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 1777,
				'name' => 'Narita',
				'state_code' => 'JP12',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 1778,
				'name' => 'Kashiwazaki',
				'state_code' => 'JP15',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 1779,
				'name' => 'Tsuyama',
				'state_code' => 'JP33',
				'country_code' => 'JPN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 1780,
				'name' => 'Sanaa',
				'state_code' => '',
				'country_code' => 'YEM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 1781,
				'name' => 'Aden',
				'state_code' => '',
				'country_code' => 'YEM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 1782,
				'name' => 'Taizz',
				'state_code' => '',
				'country_code' => 'YEM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 1783,
				'name' => 'Hodeida',
				'state_code' => '',
				'country_code' => 'YEM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 1784,
				'name' => 'al-Mukalla',
				'state_code' => '',
				'country_code' => 'YEM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 1785,
				'name' => 'Ibb',
				'state_code' => '',
				'country_code' => 'YEM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 1786,
				'name' => 'Amman',
				'state_code' => '',
				'country_code' => 'JOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 1787,
				'name' => 'al-Zarqa',
				'state_code' => '',
				'country_code' => 'JOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 1788,
				'name' => 'Irbid',
				'state_code' => '',
				'country_code' => 'JOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 1789,
				'name' => 'al-Rusayfa',
				'state_code' => '',
				'country_code' => 'JOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 1790,
				'name' => 'Wadi al-Sir',
				'state_code' => '',
				'country_code' => 'JOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 1791,
				'name' => 'Flying Fish Cove',
				'state_code' => '',
				'country_code' => 'CXR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 1792,
				'name' => 'Beograd',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 1793,
				'name' => 'Novi Sad',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 1794,
				'name' => 'Niš',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 1795,
				'name' => 'Priština',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 1796,
				'name' => 'Kragujevac',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 1797,
				'name' => 'Podgorica',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 1798,
				'name' => 'Subotica',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 1799,
				'name' => 'Prizren',
				'state_code' => '',
				'country_code' => 'YUG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 1800,
				'name' => 'Phnom Penh',
				'state_code' => '',
				'country_code' => 'KHM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 1801,
				'name' => 'Battambang',
				'state_code' => '',
				'country_code' => 'KHM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 1802,
				'name' => 'Siem Reap',
				'state_code' => '',
				'country_code' => 'KHM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 1803,
				'name' => 'Douala',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 1804,
				'name' => 'Yaoundé',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 1805,
				'name' => 'Garoua',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 1806,
				'name' => 'Maroua',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 1807,
				'name' => 'Bamenda',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 1808,
				'name' => 'Bafoussam',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 1809,
				'name' => 'Nkongsamba',
				'state_code' => '',
				'country_code' => 'CMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 1810,
				'name' => 'Montréal',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 1811,
				'name' => 'Calgary',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 1812,
				'name' => 'Toronto',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 1813,
				'name' => 'North York',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 1814,
				'name' => 'Winnipeg',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 1815,
				'name' => 'Edmonton',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 1816,
				'name' => 'Mississauga',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 1817,
				'name' => 'Scarborough',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 1818,
				'name' => 'Vancouver',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 1819,
				'name' => 'Etobicoke',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 1820,
				'name' => 'London',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 1821,
				'name' => 'Hamilton',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 1822,
				'name' => 'Ottawa',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 1823,
				'name' => 'Laval',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 1824,
				'name' => 'Surrey',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 1825,
				'name' => 'Brampton',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 1826,
				'name' => 'Windsor',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 1827,
				'name' => 'Saskatoon',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 1828,
				'name' => 'Kitchener',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 1829,
				'name' => 'Markham',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 1830,
				'name' => 'Regina',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 1831,
				'name' => 'Burnaby',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 1832,
				'name' => 'Québec',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 1833,
				'name' => 'York',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 1834,
				'name' => 'Richmond',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 1835,
				'name' => 'Vaughan',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 1836,
				'name' => 'Burlington',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 1837,
				'name' => 'Oshawa',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 1838,
				'name' => 'Oakville',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 1839,
				'name' => 'Saint Catharines',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 1840,
				'name' => 'Longueuil',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 1841,
				'name' => 'Richmond Hill',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 1842,
				'name' => 'Thunder Bay',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 1843,
				'name' => 'Nepean',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 1844,
				'name' => 'Cape Breton',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 1845,
				'name' => 'East York',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 1846,
				'name' => 'Halifax',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 1847,
				'name' => 'Cambridge',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 1848,
				'name' => 'Gloucester',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 1849,
				'name' => 'Abbotsford',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 1850,
				'name' => 'Guelph',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 1851,
				'name' => 'Saint John´s',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 1852,
				'name' => 'Coquitlam',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 1853,
				'name' => 'Saanich',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 1854,
				'name' => 'Gatineau',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 1855,
				'name' => 'Delta',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 1856,
				'name' => 'Sudbury',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 1857,
				'name' => 'Kelowna',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 1858,
				'name' => 'Barrie',
				'state_code' => '',
				'country_code' => 'CAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 1859,
				'name' => 'Praia',
				'state_code' => '',
				'country_code' => 'CPV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 1860,
				'name' => 'Almaty',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 1861,
				'name' => 'Qaraghandy',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 1862,
				'name' => 'Shymkent',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 1863,
				'name' => 'Taraz',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 1864,
				'name' => 'Astana',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 1865,
				'name' => 'Öskemen',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 1866,
				'name' => 'Pavlodar',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 1867,
				'name' => 'Semey',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 1868,
				'name' => 'Aqtöbe',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 1869,
				'name' => 'Qostanay',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 1870,
				'name' => 'Petropavl',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 1871,
				'name' => 'Oral',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 1872,
				'name' => 'Temirtau',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 1873,
				'name' => 'Qyzylorda',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 1874,
				'name' => 'Aqtau',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 1875,
				'name' => 'Atyrau',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 1876,
				'name' => 'Ekibastuz',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 1877,
				'name' => 'Kökshetau',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 1878,
				'name' => 'Rudnyy',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 1879,
				'name' => 'Taldyqorghan',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 1880,
				'name' => 'Zhezqazghan',
				'state_code' => '',
				'country_code' => 'KAZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 1881,
				'name' => 'Nairobi',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 1882,
				'name' => 'Mombasa',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 1883,
				'name' => 'Kisumu',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 1884,
				'name' => 'Nakuru',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 1885,
				'name' => 'Machakos',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 1886,
				'name' => 'Eldoret',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 1887,
				'name' => 'Meru',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 1888,
				'name' => 'Nyeri',
				'state_code' => '',
				'country_code' => 'KEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 1889,
				'name' => 'Bangui',
				'state_code' => '',
				'country_code' => 'CAF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 1890,
				'name' => 'Shanghai',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 1891,
				'name' => 'Peking',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 1892,
				'name' => 'Chongqing',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 1893,
				'name' => 'Tianjin',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 1894,
				'name' => 'Wuhan',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 1895,
				'name' => 'Harbin',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 1896,
				'name' => 'Shenyang',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 1897,
				'name' => 'Kanton [Guangzhou]',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 1898,
				'name' => 'Chengdu',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 1899,
				'name' => 'Nanking [Nanjing]',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 1900,
				'name' => 'Changchun',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 1901,
				'name' => 'Xi´an',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 1902,
				'name' => 'Dalian',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 1903,
				'name' => 'Qingdao',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 1904,
				'name' => 'Jinan',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 1905,
				'name' => 'Hangzhou',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 1906,
				'name' => 'Zhengzhou',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 1907,
				'name' => 'Shijiazhuang',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 1908,
				'name' => 'Taiyuan',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 1909,
				'name' => 'Kunming',
				'state_code' => 'CH21',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 1910,
				'name' => 'Changsha',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 1911,
				'name' => 'Nanchang',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 1912,
				'name' => 'Fuzhou',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 1913,
				'name' => 'Lanzhou',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 1914,
				'name' => 'Guiyang',
				'state_code' => 'CH5',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 1915,
				'name' => 'Ningbo',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 1916,
				'name' => 'Hefei',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 1917,
				'name' => 'Urumtši [Ürümqi]',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 1918,
				'name' => 'Anshan',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 1919,
				'name' => 'Fushun',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 1920,
				'name' => 'Nanning',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 1921,
				'name' => 'Zibo',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 1922,
				'name' => 'Qiqihar',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 1923,
				'name' => 'Jilin',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 1924,
				'name' => 'Tangshan',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 1925,
				'name' => 'Baotou',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 1926,
				'name' => 'Shenzhen',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 1927,
				'name' => 'Hohhot',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 1928,
				'name' => 'Handan',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 1929,
				'name' => 'Wuxi',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 1930,
				'name' => 'Xuzhou',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 1931,
				'name' => 'Datong',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 1932,
				'name' => 'Yichun',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 1933,
				'name' => 'Benxi',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 1934,
				'name' => 'Luoyang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 1935,
				'name' => 'Suzhou',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 1936,
				'name' => 'Xining',
				'state_code' => 'CH16',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 1937,
				'name' => 'Huainan',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 1938,
				'name' => 'Jixi',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 1939,
				'name' => 'Daqing',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 1940,
				'name' => 'Fuxin',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 1941,
				'name' => 'Amoy [Xiamen]',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 1942,
				'name' => 'Liuzhou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 1943,
				'name' => 'Shantou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 1944,
				'name' => 'Jinzhou',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 1945,
				'name' => 'Mudanjiang',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 1946,
				'name' => 'Yinchuan',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 1947,
				'name' => 'Changzhou',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 1948,
				'name' => 'Zhangjiakou',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 1949,
				'name' => 'Dandong',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 1950,
				'name' => 'Hegang',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 1951,
				'name' => 'Kaifeng',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 1952,
				'name' => 'Jiamusi',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 1953,
				'name' => 'Liaoyang',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 1954,
				'name' => 'Hengyang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 1955,
				'name' => 'Baoding',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 1956,
				'name' => 'Hunjiang',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 1957,
				'name' => 'Xinxiang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 1958,
				'name' => 'Huangshi',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 1959,
				'name' => 'Haikou',
				'state_code' => 'CH6',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 1960,
				'name' => 'Yantai',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 1961,
				'name' => 'Bengbu',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 1962,
				'name' => 'Xiangtan',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 1963,
				'name' => 'Weifang',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 1964,
				'name' => 'Wuhu',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 1965,
				'name' => 'Pingxiang',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 1966,
				'name' => 'Yingkou',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 1967,
				'name' => 'Anyang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 1968,
				'name' => 'Panzhihua',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 1969,
				'name' => 'Pingdingshan',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 1970,
				'name' => 'Xiangfan',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 1971,
				'name' => 'Zhuzhou',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 1972,
				'name' => 'Jiaozuo',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 1973,
				'name' => 'Wenzhou',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 1974,
				'name' => 'Zhangjiang',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 1975,
				'name' => 'Zigong',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 1976,
				'name' => 'Shuangyashan',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 1977,
				'name' => 'Zaozhuang',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 1978,
				'name' => 'Yakeshi',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 1979,
				'name' => 'Yichang',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 1980,
				'name' => 'Zhenjiang',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 1981,
				'name' => 'Huaibei',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 1982,
				'name' => 'Qinhuangdao',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 1983,
				'name' => 'Guilin',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 1984,
				'name' => 'Liupanshui',
				'state_code' => 'CH5',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 1985,
				'name' => 'Panjin',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 1986,
				'name' => 'Yangquan',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 1987,
				'name' => 'Jinxi',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 1988,
				'name' => 'Liaoyuan',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 1989,
				'name' => 'Lianyungang',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 1990,
				'name' => 'Xianyang',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 1991,
				'name' => 'Tai´an',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 1992,
				'name' => 'Chifeng',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 1993,
				'name' => 'Shaoguan',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 1994,
				'name' => 'Nantong',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 1995,
				'name' => 'Leshan',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 1996,
				'name' => 'Baoji',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 1997,
				'name' => 'Linyi',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 1998,
				'name' => 'Tonghua',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 1999,
				'name' => 'Siping',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 2000,
				'name' => 'Changzhi',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 2001,
				'name' => 'Tengzhou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 2002,
				'name' => 'Chaozhou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 2003,
				'name' => 'Yangzhou',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 2004,
				'name' => 'Dongwan',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 2005,
				'name' => 'Ma´anshan',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 2006,
				'name' => 'Foshan',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 2007,
				'name' => 'Yueyang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 2008,
				'name' => 'Xingtai',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 2009,
				'name' => 'Changde',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 2010,
				'name' => 'Shihezi',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 2011,
				'name' => 'Yancheng',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 2012,
				'name' => 'Jiujiang',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 2013,
				'name' => 'Dongying',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 2014,
				'name' => 'Shashi',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 2015,
				'name' => 'Xintai',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 2016,
				'name' => 'Jingdezhen',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 2017,
				'name' => 'Tongchuan',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 2018,
				'name' => 'Zhongshan',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 2019,
				'name' => 'Shiyan',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 2020,
				'name' => 'Tieli',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 2021,
				'name' => 'Jining',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 2022,
				'name' => 'Wuhai',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 2023,
				'name' => 'Mianyang',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 2024,
				'name' => 'Luzhou',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 2025,
				'name' => 'Zunyi',
				'state_code' => 'CH5',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 2026,
				'name' => 'Shizuishan',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 2027,
				'name' => 'Neijiang',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 2028,
				'name' => 'Tongliao',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 2029,
				'name' => 'Tieling',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 2030,
				'name' => 'Wafangdian',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 2031,
				'name' => 'Anqing',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 2032,
				'name' => 'Shaoyang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 2033,
				'name' => 'Laiwu',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 2034,
				'name' => 'Chengde',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 2035,
				'name' => 'Tianshui',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 2036,
				'name' => 'Nanyang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 2037,
				'name' => 'Cangzhou',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 2038,
				'name' => 'Yibin',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 2039,
				'name' => 'Huaiyin',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 2040,
				'name' => 'Dunhua',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 2041,
				'name' => 'Yanji',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 2042,
				'name' => 'Jiangmen',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 2043,
				'name' => 'Tongling',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 2044,
				'name' => 'Suihua',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 2045,
				'name' => 'Gongziling',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 2046,
				'name' => 'Xiantao',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 2047,
				'name' => 'Chaoyang',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 2048,
				'name' => 'Ganzhou',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 2049,
				'name' => 'Huzhou',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 2050,
				'name' => 'Baicheng',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 2051,
				'name' => 'Shangzi',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 2052,
				'name' => 'Yangjiang',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 2053,
				'name' => 'Qitaihe',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 2054,
				'name' => 'Gejiu',
				'state_code' => 'CH21',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 2055,
				'name' => 'Jiangyin',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 2056,
				'name' => 'Hebi',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 2057,
				'name' => 'Jiaxing',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 2058,
				'name' => 'Wuzhou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 2059,
				'name' => 'Meihekou',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 2060,
				'name' => 'Xuchang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 2061,
				'name' => 'Liaocheng',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 2062,
				'name' => 'Haicheng',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 2063,
				'name' => 'Qianjiang',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 2064,
				'name' => 'Baiyin',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 2065,
				'name' => 'Bei´an',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 2066,
				'name' => 'Yixing',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 2067,
				'name' => 'Laizhou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 2068,
				'name' => 'Qaramay',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 2069,
				'name' => 'Acheng',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 2070,
				'name' => 'Dezhou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 2071,
				'name' => 'Nanping',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 2072,
				'name' => 'Zhaoqing',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 2073,
				'name' => 'Beipiao',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 2074,
				'name' => 'Fengcheng',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 2075,
				'name' => 'Fuyu',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 2076,
				'name' => 'Xinyang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 2077,
				'name' => 'Dongtai',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 2078,
				'name' => 'Yuci',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 2079,
				'name' => 'Honghu',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 2080,
				'name' => 'Ezhou',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 2081,
				'name' => 'Heze',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 2082,
				'name' => 'Daxian',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 2083,
				'name' => 'Linfen',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 2084,
				'name' => 'Tianmen',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 2085,
				'name' => 'Yiyang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 2086,
				'name' => 'Quanzhou',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 2087,
				'name' => 'Rizhao',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 2088,
				'name' => 'Deyang',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 2089,
				'name' => 'Guangyuan',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 2090,
				'name' => 'Changshu',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 2091,
				'name' => 'Zhangzhou',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 2092,
				'name' => 'Hailar',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 2093,
				'name' => 'Nanchong',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 2094,
				'name' => 'Jiutai',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 2095,
				'name' => 'Zhaodong',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 2096,
				'name' => 'Shaoxing',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 2097,
				'name' => 'Fuyang',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 2098,
				'name' => 'Maoming',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 2099,
				'name' => 'Qujing',
				'state_code' => 'CH21',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 2100,
				'name' => 'Ghulja',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 2101,
				'name' => 'Jiaohe',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 2102,
				'name' => 'Puyang',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 2103,
				'name' => 'Huadian',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 2104,
				'name' => 'Jiangyou',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 2105,
				'name' => 'Qashqar',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 2106,
				'name' => 'Anshun',
				'state_code' => 'CH5',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 2107,
				'name' => 'Fuling',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 2108,
				'name' => 'Xinyu',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 2109,
				'name' => 'Hanzhong',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 2110,
				'name' => 'Danyang',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 2111,
				'name' => 'Chenzhou',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 2112,
				'name' => 'Xiaogan',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 2113,
				'name' => 'Shangqiu',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 2114,
				'name' => 'Zhuhai',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 2115,
				'name' => 'Qingyuan',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 2116,
				'name' => 'Aqsu',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 2117,
				'name' => 'Jining',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 2118,
				'name' => 'Xiaoshan',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 2119,
				'name' => 'Zaoyang',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 2120,
				'name' => 'Xinghua',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 2121,
				'name' => 'Hami',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 2122,
				'name' => 'Huizhou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 2123,
				'name' => 'Jinmen',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 2124,
				'name' => 'Sanming',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 2125,
				'name' => 'Ulanhot',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 2126,
				'name' => 'Korla',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 2127,
				'name' => 'Wanxian',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 2128,
				'name' => 'Rui´an',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 2129,
				'name' => 'Zhoushan',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 2130,
				'name' => 'Liangcheng',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 2131,
				'name' => 'Jiaozhou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 2132,
				'name' => 'Taizhou',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 2133,
				'name' => 'Suzhou',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 2134,
				'name' => 'Yichun',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 2135,
				'name' => 'Taonan',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 2136,
				'name' => 'Pingdu',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 2137,
				'name' => 'Ji´an',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 2138,
				'name' => 'Longkou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 2139,
				'name' => 'Langfang',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 2140,
				'name' => 'Zhoukou',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 2141,
				'name' => 'Suining',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 2142,
				'name' => 'Yulin',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 2143,
				'name' => 'Jinhua',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 2144,
				'name' => 'Liu´an',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 2145,
				'name' => 'Shuangcheng',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 2146,
				'name' => 'Suizhou',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 2147,
				'name' => 'Ankang',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 2148,
				'name' => 'Weinan',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 2149,
				'name' => 'Longjing',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 2150,
				'name' => 'Da´an',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 2151,
				'name' => 'Lengshuijiang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 2152,
				'name' => 'Laiyang',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 2153,
				'name' => 'Xianning',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 2154,
				'name' => 'Dali',
				'state_code' => 'CH21',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 2155,
				'name' => 'Anda',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 2156,
				'name' => 'Jincheng',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 2157,
				'name' => 'Longyan',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 2158,
				'name' => 'Xichang',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 2159,
				'name' => 'Wendeng',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 2160,
				'name' => 'Hailun',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 2161,
				'name' => 'Binzhou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 2162,
				'name' => 'Linhe',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 2163,
				'name' => 'Wuwei',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 2164,
				'name' => 'Duyun',
				'state_code' => 'CH5',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 2165,
				'name' => 'Mishan',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 2166,
				'name' => 'Shangrao',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 2167,
				'name' => 'Changji',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 2168,
				'name' => 'Meixian',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 2169,
				'name' => 'Yushu',
				'state_code' => 'CH16',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 2170,
				'name' => 'Tiefa',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 2171,
				'name' => 'Huai´an',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 2172,
				'name' => 'Leiyang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 2173,
				'name' => 'Zalantun',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 2174,
				'name' => 'Weihai',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 2175,
				'name' => 'Loudi',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 2176,
				'name' => 'Qingzhou',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 2177,
				'name' => 'Qidong',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 2178,
				'name' => 'Huaihua',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 2179,
				'name' => 'Luohe',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 2180,
				'name' => 'Chuzhou',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 2181,
				'name' => 'Kaiyuan',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 2182,
				'name' => 'Linqing',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 2183,
				'name' => 'Chaohu',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 2184,
				'name' => 'Laohekou',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 2185,
				'name' => 'Dujiangyan',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 2186,
				'name' => 'Zhumadian',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 2187,
				'name' => 'Linchuan',
				'state_code' => 'CH13',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 2188,
				'name' => 'Jiaonan',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 2189,
				'name' => 'Sanmenxia',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 2190,
				'name' => 'Heyuan',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 2191,
				'name' => 'Manzhouli',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 2192,
				'name' => 'Lhasa',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 2193,
				'name' => 'Lianyuan',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 2194,
				'name' => 'Kuytun',
				'state_code' => 'CH23',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 2195,
				'name' => 'Puqi',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 2196,
				'name' => 'Hongjiang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 2197,
				'name' => 'Qinzhou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 2198,
				'name' => 'Renqiu',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 2199,
				'name' => 'Yuyao',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 2200,
				'name' => 'Guigang',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 2201,
				'name' => 'Kaili',
				'state_code' => 'CH5',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 2202,
				'name' => 'Yan´an',
				'state_code' => 'CH17',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 2203,
				'name' => 'Beihai',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 2204,
				'name' => 'Xuangzhou',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 2205,
				'name' => 'Quzhou',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 2206,
				'name' => 'Yong´an',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 2207,
				'name' => 'Zixing',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 2208,
				'name' => 'Liyang',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 2209,
				'name' => 'Yizheng',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 2210,
				'name' => 'Yumen',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 2211,
				'name' => 'Liling',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 2212,
				'name' => 'Yuncheng',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 2213,
				'name' => 'Shanwei',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 2214,
				'name' => 'Cixi',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 2215,
				'name' => 'Yuanjiang',
				'state_code' => 'CH11',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 2216,
				'name' => 'Bozhou',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 2217,
				'name' => 'Jinchang',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 2218,
				'name' => 'Fu´an',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 2219,
				'name' => 'Suqian',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 2220,
				'name' => 'Shishou',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 2221,
				'name' => 'Hengshui',
				'state_code' => 'CH7',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 2222,
				'name' => 'Danjiangkou',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 2223,
				'name' => 'Fujin',
				'state_code' => 'CH8',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 2224,
				'name' => 'Sanya',
				'state_code' => 'CH6',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 2225,
				'name' => 'Guangshui',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 2226,
				'name' => 'Huangshan',
				'state_code' => 'CH1',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 2227,
				'name' => 'Xingcheng',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 2228,
				'name' => 'Zhucheng',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 2229,
				'name' => 'Kunshan',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 2230,
				'name' => 'Haining',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 2231,
				'name' => 'Pingliang',
				'state_code' => 'CH3',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 2232,
				'name' => 'Fuqing',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 2233,
				'name' => 'Xinzhou',
				'state_code' => 'CH19',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 2234,
				'name' => 'Jieyang',
				'state_code' => 'CH4',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 2235,
				'name' => 'Zhangjiagang',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 2236,
				'name' => 'Tong Xian',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 2237,
				'name' => 'Ya´an',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 2238,
				'name' => 'Jinzhou',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 2239,
				'name' => 'Emeishan',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 2240,
				'name' => 'Enshi',
				'state_code' => 'CH10',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 2241,
				'name' => 'Bose',
				'state_code' => 'CH12',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 2242,
				'name' => 'Yuzhou',
				'state_code' => 'CH9',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 2243,
				'name' => 'Kaiyuan',
				'state_code' => 'CH15',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 2244,
				'name' => 'Tumen',
				'state_code' => 'CH14',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 2245,
				'name' => 'Putian',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 2246,
				'name' => 'Linhai',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 2247,
				'name' => 'Xilin Hot',
				'state_code' => '',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 2248,
				'name' => 'Shaowu',
				'state_code' => 'CH2',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 2249,
				'name' => 'Junan',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 2250,
				'name' => 'Huaying',
				'state_code' => 'CH20',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 2251,
				'name' => 'Pingyi',
				'state_code' => 'CH18',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 2252,
				'name' => 'Huangyan',
				'state_code' => 'CH22',
				'country_code' => 'CHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 2253,
				'name' => 'Bishkek',
				'state_code' => '',
				'country_code' => 'KGZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 2254,
				'name' => 'Osh',
				'state_code' => '',
				'country_code' => 'KGZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 2255,
				'name' => 'Bikenibeu',
				'state_code' => '',
				'country_code' => 'KIR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 2256,
				'name' => 'Bairiki',
				'state_code' => '',
				'country_code' => 'KIR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 2257,
				'name' => 'Santafé de Bogotá',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 2258,
				'name' => 'Cali',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 2259,
				'name' => 'Medellín',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 2260,
				'name' => 'Barranquilla',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 2261,
				'name' => 'Cartagena',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 2262,
				'name' => 'Cúcuta',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 2263,
				'name' => 'Bucaramanga',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 2264,
				'name' => 'Ibagué',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 2265,
				'name' => 'Pereira',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 2266,
				'name' => 'Santa Marta',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 2267,
				'name' => 'Manizales',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 2268,
				'name' => 'Bello',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 2269,
				'name' => 'Pasto',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 2270,
				'name' => 'Neiva',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 2271,
				'name' => 'Soledad',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 2272,
				'name' => 'Armenia',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 2273,
				'name' => 'Villavicencio',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 2274,
				'name' => 'Soacha',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 2275,
				'name' => 'Valledupar',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 2276,
				'name' => 'Montería',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 2277,
				'name' => 'Itagüí',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 2278,
				'name' => 'Palmira',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 2279,
				'name' => 'Buenaventura',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 2280,
				'name' => 'Floridablanca',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 2281,
				'name' => 'Sincelejo',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 2282,
				'name' => 'Popayán',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 2283,
				'name' => 'Barrancabermeja',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 2284,
				'name' => 'Dos Quebradas',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 2285,
				'name' => 'Tuluá',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 2286,
				'name' => 'Envigado',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 2287,
				'name' => 'Cartago',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 2288,
				'name' => 'Girardot',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 2289,
				'name' => 'Buga',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 2290,
				'name' => 'Tunja',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 2291,
				'name' => 'Florencia',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 2292,
				'name' => 'Maicao',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 2293,
				'name' => 'Sogamoso',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 2294,
				'name' => 'Giron',
				'state_code' => '',
				'country_code' => 'COL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 2295,
				'name' => 'Moroni',
				'state_code' => '',
				'country_code' => 'COM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 2296,
				'name' => 'Brazzaville',
				'state_code' => '',
				'country_code' => 'COG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 2297,
				'name' => 'Pointe-Noire',
				'state_code' => '',
				'country_code' => 'COG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 2298,
				'name' => 'Kinshasa',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 2299,
				'name' => 'Lubumbashi',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 2300,
				'name' => 'Mbuji-Mayi',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 2301,
				'name' => 'Kolwezi',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 2302,
				'name' => 'Kisangani',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 2303,
				'name' => 'Kananga',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 2304,
				'name' => 'Likasi',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 2305,
				'name' => 'Bukavu',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 2306,
				'name' => 'Kikwit',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 2307,
				'name' => 'Tshikapa',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 2308,
				'name' => 'Matadi',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 2309,
				'name' => 'Mbandaka',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 2310,
				'name' => 'Mwene-Ditu',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 2311,
				'name' => 'Boma',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 2312,
				'name' => 'Uvira',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 2313,
				'name' => 'Butembo',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 2314,
				'name' => 'Goma',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 2315,
				'name' => 'Kalemie',
				'state_code' => '',
				'country_code' => 'COD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 2316,
				'name' => 'Bantam',
				'state_code' => '',
				'country_code' => 'CCK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 2317,
				'name' => 'West Island',
				'state_code' => '',
				'country_code' => 'CCK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 2318,
				'name' => 'Pyongyang',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 2319,
				'name' => 'Hamhung',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 2320,
				'name' => 'Chongjin',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 2321,
				'name' => 'Nampo',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 2322,
				'name' => 'Sinuiju',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 2323,
				'name' => 'Wonsan',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 2324,
				'name' => 'Phyongsong',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 2325,
				'name' => 'Sariwon',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 2326,
				'name' => 'Haeju',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 2327,
				'name' => 'Kanggye',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 2328,
				'name' => 'Kimchaek',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 2329,
				'name' => 'Hyesan',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 2330,
				'name' => 'Kaesong',
				'state_code' => '',
				'country_code' => 'PRK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 2331,
				'name' => 'Seoul',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 2332,
				'name' => 'Pusan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 2333,
				'name' => 'Inchon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 2334,
				'name' => 'Taegu',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 2335,
				'name' => 'Taejon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 2336,
				'name' => 'Kwangju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 2337,
				'name' => 'Ulsan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 2338,
				'name' => 'Songnam',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 2339,
				'name' => 'Puchon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 2340,
				'name' => 'Suwon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 2341,
				'name' => 'Anyang',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 2342,
				'name' => 'Chonju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 2343,
				'name' => 'Chongju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 2344,
				'name' => 'Koyang',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 2345,
				'name' => 'Ansan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 2346,
				'name' => 'Pohang',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 2347,
				'name' => 'Chang-won',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 2348,
				'name' => 'Masan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 2349,
				'name' => 'Kwangmyong',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 2350,
				'name' => 'Chonan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 2351,
				'name' => 'Chinju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 2352,
				'name' => 'Iksan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 2353,
				'name' => 'Pyongtaek',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 2354,
				'name' => 'Kumi',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 2355,
				'name' => 'Uijongbu',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 2356,
				'name' => 'Kyongju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 2357,
				'name' => 'Kunsan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 2358,
				'name' => 'Cheju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 2359,
				'name' => 'Kimhae',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 2360,
				'name' => 'Sunchon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 2361,
				'name' => 'Mokpo',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 2362,
				'name' => 'Yong-in',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 2363,
				'name' => 'Wonju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 2364,
				'name' => 'Kunpo',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 2365,
				'name' => 'Chunchon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 2366,
				'name' => 'Namyangju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 2367,
				'name' => 'Kangnung',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 2368,
				'name' => 'Chungju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 2369,
				'name' => 'Andong',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 2370,
				'name' => 'Yosu',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 2371,
				'name' => 'Kyongsan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 2372,
				'name' => 'Paju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 2373,
				'name' => 'Yangsan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 2374,
				'name' => 'Ichon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 2375,
				'name' => 'Asan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 2376,
				'name' => 'Koje',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 2377,
				'name' => 'Kimchon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 2378,
				'name' => 'Nonsan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 2379,
				'name' => 'Kuri',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 2380,
				'name' => 'Chong-up',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 2381,
				'name' => 'Chechon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 2382,
				'name' => 'Sosan',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 2383,
				'name' => 'Shihung',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 2384,
				'name' => 'Tong-yong',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 2385,
				'name' => 'Kongju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 2386,
				'name' => 'Yongju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 2387,
				'name' => 'Chinhae',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 2388,
				'name' => 'Sangju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 2389,
				'name' => 'Poryong',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 2390,
				'name' => 'Kwang-yang',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 2391,
				'name' => 'Miryang',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 2392,
				'name' => 'Hanam',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 2393,
				'name' => 'Kimje',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 2394,
				'name' => 'Yongchon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 2395,
				'name' => 'Sachon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 2396,
				'name' => 'Uiwang',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 2397,
				'name' => 'Naju',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 2398,
				'name' => 'Namwon',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 2399,
				'name' => 'Tonghae',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 2400,
				'name' => 'Mun-gyong',
				'state_code' => '',
				'country_code' => 'KOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 2401,
				'name' => 'Athenai',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 2402,
				'name' => 'Thessaloniki',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 2403,
				'name' => 'Pireus',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 2404,
				'name' => 'Patras',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 2405,
				'name' => 'Peristerion',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 2406,
				'name' => 'Herakleion',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 2407,
				'name' => 'Kallithea',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 2408,
				'name' => 'Larisa',
				'state_code' => '',
				'country_code' => 'GRC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 2409,
				'name' => 'Zagreb',
				'state_code' => '',
				'country_code' => 'HRV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 2410,
				'name' => 'Split',
				'state_code' => '',
				'country_code' => 'HRV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 2411,
				'name' => 'Rijeka',
				'state_code' => '',
				'country_code' => 'HRV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 2412,
				'name' => 'Osijek',
				'state_code' => '',
				'country_code' => 'HRV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 2413,
				'name' => 'La Habana',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 2414,
				'name' => 'Santiago de Cuba',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 2415,
				'name' => 'Camagüey',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 2416,
				'name' => 'Holguín',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 2417,
				'name' => 'Santa Clara',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 2418,
				'name' => 'Guantánamo',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 2419,
				'name' => 'Pinar del Río',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 2420,
				'name' => 'Bayamo',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 2421,
				'name' => 'Cienfuegos',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 2422,
				'name' => 'Victoria de las Tunas',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 2423,
				'name' => 'Matanzas',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 2424,
				'name' => 'Manzanillo',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 2425,
				'name' => 'Sancti-Spíritus',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 2426,
				'name' => 'Ciego de Ávila',
				'state_code' => '',
				'country_code' => 'CUB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 2427,
				'name' => 'al-Salimiya',
				'state_code' => '',
				'country_code' => 'KWT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 2428,
				'name' => 'Jalib al-Shuyukh',
				'state_code' => '',
				'country_code' => 'KWT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 2429,
				'name' => 'Kuwait',
				'state_code' => '',
				'country_code' => 'KWT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 2430,
				'name' => 'Nicosia',
				'state_code' => '',
				'country_code' => 'CYP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 2431,
				'name' => 'Limassol',
				'state_code' => '',
				'country_code' => 'CYP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 2432,
				'name' => 'Vientiane',
				'state_code' => '',
				'country_code' => 'LAO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 2433,
				'name' => 'Savannakhet',
				'state_code' => '',
				'country_code' => 'LAO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 2434,
				'name' => 'Riga',
				'state_code' => '',
				'country_code' => 'LVA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 2435,
				'name' => 'Daugavpils',
				'state_code' => '',
				'country_code' => 'LVA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 2436,
				'name' => 'Liepaja',
				'state_code' => '',
				'country_code' => 'LVA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 2437,
				'name' => 'Maseru',
				'state_code' => '',
				'country_code' => 'LSO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 2438,
				'name' => 'Beirut',
				'state_code' => '',
				'country_code' => 'LBN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 2439,
				'name' => 'Tripoli',
				'state_code' => '',
				'country_code' => 'LBN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 2440,
				'name' => 'Monrovia',
				'state_code' => '',
				'country_code' => 'LBR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 2441,
				'name' => 'Tripoli',
				'state_code' => '',
				'country_code' => 'LBY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 2442,
				'name' => 'Bengasi',
				'state_code' => '',
				'country_code' => 'LBY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 2443,
				'name' => 'Misrata',
				'state_code' => '',
				'country_code' => 'LBY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 2444,
				'name' => 'al-Zawiya',
				'state_code' => '',
				'country_code' => 'LBY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 2445,
				'name' => 'Schaan',
				'state_code' => '',
				'country_code' => 'LIE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 2446,
				'name' => 'Vaduz',
				'state_code' => '',
				'country_code' => 'LIE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 2447,
				'name' => 'Vilnius',
				'state_code' => '',
				'country_code' => 'LTU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 2448,
				'name' => 'Kaunas',
				'state_code' => '',
				'country_code' => 'LTU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 2449,
				'name' => 'Klaipeda',
				'state_code' => '',
				'country_code' => 'LTU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 2450,
				'name' => 'Šiauliai',
				'state_code' => '',
				'country_code' => 'LTU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 2451,
				'name' => 'Panevezys',
				'state_code' => '',
				'country_code' => 'LTU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 2452,
				'name' => 'Luxembourg [Luxemburg/Lëtzebuerg]',
				'state_code' => '',
				'country_code' => 'LUX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 2453,
				'name' => 'El-Aaiún',
				'state_code' => '',
				'country_code' => 'ESH',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 2454,
				'name' => 'Macao',
				'state_code' => '',
				'country_code' => 'MAC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 2455,
				'name' => 'Antananarivo',
				'state_code' => '',
				'country_code' => 'MDG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 2456,
				'name' => 'Toamasina',
				'state_code' => '',
				'country_code' => 'MDG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 2457,
				'name' => 'Antsirabé',
				'state_code' => '',
				'country_code' => 'MDG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 2458,
				'name' => 'Mahajanga',
				'state_code' => '',
				'country_code' => 'MDG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 2459,
				'name' => 'Fianarantsoa',
				'state_code' => '',
				'country_code' => 'MDG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 2460,
				'name' => 'Skopje',
				'state_code' => '',
				'country_code' => 'MKD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 2461,
				'name' => 'Blantyre',
				'state_code' => '',
				'country_code' => 'MWI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 2462,
				'name' => 'Lilongwe',
				'state_code' => '',
				'country_code' => 'MWI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 2463,
				'name' => 'Male',
				'state_code' => '',
				'country_code' => 'MDV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 2464,
				'name' => 'Kuala Lumpur',
				'state_code' => 'MY14',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 2465,
				'name' => 'Ipoh',
				'state_code' => 'MY07',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 2466,
				'name' => 'Johor Baharu',
				'state_code' => 'MY01',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 2467,
				'name' => 'Petaling Jaya',
				'state_code' => 'MY12',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 2468,
				'name' => 'Kelang',
				'state_code' => 'MY12',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 2469,
				'name' => 'Kuala Terengganu',
				'state_code' => 'MY13',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 2470,
				'name' => 'Pinang',
				'state_code' => 'MY09',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 2471,
				'name' => 'Kota Bharu',
				'state_code' => 'MY03',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 2472,
				'name' => 'Kuantan',
				'state_code' => 'MY03',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 2473,
				'name' => 'Taiping',
				'state_code' => 'MY02',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 2474,
				'name' => 'Seremban',
				'state_code' => 'MY05',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 2475,
				'name' => 'Kuching',
				'state_code' => 'MY11',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 2476,
				'name' => 'Sibu',
				'state_code' => 'MY16',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 2477,
				'name' => 'Sandakan',
				'state_code' => 'MY11',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 2478,
				'name' => 'Alor Setar',
				'state_code' => 'MY08',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 2479,
				'name' => 'Selayang Baru',
				'state_code' => 'MY14',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 2480,
				'name' => 'Sungai Petani',
				'state_code' => 'MY02',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 2481,
				'name' => 'Shah Alam',
				'state_code' => 'MY12',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 2482,
				'name' => 'Bamako',
				'state_code' => '',
				'country_code' => 'MLI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 2483,
				'name' => 'Birkirkara',
				'state_code' => '',
				'country_code' => 'MLT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 2484,
				'name' => 'Valletta',
				'state_code' => '',
				'country_code' => 'MLT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 2485,
				'name' => 'Casablanca',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 2486,
				'name' => 'Rabat',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 2487,
				'name' => 'Marrakech',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 2488,
				'name' => 'Fès',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 2489,
				'name' => 'Tanger',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 2490,
				'name' => 'Salé',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 2491,
				'name' => 'Meknès',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 2492,
				'name' => 'Oujda',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 2493,
				'name' => 'Kénitra',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 2494,
				'name' => 'Tétouan',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 2495,
				'name' => 'Safi',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 2496,
				'name' => 'Agadir',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 2497,
				'name' => 'Mohammedia',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 2498,
				'name' => 'Khouribga',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 2499,
				'name' => 'Beni-Mellal',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 2500,
				'name' => 'Témara',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 2501,
				'name' => 'El Jadida',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 2502,
				'name' => 'Nador',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 2503,
				'name' => 'Ksar el Kebir',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 2504,
				'name' => 'Settat',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 2505,
				'name' => 'Taza',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 2506,
				'name' => 'El Araich',
				'state_code' => '',
				'country_code' => 'MAR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 2507,
				'name' => 'Dalap-Uliga-Darrit',
				'state_code' => '',
				'country_code' => 'MHL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 2508,
				'name' => 'Fort-de-France',
				'state_code' => '',
				'country_code' => 'MTQ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 2509,
				'name' => 'Nouakchott',
				'state_code' => '',
				'country_code' => 'MRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 2510,
				'name' => 'Nouâdhibou',
				'state_code' => '',
				'country_code' => 'MRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 2511,
				'name' => 'Port-Louis',
				'state_code' => '',
				'country_code' => 'MUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 2512,
				'name' => 'Beau Bassin-Rose Hill',
				'state_code' => '',
				'country_code' => 'MUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 2513,
				'name' => 'Vacoas-Phoenix',
				'state_code' => '',
				'country_code' => 'MUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 2514,
				'name' => 'Mamoutzou',
				'state_code' => '',
				'country_code' => 'MYT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 2515,
				'name' => 'Ciudad de México',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 2516,
				'name' => 'Guadalajara',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 2517,
				'name' => 'Ecatepec de Morelos',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 2518,
				'name' => 'Puebla',
				'state_code' => 'MX21',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 2519,
				'name' => 'Nezahualcóyotl',
				'state_code' => '',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 2520,
				'name' => 'Juárez',
				'state_code' => 'MX06',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 2521,
				'name' => 'Tijuana',
				'state_code' => 'MX02',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 2522,
				'name' => 'León',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 2523,
				'name' => 'Monterrey',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 2524,
				'name' => 'Zapopan',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 2525,
				'name' => 'Naucalpan de Juárez',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 2526,
				'name' => 'Mexicali',
				'state_code' => 'MX02',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 2527,
				'name' => 'Culiacán',
				'state_code' => 'MX25',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 2528,
				'name' => 'Acapulco de Juárez',
				'state_code' => 'MX12',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 2529,
				'name' => 'Tlalnepantla de Baz',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 2530,
				'name' => 'Mérida',
				'state_code' => 'MX31',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 2531,
				'name' => 'Chihuahua',
				'state_code' => 'MX06',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 2532,
				'name' => 'San Luis Potosí',
				'state_code' => 'MX24',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 2533,
				'name' => 'Guadalupe',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 2534,
				'name' => 'Toluca',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 2535,
				'name' => 'Aguascalientes',
				'state_code' => 'MX32',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 2536,
				'name' => 'Querétaro',
				'state_code' => 'MX22',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 2537,
				'name' => 'Morelia',
				'state_code' => 'MX16',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 2538,
				'name' => 'Hermosillo',
				'state_code' => 'MX26',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 2539,
				'name' => 'Saltillo',
				'state_code' => 'MX07',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 2540,
				'name' => 'Torreón',
				'state_code' => 'MX07',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 2541,
			'name' => 'Centro (Villahermosa)',
				'state_code' => 'MX27',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 2542,
				'name' => 'San Nicolás de los Garza',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 2543,
				'name' => 'Durango',
				'state_code' => 'MX10',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 2544,
				'name' => 'Chimalhuacán',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 2545,
				'name' => 'Tlaquepaque',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 2546,
				'name' => 'Atizapán de Zaragoza',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 2547,
				'name' => 'Veracruz',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 2548,
				'name' => 'Cuautitlán Izcalli',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 2549,
				'name' => 'Irapuato',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 2550,
				'name' => 'Tuxtla Gutiérrez',
				'state_code' => 'MX05',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 2551,
				'name' => 'Tultitlán',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 2552,
				'name' => 'Reynosa',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 2553,
				'name' => 'Benito Juárez',
				'state_code' => 'MX23',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 2554,
				'name' => 'Matamoros',
				'state_code' => 'MX21',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 2555,
				'name' => 'Xalapa',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 2556,
				'name' => 'Celaya',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 2557,
				'name' => 'Mazatlán',
				'state_code' => 'MX25',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 2558,
				'name' => 'Ensenada',
				'state_code' => 'MX02',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 2559,
				'name' => 'Ahome',
				'state_code' => 'MX25',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 2560,
				'name' => 'Cajeme',
				'state_code' => 'MX26',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 2561,
				'name' => 'Cuernavaca',
				'state_code' => 'MX17',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 2562,
				'name' => 'Tonalá',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 2563,
				'name' => 'Valle de Chalco Solidaridad',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 2564,
				'name' => 'Nuevo Laredo',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 2565,
				'name' => 'Tepic',
				'state_code' => 'MX18',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 2566,
				'name' => 'Tampico',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 2567,
				'name' => 'Ixtapaluca',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 2568,
				'name' => 'Apodaca',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 2569,
				'name' => 'Guasave',
				'state_code' => 'MX25',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 2570,
				'name' => 'Gómez Palacio',
				'state_code' => 'MX10',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 2571,
				'name' => 'Tapachula',
				'state_code' => 'MX05',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 2572,
				'name' => 'Nicolás Romero',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 2573,
				'name' => 'Coatzacoalcos',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 2574,
				'name' => 'Uruapan',
				'state_code' => 'MX16',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 2575,
				'name' => 'Victoria',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 2576,
				'name' => 'Oaxaca de Juárez',
				'state_code' => 'MX12',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 2577,
				'name' => 'Coacalco de Berriozábal',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 2578,
				'name' => 'Pachuca de Soto',
				'state_code' => 'MX13',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 2579,
				'name' => 'General Escobedo',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 2580,
				'name' => 'Salamanca',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 2581,
				'name' => 'Santa Catarina',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 2582,
				'name' => 'Tehuacán',
				'state_code' => 'MX21',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 2583,
				'name' => 'Chalco',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 2584,
				'name' => 'Cárdenas',
				'state_code' => '',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 2585,
				'name' => 'Campeche',
				'state_code' => 'MX04',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 2586,
				'name' => 'La Paz',
				'state_code' => 'MX03',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 2587,
			'name' => 'Othón P. Blanco (Chetumal)',
				'state_code' => 'MX23',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 2588,
				'name' => 'Texcoco',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 2589,
				'name' => 'La Paz',
				'state_code' => 'MX03',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 2590,
				'name' => 'Metepec',
				'state_code' => 'MX13',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 2591,
				'name' => 'Monclova',
				'state_code' => 'MX07',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 2592,
				'name' => 'Huixquilucan',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 2593,
				'name' => 'Chilpancingo de los Bravo',
				'state_code' => 'MX12',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 2594,
				'name' => 'Puerto Vallarta',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 2595,
				'name' => 'Fresnillo',
				'state_code' => 'MX32',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 2596,
				'name' => 'Ciudad Madero',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 2597,
				'name' => 'Soledad de Graciano Sánchez',
				'state_code' => 'MX24',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 2598,
				'name' => 'San Juan del Río',
				'state_code' => 'MX22',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 2599,
				'name' => 'San Felipe del Progreso',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 2600,
				'name' => 'Córdoba',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 2601,
				'name' => 'Tecámac',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 2602,
				'name' => 'Ocosingo',
				'state_code' => 'MX05',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 2603,
				'name' => 'Carmen',
				'state_code' => 'MX04',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 2604,
				'name' => 'Lázaro Cárdenas',
				'state_code' => 'MX16',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 2605,
				'name' => 'Jiutepec',
				'state_code' => 'MX17',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 2606,
				'name' => 'Papantla',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 2607,
				'name' => 'Comalcalco',
				'state_code' => 'MX27',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 2608,
				'name' => 'Zamora',
				'state_code' => 'MX16',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 2609,
				'name' => 'Nogales',
				'state_code' => 'MX26',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 2610,
				'name' => 'Huimanguillo',
				'state_code' => 'MX27',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 2611,
				'name' => 'Cuautla',
				'state_code' => 'MX17',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 2612,
				'name' => 'Minatitlán',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 2613,
				'name' => 'Poza Rica de Hidalgo',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 2614,
				'name' => 'Ciudad Valles',
				'state_code' => 'MX24',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 2615,
				'name' => 'Navolato',
				'state_code' => 'MX25',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 2616,
				'name' => 'San Luis Río Colorado',
				'state_code' => 'MX26',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 2617,
				'name' => 'Pénjamo',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 2618,
				'name' => 'San Andrés Tuxtla',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 2619,
				'name' => 'Guanajuato',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 2620,
				'name' => 'Navojoa',
				'state_code' => 'MX26',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 2621,
				'name' => 'Zitácuaro',
				'state_code' => 'MX16',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 2622,
				'name' => 'Boca del Río',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 2623,
				'name' => 'Allende',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 2624,
				'name' => 'Silao',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 2625,
				'name' => 'Macuspana',
				'state_code' => 'MX27',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 2626,
				'name' => 'San Juan Bautista Tuxtepec',
				'state_code' => 'MX20',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 2627,
				'name' => 'San Cristóbal de las Casas',
				'state_code' => 'MX05',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 2628,
				'name' => 'Valle de Santiago',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 2629,
				'name' => 'Guaymas',
				'state_code' => 'MX26',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 2630,
				'name' => 'Colima',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 2631,
				'name' => 'Dolores Hidalgo',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 2632,
				'name' => 'Lagos de Moreno',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 2633,
				'name' => 'Piedras Negras',
				'state_code' => 'MX07',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 2634,
				'name' => 'Altamira',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 2635,
				'name' => 'Túxpam',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 2636,
				'name' => 'San Pedro Garza García',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 2637,
				'name' => 'Cuauhtémoc',
				'state_code' => 'MX06',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 2638,
				'name' => 'Manzanillo',
				'state_code' => 'MX08',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 2639,
				'name' => 'Iguala de la Independencia',
				'state_code' => 'MX12',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 2640,
				'name' => 'Zacatecas',
				'state_code' => 'MX32',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 2641,
				'name' => 'Tlajomulco de Zúñiga',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 2642,
				'name' => 'Tulancingo de Bravo',
				'state_code' => 'MX13',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 2643,
				'name' => 'Zinacantepec',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 2644,
				'name' => 'San Martín Texmelucan',
				'state_code' => 'MX21',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 2645,
				'name' => 'Tepatitlán de Morelos',
				'state_code' => 'MX14',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 2646,
				'name' => 'Martínez de la Torre',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 2647,
				'name' => 'Orizaba',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 2648,
				'name' => 'Apatzingán',
				'state_code' => 'MX16',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 2649,
				'name' => 'Atlixco',
				'state_code' => 'MX21',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 2650,
				'name' => 'Delicias',
				'state_code' => 'MX06',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 2651,
				'name' => 'Ixtlahuaca',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 2652,
				'name' => 'El Mante',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 2653,
				'name' => 'Lerdo',
				'state_code' => 'MX10',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 2654,
				'name' => 'Almoloya de Juárez',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 2655,
				'name' => 'Acámbaro',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 2656,
				'name' => 'Acuña',
				'state_code' => 'MX07',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 2657,
				'name' => 'Guadalupe',
				'state_code' => 'MX19',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 2658,
				'name' => 'Huejutla de Reyes',
				'state_code' => 'MX13',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 2659,
				'name' => 'Hidalgo',
				'state_code' => 'MX13',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 2660,
				'name' => 'Los Cabos',
				'state_code' => 'MX03',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 2661,
				'name' => 'Comitán de Domínguez',
				'state_code' => 'MX05',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 2662,
				'name' => 'Cunduacán',
				'state_code' => 'MX27',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 2663,
				'name' => 'Río Bravo',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 2664,
				'name' => 'Temapache',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 2665,
				'name' => 'Chilapa de Alvarez',
				'state_code' => 'MX12',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 2666,
				'name' => 'Hidalgo del Parral',
				'state_code' => 'MX06',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 2667,
				'name' => 'San Francisco del Rincón',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 2668,
				'name' => 'Taxco de Alarcón',
				'state_code' => 'MX12',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 2669,
				'name' => 'Zumpango',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 2670,
				'name' => 'San Pedro Cholula',
				'state_code' => 'MX21',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 2671,
				'name' => 'Lerma',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 2672,
				'name' => 'Tecomán',
				'state_code' => 'MX08',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 2673,
				'name' => 'Las Margaritas',
				'state_code' => 'MX05',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 2674,
				'name' => 'Cosoleacaque',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 2675,
				'name' => 'San Luis de la Paz',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 2676,
				'name' => 'José Azueta',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 2677,
				'name' => 'Santiago Ixcuintla',
				'state_code' => 'MX18',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 2678,
				'name' => 'San Felipe',
				'state_code' => 'MX02',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 2679,
				'name' => 'Tejupilco',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 2680,
				'name' => 'Tantoyuca',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 2681,
				'name' => 'Salvatierra',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 2682,
				'name' => 'Tultepec',
				'state_code' => 'MX15',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 2683,
				'name' => 'Temixco',
				'state_code' => 'MX17',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 2684,
				'name' => 'Matamoros',
				'state_code' => 'MX28',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 2685,
				'name' => 'Pánuco',
				'state_code' => 'MX30',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 2686,
				'name' => 'El Fuerte',
				'state_code' => 'MX25',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 2687,
				'name' => 'Tierra Blanca',
				'state_code' => 'MX11',
				'country_code' => 'MEX',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 2688,
				'name' => 'Weno',
				'state_code' => '',
				'country_code' => 'FSM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 2689,
				'name' => 'Palikir',
				'state_code' => '',
				'country_code' => 'FSM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 2690,
				'name' => 'Chisinau',
				'state_code' => '',
				'country_code' => 'MDA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 2691,
				'name' => 'Tiraspol',
				'state_code' => '',
				'country_code' => 'MDA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 2692,
				'name' => 'Balti',
				'state_code' => '',
				'country_code' => 'MDA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 2693,
			'name' => 'Bender (Tîghina)',
				'state_code' => '',
				'country_code' => 'MDA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 2694,
				'name' => 'Monte-Carlo',
				'state_code' => '',
				'country_code' => 'MCO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 2695,
				'name' => 'Monaco-Ville',
				'state_code' => '',
				'country_code' => 'MCO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 2696,
				'name' => 'Ulan Bator',
				'state_code' => '',
				'country_code' => 'MNG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 2697,
				'name' => 'Plymouth',
				'state_code' => '',
				'country_code' => 'MSR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 2698,
				'name' => 'Maputo',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 2699,
				'name' => 'Matola',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 2700,
				'name' => 'Beira',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 2701,
				'name' => 'Nampula',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 2702,
				'name' => 'Chimoio',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 2703,
				'name' => 'Naçala-Porto',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 2704,
				'name' => 'Quelimane',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 2705,
				'name' => 'Mocuba',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 2706,
				'name' => 'Tete',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 2707,
				'name' => 'Xai-Xai',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 2708,
				'name' => 'Gurue',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 2709,
				'name' => 'Maxixe',
				'state_code' => '',
				'country_code' => 'MOZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 2710,
			'name' => 'Rangoon (Yangon)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 2711,
				'name' => 'Mandalay',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 2712,
			'name' => 'Moulmein (Mawlamyine)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 2713,
			'name' => 'Pegu (Bago)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 2714,
			'name' => 'Bassein (Pathein)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 2715,
				'name' => 'Monywa',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 2716,
			'name' => 'Sittwe (Akyab)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 2717,
			'name' => 'Taunggyi (Taunggye)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 2718,
				'name' => 'Meikhtila',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 2719,
			'name' => 'Mergui (Myeik)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 2720,
			'name' => 'Lashio (Lasho)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 2721,
			'name' => 'Prome (Pyay)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 2722,
			'name' => 'Henzada (Hinthada)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 2723,
				'name' => 'Myingyan',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 2724,
			'name' => 'Tavoy (Dawei)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 2725,
			'name' => 'Pagakku (Pakokku)',
				'state_code' => '',
				'country_code' => 'MMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 2726,
				'name' => 'Windhoek',
				'state_code' => '',
				'country_code' => 'NAM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 2727,
				'name' => 'Yangor',
				'state_code' => '',
				'country_code' => 'NRU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 2728,
				'name' => 'Yaren',
				'state_code' => '',
				'country_code' => 'NRU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 2729,
				'name' => 'Kathmandu',
				'state_code' => '',
				'country_code' => 'NPL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 2730,
				'name' => 'Biratnagar',
				'state_code' => '',
				'country_code' => 'NPL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 2731,
				'name' => 'Pokhara',
				'state_code' => '',
				'country_code' => 'NPL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 2732,
				'name' => 'Lalitapur',
				'state_code' => '',
				'country_code' => 'NPL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 2733,
				'name' => 'Birgunj',
				'state_code' => '',
				'country_code' => 'NPL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 2734,
				'name' => 'Managua',
				'state_code' => '',
				'country_code' => 'NIC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 2735,
				'name' => 'León',
				'state_code' => '',
				'country_code' => 'NIC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 2736,
				'name' => 'Chinandega',
				'state_code' => '',
				'country_code' => 'NIC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 2737,
				'name' => 'Masaya',
				'state_code' => '',
				'country_code' => 'NIC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 2738,
				'name' => 'Niamey',
				'state_code' => '',
				'country_code' => 'NER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 2739,
				'name' => 'Zinder',
				'state_code' => '',
				'country_code' => 'NER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 2740,
				'name' => 'Maradi',
				'state_code' => '',
				'country_code' => 'NER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 2741,
				'name' => 'Lagos',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 2742,
				'name' => 'Ibadan',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 2743,
				'name' => 'Ogbomosho',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 2744,
				'name' => 'Kano',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 2745,
				'name' => 'Oshogbo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 2746,
				'name' => 'Ilorin',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 2747,
				'name' => 'Abeokuta',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 2748,
				'name' => 'Port Harcourt',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 2749,
				'name' => 'Zaria',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 2750,
				'name' => 'Ilesha',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 2751,
				'name' => 'Onitsha',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 2752,
				'name' => 'Iwo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 2753,
				'name' => 'Ado-Ekiti',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 2754,
				'name' => 'Abuja',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 2755,
				'name' => 'Kaduna',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 2756,
				'name' => 'Mushin',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 2757,
				'name' => 'Maiduguri',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 2758,
				'name' => 'Enugu',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 2759,
				'name' => 'Ede',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 2760,
				'name' => 'Aba',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 2761,
				'name' => 'Ife',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 2762,
				'name' => 'Ila',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 2763,
				'name' => 'Oyo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 2764,
				'name' => 'Ikerre',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 2765,
				'name' => 'Benin City',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 2766,
				'name' => 'Iseyin',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 2767,
				'name' => 'Katsina',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 2768,
				'name' => 'Jos',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 2769,
				'name' => 'Sokoto',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 2770,
				'name' => 'Ilobu',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 2771,
				'name' => 'Offa',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 2772,
				'name' => 'Ikorodu',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 2773,
				'name' => 'Ilawe-Ekiti',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 2774,
				'name' => 'Owo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 2775,
				'name' => 'Ikirun',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 2776,
				'name' => 'Shaki',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 2777,
				'name' => 'Calabar',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 2778,
				'name' => 'Ondo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 2779,
				'name' => 'Akure',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 2780,
				'name' => 'Gusau',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 2781,
				'name' => 'Ijebu-Ode',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 2782,
				'name' => 'Effon-Alaiye',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 2783,
				'name' => 'Kumo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 2784,
				'name' => 'Shomolu',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 2785,
				'name' => 'Oka-Akoko',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 2786,
				'name' => 'Ikare',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 2787,
				'name' => 'Sapele',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 2788,
				'name' => 'Deba Habe',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 2789,
				'name' => 'Minna',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 2790,
				'name' => 'Warri',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 2791,
				'name' => 'Bida',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 2792,
				'name' => 'Ikire',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 2793,
				'name' => 'Makurdi',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 2794,
				'name' => 'Lafia',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 2795,
				'name' => 'Inisa',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 2796,
				'name' => 'Shagamu',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 2797,
				'name' => 'Awka',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 2798,
				'name' => 'Gombe',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 2799,
				'name' => 'Igboho',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 2800,
				'name' => 'Ejigbo',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 2801,
				'name' => 'Agege',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 2802,
				'name' => 'Ise-Ekiti',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 2803,
				'name' => 'Ugep',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 2804,
				'name' => 'Epe',
				'state_code' => '',
				'country_code' => 'NGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 2805,
				'name' => 'Alofi',
				'state_code' => '',
				'country_code' => 'NIU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 2806,
				'name' => 'Kingston',
				'state_code' => '',
				'country_code' => 'NFK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 2807,
				'name' => 'Oslo',
				'state_code' => '',
				'country_code' => 'NOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 2808,
				'name' => 'Bergen',
				'state_code' => '',
				'country_code' => 'NOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 2809,
				'name' => 'Trondheim',
				'state_code' => '',
				'country_code' => 'NOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 2810,
				'name' => 'Stavanger',
				'state_code' => '',
				'country_code' => 'NOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 2811,
				'name' => 'Bærum',
				'state_code' => '',
				'country_code' => 'NOR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 2812,
				'name' => 'Abidjan',
				'state_code' => '',
				'country_code' => 'CIV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 2813,
				'name' => 'Bouaké',
				'state_code' => '',
				'country_code' => 'CIV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 2814,
				'name' => 'Yamoussoukro',
				'state_code' => '',
				'country_code' => 'CIV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 2815,
				'name' => 'Daloa',
				'state_code' => '',
				'country_code' => 'CIV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 2816,
				'name' => 'Korhogo',
				'state_code' => '',
				'country_code' => 'CIV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 2817,
				'name' => 'al-Sib',
				'state_code' => '',
				'country_code' => 'OMN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 2818,
				'name' => 'Salala',
				'state_code' => '',
				'country_code' => 'OMN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 2819,
				'name' => 'Bawshar',
				'state_code' => '',
				'country_code' => 'OMN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 2820,
				'name' => 'Suhar',
				'state_code' => '',
				'country_code' => 'OMN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 2821,
				'name' => 'Masqat',
				'state_code' => '',
				'country_code' => 'OMN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 2822,
				'name' => 'Karachi',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 2823,
				'name' => 'Lahore',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 2824,
				'name' => 'Faisalabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 2825,
				'name' => 'Rawalpindi',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 2826,
				'name' => 'Multan',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 2827,
				'name' => 'Hyderabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 2828,
				'name' => 'Gujranwala',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 2829,
				'name' => 'Peshawar',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 2830,
				'name' => 'Quetta',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 2831,
				'name' => 'Islamabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 2832,
				'name' => 'Sargodha',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 2833,
				'name' => 'Sialkot',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 2834,
				'name' => 'Bahawalpur',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 2835,
				'name' => 'Sukkur',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 2836,
				'name' => 'Jhang',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 2837,
				'name' => 'Sheikhupura',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 2838,
				'name' => 'Larkana',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 2839,
				'name' => 'Gujrat',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 2840,
				'name' => 'Mardan',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 2841,
				'name' => 'Kasur',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 2842,
				'name' => 'Rahim Yar Khan',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 2843,
				'name' => 'Sahiwal',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 2844,
				'name' => 'Okara',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 2845,
				'name' => 'Wah',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 2846,
				'name' => 'Dera Ghazi Khan',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 2847,
				'name' => 'Mirpur Khas',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 2848,
				'name' => 'Nawabshah',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 2849,
				'name' => 'Mingora',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 2850,
				'name' => 'Chiniot',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 2851,
				'name' => 'Kamoke',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 2852,
				'name' => 'Mandi Burewala',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 2853,
				'name' => 'Jhelum',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 2854,
				'name' => 'Sadiqabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 2855,
				'name' => 'Jacobabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 2856,
				'name' => 'Shikarpur',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 2857,
				'name' => 'Khanewal',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 2858,
				'name' => 'Hafizabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 2859,
				'name' => 'Kohat',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 2860,
				'name' => 'Muzaffargarh',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 2861,
				'name' => 'Khanpur',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 2862,
				'name' => 'Gojra',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 2863,
				'name' => 'Bahawalnagar',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 2864,
				'name' => 'Muridke',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 2865,
				'name' => 'Pak Pattan',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 2866,
				'name' => 'Abottabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 2867,
				'name' => 'Tando Adam',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 2868,
				'name' => 'Jaranwala',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 2869,
				'name' => 'Khairpur',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 2870,
				'name' => 'Chishtian Mandi',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 2871,
				'name' => 'Daska',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 2872,
				'name' => 'Dadu',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 2873,
				'name' => 'Mandi Bahauddin',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 2874,
				'name' => 'Ahmadpur East',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 2875,
				'name' => 'Kamalia',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 2876,
				'name' => 'Khuzdar',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 2877,
				'name' => 'Vihari',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 2878,
				'name' => 'Dera Ismail Khan',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 2879,
				'name' => 'Wazirabad',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 2880,
				'name' => 'Nowshera',
				'state_code' => '',
				'country_code' => 'PAK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 2881,
				'name' => 'Koror',
				'state_code' => '',
				'country_code' => 'PLW',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 2882,
				'name' => 'Ciudad de Panamá',
				'state_code' => '',
				'country_code' => 'PAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 2883,
				'name' => 'San Miguelito',
				'state_code' => '',
				'country_code' => 'PAN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 2884,
				'name' => 'Port Moresby',
				'state_code' => '',
				'country_code' => 'PNG',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 2885,
				'name' => 'Asunción',
				'state_code' => '',
				'country_code' => 'PRY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 2886,
				'name' => 'Ciudad del Este',
				'state_code' => '',
				'country_code' => 'PRY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 2887,
				'name' => 'San Lorenzo',
				'state_code' => '',
				'country_code' => 'PRY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 2888,
				'name' => 'Lambaré',
				'state_code' => '',
				'country_code' => 'PRY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 2889,
				'name' => 'Fernando de la Mora',
				'state_code' => '',
				'country_code' => 'PRY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 2890,
				'name' => 'Lima',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 2891,
				'name' => 'Arequipa',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 2892,
				'name' => 'Trujillo',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 2893,
				'name' => 'Chiclayo',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 2894,
				'name' => 'Callao',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 2895,
				'name' => 'Iquitos',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 2896,
				'name' => 'Chimbote',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 2897,
				'name' => 'Huancayo',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 2898,
				'name' => 'Piura',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 2899,
				'name' => 'Cusco',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 2900,
				'name' => 'Pucallpa',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 2901,
				'name' => 'Tacna',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 2902,
				'name' => 'Ica',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 2903,
				'name' => 'Sullana',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 2904,
				'name' => 'Juliaca',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 2905,
				'name' => 'Huánuco',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 2906,
				'name' => 'Ayacucho',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 2907,
				'name' => 'Chincha Alta',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 2908,
				'name' => 'Cajamarca',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 2909,
				'name' => 'Puno',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 2910,
				'name' => 'Ventanilla',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 2911,
				'name' => 'Castilla',
				'state_code' => '',
				'country_code' => 'PER',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 2912,
				'name' => 'Adamstown',
				'state_code' => '',
				'country_code' => 'PCN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 2913,
				'name' => 'Garapan',
				'state_code' => '',
				'country_code' => 'MNP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 2914,
				'name' => 'Lisboa',
				'state_code' => '',
				'country_code' => 'PRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 2915,
				'name' => 'Porto',
				'state_code' => '',
				'country_code' => 'PRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 2916,
				'name' => 'Amadora',
				'state_code' => '',
				'country_code' => 'PRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 2917,
				'name' => 'Coímbra',
				'state_code' => '',
				'country_code' => 'PRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 2918,
				'name' => 'Braga',
				'state_code' => '',
				'country_code' => 'PRT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 2919,
				'name' => 'San Juan',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 2920,
				'name' => 'Bayamón',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 2921,
				'name' => 'Ponce',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 2922,
				'name' => 'Carolina',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 2923,
				'name' => 'Caguas',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 2924,
				'name' => 'Arecibo',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 2925,
				'name' => 'Guaynabo',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 2926,
				'name' => 'Mayagüez',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 2927,
				'name' => 'Toa Baja',
				'state_code' => '',
				'country_code' => 'PRI',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 2928,
				'name' => 'Warszawa',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 2929,
				'name' => 'Lódz',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 2930,
				'name' => 'Kraków',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 2931,
				'name' => 'Wroclaw',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 2932,
				'name' => 'Poznan',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 2933,
				'name' => 'Gdansk',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 2934,
				'name' => 'Szczecin',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 2935,
				'name' => 'Bydgoszcz',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 2936,
				'name' => 'Lublin',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 2937,
				'name' => 'Katowice',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 2938,
				'name' => 'Bialystok',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 2939,
				'name' => 'Czestochowa',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 2940,
				'name' => 'Gdynia',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 2941,
				'name' => 'Sosnowiec',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 2942,
				'name' => 'Radom',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 2943,
				'name' => 'Kielce',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 2944,
				'name' => 'Gliwice',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 2945,
				'name' => 'Torun',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 2946,
				'name' => 'Bytom',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 2947,
				'name' => 'Zabrze',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 2948,
				'name' => 'Bielsko-Biala',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 2949,
				'name' => 'Olsztyn',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 2950,
				'name' => 'Rzeszów',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 2951,
				'name' => 'Ruda Slaska',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 2952,
				'name' => 'Rybnik',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 2953,
				'name' => 'Walbrzych',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 2954,
				'name' => 'Tychy',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 2955,
				'name' => 'Dabrowa Górnicza',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 2956,
				'name' => 'Plock',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 2957,
				'name' => 'Elblag',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 2958,
				'name' => 'Opole',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 2959,
				'name' => 'Gorzów Wielkopolski',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 2960,
				'name' => 'Wloclawek',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 2961,
				'name' => 'Chorzów',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 2962,
				'name' => 'Tarnów',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 2963,
				'name' => 'Zielona Góra',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 2964,
				'name' => 'Koszalin',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 2965,
				'name' => 'Legnica',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 2966,
				'name' => 'Kalisz',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 2967,
				'name' => 'Grudziadz',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 2968,
				'name' => 'Slupsk',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 2969,
				'name' => 'Jastrzebie-Zdrój',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 2970,
				'name' => 'Jaworzno',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 2971,
				'name' => 'Jelenia Góra',
				'state_code' => '',
				'country_code' => 'POL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 2972,
				'name' => 'Malabo',
				'state_code' => '',
				'country_code' => 'GNQ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 2973,
				'name' => 'Doha',
				'state_code' => '',
				'country_code' => 'QAT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 2974,
				'name' => 'Paris',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 2975,
				'name' => 'Marseille',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 2976,
				'name' => 'Lyon',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 2977,
				'name' => 'Toulouse',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 2978,
				'name' => 'Nice',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 2979,
				'name' => 'Nantes',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 2980,
				'name' => 'Strasbourg',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 2981,
				'name' => 'Montpellier',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 2982,
				'name' => 'Bordeaux',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 2983,
				'name' => 'Rennes',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 2984,
				'name' => 'Le Havre',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 2985,
				'name' => 'Reims',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 2986,
				'name' => 'Lille',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 2987,
				'name' => 'St-Étienne',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 2988,
				'name' => 'Toulon',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 2989,
				'name' => 'Grenoble',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 2990,
				'name' => 'Angers',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 2991,
				'name' => 'Dijon',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 2992,
				'name' => 'Brest',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 2993,
				'name' => 'Le Mans',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 2994,
				'name' => 'Clermont-Ferrand',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 2995,
				'name' => 'Amiens',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 2996,
				'name' => 'Aix-en-Provence',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 2997,
				'name' => 'Limoges',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 2998,
				'name' => 'Nîmes',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 2999,
				'name' => 'Tours',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 3000,
				'name' => 'Villeurbanne',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 3001,
				'name' => 'Metz',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 3002,
				'name' => 'Besançon',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 3003,
				'name' => 'Caen',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 3004,
				'name' => 'Orléans',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 3005,
				'name' => 'Mulhouse',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 3006,
				'name' => 'Rouen',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 3007,
				'name' => 'Boulogne-Billancourt',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 3008,
				'name' => 'Perpignan',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 3009,
				'name' => 'Nancy',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 3010,
				'name' => 'Roubaix',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 3011,
				'name' => 'Argenteuil',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 3012,
				'name' => 'Tourcoing',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 3013,
				'name' => 'Montreuil',
				'state_code' => '',
				'country_code' => 'FRA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 3014,
				'name' => 'Cayenne',
				'state_code' => '',
				'country_code' => 'GUF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 3015,
				'name' => 'Faaa',
				'state_code' => '',
				'country_code' => 'PYF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 3016,
				'name' => 'Papeete',
				'state_code' => '',
				'country_code' => 'PYF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 3017,
				'name' => 'Saint-Denis',
				'state_code' => '',
				'country_code' => 'REU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 3018,
				'name' => 'Bucuresti',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 3019,
				'name' => 'Iasi',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 3020,
				'name' => 'Constanta',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 3021,
				'name' => 'Cluj-Napoca',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 3022,
				'name' => 'Galati',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 3023,
				'name' => 'Timisoara',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 3024,
				'name' => 'Brasov',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 3025,
				'name' => 'Craiova',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 3026,
				'name' => 'Ploiesti',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 3027,
				'name' => 'Braila',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 3028,
				'name' => 'Oradea',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 3029,
				'name' => 'Bacau',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 3030,
				'name' => 'Pitesti',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 3031,
				'name' => 'Arad',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 3032,
				'name' => 'Sibiu',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 3033,
				'name' => 'Târgu Mures',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 3034,
				'name' => 'Baia Mare',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 3035,
				'name' => 'Buzau',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 3036,
				'name' => 'Satu Mare',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 3037,
				'name' => 'Botosani',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 3038,
				'name' => 'Piatra Neamt',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 3039,
				'name' => 'Râmnicu Vâlcea',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 3040,
				'name' => 'Suceava',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 3041,
				'name' => 'Drobeta-Turnu Severin',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 3042,
				'name' => 'Târgoviste',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 3043,
				'name' => 'Focsani',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 3044,
				'name' => 'Târgu Jiu',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 3045,
				'name' => 'Tulcea',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 3046,
				'name' => 'Resita',
				'state_code' => '',
				'country_code' => 'ROM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 3047,
				'name' => 'Kigali',
				'state_code' => '',
				'country_code' => 'RWA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 3048,
				'name' => 'Stockholm',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 3049,
				'name' => 'Gothenburg [Göteborg]',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 3050,
				'name' => 'Malmö',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 3051,
				'name' => 'Uppsala',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 3052,
				'name' => 'Linköping',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 3053,
				'name' => 'Västerås',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 3054,
				'name' => 'Örebro',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 3055,
				'name' => 'Norrköping',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 3056,
				'name' => 'Helsingborg',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 3057,
				'name' => 'Jönköping',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 3058,
				'name' => 'Umeå',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 3059,
				'name' => 'Lund',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 3060,
				'name' => 'Borås',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 3061,
				'name' => 'Sundsvall',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 3062,
				'name' => 'Gävle',
				'state_code' => '',
				'country_code' => 'SWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 3063,
				'name' => 'Jamestown',
				'state_code' => '',
				'country_code' => 'SHN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 3064,
				'name' => 'Basseterre',
				'state_code' => '',
				'country_code' => 'KNA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 3065,
				'name' => 'Castries',
				'state_code' => '',
				'country_code' => 'LCA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 3066,
				'name' => 'Kingstown',
				'state_code' => '',
				'country_code' => 'VCT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 3067,
				'name' => 'Saint-Pierre',
				'state_code' => '',
				'country_code' => 'SPM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 3068,
				'name' => 'Berlin',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 3069,
				'name' => 'Hamburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 3070,
				'name' => 'Munich [München]',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 3071,
				'name' => 'Köln',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 3072,
				'name' => 'Frankfurt am Main',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 3073,
				'name' => 'Essen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 3074,
				'name' => 'Dortmund',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 3075,
				'name' => 'Stuttgart',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 3076,
				'name' => 'Düsseldorf',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 3077,
				'name' => 'Bremen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 3078,
				'name' => 'Duisburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 3079,
				'name' => 'Hannover',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 3080,
				'name' => 'Leipzig',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 3081,
				'name' => 'Nürnberg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 3082,
				'name' => 'Dresden',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 3083,
				'name' => 'Bochum',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 3084,
				'name' => 'Wuppertal',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 3085,
				'name' => 'Bielefeld',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 3086,
				'name' => 'Mannheim',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 3087,
				'name' => 'Bonn',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 3088,
				'name' => 'Gelsenkirchen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 3089,
				'name' => 'Karlsruhe',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 3090,
				'name' => 'Wiesbaden',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 3091,
				'name' => 'Münster',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 3092,
				'name' => 'Mönchengladbach',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 3093,
				'name' => 'Chemnitz',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 3094,
				'name' => 'Augsburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 3095,
				'name' => 'Halle/Saale',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 3096,
				'name' => 'Braunschweig',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 3097,
				'name' => 'Aachen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 3098,
				'name' => 'Krefeld',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 3099,
				'name' => 'Magdeburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 3100,
				'name' => 'Kiel',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 3101,
				'name' => 'Oberhausen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 3102,
				'name' => 'Lübeck',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 3103,
				'name' => 'Hagen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 3104,
				'name' => 'Rostock',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 3105,
				'name' => 'Freiburg im Breisgau',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 3106,
				'name' => 'Erfurt',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 3107,
				'name' => 'Kassel',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 3108,
				'name' => 'Saarbrücken',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 3109,
				'name' => 'Mainz',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 3110,
				'name' => 'Hamm',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 3111,
				'name' => 'Herne',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 3112,
				'name' => 'Mülheim an der Ruhr',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 3113,
				'name' => 'Solingen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 3114,
				'name' => 'Osnabrück',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 3115,
				'name' => 'Ludwigshafen am Rhein',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 3116,
				'name' => 'Leverkusen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 3117,
				'name' => 'Oldenburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 3118,
				'name' => 'Neuss',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 3119,
				'name' => 'Heidelberg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 3120,
				'name' => 'Darmstadt',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 3121,
				'name' => 'Paderborn',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 3122,
				'name' => 'Potsdam',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 3123,
				'name' => 'Würzburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 3124,
				'name' => 'Regensburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 3125,
				'name' => 'Recklinghausen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 3126,
				'name' => 'Göttingen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 3127,
				'name' => 'Bremerhaven',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 3128,
				'name' => 'Wolfsburg',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 3129,
				'name' => 'Bottrop',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 3130,
				'name' => 'Remscheid',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 3131,
				'name' => 'Heilbronn',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 3132,
				'name' => 'Pforzheim',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 3133,
				'name' => 'Offenbach am Main',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 3134,
				'name' => 'Ulm',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 3135,
				'name' => 'Ingolstadt',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 3136,
				'name' => 'Gera',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 3137,
				'name' => 'Salzgitter',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 3138,
				'name' => 'Cottbus',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 3139,
				'name' => 'Reutlingen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 3140,
				'name' => 'Fürth',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 3141,
				'name' => 'Siegen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 3142,
				'name' => 'Koblenz',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 3143,
				'name' => 'Moers',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 3144,
				'name' => 'Bergisch Gladbach',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 3145,
				'name' => 'Zwickau',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 3146,
				'name' => 'Hildesheim',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 3147,
				'name' => 'Witten',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 3148,
				'name' => 'Schwerin',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 3149,
				'name' => 'Erlangen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 3150,
				'name' => 'Kaiserslautern',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 3151,
				'name' => 'Trier',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 3152,
				'name' => 'Jena',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 3153,
				'name' => 'Iserlohn',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 3154,
				'name' => 'Gütersloh',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 3155,
				'name' => 'Marl',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 3156,
				'name' => 'Lünen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 3157,
				'name' => 'Düren',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 3158,
				'name' => 'Ratingen',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 3159,
				'name' => 'Velbert',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 3160,
				'name' => 'Esslingen am Neckar',
				'state_code' => '',
				'country_code' => 'DEU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 3161,
				'name' => 'Honiara',
				'state_code' => '',
				'country_code' => 'SLB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 3162,
				'name' => 'Lusaka',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 3163,
				'name' => 'Ndola',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 3164,
				'name' => 'Kitwe',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 3165,
				'name' => 'Kabwe',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 3166,
				'name' => 'Chingola',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 3167,
				'name' => 'Mufulira',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 3168,
				'name' => 'Luanshya',
				'state_code' => '',
				'country_code' => 'ZMB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 3169,
				'name' => 'Apia',
				'state_code' => '',
				'country_code' => 'WSM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 3170,
				'name' => 'Serravalle',
				'state_code' => '',
				'country_code' => 'SMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 3171,
				'name' => 'San Marino',
				'state_code' => '',
				'country_code' => 'SMR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 3172,
				'name' => 'São Tomé',
				'state_code' => '',
				'country_code' => 'STP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 3173,
				'name' => 'Riyadh',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 3174,
				'name' => 'Jedda',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 3175,
				'name' => 'Mekka',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 3176,
				'name' => 'Medina',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 3177,
				'name' => 'al-Dammam',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 3178,
				'name' => 'al-Taif',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 3179,
				'name' => 'Tabuk',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 3180,
				'name' => 'Burayda',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 3181,
				'name' => 'al-Hufuf',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 3182,
				'name' => 'al-Mubarraz',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 3183,
				'name' => 'Khamis Mushayt',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 3184,
				'name' => 'Hail',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 3185,
				'name' => 'al-Kharj',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 3186,
				'name' => 'al-Khubar',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 3187,
				'name' => 'Jubayl',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 3188,
				'name' => 'Hafar al-Batin',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 3189,
				'name' => 'al-Tuqba',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 3190,
				'name' => 'Yanbu',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 3191,
				'name' => 'Abha',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 3192,
				'name' => 'Ara´ar',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 3193,
				'name' => 'al-Qatif',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 3194,
				'name' => 'al-Hawiya',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 3195,
				'name' => 'Unayza',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 3196,
				'name' => 'Najran',
				'state_code' => '',
				'country_code' => 'SAU',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 3197,
				'name' => 'Pikine',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 3198,
				'name' => 'Dakar',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 3199,
				'name' => 'Thiès',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 3200,
				'name' => 'Kaolack',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 3201,
				'name' => 'Ziguinchor',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 3202,
				'name' => 'Rufisque',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 3203,
				'name' => 'Saint-Louis',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 3204,
				'name' => 'Mbour',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 3205,
				'name' => 'Diourbel',
				'state_code' => '',
				'country_code' => 'SEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 3206,
				'name' => 'Victoria',
				'state_code' => '',
				'country_code' => 'SYC',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 3207,
				'name' => 'Freetown',
				'state_code' => '',
				'country_code' => 'SLE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 3208,
				'name' => 'Singapore',
				'state_code' => '',
				'country_code' => 'SGP',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 3209,
				'name' => 'Bratislava',
				'state_code' => '',
				'country_code' => 'SVK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 3210,
				'name' => 'Košice',
				'state_code' => '',
				'country_code' => 'SVK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 3211,
				'name' => 'Prešov',
				'state_code' => '',
				'country_code' => 'SVK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 3212,
				'name' => 'Ljubljana',
				'state_code' => '',
				'country_code' => 'SVN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 3213,
				'name' => 'Maribor',
				'state_code' => '',
				'country_code' => 'SVN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 3214,
				'name' => 'Mogadishu',
				'state_code' => '',
				'country_code' => 'SOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 3215,
				'name' => 'Hargeysa',
				'state_code' => '',
				'country_code' => 'SOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 3216,
				'name' => 'Kismaayo',
				'state_code' => '',
				'country_code' => 'SOM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 3217,
				'name' => 'Colombo',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 3218,
				'name' => 'Dehiwala',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 3219,
				'name' => 'Moratuwa',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 3220,
				'name' => 'Jaffna',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 3221,
				'name' => 'Kandy',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 3222,
				'name' => 'Sri Jayawardenepura Kotte',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 3223,
				'name' => 'Negombo',
				'state_code' => '',
				'country_code' => 'LKA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 3224,
				'name' => 'Omdurman',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 3225,
				'name' => 'Khartum',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 3226,
				'name' => 'Sharq al-Nil',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 3227,
				'name' => 'Port Sudan',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 3228,
				'name' => 'Kassala',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 3229,
				'name' => 'Obeid',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 3230,
				'name' => 'Nyala',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 3231,
				'name' => 'Wad Madani',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 3232,
				'name' => 'al-Qadarif',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 3233,
				'name' => 'Kusti',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 3234,
				'name' => 'al-Fashir',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 3235,
				'name' => 'Juba',
				'state_code' => '',
				'country_code' => 'SDN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 3236,
				'name' => 'Helsinki [Helsingfors]',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 3237,
				'name' => 'Espoo',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 3238,
				'name' => 'Tampere',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 3239,
				'name' => 'Vantaa',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 3240,
				'name' => 'Turku [Åbo]',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 3241,
				'name' => 'Oulu',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 3242,
				'name' => 'Lahti',
				'state_code' => '',
				'country_code' => 'FIN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 3243,
				'name' => 'Paramaribo',
				'state_code' => '',
				'country_code' => 'SUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 3244,
				'name' => 'Mbabane',
				'state_code' => '',
				'country_code' => 'SWZ',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 3245,
				'name' => 'Zürich',
				'state_code' => '',
				'country_code' => 'CHE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 3246,
				'name' => 'Geneve',
				'state_code' => '',
				'country_code' => 'CHE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 3247,
				'name' => 'Basel',
				'state_code' => '',
				'country_code' => 'CHE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 3248,
				'name' => 'Bern',
				'state_code' => '',
				'country_code' => 'CHE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 3249,
				'name' => 'Lausanne',
				'state_code' => '',
				'country_code' => 'CHE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 3250,
				'name' => 'Damascus',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 3251,
				'name' => 'Aleppo',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 3252,
				'name' => 'Hims',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 3253,
				'name' => 'Hama',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 3254,
				'name' => 'Latakia',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 3255,
				'name' => 'al-Qamishliya',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 3256,
				'name' => 'Dayr al-Zawr',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 3257,
				'name' => 'Jaramana',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 3258,
				'name' => 'Duma',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 3259,
				'name' => 'al-Raqqa',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 3260,
				'name' => 'Idlib',
				'state_code' => '',
				'country_code' => 'SYR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 3261,
				'name' => 'Dushanbe',
				'state_code' => '',
				'country_code' => 'TJK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 3262,
				'name' => 'Khujand',
				'state_code' => '',
				'country_code' => 'TJK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 3263,
				'name' => 'Taipei',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 3264,
				'name' => 'Kaohsiung',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 3265,
				'name' => 'Taichung',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 3266,
				'name' => 'Tainan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 3267,
				'name' => 'Panchiao',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 3268,
				'name' => 'Chungho',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 3269,
			'name' => 'Keelung (Chilung)',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 3270,
				'name' => 'Sanchung',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 3271,
				'name' => 'Hsinchuang',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 3272,
				'name' => 'Hsinchu',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 3273,
				'name' => 'Chungli',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 3274,
				'name' => 'Fengshan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 3275,
				'name' => 'Taoyuan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 3276,
				'name' => 'Chiayi',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 3277,
				'name' => 'Hsintien',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 3278,
				'name' => 'Changhwa',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 3279,
				'name' => 'Yungho',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 3280,
				'name' => 'Tucheng',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 3281,
				'name' => 'Pingtung',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 3282,
				'name' => 'Yungkang',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 3283,
				'name' => 'Pingchen',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 3284,
				'name' => 'Tali',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 3285,
				'name' => 'Taiping',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 3286,
				'name' => 'Pate',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 3287,
				'name' => 'Fengyuan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 3288,
				'name' => 'Luchou',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 3289,
				'name' => 'Hsichuh',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 3290,
				'name' => 'Shulin',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 3291,
				'name' => 'Yuanlin',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 3292,
				'name' => 'Yangmei',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 3293,
				'name' => 'Taliao',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 3294,
				'name' => 'Kueishan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 3295,
				'name' => 'Tanshui',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 3296,
				'name' => 'Taitung',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 3297,
				'name' => 'Hualien',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 3298,
				'name' => 'Nantou',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 3299,
				'name' => 'Lungtan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 3300,
				'name' => 'Touliu',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 3301,
				'name' => 'Tsaotun',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 3302,
				'name' => 'Kangshan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 3303,
				'name' => 'Ilan',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 3304,
				'name' => 'Miaoli',
				'state_code' => '',
				'country_code' => 'TWN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 3305,
				'name' => 'Dar es Salaam',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 3306,
				'name' => 'Dodoma',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 3307,
				'name' => 'Mwanza',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 3308,
				'name' => 'Zanzibar',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 3309,
				'name' => 'Tanga',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 3310,
				'name' => 'Mbeya',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 3311,
				'name' => 'Morogoro',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 3312,
				'name' => 'Arusha',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 3313,
				'name' => 'Moshi',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 3314,
				'name' => 'Tabora',
				'state_code' => '',
				'country_code' => 'TZA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 3315,
				'name' => 'København',
				'state_code' => '',
				'country_code' => 'DNK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 3316,
				'name' => 'Århus',
				'state_code' => '',
				'country_code' => 'DNK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 3317,
				'name' => 'Odense',
				'state_code' => '',
				'country_code' => 'DNK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 3318,
				'name' => 'Aalborg',
				'state_code' => '',
				'country_code' => 'DNK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 3319,
				'name' => 'Frederiksberg',
				'state_code' => '',
				'country_code' => 'DNK',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 3320,
				'name' => 'Bangkok',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 3321,
				'name' => 'Nonthaburi',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 3322,
				'name' => 'Nakhon Ratchasima',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 3323,
				'name' => 'Chiang Mai',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 3324,
				'name' => 'Udon Thani',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 3325,
				'name' => 'Hat Yai',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 3326,
				'name' => 'Khon Kaen',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 3327,
				'name' => 'Pak Kret',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 3328,
				'name' => 'Nakhon Sawan',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 3329,
				'name' => 'Ubon Ratchathani',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 3330,
				'name' => 'Songkhla',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 3331,
				'name' => 'Nakhon Pathom',
				'state_code' => '',
				'country_code' => 'THA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 3332,
				'name' => 'Lomé',
				'state_code' => '',
				'country_code' => 'TGO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 3333,
				'name' => 'Fakaofo',
				'state_code' => '',
				'country_code' => 'TKL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 3334,
				'name' => 'Nuku´alofa',
				'state_code' => '',
				'country_code' => 'TON',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 3335,
				'name' => 'Chaguanas',
				'state_code' => '',
				'country_code' => 'TTO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 3336,
				'name' => 'Port-of-Spain',
				'state_code' => '',
				'country_code' => 'TTO',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 3337,
				'name' => 'N´Djaména',
				'state_code' => '',
				'country_code' => 'TCD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 3338,
				'name' => 'Moundou',
				'state_code' => '',
				'country_code' => 'TCD',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 3339,
				'name' => 'Praha',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 3340,
				'name' => 'Brno',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 3341,
				'name' => 'Ostrava',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 3342,
				'name' => 'Plzen',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 3343,
				'name' => 'Olomouc',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 3344,
				'name' => 'Liberec',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 3345,
				'name' => 'Ceské Budejovice',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 3346,
				'name' => 'Hradec Králové',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 3347,
				'name' => 'Ústí nad Labem',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 3348,
				'name' => 'Pardubice',
				'state_code' => '',
				'country_code' => 'CZE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 3349,
				'name' => 'Tunis',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 3350,
				'name' => 'Sfax',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 3351,
				'name' => 'Ariana',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 3352,
				'name' => 'Ettadhamen',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 3353,
				'name' => 'Sousse',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 3354,
				'name' => 'Kairouan',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 3355,
				'name' => 'Biserta',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 3356,
				'name' => 'Gabès',
				'state_code' => '',
				'country_code' => 'TUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 3357,
				'name' => 'Istanbul',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 3358,
				'name' => 'Ankara',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 3359,
				'name' => 'Izmir',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 3360,
				'name' => 'Adana',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 3361,
				'name' => 'Bursa',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 3362,
				'name' => 'Gaziantep',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 3363,
				'name' => 'Konya',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 3364,
			'name' => 'Mersin (Içel)',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 3365,
				'name' => 'Antalya',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 3366,
				'name' => 'Diyarbakir',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 3367,
				'name' => 'Kayseri',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 3368,
				'name' => 'Eskisehir',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 3369,
				'name' => 'Sanliurfa',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 3370,
				'name' => 'Samsun',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 3371,
				'name' => 'Malatya',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 3372,
				'name' => 'Gebze',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 3373,
				'name' => 'Denizli',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 3374,
				'name' => 'Sivas',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 3375,
				'name' => 'Erzurum',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 3376,
				'name' => 'Tarsus',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 3377,
				'name' => 'Kahramanmaras',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 3378,
				'name' => 'Elâzig',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 3379,
				'name' => 'Van',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 3380,
				'name' => 'Sultanbeyli',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 3381,
			'name' => 'Izmit (Kocaeli)',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 3382,
				'name' => 'Manisa',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 3383,
				'name' => 'Batman',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 3384,
				'name' => 'Balikesir',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 3385,
			'name' => 'Sakarya (Adapazari)',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 3386,
				'name' => 'Iskenderun',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 3387,
				'name' => 'Osmaniye',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 3388,
				'name' => 'Çorum',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 3389,
				'name' => 'Kütahya',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 3390,
			'name' => 'Hatay (Antakya)',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 3391,
				'name' => 'Kirikkale',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 3392,
				'name' => 'Adiyaman',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 3393,
				'name' => 'Trabzon',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 3394,
				'name' => 'Ordu',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 3395,
				'name' => 'Aydin',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 3396,
				'name' => 'Usak',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 3397,
				'name' => 'Edirne',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 3398,
				'name' => 'Çorlu',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 3399,
				'name' => 'Isparta',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 3400,
				'name' => 'Karabük',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 3401,
				'name' => 'Kilis',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 3402,
				'name' => 'Alanya',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 3403,
				'name' => 'Kiziltepe',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 3404,
				'name' => 'Zonguldak',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 3405,
				'name' => 'Siirt',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 3406,
				'name' => 'Viransehir',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 3407,
				'name' => 'Tekirdag',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 3408,
				'name' => 'Karaman',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 3409,
				'name' => 'Afyon',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 3410,
				'name' => 'Aksaray',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 3411,
				'name' => 'Ceyhan',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 3412,
				'name' => 'Erzincan',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 3413,
				'name' => 'Bismil',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 3414,
				'name' => 'Nazilli',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 3415,
				'name' => 'Tokat',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 3416,
				'name' => 'Kars',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 3417,
				'name' => 'Inegöl',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 3418,
				'name' => 'Bandirma',
				'state_code' => '',
				'country_code' => 'TUR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 3419,
				'name' => 'Ashgabat',
				'state_code' => '',
				'country_code' => 'TKM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 3420,
				'name' => 'Chärjew',
				'state_code' => '',
				'country_code' => 'TKM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 3421,
				'name' => 'Dashhowuz',
				'state_code' => '',
				'country_code' => 'TKM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 3422,
				'name' => 'Mary',
				'state_code' => '',
				'country_code' => 'TKM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 3423,
				'name' => 'Cockburn Town',
				'state_code' => '',
				'country_code' => 'TCA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 3424,
				'name' => 'Funafuti',
				'state_code' => '',
				'country_code' => 'TUV',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 3425,
				'name' => 'Kampala',
				'state_code' => '',
				'country_code' => 'UGA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 3426,
				'name' => 'Kyiv',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 3427,
				'name' => 'Harkova [Harkiv]',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 3428,
				'name' => 'Dnipropetrovsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 3429,
				'name' => 'Donetsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 3430,
				'name' => 'Odesa',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 3431,
				'name' => 'Zaporizzja',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 3432,
				'name' => 'Lviv',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 3433,
				'name' => 'Kryvyi Rig',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 3434,
				'name' => 'Mykolajiv',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 3435,
				'name' => 'Mariupol',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 3436,
				'name' => 'Lugansk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 3437,
				'name' => 'Vinnytsja',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 3438,
				'name' => 'Makijivka',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 3439,
				'name' => 'Herson',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 3440,
				'name' => 'Sevastopol',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 3441,
				'name' => 'Simferopol',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 3442,
				'name' => 'Pultava [Poltava]',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 3443,
				'name' => 'Tšernigiv',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 3444,
				'name' => 'Tšerkasy',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 3445,
				'name' => 'Gorlivka',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 3446,
				'name' => 'Zytomyr',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 3447,
				'name' => 'Sumy',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 3448,
				'name' => 'Dniprodzerzynsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 3449,
				'name' => 'Kirovograd',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 3450,
				'name' => 'Hmelnytskyi',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 3451,
				'name' => 'Tšernivtsi',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 3452,
				'name' => 'Rivne',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 3453,
				'name' => 'Krementšuk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 3454,
				'name' => 'Ivano-Frankivsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 3455,
				'name' => 'Ternopil',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 3456,
				'name' => 'Lutsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 3457,
				'name' => 'Bila Tserkva',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 3458,
				'name' => 'Kramatorsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 3459,
				'name' => 'Melitopol',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 3460,
				'name' => 'Kertš',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 3461,
				'name' => 'Nikopol',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 3462,
				'name' => 'Berdjansk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 3463,
				'name' => 'Pavlograd',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 3464,
				'name' => 'Sjeverodonetsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 3465,
				'name' => 'Slovjansk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 3466,
				'name' => 'Uzgorod',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 3467,
				'name' => 'Altševsk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 3468,
				'name' => 'Lysytšansk',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 3469,
				'name' => 'Jevpatorija',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 3470,
				'name' => 'Kamjanets-Podilskyi',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 3471,
				'name' => 'Jenakijeve',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 3472,
				'name' => 'Krasnyi Lutš',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 3473,
				'name' => 'Stahanov',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 3474,
				'name' => 'Oleksandrija',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 3475,
				'name' => 'Konotop',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 3476,
				'name' => 'Kostjantynivka',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 3477,
				'name' => 'Berdytšiv',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 3478,
				'name' => 'Izmajil',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 3479,
				'name' => 'Šostka',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 3480,
				'name' => 'Uman',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 3481,
				'name' => 'Brovary',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 3482,
				'name' => 'Mukatševe',
				'state_code' => '',
				'country_code' => 'UKR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 3483,
				'name' => 'Budapest',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 3484,
				'name' => 'Debrecen',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 3485,
				'name' => 'Miskolc',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 3486,
				'name' => 'Szeged',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 3487,
				'name' => 'Pécs',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 3488,
				'name' => 'Györ',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 3489,
				'name' => 'Nyiregyháza',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 3490,
				'name' => 'Kecskemét',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 3491,
				'name' => 'Székesfehérvár',
				'state_code' => '',
				'country_code' => 'HUN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 3492,
				'name' => 'Montevideo',
				'state_code' => '',
				'country_code' => 'URY',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 3493,
				'name' => 'Nouméa',
				'state_code' => '',
				'country_code' => 'NCL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 3494,
				'name' => 'Auckland',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 3495,
				'name' => 'Christchurch',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 3496,
				'name' => 'Manukau',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 3497,
				'name' => 'North Shore',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 3498,
				'name' => 'Waitakere',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 3499,
				'name' => 'Wellington',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 3500,
				'name' => 'Dunedin',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 3501,
				'name' => 'Hamilton',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 3502,
				'name' => 'Lower Hutt',
				'state_code' => '',
				'country_code' => 'NZL',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 3503,
				'name' => 'Toskent',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 3504,
				'name' => 'Namangan',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 3505,
				'name' => 'Samarkand',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 3506,
				'name' => 'Andijon',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 3507,
				'name' => 'Buhoro',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 3508,
				'name' => 'Karsi',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 3509,
				'name' => 'Nukus',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 3510,
				'name' => 'Kükon',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 3511,
				'name' => 'Fargona',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 3512,
				'name' => 'Circik',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 3513,
				'name' => 'Margilon',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 3514,
				'name' => 'Ürgenc',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 3515,
				'name' => 'Angren',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 3516,
				'name' => 'Cizah',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 3517,
				'name' => 'Navoi',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 3518,
				'name' => 'Olmalik',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 3519,
				'name' => 'Termiz',
				'state_code' => '',
				'country_code' => 'UZB',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 3520,
				'name' => 'Minsk',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 3521,
				'name' => 'Gomel',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 3522,
				'name' => 'Mogiljov',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 3523,
				'name' => 'Vitebsk',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 3524,
				'name' => 'Grodno',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 3525,
				'name' => 'Brest',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 3526,
				'name' => 'Bobruisk',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 3527,
				'name' => 'Baranovitši',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 3528,
				'name' => 'Borisov',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 3529,
				'name' => 'Pinsk',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 3530,
				'name' => 'Orša',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 3531,
				'name' => 'Mozyr',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 3532,
				'name' => 'Novopolotsk',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 3533,
				'name' => 'Lida',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 3534,
				'name' => 'Soligorsk',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 3535,
				'name' => 'Molodetšno',
				'state_code' => '',
				'country_code' => 'BLR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 3536,
				'name' => 'Mata-Utu',
				'state_code' => '',
				'country_code' => 'WLF',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 3537,
				'name' => 'Port-Vila',
				'state_code' => '',
				'country_code' => 'VUT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 3538,
				'name' => 'Città del Vaticano',
				'state_code' => '',
				'country_code' => 'VAT',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 3539,
				'name' => 'Caracas',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 3540,
				'name' => 'Maracaíbo',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 3541,
				'name' => 'Barquisimeto',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 3542,
				'name' => 'Valencia',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 3543,
				'name' => 'Ciudad Guayana',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 3544,
				'name' => 'Petare',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 3545,
				'name' => 'Maracay',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 3546,
				'name' => 'Barcelona',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 3547,
				'name' => 'Maturín',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 3548,
				'name' => 'San Cristóbal',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 3549,
				'name' => 'Ciudad Bolívar',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 3550,
				'name' => 'Cumaná',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 3551,
				'name' => 'Mérida',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 3552,
				'name' => 'Cabimas',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 3553,
				'name' => 'Barinas',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 3554,
				'name' => 'Turmero',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 3555,
				'name' => 'Baruta',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 3556,
				'name' => 'Puerto Cabello',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 3557,
				'name' => 'Santa Ana de Coro',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 3558,
				'name' => 'Los Teques',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 3559,
				'name' => 'Punto Fijo',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 3560,
				'name' => 'Guarenas',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 3561,
				'name' => 'Acarigua',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 3562,
				'name' => 'Puerto La Cruz',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 3563,
				'name' => 'Ciudad Losada',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 3564,
				'name' => 'Guacara',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 3565,
				'name' => 'Valera',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 3566,
				'name' => 'Guanare',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 3567,
				'name' => 'Carúpano',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 3568,
				'name' => 'Catia La Mar',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 3569,
				'name' => 'El Tigre',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 3570,
				'name' => 'Guatire',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 3571,
				'name' => 'Calabozo',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 3572,
				'name' => 'Pozuelos',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 3573,
				'name' => 'Ciudad Ojeda',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 3574,
				'name' => 'Ocumare del Tuy',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 3575,
				'name' => 'Valle de la Pascua',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 3576,
				'name' => 'Araure',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 3577,
				'name' => 'San Fernando de Apure',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 3578,
				'name' => 'San Felipe',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 3579,
				'name' => 'El Limón',
				'state_code' => '',
				'country_code' => 'VEN',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 3580,
				'name' => 'Moscow',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			80 =>
			array (
				'id' => 3581,
				'name' => 'St Petersburg',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			81 =>
			array (
				'id' => 3582,
				'name' => 'Novosibirsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			82 =>
			array (
				'id' => 3583,
				'name' => 'Nizni Novgorod',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			83 =>
			array (
				'id' => 3584,
				'name' => 'Jekaterinburg',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			84 =>
			array (
				'id' => 3585,
				'name' => 'Samara',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			85 =>
			array (
				'id' => 3586,
				'name' => 'Omsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			86 =>
			array (
				'id' => 3587,
				'name' => 'Kazan',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			87 =>
			array (
				'id' => 3588,
				'name' => 'Ufa',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			88 =>
			array (
				'id' => 3589,
				'name' => 'Tšeljabinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			89 =>
			array (
				'id' => 3590,
				'name' => 'Rostov-na-Donu',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			90 =>
			array (
				'id' => 3591,
				'name' => 'Perm',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			91 =>
			array (
				'id' => 3592,
				'name' => 'Volgograd',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			92 =>
			array (
				'id' => 3593,
				'name' => 'Voronez',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			93 =>
			array (
				'id' => 3594,
				'name' => 'Krasnojarsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			94 =>
			array (
				'id' => 3595,
				'name' => 'Saratov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			95 =>
			array (
				'id' => 3596,
				'name' => 'Toljatti',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			96 =>
			array (
				'id' => 3597,
				'name' => 'Uljanovsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			97 =>
			array (
				'id' => 3598,
				'name' => 'Izevsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			98 =>
			array (
				'id' => 3599,
				'name' => 'Krasnodar',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			99 =>
			array (
				'id' => 3600,
				'name' => 'Jaroslavl',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			100 =>
			array (
				'id' => 3601,
				'name' => 'Habarovsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			101 =>
			array (
				'id' => 3602,
				'name' => 'Vladivostok',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			102 =>
			array (
				'id' => 3603,
				'name' => 'Irkutsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			103 =>
			array (
				'id' => 3604,
				'name' => 'Barnaul',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			104 =>
			array (
				'id' => 3605,
				'name' => 'Novokuznetsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			105 =>
			array (
				'id' => 3606,
				'name' => 'Penza',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			106 =>
			array (
				'id' => 3607,
				'name' => 'Rjazan',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			107 =>
			array (
				'id' => 3608,
				'name' => 'Orenburg',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			108 =>
			array (
				'id' => 3609,
				'name' => 'Lipetsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			109 =>
			array (
				'id' => 3610,
				'name' => 'Nabereznyje Tšelny',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			110 =>
			array (
				'id' => 3611,
				'name' => 'Tula',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			111 =>
			array (
				'id' => 3612,
				'name' => 'Tjumen',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			112 =>
			array (
				'id' => 3613,
				'name' => 'Kemerovo',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			113 =>
			array (
				'id' => 3614,
				'name' => 'Astrahan',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			114 =>
			array (
				'id' => 3615,
				'name' => 'Tomsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			115 =>
			array (
				'id' => 3616,
				'name' => 'Kirov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			116 =>
			array (
				'id' => 3617,
				'name' => 'Ivanovo',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			117 =>
			array (
				'id' => 3618,
				'name' => 'Tšeboksary',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			118 =>
			array (
				'id' => 3619,
				'name' => 'Brjansk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			119 =>
			array (
				'id' => 3620,
				'name' => 'Tver',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			120 =>
			array (
				'id' => 3621,
				'name' => 'Kursk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			121 =>
			array (
				'id' => 3622,
				'name' => 'Magnitogorsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			122 =>
			array (
				'id' => 3623,
				'name' => 'Kaliningrad',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			123 =>
			array (
				'id' => 3624,
				'name' => 'Nizni Tagil',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			124 =>
			array (
				'id' => 3625,
				'name' => 'Murmansk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			125 =>
			array (
				'id' => 3626,
				'name' => 'Ulan-Ude',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			126 =>
			array (
				'id' => 3627,
				'name' => 'Kurgan',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			127 =>
			array (
				'id' => 3628,
				'name' => 'Arkangeli',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			128 =>
			array (
				'id' => 3629,
				'name' => 'Sotši',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			129 =>
			array (
				'id' => 3630,
				'name' => 'Smolensk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			130 =>
			array (
				'id' => 3631,
				'name' => 'Orjol',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			131 =>
			array (
				'id' => 3632,
				'name' => 'Stavropol',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			132 =>
			array (
				'id' => 3633,
				'name' => 'Belgorod',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			133 =>
			array (
				'id' => 3634,
				'name' => 'Kaluga',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			134 =>
			array (
				'id' => 3635,
				'name' => 'Vladimir',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			135 =>
			array (
				'id' => 3636,
				'name' => 'Mahatškala',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			136 =>
			array (
				'id' => 3637,
				'name' => 'Tšerepovets',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			137 =>
			array (
				'id' => 3638,
				'name' => 'Saransk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			138 =>
			array (
				'id' => 3639,
				'name' => 'Tambov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			139 =>
			array (
				'id' => 3640,
				'name' => 'Vladikavkaz',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			140 =>
			array (
				'id' => 3641,
				'name' => 'Tšita',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			141 =>
			array (
				'id' => 3642,
				'name' => 'Vologda',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			142 =>
			array (
				'id' => 3643,
				'name' => 'Veliki Novgorod',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			143 =>
			array (
				'id' => 3644,
				'name' => 'Komsomolsk-na-Amure',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			144 =>
			array (
				'id' => 3645,
				'name' => 'Kostroma',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			145 =>
			array (
				'id' => 3646,
				'name' => 'Volzski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			146 =>
			array (
				'id' => 3647,
				'name' => 'Taganrog',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			147 =>
			array (
				'id' => 3648,
				'name' => 'Petroskoi',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			148 =>
			array (
				'id' => 3649,
				'name' => 'Bratsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			149 =>
			array (
				'id' => 3650,
				'name' => 'Dzerzinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			150 =>
			array (
				'id' => 3651,
				'name' => 'Surgut',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			151 =>
			array (
				'id' => 3652,
				'name' => 'Orsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			152 =>
			array (
				'id' => 3653,
				'name' => 'Sterlitamak',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			153 =>
			array (
				'id' => 3654,
				'name' => 'Angarsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			154 =>
			array (
				'id' => 3655,
				'name' => 'Joškar-Ola',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			155 =>
			array (
				'id' => 3656,
				'name' => 'Rybinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			156 =>
			array (
				'id' => 3657,
				'name' => 'Prokopjevsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			157 =>
			array (
				'id' => 3658,
				'name' => 'Niznevartovsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			158 =>
			array (
				'id' => 3659,
				'name' => 'Naltšik',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			159 =>
			array (
				'id' => 3660,
				'name' => 'Syktyvkar',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			160 =>
			array (
				'id' => 3661,
				'name' => 'Severodvinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			161 =>
			array (
				'id' => 3662,
				'name' => 'Bijsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			162 =>
			array (
				'id' => 3663,
				'name' => 'Niznekamsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			163 =>
			array (
				'id' => 3664,
				'name' => 'Blagoveštšensk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			164 =>
			array (
				'id' => 3665,
				'name' => 'Šahty',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			165 =>
			array (
				'id' => 3666,
				'name' => 'Staryi Oskol',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			166 =>
			array (
				'id' => 3667,
				'name' => 'Zelenograd',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			167 =>
			array (
				'id' => 3668,
				'name' => 'Balakovo',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			168 =>
			array (
				'id' => 3669,
				'name' => 'Novorossijsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			169 =>
			array (
				'id' => 3670,
				'name' => 'Pihkova',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			170 =>
			array (
				'id' => 3671,
				'name' => 'Zlatoust',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			171 =>
			array (
				'id' => 3672,
				'name' => 'Jakutsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			172 =>
			array (
				'id' => 3673,
				'name' => 'Podolsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			173 =>
			array (
				'id' => 3674,
				'name' => 'Petropavlovsk-Kamtšatski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			174 =>
			array (
				'id' => 3675,
				'name' => 'Kamensk-Uralski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			175 =>
			array (
				'id' => 3676,
				'name' => 'Engels',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			176 =>
			array (
				'id' => 3677,
				'name' => 'Syzran',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			177 =>
			array (
				'id' => 3678,
				'name' => 'Grozny',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			178 =>
			array (
				'id' => 3679,
				'name' => 'Novotšerkassk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			179 =>
			array (
				'id' => 3680,
				'name' => 'Berezniki',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			180 =>
			array (
				'id' => 3681,
				'name' => 'Juzno-Sahalinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			181 =>
			array (
				'id' => 3682,
				'name' => 'Volgodonsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			182 =>
			array (
				'id' => 3683,
				'name' => 'Abakan',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			183 =>
			array (
				'id' => 3684,
				'name' => 'Maikop',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			184 =>
			array (
				'id' => 3685,
				'name' => 'Miass',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			185 =>
			array (
				'id' => 3686,
				'name' => 'Armavir',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			186 =>
			array (
				'id' => 3687,
				'name' => 'Ljubertsy',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			187 =>
			array (
				'id' => 3688,
				'name' => 'Rubtsovsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			188 =>
			array (
				'id' => 3689,
				'name' => 'Kovrov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			189 =>
			array (
				'id' => 3690,
				'name' => 'Nahodka',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			190 =>
			array (
				'id' => 3691,
				'name' => 'Ussurijsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			191 =>
			array (
				'id' => 3692,
				'name' => 'Salavat',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			192 =>
			array (
				'id' => 3693,
				'name' => 'Mytištši',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			193 =>
			array (
				'id' => 3694,
				'name' => 'Kolomna',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			194 =>
			array (
				'id' => 3695,
				'name' => 'Elektrostal',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			195 =>
			array (
				'id' => 3696,
				'name' => 'Murom',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			196 =>
			array (
				'id' => 3697,
				'name' => 'Kolpino',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			197 =>
			array (
				'id' => 3698,
				'name' => 'Norilsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			198 =>
			array (
				'id' => 3699,
				'name' => 'Almetjevsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			199 =>
			array (
				'id' => 3700,
				'name' => 'Novomoskovsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			200 =>
			array (
				'id' => 3701,
				'name' => 'Dimitrovgrad',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			201 =>
			array (
				'id' => 3702,
				'name' => 'Pervouralsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			202 =>
			array (
				'id' => 3703,
				'name' => 'Himki',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			203 =>
			array (
				'id' => 3704,
				'name' => 'Balašiha',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			204 =>
			array (
				'id' => 3705,
				'name' => 'Nevinnomyssk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			205 =>
			array (
				'id' => 3706,
				'name' => 'Pjatigorsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			206 =>
			array (
				'id' => 3707,
				'name' => 'Korolev',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			207 =>
			array (
				'id' => 3708,
				'name' => 'Serpuhov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			208 =>
			array (
				'id' => 3709,
				'name' => 'Odintsovo',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			209 =>
			array (
				'id' => 3710,
				'name' => 'Orehovo-Zujevo',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			210 =>
			array (
				'id' => 3711,
				'name' => 'Kamyšin',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			211 =>
			array (
				'id' => 3712,
				'name' => 'Novotšeboksarsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			212 =>
			array (
				'id' => 3713,
				'name' => 'Tšerkessk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			213 =>
			array (
				'id' => 3714,
				'name' => 'Atšinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			214 =>
			array (
				'id' => 3715,
				'name' => 'Magadan',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			215 =>
			array (
				'id' => 3716,
				'name' => 'Mitšurinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			216 =>
			array (
				'id' => 3717,
				'name' => 'Kislovodsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			217 =>
			array (
				'id' => 3718,
				'name' => 'Jelets',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			218 =>
			array (
				'id' => 3719,
				'name' => 'Seversk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			219 =>
			array (
				'id' => 3720,
				'name' => 'Noginsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			220 =>
			array (
				'id' => 3721,
				'name' => 'Velikije Luki',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			221 =>
			array (
				'id' => 3722,
				'name' => 'Novokuibyševsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			222 =>
			array (
				'id' => 3723,
				'name' => 'Neftekamsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			223 =>
			array (
				'id' => 3724,
				'name' => 'Leninsk-Kuznetski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			224 =>
			array (
				'id' => 3725,
				'name' => 'Oktjabrski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			225 =>
			array (
				'id' => 3726,
				'name' => 'Sergijev Posad',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			226 =>
			array (
				'id' => 3727,
				'name' => 'Arzamas',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			227 =>
			array (
				'id' => 3728,
				'name' => 'Kiseljovsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			228 =>
			array (
				'id' => 3729,
				'name' => 'Novotroitsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			229 =>
			array (
				'id' => 3730,
				'name' => 'Obninsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			230 =>
			array (
				'id' => 3731,
				'name' => 'Kansk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			231 =>
			array (
				'id' => 3732,
				'name' => 'Glazov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			232 =>
			array (
				'id' => 3733,
				'name' => 'Solikamsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			233 =>
			array (
				'id' => 3734,
				'name' => 'Sarapul',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			234 =>
			array (
				'id' => 3735,
				'name' => 'Ust-Ilimsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			235 =>
			array (
				'id' => 3736,
				'name' => 'Štšolkovo',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			236 =>
			array (
				'id' => 3737,
				'name' => 'Mezduretšensk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			237 =>
			array (
				'id' => 3738,
				'name' => 'Usolje-Sibirskoje',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			238 =>
			array (
				'id' => 3739,
				'name' => 'Elista',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			239 =>
			array (
				'id' => 3740,
				'name' => 'Novošahtinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			240 =>
			array (
				'id' => 3741,
				'name' => 'Votkinsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			241 =>
			array (
				'id' => 3742,
				'name' => 'Kyzyl',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			242 =>
			array (
				'id' => 3743,
				'name' => 'Serov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			243 =>
			array (
				'id' => 3744,
				'name' => 'Zelenodolsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			244 =>
			array (
				'id' => 3745,
				'name' => 'Zeleznodoroznyi',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			245 =>
			array (
				'id' => 3746,
				'name' => 'Kinešma',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			246 =>
			array (
				'id' => 3747,
				'name' => 'Kuznetsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			247 =>
			array (
				'id' => 3748,
				'name' => 'Uhta',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			248 =>
			array (
				'id' => 3749,
				'name' => 'Jessentuki',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			249 =>
			array (
				'id' => 3750,
				'name' => 'Tobolsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			250 =>
			array (
				'id' => 3751,
				'name' => 'Neftejugansk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			251 =>
			array (
				'id' => 3752,
				'name' => 'Bataisk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			252 =>
			array (
				'id' => 3753,
				'name' => 'Nojabrsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			253 =>
			array (
				'id' => 3754,
				'name' => 'Balašov',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			254 =>
			array (
				'id' => 3755,
				'name' => 'Zeleznogorsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			255 =>
			array (
				'id' => 3756,
				'name' => 'Zukovski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			256 =>
			array (
				'id' => 3757,
				'name' => 'Anzero-Sudzensk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			257 =>
			array (
				'id' => 3758,
				'name' => 'Bugulma',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			258 =>
			array (
				'id' => 3759,
				'name' => 'Zeleznogorsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			259 =>
			array (
				'id' => 3760,
				'name' => 'Novouralsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			260 =>
			array (
				'id' => 3761,
				'name' => 'Puškin',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			261 =>
			array (
				'id' => 3762,
				'name' => 'Vorkuta',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			262 =>
			array (
				'id' => 3763,
				'name' => 'Derbent',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			263 =>
			array (
				'id' => 3764,
				'name' => 'Kirovo-Tšepetsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			264 =>
			array (
				'id' => 3765,
				'name' => 'Krasnogorsk',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			265 =>
			array (
				'id' => 3766,
				'name' => 'Klin',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			266 =>
			array (
				'id' => 3767,
				'name' => 'Tšaikovski',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			267 =>
			array (
				'id' => 3768,
				'name' => 'Novyi Urengoi',
				'state_code' => '',
				'country_code' => 'RUS',
				'created_at' => $now,
				'updated_at' => $now,
			),
			268 =>
			array (
				'id' => 3769,
				'name' => 'Ho Chi Minh City',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			269 =>
			array (
				'id' => 3770,
				'name' => 'Hanoi',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			270 =>
			array (
				'id' => 3771,
				'name' => 'Haiphong',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			271 =>
			array (
				'id' => 3772,
				'name' => 'Da Nang',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			272 =>
			array (
				'id' => 3773,
				'name' => 'Biên Hoa',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			273 =>
			array (
				'id' => 3774,
				'name' => 'Nha Trang',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			274 =>
			array (
				'id' => 3775,
				'name' => 'Hue',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			275 =>
			array (
				'id' => 3776,
				'name' => 'Can Tho',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			276 =>
			array (
				'id' => 3777,
				'name' => 'Cam Pha',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			277 =>
			array (
				'id' => 3778,
				'name' => 'Nam Dinh',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			278 =>
			array (
				'id' => 3779,
				'name' => 'Quy Nhon',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			279 =>
			array (
				'id' => 3780,
				'name' => 'Vung Tau',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			280 =>
			array (
				'id' => 3781,
				'name' => 'Rach Gia',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			281 =>
			array (
				'id' => 3782,
				'name' => 'Long Xuyen',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			282 =>
			array (
				'id' => 3783,
				'name' => 'Thai Nguyen',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			283 =>
			array (
				'id' => 3784,
				'name' => 'Hong Gai',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			284 =>
			array (
				'id' => 3785,
				'name' => 'Phan Thiêt',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			285 =>
			array (
				'id' => 3786,
				'name' => 'Cam Ranh',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			286 =>
			array (
				'id' => 3787,
				'name' => 'Vinh',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			287 =>
			array (
				'id' => 3788,
				'name' => 'My Tho',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			288 =>
			array (
				'id' => 3789,
				'name' => 'Da Lat',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			289 =>
			array (
				'id' => 3790,
				'name' => 'Buon Ma Thuot',
				'state_code' => '',
				'country_code' => 'VNM',
				'created_at' => $now,
				'updated_at' => $now,
			),
			290 =>
			array (
				'id' => 3791,
				'name' => 'Tallinn',
				'state_code' => '',
				'country_code' => 'EST',
				'created_at' => $now,
				'updated_at' => $now,
			),
			291 =>
			array (
				'id' => 3792,
				'name' => 'Tartu',
				'state_code' => '',
				'country_code' => 'EST',
				'created_at' => $now,
				'updated_at' => $now,
			),
			292 =>
			array (
				'id' => 3793,
				'name' => 'New York',
				'state_code' => 'NY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			293 =>
			array (
				'id' => 3794,
				'name' => 'Los Angeles',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			294 =>
			array (
				'id' => 3795,
				'name' => 'Chicago',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			295 =>
			array (
				'id' => 3796,
				'name' => 'Houston',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			296 =>
			array (
				'id' => 3797,
				'name' => 'Philadelphia',
				'state_code' => 'PA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			297 =>
			array (
				'id' => 3798,
				'name' => 'Phoenix',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			298 =>
			array (
				'id' => 3799,
				'name' => 'San Diego',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			299 =>
			array (
				'id' => 3800,
				'name' => 'Dallas',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			300 =>
			array (
				'id' => 3801,
				'name' => 'San Antonio',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			301 =>
			array (
				'id' => 3802,
				'name' => 'Detroit',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			302 =>
			array (
				'id' => 3803,
				'name' => 'San Jose',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			303 =>
			array (
				'id' => 3804,
				'name' => 'Indianapolis',
				'state_code' => 'IN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			304 =>
			array (
				'id' => 3805,
				'name' => 'San Francisco',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			305 =>
			array (
				'id' => 3806,
				'name' => 'Jacksonville',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			306 =>
			array (
				'id' => 3807,
				'name' => 'Columbus',
				'state_code' => 'OH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			307 =>
			array (
				'id' => 3808,
				'name' => 'Austin',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			308 =>
			array (
				'id' => 3809,
				'name' => 'Baltimore',
				'state_code' => 'MD',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			309 =>
			array (
				'id' => 3810,
				'name' => 'Memphis',
				'state_code' => 'TN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			310 =>
			array (
				'id' => 3811,
				'name' => 'Milwaukee',
				'state_code' => 'WI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			311 =>
			array (
				'id' => 3812,
				'name' => 'Boston',
				'state_code' => 'MA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			312 =>
			array (
				'id' => 3813,
				'name' => 'Washington',
				'state_code' => '',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			313 =>
			array (
				'id' => 3814,
				'name' => 'Nashville-Davidson',
				'state_code' => 'TN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			314 =>
			array (
				'id' => 3815,
				'name' => 'El Paso',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			315 =>
			array (
				'id' => 3816,
				'name' => 'Seattle',
				'state_code' => 'WA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			316 =>
			array (
				'id' => 3817,
				'name' => 'Denver',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			317 =>
			array (
				'id' => 3818,
				'name' => 'Charlotte',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			318 =>
			array (
				'id' => 3819,
				'name' => 'Fort Worth',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			319 =>
			array (
				'id' => 3820,
				'name' => 'Portland',
				'state_code' => 'OR',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			320 =>
			array (
				'id' => 3821,
				'name' => 'Oklahoma City',
				'state_code' => 'OK',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			321 =>
			array (
				'id' => 3822,
				'name' => 'Tucson',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			322 =>
			array (
				'id' => 3823,
				'name' => 'New Orleans',
				'state_code' => 'LA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			323 =>
			array (
				'id' => 3824,
				'name' => 'Las Vegas',
				'state_code' => 'NV',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			324 =>
			array (
				'id' => 3825,
				'name' => 'Cleveland',
				'state_code' => 'OH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			325 =>
			array (
				'id' => 3826,
				'name' => 'Long Beach',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			326 =>
			array (
				'id' => 3827,
				'name' => 'Albuquerque',
				'state_code' => 'NM',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			327 =>
			array (
				'id' => 3828,
				'name' => 'Kansas City',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			328 =>
			array (
				'id' => 3829,
				'name' => 'Fresno',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			329 =>
			array (
				'id' => 3830,
				'name' => 'Virginia Beach',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			330 =>
			array (
				'id' => 3831,
				'name' => 'Atlanta',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			331 =>
			array (
				'id' => 3832,
				'name' => 'Sacramento',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			332 =>
			array (
				'id' => 3833,
				'name' => 'Oakland',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			333 =>
			array (
				'id' => 3834,
				'name' => 'Mesa',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			334 =>
			array (
				'id' => 3835,
				'name' => 'Tulsa',
				'state_code' => 'OK',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			335 =>
			array (
				'id' => 3836,
				'name' => 'Omaha',
				'state_code' => 'NE',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			336 =>
			array (
				'id' => 3837,
				'name' => 'Minneapolis',
				'state_code' => 'MN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			337 =>
			array (
				'id' => 3838,
				'name' => 'Honolulu',
				'state_code' => 'HI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			338 =>
			array (
				'id' => 3839,
				'name' => 'Miami',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			339 =>
			array (
				'id' => 3840,
				'name' => 'Colorado Springs',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			340 =>
			array (
				'id' => 3841,
				'name' => 'Saint Louis',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			341 =>
			array (
				'id' => 3842,
				'name' => 'Wichita',
				'state_code' => 'KS',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			342 =>
			array (
				'id' => 3843,
				'name' => 'Santa Ana',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			343 =>
			array (
				'id' => 3844,
				'name' => 'Pittsburgh',
				'state_code' => 'PA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			344 =>
			array (
				'id' => 3845,
				'name' => 'Arlington',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			345 =>
			array (
				'id' => 3846,
				'name' => 'Cincinnati',
				'state_code' => 'OH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			346 =>
			array (
				'id' => 3847,
				'name' => 'Anaheim',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			347 =>
			array (
				'id' => 3848,
				'name' => 'Toledo',
				'state_code' => 'OH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			348 =>
			array (
				'id' => 3849,
				'name' => 'Tampa',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			349 =>
			array (
				'id' => 3850,
				'name' => 'Buffalo',
				'state_code' => 'NY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			350 =>
			array (
				'id' => 3851,
				'name' => 'Saint Paul',
				'state_code' => 'MN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			351 =>
			array (
				'id' => 3852,
				'name' => 'Corpus Christi',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			352 =>
			array (
				'id' => 3853,
				'name' => 'Aurora',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			353 =>
			array (
				'id' => 3854,
				'name' => 'Raleigh',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			354 =>
			array (
				'id' => 3855,
				'name' => 'Newark',
				'state_code' => 'NJ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			355 =>
			array (
				'id' => 3856,
				'name' => 'Lexington-Fayette',
				'state_code' => 'KY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			356 =>
			array (
				'id' => 3857,
				'name' => 'Anchorage',
				'state_code' => 'AK',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			357 =>
			array (
				'id' => 3858,
				'name' => 'Louisville',
				'state_code' => 'KY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			358 =>
			array (
				'id' => 3859,
				'name' => 'Riverside',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			359 =>
			array (
				'id' => 3860,
				'name' => 'Saint Petersburg',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			360 =>
			array (
				'id' => 3861,
				'name' => 'Bakersfield',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			361 =>
			array (
				'id' => 3862,
				'name' => 'Stockton',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			362 =>
			array (
				'id' => 3863,
				'name' => 'Birmingham',
				'state_code' => 'AL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			363 =>
			array (
				'id' => 3864,
				'name' => 'Jersey City',
				'state_code' => 'NJ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			364 =>
			array (
				'id' => 3865,
				'name' => 'Norfolk',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			365 =>
			array (
				'id' => 3866,
				'name' => 'Baton Rouge',
				'state_code' => 'LA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			366 =>
			array (
				'id' => 3867,
				'name' => 'Hialeah',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			367 =>
			array (
				'id' => 3868,
				'name' => 'Lincoln',
				'state_code' => 'NE',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			368 =>
			array (
				'id' => 3869,
				'name' => 'Greensboro',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			369 =>
			array (
				'id' => 3870,
				'name' => 'Plano',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			370 =>
			array (
				'id' => 3871,
				'name' => 'Rochester',
				'state_code' => 'NY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			371 =>
			array (
				'id' => 3872,
				'name' => 'Glendale',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			372 =>
			array (
				'id' => 3873,
				'name' => 'Akron',
				'state_code' => 'OH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			373 =>
			array (
				'id' => 3874,
				'name' => 'Garland',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			374 =>
			array (
				'id' => 3875,
				'name' => 'Madison',
				'state_code' => 'WI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			375 =>
			array (
				'id' => 3876,
				'name' => 'Fort Wayne',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			376 =>
			array (
				'id' => 3877,
				'name' => 'Fremont',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			377 =>
			array (
				'id' => 3878,
				'name' => 'Scottsdale',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			378 =>
			array (
				'id' => 3879,
				'name' => 'Montgomery',
				'state_code' => 'AL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			379 =>
			array (
				'id' => 3880,
				'name' => 'Shreveport',
				'state_code' => 'LA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			380 =>
			array (
				'id' => 3881,
				'name' => 'Augusta-Richmond County',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			381 =>
			array (
				'id' => 3882,
				'name' => 'Lubbock',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			382 =>
			array (
				'id' => 3883,
				'name' => 'Chesapeake',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			383 =>
			array (
				'id' => 3884,
				'name' => 'Mobile',
				'state_code' => 'AL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			384 =>
			array (
				'id' => 3885,
				'name' => 'Des Moines',
				'state_code' => 'IA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			385 =>
			array (
				'id' => 3886,
				'name' => 'Grand Rapids',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			386 =>
			array (
				'id' => 3887,
				'name' => 'Richmond',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			387 =>
			array (
				'id' => 3888,
				'name' => 'Yonkers',
				'state_code' => 'NY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			388 =>
			array (
				'id' => 3889,
				'name' => 'Spokane',
				'state_code' => 'WA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			389 =>
			array (
				'id' => 3890,
				'name' => 'Glendale',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			390 =>
			array (
				'id' => 3891,
				'name' => 'Tacoma',
				'state_code' => 'WA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			391 =>
			array (
				'id' => 3892,
				'name' => 'Irving',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			392 =>
			array (
				'id' => 3893,
				'name' => 'Huntington Beach',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			393 =>
			array (
				'id' => 3894,
				'name' => 'Modesto',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			394 =>
			array (
				'id' => 3895,
				'name' => 'Durham',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			395 =>
			array (
				'id' => 3896,
				'name' => 'Columbus',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			396 =>
			array (
				'id' => 3897,
				'name' => 'Orlando',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			397 =>
			array (
				'id' => 3898,
				'name' => 'Boise City',
				'state_code' => 'ID',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			398 =>
			array (
				'id' => 3899,
				'name' => 'Winston-Salem',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			399 =>
			array (
				'id' => 3900,
				'name' => 'San Bernardino',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			400 =>
			array (
				'id' => 3901,
				'name' => 'Jackson',
				'state_code' => 'MS',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			401 =>
			array (
				'id' => 3902,
				'name' => 'Little Rock',
				'state_code' => 'AR',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			402 =>
			array (
				'id' => 3903,
				'name' => 'Salt Lake City',
				'state_code' => 'UT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			403 =>
			array (
				'id' => 3904,
				'name' => 'Reno',
				'state_code' => 'NV',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			404 =>
			array (
				'id' => 3905,
				'name' => 'Newport News',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			405 =>
			array (
				'id' => 3906,
				'name' => 'Chandler',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			406 =>
			array (
				'id' => 3907,
				'name' => 'Laredo',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			407 =>
			array (
				'id' => 3908,
				'name' => 'Henderson',
				'state_code' => 'NV',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			408 =>
			array (
				'id' => 3909,
				'name' => 'Arlington',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			409 =>
			array (
				'id' => 3910,
				'name' => 'Knoxville',
				'state_code' => 'TN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			410 =>
			array (
				'id' => 3911,
				'name' => 'Amarillo',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			411 =>
			array (
				'id' => 3912,
				'name' => 'Providence',
				'state_code' => 'RI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			412 =>
			array (
				'id' => 3913,
				'name' => 'Chula Vista',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			413 =>
			array (
				'id' => 3914,
				'name' => 'Worcester',
				'state_code' => 'MA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			414 =>
			array (
				'id' => 3915,
				'name' => 'Oxnard',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			415 =>
			array (
				'id' => 3916,
				'name' => 'Dayton',
				'state_code' => 'OH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			416 =>
			array (
				'id' => 3917,
				'name' => 'Garden Grove',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			417 =>
			array (
				'id' => 3918,
				'name' => 'Oceanside',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			418 =>
			array (
				'id' => 3919,
				'name' => 'Tempe',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			419 =>
			array (
				'id' => 3920,
				'name' => 'Huntsville',
				'state_code' => 'AL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			420 =>
			array (
				'id' => 3921,
				'name' => 'Ontario',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			421 =>
			array (
				'id' => 3922,
				'name' => 'Chattanooga',
				'state_code' => 'TN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			422 =>
			array (
				'id' => 3923,
				'name' => 'Fort Lauderdale',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			423 =>
			array (
				'id' => 3924,
				'name' => 'Springfield',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			424 =>
			array (
				'id' => 3925,
				'name' => 'Springfield',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			425 =>
			array (
				'id' => 3926,
				'name' => 'Santa Clarita',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			426 =>
			array (
				'id' => 3927,
				'name' => 'Salinas',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			427 =>
			array (
				'id' => 3928,
				'name' => 'Tallahassee',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			428 =>
			array (
				'id' => 3929,
				'name' => 'Rockford',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			429 =>
			array (
				'id' => 3930,
				'name' => 'Pomona',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			430 =>
			array (
				'id' => 3931,
				'name' => 'Metairie',
				'state_code' => 'LA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			431 =>
			array (
				'id' => 3932,
				'name' => 'Paterson',
				'state_code' => 'NJ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			432 =>
			array (
				'id' => 3933,
				'name' => 'Overland Park',
				'state_code' => 'KS',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			433 =>
			array (
				'id' => 3934,
				'name' => 'Santa Rosa',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			434 =>
			array (
				'id' => 3935,
				'name' => 'Syracuse',
				'state_code' => 'NY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			435 =>
			array (
				'id' => 3936,
				'name' => 'Kansas City',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			436 =>
			array (
				'id' => 3937,
				'name' => 'Hampton',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			437 =>
			array (
				'id' => 3938,
				'name' => 'Lakewood',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			438 =>
			array (
				'id' => 3939,
				'name' => 'Vancouver',
				'state_code' => 'WA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			439 =>
			array (
				'id' => 3940,
				'name' => 'Irvine',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			440 =>
			array (
				'id' => 3941,
				'name' => 'Aurora',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			441 =>
			array (
				'id' => 3942,
				'name' => 'Moreno Valley',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			442 =>
			array (
				'id' => 3943,
				'name' => 'Pasadena',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			443 =>
			array (
				'id' => 3944,
				'name' => 'Hayward',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			444 =>
			array (
				'id' => 3945,
				'name' => 'Brownsville',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			445 =>
			array (
				'id' => 3946,
				'name' => 'Bridgeport',
				'state_code' => 'CT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			446 =>
			array (
				'id' => 3947,
				'name' => 'Hollywood',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			447 =>
			array (
				'id' => 3948,
				'name' => 'Warren',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			448 =>
			array (
				'id' => 3949,
				'name' => 'Torrance',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			449 =>
			array (
				'id' => 3950,
				'name' => 'Eugene',
				'state_code' => 'OR',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			450 =>
			array (
				'id' => 3951,
				'name' => 'Pembroke Pines',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			451 =>
			array (
				'id' => 3952,
				'name' => 'Salem',
				'state_code' => 'OR',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			452 =>
			array (
				'id' => 3953,
				'name' => 'Pasadena',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			453 =>
			array (
				'id' => 3954,
				'name' => 'Escondido',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			454 =>
			array (
				'id' => 3955,
				'name' => 'Sunnyvale',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			455 =>
			array (
				'id' => 3956,
				'name' => 'Savannah',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			456 =>
			array (
				'id' => 3957,
				'name' => 'Fontana',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			457 =>
			array (
				'id' => 3958,
				'name' => 'Orange',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			458 =>
			array (
				'id' => 3959,
				'name' => 'Naperville',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			459 =>
			array (
				'id' => 3960,
				'name' => 'Alexandria',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			460 =>
			array (
				'id' => 3961,
				'name' => 'Rancho Cucamonga',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			461 =>
			array (
				'id' => 3962,
				'name' => 'Grand Prairie',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			462 =>
			array (
				'id' => 3963,
				'name' => 'East Los Angeles',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			463 =>
			array (
				'id' => 3964,
				'name' => 'Fullerton',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			464 =>
			array (
				'id' => 3965,
				'name' => 'Corona',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			465 =>
			array (
				'id' => 3966,
				'name' => 'Flint',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			466 =>
			array (
				'id' => 3967,
				'name' => 'Paradise',
				'state_code' => 'NV',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			467 =>
			array (
				'id' => 3968,
				'name' => 'Mesquite',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			468 =>
			array (
				'id' => 3969,
				'name' => 'Sterling Heights',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			469 =>
			array (
				'id' => 3970,
				'name' => 'Sioux Falls',
				'state_code' => 'SD',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			470 =>
			array (
				'id' => 3971,
				'name' => 'New Haven',
				'state_code' => 'CT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			471 =>
			array (
				'id' => 3972,
				'name' => 'Topeka',
				'state_code' => 'KS',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			472 =>
			array (
				'id' => 3973,
				'name' => 'Concord',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			473 =>
			array (
				'id' => 3974,
				'name' => 'Evansville',
				'state_code' => 'IN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			474 =>
			array (
				'id' => 3975,
				'name' => 'Hartford',
				'state_code' => 'CT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			475 =>
			array (
				'id' => 3976,
				'name' => 'Fayetteville',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			476 =>
			array (
				'id' => 3977,
				'name' => 'Cedar Rapids',
				'state_code' => 'IA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			477 =>
			array (
				'id' => 3978,
				'name' => 'Elizabeth',
				'state_code' => 'NJ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			478 =>
			array (
				'id' => 3979,
				'name' => 'Lansing',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			479 =>
			array (
				'id' => 3980,
				'name' => 'Lancaster',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			480 =>
			array (
				'id' => 3981,
				'name' => 'Fort Collins',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			481 =>
			array (
				'id' => 3982,
				'name' => 'Coral Springs',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			482 =>
			array (
				'id' => 3983,
				'name' => 'Stamford',
				'state_code' => 'CT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			483 =>
			array (
				'id' => 3984,
				'name' => 'Thousand Oaks',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			484 =>
			array (
				'id' => 3985,
				'name' => 'Vallejo',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			485 =>
			array (
				'id' => 3986,
				'name' => 'Palmdale',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			486 =>
			array (
				'id' => 3987,
				'name' => 'Columbia',
				'state_code' => 'SC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			487 =>
			array (
				'id' => 3988,
				'name' => 'El Monte',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			488 =>
			array (
				'id' => 3989,
				'name' => 'Abilene',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			489 =>
			array (
				'id' => 3990,
				'name' => 'North Las Vegas',
				'state_code' => 'NV',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			490 =>
			array (
				'id' => 3991,
				'name' => 'Ann Arbor',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			491 =>
			array (
				'id' => 3992,
				'name' => 'Beaumont',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			492 =>
			array (
				'id' => 3993,
				'name' => 'Waco',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			493 =>
			array (
				'id' => 3994,
				'name' => 'Macon',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			494 =>
			array (
				'id' => 3995,
				'name' => 'Independence',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			495 =>
			array (
				'id' => 3996,
				'name' => 'Peoria',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			496 =>
			array (
				'id' => 3997,
				'name' => 'Inglewood',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			497 =>
			array (
				'id' => 3998,
				'name' => 'Springfield',
				'state_code' => 'MO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			498 =>
			array (
				'id' => 3999,
				'name' => 'Simi Valley',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			499 =>
			array (
				'id' => 4000,
				'name' => 'Lafayette',
				'state_code' => 'LA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		\DB::table('city')->insert(array (
			0 =>
			array (
				'id' => 4001,
				'name' => 'Gilbert',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			1 =>
			array (
				'id' => 4002,
				'name' => 'Carrollton',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			2 =>
			array (
				'id' => 4003,
				'name' => 'Bellevue',
				'state_code' => 'WA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			3 =>
			array (
				'id' => 4004,
				'name' => 'West Valley City',
				'state_code' => 'UT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			4 =>
			array (
				'id' => 4005,
				'name' => 'Clarksville',
				'state_code' => 'TN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			5 =>
			array (
				'id' => 4006,
				'name' => 'Costa Mesa',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			6 =>
			array (
				'id' => 4007,
				'name' => 'Peoria',
				'state_code' => 'AZ',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			7 =>
			array (
				'id' => 4008,
				'name' => 'South Bend',
				'state_code' => 'IN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			8 =>
			array (
				'id' => 4009,
				'name' => 'Downey',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			9 =>
			array (
				'id' => 4010,
				'name' => 'Waterbury',
				'state_code' => 'CT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			10 =>
			array (
				'id' => 4011,
				'name' => 'Manchester',
				'state_code' => 'NH',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			11 =>
			array (
				'id' => 4012,
				'name' => 'Allentown',
				'state_code' => 'PA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			12 =>
			array (
				'id' => 4013,
				'name' => 'McAllen',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			13 =>
			array (
				'id' => 4014,
				'name' => 'Joliet',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			14 =>
			array (
				'id' => 4015,
				'name' => 'Lowell',
				'state_code' => 'MA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			15 =>
			array (
				'id' => 4016,
				'name' => 'Provo',
				'state_code' => 'UT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			16 =>
			array (
				'id' => 4017,
				'name' => 'West Covina',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			17 =>
			array (
				'id' => 4018,
				'name' => 'Wichita Falls',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			18 =>
			array (
				'id' => 4019,
				'name' => 'Erie',
				'state_code' => 'PA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			19 =>
			array (
				'id' => 4020,
				'name' => 'Daly City',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			20 =>
			array (
				'id' => 4021,
				'name' => 'Citrus Heights',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			21 =>
			array (
				'id' => 4022,
				'name' => 'Norwalk',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			22 =>
			array (
				'id' => 4023,
				'name' => 'Gary',
				'state_code' => 'IN',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			23 =>
			array (
				'id' => 4024,
				'name' => 'Berkeley',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			24 =>
			array (
				'id' => 4025,
				'name' => 'Santa Clara',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			25 =>
			array (
				'id' => 4026,
				'name' => 'Green Bay',
				'state_code' => 'WI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			26 =>
			array (
				'id' => 4027,
				'name' => 'Cape Coral',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			27 =>
			array (
				'id' => 4028,
				'name' => 'Arvada',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			28 =>
			array (
				'id' => 4029,
				'name' => 'Pueblo',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			29 =>
			array (
				'id' => 4030,
				'name' => 'Sandy',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			30 =>
			array (
				'id' => 4031,
				'name' => 'Athens-Clarke County',
				'state_code' => 'GA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			31 =>
			array (
				'id' => 4032,
				'name' => 'Cambridge',
				'state_code' => 'MA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			32 =>
			array (
				'id' => 4033,
				'name' => 'Westminster',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			33 =>
			array (
				'id' => 4034,
				'name' => 'San Buenaventura',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			34 =>
			array (
				'id' => 4035,
				'name' => 'Portsmouth',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			35 =>
			array (
				'id' => 4036,
				'name' => 'Livonia',
				'state_code' => 'MI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			36 =>
			array (
				'id' => 4037,
				'name' => 'Burbank',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			37 =>
			array (
				'id' => 4038,
				'name' => 'Clearwater',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			38 =>
			array (
				'id' => 4039,
				'name' => 'Midland',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			39 =>
			array (
				'id' => 4040,
				'name' => 'Davenport',
				'state_code' => 'IA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			40 =>
			array (
				'id' => 4041,
				'name' => 'Mission Viejo',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			41 =>
			array (
				'id' => 4042,
				'name' => 'Miami Beach',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			42 =>
			array (
				'id' => 4043,
				'name' => 'Sunrise Manor',
				'state_code' => 'NV',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			43 =>
			array (
				'id' => 4044,
				'name' => 'New Bedford',
				'state_code' => 'MA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			44 =>
			array (
				'id' => 4045,
				'name' => 'El Cajon',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			45 =>
			array (
				'id' => 4046,
				'name' => 'Norman',
				'state_code' => 'OK',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			46 =>
			array (
				'id' => 4047,
				'name' => 'Richmond',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			47 =>
			array (
				'id' => 4048,
				'name' => 'Albany',
				'state_code' => 'NY',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			48 =>
			array (
				'id' => 4049,
				'name' => 'Brockton',
				'state_code' => 'MA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			49 =>
			array (
				'id' => 4050,
				'name' => 'Roanoke',
				'state_code' => 'VA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			50 =>
			array (
				'id' => 4051,
				'name' => 'Billings',
				'state_code' => 'MT',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			51 =>
			array (
				'id' => 4052,
				'name' => 'Compton',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			52 =>
			array (
				'id' => 4053,
				'name' => 'Gainesville',
				'state_code' => 'FL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			53 =>
			array (
				'id' => 4054,
				'name' => 'Fairfield',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			54 =>
			array (
				'id' => 4055,
				'name' => 'Arden-Arcade',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			55 =>
			array (
				'id' => 4056,
				'name' => 'San Mateo',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			56 =>
			array (
				'id' => 4057,
				'name' => 'Visalia',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			57 =>
			array (
				'id' => 4058,
				'name' => 'Boulder',
				'state_code' => 'CO',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			58 =>
			array (
				'id' => 4059,
				'name' => 'Cary',
				'state_code' => 'NC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			59 =>
			array (
				'id' => 4060,
				'name' => 'Santa Monica',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			60 =>
			array (
				'id' => 4061,
				'name' => 'Fall River',
				'state_code' => 'WI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			61 =>
			array (
				'id' => 4062,
				'name' => 'Kenosha',
				'state_code' => 'WI',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			62 =>
			array (
				'id' => 4063,
				'name' => 'Elgin',
				'state_code' => 'IL',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			63 =>
			array (
				'id' => 4064,
				'name' => 'Odessa',
				'state_code' => 'TX',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			64 =>
			array (
				'id' => 4065,
				'name' => 'Carson',
				'state_code' => 'CA',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			65 =>
			array (
				'id' => 4066,
				'name' => 'Charleston',
				'state_code' => 'SC',
				'country_code' => 'USA',
				'created_at' => $now,
				'updated_at' => $now,
			),
			66 =>
			array (
				'id' => 4067,
				'name' => 'Charlotte Amalie',
				'state_code' => '',
				'country_code' => 'VIR',
				'created_at' => $now,
				'updated_at' => $now,
			),
			67 =>
			array (
				'id' => 4068,
				'name' => 'Harare',
				'state_code' => '',
				'country_code' => 'ZWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			68 =>
			array (
				'id' => 4069,
				'name' => 'Bulawayo',
				'state_code' => '',
				'country_code' => 'ZWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			69 =>
			array (
				'id' => 4070,
				'name' => 'Chitungwiza',
				'state_code' => '',
				'country_code' => 'ZWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			70 =>
			array (
				'id' => 4071,
				'name' => 'Mount Darwin',
				'state_code' => '',
				'country_code' => 'ZWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			71 =>
			array (
				'id' => 4072,
				'name' => 'Mutare',
				'state_code' => '',
				'country_code' => 'ZWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			72 =>
			array (
				'id' => 4073,
				'name' => 'Gweru',
				'state_code' => '',
				'country_code' => 'ZWE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			73 =>
			array (
				'id' => 4074,
				'name' => 'Gaza',
				'state_code' => '',
				'country_code' => 'PSE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			74 =>
			array (
				'id' => 4075,
				'name' => 'Khan Yunis',
				'state_code' => '',
				'country_code' => 'PSE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			75 =>
			array (
				'id' => 4076,
				'name' => 'Hebron',
				'state_code' => '',
				'country_code' => 'PSE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			76 =>
			array (
				'id' => 4077,
				'name' => 'Jabaliya',
				'state_code' => '',
				'country_code' => 'PSE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			77 =>
			array (
				'id' => 4078,
				'name' => 'Nablus',
				'state_code' => '',
				'country_code' => 'PSE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			78 =>
			array (
				'id' => 4079,
				'name' => 'Rafah',
				'state_code' => '',
				'country_code' => 'PSE',
				'created_at' => $now,
				'updated_at' => $now,
			),
			79 =>
			array (
				'id' => 4080,
				'name' => 'Klang Valley',
				'state_code' => 'MY14',
				'country_code' => 'MYS',
				'created_at' => $now,
				'updated_at' => $now,
			),
		));
		
		$cities = DB::table('city')->where('country_code','MYS')->get();
		$id = 1;
		foreach($cities as $city){
			DB::table('city')->where('id',$city->id)->update(['citycountry_id'=>$id]);
			$id++;
		}	
		
		$states = DB::table('state')->where('country_code','MYS')->get();
		
		foreach($states as $state){
			$cities = DB::table('city')->where('state_code',$state->code)->where('country_code','MYS')->get();
			$id = 1;
			foreach($cities as $city){
				DB::table('city')->where('id',$city->id)->update(['citystate_id'=>$id]);
				$id++;
			}
		}		
		
	}
}
