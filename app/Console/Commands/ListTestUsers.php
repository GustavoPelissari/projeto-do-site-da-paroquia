<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ListTestUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parish:list-test-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista todos os usuários de teste criados para o sistema paroquial';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📋 LISTA DE USUÁRIOS DE TESTE - PARÓQUIA SÃO PAULO APÓSTOLO');
        $this->line('════════════════════════════════════════════════════════════════');

        $testUsers = User::whereIn('email', [
            'padre@teste.com',
            'admin@teste.com',
            'coordenador@teste.com'
        ])->get();

        if ($testUsers->isEmpty()) {
            $this->warn('❌ Nenhum usuário de teste encontrado.');
            $this->info('Execute: php artisan db:seed --class=DevRoleUsersSeeder');
            return Command::FAILURE;
        }

        foreach ($testUsers as $user) {
            $this->line('');
            $this->info("👤 {$user->name}");
            $this->line("   📧 Email: {$user->email}");
            $this->line("   🔐 Senha: " . $this->getPasswordForUser($user->email));
            $this->line("   👑 Papel: " . $this->getRoleDescription($user->role));
            $this->line("   📋 Responsabilidades: " . $this->getResponsibilities($user->role));
            
            if ($user->email_verified_at) {
                $this->line("   ✅ Email verificado");
            } else {
                $this->line("   ⚠️  Email não verificado");
            }
        }

        $this->line('');
        $this->line('════════════════════════════════════════════════════════════════');
        $this->info('🚀 INSTRUÇÕES PARA TESTE:');
        $this->line('');
        $this->line('1. Acesse: http://localhost:8000/login');
        $this->line('2. Use qualquer e-mail e a senha acima para fazer login');
        $this->line('3. Teste diferentes funcionalidades baseadas no papel do usuário');
        $this->line('');
        
        $this->warn('⚠️  IMPORTANTE: Estes usuários são apenas para DESENVOLVIMENTO!');
        $this->warn('   Não use em produção - as senhas são simples e conhecidas.');

        return Command::SUCCESS;
    }

    private function getPasswordForUser($email)
    {
        $passwords = [
            'padre@teste.com' => 'Teste@1234',
            'admin@teste.com' => 'Teste@1234',
            'coordenador@teste.com' => 'Teste@1234',
        ];

        return $passwords[$email] ?? 'N/A';
    }

    private function getRoleDescription($role)
    {
        if ($role instanceof \App\Enums\UserRole) {
            return $role->label();
        }

        $roles = [
            'admin_global' => 'Administrador Global',
            'coordenador_de_pastoral' => 'Coordenador de Pastoral',
            'administrativo' => 'Administrativo',
            'usuario_padrao' => 'Usuário Padrão',
        ];

        return $roles[$role] ?? $role;
    }

    private function getResponsibilities($role)
    {
        $roleValue = $role instanceof \App\Enums\UserRole ? $role->value : $role;
        
        $responsibilities = [
            'admin_global' => 'Gerenciamento total (usuários, pastorais, escalas, publicações)',
            'coordenador_de_pastoral' => 'Gerir coroinhas, escalas e solicitações de entrada',
            'administrativo' => 'Editar horários de missas e conteúdos operacionais',
            'usuario_padrao' => 'Comentar, solicitar entrada em pastorais',
        ];

        return $responsibilities[$roleValue] ?? 'Não definidas';
    }
}
