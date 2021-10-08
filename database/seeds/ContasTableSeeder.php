<?php

use Illuminate\Database\Seeder;
use App\Conta;

class ContasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Conta::create([
            'nome'      => 'Carlos Ferreira',
            'email'     => 'carlos@especializati.com.br',
            'saldo'  => 100,
        ]);
    }
}