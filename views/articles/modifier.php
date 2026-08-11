<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier l'article</h1>
        <a href="<?= BASE_URL ?>/controllers/ArticleController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/ArticleController.php?action=update&id=<?= $article['ID_ARTICLE'] ?>" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="designation">Désignation *</label>
                <input type="text" name="designation" id="designation" value="<?= h($article['DESIGNATION']) ?>" required>
            </div>
            <div class="form-group">
                <label for="marque">Marque</label>
                <input type="text" name="marque" id="marque" value="<?= h($article['MARQUE']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="modele">Modèle</label>
                <input type="text" name="modele" id="modele" value="<?= h($article['MODELE']) ?>">
            </div>
            <div class="form-group">
                <label for="prix_unitaire">Prix unitaire</label>
                <input type="number" step="0.01" name="prix_unitaire" id="prix_unitaire" value="<?= h($article['PRIX_UNITAIRE']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_categorie">Catégorie</label>
                <select name="id_categorie" id="id_categorie">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['ID_CATEGORIE'] ?>" <?= $article['ID_CATEGORIE'] == $c['ID_CATEGORIE'] ? 'selected' : '' ?>>
                            <?= h($c['LIBELLE']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_fournisseur">Fournisseur</label>
                <select name="id_fournisseur" id="id_fournisseur">
                    <option value="">-- Choisir un fournisseur --</option>
                    <?php foreach ($fournisseurs as $f): ?>
                        <option value="<?= $f['ID_FOURNISSEUR'] ?>" <?= $article['ID_FOURNISSEUR'] == $f['ID_FOURNISSEUR'] ? 'selected' : '' ?>>
                            <?= h($f['NOM']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="<?= h($article['DESCRIPTION']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>