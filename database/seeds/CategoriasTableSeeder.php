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
                ['nombre' => 'Categoria1'],

                ['nombre' => 'Categoria2'],

                ['nombre' => 'Categoria3'],

                ['nombre' => 'Categoria4'],

                ['nombre' => 'Categoria5'],

                ['nombre' => 'Categoria6'],

                ['nombre' => 'Categoria7'],

                ['nombre' => 'Categoria8'],

                ['nombre' => 'Categoria9']
            ]
        );
    }
}
