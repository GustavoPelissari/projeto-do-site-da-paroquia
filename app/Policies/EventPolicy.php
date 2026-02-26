<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Event $event): bool
    {
        return $event->status === 'published' || $user->canManageContent();
    }

    public function create(User $user): bool
    {
        return $user->canManageContent();
    }

    public function update(User $user, Event $event): bool
    {
        return $user->canManageContent() || 
               ($user->isCoordinator() && $event->group_id === $user->parish_group_id);
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin() || 
               ($user->isCoordinator() && $event->group_id === $user->parish_group_id);
    }

    public function forceDelete(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }
}
