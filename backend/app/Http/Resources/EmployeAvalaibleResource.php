<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeAvalaibleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'fullname' => $this->name . ' ' . $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'speciality' => $this->speciality,
            'time_zone' => $this->time_zone,
            'avalaible_hours' => $this->avalaible_hours,
        ];
    }
}
