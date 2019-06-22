<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('talles')->insert(
            [
                ['nombre' => 'UNICO'],

                ['nombre' => 'XXS'],

                ['nombre' => 'XS'],

                ['nombre' => 'S'],

                ['nombre' => 'M'],

                ['nombre' => 'L'],

                ['nombre' => 'XL'],

                ['nombre' => 'XXL']
            ]
        );

    }
}
