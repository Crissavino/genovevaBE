<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriasTableSeeder::class);
        $this->call(CategoriassecundariasTableSeeder::class);
        $this->call(ColoresTableSeeder::class);
        $this->call(EstadopagosTableSeeder::class);
        $this->call(EstadoenviosTableSeeder::class);
        $this->call(TallesTableSeeder::class);
    }
}
