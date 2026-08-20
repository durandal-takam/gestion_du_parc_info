<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Utilisateur.php';

// Vérifier que l'utilisateur a le droit d'accéder
if (!aRole(ROLE_SUPER_ADMIN) && !aRole(ROLE_ADMIN)) {
    $_SESSION['error'] = "Accès refusé";
    rediriger(BASE_URL . '/index.php');
}

$action = $_GET['action'] ?? 'list';

switch ($action) {

    case 'list':
        $utilisateurs = Utilisateur::getAll($pdo);
        include VIEWS_PATH . 'utilisateurs/liste.php';
        break;

    case 'voir':
        $utilisateur = Utilisateur::getByIdWithRole($pdo, $_GET['id'] ?? 0);
        include VIEWS_PATH . 'utilisateurs/voir.php';
        break;
    case 'ajouter':
        $roles = $pdo->query("SELECT * FROM ROLE")->fetchAll();
        include VIEWS_PATH . 'utilisateurs/ajouter.php';
        break;

    case 'store':
        if (Utilisateur::loginExiste($pdo, $_POST['login'])) {
            $_SESSION['error'] = "Ce login existe déjà";
            rediriger(BASE_URL . '/controllers/UtilisateurController.php?action=ajouter');
        }
        Utilisateur::create($pdo, $_POST);
        journaliser($pdo, 'utilisateur', 'creation', 'Création de l\'utilisateur ' . ($_POST['prenom'] ?? '') . ' ' . ($_POST['nom'] ?? ''));
        $_SESSION['success'] = "Utilisateur ajouté avec succès";
        rediriger(BASE_URL . '/controllers/UtilisateurController.php?action=list');
        break;

    case 'modifier':
        $id = $_GET['id'];
        $utilisateur = Utilisateur::getById($pdo, $id);
        $roles = $pdo->query("SELECT * FROM ROLE")->fetchAll();
        include VIEWS_PATH . 'utilisateurs/modifier.php';
        break;

    case 'update':
        $id = $_POST['id_user'];
        if (!empty($_POST['login'])) {
            if (Utilisateur::loginExiste($pdo, $_POST['login'], $id)) {
                $_SESSION['error'] = "Ce login est déjà utilisé";
                rediriger(BASE_URL . "/controllers/UtilisateurController.php?action=modifier&id=$id");
            }
        }
        Utilisateur::update($pdo, $id, $_POST);
        journaliser($pdo, 'utilisateur', 'modification', 'Modification de l\'utilisateur ID ' . $id);
        $_SESSION['success'] = "Utilisateur modifié avec succès";
        rediriger(BASE_URL . '/controllers/UtilisateurController.php?action=list');
        break;

    case 'supprimer':
        $id = $_GET['id'];
        if ($id == $_SESSION['user']['ID_USER']) {
            $_SESSION['error'] = "Vous ne pouvez pas vous supprimer vous-même";
        } else {
            $utilisateurASupprimer = Utilisateur::getById($pdo, $id);
            Utilisateur::delete($pdo, $id);
            if ($utilisateurASupprimer) {
                journaliser($pdo, 'utilisateur', 'suppression', 'Suppression de l\'utilisateur ' . $utilisateurASupprimer['PRENOM'] . ' ' . $utilisateurASupprimer['NOM']);
            }
            $_SESSION['success'] = "Utilisateur supprimé";
        }
        rediriger(BASE_URL . '/controllers/UtilisateurController.php?action=list');
        break;
}