<?php

namespace Modules\Patient\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\Common\Traits\UsesUuid;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Symptom\Entities\Symptom;
use Spatie\Permission\Traits\HasRoles;

class Patient extends Authenticatable
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
        return \Modules\Patient\Database\factories\PatientFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function symptoms(): BelongsToMany
    {
        return $this->belongsToMany(Symptom::class, 'symptom_user', 'user_id', 'symptom_id')
        ->wherePivot('user', 'Patient')
        ->withPivot('created_at', 'description', 'severity')
        ->withTimestamps();
    }
}
