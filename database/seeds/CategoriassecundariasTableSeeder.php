<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriassecundariasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categoriassecundarias')->insert(
            [
                ['nombre' => 'Remeras'],

                ['nombre' => 'Tops'],

                ['nombre' => 'Camisas'],

                ['nombre' => 'Blusas'],

                ['nombre' => 'Pantalones'],

                ['nombre' => 'Polleras'],

                ['nombre' => 'Shorts'],

                ['nombre' => 'Bodys'],

                ['nombre' => 'Vestidos'],

                ['nombre' => 'Monos'],

                ['nombre' => 'Camperas'],

                ['nombre' => 'Sacos'],

                ['nombre' => 'Accesorios'],

                ['nombre' => 'Sweater']
            ]
        );

    }
}
