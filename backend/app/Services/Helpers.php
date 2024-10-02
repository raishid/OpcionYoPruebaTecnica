<?php

namespace App\Services;

use App\Models\Employee;
use Carbon\Carbon;

class Helpers
{

  public static function getRandomAvailableTime(Employee $employee, Carbon $date)
  {
    $start = Carbon::parse($employee->horary->start, $date->timezone);
    $end = Carbon::parse($employee->horary->end, $date->timezone);
    $lunchStart = Carbon::parse($employee->horary->lunch_start, $date->timezone);
    $lunchEnd = Carbon::parse($employee->horary->lunch_end, $date->timezone);
    $days = $employee->horary->days;

    do {
      $randomTime = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp), $date->timezone);
      $randomTime->minute = 0;
      $randomTime->second = 0;
      $nameDay = $randomTime->format('l');
      $newTime = $randomTime->setDate($date->year, $date->month, $date->day);

      if (!in_array($nameDay, $days)) {
        continue;
      }
    } while (!isset($newTime) || (($randomTime->between($lunchStart, $lunchEnd) || $randomTime->isWeekend()) && !self::verifyAvalaibleTime($employee, $newTime)));

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
