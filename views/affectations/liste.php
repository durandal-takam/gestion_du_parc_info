<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Affectations</h1>
        <a href="<?= BASE_URL ?>/controllers/AffectationController.php?action=ajouter" class="btn btn-primary">+ Affecter un matériel</a>
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
                <th>Utilisateur</th>
                <th>Matériel</th>
                <th>N° série</th>
                <th>Date affectation</th>
                <th>Date retour</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($affectations as $a): ?>
                <tr>
                    <td><?= h($a['ID_AFFECTATION']) ?></td>
                    <td><?= h($a['PRENOM'] . ' ' . $a['NOM']) ?></td>
                    <td><?= h($a['MATERIEL_DESIGNATION']) ?></td>
                    <td><?= h($a['NUMERO_SERIE']) ?></td>
                    <td><?= h($a['DATE_AFFECTATION']) ?></td>
                    <td><?= h($a['DATE_RETOUR'] ?? '-') ?></td>
                    <td>
                        <span class="badge <?= $a['STATUT'] == 'active' ? 'badge-success' : 'badge-muted' ?>">
                            <?= h($a['STATUT']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($a['STATUT'] == 'active'): ?>
                            <a href="<?= BASE_URL ?>/controllers/AffectationController.php?action=terminer&id=<?= $a['ID_AFFECTATION'] ?>" class="btn btn-small" onclick="return confirm('Terminer cette affectation et libérer le matériel ?')">↩️ Terminer</a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/controllers/AffectationController.php?action=supprimer&id=<?= $a['ID_AFFECTATION'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cette affectation ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>