<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier la catégorie</h1>
        <a href="<?= BASE_URL ?>/controllers/CategorieMaterielController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/CategorieMaterielController.php?action=update&id=<?= $categorie['ID_CATEGORIE'] ?>" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="libelle">Libellé *</label>
                <input type="text" name="libelle" id="libelle" value="<?= h($categorie['LIBELLE']) ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" value="<?= h($categorie['DESCRIPTION']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>