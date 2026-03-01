<?php

namespace App\AI;

class FakeAiClient implements AiClientInterface
{
    public function analyzeTicket(string $title, string $description): array
    {
        usleep(700_000);

        $desc = mb_strtolower($description);

        $category = str_contains($desc, 'payment') || str_contains($desc, 'invoice') ? 'Billing' : 'Technical';
        $sentiment = str_contains($desc, 'angry') || str_contains($desc, 'terrible') ? 'Negative' : 'Neutral';

        return [
            'category' => $category,
            'sentiment' => $sentiment,
            'reply' => "Thanks for reaching out — we’re looking into this now. Could you share any relevant details (account email, timestamps, screenshots) so we can help faster?",
        ];
    }
}
