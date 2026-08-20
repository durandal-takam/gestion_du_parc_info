<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier la fiche <?= h($fiche['NUMERO_FICHE']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=update&id=<?= $fiche['ID_FICHE'] ?>" enctype="multipart/form-data" style="max-width: 700px; margin: auto;">
        <div class="form-group">
            <label>N° de la fiche</label>
            <input type="text" value="<?= h($fiche['NUMERO_FICHE']) ?>" class="form-control" disabled>
        </div>

        <div class="form-group">
            <label>Maintenance concernée *</label>
            <select name="id_maintenance" class="form-control" required>
                <option value="">-- Choisir une maintenance --</option>
                <?php foreach ($maintenances as $m): ?>
                    <option value="<?= $m['ID_MAINTENANCE'] ?>" <?= $m['ID_MAINTENANCE'] == $fiche['ID_MAINTENANCE'] ? 'selected' : '' ?>>
                        #<?= $m['ID_MAINTENANCE'] ?> — <?= h($m['MATERIEL_DESIGNATION'] ?? 'Matériel ?') ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Technicien *</label>
            <select name="id_technicien" class="form-control" required>
                <option value="">-- Choisir un technicien --</option>
                <?php foreach ($techniciens as $t): ?>
                    <option value="<?= $t['ID_USER'] ?>" <?= $t['ID_USER'] == $fiche['ID_TECHNICIEN'] ? 'selected' : '' ?>>
                        <?= h($t['PRENOM'] . ' ' . $t['NOM']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nom du responsable *</label>
            <input type="text" name="nom_responsable" class="form-control" value="<?= h($fiche['NOM_RESPONSABLE']) ?>" required>
        </div>

        <div class="form-group">
            <label>Travaux effectués *</label>
            <textarea name="travaux_effectues" class="form-control" rows="4" required><?= h($fiche['TRAVAUX_EFFECTUES']) ?></textarea>
        </div>

        <div class="form-group">
            <label>Observations</label>
            <textarea name="observations" class="form-control" rows="3"><?= h($fiche['OBSERVATIONS'] ?: '') ?></textarea>
        </div>

        <div class="form-group">
            <label>Signature du technicien</label>
            <?php if ($fiche['SIGNATURE_TECHNICIEN']): ?>
                <p>Signature actuelle :</p>
                <img src="data:image/png;base64,<?= h($fiche['SIGNATURE_TECHNICIEN']) ?>" alt="Signature" style="border: 1px solid #999; background: #fff; max-width: 250px; max-height: 120px;">
                <p><small>Dessinez ci-dessous pour la remplacer :</small></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Signature du responsable</label>
            <?php if ($fiche['SIGNATURE_RESPONSABLE']): ?>
                <p>Signature actuelle :</p>
                <img src="data:image/png;base64,<?= h($fiche['SIGNATURE_RESPONSABLE']) ?>" alt="Signature" style="border: 1px solid #999; background: #fff; max-width: 250px; max-height: 120px;">
                <p><small>Dessinez ci-dessous pour la remplacer :</small></p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Version numérisée (PDF, JPG, PNG — 5 Mo max)</label>
            <?php if ($fiche['FICHIER_NUMERISE']): ?>
                <p>Fichier actuel : <a href="<?= BASE_URL ?>/uploads/fiches/<?= h($fiche['FICHIER_NUMERISE']) ?>" target="_blank">📎 <?= h($fiche['FICHIER_NUMERISE']) ?></a></p>
                <small>Choisissez un nouveau fichier pour le remplacer.</small>
            <?php endif; ?>
            <input type="file" name="fichier" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>

<script>
    initSignaturePad('canvas-technicien', 'signature-technicien');
    initSignaturePad('canvas-responsable', 'signature-responsable');
</script>