<?php

namespace Tests\Feature;

use App\AI\AiClientInterface;
use App\AI\FakeAiClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketsApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatesAndEnrichesTicket(): void
    {
        config()->set('queue.default', 'sync');

        $this->app->bind(AiClientInterface::class, fn() =>
            new FakeAiClient()
        );

        $response = $this->postJson('/api/tickets', [
            'title' => 'Payment failed',
            'description' => 'My payment failed and I am very angry about it.',
        ]);

        $response->assertStatus(201);

        $id = $response->json('id');

        $response = $this->getJson("/api/tickets/{$id}")
            ->assertOk();

        $ticket = $response->json('data');

        $this->assertNotNull($ticket['category']);
        $this->assertNotNull($ticket['sentiment']);
        $this->assertNotNull($ticket['suggested_reply']);
        $this->assertNotNull($ticket['ai_processed_at']);
    }
}
