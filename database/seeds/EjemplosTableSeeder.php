<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class EjemplosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ejemplos')->insert(
            [

                [
                    'title' => 'prueba1',
                    'description' => 'prueba',
                    'user_id' => 'prueba'
                ],

                [
                    'title' => 'prueba2',
                    'description' => 'prueba',
                    'user_id' => 'prueba'
                ],

                [
                    'title' => 'prueba3',
                    'description' => 'prueba',
                    'user_id' => 'prueba'
                ],

                [
                    'title' => 'prueba4',
                    'description' => 'prueba',
                    'user_id' => 'prueba'
                ],

                [
                    'title' => 'prueba5',
                    'description' => 'prueba',
                    'user_id' => 'prueba'
                ]

            ]
        );

    }
}
