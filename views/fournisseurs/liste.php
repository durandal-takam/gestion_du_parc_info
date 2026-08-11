<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Fournisseurs</h1>
        <a href="<?= BASE_URL ?>/controllers/FournisseurController.php?action=ajouter" class="btn btn-primary">+ Ajouter un fournisseur</a>
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
                <th>Téléphone</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>Articles</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fournisseurs as $f): ?>
                <tr>
                    <td><?= h($f['ID_FOURNISSEUR']) ?></td>
                    <td><?= h($f['NOM']) ?></td>
                    <td><?= h($f['TELEPHONE']) ?></td>
                    <td><?= h($f['EMAIL']) ?></td>
                    <td><?= h($f['ADRESSE']) ?></td>
                    <td><?= h($f['NB_ARTICLES']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/FournisseurController.php?action=modifier&id=<?= $f['ID_FOURNISSEUR'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/FournisseurController.php?action=supprimer&id=<?= $f['ID_FOURNISSEUR'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce fournisseur ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>