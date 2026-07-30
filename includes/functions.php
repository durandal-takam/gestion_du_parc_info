<?php
// includes/functions.php - Fonctions utilitaires

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