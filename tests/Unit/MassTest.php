<?php

namespace Tests\Unit;

use App\Models\Mass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes unitários para o modelo Mass.
 */
class MassTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function day_name_accessor_translates_day_of_week(): void
    {
        $mass = Mass::factory()->create(['day_of_week' => 'sunday']);
        $this->assertSame('Domingo', $mass->day_name);

        $mass->update(['day_of_week' => 'wednesday']);
        $this->assertSame('Quarta-feira', $mass->fresh()->day_name);
    }
}