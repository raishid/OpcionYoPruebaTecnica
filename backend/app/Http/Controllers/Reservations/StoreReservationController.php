<?php

namespace App\Http\Controllers\Reservations;

use Carbon\Carbon;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reservations\StoreReservationRequest;

class StoreReservationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreReservationRequest $request)
    {
        $data = $request->validated();
        $date = $data['date'];
        $time = $data['time'];
        $employeeId = $data['employee_id'];
        $timezone = $data['timezone'];

        $time = Carbon::parse($time);

        $dateParsed = Carbon::parse($date, $timezone)->setHour($time->hour)->setMinute($time->minute);

        $employee = Employee::find($employeeId);

        $reservation = $employee->reservations()->create([
            'date' => $dateParsed,
        ]);


        return response()->json($reservation, 201);
    }
}
