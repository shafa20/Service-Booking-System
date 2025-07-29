<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'service'     => new ServiceResource($this->service),
            'user'        => new UserResource($this->user),
            'booking_date'=> $this->booking_date,
            'created_at'  => $this->created_at,
        ];
    }
}