<?php

namespace App\AI;

interface AiClientInterface
{
    /** @return array{category:string,sentiment:string,reply:string,urgency?:string} */
    public function analyzeTicket(string $title, string $description): array;
}
