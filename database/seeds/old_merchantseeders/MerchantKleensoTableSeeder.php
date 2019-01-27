<?php

use Illuminate\Database\Seeder;

class MerchantKleensoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('merchant')->truncate();
        $now = \Carbon\Carbon::now()->toDateTimeString();
        \DB::table('merchant')->insert(array (
            'id' => 26,
            'description' =>
            "
                <p>
                Kleenso Resource Sdn Bhd is involved in the manufacturing and marketing of total cleaning solution products. We manufacture full rage of cleaning solution products under our house brand Kleenso and also our own Pesso brand of pest repellant products.
                </p>

                <p>
                In additional to our own brands we are also authorised distribution for other trusted brands includings 3M, Dupont and ABC.
                </p>

                <p>
                Our mission to be innovative manufacturer, to market and promote the knowledge of healthy lifestyle in total cleaning solution products rangging from home care, skin care, care care to industrial care.
                </p>

                <p>
                Quality is our commitment, every production batch must go through stability test anad quality control test.
                </p>

                <p>
                All our counterparts and partners must share, practice and embrace the same quality concept as Kleenso's.
                </p>

                <p>
                To continuous upgrade the workforce - regular training is provided in order to increase quality productivity contributors.
                </p>

                <p>
                We are always open to our customers suggestion, ideas and recommendations to meet and fulfill market needs and requirements.
                </p>
            ",
            'history' =>
            "
                <p>
                We manufacture home care products under the brand Kleenso with vision of provide
                extreme towards skin protection, environmental friendliness and specialized cleaning solution.
                </p>

                <p>
                Kleenso promote no harmful chemical, use safe ingredients, preservation and anti toxic reagent to produce and preserve our product quality. All kleenso products are highly biodegrable and enviromentally friendly.
                </p>

                <p>
                Our innovative research and development team and laboratories team work hand in hand to cater to the consumer needs.
                </p>
            ",

        ) );
    }
}
