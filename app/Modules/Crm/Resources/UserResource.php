<?php

namespace App\Modules\Crm\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $request->id,
            "name" => $request->name,
            "email" => $request->email,
            "role" => $request->role,
            "updated_at" => $request->updated_at,
            "created_at" => $request->created_at,
        ];
    }
}
