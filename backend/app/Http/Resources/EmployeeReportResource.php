<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $data = [
            'id' => $this->id,
            'name'  => $this->name,
            'last_name' => $this->last_name,
            'avalaibles' => $this->avalaibles,
            'reservations' => $this->reserves,
        ];
        return $data;
    }
}
