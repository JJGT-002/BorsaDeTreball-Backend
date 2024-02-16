<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JobOffer extends Model {

    use HasFactory;

    protected $fillable = [
        'company_id',
        'observations',
        'description',
        'contractDuration',
        'contact',
        'registrationMethod',
        'isActive',
        'isDeleted',
        'isValid',
    ];

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class,'company_id','id');
    }

    public function student(): BelongsToMany {
        return $this->belongsToMany(Student::class, 'student_enrolled_offers', 'job_offer_id', 'student_id');
    }

    public function cycle(): BelongsToMany {
        return $this->belongsToMany(Cycle::class, 'offer_cycles', 'job_offer_id', 'cycle_id');
    }
}
