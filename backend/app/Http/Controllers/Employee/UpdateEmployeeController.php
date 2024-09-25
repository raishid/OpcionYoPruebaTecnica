<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Employee;

class UpdateEmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        $employee->update($data);

        $employee->horary()->update([
            'start' => $data['hour_start'],
            'end' => $data['hour_end'],
            'lunch_start' => $data['lunch_start'],
            'lunch_end' => $data['lunch_end'],
            'days' => $data['days'],
        ]);

        return response()->json($employee);
    }
}
