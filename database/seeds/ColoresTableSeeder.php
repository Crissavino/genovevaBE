<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colores')->insert(
            [
                ['nombre' => 'Red'],

                ['nombre' => 'Orange'],

                ['nombre' => 'Yellow'],

                ['nombre' => 'Green'],

                ['nombre' => 'Blue'],

                ['nombre' => 'Purple'],

                ['nombre' => 'Brown'],

                ['nombre' => 'Magenta'],

                ['nombre' => 'Tan'],

                ['nombre' => 'Cyan'],

                ['nombre' => 'Olive'],

                ['nombre' => 'Maroon'],

                ['nombre' => 'Navy'],

                ['nombre' => 'Aquamarine'],

                ['nombre' => 'Turquoise'],

                ['nombre' => 'Silver'],

                ['nombre' => 'Lime'],

                ['nombre' => 'Teal'],

                ['nombre' => 'Indigo'],

                ['nombre' => 'Violet'],

                ['nombre' => 'Pink'],

                ['nombre' => 'Black'],

                ['nombre' => 'White'],

                ['nombre' => 'Grey']

            ]
        );

    }
}
