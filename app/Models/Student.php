<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model {

    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'surnames',
        'urlCV',
        'isActivated',
        //'cycle_id'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function cycle(): BelongsToMany {
        return $this->belongsToMany(Cycle::class, 'student_cycles', 'student_id', 'cycle_id')->withPivot('endDate');
    }

    public function jobOffer(): BelongsToMany {
        return $this->belongsToMany(JobOffer::class, 'student_enrolled_offers', 'student_id', 'job_offer_id');
    }
}
