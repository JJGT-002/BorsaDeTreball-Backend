<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalFamily extends Model {

    use HasFactory;

    protected $fillable = [
        'cliteral',
        'vliteral',
        'depcurt',
        'didactico'
    ];
}
