<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'codigo' => '70613986JV',
            'dni_ce' => '70613986',
            'nombres' => 'Ángel',
            'apellidos' => 'Justo Vicente',
            'fecha_nacimiento' => '1996-02-17 00:00:00',
            'sexo' => 4,
            'celular' => '950526214',
            'direccion' => 'Jr. José Varallanos #166',
            'email' => 'admin@leanworksac.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'estado' => 1,
            'remember_token' => Str::random(10),
            'created_at' => now(),
        ])->assignRole('Super Admin');
    }
}
