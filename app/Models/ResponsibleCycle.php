<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsibleCycle extends Model {

    use HasFactory;

    protected $fillable = [
        'responsible_id',
        'cycle_id',
    ];
}
