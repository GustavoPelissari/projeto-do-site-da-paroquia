<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+3 months');
        $endDate = (clone $startDate);
        $endDate->modify('+' . $this->faker->numberBetween(1, 8) . ' hours');

        $user = User::query()->inRandomOrder()->first() ?? User::factory()->create();

        $group = null;
        if ($this->faker->boolean(35)) {
            $group = Group::query()->inRandomOrder()->first() ?? Group::factory()->create();
        }

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(2, true),
            'location' => $this->faker->city,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement(['scheduled', 'cancelled', 'completed']),
            'category' => $this->faker->randomElement(['service', 'celebration', 'meeting', 'formation', 'other']),
            'max_participants' => $this->faker->boolean(40) ? $this->faker->numberBetween(10, 200) : null,
            'requirements' => $this->faker->boolean(35) ? $this->faker->sentence() : null,
            'user_id' => $user->id,
            'group_id' => $group?->id,
            'created_by' => $this->faker->boolean(70) ? $user->id : null,
        ];
    }
}
