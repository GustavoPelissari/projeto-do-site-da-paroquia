<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para o modelo Group.
 *
 * Gera grupos com categorias, descrição e coordenador opcional. A lista de
 * categorias segue as opções definidas no modelo.
 */
class GroupFactory extends Factory
{
    /**
     * O nome da classe de modelo correspondente.
     *
     * @var string
     */
    protected $model = Group::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'description' => $this->faker->paragraph(),
            'category' => $this->faker->randomElement(['liturgy', 'pastoral', 'service', 'formation', 'youth', 'family']),
            'coordinator_name' => null,
            'coordinator_phone' => null,
            'coordinator_email' => null,
            'meeting_info' => null,
            'image' => null,
            'is_active' => true,
            'requires_scale' => false,
            'coordinator_id' => null,
        ];
    }
}