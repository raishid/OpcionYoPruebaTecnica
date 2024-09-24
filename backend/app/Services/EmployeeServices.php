<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\EmployeAvalaibleResource;

class EmployeeServices
{
  /*
  @param Collection<int, \App\Models\Employee> $employees
  */
  public function mapEmployeesAvalaibleHour(Collection $employees)
  {
    $employees = $employees->map(function (Employee $employee) {
      $start = Carbon::parse($employee->horary->start);
      $end = Carbon::parse($employee->horary->end);
      $lunch_start = Carbon::parse($employee->horary->lunch_start);
      $lunch_end = Carbon::parse($employee->horary->lunch_end);

      $hours = collect();
      $hour = $start->copy();
      while ($hour->lessThanOrEqualTo($end)) {
        if ($hour->between($lunch_start, $lunch_end)) {
          $hour->addHour();
          continue;
        }

        $hours->push($hour->format('H:i'));

        $hour->addHour();
      }

      $employee->avalaible_hours = $hours;

      return EmployeAvalaibleResource::make($employee);
    });

    return $employees;
  }

  public function mapAvalaibleFromInterval(Collection $employees, Carbon $start_time, Carbon $end_time) {}
}
