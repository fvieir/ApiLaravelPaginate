<?php

use Illuminate\Database\Seeder;
use App\Veiculo;

class VeiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Veiculo::class, 10)->create();// Criar 10 registros
    }
}
