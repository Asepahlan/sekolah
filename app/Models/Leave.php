<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'approved_by',
        'start_date',
        'end_date',
        'type',
        'reason',
        'attachment',
        'status',
        'notes'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getDurationAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }
} 
