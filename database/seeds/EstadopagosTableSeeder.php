<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadopagosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estadopagos')->insert(
            [
                ['nombre' => 'Pagado'],

                ['nombre' => 'Pendiente'],

                ['nombre' => 'Rechazado'],

                ['nombre' => 'Aprobado']
            ]
        );

    }
}
