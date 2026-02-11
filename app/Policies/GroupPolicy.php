<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;

class GroupPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Group $group): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isAdministrativo();
    }

    public function update(User $user, Group $group): bool
    {
        return $user->isAdmin() || 
               ($user->isAdministrativo()) ||
               ($user->isCoordinator() && $user->parish_group_id === $group->id);
    }

    public function delete(User $user, Group $group): bool
    {
        return $user->isAdmin() || $user->isAdministrativo();
    }

    public function manage(User $user, Group $group): bool
    {
        return $user->isAdmin() || 
               ($user->isCoordinator() && $user->parish_group_id === $group->id);
    }

    public function forceDelete(User $user, Group $group): bool
    {
        return $user->isAdmin();
    }
}
