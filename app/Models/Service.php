<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'icon',
        'image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Show only active services.
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Display services in admin-defined order.
    public function scopeOrdered($query)
    {
        return $query
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
