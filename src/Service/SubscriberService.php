<?php
declare(strict_types=1);
namespace App\Service;

use App\Api\SalesAutopilotClient;

class SubscriberService
{
    public function __construct(private SalesAutopilotClient $client) {}

    public function getSubscribers(int $listId, ?string $sort = null, ?string $filter = null): array
    {
        $subscribers = $this->client->getSubscribers($listId, limit: 20);

        if (!empty($filter)) {
            $subscribers = array_filter($subscribers, fn($s) =>
            str_contains(strtolower($s['email'] ?? ''), strtolower($filter))
            );
        }

        if (!empty($sort) && in_array($sort, ['email', 'mssys_firstname', 'created_at'])) {
            usort($subscribers, fn($a, $b) =>
                ($a[$sort] ?? '') <=> ($b[$sort] ?? '')
            );
        }

        return array_values($subscribers);
    }
}