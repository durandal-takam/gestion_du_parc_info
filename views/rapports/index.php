<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Rapports</h1>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card">
            <h3>Taux de disponibilité du parc</h3>
            <div class="number"><?= $stats['kpi_dispo'] ?>%</div>
        </div>
        <div class="stat-card">
            <h3>Temps moyen de résolution</h3>
            <div class="number"><?= $stats['kpi_resolution'] ?> h</div>
        </div>
        <div class="stat-card">
            <h3>Garanties expirées</h3>
            <div class="number"><?= $stats['garanties']['expirees'] ?></div>
        </div>
        <div class="stat-card">
            <h3>Garanties sous 30 jours</h3>
            <div class="number"><?= $stats['garanties']['bientot'] ?></div>
        </div>
        <div class="stat-card">
            <h3>Garanties valides</h3>
            <div class="number"><?= $stats['garanties']['valides'] ?></div>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Matériels par état</h3>
        <table class="table">
            <thead><tr><th>État</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['etat'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['etat'] as $l): ?>
                    <tr>
                        <td><?= h($l['ETAT']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=etat&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=etat&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Matériels par catégorie</h3>
        <table class="table">
            <thead><tr><th>Catégorie</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['categorie'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['categorie'] as $l): ?>
                    <tr>
                        <td><?= h($l['LIBELLE']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=categorie&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=categorie&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Affectations actives par agent</h3>
        <table class="table">
            <thead><tr><th>Agent</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['affectations'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['affectations'] as $l): ?>
                    <tr>
                        <td><?= h($l['PRENOM'] . ' ' . $l['NOM']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=affectations&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=affectations&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Mouvements par type</h3>
        <table class="table">
            <thead><tr><th>Type</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['mouvements'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['mouvements'] as $l): ?>
                    <tr>
                        <td><?= h($l['TYPE_MOUVEMENT']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=mouvements&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=mouvements&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>
        <div class="rapport-carte">
        <h3>Tickets par statut</h3>
        <table class="table">
            <thead><tr><th>Statut</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['tickets'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['tickets'] as $l): ?>
                    <tr>
                        <td><?= h($l['STATUT']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=tickets&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=tickets&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Tickets par priorité</h3>
        <table class="table">
            <thead><tr><th>Priorité</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['priorite'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['priorite'] as $l): ?>
                    <tr>
                        <td><?= h($l['PRIORITE']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=priorite&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=priorite&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Pannes les plus fréquentes (top 5)</h3>
        <table class="table">
            <thead><tr><th>Catégorie de panne</th><th>Nombre</th><th>Répartition</th></tr></thead>
            <tbody>
                <?php $total = 0; foreach ($stats['pannes'] as $l) { $total += (int)$l['NB']; } ?>
                <?php foreach ($stats['pannes'] as $l): ?>
                    <tr>
                        <td><?= h($l['LIBELLE']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td>
                            <div class="barre"><div class="barre-remplie" style="width: <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%;"></div></div>
                            <?= $total ? (int)round($l['NB'] * 100 / $total) : 0 ?>%
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=pannes&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=pannes&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Maintenances par type (avec coûts)</h3>
        <table class="table">
            <thead><tr><th>Type</th><th>Nombre</th><th>Coût total</th></tr></thead>
            <tbody>
                <?php foreach ($stats['maintenances'] as $l): ?>
                    <tr>
                        <td><?= h($l['LIBELLE']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td><strong><?= number_format((float)$l['COUT_TOTAL'], 0, ',', ' ') ?> FCFA</strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=maintenances&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=maintenances&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>

    <div class="rapport-carte">
        <h3>Top 5 des matériels les plus coûteux en maintenance</h3>
        <table class="table">
            <thead><tr><th>Matériel</th><th>Interventions</th><th>Coût total</th></tr></thead>
            <tbody>
                <?php foreach ($stats['couts'] as $l): ?>
                    <tr>
                        <td><?= h($l['DESIGNATION']) ?></td>
                        <td><strong><?= (int)$l['NB'] ?></strong></td>
                        <td><strong><?= number_format((float)$l['COUT_TOTAL'], 0, ',', ' ') ?> FCFA</strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="rapport-actions">
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=couts&format=excel" class="btn btn-small">⤓ Excel</a>
            <a href="<?= BASE_URL ?>/controllers/RapportController.php?action=export&type=couts&format=pdf" class="btn btn-small">⤓ PDF</a>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>