<?php

namespace App\Http\Controllers\Reservations;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StoreReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $date = $request->input('date');
        $time = $request->input('time');
        $employeeId = $request->input('employee_id');
        $timezone = $request->input('timezone');

        $time = Carbon::parse($time);

        $dateParsed = Carbon::parse($date, $timezone)->setHour($time->hour)->setMinute($time->minute);

        $employee = Employee::find($employeeId);

        $reservation = $employee->reservations()->create([
            'date' => $dateParsed,
        ]);


        return response()->json($reservation, 201);
    }
}
