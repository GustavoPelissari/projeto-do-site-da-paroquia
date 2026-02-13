<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevRoleUsersSeeder extends Seeder
{
    /**
     * Seed de usuários de teste por perfil (idempotente).
     */
    public function run(): void
    {
        $password = 'Teste@1234';

        $users = [
            [
                'name' => 'Padre Teste',
                'email' => 'padre@teste.com',
                'role' => UserRole::ADMIN_GLOBAL->value,
            ],
            [
                'name' => 'Administração Teste',
                'email' => 'admin@teste.com',
                'role' => UserRole::ADMINISTRATIVO->value,
            ],
            [
                'name' => 'Coordenador de Pastoral Teste',
                'email' => 'coordenador@teste.com',
                'role' => UserRole::COORDENADOR_PASTORAL->value,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($password),
                    'role' => $data['role'],
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command?->info('✅ Usuários de teste por perfil criados/atualizados.');
        $this->command?->line('📧 padre@teste.com | admin@teste.com | coordenador@teste.com');
        $this->command?->line('🔐 Senha padrão: Teste@1234');
    }
}
