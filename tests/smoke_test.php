<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Api\ApiException;
use App\Api\SalesAutopilotClient;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeMutable(__DIR__ . '/../');
$dotenv->safeLoad();

function pass(string $msg): void {
    echo "\033[32m✔ PASS\033[0m — {$msg}\n";
}
function fail(string $msg): void {
    echo "\033[31m✘ FAIL\033[0m — {$msg}\n";
}
function section(string $title): void {
    echo "\n\033[33m== {$title} ==\033[0m\n";
}

$baseUrl  = $_ENV['SAPI_BASE_URL']  ?? '';
$username = $_ENV['SAPI_USERNAME']  ?? '';
$password = $_ENV['SAPI_PASSWORD']  ?? '';
$timeout  = (float) ($_ENV['SAPI_TIMEOUT'] ?? 10);

if (empty($baseUrl) || empty($username) || empty($password)) {
    fail('.env hiányos — SAPI_BASE_URL, SAPI_USERNAME, SAPI_PASSWORD szükséges');
    exit(1);
}

$results = ['pass' => 0, 'fail' => 0];

function check(bool $condition, string $passMsg, string $failMsg): void {
    global $results;
    if ($condition) { pass($passMsg); $results['pass']++; }
    else            { fail($failMsg); $results['fail']++; }
}

// 1. Listák lekérése
section('1. Listák lekérése (valid credentials)');
$client = new SalesAutopilotClient($baseUrl, $username, $password, $timeout);
$lists  = [];
try {
    $lists = $client->getLists();
    check(is_array($lists), 'getLists() tömböt ad vissza', 'getLists() nem tömböt adott vissza');
    if (!empty($lists)) {
        check(isset($lists[0]['id']),   'Lista tartalmaz id mezőt',   'Lista nem tartalmaz id mezőt');
        check(isset($lists[0]['name']), 'Lista tartalmaz name mezőt', 'Lista nem tartalmaz name mezőt');
    }
} catch (ApiException $e) {
    fail('getLists() kivételt dobott: ' . $e->getMessage()); $results['fail']++;
}

// 2. Feliratkozók lekérése
section('2. Feliratkozók lekérése (valid list_id)');
if (!empty($lists)) {
    $firstListId = (int) $lists[0]['id'];
    try {
        $subscribers = $client->getSubscribers($firstListId, 20);
        check(is_array($subscribers), 'getSubscribers() tömböt ad vissza', 'getSubscribers() nem tömböt adott vissza');
        check(count($subscribers) <= 20, 'Maximum 20 feliratkozó kerül vissza', 'Több mint 20 feliratkozó érkezett');
        if (!empty($subscribers)) {
            check(isset($subscribers[0]['email']), 'Feliratkozó tartalmaz email mezőt', 'Feliratkozó nem tartalmaz email mezőt');
        } else {
            pass('Lista üres — 0 feliratkozó, nem törik el'); $results['pass']++;
        }
    } catch (ApiException $e) {
        fail('getSubscribers() kivételt dobott: ' . $e->getMessage()); $results['fail']++;
    }
} else {
    echo "  (kihagyva — nincs lista a fiókban)\n";
}

// 3. Lista mérete
section('3. Lista méretének lekérése');
if (!empty($lists)) {
    $firstListId = (int) $lists[0]['id'];
    try {
        $count = $client->getListCount($firstListId);
        check(is_int($count) && $count >= 0, "Lista mérete lekérhető ({$count} feliratkozó)", 'Lista mérete nem kérhető le');
    } catch (ApiException $e) {
        fail('getListCount() kivételt dobott: ' . $e->getMessage()); $results['fail']++;
    }
}

// 4. Hibás credentials
section('4. Hibás API credentials (401 kezelés)');
$badClient = new SalesAutopilotClient($baseUrl, 'hibas_user', 'hibas_jelszo', $timeout);
try {
    $badClient->getLists();
    fail('Hibás credentials esetén kivételt kellett volna dobni'); $results['fail']++;
} catch (ApiException $e) {
    check($e->getCode() === 401, 'Hibás credentials → 401 ApiException', 'Nem 401 kód érkezett: ' . $e->getCode());
}

// 5. Érvénytelen list_id
section('5. Érvénytelen list_id kezelése');
try {
    $result = $client->getSubscribers(999999999, 20);
    check(is_array($result) && empty($result), 'Érvénytelen list_id → üres tömb, nem fatal error', 'Váratlan eredmény');
} catch (ApiException $e) {
    pass('Érvénytelen list_id → ApiException (' . $e->getCode() . ') — kezelt hiba'); $results['pass']++;
}

// 6. Timeout
section('6. Kapcsolati timeout kezelése');
$timeoutClient = new SalesAutopilotClient($baseUrl, $username, $password, 0.001);
try {
    $timeoutClient->getLists();
    fail('Timeout esetén kivételt kellett volna dobni'); $results['fail']++;
} catch (ApiException $e) {
    check($e->getCode() === 503, 'Timeout → 503 ApiException', 'Nem 503 kód: ' . $e->getCode());
}

// Összesítés
$total = $results['pass'] + $results['fail'];
echo "\n\033[33m== Eredmény ==\033[0m\n";
echo "Összesen: {$total} | \033[32m{$results['pass']} pass\033[0m | \033[31m{$results['fail']} fail\033[0m\n\n";
exit($results['fail'] > 0 ? 1 : 0);