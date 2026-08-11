<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier le fournisseur</h1>
        <a href="<?= BASE_URL ?>/controllers/FournisseurController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/controllers/FournisseurController.php?action=update&id=<?= $fournisseur['ID_FOURNISSEUR'] ?>" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" value="<?= h($fournisseur['NOM']) ?>" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="<?= h($fournisseur['TELEPHONE']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= h($fournisseur['EMAIL']) ?>">
            </div>
            <div class="form-group">
                <label for="adresse">Adresse</label>
                <input type="text" name="adresse" id="adresse" value="<?= h($fournisseur['ADRESSE']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php' ; ?>