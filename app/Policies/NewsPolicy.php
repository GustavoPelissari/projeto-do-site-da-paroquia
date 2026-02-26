<?php

namespace App\Policies;

use App\Models\News;
use App\Models\User;

class NewsPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, News $news): bool
    {
        return $news->status === 'published' || $user->canManageContent();
    }

    public function create(User $user): bool
    {
        return $user->canManageContent();
    }

    public function update(User $user, News $news): bool
    {
        return $user->canManageContent() || 
               ($user->isCoordinator() && !$news->is_global);
    }

    public function delete(User $user, News $news): bool
    {
        return $user->isAdmin() || 
               ($user->isCoordinator() && !$news->is_global);
    }

    public function publish(User $user, News $news): bool
    {
        return $user->isAdmin() || $user->isAdministrativo();
    }

    public function forceDelete(User $user, News $news): bool
    {
        return $user->isAdmin();
    }
}
