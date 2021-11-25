<?php

namespace Modules\Symptom\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Classification\Entities\Classification;
use Modules\Category\Entities\Category;
use Modules\Disease\Entities\Disease;
use Modules\Admin\Entities\Admin;
use Modules\Doctor\Entities\Doctor;
use Modules\Patient\Entities\Patient;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Traits\UsesUuid;

class Symptom extends Model
{
    use HasFactory, UsesUuid;
    /**
     * Mass assignable attributes
     * 
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public $timestamps = true;
    
    protected static function newFactory()
    {
        return \Modules\Symptom\Database\factories\SymptomFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function disease(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class);
    }

    /**
     * @return BelongsToMany
     */
    public function diseaseClassification(): BelongsToMany
    {
        return $this->belongsToMany(DiseaseClassification::class);
    }

    /**
     * @return BelongsToMany
     */
    public function diseaseCategory(): BelongsToMany
    {
       return $this->belongsToMany(DiseaseCategory::class);
    }

    /**
     * @return BelongsToMany
     */
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'symptom_user', 'symptom_id', 'user_id');
    }
    
    /**
     * @return BelongsToMany
     */
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'symptom_user', 'symptom_id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class, 'symptom_user', 'symptom_id', 'user_id');
    }


}
