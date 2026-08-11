<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Ajouter une direction</h1>
        <a href="<?= BASE_URL ?>/controllers/DirectionController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/DirectionController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="nom_direction">Nom *</label>
                <input type="text" name="nom_direction" id="nom_direction" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>