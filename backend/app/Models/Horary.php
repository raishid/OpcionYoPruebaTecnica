<?php

namespace App\Models;

use App\Casts\TimeCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horary extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'employee_id',
        'start',
        'end',
        'lunch_start',
        'lunch_end',
        'days'
    ];

    protected $casts = [
        'start' => TimeCast::class,
        'end' => TimeCast::class,
        'lunch_start' => TimeCast::class,
        'lunch_end' => TimeCast::class,
        'days' => 'array'
    ];

    public $timestamps = false;
}
