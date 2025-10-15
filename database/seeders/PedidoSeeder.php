<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Pedido;


class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $client = User::where('email', 'test@example.com')->first();

        $pizzas = Pizza::all();

        foreach ($pizzas as $pizza) {
            # code...
            $pedido = Pedido::create([
                'user_id' => $client->id,
                'pizza_id' => $pizza->id,
                'fecha_hora_pedido' => now(),
            ]);
        }
    }
}
