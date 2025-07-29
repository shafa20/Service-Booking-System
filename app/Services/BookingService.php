<?php
namespace App\Services;

use App\Models\Booking;
use App\Models\Service;

class BookingService
{
    public function create($user, $data)
    {
        // Prevent booking in the past
        if (strtotime($data['booking_date']) < strtotime(date('Y-m-d'))) {
            throw new \Exception('Cannot book for a past date.');
        }
        return Booking::create([
            'user_id'      => $user->id,
            'service_id'   => $data['service_id'],
            'booking_date' => $data['booking_date'],
        ]);
    }

    public function userBookings($user)
    {
        return Booking::with('service')->where('user_id', $user->id)->get();
    }

    public function allBookings()
    {
        return Booking::with(['service', 'user'])->get();
    }
}