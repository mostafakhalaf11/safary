<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function before(User $actor, string $ability): ?bool
    {
        if ($actor->type === 'super-admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $actor): bool
    {
        return $actor->can('manage-users');
    }

    public function view(User $actor, User $target): bool
    {
        return $actor->can('view-users') && $actor->id === $target->id;
    }

    public function create(User $actor): bool
    {
        return $actor->can('create-users');
    }

    public function update(User $actor, User $target): bool
    {
        return $actor->can('edit-users') && $actor->id === $target->id;
    }

    public function delete(User $actor, User $target): bool
    {
        return $actor->can('delete-users') && $actor->id === $target->id;
    }
}
