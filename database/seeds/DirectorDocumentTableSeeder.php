<?php

use Illuminate\Database\Seeder;

class DirectorDocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        \DB::table('directordocument')->truncate();

        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('directordocument')->insert(array (
            0 => array (
                'director_id' => '1',
                'document_id' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ),
        ));
    }
}