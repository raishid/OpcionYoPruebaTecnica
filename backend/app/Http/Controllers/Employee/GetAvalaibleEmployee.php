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
        $time_request = Carbon::createFromTimestamp($data['time_request'], $data['timezone']);
        $time_request->setTimezone('UTC');

        $employees = Employee::with('horary')
            ->get()
            ->filter(function ($employee) use ($time_request) {
                return in_array($time_request->format('l'), $employee->horary->days);
            });

        $services = new EmployeeServices;

        $employees = $services->mapAvalaibleHour($employees, $time_request);

        return response()->json($employees);
    }
}
