<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TwitchService
{
    private string $apiUrl = 'https://api.twitch.tv/helix';

    public function appAccessToken(): string
    {
        return Cache::remember(
            'twitch.app-access-token',
            now()->addDays(30),
            function (): string {
                $response = Http::asForm()
                    ->post('https://id.twitch.tv/oauth2/token', [
                        'client_id' => config(
                            'services.twitch.client_id'
                        ),
                        'client_secret' => config(
                            'services.twitch.client_secret'
                        ),
                        'grant_type' => 'client_credentials',
                    ]);

                if ($response->failed()) {
                    throw new RuntimeException(
                        'Unable to authenticate with Twitch: '.
                        $response->body()
                    );
                }

                $token = $response->json('access_token');

                if (!$token) {
                    throw new RuntimeException(
                        'Twitch did not return an access token.'
                    );
                }

                return $token;
            }
        );
    }

    public function client(?string $token = null): PendingRequest
    {
        return Http::acceptJson()
            ->withHeaders([
                'Client-Id' => config(
                    'services.twitch.client_id'
                ),
            ])
            ->withToken($token ?? $this->appAccessToken())
            ->connectTimeout(5)
            ->timeout(15)
            ->retry(2, 300);
    }

    public function getUserByLogin(string $login): ?array
    {
        $response = $this->client()->get(
            "{$this->apiUrl}/users",
            [
                'login' => $login,
            ]
        );

        if ($response->failed()) {
            throw new RuntimeException($response->body());
        }

        return $response->json('data.0');
    }

    public function getLiveStream(string $broadcasterId): ?array
    {
        $response = $this->client()->get(
            "{$this->apiUrl}/streams",
            [
                'user_id' => $broadcasterId,
            ]
        );

        if ($response->failed()) {
            throw new RuntimeException($response->body());
        }

        return $response->json('data.0');
    }

    public function isLive(string $broadcasterId): bool
    {
        return $this->getLiveStream($broadcasterId) !== null;
    }

    public function searchCategories(string $query): array
    {
        $response = $this->client()->get(
            "{$this->apiUrl}/search/categories",
            [
                'query' => $query,
                'first' => 20,
            ]
        );

        if ($response->failed()) {
            throw new RuntimeException($response->body());
        }

        return $response->json('data', []);
    }

    public function updateChannel(
        string $userAccessToken,
        string $broadcasterId,
        string $title,
        ?string $categoryId = null
    ): void {
        $payload = [
            'title' => $title,
        ];

        if ($categoryId) {
            $payload['game_id'] = $categoryId;
        }

        $response = $this->client($userAccessToken)
            ->patch(
                "{$this->apiUrl}/channels",
                $payload + [
                    'broadcaster_id' => $broadcasterId,
                ]
            );

        if ($response->failed()) {
            throw new RuntimeException(
                'Twitch channel update failed: '.
                $response->body()
            );
        }
    }
    public function validateToken(string $token): array
    {
        $response = Http::acceptJson()
            ->withToken($token)
            ->get('https://id.twitch.tv/oauth2/validate');

        if ($response->failed()) {
            throw new \RuntimeException(
                'Token validation failed: '.$response->body()
            );
        }

        return $response->json();
    }
}