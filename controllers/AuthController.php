<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

$action = $_GET['action'] ?? '';

if ($action === 'login') {
    $login = $_POST['login'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';

    $stmt = $pdo->prepare("
        SELECT u.*, r.LIBELLE as ROLE_LIBELLE
        FROM UTILISATEUR u
        JOIN ROLE r ON u.ID_ROLE = r.ID_ROLE
        WHERE u.LOGIN = ?
    ");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['MOT_DE_PASSE'])) {

        // Vérifier que le compte est actif
        if ($user['STATUT'] !== 'actif') {
            $_SESSION['error'] = 'Votre compte a été désactivé. Contactez l\'administrateur.';
            rediriger(BASE_URL . '/views/auth/login.php');
        }

        // Enregistrer la connexion
        $stmt = $pdo->prepare("UPDATE UTILISATEUR SET DERNIERE_CONNEXION = NOW() WHERE ID_USER = ?");
        $stmt->execute([$user['ID_USER']]);

        $_SESSION['user'] = $user;
        rediriger(BASE_URL . '/index.php');

    } else {
        $_SESSION['error'] = 'Identifiant ou mot de passe incorrect';
        rediriger(BASE_URL . '/views/auth/login.php');
    }

} elseif ($action === 'logout') {
    session_destroy();
    rediriger(BASE_URL . '/views/auth/login.php');
}