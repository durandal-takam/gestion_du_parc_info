<?php
session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
 require_once __DIR__ . '/../../includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        <p class="sous-titre">Gestion du Parc Informatique</p>
         
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/controllers/AuthController.php?action=login" method="POST">
            <div class="form-group">
                <label for="login">Identifiant</label>
                <input type="text" name="login" id="login" required autofocus>
            </div>
            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>