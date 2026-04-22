<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Dotenv\Exception\ValidationException;

// Load .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');

try {
    $dotenv->load();
    $dotenv->required(['SAPI_USERNAME', 'SAPI_PASSWORD', 'SAPI_BASE_URL'])->notEmpty();
} catch (ValidationException $e) {
    $error = 'Hiányzó API konfiguráció. Töltse ki a .env fájlt (lásd: .env.example).';
    $errorCode = 500;
    require __DIR__ . '/../src/View/error.php';
    exit;
}

// Simple query-param based router
$page   = $_GET['page']    ?? 'lists';
$listId = $_GET['list_id'] ?? null;
$sort   = $_GET['sort']    ?? null;
$filter = $_GET['filter']  ?? null;

try {
    $client = new \App\Api\SalesAutopilotClient(
        baseUrl:  $_ENV['SAPI_BASE_URL'],
        username: $_ENV['SAPI_USERNAME'],
        password: $_ENV['SAPI_PASSWORD'],
        timeout:  (int) ($_ENV['SAPI_TIMEOUT'] ?? 10),
    );

    $listService       = new \App\Service\ListService($client);
    $subscriberService = new \App\Service\SubscriberService($client);

    match ($page) {
        'lists' => (function () use ($listService) {
            $lists = $listService->getLists();
            require __DIR__ . '/../src/View/lists.php';
        })(),
        'subscribers' => (function () use ($subscriberService, $listId, $sort, $filter) {
            if (empty($listId)) {
                header('Location: ?page=lists');
                exit;
            }
            $subscribers = $subscriberService->getSubscribers((int) $listId, sort: $sort, filter: $filter);
            require __DIR__ . '/../src/View/subscribers.php';
        })(),
        default => (function () {
            header('Location: ?page=lists');
            exit;
        })(),
    };

} catch (\App\Api\ApiException $e) {
    $error     = $e->getMessage();
    $errorCode = $e->getCode();
    require __DIR__ . '/../src/View/error.php';
} catch (\Exception $e) {
    $error     = 'Váratlan hiba történt. Kérjük, próbálja újra később.';
    $errorCode = 500;
    require __DIR__ . '/../src/View/error.php';
}
