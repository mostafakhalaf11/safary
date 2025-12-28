<?php

namespace App\Policies;

use App\Models\Delivery;

class DeliveryPolicy
{
    public function before(Delivery $actor, string $ability): ?bool
    {
        if ($actor->type === 'super-admin') {
            return true;
        }
        return null;
    }

    public function viewAny(Delivery $actor): bool
    {
        return $actor->can('manage-deliveries');
    }

    public function view(Delivery $actor, Delivery $target): bool
    {
        return $actor->can('view-deliveries') && $actor->id === $target->id;
    }

    public function create(Delivery $actor): bool
    {
        return $actor->can('create-deliveries');
    }

    public function update(Delivery $actor, Delivery $target): bool
    {
        return $actor->can('edit-deliveries') && $actor->id === $target->id;
    }

    public function delete(Delivery $actor, Delivery $target): bool
    {
        return $actor->can('delete-deliveries') && $actor->id === $target->id;
    }
}
