<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Services\Helpers;
use Illuminate\Database\Seeder;
use App\Jobs\ReservationSeedJob;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();

        $nextMonth = now()->addMonth()->firstOfMonth();

        $employees->each(function ($employee) use ($nextMonth) {
            ReservationSeedJob::dispatch($employee, $nextMonth);
        });

        $twoMonth = now()->addMonths(2)->firstOfMonth();

        $employees->each(function ($employee) use ($twoMonth) {
            ReservationSeedJob::dispatch($employee, $twoMonth);
        });
    }
}
