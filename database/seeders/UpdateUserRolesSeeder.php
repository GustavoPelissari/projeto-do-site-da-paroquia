<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Atualizar usuários existentes com novos papéis

        // Usuários admin -> admin_global
        User::where('role', 'admin')->update([
            'role' => UserRole::ADMIN_GLOBAL->value,
        ]);

        // Usuários moderator -> administrativo
        User::where('role', 'moderator')->update([
            'role' => UserRole::ADMINISTRATIVO->value,
        ]);

        // Usuários member -> usuario_padrao
        User::where('role', 'member')->update([
            'role' => UserRole::USUARIO_PADRAO->value,
        ]);

        // Criar alguns grupos de exemplo com requires_scale
        $groupsData = [
            [
                'name' => 'Coroinhas',
                'description' => 'Jovens que auxiliam nas celebrações litúrgicas',
                'category' => 'liturgy',
                'requires_scale' => true,
                'coordinator_name' => 'Padre João',
                'coordinator_email' => 'padre.joao@paroquia.com',
                'coordinator_phone' => '(11) 99999-1234',
                'is_active' => true,
            ],
            [
                'name' => 'Ministros Extraordinários da Comunhão',
                'description' => 'Ministros que auxiliam na distribuição da Eucaristia',
                'category' => 'liturgy',
                'requires_scale' => true,
                'coordinator_name' => 'Maria Santos',
                'coordinator_email' => 'maria.santos@paroquia.com',
                'coordinator_phone' => '(11) 99999-5678',
                'is_active' => true,
            ],
            [
                'name' => 'Sociedade São Vicente de Paulo',
                'description' => 'Grupo de caridade e assistência social',
                'category' => 'service',
                'requires_scale' => false, // Vicentinos não têm escala
                'coordinator_name' => 'José Silva',
                'coordinator_email' => 'jose.silva@paroquia.com',
                'coordinator_phone' => '(11) 99999-9999',
                'is_active' => true,
            ],
            [
                'name' => 'Pastoral da Juventude',
                'description' => 'Atividades e formação para jovens da paróquia',
                'category' => 'youth',
                'requires_scale' => false,
                'coordinator_name' => 'Ana Paula',
                'coordinator_email' => 'ana.paula@paroquia.com',
                'coordinator_phone' => '(11) 99999-4321',
                'is_active' => true,
            ],
        ];

        foreach ($groupsData as $groupData) {
            Group::updateOrCreate(
                ['name' => $groupData['name']],
                $groupData
            );
        }

        // Criar coordenadores de exemplo
        $coordenadorCoroinhas = User::firstOrCreate(
            ['email' => 'coordenador.coroinhas@paroquia.com'],
            [
                'name' => 'Coordenador Coroinhas',
                'role' => UserRole::COORDENADOR_PASTORAL->value,
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ]
        );

        $coordenadorMinistros = User::firstOrCreate(
            ['email' => 'coordenador.ministros@paroquia.com'],
            [
                'name' => 'Coordenador Ministros',
                'role' => UserRole::COORDENADOR_PASTORAL->value,
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ]
        );

        // Associar coordenadores aos grupos
        $grupoCoroinhas = Group::where('name', 'Coroinhas')->first();
        $grupoMinistros = Group::where('name', 'Ministros Extraordinários da Comunhão')->first();

        if ($grupoCoroinhas) {
            $grupoCoroinhas->update(['coordinator_id' => $coordenadorCoroinhas->id]);
            $coordenadorCoroinhas->update(['parish_group_id' => $grupoCoroinhas->id]);
        }

        if ($grupoMinistros) {
            $grupoMinistros->update(['coordinator_id' => $coordenadorMinistros->id]);
            $coordenadorMinistros->update(['parish_group_id' => $grupoMinistros->id]);
        }

        // Criar alguns usuários padrão de exemplo
        $usuariosPadrao = [
            [
                'name' => 'João Membro',
                'email' => 'joao.membro@paroquia.com',
                'role' => UserRole::USUARIO_PADRAO->value,
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Maria Fiel',
                'email' => 'maria.fiel@paroquia.com',
                'role' => UserRole::USUARIO_PADRAO->value,
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($usuariosPadrao as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        $this->command->info('✅ Papéis dos usuários atualizados com sucesso!');
        $this->command->info('✅ Grupos de exemplo criados!');
        $this->command->info('✅ Coordenadores de exemplo criados!');
        $this->command->info('');
        $this->command->info('🔐 Credenciais de teste:');
        $this->command->info('Coordenador Coroinhas: coordenador.coroinhas@paroquia.com / 123456');
        $this->command->info('Coordenador Ministros: coordenador.ministros@paroquia.com / 123456');
        $this->command->info('Usuário Padrão: joao.membro@paroquia.com / 123456');
    }
}
