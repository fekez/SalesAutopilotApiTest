<?php

declare(strict_types=1);

namespace App\Service;

use App\Api\SalesAutopilotClient;

class ListService
{
    public function __construct(private SalesAutopilotClient $client) {}

    public function getLists(): array
    {
        $lists = $this->client->getLists();

        if (empty($lists)) {
            return [];
        }

        // Rate limit miatt sorban, egymás után kérjük le a számokat
        foreach ($lists as &$list) {
            $id = (int) ($list['id'] ?? 0);
            if ($id > 0) {
                $list['size'] = $this->client->getListCount($id);
            } else {
                $list['size'] = 0;
            }
            // created_at nem elérhető az API-ból, kihagyjuk
            $list['created_at'] = null;
        }
        unset($list);

        return $lists;
    }
}