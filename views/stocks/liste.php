<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Gestion des stocks</h1>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= h($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>Article</th>
                <th>Catégorie</th>
                <th>Quantité dispo</th>
                <th>Seuil d'alerte</th>
                <th>État</th>
                <th>Dernière mise à jour</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stocks as $s): ?>
                <tr>
                    <td>
                        <strong><?= h($s['ARTICLE_DESIGNATION']) ?></strong><br>
                        <small><?= h(trim($s['MARQUE'] . ' ' . $s['MODELE'])) ?></small>
                    </td>
                    <td><?= h($s['CATEGORIE_LIBELLE'] ?? '-') ?></td>
                    <td><strong><?= (int)$s['QUANTITE_DISPO'] ?></strong></td>
                    <td><?= (int)$s['SEUIL_ALERTE'] ?></td>
                    <td>
                        <?php if ((int)$s['QUANTITE_DISPO'] <= (int)$s['SEUIL_ALERTE']): ?>
                            <span class="badge badge-danger">⚠️ À réapprovisionner</span>
                        <?php else: ?>
                            <span class="badge badge-success">✓ En stock</span>
                        <?php endif; ?>
                    </td>
                    <td><?= h($s['DATE_MISE_A_JOUR'] ?: '-') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/StockController.php?action=ajuster&id=<?= $s['ID_STOCK'] ?>" class="btn btn-small">↕️ Ajuster</a>
                        <a href="<?= BASE_URL ?>/controllers/StockController.php?action=mouvements&id=<?= $s['ID_STOCK'] ?>" class="btn btn-small">📜 Historique</a>
                        <a href="<?= BASE_URL ?>/controllers/StockController.php?action=modifier&id=<?= $s['ID_STOCK'] ?>" class="btn btn-small">⚙️ Seuil</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>