<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\GroupRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Testes de feature para GroupRequestController.
 */
class GroupRequestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_group_request_pages(): void
    {
        $response = $this->get('/group-requests/create');
        $response->assertRedirect('/login');

        $response = $this->post('/group-requests', []);
        $response->assertRedirect('/login');

        $response = $this->get('/group-requests');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_cannot_create_request_if_already_in_group(): void
    {
        $user = User::factory()->create([ 'parish_group_id' => Group::factory()->create()->id ]);
        $this->actingAs($user);
        $response = $this->get(route('group-requests.create'));
        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('error');
    }

    /** @test */
    public function user_can_submit_group_request(): void
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('group-requests.store'), [
            'group_id' => $group->id,
            'message' => 'Quero participar',
        ]);
        $response->assertRedirect(route('group-requests.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('group_requests', [
            'user_id' => $user->id,
            'group_id' => $group->id,
            'status' => GroupRequest::STATUS_PENDING,
        ]);
    }
}