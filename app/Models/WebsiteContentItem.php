<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteContentItem extends Model
{
    protected $fillable = [
        'page',
        'content_key',
        'type',
        'value',
        'original_value',
    ];
}
