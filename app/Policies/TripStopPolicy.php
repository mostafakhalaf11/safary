<?php

namespace App\Policies;

use App\Models\TripStop;

class TripStopPolicy
{
    public function before(TripStop $actor, string $ability): ?bool
    {
        if ($actor->type === 'super-admin') {
            return true;
        }
        return null;
    }

    public function viewAny(TripStop $actor): bool
    {
        return $actor->can('manage-tripStops');
    }

    public function view(TripStop $actor, TripStop $target): bool
    {
        return $actor->can('view-tripStops') && $actor->id === $target->id;
    }

    public function create(TripStop $actor): bool
    {
        return $actor->can('create-tripStops');
    }

    public function update(TripStop $actor, TripStop $target): bool
    {
        return $actor->can('edit-tripStops') && $actor->id === $target->id;
    }

    public function delete(TripStop $actor, TripStop $target): bool
    {
        return $actor->can('delete-tripStops') && $actor->id === $target->id;
    }
}
