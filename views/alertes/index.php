<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>🔔 Centre d'alertes</h1>
        <p>Les situations qui demandent votre attention</p>
    </div>

    <h2>Stocks faibles (<?= count($stocks_faibles) ?>)</h2>
    <?php if (empty($stocks_faibles)): ?>
        <p>✅ Aucun stock sous le seuil d'alerte.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>Article</th><th>Quantité dispo</th><th>Seuil</th></tr></thead>
            <tbody>
                <?php foreach ($stocks_faibles as $s): ?>
                    <tr>
                        <td><?= h($s['ARTICLE_DESIGNATION']) ?></td>
                        <td><span class="badge badge-primary"><?= $s['QUANTITE_DISPO'] ?></span></td>
                        <td><?= $s['SEUIL_ALERTE'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Garanties expirées (<?= count($garanties_expirees) ?>)</h2>
    <?php if (empty($garanties_expirees)): ?>
        <p>✅ Aucune garantie expirée.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>Matériel</th><th>N° série</th><th>Fin de garantie</th></tr></thead>
            <tbody>
                <?php foreach ($garanties_expirees as $g): ?>
                    <tr>
                        <td><?= h($g['DESIGNATION']) ?></td>
                        <td><?= h($g['NUMERO_SERIE'] ?: '-') ?></td>
                        <td><?= h($g['GARANTIE']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Garanties sous 30 jours (<?= count($garanties_bientot) ?>)</h2>
    <?php if (empty($garanties_bientot)): ?>
        <p>✅ Aucune garantie ne se termine dans les 30 jours.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>Matériel</th><th>N° série</th><th>Fin de garantie</th></tr></thead>
            <tbody>
                <?php foreach ($garanties_bientot as $g): ?>
                    <tr>
                        <td><?= h($g['DESIGNATION']) ?></td>
                        <td><?= h($g['NUMERO_SERIE'] ?: '-') ?></td>
                        <td><?= h($g['GARANTIE']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Tickets urgents (<?= count($tickets_urgents) ?>)</h2>
    <?php if (empty($tickets_urgents)): ?>
        <p>✅ Aucun ticket Critique ou Haute priorité ouvert.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>Date</th><th>Priorité</th><th>Demandeur</th><th>Matériel</th><th>Statut</th></tr></thead>
            <tbody>
                <?php foreach ($tickets_urgents as $t): ?>
                    <tr>
                        <td><?= h($t['DATE_DEMANDE']) ?></td>
                        <td><span class="badge badge-primary"><?= h($t['PRIORITE']) ?></span></td>
                        <td><?= h($t['PRENOM'] . ' ' . $t['NOM']) ?></td>
                        <td><?= h($t['MATERIEL_DESIGNATION'] ?: '-') ?></td>
                        <td><?= h($t['STATUT']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Matériels en panne (<?= count($en_panne) ?>)</h2>
    <?php if (empty($en_panne)): ?>
        <p>✅ Aucun matériel en panne.</p>
    <?php else: ?>
        <table class="table">
            <thead><tr><th>Matériel</th><th>N° série</th></tr></thead>
            <tbody>
                <?php foreach ($en_panne as $m): ?>
                    <tr>
                        <td><?= h($m['DESIGNATION']) ?></td>
                        <td><?= h($m['NUMERO_SERIE'] ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>