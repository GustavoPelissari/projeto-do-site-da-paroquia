<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateDevAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:create-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar usuários de teste por perfil para desenvolvimento';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $password = 'Teste@1234';

        $users = [
            [
                'email' => 'padre@teste.com',
                'name' => 'Padre Teste',
                'role' => 'admin_global',
                'rotulo' => 'PADRE (ADMINISTRADOR GLOBAL)',
            ],
            [
                'email' => 'admin@teste.com',
                'name' => 'Administração Teste',
                'role' => 'administrativo',
                'rotulo' => 'ADMINISTRAÇÃO',
            ],
            [
                'email' => 'coordenador@teste.com',
                'name' => 'Coordenador de Pastoral Teste',
                'role' => 'coordenador_de_pastoral',
                'rotulo' => 'COORDENADOR DE PASTORAL',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $password,
                    'role' => $data['role'],
                    'email_verified_at' => now(),
                ]
            );

            $this->info("✅ {$data['rotulo']}: {$user->email}");
        }

        $this->newLine();
        $this->info('🔐 Senha padrão para todos: Teste@1234');
        $this->info('🌐 Login: http://localhost:8000/login');

        return self::SUCCESS;
    }
}
