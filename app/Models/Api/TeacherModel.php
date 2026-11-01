<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class TeacherModel extends Model
{
	protected $table = 'teachers';
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'photo',
        'gender',
        'date_of_birth',
        'email',
        'phone',
        'qualification',
        'specialization',
        'joining_date',
        'address',
        'city',
        'state',
        'pincode',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'status' => 'boolean',
    ];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : null;
    }

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
        ])));
    }
}