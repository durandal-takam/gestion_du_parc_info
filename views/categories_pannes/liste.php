<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Catégories de pannes</h1>
        <a href="<?= BASE_URL ?>/controllers/CategoriePanneController.php?action=ajouter" class="btn btn-primary">+ Ajouter une catégorie</a>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $c): ?>
                <tr>
                    <td><?= h($c['ID_CATEGORIE_PANNE']) ?></td>
                    <td><?= h($c['LIBELLE']) ?></td>
                    <td><?= h($c['DESCRIPTION']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/CategoriePanneController.php?action=modifier&id=<?= $c['ID_CATEGORIE_PANNE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/CategoriePanneController.php?action=supprimer&id=<?= $c['ID_CATEGORIE_PANNE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cette catégorie ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>