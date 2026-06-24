<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessStep extends Model
{
    protected $guarded = [];
    protected $casts = ['is_active' => 'boolean'];
}
