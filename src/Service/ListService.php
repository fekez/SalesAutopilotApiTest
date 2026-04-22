<?php
declare(strict_types=1);
namespace App\Service;

use App\Api\SalesAutopilotClient;

class ListService
{
    public function __construct(private SalesAutopilotClient $client) {}

    public function getLists(): array
    {
        return $this->client->getLists();
    }
}