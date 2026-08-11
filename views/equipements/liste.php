<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Équipements</h1>
        <a href="<?= BASE_URL ?>/controllers/MaterielController.php?action=ajouter" class="btn btn-primary">+ Ajouter un matériel</a>
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
                <th>Désignation</th>
                <th>N° série</th>
                <th>Article (catégorie)</th>
                <th>Acquisition</th>
                <th>Mise en service</th>
                <th>État</th>
                <th>Localisation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materiels as $m): ?>
                <tr>
                    <td><?= h($m['ID_MATERIEL']) ?></td>
                    <td><?= h($m['DESIGNATION']) ?></td>
                    <td><?= h($m['NUMERO_SERIE']) ?></td>
                    <td><?= h($m['ARTICLE_DESIGNATION'] ?? '-') ?> (<?= h($m['CATEGORIE_LIBELLE'] ?? '-') ?>)</td>
                    <td><?= h($m['DATE_D_ACQUISITION']) ?></td>
                    <td><?= h($m['DATE_MISE_EN_SERVICE']) ?></td>
                    <td>
                        <?php
                        $badge = match ($m['ETAT']) {
                            'disponible'   => 'badge-success',
                            'affecté'      => 'badge-primary',
                            'en panne'     => 'badge-danger',
                            'en maintenance' => 'badge-warning',
                            default        => 'badge-muted',
                        };
                        ?>
                        <span class="badge <?= $badge ?>"><?= h($m['ETAT']) ?></span>
                    </td>
                    <td><?= h($m['LOCALISATION']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/MaterielController.php?action=modifier&id=<?= $m['ID_MATERIEL'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/MaterielController.php?action=supprimer&id=<?= $m['ID_MATERIEL'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce matériel ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>