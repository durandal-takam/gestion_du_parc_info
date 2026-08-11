<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Bureaux</h1>
        <a href="<?= BASE_URL ?>/controllers/BureauController.php?action=ajouter" class="btn btn-primary">+ Ajouter un bureau</a>
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
                <th>Nom du bureau</th>
                <th>Direction</th>
                <th>Localisation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bureaux as $b): ?>
                <tr>
                    <td><?= h($b['ID_BUREAU']) ?></td>
                    <td><?= h($b['NOM_BUREAU']) ?></td>
                    <td><?= h($b['NOM_DIRECTION']) ?></td>
                    <td><?= h($b['LOCALISATION']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/BureauController.php?action=modifier&id=<?= $b['ID_BUREAU'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/BureauController.php?action=supprimer&id=<?= $b['ID_BUREAU'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce bureau ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>