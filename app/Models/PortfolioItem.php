<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    protected $guarded = [];
    protected $casts = ['tags' => 'array', 'is_active' => 'boolean'];
}
