<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "post"=> $this->post->title,
            "post_autor" => $this->post->user->name,
            "comment_created_date" => $this->created_at,
            "comment" => $this->comment,
            "autor" => $this->user->name,
        ];
    }
}
