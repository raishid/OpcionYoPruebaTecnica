<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use App\Services\EmployeeServices;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeAvalaibleResource;
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
        $time_request->setMinute(0);
        $time_request->setSecond(0);
        $time_request->setMicro(0);


        $employeeServices = new EmployeeServices;
        $employees = $employeeServices->mapAvalaibleHour($time_request);

        return response()->json($employees);
    }
}
