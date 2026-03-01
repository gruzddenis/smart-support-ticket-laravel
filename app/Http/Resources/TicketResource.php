<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,

            'category' => $this->category,
            'sentiment' => $this->sentiment,
            'urgency' => $this->urgency,
            'suggested_reply' => $this->suggested_reply,

            'ai_processed_at' => optional($this->ai_processed_at)?->toISOString(),
            'ai_error' => $this->ai_error,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
