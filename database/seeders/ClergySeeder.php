<?php

namespace Database\Seeders;

use App\Models\Clergy;
use Illuminate\Database\Seeder;

class ClergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clergy = [
            [
                'name' => 'Pe. Valdenir Pereira dos Santos',
                'role' => 'paroco',
                'photo' => 'images/valdenir-pereira.png',
                'bio' => 'Pároco da Paróquia São Paulo Apóstolo. Nascido em 26/12/1976, foi ordenado sacerdote em 22/04/2006.',
                'email' => null,
                'phone' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pe. Wagner Pereira de Oliveira',
                'role' => 'vigario',
                'photo' => 'images/wagner-pereira.png',
                'bio' => 'Vigário Paroquial da Paróquia São Paulo Apóstolo. Nascido em 29/05/1994, foi ordenado sacerdote em 02/12/2022.',
                'email' => null,
                'phone' => null,
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($clergy as $member) {
            Clergy::create($member);
        }

        $this->command->info('✅ Clero cadastrado com sucesso!');
        $this->command->info('   - Pároco (ordem 1)');
        $this->command->info('   - Vigário Paroquial (ordem 2)');
        $this->command->info('');
        $this->command->info('⚠️  IMPORTANTE: Adicione os nomes reais e fotos através do painel admin.');
    }
}
