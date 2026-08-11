<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Articles</h1>
        <a href="<?= BASE_URL ?>/controllers/ArticleController.php?action=ajouter" class="btn btn-primary">+ Ajouter un article</a>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= h($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Désignation</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Catégorie</th>
                <th>Fournisseur</th>
                <th>Prix unitaire</th>
                <th>Stock dispo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $a): ?>
                <tr>
                    <td><?= h($a['ID_ARTICLE']) ?></td>
                    <td><?= h($a['DESIGNATION']) ?></td>
                    <td><?= h($a['MARQUE']) ?></td>
                    <td><?= h($a['MODELE']) ?></td>
                    <td><?= h($a['CATEGORIE_LIBELLE'] ?? '-') ?></td>
                    <td><?= h($a['FOURNISSEUR_NOM'] ?? '-') ?></td>
                    <td><?= number_format($a['PRIX_UNITAIRE'], 0, ',', ' ') ?> FCFA</td>
                    <td><?= h($a['QUANTITE_DISPO']) ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/ArticleController.php?action=modifier&id=<?= $a['ID_ARTICLE'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/ArticleController.php?action=supprimer&id=<?= $a['ID_ARTICLE'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cet article ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>