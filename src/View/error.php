<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$content = '<div class="error-box">'
    . '<h2>⚠️ Hiba történt</h2>'
    . '<p>' . htmlspecialchars($error ?? 'Ismeretlen hiba.') . '</p>'
    . '<a href="?page=lists">← Vissza a listákhoz</a>'
    . '</div>';

renderLayout('Hiba', $content);