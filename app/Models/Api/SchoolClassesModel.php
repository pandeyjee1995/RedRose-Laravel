<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Model;

class SchoolClassesModel extends Model
{
    protected $table = 'school_classes';

    protected $fillable = [
        'class_name',
        'class_code',
        'description',
        'created_by',
        'updated_by',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}