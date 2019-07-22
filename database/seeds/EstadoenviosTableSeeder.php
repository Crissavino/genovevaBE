<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoenviosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estadoenvios')->insert(
            [
                ['nombre' => 'Por enviar'],

                ['nombre' => 'Enviado'],

                ['nombre' => 'Recibido'],
            ]
        );

    }
}
