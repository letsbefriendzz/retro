<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(?Request $request): array
    {
        return [
            "id" => $this->id,
            "github_url" => $this->github_url,
            "name" => $this->name,
            "nickname" => $this->nickname,
            "avatar" => $this->avatar,
            "email" => $this->email,
        ];
    }
}
