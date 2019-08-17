<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert(
            [
                ['nombre' => 'Remeras'],

                ['nombre' => 'Camisas'],

                ['nombre' => 'Pantalones'],

                ['nombre' => 'Polleras'],

                ['nombre' => 'Bodys'],

                ['nombre' => 'Vestidos'],

                ['nombre' => 'Camperas'],

                ['nombre' => 'Accesorios'],
                
                ['nombre' => 'Tops'],
                
                ['nombre' => 'Blusas'],
                
                ['nombre' => 'Monos'],
                
                ['nombre' => 'Musculosas'],

                ['nombre' => 'Shorts'],

                ['nombre' => 'Sacos'],

                ['nombre' => 'Sweaters']
            ]
        );
    }
}
