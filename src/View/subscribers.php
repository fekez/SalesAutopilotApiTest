<?php
declare(strict_types=1);
require_once __DIR__ . '/layout.php';

$currentSort   = $_GET['sort']   ?? '';
$currentFilter = $_GET['filter'] ?? '';
$listId        = $_GET['list_id'] ?? '';

ob_start(); ?>
    <a class="back-link" href="?page=lists">← Vissza a listákhoz</a>

    <div class="filter-bar">
        <form method="get" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:center;">
            <input type="hidden" name="page" value="subscribers">
            <input type="hidden" name="list_id" value="<?= htmlspecialchars($listId) ?>">
            <input
                type="text"
                name="filter"
                placeholder="Szűrés email alapján..."
                value="<?= htmlspecialchars($currentFilter) ?>"
            >
            <select name="sort">
                <option value="">– Rendezés –</option>
                <option value="email"          <?= $currentSort === 'email'          ? 'selected' : '' ?>>Email (A→Z)</option>
                <option value="mssys_firstname" <?= $currentSort === 'mssys_firstname' ? 'selected' : '' ?>>Keresztnév (A→Z)</option>
                <option value="created_at"     <?= $currentSort === 'created_at'     ? 'selected' : '' ?>>Létrehozás dátuma</option>
            </select>
            <button type="submit">Alkalmaz</button>
            <?php if ($currentFilter || $currentSort): ?>
                <a href="?page=subscribers&list_id=<?= urlencode($listId) ?>">Törlés ✕</a>
            <?php endif; ?>
        </form>
    </div>

<?php if (empty($subscribers)): ?>
    <p class="empty">Ennek a listának nincs feliratkozója<?= $currentFilter ? ' a megadott szűrési feltételre' : '' ?>.</p>
<?php else: ?>
    <p class="info"><?= count($subscribers) ?> feliratkozó megjelenítve</p>
    <table>
        <thead>
        <tr>
            <th>Email</th>
            <th>Keresztnév</th>
            <th>Vezetéknév</th>
            <th>Létrehozva</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subscribers as $sub): ?>
            <tr>
                <td><?= htmlspecialchars($sub['email'] ?? '–') ?></td>
                <td><?= htmlspecialchars($sub['mssys_firstname'] ?? '–') ?></td>
                <td><?= htmlspecialchars($sub['mssys_lastname'] ?? '–') ?></td>
                <td><?= htmlspecialchars($sub['created_at'] ?? '–') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;

$content = ob_get_clean();
renderLayout('Feliratkozók', $content);