<?php
if (!estConnecte()) {
    rediriger(BASE_URL . '/views/auth/login.php');
}

// Vérifier en base que le compte est toujours actif
$stmt = $pdo->prepare("SELECT STATUT FROM UTILISATEUR WHERE ID_USER = ?");
$stmt->execute([$_SESSION['user']['ID_USER']]);
$statut_db = $stmt->fetchColumn();

if ($statut_db !== 'actif') {
    session_destroy();
    $_SESSION['error'] = 'Votre compte a été désactivé. Contactez l\'administrateur.';
    rediriger(BASE_URL . '/views/auth/login.php');
}
// Déconnexion automatique après 10 minutes d'inactivité
$inactivite_max = 10 * 60;
if (isset($_SESSION['derniere_activite']) && (time() - $_SESSION['derniere_activite']) > $inactivite_max) {
    session_destroy();
    session_start();
    $_SESSION['error'] = 'Session expirée après 10 minutes d\'inactivité.';
    rediriger(BASE_URL . '/views/auth/login.php');
}
$_SESSION['derniere_activite'] = time();
// Pouls de présence : mise à jour à chaque page
$pdo->prepare("UPDATE UTILISATEUR SET DERNIERE_CONNEXION = NOW() WHERE ID_USER = ?")
    ->execute([$_SESSION['user']['ID_USER']]);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/print.css?v=2" media="print">
</head>
<body>
    <div class="app-container">
        <header class="top-bar">
            <div class="logo">
                <h2><?= APP_NAME ?></h2>
            </div>
            <div class="user-info">
                <span><?= h($_SESSION['user']['PRENOM'] . ' ' . $_SESSION['user']['NOM']) ?></span>
                <span class="badge-role"><?= h($_SESSION['user']['ROLE_LIBELLE']) ?></span>
                <a href="<?= BASE_URL ?>/controllers/AuthController.php?action=logout" class="btn-logout">Déconnexion</a>
            </div>
        </header>
        <div class="main-layout">
            