<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Ajouter un matériel</h1>
        <a href="<?= BASE_URL ?>/controllers/MaterielController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/MaterielController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_article">Article</label>
                <select name="id_article" id="id_article">
                    <option value="">-- Choisir un article --</option>
                    <?php foreach ($articles as $a): ?>
                        <option value="<?= $a['ID_ARTICLE'] ?>"><?= h($a['DESIGNATION']) ?> (<?= h($a['MARQUE']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="designation">Désignation *</label>
                <input type="text" name="designation" id="designation" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="numero_serie">N° de série</label>
                <input type="text" name="numero_serie" id="numero_serie">
            </div>
            <div class="form-group">
                <label for="etat">État *</label>
                <select name="etat" id="etat">
                    <option value="disponible" selected>Disponible</option>
                    <option value="affecté">Affecté</option>
                    <option value="en panne">En panne</option>
                    <option value="en maintenance">En maintenance</option>
                    <option value="réformé">Réformé</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date_acquisition">Date d'acquisition</label>
                <input type="date" name="date_acquisition" id="date_acquisition">
            </div>
            <div class="form-group">
                <label for="date_mise_en_service">Date de mise en service</label>
                <input type="date" name="date_mise_en_service" id="date_mise_en_service">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="localisation">Localisation</label>
                <input type="text" name="localisation" id="localisation">
            </div>
            <div class="form-group">
                <label for="garantie">Fin de garantie</label>
                <input type="date" name="garantie" id="garantie">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="configuration">Configuration</label>
                <textarea name="configuration" id="configuration" rows="3"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>