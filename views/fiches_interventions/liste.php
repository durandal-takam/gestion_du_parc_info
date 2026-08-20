<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Fiches d'intervention</h1>
        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=ajouter" class="btn btn-primary">+ Nouvelle fiche</a>
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
                <th>N° fiche</th>
                <th>Date</th>
                <th>Matériel</th>
                <th>Technicien</th>
                <th>Responsable</th>
                <th>Version numérisée</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fiches as $f): ?>
                <tr>
                    <td><strong><?= h($f['NUMERO_FICHE']) ?></strong></td>
                    <td><?= h($f['DATE_FICHE']) ?></td>
                    <td><?= h($f['MATERIEL_DESIGNATION'] ?? '-') ?></td>
                    <td><?= h($f['PRENOM'] . ' ' . $f['NOM']) ?></td>
                    <td><?= h($f['NOM_RESPONSABLE']) ?></td>
                    <td>
                        <?php if ($f['FICHIER_NUMERISE']): ?>
                            <a href="<?= BASE_URL ?>/uploads/fiches/<?= h($f['FICHIER_NUMERISE']) ?>" target="_blank" class="btn btn-small">📎 Voir</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=voir&id=<?= $f['ID_FICHE'] ?>" class="btn btn-small">🖨️ Imprimer</a>
                        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=modifier&id=<?= $f['ID_FICHE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=supprimer&id=<?= $f['ID_FICHE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cette fiche ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>