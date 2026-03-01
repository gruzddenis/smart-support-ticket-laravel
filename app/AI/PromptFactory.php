<?php

namespace App\AI;

final class PromptFactory
{
    public static function system(): string
    {
        return implode("\n", [
            "You are a Helpful Customer Support Agent.",
            "Classify the ticket and draft a helpful response.",
            "Return ONLY valid JSON. No markdown. No extra text.",
            "JSON schema:",
            '{ "category": "Technical|Billing|General", "sentiment": "Positive|Neutral|Negative", "urgency": "Low|Medium|High", "reply": "..." }',
        ]);
    }

    public static function user(string $title, string $description): string
    {
        return "TITLE: {$title}\nDESCRIPTION: {$description}";
    }
}
