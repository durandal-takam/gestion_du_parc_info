<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Inventaires</h1>
        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=ajouter" class="btn btn-primary">+ Nouvel inventaire</a>
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
                <th>N° inventaire</th>
                <th>Date</th>
                <th>Agent</th>
                <th>Matériels comptés</th>
                <th>Observation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inventaires as $inv): ?>
                <tr>
                    <td><strong><?= h($inv['NUMERO_INVENTAIRE']) ?></strong></td>
                    <td><?= h($inv['DATE_INVENTAIRE']) ?></td>
                    <td><?= h($inv['PRENOM'] . ' ' . $inv['NOM']) ?></td>
                    <td><?= (int)$inv['NB_DETAILS'] ?></td>
                    <td><?= h($inv['OBSERVATION'] ?: '-') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=voir&id=<?= h(urlencode($inv['NUMERO_INVENTAIRE'])) ?>" class="btn btn-small">🖨️ Procès-verbal</a>
                        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=modifier&id=<?= h(urlencode($inv['NUMERO_INVENTAIRE'])) ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=supprimer&id=<?= h(urlencode($inv['NUMERO_INVENTAIRE'])) ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cet inventaire ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($inventaires)): ?>
        <p>Aucun inventaire pour le moment.</p>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>