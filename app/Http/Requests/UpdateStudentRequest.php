<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $studentId = $this->route('id');

        return [
            'admission_no' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'admission_no')
                    ->ignore($studentId),
            ],

            'roll_no' => 'nullable|string|max:50',

            'first_name' => 'required|string|max:100',

            'middle_name' => 'nullable|string|max:100',

            'last_name' => 'nullable|string|max:100',

            'date_of_birth' => 'nullable|date',

            'gender' => [
                'nullable',
                Rule::in([
                    'male',
                    'female',
                    'other',
                ]),
            ],

            'blood_group' => 'nullable|string|max:10',

            'email' => 'nullable|email|max:150',

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string',

            'city' => 'nullable|string|max:100',

            'state' => 'nullable|string|max:100',

            'pincode' => 'nullable|string|max:10',

            'admission_date' => 'nullable|date',

            'class_id' => [
                'nullable',
                'integer',
                'exists:school_classes,id',
            ],

            'section' => 'nullable|string|max:20',

            'status' => 'sometimes|boolean',
        ];
    }
}