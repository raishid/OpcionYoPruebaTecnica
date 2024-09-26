<?php

namespace App\Services;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\EmployeAvalaibleResource;
use Carbon\CarbonPeriod;

class EmployeeServices
{
  /*
  @param Collection<int, \App\Models\Employee> $employees
  */
  public function mapAvalaibleHour(Collection $employees, Carbon $time_request)
  {
    $tagetHour = Carbon::parse($time_request->format('H:i'));
    $tagetHour->minute = 0;
    $tagetHour->second = 0;

    $employees = $employees->map(function (Employee $employee) use ($tagetHour, $time_request) {
      $start = Carbon::parse($employee->horary->start);
      $end = Carbon::parse($employee->horary->end);
      $lunch_start = Carbon::parse($employee->horary->lunch_start);
      $lunch_end = Carbon::parse($employee->horary->lunch_end);

      if ($tagetHour->between($start, $end) && !$tagetHour->between($lunch_start, $lunch_end) && $employee->reservations()->where('date', $tagetHour->format('Y-m-d H:i:s'))->get()->isEmpty()) {
        $employee->avalable_horaries = $tagetHour->toAtomString();
        return EmployeAvalaibleResource::make($employee);
      }
    });

    $employees = array_values(array_filter($employees->toArray()));

    return $employees;
  }

  /*
  @param Collection<int, \App\Models\Employee> $employees
  */

  public function mapAvalaibleFromInterval(Collection $employees_reservation_interval_date, CarbonPeriod $periods)
  {

    $avalaiblesDaysFromInterval = $employees_reservation_interval_date->map(function (Employee $employee) use ($periods) {
      $avalaible_hoursDay = collect();
      $reservations = $employee->reservations()->whereBetween('date', [$periods->getStartDate(), $periods->getEndDate()->endOfDay()]);

      foreach ($periods as $date) {

        if (!in_array($date->format('l'), $employee->horary->days)) {
          continue;
        }

        $reserve_day = $reservations->whereDate('date', $date);

        $start = Carbon::parse($employee->horary->start);
        $end = Carbon::parse($employee->horary->end);

        $lunch_start = Carbon::parse($employee->horary->lunch_start);
        $lunch_end = Carbon::parse($employee->horary->lunch_end);
        $hours = collect();

        $perioDay = CarbonPeriod::create($start, '1 hour', $end);

        if ($reserve_day->count() > 0) {

          foreach ($perioDay as $_day) {
            if ($_day->between($lunch_start, $lunch_end)) {
              continue;
            }

            if (
              $employee->reservations()
              ->whereDate('date', $date)
              ->whereTime('date', $_day->format('H:i:s'))
              ->count() > 0
            ) {
              continue;
            }
            $_day->setDate($date->year, $date->month, $date->day);
            $hours->push($_day->toAtomString());
          }

          $avalaible_hoursDay->push($hours);
        } else {
          foreach ($perioDay as $_day) {
            if ($_day->between($lunch_start, $lunch_end)) {
              continue;
            }

            $_day->setDate($date->year, $date->month, $date->day);
            $hours->push($_day->toAtomString());
          }

          $avalaible_hoursDay->push($hours);
        }
      }

      $employee->avalable_horaries = $avalaible_hoursDay;

      return EmployeAvalaibleResource::make($employee);
    });

    return $avalaiblesDaysFromInterval;
  }
}
