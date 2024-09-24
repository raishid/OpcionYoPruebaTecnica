<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Services\Helpers;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReserverEmployeeSeed implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Employee $employee, public Carbon $nextMonth)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->employee->reservations()->createMany([
            [
                'date'  => Helpers::getRandomAvailableTime($this->employee, $this->nextMonth),
            ],
            [
                'date'  => Helpers::getRandomAvailableTime($this->employee, $this->nextMonth),
            ],
            [
                'date'  => Helpers::getRandomAvailableTime($this->employee, $this->nextMonth),
            ],
        ]);
    }
}
