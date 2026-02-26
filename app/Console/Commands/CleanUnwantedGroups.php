<?php

namespace App\Console\Commands;

use App\Models\Group;
use Illuminate\Console\Command;

class CleanUnwantedGroups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parish:clean-unwanted-groups {--force : Force deletion without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove pastorais indesejadas (Coral Paroquial, Ministros Extraordinários da Eucaristia, Pastoral da Família, Pastoral da Juventude)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $unwantedGroups = [
            'Coral Paroquial',
            'Ministros Extraordinários da Eucaristia',
            'Pastoral da Família',
            'Pastoral da Juventude',
        ];

        $this->info('🧹 Procurando pastorais indesejadas para remoção...');

        $groupsToRemove = Group::whereIn('name', $unwantedGroups)->get();

        if ($groupsToRemove->isEmpty()) {
            $this->info('✅ Nenhuma pastoral indesejada encontrada.');

            return Command::SUCCESS;
        }

        $this->info('📋 Pastorais encontradas para remoção:');
        foreach ($groupsToRemove as $group) {
            $this->line("  • {$group->id} - {$group->name}");
        }

        if (! $this->option('force')) {
            if (! $this->confirm('Deseja continuar com a remoção?')) {
                $this->info('❌ Operação cancelada.');

                return Command::FAILURE;
            }
        }

        $this->info('🗑️ Removendo pastorais...');

        $removedCount = 0;
        foreach ($groupsToRemove as $group) {
            try {
                // Soft delete preferencial
                $group->update(['is_active' => false]);
                $group->delete();

                $this->line("  ✅ Removido: {$group->name}");
                $removedCount++;
            } catch (\Exception $e) {
                $this->error("  ❌ Erro ao remover {$group->name}: {$e->getMessage()}");
            }
        }

        $this->info("🎉 Operação concluída! {$removedCount} pastorais removidas.");

        if ($removedCount > 0) {
            $this->warn('💡 Lembre-se de verificar se há rotas ou views específicas para essas pastorais que precisam ser removidas.');
        }

        return Command::SUCCESS;
    }
}
