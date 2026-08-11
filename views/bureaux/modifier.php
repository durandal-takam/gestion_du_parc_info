<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier le bureau</h1>
        <a href="<?= BASE_URL ?>/controllers/BureauController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/BureauController.php?action=update&id=<?= $bureau['ID_BUREAU'] ?>" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_direction">Direction *</label>
                <select name="id_direction" id="id_direction" required>
                    <option value="">-- Choisir une direction --</option>
                    <?php foreach ($directions as $d): ?>
                        <option value="<?= $d['ID_DIRECTION'] ?>" <?= $bureau['ID_DIRECTION'] == $d['ID_DIRECTION'] ? 'selected' : '' ?>>
                            <?= h($d['NOM_DIRECTION']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nom_bureau">Nom du bureau *</label>
                <input type="text" name="nom_bureau" id="nom_bureau" value="<?= h($bureau['NOM_BUREAU']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="localisation">Localisation</label>
                <input type="text" name="localisation" id="localisation" value="<?= h($bureau['LOCALISATION']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>