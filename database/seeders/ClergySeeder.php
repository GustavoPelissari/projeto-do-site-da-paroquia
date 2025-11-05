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
                'name' => 'Pe. [Nome do Pároco]',
                'role' => 'paroco',
                'photo' => null, // Adicionar foto depois
                'bio' => 'Pároco da Paróquia São Paulo Apóstolo',
                'email' => null,
                'phone' => null,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Pe. [Nome do Vigário]',
                'role' => 'vigario',
                'photo' => null, // Adicionar foto depois
                'bio' => 'Vigário Paroquial da Paróquia São Paulo Apóstolo',
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
