<?php

namespace Modules\Symptom\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackedSymptomResource extends JsonResource
{
    /**
     * Transform resource into an array
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'severity' => $this->pivot->severity,
            'description' => $this->pivot->description,
            'created_at' => $this->pivot->created_at->toDateTimeString(),
        ];
    }
}