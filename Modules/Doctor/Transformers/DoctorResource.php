<?php

namespace Modules\Doctor\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform resource into an array
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'uuid' => $this->uuid,
            'CUD' => $this->hasPermissionTo('CUD1')
        ];
    }
}