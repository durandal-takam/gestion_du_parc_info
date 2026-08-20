<?php
// includes/functions.php - Fonctions utilitaires
date_default_timezone_set('Africa/Lagos');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/constants.php';

// Vérifier si l'utilisateur est connecté
function estConnecte() {
    return isset($_SESSION['user']);
}

// Vérifier si l'utilisateur a un rôle spécifique
function aRole($role_id) {
    return estConnecte() && $_SESSION['user']['ID_ROLE'] == $role_id;
}

// Rediriger vers une page
function rediriger($url) {
    header("Location: $url");
    exit();
}

// Sécuriser une chaîne (affichage)
function h($texte) {
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}
// Journaliser une action importante
function journaliser($pdo, $module, $action, $description) {
    $stmt = $pdo->prepare("
        INSERT INTO JOURNAL (ID_USER, MODULE, ACTION, DESCRIPTION, IP_ADRESSE, DATE_ACTION)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $stmt->execute([
        $_SESSION['user']['ID_USER'] ?? null,
        $module, $action, $description,
        $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
}