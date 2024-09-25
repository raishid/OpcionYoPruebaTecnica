<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use App\Services\EmployeeServices;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\GetEmployeeAvalaibleIntervalTimeRequest;

class GetEmployeeAvalaibleIntervalTime extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetEmployeeAvalaibleIntervalTimeRequest $request)
    {
        $data = $request->validated();
        $start_time = Carbon::createFromTimestamp($data['start_time']);
        $end_time = Carbon::createFromTimestamp($data['end_time']);

        $employees_reservation_interval_date = Employee::all();

        $periods = CarbonPeriod::create($start_time, '1 day', $end_time);

        $service = new EmployeeServices;
        $availables_horary_dates = $service->mapAvalaibleFromInterval($employees_reservation_interval_date, $periods);


        return response()->json($availables_horary_dates);
    }
}
