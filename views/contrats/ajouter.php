<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Ajouter un contrat</h1>
        <a href="<?= BASE_URL ?>/controllers/ContratController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/ContratController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_prestataire">Prestataire *</label>
                <select name="id_prestataire" id="id_prestataire" required>
                    <option value="">-- Choisir un prestataire --</option>
                    <?php foreach ($prestataires as $p): ?>
                        <option value="<?= $p['ID_PRESTATAIRE'] ?>"><?= h($p['NOM']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="reference">Référence *</label>
                <input type="text" name="reference" id="reference" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date_debut">Date de début *</label>
                <input type="date" name="date_debut" id="date_debut" required>
            </div>
            <div class="form-group">
                <label for="date_fin">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="montant">Montant</label>
                <input type="number" step="0.01" name="montant" id="montant">
            </div>
            <div class="form-group">
                <label for="observation">Observation</label>
                <input type="text" name="observation" id="observation">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>