<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Directions</h1>
        <a href="<?= BASE_URL ?>/controllers/DirectionController.php?action=ajouter" class="btn btn-primary">+ Ajouter une direction</a>
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
                <th>Nom</th>
                <th>Description</th>
                <th>Bureaux</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($directions as $d): ?>
                <tr>
                    <td><?= h($d['ID_DIRECTION']) ?></td>
                    <td><?= h($d['NOM_DIRECTION']) ?></td>
                    <td><?= h($d['DESCRIPTION']) ?></td>
                    <td><?= h($d['NB_BUREAUX']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/DirectionController.php?action=modifier&id=<?= $d['ID_DIRECTION'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/DirectionController.php?action=supprimer&id=<?= $d['ID_DIRECTION'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cette direction ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>