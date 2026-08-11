<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Rôles</h1>
        <a href="<?= BASE_URL ?>/controllers/RoleController.php?action=ajouter" class="btn btn-primary">+ Ajouter un rôle</a>
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
                <th>Libellé</th>
                <th>Description</th>
                <th>Utilisateurs</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $r): ?>
                <tr>
                    <td><?= h($r['ID_ROLE']) ?></td>
                    <td><?= h($r['LIBELLE']) ?></td>
                    <td><?= h($r['DESCRIPTION']) ?></td>
                    <td><?= h($r['NB_UTILISATEURS']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/RoleController.php?action=modifier&id=<?= $r['ID_ROLE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/RoleController.php?action=supprimer&id=<?= $r['ID_ROLE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce rôle ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>