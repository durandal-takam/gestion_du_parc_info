<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Prestataire.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $prestataires = Prestataire::getAll($pdo);
        require VIEWS_PATH . 'prestataires/liste.php';
        break;

    case 'ajouter':
        require VIEWS_PATH . 'prestataires/ajouter.php';
        break;

    case 'store':
        Prestataire::create($pdo, [
            'nom'       => $_POST['nom'] ?? '',
            'telephone' => $_POST['telephone'] ?? '',
            'email'     => $_POST['email'] ?? '',
            'adresse'   => $_POST['adresse'] ?? '',
        ]);
        journaliser($pdo, 'prestataire', 'creation', 'Création du prestataire "' . ($_POST['nom'] ?? '') . '"');
        $_SESSION['success'] = 'Prestataire ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/PrestataireController.php?action=list');
        break;

    case 'modifier':
        $prestataire = Prestataire::getById($pdo, $_GET['id'] ?? 0);
        if (!$prestataire) {
            $_SESSION['error'] = 'Prestataire introuvable.';
            rediriger(BASE_URL . '/controllers/PrestataireController.php?action=list');
        }
        require VIEWS_PATH . 'prestataires/modifier.php';
        break;

    case 'update':
        Prestataire::update($pdo, $_GET['id'] ?? 0, [
            'nom'       => $_POST['nom'] ?? '',
            'telephone' => $_POST['telephone'] ?? '',
            'email'     => $_POST['email'] ?? '',
            'adresse'   => $_POST['adresse'] ?? '',
        ]);
        journaliser($pdo, 'prestataire', 'modification', 'Modification du prestataire ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Prestataire modifié avec succès.';
        rediriger(BASE_URL . '/controllers/PrestataireController.php?action=list');
        break;

    case 'supprimer':
        $prestataireASupprimer = Prestataire::getById($pdo, $_GET['id'] ?? 0);
        Prestataire::delete($pdo, $_GET['id'] ?? 0);
        if ($prestataireASupprimer) {
            journaliser($pdo, 'prestataire', 'suppression', 'Suppression du prestataire "' . $prestataireASupprimer['NOM'] . '"');
        }
        $_SESSION['success'] = 'Prestataire supprimé avec succès.';
        rediriger(BASE_URL . '/controllers/PrestataireController.php?action=list');
        break;
}