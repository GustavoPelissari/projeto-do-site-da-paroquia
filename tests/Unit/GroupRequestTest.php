<?php

namespace Tests\Unit;

use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes unitários para o modelo GroupRequest.
 */
class GroupRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function status_helpers_identify_state_correctly(): void
    {
        $pending = GroupRequest::factory()->create(['status' => GroupRequest::STATUS_PENDING]);
        $approved = GroupRequest::factory()->create(['status' => GroupRequest::STATUS_APPROVED]);
        $rejected = GroupRequest::factory()->create(['status' => GroupRequest::STATUS_REJECTED]);

        $this->assertTrue($pending->isPending());
        $this->assertFalse($pending->isApproved());
        $this->assertFalse($pending->isRejected());

        $this->assertTrue($approved->isApproved());
        $this->assertFalse($approved->isPending());
        $this->assertFalse($approved->isRejected());

        $this->assertTrue($rejected->isRejected());
        $this->assertFalse($rejected->isApproved());
        $this->assertFalse($rejected->isPending());
    }

    /** @test */
    public function approve_method_updates_status_and_assigns_user_to_group(): void
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $request = GroupRequest::factory()->create([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => GroupRequest::STATUS_PENDING,
        ]);
        $approver = User::factory()->create();

        $request->approve($approver, 'Bem-vindo!');
        $request->refresh();
        $user->refresh();

        $this->assertSame(GroupRequest::STATUS_APPROVED, $request->status);
        $this->assertSame($group->id, $user->parish_group_id);
    }

    /** @test */
    public function reject_method_updates_status_without_assigning_group(): void
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $request = GroupRequest::factory()->create([
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => GroupRequest::STATUS_PENDING,
        ]);
        $rejector = User::factory()->create();

        $request->reject($rejector, 'Desculpe');
        $request->refresh();
        $user->refresh();

        $this->assertSame(GroupRequest::STATUS_REJECTED, $request->status);
        $this->assertNull($user->parish_group_id);
    }
}