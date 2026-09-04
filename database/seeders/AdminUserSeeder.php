<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'nombre_completo' => 'Fernando Flores',
            'username' => 'fer-2916',
            'email' => 'admin@example.com',
            'password' => bcrypt('@Andrea_2916'), // Cambia 'password' por una contraseña segura
            'is_verified' => 'Verificado', // Marcar como verificado
            'verification_id' => Str::uuid(),
        ]);

        $user->profile()->create([
            'avatar' => null,
            'headline' => 'Sin titulo profesional.',
        ]);

        $user->assignRole('Super Admin');
    }
}
