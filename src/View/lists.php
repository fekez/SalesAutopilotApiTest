<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

ob_start();
if (empty($lists)): ?>
    <p class="empty">Nincsenek elérhető listák.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Név</th>
            <th>Méret</th>
            <th>Létrehozva</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lists as $list): ?>
            <tr>
                <td><?= htmlspecialchars($list['name'] ?? '–') ?></td>
                <td><?= htmlspecialchars((string)($list['size'] ?? '–')) ?></td>
                <td><?= htmlspecialchars($list['created_at'] ?? '–') ?></td>
                <td><a class="btn" href="?page=subscribers&list_id=<?= urlencode((string)$list['id']) ?>">Megnyitás →</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;

$content = ob_get_clean();
renderLayout('Listák', $content);