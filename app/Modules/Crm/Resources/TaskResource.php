<?php

namespace App\Modules\Crm\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Modules\Crm\Models\Task
 */
class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'client_id' => $this->client_id,
            'deadline' => $this->deadline,
            'remind_before_minutes' => $this->remind_before_minutes,
            'remind_via' => $this->remind_via,
            'is_recurring' => $this->is_recurring,
            'recurrence_type' => $this->recurrence_type,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
