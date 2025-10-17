<?php

namespace App\Services;

use GuzzleHttp\Client;

class SupabaseService
{
    protected Client $client;
    protected string $url;
    protected string $key;

    public function __construct()
    {
        $this->url = config('services.supabase.url');
        $this->key = config('services.supabase.key');
        $this->client = new Client([
            'base_uri' => "{$this->url}/rest/v1/",
            'headers' => [
                'apikey'        => $this->key,
                'Authorization' => "Bearer {$this->key}",
                'Accept'        => 'application/json',
            ],
        ]);
    }

    public function tableCount(string $table): int
    {
        $response = $this->client->get($table, [
            'query' => [
                'select' => 'id',
                'limit'  => '0',
                'count'  => 'exact'
            ]
        ]);

        $count = $response->getHeaderLine('content-range'); // e.g. "0-0/123"
        if (preg_match('/\/(\d+)$/', $count, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }

    public function tableList(string $table): array
    {
        $response = $this->client->get($table);
        return json_decode($response->getBody()->getContents(), true) ?? [];
    }
}
