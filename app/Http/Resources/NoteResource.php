<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "content" => $this->content,
            "retro_column" => $this->retro_column,
            "session_id" => $this->session_id,
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
