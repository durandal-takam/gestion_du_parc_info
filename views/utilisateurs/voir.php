<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Fiche utilisateur</h1>
        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <?php if (!$utilisateur): ?>
        <div class="alert alert-error">Utilisateur introuvable.</div>
    <?php else: ?>
        <table class="table" style="max-width: 600px;">
            <tr><th>Nom</th><td><?= h($utilisateur['NOM']) ?></td></tr>
            <tr><th>Prénom</th><td><?= h($utilisateur['PRENOM']) ?></td></tr>
            <tr><th>Login</th><td><?= h($utilisateur['LOGIN']) ?></td></tr>
            <tr><th>Email</th><td><?= h($utilisateur['EMAIL']) ?></td></tr>
            <tr><th>Téléphone</th><td><?= h($utilisateur['TELEPHONE'] ?: '-') ?></td></tr>
            <tr><th>Rôle</th><td><?= h($utilisateur['ROLE_LIBELLE']) ?></td></tr>
            <tr>
                <th>Statut</th>
                <td>
                    <span class="badge <?= $utilisateur['STATUT'] == 'actif' ? 'badge-success' : 'badge-danger' ?>">
                        <?= h($utilisateur['STATUT']) ?>
                    </span>
                </td>
            </tr>
            <tr>
                <th>Présence</th>
                <td>
                    <?php if ($utilisateur['DERNIERE_CONNEXION'] >= date('Y-m-d H:i:s', time() - 300)): ?>
                        <span class="badge badge-primary">🟢 En ligne</span>
                    <?php else: ?>
                        <span class="badge badge-muted">⚪ Hors ligne</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr><th>Dernière connexion</th><td><?= h($utilisateur['DERNIERE_CONNEXION'] ?: '-') ?></td></tr>
        </table>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>