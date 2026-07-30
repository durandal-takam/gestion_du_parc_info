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