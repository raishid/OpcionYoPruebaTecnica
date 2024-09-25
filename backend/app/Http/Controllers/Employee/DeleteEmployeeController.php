<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class DeleteEmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Employee $employee)
    {
        $employee->delete();

        return response()->json(['message' => 'Employee deleted']);
    }
}
