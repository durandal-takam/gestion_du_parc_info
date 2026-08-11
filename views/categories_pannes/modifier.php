<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier la catégorie de panne</h1>
        <a href="<?= BASE_URL ?>/controllers/CategoriePanneController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/CategoriePanneController.php?action=update&id=<?= $categorie['ID_CATEGORIE_PANNE'] ?>" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="libelle">Libellé *</label>
                <input type="text" name="libelle" id="libelle" value="<?= h($categorie['LIBELLE']) ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"><?= h($categorie['DESCRIPTION']) ?></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>