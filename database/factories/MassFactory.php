<?php

namespace Database\Factories;

use App\Models\Mass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * Factory para o modelo Mass.
 *
 * Cria missas com dia da semana e horário. Usa os dias em inglês minúsculo
 * conforme o modelo espera (sunday, monday, ...). A hora é definida como uma
 * instância de Carbon.
 */
class MassFactory extends Factory
{
    /**
     * O nome da classe de modelo correspondente.
     *
     * @var string
     */
    protected $model = Mass::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        $day = $this->faker->randomElement(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
        $time = Carbon::createFromTime($this->faker->numberBetween(6, 20), 0, 0);

        return [
            'name' => 'Missa',
            'day_of_week' => $day,
            'time' => $time->format('H:i'),
            'location' => 'Igreja Matriz',
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}