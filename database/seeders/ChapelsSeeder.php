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
                'address' => 'R. Alfredo Bernardo, 4808-4860 - Umuarama, PR, 87509-190',
                'neighborhood' => 'Primeiro de Maio',
                'city' => 'Umuarama',
                'state' => 'PR',
                'description' => 'Missa aos sábados, às 18h00',
                'image' => 'images/Capela Nossa Senhora de Fatima.png',
                'map_link' => 'https://maps.app.goo.gl/vKJM51mUMWB19T5j8',
                'is_active' => true,
            ],
            [
                'name' => 'Capela Santo Antônio',
                'address' => 'R. Santa Madalena - Jardim Shangrila, Umuarama - PR, 87509-090',
                'neighborhood' => 'Jardim Shangrila',
                'city' => 'Umuarama',
                'state' => 'PR',
                'description' => 'Missa aos domingos, às 08h00',
                'image' => 'images/capela-santo-antonio.png',
                'map_link' => 'https://maps.app.goo.gl/TJ2TWHbRfUEvW37C9',
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
