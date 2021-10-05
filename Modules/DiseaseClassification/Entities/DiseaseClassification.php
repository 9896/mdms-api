<?php

namespace Modules\DiseaseClassification\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Disease\Entities\Disease;
use Modules\Category\Entities\Category;
use Modules\Symptom\Entities\Symptom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiseaseClassification extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'malady_classifications';
    
    protected static function newFactory()
    {
        return \Modules\DiseaseClassification\Database\factories\DiseaseClassificationFactory::new();
    }

    /**
     * @return BelongsToMany
     */
    public function disease(): BelongsToMany
    {
        return $this->belongsToMany(Disease::class, 'disease_malady_classification', 'malady_classification_id');
    } 

    /**
     * @return HasMany
     */
    public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return BelongsToMany
     */
    public function symptom():BelongsToMany
    {
        return $this->belongsToMany(Symptom::class);
    }

    
}
