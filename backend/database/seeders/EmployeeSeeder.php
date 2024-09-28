<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Horary;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Horary::factory(100)->create();
    }
}
