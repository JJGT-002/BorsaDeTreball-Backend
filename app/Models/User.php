<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'address',
        'accept',
        'observations',
        'role',
        'isActivated',
        'isDeleted',
    ];

    protected $hidden = [
        'password',
        'token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'accept' => 'boolean',
        'role' => 'string',
        'isDeleted' => 'boolean',
    ];

    public function student(): BelongsTo {
        return $this->belongsTo(Student::class,'id','user_id');
    }

    public function company(): BelongsTo {
        return $this->belongsTo(Company::class,'id','user_id');
    }

    public function cycles(): BelongsToMany {
        return $this->belongsToMany(Cycle::class, 'responsible_cycles', 'user_id', 'cycle_id');
    }
}
