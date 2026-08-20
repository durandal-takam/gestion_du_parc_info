<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header no-print">
        <h1>Fiche d'intervention</h1>
        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=list" class="btn">← Retour à la liste</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Imprimer</button>
    </div>

    <div class="fiche-papier">
        <div class="fiche-entete">
            <h2><?= APP_NAME ?></h2>
            <h3>FICHE D'INTERVENTION</h3>
            <p><strong>N° :</strong> <?= h($fiche['NUMERO_FICHE']) ?></p>
            <p><strong>Date :</strong> <?= h($fiche['DATE_FICHE']) ?></p>
        </div>

        <table class="table">
            <tr>
                <th>Matériel concerné</th>
                <td><?= h($fiche['MATERIEL_DESIGNATION'] ?? '-') ?> (N° série : <?= h($fiche['NUMERO_SERIE'] ?? '-') ?>)</td>
            </tr>
            <tr>
                <th>Description de la panne</th>
                <td><?= h($fiche['PANNE_DESCRIPTION'] ?? '-') ?></td>
            </tr>
            <tr>
                <th>Date de la panne</th>
                <td><?= h($fiche['DATE_PANNE']) ?></td>
            </tr>
            <tr>
                <th>Travaux effectués</th>
                <td><?= h($fiche['TRAVAUX_EFFECTUES']) ?></td>
            </tr>
            <tr>
                <th>Observations</th>
                <td><?= h($fiche['OBSERVATIONS'] ?? '-') ?></td>
            </tr>
        </table>

        <div class="fiche-signatures">
            <div class="signature-block">
                <p><strong>Le technicien</strong></p>
                <p><?= h($fiche['PRENOM'] . ' ' . $fiche['NOM']) ?></p>
                <p class="signature-zone"> <?php if ($fiche['SIGNATURE_TECHNICIEN']): ?>
                    <img src="data:image/png;base64,<?= h($fiche['SIGNATURE_TECHNICIEN']) ?>" alt="Signature" style="border: 1px solid #999; background: #fff; max-width: 200px; max-height: 100px;">
                <?php else: ?>
                    -
                <?php endif; ?></p>
            </div>
            <div class="signature-block">
                <p><strong>Le responsable</strong></p>
                <p><?= h($fiche['NOM_RESPONSABLE']) ?></p>
                <p class="signature-zone"> <?php if ($fiche['SIGNATURE_RESPONSABLE']): ?>
                    <img src="data:image/png;base64,<?= h($fiche['SIGNATURE_RESPONSABLE']) ?>" alt="Signature" style="border: 1px solid #999; background: #fff; max-width: 200px; max-height: 100px;">
                <?php else: ?>
                    -
                <?php endif; ?></p>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>