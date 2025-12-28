<?php

namespace App\Policies;

use App\Models\Booking;

class BookingPolicy
{
    public function before(Booking $actor, string $ability): ?bool
    {
        if ($actor->type === 'super-admin') {
            return true;
        }
        return null;
    }

    public function viewAny(Booking $actor): bool
    {
        return $actor->can('manage-bookings');
    }

    public function view(Booking $actor, Booking $target): bool
    {
        return $actor->can('view-bookings') && $actor->id === $target->id;
    }

    public function create(Booking $actor): bool
    {
        return $actor->can('create-bookings');
    }

    public function update(Booking $actor, Booking $target): bool
    {
        return $actor->can('edit-bookings') && $actor->id === $target->id;
    }

    public function delete(Booking $actor, Booking $target): bool
    {
        return $actor->can('delete-bookings') && $actor->id === $target->id;
    }
}
