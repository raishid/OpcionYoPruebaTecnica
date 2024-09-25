<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Employee;

class StoreEmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmployeeRequest $request)
    {
        $data = $request->validated();

        $employee = Employee::create($data);

        $employee->horary()->create([
            'start' => $data['hour_start'],
            'end' => $data['hour_end'],
            'lunch_start' => $data['lunch_start'],
            'lunch_end' => $data['lunch_end'],
            'days' => $data['days'],
        ]);

        return response()->json($employee);
    }
}
