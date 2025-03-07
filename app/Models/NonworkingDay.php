<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonworkingDay extends Model
{
    use HasFactory;

    protected $table = 'nonworking_days';

    protected $fillable = ['date', 'reason'];
}
