<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Services\EmployeeServices;
use App\Http\Controllers\Controller;

class GetEmployeeAvalaibleIntervalTime extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $start_time = Carbon::createFromTimestamp($request->start_time);
        $end_time = Carbon::createFromTimestamp($request->end_time);

        $employees_reservation_interval_date = Employee::whereHas('reservations', function ($query) use ($start_time, $end_time) {
            $query->whereRaw('reservations.date >= ? AND reservations.date <= ?', [$start_time, $end_time]);
        })->get();


        //verify avalaible by day
        $avalaiblesDaysFromInterval = $employees_reservation_interval_date->map(function (Employee $employee) use ($start_time, $end_time) {
            $avalaible_hoursDay = collect();
            while ($start_time->lessThanOrEqualTo($end_time)) {
                $reserve_day = $employee->reservations()->whereDate('date', $start_time);
                if ($reserve_day->count() > 0) {
                    $start = Carbon::parse($employee->horary->start);
                    $end = Carbon::parse($employee->horary->end);
                    $lunch_start = Carbon::parse($employee->horary->lunch_start);
                    $lunch_end = Carbon::parse($employee->horary->lunch_end);
                    $hours = collect();
                    $hour = $start->copy();
                    while ($hour->lessThanOrEqualTo($end)) {
                        if ($hour->between($lunch_start, $lunch_end)) {
                            $hour->addHour();
                            continue;
                        }

                        $hours->push($hour->format('H:i'));

                        $hour->addHour();
                    }

                    $avalaible_hoursDay->push([
                        'date' => $start_time->format('Y-m-d'),
                        'hours' => $hours
                    ]);
                }
            }
            return $avalaible_hoursDay;
        });


        dd($avalaiblesDaysFromInterval);
    }
}
