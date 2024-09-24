<?php

namespace App\Jobs;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReservationSeedJob implements ShouldQueue
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
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth);
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(1));
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(2));
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(3));
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(4));
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(5));
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(6));
        ReserverEmployeeSeed::dispatch($this->employee, $this->nextMonth->addDays(7));
    }
}
