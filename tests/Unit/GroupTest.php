<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes unitários para o modelo Group.
 */
class GroupTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function category_name_accessor_returns_human_readable_value(): void
    {
        $group = Group::factory()->create(['category' => 'liturgy']);
        $this->assertSame('Liturgia', $group->category_name);
    }

    /** @test */
    public function scope_active_returns_only_active_groups(): void
    {
        Group::factory()->create(['is_active' => false]);
        $active = Group::factory()->create(['is_active' => true]);
        $result = Group::active()->get();
        $this->assertCount(1, $result);
        $this->assertTrue($result->first()->is_active);
        $this->assertTrue($result->first()->is($active));
    }

    /** @test */
    public function has_coordinator_and_is_coordinated_by_work_correctly(): void
    {
        $user = User::factory()->create();
        $group = Group::factory()->create(['coordinator_id' => $user->id]);
        $this->assertTrue($group->hasCoordinator());
        $this->assertTrue($group->isCoordinatedBy($user));

        $otherUser = User::factory()->create();
        $this->assertFalse($group->isCoordinatedBy($otherUser));
    }
}