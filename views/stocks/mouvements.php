<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Historique — <?= h($stock['ARTICLE_DESIGNATION']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/StockController.php?action=list" class="btn">← Retour aux stocks</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Quantité</th>
                <th>Motif</th>
                <th>Utilisateur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mouvements as $mv): ?>
                <tr>
                    <td><?= h($mv['DATE_MOUVEMENT']) ?></td>
                    <td>
                        <?php if ($mv['TYPE_MOUVEMENT'] == 'entree'): ?>
                            <span class="badge badge-success">⬇️ Entrée</span>
                        <?php else: ?>
                            <span class="badge badge-danger">⬆️ Sortie</span>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= (int)$mv['QUANTITE'] ?></strong></td>
                    <td><?= h($mv['MOTIF'] ?: '-') ?></td>
                    <td><?= h(($mv['PRENOM'] ?? '') . ' ' . ($mv['NOM'] ?? '-')) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($mouvements)): ?>
        <p>Aucun mouvement enregistré pour ce stock.</p>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>