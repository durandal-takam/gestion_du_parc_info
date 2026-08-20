<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Role.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $roles = Role::getAll($pdo);
        require VIEWS_PATH . 'roles/liste.php';
        break;

    case 'ajouter':
        require VIEWS_PATH . 'roles/ajouter.php';
        break;

    case 'store':
        Role::create($pdo, [
            'libelle'     => $_POST['libelle'] ?? '',
            'description' => $_POST['description'] ?? '',
        ]);
        journaliser($pdo, 'role', 'creation', 'Création du rôle "' . ($_POST['libelle'] ?? '') . '"');
        $_SESSION['success'] = 'Rôle ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/RoleController.php?action=list');
        break;

    case 'modifier':
        $role = Role::getById($pdo, $_GET['id'] ?? 0);
        if (!$role) {
            $_SESSION['error'] = 'Rôle introuvable.';
            rediriger(BASE_URL . '/controllers/RoleController.php?action=list');
        }
        require VIEWS_PATH . 'roles/modifier.php';
        break;

    case 'update':
        Role::update($pdo, $_GET['id'] ?? 0, [
            'libelle'     => $_POST['libelle'] ?? '',
            'description' => $_POST['description'] ?? '',
        ]);
        journaliser($pdo, 'role', 'modification', 'Modification du rôle ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Rôle modifié avec succès.';
        rediriger(BASE_URL . '/controllers/RoleController.php?action=list');
        break;

    case 'supprimer':
        // Garde : un rôle utilisé par des utilisateurs ne peut pas être supprimé
        $nb = Role::countUtilisateurs($pdo, $_GET['id'] ?? 0);
        if ($nb > 0) {
            $_SESSION['error'] = "Impossible de supprimer ce rôle : $nb utilisateur(s) l'utilisent.";
        } else {
            $roleASupprimer = Role::getById($pdo, $_GET['id'] ?? 0);
            Role::delete($pdo, $_GET['id'] ?? 0);
            if ($roleASupprimer) {
                journaliser($pdo, 'role', 'suppression', 'Suppression du rôle "' . $roleASupprimer['LIBELLE'] . '"');
            }
            $_SESSION['success'] = 'Rôle supprimé avec succès.';
        }
        rediriger(BASE_URL . '/controllers/RoleController.php?action=list');
        break;
}