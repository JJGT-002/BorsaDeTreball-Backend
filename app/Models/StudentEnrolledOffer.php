<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentEnrolledOffer extends Model {

    use HasFactory;

    protected $fillable = [
        'student_id',
        'job_offer_id'
    ];
}
