<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'event_name' => $this->event_name,
            'event_desc' => $this->event_desc,
            'event_category' => new EventCategoryResource($this->event_category),
            /* 'event_category' => [
                'name' => $this->event_category->name,
                'description' => $this->event_category->description,
            ], */
            'company' => new CompanyResource($this->company),
            'max_participants' => $this->max_participants,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
