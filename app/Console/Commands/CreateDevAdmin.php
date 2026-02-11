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
    protected $signature = 'dev:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user for development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Criar usuário admin para desenvolvimento
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@paroquia.com'],
            [
                'name' => 'Padre Administrador',
                'email' => 'admin@paroquia.com',
                'password' => '123456', // Senha simples para desenvolvimento
                'role' => 'admin_global',
                'email_verified_at' => now(),
            ]
        );

        // Criar usuário coordenador dos coroinhas
        $coordenadorUser = User::updateOrCreate(
            ['email' => 'coordenador@paroquia.com'],
            [
                'name' => 'João Silva - Coordenador dos Coroinhas',
                'email' => 'coordenador@paroquia.com',
                'password' => '123456', // Senha simples para desenvolvimento
                'role' => 'coordenador_de_pastoral',
                'email_verified_at' => now(),
            ]
        );

        $this->info('✅ Usuários criados/atualizados!');
        $this->newLine();
        
        $this->info('� ADMIN GLOBAL (Padre):');
        $this->info('�📧 Email: admin@paroquia.com');
        $this->info('🔑 Senha: 123456');
        $this->info('👤 Nome: ' . $adminUser->name);
        $this->info('🏷️ Role: ' . $adminUser->role->value);
        $this->info('🆔 ID: ' . $adminUser->id);
        
        $this->newLine();
        
        $this->info('🟡 COORDENADOR DE PASTORAL:');
        $this->info('📧 Email: coordenador@paroquia.com');
        $this->info('🔑 Senha: 123456');
        $this->info('👤 Nome: ' . $coordenadorUser->name);
        $this->info('🏷️ Role: ' . $coordenadorUser->role->value);
        $this->info('🆔 ID: ' . $coordenadorUser->id);
        
        $this->newLine();
        $this->info('🌐 Acesse: http://localhost:8000/login');
        $this->info('🎯 Dashboard Admin: http://localhost:8000/admin');
        $this->info('⛪ Dashboard Padre: http://localhost:8000/admin/global');
        
        return 0;
    }
}
