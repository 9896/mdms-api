<?php

namespace Modules\Doctor\Entities;

use Modules\Common\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Modules\Disease\Entities\Disease;
use Modules\Symptom\Entities\Symptom;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Doctor extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, UsesUuid, HasRoles;

    /**
     * Mass assignable attributes
     * 
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number'
    ];

    /**
     * Attributes that should be hidden
     * 
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Attributes that should be cast to native types
     * 
     * @var array
     */
    protected $casts = [];
    
    protected static function newFactory()
    {
        return \Modules\Doctor\Database\factories\DoctorFactory::new();
    }

    /**
     * This refers to a disease post(s) that has been written by a particular doctor
     * @return HasMany
     */
    public function disease(): HasMany
    {
        return $this->hasMany(Disease::class);
    }

    /**
     * @return BelongsToMany
     */
    public function symptoms(): BelongsToMany
    {
        return $this->belongsToMany(Symptom::class, 'symptom_user', 'user_id', 'symptom_id')
        ->wherePivot('user', 'Doctor')
        ->withPivot('created_at', 'description', 'severity')
        ->withTimestamps();
    }
}
