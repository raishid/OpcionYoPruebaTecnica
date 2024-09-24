<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory, HasUuids;


    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'department',
        'position',
        'salary',
        'status',
    ];

    public function horary()
    {
        return $this->hasOne(Horary::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
