<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\BookingService;
use App\Http\Resources\BookingResource;
use Illuminate\Http\Request;

class BookingController extends BaseController
{
    protected $bookingService;
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    // Customer: create booking
    public function store(Request $request)
    {
        try {
            $booking = $this->bookingService->create($request->user(), $request->all());
            return $this->sendResponse(new BookingResource($booking), 'Booking created.');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 422);
        }
    }

    // Customer: list own bookings
    public function index(Request $request)
    {
        $bookings = $this->bookingService->userBookings($request->user());
        return $this->sendResponse(BookingResource::collection($bookings), 'My bookings.');
    }

    // Admin: list all bookings
    public function all()
    {
        $bookings = $this->bookingService->allBookings();
        return $this->sendResponse(BookingResource::collection($bookings), 'All bookings.');
    }
}