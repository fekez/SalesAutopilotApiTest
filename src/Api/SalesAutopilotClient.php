<?php

declare(strict_types=1);

namespace App\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class SalesAutopilotClient
{
    private Client $http;

    public function __construct(
        private string $baseUrl,
        private string $username,
        private string $password,
        private int $timeout = 10,
    ) {
        $this->http = new Client([
            'base_uri' => rtrim($baseUrl, '/') . '/',
            'timeout'  => $timeout,
            'auth'     => [$username, $password],
            'headers'  => ['Accept' => 'application/json'],
        ]);
    }

    public function get(string $endpoint, array $query = []): mixed
    {
        try {
            $response = $this->http->get($endpoint, ['query' => $query]);
            return $this->decode((string) $response->getBody());

        } catch (ConnectException) {
            throw new ApiException('Az API nem érhető el. Ellenőrizze a kapcsolatot, vagy próbálja újra később.', 503);
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        }
    }

    public function post(string $endpoint, mixed $body = null): mixed
    {
        try {
            $options = [];
            if ($body !== null) {
                $options['json'] = $body;
            }
            $response = $this->http->post($endpoint, $options);
            return $this->decode((string) $response->getBody());

        } catch (ConnectException) {
            throw new ApiException('Az API nem érhető el. Ellenőrizze a kapcsolatot, vagy próbálja újra később.', 503);
        } catch (RequestException $e) {
            throw $this->handleRequestException($e);
        }
    }

    public function getLists(): array
    {
        $data = $this->get('getlists');

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

    public function getListCount(int $listId): int
    {
        $data = $this->get("listtotalcount/{$listId}");
        return is_numeric($data) ? (int) $data : 0;
    }

    public function getSubscribers(int $listId, int $limit = 20): array
    {
        $data = $this->post("list/{$listId}/order/subdate/asc/{$limit}");

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

    private function decode(string $body): mixed
    {
        $body = trim($body);

        if ($body === '') {
            return null;
        }

        // A valid numeric response (pl. listtotalcount)
        if (is_numeric($body)) {
            return $body;
        }

        $decoded = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ApiException('Az API érvénytelen választ adott.', 502);
        }

        return $decoded;
    }

    private function handleRequestException(RequestException $e): ApiException
    {
        $status = $e->getResponse()?->getStatusCode() ?? 0;

        return match (true) {
            $status === 401 => new ApiException(
                'Érvénytelen API azonosító vagy jelszó. Ellenőrizze a .env fájl tartalmát.',
                401
            ),
            $status === 429 => new ApiException(
                'Túl sok egyidejű API kérés. Próbálja újra néhány másodperc múlva.',
                429
            ),
            $status === 404 => new ApiException(
                'A kért erőforrás nem található az API-ban.',
                404
            ),
            $status >= 500  => new ApiException(
                'A SalesAutopilot szerver hibát jelzett. Próbálja újra később.',
                502
            ),
            default         => new ApiException(
                'API hiba történt. (' . $status . ')',
                $status
            ),
        };
    }
}