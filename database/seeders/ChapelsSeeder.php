<?php

namespace Database\Seeders;

use App\Models\Chapel;
use Illuminate\Database\Seeder;

class ChapelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chapels = [
            [
                'name' => 'Capela Nossa Senhora de Fátima',
                'address' => 'Rua (a definir)',
                'neighborhood' => 'Primeiro de Maio',
                'city' => 'Umuarama',
                'state' => 'PR',
                'description' => 'Missa aos sábados, às 06h00',
                'is_active' => true,
            ],
            [
                'name' => 'Capela Santo Antônio',
                'address' => 'Endereço a ser definido',
                'neighborhood' => 'A definir',
                'city' => 'Umuarama',
                'state' => 'PR',
                'description' => 'Missa aos domingos, às 08h00',
                'is_active' => true,
            ],
        ];

        foreach ($chapels as $chapel) {
            Chapel::create($chapel);
        }

        $this->command->info('✅ Capelas cadastradas com sucesso!');
        $this->command->info('   - Capela Nossa Senhora de Fátima (Primeiro de Maio)');
        $this->command->info('   - Capela Santo Antônio');
    }
}
