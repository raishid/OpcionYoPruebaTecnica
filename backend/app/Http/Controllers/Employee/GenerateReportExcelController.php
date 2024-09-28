<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use App\Services\EmployeeServices;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\ReportAvalaibleEmployee;
use App\Http\Requests\Employee\GetEmployeeAvalaibleIntervalTimeRequest;

class GenerateReportExcelController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GetEmployeeAvalaibleIntervalTimeRequest $request)
    {
        $data = $request->validated();

        $start_time = Carbon::createFromDate($data['start_time']);
        $end_time = Carbon::createFromDate($data['end_time'])->endOfDay();

        return Excel::download(new ReportAvalaibleEmployee($start_time, $end_time), 'report.xlsx');
    }
}
