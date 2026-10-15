<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'specialization',
        'department',
        'qualification',
        'experience_years',
        'short_description',
        'bio',
        'image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'experience_years' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
