<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicCalendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'type',
        'color'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];
} 
