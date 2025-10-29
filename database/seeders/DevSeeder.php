<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;
use App\Models\Mass;
use App\Models\News;
use App\Models\Schedule;
use App\Models\GroupRequest;
use App\Models\Notification;
use Carbon\Carbon;

class DevSeeder extends Seeder
{
    /**
     * Seed the application's database for development.
     */
    public function run(): void
    {
        $this->command->info('🌱 Iniciando criação de dados de teste...');

        // 1. Criar usuários de teste
        $this->createTestUsers();

        // 2. Criar pastorais/grupos (sem as removidas)
        $this->createGroups();

        // 3. Criar horários de missas
        $this->createMasses();

        // 4. Criar notícias
        $this->createNews();

        // 5. Criar escalas PDF de teste
        $this->createSchedules();

        // 6. Criar solicitações de ingresso
        $this->createGroupRequests();

        // 7. Criar notificações
        $this->createNotifications();

        $this->command->info('✅ DevSeeder concluído com sucesso!');
    }

    private function createTestUsers(): void
    {
        $this->command->info('👥 Criando usuários de teste...');

        // Admin Global
        $admin = User::firstOrCreate(
            ['email' => 'admin@paroquia.test'],
            [
                'name' => 'Padre Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin123!'),
                'role' => 'admin_global',
            ]
        );
        $this->command->line("  ✅ Admin: {$admin->email}");

        // Coordenador Coroinhas
        $coordenador = User::firstOrCreate(
            ['email' => 'coord.coroinhas@paroquia.test'],
            [
                'name' => 'Joana Coordenadora',
                'email_verified_at' => now(),
                'password' => Hash::make('Coord123!'),
                'role' => 'coordenador_de_pastoral',
            ]
        );
        $this->command->line("  ✅ Coordenador: {$coordenador->email}");

        // Administrativo
        $administrativo = User::firstOrCreate(
            ['email' => 'administrativo@paroquia.test'],
            [
                'name' => 'Carlos Administrativo',
                'email_verified_at' => now(),
                'password' => Hash::make('Adm123!'),
                'role' => 'administrativo',
            ]
        );
        $this->command->line("  ✅ Administrativo: {$administrativo->email}");

