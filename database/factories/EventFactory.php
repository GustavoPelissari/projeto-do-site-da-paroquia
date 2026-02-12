<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-2 weeks', '+2 weeks');
        $end = (clone $start);
        $end->modify('+2 hours');

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'location' => $this->faker->city(),
            'start_date' => $start,
            'end_date' => $end,
            'status' => $this->faker->randomElement(['scheduled', 'cancelled', 'completed']),
            'category' => $this->faker->randomElement(['service', 'meeting', 'celebration', 'training']),
            'max_participants' => $this->faker->optional()->numberBetween(10, 200),
            'requirements' => $this->faker->optional()->sentence(),
            'user_id' => User::factory(),
            'group_id' => Group::factory(),
            'created_by' => User::factory(),
            'scope' => 'parish',
        ];
    }
}
