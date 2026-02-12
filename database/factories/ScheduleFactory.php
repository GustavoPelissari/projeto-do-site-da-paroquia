<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        $user = User::query()->inRandomOrder()->first() ?? User::factory()->create();
        $group = Group::query()->inRandomOrder()->first() ?? Group::factory()->create();

        $startDate = $this->faker->dateTimeBetween('-1 week', '+1 week');
        $endDate = (clone $startDate);
        $endDate->modify('+' . $this->faker->numberBetween(1, 14) . ' days');

        $filename = $this->faker->uuid . '.pdf';

        return [
            'group_id' => $group->id,
            'user_id' => $user->id,
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'pdf_path' => 'schedules/' . $filename,
            'pdf_filename' => $filename,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'metadata' => null,
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
