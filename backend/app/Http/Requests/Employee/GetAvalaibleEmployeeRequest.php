<?php

namespace App\Http\Requests\Employee;

use App\Rules\Timestamp;
use Illuminate\Foundation\Http\FormRequest;

class GetAvalaibleEmployeeRequest extends FormRequest
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
        return [
            'time_request'  => ['required', new Timestamp],
            'timezone'      => ['required', 'timezone'],
        ];
    }
}
