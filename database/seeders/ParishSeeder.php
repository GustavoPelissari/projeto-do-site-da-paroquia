<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Group;
use App\Models\Mass;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ParishSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@paroquia.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin_global',
            'email_verified_at' => now(),
        ]);

        // Create masses - Horários reais da Paróquia São Paulo Apóstolo - Umuarama/PR
        Mass::create([
            'day_of_week' => 'sunday',
            'time' => '08:00',
            'location' => 'Capela Santo Antônio',
            'description' => 'Missa dominical matutina',
        ]);

        Mass::create([
            'day_of_week' => 'sunday',
            'time' => '09:30',
            'location' => 'Igreja Matriz',
            'description' => 'Missa dominical com celebração solene',
        ]);

        Mass::create([
            'day_of_week' => 'sunday',
            'time' => '18:00',
            'location' => 'Igreja Matriz',
            'description' => 'Missa dominical vespertina',
        ]);

        Mass::create([
            'day_of_week' => 'monday',
            'time' => '06:30',
            'location' => 'Igreja Matriz',
            'description' => 'Missa matutina',
        ]);

        Mass::create([
            'day_of_week' => 'tuesday',
            'time' => '06:30',
            'location' => 'Igreja Matriz',
            'description' => 'Missa matutina',
        ]);

        Mass::create([
            'day_of_week' => 'wednesday',
            'time' => '20:00',
            'location' => 'Igreja Matriz',
            'description' => 'Missa vespertina',
        ]);

        Mass::create([
            'day_of_week' => 'thursday',
            'time' => '18:30',
            'location' => 'Igreja Matriz',
            'description' => 'Missa vespertina',
        ]);

        Mass::create([
            'day_of_week' => 'friday',
            'time' => '06:30',
            'location' => 'Igreja Matriz',
            'description' => 'Missa matutina',
        ]);

        Mass::create([
            'day_of_week' => 'saturday',
            'time' => '18:00',
            'location' => 'Capela Nossa Senhora de Fátima',
            'description' => 'Missa vespertina - antecipa Domingo',
        ]);

        Mass::create([
            'day_of_week' => 'saturday',
            'time' => '19:30',
            'location' => 'Igreja Matriz',
            'description' => 'Missa vespertina - antecipa Domingo',
        ]);

        // Create sample groups
        Group::create([
            'name' => 'Coral Paroquial',
            'description' => 'Grupo responsável pela música litúrgica das missas e celebrações especiais.',
            'category' => 'liturgy',
            'coordinator_name' => 'Maria Silva',
            'coordinator_phone' => '(11) 99999-1111',
            'coordinator_email' => 'coral@paroquia.com',
            'meeting_info' => 'Ensaios toda quinta-feira às 20h na sacristia',
        ]);

        Group::create([
            'name' => 'Pastoral da Juventude',
            'description' => 'Grupo voltado para jovens entre 15 e 30 anos, promovendo encontros, retiros e ações sociais.',
            'category' => 'youth',
            'coordinator_name' => 'João Santos',
            'coordinator_phone' => '(11) 99999-2222',
            'coordinator_email' => 'pj@paroquia.com',
            'meeting_info' => 'Encontros aos domingos às 15h no salão paroquial',
        ]);

        Group::create([
            'name' => 'Catequese Infantil',
            'description' => 'Preparação das crianças para receber os sacramentos da Primeira Comunhão.',
            'category' => 'formation',
            'coordinator_name' => 'Ana Costa',
            'coordinator_phone' => '(11) 99999-3333',
            'coordinator_email' => 'catequese@paroquia.com',
            'meeting_info' => 'Aulas aos sábados das 14h às 16h',
        ]);

        Group::create([
            'name' => 'Pastoral da Família',
            'description' => 'Acompanhamento e apoio às famílias da paróquia através de encontros e orientações.',
            'category' => 'family',
            'coordinator_name' => 'Carlos e Lucia Oliveira',
            'coordinator_phone' => '(11) 99999-4444',
            'coordinator_email' => 'familia@paroquia.com',
            'meeting_info' => 'Encontros mensais no primeiro sábado do mês às 19h',
        ]);

        // Create sample news
        News::create([
            'title' => 'Festa de São José - Padroeiro da Paróquia',
            'excerpt' => 'Celebraremos no próximo dia 19 de março a festa do nosso padroeiro São José.',
            'content' => 'A Paróquia São José convida toda a comunidade para a celebração da festa do nosso padroeiro. A programação inclui missas especiais, procissão e festa comunitária. As celebrações começam com a novena a partir do dia 10 de março, sempre às 19h30. No dia 19, teremos missas às 8h, 10h, 15h e 19h, com a procissão saindo às 16h da Praça Central.',
            'status' => 'published',
            'featured' => true,
            'user_id' => $admin->id,
            'published_at' => now(),
        ]);

        News::create([
            'title' => 'Campanha do Agasalho 2024',
            'excerpt' => 'A Pastoral Social está arrecadando roupas e cobertores para distribuição no inverno.',
            'content' => 'Nossa Pastoral Social iniciou a Campanha do Agasalho 2024. Estamos arrecadando roupas em bom estado, cobertores, meias e calçados para distribuir às famílias carentes da nossa comunidade durante o período do inverno. Os donativos podem ser entregues na secretaria paroquial de segunda a sexta, das 8h às 17h, e aos sábados das 8h às 12h.',
            'status' => 'published',
            'featured' => true,
            'user_id' => $admin->id,
            'published_at' => now()->subDays(2),
        ]);

        News::create([
            'title' => 'Retiro de Quaresma - Inscrições Abertas',
            'excerpt' => 'Convite especial para o retiro quaresmal que acontecerá nos dias 15 e 16 de março.',
            'content' => 'Estão abertas as inscrições para o Retiro de Quaresma "Caminhando para a Páscoa". O retiro acontecerá nos dias 15 e 16 de março, das 8h às 17h, no Centro de Retiros Nossa Senhora da Paz. A programação inclui reflexões, momentos de oração, partilha e celebração eucarística. As inscrições podem ser feitas na secretaria paroquial. Investimento: R$ 80,00 (inclui alimentação).',
            'status' => 'published',
            'featured' => false,
            'user_id' => $admin->id,
            'published_at' => now()->subDays(5),
        ]);

        // Create sample events
        Event::create([
            'title' => 'Bingo Beneficente',
            'description' => 'Bingo para arrecadar fundos para a reforma do telhado da igreja. Diversos prêmios e muita diversão garantida!',
            'location' => 'Salão Paroquial',
            'start_date' => now()->addWeeks(2)->setTime(19, 0),
            'end_date' => now()->addWeeks(2)->setTime(22, 0),
            'status' => 'scheduled',
            'max_participants' => 200,
            'requirements' => 'Trazer RG para verificação da idade (maiores de 18 anos)',
            'user_id' => $admin->id,
        ]);

        Event::create([
            'title' => 'Encontro de Casais',
            'description' => 'Encontro mensal para casais da paróquia com reflexões sobre matrimônio e vida familiar.',
            'location' => 'Centro Pastoral',
            'start_date' => now()->addDays(10)->setTime(19, 30),
            'end_date' => now()->addDays(10)->setTime(22, 0),
            'status' => 'scheduled',
            'max_participants' => 30,
            'user_id' => $admin->id,
        ]);

        Event::create([
            'title' => 'Via Sacra Comunitária',
            'description' => 'Via Sacra pelas ruas do bairro durante a Semana Santa.',
            'location' => 'Saída da Igreja Principal',
            'start_date' => now()->addMonth()->setTime(19, 0),
            'end_date' => now()->addMonth()->setTime(21, 0),
            'status' => 'scheduled',
            'user_id' => $admin->id,
        ]);
    }
}
