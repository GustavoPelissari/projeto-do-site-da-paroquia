<?php

namespace Database\Factories;

use App\Models\GroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para o modelo GroupRequest.
 *
 * Uma solicitação pertence a um usuário e um grupo e tem um status.
 */
class GroupRequestFactory extends Factory
{
    /**
     * O nome da classe de modelo correspondente.
     *
     * @var string
     */
    protected $model = GroupRequest::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'group_id' => Group::factory(),
            'status' => $this->faker->randomElement([
                GroupRequest::STATUS_PENDING,
                GroupRequest::STATUS_APPROVED,
                GroupRequest::STATUS_REJECTED,
            ]),
            'message' => $this->faker->sentence(),
            'response_message' => null,
            'approved_by' => null,
            'approved_at' => null,
            'rejected_at' => null,
        ];
    }
}