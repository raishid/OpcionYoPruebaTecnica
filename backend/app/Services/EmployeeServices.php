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
  public function mapAvalaibleHour(Collection $employees)
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

        $parsedTimezone = Carbon::parse($hour->format('H:i'), $employee->time_zone);

        $hours->push($parsedTimezone->format('H:i'));

        $hour->addHour();
      }

      $employee->avalaible_hours = $hours;

      return EmployeAvalaibleResource::make($employee);
    });

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
        $reserve_day = $reservations->whereDate('date', $date);

        $start = Carbon::parse($employee->horary->start);
        $end = Carbon::parse($employee->horary->end);

        $lunch_start = Carbon::parse($employee->horary->lunch_start, 'UTC');
        $lunch_end = Carbon::parse($employee->horary->lunch_end, 'UTC');
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
            $hours->push($_day->toISOString());
          }

          $avalaible_hoursDay->push([
            'date'  => $date->format('Y-m-d'),
            'hours' => $hours
          ]);
        } else {
          foreach ($perioDay as $_day) {
            if ($_day->between($lunch_start, $lunch_end)) {
              continue;
            }

            $hours->push($_day->toISOString());
          }

          $avalaible_hoursDay->push([
            'date'  => $date->format('Y-m-d'),
            'hours' => $hours
          ]);
        }
      }

      $employee->avalable_horaries = $avalaible_hoursDay;

      return EmployeAvalaibleResource::make($employee);
    });

    return $avalaiblesDaysFromInterval;
  }
}
