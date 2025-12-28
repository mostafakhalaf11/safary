<?php

namespace App\Policies;

use App\Models\Driver;

class DriverPolicy
{
    public function before(Driver $actor, string $ability): ?bool
    {
        if ($actor->type === 'super-admin') {
            return true;
        }
        return null;
    }

    public function viewAny(Driver $actor): bool
    {
        return $actor->can('manage-drivers');
    }

    public function view(Driver $actor, Driver $target): bool
    {
        return $actor->can('view-drivers') && $actor->id === $target->id;
    }

    public function create(Driver $actor): bool
    {
        return $actor->can('create-drivers');
    }

    public function update(Driver $actor, Driver $target): bool
    {
        return $actor->can('edit-drivers') && $actor->id === $target->id;
    }

    public function delete(Driver $actor, Driver $target): bool
    {
        return $actor->can('delete-drivers') && $actor->id === $target->id;
    }
}
