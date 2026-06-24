<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechCategory extends Model
{
    protected $guarded = [];
    protected $casts = ['pills' => 'array', 'is_active' => 'boolean'];
}
