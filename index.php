<?php
session_start();
require_once 'includes/functions.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<main class="content">
    <h1>Tableau de bord</h1>
    <p>Bienvenue, <?= h($_SESSION['user']['PRENOM'] . ' ' . $_SESSION['user']['NOM']) ?> !</p>
    <p>Vous êtes connecté en tant que <strong><?= h($_SESSION['user']['ROLE_LIBELLE']) ?></strong>.</p>
</main>

<?php require_once 'includes/footer.php'; ?>