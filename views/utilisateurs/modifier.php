<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier l'utilisateur : <?= h($utilisateur['PRENOM'] . ' ' . $utilisateur['NOM']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=update" method="POST" class="form">
        <input type="hidden" name="id_user" value="<?= h($utilisateur['ID_USER']) ?>">

        <div class="form-row">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" value="<?= h($utilisateur['NOM']) ?>" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom" value="<?= h($utilisateur['PRENOM']) ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" value="<?= h($utilisateur['EMAIL']) ?>" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone" value="<?= h($utilisateur['TELEPHONE']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="login">Login *</label>
                <input type="text" name="login" id="login" value="<?= h($utilisateur['LOGIN']) ?>" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Nouveau mot de passe (laisser vide pour conserver)</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_role">Rôle *</label>
                <select name="id_role" id="id_role" required>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['ID_ROLE'] ?>" <?= $r['ID_ROLE'] == $utilisateur['ID_ROLE'] ? 'selected' : '' ?>>
                            <?= h($r['LIBELLE']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="statut">Statut *</label>
                <select name="statut" id="statut">
                    <option value="actif" <?= $utilisateur['STATUT'] == 'actif' ? 'selected' : '' ?>>Actif</option>
                    <option value="inactif" <?= $utilisateur['STATUT'] == 'inactif' ? 'selected' : '' ?>>Inactif</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>