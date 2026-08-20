<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Journal d'activité</h1>
        <p><?= $total ?> entrée(s) — page <?= $page ?>/<?= $pages ?></p>
    </div>

    <form method="GET" action="<?= BASE_URL ?>/controllers/JournalController.php" class="form" style="max-width: 100%; margin-bottom: 15px;">
        <input type="hidden" name="action" value="list">
        <div class="form-row">
            <div class="form-group">
                <label>Utilisateur</label>
                <select name="id_user">
                    <option value="">-- Tous --</option>
                    <?php foreach ($utilisateurs as $u): ?>
                        <option value="<?= $u['ID_USER'] ?>" <?= ($_GET['id_user'] ?? '') == $u['ID_USER'] ? 'selected' : '' ?>>
                            <?= h($u['PRENOM'] . ' ' . $u['NOM']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Action</label>
                <select name="action_filtre">
                    <option value="">-- Toutes --</option>
                    <?php foreach ($actions as $a): ?>
                        <option value="<?= h($a['ACTION']) ?>" <?= ($_GET['action_filtre'] ?? '') == $a['ACTION'] ? 'selected' : '' ?>>
                            <?= h($a['ACTION']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Du</label>
                <input type="date" name="date_debut" value="<?= h($_GET['date_debut'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Au</label>
                <input type="date" name="date_fin" value="<?= h($_GET['date_fin'] ?? '') ?>">
            </div>
            <div class="form-group" style="align-self: flex-end;">
                <button type="submit" class="btn btn-primary">Filtrer</button>
                <a href="<?= BASE_URL ?>/controllers/JournalController.php?action=list" class="btn">Effacer</a>
                <a href="<?= BASE_URL ?>/controllers/JournalController.php?action=export&<?= http_build_query(array_diff_key($_GET, ['action' => '', 'page' => ''])) ?>" class="btn">📥 Exporter</a>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Utilisateur</th>
                <th>Module</th>
                <th>Action</th>
                <th>Description</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($entrees as $j): ?>
                <tr>
                    <td><?= h($j['DATE_ACTION']) ?></td>
                    <td><?= $j['ID_USER'] ? h($j['PRENOM'] . ' ' . $j['NOM']) : '<em>système</em>' ?></td>
                    <td><?= h($j['MODULE']) ?></td>
                    <td><span class="badge badge-primary"><?= h($j['ACTION']) ?></span></td>
                    <td><?= h($j['DESCRIPTION'] ?: '-') ?></td>
                    <td><?= h($j['IP_ADRESSE'] ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($entrees)): ?>
        <p>Aucune entrée de journal pour ces critères.</p>
    <?php endif; ?>

    <?php if ($pages > 1): ?>
        <div class="rapport-actions">
            <?php $base = $_GET; unset($base['page']); ?>
            <?php if ($page > 1): ?>
                <a href="<?= BASE_URL ?>/controllers/JournalController.php?action=list&<?= http_build_query(array_merge($base, ['page' => $page - 1])) ?>" class="btn btn-small">← Précédente</a>
            <?php endif; ?>
            <span>Page <?= $page ?> / <?= $pages ?></span>
            <?php if ($page < $pages): ?>
                <a href="<?= BASE_URL ?>/controllers/JournalController.php?action=list&<?= http_build_query(array_merge($base, ['page' => $page + 1])) ?>" class="btn btn-small">Suivante →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>