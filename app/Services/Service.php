<?php

namespace App\Services;

use \GuzzleHttp\Client;

abstract class Service
{
    protected Client $client;

    protected function getClient(): Client
    {
        if (empty($this->client)) {
            $this->client = new Client();
        }

        return $this->client;
    }
}
