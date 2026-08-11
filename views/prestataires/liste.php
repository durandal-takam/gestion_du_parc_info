<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Prestataires</h1>
        <a href="<?= BASE_URL ?>/controllers/PrestataireController.php?action=ajouter" class="btn btn-primary">+ Ajouter un prestataire</a>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($prestataires as $p): ?>
                <tr>
                    <td><?= h($p['ID_PRESTATAIRE']) ?></td>
                    <td><?= h($p['NOM']) ?></td>
                    <td><?= h($p['TELEPHONE']) ?></td>
                    <td><?= h($p['EMAIL']) ?></td>
                    <td><?= h($p['ADRESSE']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/PrestataireController.php?action=modifier&id=<?= $p['ID_PRESTATAIRE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/PrestataireController.php?action=supprimer&id=<?= $p['ID_PRESTATAIRE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce prestataire ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>