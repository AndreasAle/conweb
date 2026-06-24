<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeamediaPackage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];
}
