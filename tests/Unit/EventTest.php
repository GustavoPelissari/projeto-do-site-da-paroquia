<?php

namespace Tests\Unit;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

/**
 * Testes unitários para o modelo Event.
 */
class EventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_upcoming_returns_true_if_start_date_in_future(): void
    {
        $event = Event::factory()->create([
            'start_date' => Carbon::now()->addDay(),
        ]);
        $this->assertTrue($event->isUpcoming());

        $event->update(['start_date' => Carbon::now()->subDay()]);
        $this->assertFalse($event->fresh()->isUpcoming());
    }
}