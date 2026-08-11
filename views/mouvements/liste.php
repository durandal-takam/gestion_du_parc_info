<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Mouvements du matériel</h1>
        <a href="<?= BASE_URL ?>/controllers/MouvementController.php?action=ajouter" class="btn btn-primary">+ Enregistrer un mouvement</a>
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
                <th>Matériel</th>
                <th>Utilisateur</th>
                <th>Type</th>
                <th>Date</th>
                <th>Observation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mouvements as $m): ?>
                <tr>
                    <td><?= h($m['ID_MOUVEMENT']) ?></td>
                    <td><?= h($m['MATERIEL_DESIGNATION'] ?? '-') ?></td>
                    <td><?= h(($m['PRENOM'] ?? '') . ' ' . ($m['NOM'] ?? '-')) ?></td>
                    <td>
                        <?php
                        $badge = match ($m['TYPE_MOUVEMENT']) {
                            'transfert'          => 'badge-primary',
                            'prêt'               => 'badge-warning',
                            'retour'             => 'badge-success',
                            'réforme'            => 'badge-danger',
                            default              => 'badge-muted',
                        };
                        ?>
                        <span class="badge <?= $badge ?>"><?= h($m['TYPE_MOUVEMENT']) ?></span>
                    </td>
                    <td><?= h($m['DATE_MOUVEMENT']) ?></td>
                    <td><?= h($m['OBSERVATION']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/MouvementController.php?action=supprimer&id=<?= $m['ID_MOUVEMENT'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce mouvement ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>