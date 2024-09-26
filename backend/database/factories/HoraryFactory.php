<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Horary>
 */
class HoraryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $intervals = $this->_randomHoraryInterval();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return [
            'employee_id'   => Employee::factory(),
            'start'         => $intervals['start'],
            'end'           => $intervals['end'],
            'lunch_start'   => $intervals['lunch_start'],
            'lunch_end'     => $intervals['lunch_end'],
            'days'          => $days,
        ];
    }

    private function _randomHoraryInterval()
    {
        $start = rand(8, 10);
        $lunch = rand(12, 14);
        $end = $start + 7;

        return [
            'start' => date("H:i:s", mktime($start, 0, 0, 0, 0, 0)),
            'end' => date("H:i:s", mktime($end, 0, 0, 0, 0, 0)),
            'lunch_start' => date("H:i:s", mktime($lunch, 0, 0, 0, 0, 0)),
            'lunch_end' => date("H:i:s", mktime($lunch + 1, 0, 0, 0, 0, 0)),
        ];
    }
}
