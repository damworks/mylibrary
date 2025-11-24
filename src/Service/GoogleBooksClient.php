<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleBooksClient
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function findByIsbn(string $isbn): ?array
    {
        $response = $this->client->request('GET', 'https://www.googleapis.com/books/v1/volumes', [
            'query' => [
                'q'   => 'isbn:' . $isbn,
                'key' => $this->apiKey,
            ],
        ]);

        $data = $response->toArray(false);

        if (empty($data['items'][0])) {
            return null;
        }

        return $data['items'][0];
    }
}
