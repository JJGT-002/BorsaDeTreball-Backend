<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCycle extends Model {

    use HasFactory;

    protected $fillable = [
        'cycle_id',
        'student_id',
        'endDate',
        'isValid',
    ];
}
