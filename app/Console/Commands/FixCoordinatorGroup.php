<?php

namespace App\Console\Commands;

use App\Models\Group;
use App\Models\User;
use Illuminate\Console\Command;

class FixCoordinatorGroup extends Command
{
    protected $signature = 'fix:coordinator-group';

    protected $description = 'Fix coordinator group association';

    public function handle()
    {
        $this->info('Verificando coordenador...');

        $coordinator = User::where('email', 'coord.coroinhas@paroquia.test')->first();

        if (! $coordinator) {
            $this->error('Coordenador não encontrado!');

            return;
        }

        $this->info("Coordenador encontrado: {$coordinator->name}");
        $this->info('Parish Group ID atual: '.($coordinator->parish_group_id ?? 'NULL'));

        // Buscar grupo dos Coroinhas
        $coroinharsGroup = Group::where('name', 'like', '%Coroinhas%')->first();

        if (! $coroinharsGroup) {
            $this->error('Grupo dos Coroinhas não encontrado!');
            $this->info('Grupos disponíveis:');
            Group::all()->each(function ($group) {
                $this->line("ID: {$group->id} - Nome: {$group->name}");
            });

            return;
        }

        $this->info("Grupo encontrado: {$coroinharsGroup->name} (ID: {$coroinharsGroup->id})");

        // Associar coordenador ao grupo
        $coordinator->parish_group_id = $coroinharsGroup->id;
        $coordinator->save();

        $this->info('✅ Coordenador associado ao grupo com sucesso!');
        $this->info("Coordenador: {$coordinator->name}");
        $this->info("Grupo: {$coroinharsGroup->name}");
    }
}
