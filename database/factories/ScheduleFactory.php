<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 week', '+1 week');
        $end = (clone $start);
        $end->modify('+2 days');

        return [
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'pdf_path' => 'schedules/dummy.pdf',
            'pdf_filename' => 'dummy.pdf',
            'start_date' => $start,
            'end_date' => $end,
            'metadata' => null,
            'is_active' => true,
        ];
    }
}
