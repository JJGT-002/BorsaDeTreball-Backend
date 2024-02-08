<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cycle extends Model {

    use HasFactory;

    protected $fillable = [
        'ciclo',
        'departamento',
        'tipo',
        'normativa',
        'titol',
        'rd',
        'rd2',
        'vliteral',
        'cliteral',
        'horasFct',
        'acronim',
        'llocTreball',
        'dataSignaturaDual',
    ];

    public function professionalFamily(): BelongsTo {
        return $this->belongsTo(Student::class,'departamento','id');
    }

    public function student(): BelongsToMany {
        return $this->belongsToMany(Student::class, 'student_cycles', 'cycle_id', 'student_id');
    }

    public function jobOffer(): BelongsToMany {
        return $this->belongsToMany(JobOffer::class, 'offer_cycles', 'cycle_id', 'job_offer_id');
    }
}
