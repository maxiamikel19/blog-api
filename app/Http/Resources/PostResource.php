<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title'=> $this->title,
            'content'=> $this->content,
            'created_at'=> $this->created_at,
            'autor'=> $this->user,
            'total_comments' =>$this->comments->count(),
        ];
    }
}
