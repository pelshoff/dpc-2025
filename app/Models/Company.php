<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $primaryKey = 'ulid';
    protected $guarded = [];
    protected $casts = [
        'officers' => 'array',
    ];
}
