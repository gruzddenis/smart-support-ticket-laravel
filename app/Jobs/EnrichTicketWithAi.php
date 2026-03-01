<?php

namespace App\Jobs;

use App\AI\AiClientInterface;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnrichTicketWithAi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $ticketId)
    {
    }

    public function handle(AiClientInterface $ai): void
    {
        $ticket = Ticket::find($this->ticketId);

        if ($ticket === false) {
            return;
        }

        try {
            $result = $ai->analyzeTicket($ticket->title, $ticket->description);

            $sentiment =  $result['sentiment'] ?? null;

            $ticket->update([
                'category' => $result['category'] ?? null,
                'sentiment' => $sentiment,
                'urgency' => $sentiment === 'Negative' ? 'High' : 'Medium',
                'suggested_reply' => $result['reply'] ?? null,
                'ai_processed_at' => now(),
                'ai_error' => null,
            ]);
        } catch (\Throwable $exception) {
            $ticket->update([
                'ai_processed_at' => now(),
                'ai_error' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
