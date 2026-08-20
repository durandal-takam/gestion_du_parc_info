<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Maintenances</h1>
        <a href="<?= BASE_URL ?>/controllers/MaintenanceController.php?action=ajouter" class="btn btn-primary">+ Nouvelle maintenance</a>
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
                <th>ID</th>
                <th>Type</th>
                <th>Matériel</th>
                <th>Technicien</th>
                <th>Catégorie panne</th>
                <th>Date panne</th>
                <th>Date intervention</th>
                <th>Coût</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($maintenances as $m): ?>
                <tr>
                    <td><?= h($m['ID_MAINTENANCE']) ?></td>
                    <td><span class="badge badge-primary"><?= h($m['TYPE_LIBELLE']) ?></span></td>
                    <td><?= h($m['MATERIEL_DESIGNATION'] ?? '-') ?></td>
                    <td><?= h($m['PRENOM'] . ' ' . $m['NOM']) ?></td>
                    <td><?= h($m['CATEGORIE_LIBELLE'] ?? '-') ?></td>
                    <td><?= h($m['DATE_PANNE']) ?></td>
                    <td><?= h($m['DATE_INTERVENTION'] ?? '-') ?></td>
                    <td><?= $m['COUT'] ? number_format($m['COUT'], 0, ',', ' ') . ' FCFA' : '-' ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/MaintenanceController.php?action=modifier&id=<?= $m['ID_MAINTENANCE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/MaintenanceController.php?action=supprimer&id=<?= $m['ID_MAINTENANCE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cette maintenance ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>