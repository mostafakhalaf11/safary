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
        return $actor->can('manage-user');
    }

    public function view(User $actor, User $target): bool
    {
        return $actor->id === $target->id;
    }

    public function create(User $actor): bool
    {
        return $actor->can('create-user');
    }

    public function update(User $actor, User $target): bool
    {
        return $actor->can('edit-user') && $actor->id === $target->id;
    }

    public function delete(User $actor, User $target): bool
    {
        return $actor->can('delete-user') && $actor->id === $target->id;
    }
}
