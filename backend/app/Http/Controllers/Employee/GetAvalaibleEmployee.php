<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use App\Services\EmployeeServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\GetAvalaibleEmployeeRequest;

class GetAvalaibleEmployee extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetAvalaibleEmployeeRequest $request)
    {
        $data = $request->validated();
        $time_request = Carbon::createFromTimestamp($data['time_request']);

        $employees = Employee::with('horary')
            ->get()
            ->filter(function ($employee) use ($time_request) {
                return in_array($time_request->format('l'), json_decode($employee->horary->days));
            })->filter(function ($employee) use ($time_request) {
                $hour_request = Carbon::parse($time_request->format('H:i'));
                $hour_request->minute = 0;
                $start = Carbon::parse($employee->horary->start);
                $end = Carbon::parse($employee->horary->end);

                $lunch_start = Carbon::parse($employee->horary->lunch_start);
                $lunch_end = Carbon::parse($employee->horary->lunch_end);
                return $hour_request->between($start, $end) && !$hour_request->between($lunch_start, $lunch_end);
            })->filter(function ($employee) use ($time_request) {
                return $employee->reservations->where('date', $time_request->timestamp)->isEmpty();
            });


        $services = new EmployeeServices;

        $employees = $services->mapAvalaibleHour($employees);

        return response()->json($employees);
    }
}
