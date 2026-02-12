<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Factory para o modelo Event.
 *
 * Os eventos possuem data e horário de início/fim, título, descrição e localização.
 * Esta fábrica gera dados coerentes para testes, utilizando datas futuras e
 * categorias e status genéricos. Ajuste conforme surgirem novos campos.
 */
class EventFactory extends Factory
{
    /**
     * O nome da classe de modelo correspondente.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        $start = Carbon::now()->addDays($this->faker->numberBetween(1, 10))->setTime($this->faker->numberBetween(8, 20), 0);
        $end = (clone $start)->addHours($this->faker->numberBetween(1, 4));

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'start_date' => $start,
            'end_date' => $end,
            'status' => 'scheduled',
            'category' => $this->faker->randomElement(['pastoral', 'liturgy', 'formation', 'service', 'youth', 'family']),
            'max_participants' => null,
            'requirements' => null,
            // Relacionamentos opcionais: usuário criador ou grupo
            'user_id' => User::factory(),
            'group_id' => null,
            'created_by' => null,
            'scope' => null,
        ];
    }
}