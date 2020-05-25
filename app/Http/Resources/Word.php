<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Word extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
            'word_id' => $this->id,
            'word' => $this->word,
            'rate' => $this->rate,
            'type' => $this->type,
            'user_id' => $this->user_id,
        ],
        'links' => [
            'self' => $this->path(),
        ],
        'liked' => $this->liked($request),
      ];
    }
}
