<?php

namespace App\Services;

use App\Models\Employee;
use Carbon\Carbon;

class Helpers
{

  public static function getRandomAvailableTime(Employee $employee, Carbon $date)
  {
    $start = Carbon::parse($employee->horary->start);
    $end = Carbon::parse($employee->horary->end);
    $lunchStart = Carbon::parse($employee->horary->lunch_start);
    $lunchEnd = Carbon::parse($employee->horary->lunch_end);
    $days = json_decode($employee->horary->days);

    do {
      $randomTime = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp));
      $randomTime->minute = 0;
      $randomTime->second = 0;
      $nameDay = $randomTime->format('l');

      if (!in_array($nameDay, $days)) {
        continue;
      }

      $newTime = $randomTime->setDate($date->year, $date->month, $date->day);
    } while (($randomTime->between($lunchStart, $lunchEnd) || $randomTime->isWeekend()) && !self::verifyAvalaibleTime($employee, $newTime));

    return $newTime;
  }

  public static function verifyAvalaibleTime(Employee $employee, Carbon $date)
  {
    $existingReservations = $employee->reservations->where('date', $date->timestamp);

    if ($existingReservations) {
      return false;
    }

    return true;
  }
}
