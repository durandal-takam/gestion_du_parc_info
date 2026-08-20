<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Nouvelle fiche d'intervention</h1>
        <a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=list" class="btn">← Retour</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form id="form-fiche" action="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=store" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Maintenance concernée *</label>
            <select name="id_maintenance" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($maintenances as $m): ?>
                    <option value="<?= $m['ID_MAINTENANCE'] ?>">
                        #<?= $m['ID_MAINTENANCE'] ?> - <?= h($m['MATERIEL_DESIGNATION'] ?? 'Matériel inconnu') ?> (n° série <?= h($m['NUMERO_SERIE'] ?? '-') ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <small>Numéro de fiche et date générés automatiquement (FI-2026-0001, date du jour).</small>
            <?php if (empty($maintenances)): ?>
                <small style="color: #c0392b;">Aucune maintenance sans fiche. Créez d'abord une maintenance.</small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Technicien *</label>
            <select name="id_technicien" required>
                <option value="">-- Choisir --</option>
                <?php foreach ($techniciens as $t): ?>
                    <option value="<?= $t['ID_USER'] ?>"><?= h($t['PRENOM'] . ' ' . $t['NOM']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Nom du responsable *</label>
            <input type="text" name="nom_responsable" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Travaux effectués *</label>
            <textarea name="travaux_effectues" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label>Observations</label>
            <textarea name="observations" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label>Version numérisée (PDF, JPG, PNG - 5 Mo max)</label>
            <input type="file" name="fichier" accept=".pdf,.jpg,.jpeg,.png" class="form-control">
        </div>

        <div class="form-group">
            <label>Signature du technicien</label>
            <canvas id="canvas-technicien" width="400" height="150" style="border: 1px solid #999; background: #fff; touch-action: none; cursor: crosshair; max-width: 100%;"></canvas>
            <div style="margin-top: 5px;">
                <button type="button" id="btn-effacer-canvas-technicien" class="btn btn-small">🧽 Effacer</button>
            </div>
            <input type="hidden" name="signature_technicien" id="signature-technicien">
            <small>Signez dans le cadre ci-dessus (souris ou doigt).</small>
        </div>

        <div class="form-group">
            <label>Signature du responsable</label>
            <canvas id="canvas-responsable" width="400" height="150" style="border: 1px solid #999; background: #fff; touch-action: none; cursor: crosshair; max-width: 100%;"></canvas>
            <div style="margin-top: 5px;">
                <button type="button" id="btn-effacer-canvas-responsable" class="btn btn-small">🧽 Effacer</button>
            </div>
            <input type="hidden" name="signature_responsable" id="signature-responsable">
            <small>Signez dans le cadre ci-dessus (souris ou doigt).</small>
        </div>

        <button type="submit" class="btn btn-primary">Créer la fiche</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>


<script>
    initSignaturePad('canvas-technicien', 'signature-technicien');
    initSignaturePad('canvas-responsable', 'signature-responsable');
</script>