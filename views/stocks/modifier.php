<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Seuil d'alerte — <?= h($stock['ARTICLE_DESIGNATION']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/StockController.php?action=list" class="btn">← Retour aux stocks</a>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/controllers/StockController.php?action=update&id=<?= $stock['ID_STOCK'] ?>" style="max-width: 500px; margin: auto;">
        <div class="form-group">
            <label>Seuil d'alerte *</label>
            <input type="number" name="seuil_alerte" class="form-control" min="0" value="<?= (int)$stock['SEUIL_ALERTE'] ?>" required>
            <small>En dessous de ce seuil, l'article apparaît en ⚠️ alerte dans la liste.</small>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer le seuil</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>