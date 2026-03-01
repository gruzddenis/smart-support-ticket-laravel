<?php

namespace App\Providers;

use App\AI\AiClientInterface;
use App\AI\FakeAiClient;
use App\AI\OpenAiClient;
use Illuminate\Support\ServiceProvider;
use OpenAI;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AiClientInterface::class, function () {

            if (config('ai.provider') === 'fake') {
                return new FakeAiClient();
            }

            if (!config('ai.openai.key')) {
                throw new \RuntimeException('OPENAI_API_KEY is required');
            }

            return new OpenAiClient(
                client: OpenAI::client(config('ai.openai.key')),
                model: config('ai.openai.model'),
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
