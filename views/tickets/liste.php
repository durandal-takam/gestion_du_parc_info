<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Tickets de maintenance</h1>
        <a href="<?= BASE_URL ?>/controllers/DemandeController.php?action=ajouter" class="btn btn-primary">+ Nouveau ticket</a>
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
                <th>Date</th>
                <th>Demandeur</th>
                <th>Matériel</th>
                <th>Catégorie</th>
                <th>Priorité</th>
                <th>Statut</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demandes as $d): ?>
                <tr>
                    <td><?= h($d['ID_DEMANDE']) ?></td>
                    <td><?= h($d['DATE_DEMANDE']) ?></td>
                    <td><?= h($d['PRENOM'] . ' ' . $d['NOM']) ?></td>
                    <td><?= h($d['MATERIEL_DESIGNATION'] ?? '-') ?></td>
                    <td><?= h($d['CATEGORIE_LIBELLE'] ?? '-') ?></td>
                    <td>
                        <?php
                        $badge_p = match ($d['PRIORITE']) {
                            'Basse'    => 'badge-success',
                            'Moyenne'  => 'badge-primary',
                            'Haute'    => 'badge-warning',
                            'Critique' => 'badge-danger',
                            default    => 'badge-muted',
                        };
                        ?>
                        <span class="badge <?= $badge_p ?>"><?= h($d['PRIORITE']) ?></span>
                    </td>
                    <td>
                        <?php
                        $badge_s = match ($d['STATUT']) {
                            'Ouvert'                => 'badge-primary',
                            'En cours'              => 'badge-warning',
                            'En attente de pièces'  => 'badge-muted',
                            'Résolu'                => 'badge-success',
                            'Fermé'                 => 'badge-muted',
                            default                 => 'badge-muted',
                        };
                        ?>
                        <span class="badge <?= $badge_s ?>"><?= h($d['STATUT']) ?></span>
                    </td>
                    <td><?= h($d['DESCRIPTION']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/DemandeController.php?action=modifier&id=<?= $d['ID_DEMANDE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/DemandeController.php?action=supprimer&id=<?= $d['ID_DEMANDE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer ce ticket ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>