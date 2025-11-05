<?php

namespace Database\Seeders;

use App\Models\Mass;
use Illuminate\Database\Seeder;

class UpdatedMassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masses = [
            // Durante a semana (segunda a sexta) - 06h00 na Matriz
            [
                'name' => 'Missa Diária',
                'day_of_week' => 'monday',
                'time' => '06:00',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa diária da manhã',
            ],
            [
                'name' => 'Missa Diária',
                'day_of_week' => 'tuesday',
                'time' => '06:00',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa diária da manhã',
            ],
            [
                'name' => 'Missa Diária',
                'day_of_week' => 'wednesday',
                'time' => '06:00',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa diária da manhã',
            ],
            [
                'name' => 'Missa Diária',
                'day_of_week' => 'thursday',
                'time' => '06:00',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa diária da manhã',
            ],
            [
                'name' => 'Missa Diária',
                'day_of_week' => 'friday',
                'time' => '06:00',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa diária da manhã',
            ],
            
            // Sábado - 06h00 na Capela Nossa Senhora de Fátima
            [
                'name' => 'Missa de Sábado',
                'day_of_week' => 'saturday',
                'time' => '06:00',
                'location' => 'Capela Nossa Senhora de Fátima',
                'is_active' => true,
                'description' => 'Bairro Primeiro de Maio, Umuarama - PR',
            ],
            
            // Domingo - Várias missas
            [
                'name' => 'Primeira Missa Dominical',
                'day_of_week' => 'sunday',
                'time' => '07:30',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa Dominical',
            ],
            [
                'name' => 'Missa na Capela Santo Antônio',
                'day_of_week' => 'sunday',
                'time' => '08:00',
                'location' => 'Capela Santo Antônio',
                'is_active' => true,
                'description' => 'Missa Dominical',
            ],
            [
                'name' => 'Missa Dominical',
                'day_of_week' => 'sunday',
                'time' => '09:30',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa Dominical',
            ],
            [
                'name' => 'Missa Vespertina',
                'day_of_week' => 'sunday',
                'time' => '18:00',
                'location' => 'Matriz São Paulo Apóstolo',
                'is_active' => true,
                'description' => 'Missa Dominical',
            ],
        ];

        foreach ($masses as $mass) {
            Mass::create($mass);
        }

        $this->command->info('✅ Horários de missas atualizados com sucesso!');
        $this->command->info('   - Segunda a Sexta: 06h00 na Matriz');
        $this->command->info('   - Sábado: 06h00 na Capela N. Sra. de Fátima');
        $this->command->info('   - Domingo: 07h30, 09h30 e 18h00 na Matriz + 08h00 na Capela Santo Antônio');
    }
}
