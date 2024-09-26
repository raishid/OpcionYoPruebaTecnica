<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;

class GetEmployeeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Employee $employee)
    {

        return response()->json(EmployeeResource::make($employee));
    }
}
