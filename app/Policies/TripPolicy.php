<?php

namespace App\Policies;

use App\Models\Trip;

class TripPolicy
{
    public function before(Trip $actor, string $ability): ?bool
    {
        if ($actor->type === 'super-admin') {
            return true;
        }
        return null;
    }

    public function viewAny(Trip $actor): bool
    {
        return $actor->can('manage-trips');
    }

    public function view(Trip $actor, Trip $target): bool
    {
        return $actor->can('view-trips') && $actor->id === $target->id;
    }

    public function create(Trip $actor): bool
    {
        return $actor->can('create-trips');
    }

    public function update(Trip $actor, Trip $target): bool
    {
        return $actor->can('edit-trips') && $actor->id === $target->id;
    }

    public function delete(Trip $actor, Trip $target): bool
    {
        return $actor->can('delete-trips') && $actor->id === $target->id;
    }
}