        // Usuário padrão
        $usuario = User::firstOrCreate(
            ['email' => 'maria@paroquia.test'],
            [
                'name' => 'Maria Usuario',
                'email_verified_at' => now(),
                'password' => Hash::make('User123!'),
                'role' => 'usuario_padrao',
            ]
        );
        $this->command->line("  ✅ Usuário padrão: {$usuario->email}");
    }

    private function createGroups(): void
    {
        $this->command->info('🏛️ Criando pastorais e grupos...');

        $coordenador = User::where('email', 'coord.coroinhas@paroquia.test')->first();

        $groups = [
            [
                'name' => 'Coroinhas',
                'description' => 'Grupo de crianças e jovens que auxiliam nas celebrações litúrgicas, aprendendo sobre o serviço ao altar e a participação ativa na missa.',
                'category' => 'liturgy',
                'coordinator_name' => 'Joana Coordenadora',
                'coordinator_phone' => '(11) 99999-1234',
                'coordinator_email' => 'coord.coroinhas@paroquia.test',
                'coordinator_id' => $coordenador->id,
                'meeting_info' => 'Todos os sábados às 14h no salão paroquial',
                'requires_scale' => true,
                'is_active' => true,
            ],
            [
                'name' => 'Vicentinos',
                'description' => 'Sociedade São Vicente de Paulo - dedicada ao serviço dos mais necessitados através de visitas, doações e apoio espiritual.',
                'category' => 'service',
                'coordinator_name' => 'João Vicentino',
                'coordinator_phone' => '(11) 99999-5678',
                'coordinator_email' => 'vicentinos@paroquia.test',
                'meeting_info' => 'Quintas-feiras às 19h30 na casa paroquial',
                'requires_scale' => false,
                'is_active' => true,
            ],
            [
                'name' => 'Ministros Extraordinários',
                'description' => 'Ministros que auxiliam na distribuição da Sagrada Comunhão durante as celebrações eucarísticas.',
                'category' => 'liturgy',
                'coordinator_name' => 'Maria Ministra',
                'coordinator_phone' => '(11) 99999-9012',
                'coordinator_email' => 'ministros@paroquia.test',
                'meeting_info' => 'Primeiro domingo do mês após a missa das 19h',
                'requires_scale' => true,
                'is_active' => true,
            ],
        ];

        foreach ($groups as $groupData) {
            $group = Group::firstOrCreate(
                ['name' => $groupData['name']],
                $groupData
            );
            $this->command->line("  ✅ Grupo: {$group->name}");
        }
    }

    private function createMasses(): void
    {
        $this->command->info('⛪ Criando horários de missas...');

        $masses = [
            [
                'name' => 'Missa Dominical Matutina',
                'day_of_week' => 'sunday',
                'time' => '08:00:00',
                'location' => 'Igreja Matriz',
                'description' => 'Missa dominical para famílias',
                'is_active' => true,
            ],
            [
                'name' => 'Missa Dominical Vespertina',
                'day_of_week' => 'sunday',
                'time' => '19:00:00',
                'location' => 'Igreja Matriz',
                'description' => 'Missa dominical principal',
                'is_active' => true,
            ],
            [
                'name' => 'Missa de Sábado',
                'day_of_week' => 'saturday',
                'time' => '19:00:00',
                'location' => 'Igreja Matriz',
                'description' => 'Missa de sábado à noite',
                'is_active' => true,
            ],
        ];

        foreach ($masses as $massData) {
            $mass = Mass::create($massData);
            $this->command->line("  ✅ Missa criada: {$mass->name} - {$mass->time}");
        }
    }

    private function createNews(): void
    {
        $this->command->info('📰 Criando notícias...');

        $admin = User::where('email', 'admin@paroquia.test')->first();

        $news = News::create([
            'title' => 'Bem-vindos à Paróquia São Paulo Apóstolo',
            'content' => 'Nossa paróquia está de portas abertas para receber você e sua família. Venha participar de nossa comunidade de fé e descobrir como pode contribuir para a construção do Reino de Deus.',
            'excerpt' => 'Conheça nossa paróquia e participe de nossa comunidade de fé.',
            'status' => 'published',
            'published_at' => now(),
            'user_id' => $admin->id,
        ]);

        $this->command->line("  ✅ Notícia criada: {$news->title}");
    }

    private function createSchedules(): void
    {
        $this->command->info('📅 Criando escalas de teste...');

        $coroinhas = Group::where('name', 'Coroinhas')->first();
        $coordenador = User::where('email', 'coord.coroinhas@paroquia.test')->first();

        if ($coroinhas && $coordenador) {
            // Criar diretório de escalas se não existir
            $scalesPath = storage_path('app/public/scales');
            if (!file_exists($scalesPath)) {
                mkdir($scalesPath, 0755, true);
            }

            // Criar um arquivo PDF simples para teste
            $pdfContent = '%PDF-1.4
1 0 obj
<<
/Type /Catalog
/Pages 2 0 R
>>
endobj

2 0 obj
<<
/Type /Pages
/Kids [3 0 R]
/Count 1
>>
endobj

3 0 obj
<<
/Type /Page
/Parent 2 0 R
/MediaBox [0 0 612 792]
/Contents 4 0 R
>>
endobj

4 0 obj
<<
/Length 44
>>
stream
BT
/F1 12 Tf
72 720 Td
(Escala Coroinhas - Dezembro 2025) Tj
ET
endstream
endobj

xref
0 5
0000000000 65535 f 
0000000010 00000 n 
0000000053 00000 n 
0000000125 00000 n 
0000000185 00000 n 
trailer
<<
/Size 5
/Root 1 0 R
>>
startxref
279
%%EOF';

            $fileName = 'escala_coroinhas_dezembro_2025.pdf';
            $filePath = $scalesPath . '/' . $fileName;
            file_put_contents($filePath, $pdfContent);

            $schedule = Schedule::firstOrCreate(
                [
                    'group_id' => $coroinhas->id,
                    'title' => 'Escala Coroinhas - Dezembro 2025'
                ],
                [
                    'user_id' => $coordenador->id,
                    'description' => 'Escala de coroinhas para o mês de dezembro de 2025',
                    'pdf_path' => 'scales/' . $fileName,
                    'pdf_filename' => $fileName,
                    'start_date' => '2025-12-01',
                    'end_date' => '2025-12-31',
                    'is_active' => true,
                ]
            );

            $this->command->line("  ✅ Escala: {$schedule->title}");
        }
    }

    private function createGroupRequests(): void
    {
        $this->command->info('📝 Criando solicitações de ingresso...');

        $maria = User::where('email', 'maria@paroquia.test')->first();
        $coroinhas = Group::where('name', 'Coroinhas')->first();

        if ($maria && $coroinhas) {
            $request = GroupRequest::create([
                'user_id' => $maria->id,
                'group_id' => $coroinhas->id,
                'message' => 'Olá! Tenho interesse em participar do grupo de coroinhas. Tenho 16 anos e gostaria de servir ao altar e aprender mais sobre a liturgia.',
                'status' => 'pending',
            ]);

            $this->command->line("  ✅ Solicitação criada: {$maria->name} para {$coroinhas->name}");
        }
    }

    private function createNotifications(): void
    {
        $this->command->info('🔔 Criando notificações...');

        $coordenador = User::where('email', 'coord.coroinhas@paroquia.test')->first();
        $maria = User::where('email', 'maria@paroquia.test')->first();

        if ($coordenador && $maria) {
            $notification = Notification::create([
                'user_id' => $coordenador->id,
                'title' => 'Nova solicitação de ingresso',
                'message' => "Maria Usuario solicitou ingresso no grupo Coroinhas. Clique para avaliar a solicitação.",
                'type' => 'group_request',
                'read_at' => null,
            ]);

            $this->command->line("  ✅ Notificação criada para: {$coordenador->name}");
        }
    }
}