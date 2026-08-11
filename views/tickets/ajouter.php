<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Nouveau ticket</h1>
        <a href="<?= BASE_URL ?>/controllers/DemandeController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/DemandeController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_materiel">Matériel</label>
                <select name="id_materiel" id="id_materiel">
                    <option value="">-- Choisir un matériel --</option>
                    <?php foreach ($materiels as $m): ?>
                        <option value="<?= $m['ID_MATERIEL'] ?>"><?= h($m['DESIGNATION']) ?> (<?= h($m['NUMERO_SERIE']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_categorie_panne">Catégorie de panne</label>
                <select name="id_categorie_panne" id="id_categorie_panne">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['ID_CATEGORIE_PANNE'] ?>"><?= h($c['LIBELLE']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="priorite">Priorité *</label>
                <select name="priorite" id="priorite">
                    <?php foreach (['Basse', 'Moyenne', 'Haute', 'Critique'] as $p): ?>
                        <option value="<?= $p ?>" <?= $p == 'Moyenne' ? 'selected' : '' ?>><?= $p ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description de la panne *</label>
                <textarea name="description" id="description" rows="4" required></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Créer le ticket</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>