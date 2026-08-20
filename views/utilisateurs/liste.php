<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Gestion des utilisateurs</h1>
        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=ajouter" class="btn btn-primary">+ Ajouter un utilisateur</a>
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
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Login</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateurs as $u): ?>
                <tr>
                    <td><?= h($u['ID_USER']) ?></td>
                    <td><?= h($u['NOM']) ?></td>
                    <td><?= h($u['PRENOM']) ?></td>
                    <td><?= h($u['EMAIL']) ?></td>
                    <td><?= h($u['LOGIN']) ?></td>
                    <td><?= h($u['ROLE_LIBELLE']) ?></td>
                      <td>
                        <span class="badge <?= $u['STATUT'] == 'actif' ? 'badge-success' : 'badge-danger' ?>">
                            <?= h($u['STATUT']) ?>
                        </span>
<?php if (!empty($u['EN_LIGNE'])): ?>
    <span class="badge badge-primary">🟢 En ligne</span>
<?php else: ?>
    <span class="badge badge-muted">⚪ Hors ligne</span>
<?php endif; ?>                           
                        
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=voir&id=<?= $u['ID_USER'] ?>" class="btn btn-small">👁️ Voir</a>
                        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=modifier&id=<?= $u['ID_USER'] ?>" class="btn btn-small">✏️ Modifier</a>
                        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=supprimer&id=<?= $u['ID_USER'] ?>" class="btn btn-small btn-danger" onclick="return confirm('Supprimer cet utilisateur ?')">🗑️ Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>