<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacherId = $this->route('teacher') ?? $this->route('id');

        return [
            'employee_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('teachers', 'employee_id')
                    ->ignore($teacherId),
            ],

            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'gender' => [
                'nullable',
                Rule::in(['male', 'female', 'other']),
            ],

            'date_of_birth' => 'nullable|date',

            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('teachers', 'email')->ignore($teacherId),
            ],

            'phone' => 'nullable|string|max:20',
            'qualification' => 'nullable|string|max:255',
            'specialization' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'status' => 'sometimes|boolean',
        ];
    }
}