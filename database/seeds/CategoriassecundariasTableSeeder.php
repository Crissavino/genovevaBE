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
                ['nombre' => 'CategoriaSecundaria1'],

                ['nombre' => 'CategoriaSecundaria2'],

                ['nombre' => 'CategoriaSecundaria3'],

                ['nombre' => 'CategoriaSecundaria4'],

                ['nombre' => 'CategoriaSecundaria5'],

                ['nombre' => 'CategoriaSecundaria6'],

                ['nombre' => 'CategoriaSecundaria7'],

                ['nombre' => 'CategoriaSecundaria8'],

                ['nombre' => 'CategoriaSecundaria9'],
            ]
        );

    }
}
