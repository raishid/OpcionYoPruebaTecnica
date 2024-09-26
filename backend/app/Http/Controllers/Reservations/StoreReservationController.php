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

        $dateParsed = Carbon::parse($date, $timezone)->setTimeFromTimeString($time);

        $employee = Employee::find($employeeId);

        $dateTimeZoneEmploye = $dateParsed->setTimezone('UTC');

        $reservation = $employee->reservations()->create([
            'date' => $dateTimeZoneEmploye,
        ]);


        return response()->json($reservation, 201);
    }
}
