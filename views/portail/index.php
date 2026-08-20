<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Mon espace</h1>
        <p>Bienvenue, <?= h($_SESSION['user']['PRENOM'] . ' ' . $_SESSION['user']['NOM']) ?></p>
    </div>

    <h2>Mes affectations actives (<?= count($affectations) ?>)</h2>
    <table class="table">
        <thead>
            <tr><th>Matériel</th><th>N° série</th><th>Date d'affectation</th></tr>
        </thead>
        <tbody>
            <?php foreach ($affectations as $a): ?>
                <tr>
                    <td><?= h($a['MATERIEL_DESIGNATION']) ?></td>
                    <td><?= h($a['NUMERO_SERIE'] ?: '-') ?></td>
                    <td><?= h($a['DATE_AFFECTATION']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (empty($affectations)): ?>
        <p>Aucun matériel affecté actuellement.</p>
    <?php endif; ?>

    <h2>Mes tickets (<?= count($tickets) ?>)</h2>
    <table class="table">
        <thead>
            <tr><th>Date</th><th>Matériel</th><th>Catégorie</th><th>Statut</th><th>Priorité</th><th>Description</th></tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $t): ?>
                <tr>
                    <td><?= h($t['DATE_DEMANDE']) ?></td>
                    <td><?= h($t['MATERIEL_DESIGNATION'] ?: '-') ?></td>
                    <td><?= h($t['CATEGORIE_LIBELLE'] ?: '-') ?></td>
                    <td><span class="badge badge-primary"><?= h($t['STATUT']) ?></span></td>
                    <td><?= h($t['PRIORITE']) ?></td>
                    <td><?= h($t['DESCRIPTION'] ?: '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (empty($tickets)): ?>
        <p>Aucun ticket ouvert.</p>
    <?php endif; ?>

    <?php if ($maintenances): ?>
        <h2>Mes interventions (<?= count($maintenances) ?>)</h2>
        <table class="table">
            <thead>
                <tr><th>Type</th><th>Matériel</th><th>Date d'intervention</th><th>Coût</th></tr>
            </thead>
            <tbody>
                <?php foreach ($maintenances as $m): ?>
                    <tr>
                        <td><?= h($m['TYPE_LIBELLE']) ?></td>
                        <td><?= h($m['MATERIEL_DESIGNATION'] ?: '-') ?></td>
                        <td><?= h($m['DATE_INTERVENTION'] ?: '-') ?></td>
                        <td><?= h($m['COUT'] ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>