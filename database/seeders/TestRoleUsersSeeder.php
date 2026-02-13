<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestRoleUsersSeeder extends Seeder
{
    /**
     * Cria usuários de teste por perfil (idempotente).
     */
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Padre Teste',
                'email' => 'padre@teste.com',
                'role' => UserRole::ADMIN_GLOBAL->value,
                'descricao' => 'PADRE (Admin Global)',
            ],
            [
                'name' => 'Administracao Teste',
                'email' => 'admin@teste.com',
                'role' => UserRole::ADMINISTRATIVO->value,
                'descricao' => 'ADMINISTRAÇÃO',
            ],
            [
                'name' => 'Coordenador de Pastoral Teste',
                'email' => 'coordenador@teste.com',
                'role' => UserRole::COORDENADOR_PASTORAL->value,
                'descricao' => 'COORDENADOR_DE_PASTORAL',
            ],
        ];

        foreach ($usuarios as $dados) {
            $user = User::updateOrCreate(
                ['email' => $dados['email']],
                [
                    'name' => $dados['name'],
                    'role' => $dados['role'],
                    'email_verified_at' => now(),
                    'password' => Hash::make('Teste@1234'),
                ]
            );

            $this->command?->info("✔ {$dados['descricao']}: {$user->email}");
        }
    }
}
