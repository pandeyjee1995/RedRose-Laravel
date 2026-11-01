<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentModel extends Model
{
	protected $table = 'students';
    protected $fillable = [
        'admission_no',
        'roll_no',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'admission_date',
        'class_id',
        'section',
        'status',
        'photo',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
        'status' => 'boolean',
    ];

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(
            \App\Models\Api\SchoolClassesModel::class,
            'class_id'
        );
    }

    public function getFullNameAttribute(): string
    {
        return trim(
            $this->first_name . ' ' .
            $this->middle_name . ' ' .
            $this->last_name
        );
    }
}