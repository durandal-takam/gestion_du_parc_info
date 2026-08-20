<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Fournisseur.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $fournisseurs = Fournisseur::getAll($pdo);
        require VIEWS_PATH . 'fournisseurs/liste.php';
        break;

    case 'ajouter':
        require VIEWS_PATH . 'fournisseurs/ajouter.php';
        break;

    case 'store':
        if (empty($_POST['nom'] ?? '')) {
            $_SESSION['error'] = 'Le nom est obligatoire.';
            rediriger(BASE_URL . '/controllers/FournisseurController.php?action=ajouter');
        }
        if (Fournisseur::emailExiste($pdo, $_POST['email'] ?? '', 0)) {
            $_SESSION['error'] = 'Cet email est déjà utilisé par un autre fournisseur.';
            rediriger(BASE_URL . '/controllers/FournisseurController.php?action=ajouter');
        }
        Fournisseur::create($pdo, [
            'nom'       => $_POST['nom'] ?? '',
            'telephone' => $_POST['telephone'] ?? '',
            'email'     => $_POST['email'] ?? '',
            'adresse'   => $_POST['adresse'] ?? '',
        ]);
        journaliser($pdo, 'fournisseur', 'creation', 'Création du fournisseur "' . ($_POST['nom'] ?? '') . '"');
        $_SESSION['success'] = 'Fournisseur ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/FournisseurController.php?action=list');
        break;

    case 'modifier':
        $fournisseur = Fournisseur::getById($pdo, $_GET['id'] ?? 0);
        if (!$fournisseur) {
            $_SESSION['error'] = 'Fournisseur introuvable.';
            rediriger(BASE_URL . '/controllers/FournisseurController.php?action=list');
        }
        require VIEWS_PATH . 'fournisseurs/modifier.php';
        break;

    case 'update':
        $id = $_GET['id'] ?? 0;
        if (Fournisseur::emailExiste($pdo, $_POST['email'] ?? '', $id)) {
            $_SESSION['error'] = 'Cet email est déjà utilisé par un autre fournisseur.';
            rediriger(BASE_URL . "/controllers/FournisseurController.php?action=modifier&id=$id");
        }
        Fournisseur::update($pdo, $id, [
            'nom'       => $_POST['nom'] ?? '',
            'telephone' => $_POST['telephone'] ?? '',
            'email'     => $_POST['email'] ?? '',
            'adresse'   => $_POST['adresse'] ?? '',
        ]);
        journaliser($pdo, 'fournisseur', 'modification', 'Modification du fournisseur ID ' . $id);
        $_SESSION['success'] = 'Fournisseur modifié avec succès.';
        rediriger(BASE_URL . '/controllers/FournisseurController.php?action=list');
        break;

    case 'supprimer':
        // Garde : un fournisseur lié à des articles ne peut pas être supprimé
        $nb = Fournisseur::countArticles($pdo, $_GET['id'] ?? 0);
        if ($nb > 0) {
            $_SESSION['error'] = "Impossible de supprimer ce fournisseur : $nb article(s) lui sont liés.";
        } else {
            $fournisseurASupprimer = Fournisseur::getById($pdo, $_GET['id'] ?? 0);
            Fournisseur::delete($pdo, $_GET['id'] ?? 0);
            if ($fournisseurASupprimer) {
                journaliser($pdo, 'fournisseur', 'suppression', 'Suppression du fournisseur "' . $fournisseurASupprimer['NOM'] . '"');
            }
            $_SESSION['success'] = 'Fournisseur supprimé avec succès.';
        }
        rediriger(BASE_URL . '/controllers/FournisseurController.php?action=list');
        break;
}