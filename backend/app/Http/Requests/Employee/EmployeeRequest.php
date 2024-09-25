<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $requireds = [
            'name'  => 'required|string',
            'last_naem' => 'required|string',
            'phone' => 'required|string',
            'address'   => 'required|string',
            'specialty' => 'required|string',
            'timezone'  => 'required|timezone',
            'hour_start'    => 'required|date_format:H:i',
            'hour_end'  => 'required|date_format:H:i',
            'lunch_start'   => 'required|date_format:H:i',
            'lunch_end' => 'required|date_format:H:i',
            'days'  => 'required|array',
        ];

        if ($this->route()->getName() === 'employee.store') {
            $requireds['email'] = 'required|email|unique:employees,email';
            return $requireds;
        }

        if ($this->route()->getName() === 'employee.update') {
            $requireds['email'] = 'required|email|unique:employees,email,' . $this->employee->id;
            return $requireds;
        }
    }
}
