<?php

namespace App\Services;

use App\Models\Employee;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\EmployeeReportResource;
use App\Http\Resources\EmployeAvalaibleResource;

class EmployeeServices
{
  /*
  @param Collection<int, \App\Models\Employee> $employees
  */
  public function mapAvalaibleHour(Carbon $time_request)
  {
    $employees_no_reservation = Employee::with('horary')->whereNotExists(function ($query) use ($time_request) {
      $query->select('id')->from('reservations')->whereColumn('reservations.employee_id', 'employees.id')->where('reservations.date', $time_request->format('Y-m-d H:i:s'));
    })->get();


    $employees = $employees_no_reservation->filter(function ($employee) use ($time_request) {
      $hour_request = Carbon::parse($time_request->format('H:i'));
      $hour_start = Carbon::parse($employee->horary->start);
      $hour_end = Carbon::parse($employee->horary->end);
      $lunch_start = Carbon::parse($employee->horary->lunch_start);
      $lunch_end = Carbon::parse($employee->horary->lunch_end);

      if ($hour_request->between($hour_start, $hour_end) && !$hour_request->between($lunch_start, $lunch_end)) {
        $employee->avalaible_hour = $hour_request->format('H:i');
        return true;
      }
    });

    $employees = EmployeAvalaibleResource::collection($employees);

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

  /*
  @param Collection<int, \App\Models\Employee> $employees
  */

  public function mapAvalaibleAndReservations($employee, CarbonPeriod $periods)
  {

    $avalaible = collect();
    $reservers = collect();
    $reservations = $employee->reservations()->whereBetween('date', [$periods->getStartDate(), $periods->getEndDate()->endOfDay()]);
    $reserve_days = $reservations->pluck('date')->map(function ($item) {
      return Carbon::parse($item)->toAtomString();
    });

    foreach ($periods as $date) {

      if (!in_array($date->format('l'), $employee->horary->days)) {
        continue;
      }

      $start = Carbon::parse($employee->horary->start);
      $end = Carbon::parse($employee->horary->end);

      $perioDay = CarbonPeriod::create($start, '1 hour', $end);

      foreach ($perioDay as $_day) {
        $_day->setDate($date->year, $date->month, $date->day);

        $exist = $reserve_days->filter(function ($item) use ($_day) {
          return $item == $_day->toAtomString();
        });

        if ($exist->count() > 0) {
          $reservers->push($_day->toAtomString());
        } else {
          $avalaible->push($_day->toAtomString());
        }
      }
    }

    $employee->avalaibles = $avalaible;
    $employee->reserves = $reservers;

    return EmployeeReportResource::make($employee);
  }
}
