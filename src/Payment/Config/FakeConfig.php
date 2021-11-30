<?php

namespace App\Payment\Config;

class FakeConfig
{
    public function __construct(private string $apiKey)
    {
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}
