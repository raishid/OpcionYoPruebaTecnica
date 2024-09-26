<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Employee;
use Carbon\Carbon;

class StoreEmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmployeeRequest $request)
    {
        $data = $request->validated();

        $employee = Employee::create($data);

        $parsedHour = Carbon::parse($data['hour_start'], $employee->time_zone);
        $parsedHour->setTimezone('UTC');

        $parseEndHour = Carbon::parse($data['hour_end'], $employee->time_zone);
        $parseEndHour->setTimezone('UTC');

        $parseLunchStart = Carbon::parse($data['lunch_start'], $employee->time_zone);
        $parseLunchStart->setTimezone('UTC');

        $parseLunchEnd = Carbon::parse($data['lunch_end'], $employee->time_zone);
        $parseLunchEnd->setTimezone('UTC');

        $employee->horary()->create([
            'start' => $parsedHour,
            'end' => $parseEndHour,
            'lunch_start' => $parseLunchStart,
            'lunch_end' => $parseLunchEnd,
            'days' => $data['days'],
        ]);

        return response()->json($employee);
    }
}
