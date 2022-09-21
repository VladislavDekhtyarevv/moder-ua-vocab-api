<?php

namespace App\Http\Resources;

use App\Models\Word;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class WordResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = auth('sanctum')->user();
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'likes' => $this->upvoters_count,
            'dislikes' => $this->downvoters_count,
            'hasLike' => $user ? $user->attachVoteStatus(Word::find($this->id))->has_upvoted : false,
            'hasDislike' => $user ? $user->attachVoteStatus(Word::find($this->id))->has_downvoted : false,
        ];
    }
}
