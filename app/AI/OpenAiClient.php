<?php

namespace App\AI;

use OpenAI\Client;
use RuntimeException;

class OpenAiClient implements AiClientInterface
{
    public function __construct(
        private Client $client,
        private string $model,
    ) {}

    public function analyzeTicket(string $title, string $description): array
    {
        $response = $this->client->chat()->create([
            'model' => $this->model,
            'temperature' => 0.2,
            'messages' => [
                ['role' => 'system', 'content' => PromptFactory::system()],
                ['role' => 'user', 'content' => PromptFactory::user($title, $description)],
            ],
        ]);

        $content = $response->choices[0]->message->content ?? null;

        if ($content === null) {
            throw new RuntimeException('Invalid OpenAI response structure');
        }

        $data = json_decode($content, true);

        if (is_array($data) === false || isset($data['category'], $data['sentiment'], $data['reply']) === false) {
            throw new RuntimeException('Invalid AI JSON response');
        }

        return $data;
    }
}
