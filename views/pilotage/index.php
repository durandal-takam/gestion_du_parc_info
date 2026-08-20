<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Tableau de bord Direction</h1>
        <p>Indicateurs de pilotage du parc informatique</p>
    </div>

    <div class="form-row">
        <div class="form-group" style="flex: 1;">
            <div style="background: #eef3fa; border-radius: 6px; padding: 15px; text-align: center;">
                <strong style="font-size: 26px;"><?= $kpi_dispo ?>%</strong>
                <p>Taux de disponibilité des équipements</p>
            </div>
        </div>
        <div class="form-group" style="flex: 1;">
            <div style="background: #eef3fa; border-radius: 6px; padding: 15px; text-align: center;">
                <strong style="font-size: 26px;"><?= $kpi_resol ?> h</strong>
                <p>Temps moyen de résolution (panne → intervention)</p>
            </div>
        </div>
        <div class="form-group" style="flex: 1;">
            <div style="background: #eef3fa; border-radius: 6px; padding: 15px; text-align: center;">
                <strong style="font-size: 26px;"><?= $garanties['expirees'] + $garanties['bientot'] ?></strong>
                <p>Garanties à risque (expirées + < 30 jours)</p>
            </div>
        </div>
    </div>

    <h2>Matériels par état</h2>
    <?php $max_etat = max(array_column($par_etat, 'NB') ?: [1]); ?>
    <?php foreach ($par_etat as $e): ?>
        <p>
            <?= h($e['ETAT']) ?> (<?= $e['NB'] ?>)<br>
            <div style="background: #eef; border-radius: 3px; overflow: hidden;">
                <div style="background: #1e3a5f; height: 18px; width: <?= round($e['NB'] * 100 / $max_etat) ?>%;"></div>
            </div>
        </p>
    <?php endforeach; ?>

    <h2>Tickets par statut</h2>
    <?php $max_statut = max(array_column($par_statut, 'NB') ?: [1]); ?>
    <?php foreach ($par_statut as $s): ?>
        <p>
            <?= h($s['STATUT']) ?> (<?= $s['NB'] ?>)<br>
            <div style="background: #eef; border-radius: 3px; overflow: hidden;">
                <div style="background: #1e3a5f; height: 18px; width: <?= round($s['NB'] * 100 / $max_statut) ?>%;"></div>
            </div>
        </p>
    <?php endforeach; ?>

    <h2>Pannes les plus fréquentes</h2>
    <?php $max_panne = max(array_column($pannes, 'NB') ?: [1]); ?>
    <?php foreach ($pannes as $p): ?>
        <p>
            <?= h($p['LIBELLE']) ?> (<?= $p['NB'] ?>)<br>
            <div style="background: #eef; border-radius: 3px; overflow: hidden;">
                <div style="background: #1e3a5f; height: 18px; width: <?= round($p['NB'] * 100 / $max_panne) ?>%;"></div>
            </div>
        </p>
    <?php endforeach; ?>

    <h2>Affectations actives par agent</h2>
    <table class="table">
        <thead><tr><th>Agent</th><th>Matériels affectés</th></tr></thead>
        <tbody>
            <?php foreach ($par_agent as $a): ?>
                <tr>
                    <td><?= h($a['PRENOM'] . ' ' . $a['NOM']) ?></td>
                    <td><?= $a['NB'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Maintenances par type (coût)</h2>
    <table class="table">
        <thead><tr><th>Type</th><th>Nombre</th><th>Coût total</th></tr></thead>
        <tbody>
            <?php foreach ($par_type as $t): ?>
                <tr>
                    <td><?= h($t['LIBELLE']) ?></td>
                    <td><?= $t['NB'] ?></td>
                    <td><?= number_format((float)$t['COUT_TOTAL'], 0, ',', ' ') ?> FCFA</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Top 5 équipements les plus coûteux</h2>
    <table class="table">
        <thead><tr><th>Matériel</th><th>Interventions</th><th>Coût total</th></tr></thead>
        <tbody>
            <?php foreach ($top5 as $c): ?>
                <tr>
                    <td><?= h($c['DESIGNATION']) ?></td>
                    <td><?= $c['NB'] ?></td>
                    <td><?= number_format((float)$c['COUT_TOTAL'], 0, ',', ' ') ?> FCFA</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>