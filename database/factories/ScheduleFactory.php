<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * Factory para o modelo Schedule.
 *
 * Cria escalas com datas de início e fim, título, descrição e PDF falso.
 * Os arquivos PDF não são gerados de fato; em um ambiente de testes, isso
 * normalmente não é necessário. Ajuste o caminho se precisar testar upload.
 */
class ScheduleFactory extends Factory
{
    /**
     * O nome da classe de modelo correspondente.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        $start = Carbon::now()->addDays($this->faker->numberBetween(-3, 3))->toDateString();
        $end = Carbon::parse($start)->addDays($this->faker->numberBetween(1, 5))->toDateString();

        return [
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'pdf_path' => null,
            'pdf_filename' => 'dummy.pdf',
            'start_date' => $start,
            'end_date' => $end,
            'metadata' => null,
            'is_active' => true,
        ];
    }
}