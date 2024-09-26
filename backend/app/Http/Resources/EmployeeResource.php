<?php

namespace App\Http\Resources;

use App\Models\Horary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'speciality' => $this->speciality,
            'time_zone' => $this->time_zone,
            'horaries' => HoraryResource::make($this->horary),
        ];
    }
}
