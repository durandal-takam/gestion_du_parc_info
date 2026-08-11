<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Ajouter un utilisateur</h1>
        <a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="telephone">Téléphone</label>
                <input type="text" name="telephone" id="telephone">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="login">Login *</label>
                <input type="text" name="login" id="login" required>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe *</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_role">Rôle *</label>
                <select name="id_role" id="id_role" required>
                    <option value="">-- Choisir un rôle --</option>
                    <?php foreach ($roles as $r): ?>
                        <option value="<?= $r['ID_ROLE'] ?>"><?= h($r['LIBELLE']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="statut">Statut *</label>
                <select name="statut" id="statut">
                    <option value="actif">Actif</option>
                    <option value="inactif">Inactif</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>