<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

/**
 * Testes unitários para o modelo Schedule.
 */
class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_currently_active_checks_dates_and_active_flag(): void
    {
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $schedule = Schedule::factory()->create([
            'group_id' => $group->id,
            'user_id' => $user->id,
            'start_date' => Carbon::now()->subDay()->toDateString(),
            'end_date' => Carbon::now()->addDay()->toDateString(),
            'is_active' => true,
        ]);
        $this->assertTrue($schedule->isCurrentlyActive());

        // Outside of range
        $schedule->update(['start_date' => Carbon::now()->addDay()->toDateString()]);
        $this->assertFalse($schedule->fresh()->isCurrentlyActive());

        $schedule->update([
            'start_date' => Carbon::now()->subDays(3)->toDateString(),
            'end_date' => Carbon::now()->subDay()->toDateString(),
        ]);
        $this->assertFalse($schedule->fresh()->isCurrentlyActive());

        // Inactive flag
        $schedule->update([
            'start_date' => Carbon::now()->subDay()->toDateString(),
            'end_date' => Carbon::now()->addDay()->toDateString(),
            'is_active' => false,
        ]);
        $this->assertFalse($schedule->fresh()->isCurrentlyActive());
    }
}