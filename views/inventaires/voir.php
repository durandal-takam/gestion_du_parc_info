<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header no-print">
        <h1>Procès-verbal d'inventaire</h1>
        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=list" class="btn">← Retour</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer</button>
    </div>

    <div class="fiche-papier">
        <div class="fiche-entete">
            <h2><?= APP_NAME ?></h2>
            <h3>PROCÈS-VERBAL D'INVENTAIRE</h3>
            <p><strong>N° :</strong> <?= h($inventaire['NUMERO_INVENTAIRE']) ?></p>
            <p><strong>Date :</strong> <?= h($inventaire['DATE_INVENTAIRE']) ?> — <strong>Agent :</strong> <?= h($inventaire['PRENOM'] . ' ' . $inventaire['NOM']) ?></p>
        </div>

        <?php $classe_etat = ['disponible' => 'badge-success', 'affecté' => 'badge-primary', 'en maintenance' => 'badge-warning', 'hors service' => 'badge-danger']; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Matériel</th>
                    <th>N° série</th>
                    <th>État constaté</th>
                    <th>Remarque</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $d): ?>
                    <tr>
                        <td><?= h($d['MATERIEL_DESIGNATION']) ?></td>
                        <td><?= h($d['NUMERO_SERIE'] ?: '-') ?></td>
                        <td><span class="badge <?= $classe_etat[$d['ETAT_CONSTATE']] ?? 'badge-muted' ?>"><?= h($d['ETAT_CONSTATE']) ?></span></td>
                        <td><?= h($d['REMARQUE'] ?: '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="margin-top: 16px;"><strong>Observation :</strong> <?= h($inventaire['OBSERVATION'] ?: '-') ?></p>

        <div class="fiche-signatures">
            <div class="signature-block">
                <p><strong>L'agent recenseur</strong></p>
                <p><?= h($inventaire['PRENOM'] . ' ' . $inventaire['NOM']) ?></p>
                <p class="signature-zone"></p>
            </div>
            <div class="signature-block">
                <p><strong>Le responsable</strong></p>
                <p class="signature-zone"></p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>