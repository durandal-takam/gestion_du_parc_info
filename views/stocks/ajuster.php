<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Ajuster le stock — <?= h($stock['ARTICLE_DESIGNATION']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/StockController.php?action=list" class="btn">← Retour aux stocks</a>
    </div>

    <p>Quantité actuelle : <strong><?= (int)$stock['QUANTITE_DISPO'] ?></strong></p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/controllers/StockController.php?action=store-ajuster&id=<?= $stock['ID_STOCK'] ?>" style="max-width: 500px; margin: auto;">
        <div class="form-group">
            <label>Type de mouvement *</label>
            <select name="type" class="form-control" required>
                <option value="entree">⬇️ Entrée (approvisionnement)</option>
                <option value="sortie">⬆️ Sortie (consommation)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Quantité *</label>
            <input type="number" name="quantite" class="form-control" min="1" required>
        </div>

        <div class="form-group">
            <label>Motif</label>
            <input type="text" name="motif" class="form-control" placeholder="Ex : livraison fournisseur, consommation atelier...">
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer le mouvement</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>