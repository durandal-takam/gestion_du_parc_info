<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Bureau.php';
require_once __DIR__ . '/../models/Direction.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $bureaux = Bureau::getAll($pdo);
        require VIEWS_PATH . 'bureaux/liste.php';
        break;

    case 'ajouter':
        $directions = Direction::getAll($pdo);
        require VIEWS_PATH . 'bureaux/ajouter.php';
        break;

    case 'store':
        Bureau::create($pdo, [
            'id_direction' => $_POST['id_direction'] ?? '',
            'nom_bureau'   => $_POST['nom_bureau'] ?? '',
            'localisation' => $_POST['localisation'] ?? '',
        ]);
        journaliser($pdo, 'bureau', 'creation', 'Création du bureau "' . ($_POST['nom_bureau'] ?? '') . '"');
        $_SESSION['success'] = 'Bureau ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/BureauController.php?action=list');
        break;

    case 'modifier':
        $bureau = Bureau::getById($pdo, $_GET['id'] ?? 0);
        if (!$bureau) {
            $_SESSION['error'] = 'Bureau introuvable.';
            rediriger(BASE_URL . '/controllers/BureauController.php?action=list');
        }
        $directions = Direction::getAll($pdo);
        require VIEWS_PATH . 'bureaux/modifier.php';
        break;

    case 'update':
        Bureau::update($pdo, $_GET['id'] ?? 0, [
            'id_direction' => $_POST['id_direction'] ?? '',
            'nom_bureau'   => $_POST['nom_bureau'] ?? '',
            'localisation' => $_POST['localisation'] ?? '',
        ]);
        journaliser($pdo, 'bureau', 'modification', 'Modification du bureau ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Bureau modifié avec succès.';
        rediriger(BASE_URL . '/controllers/BureauController.php?action=list');
        break;

    case 'supprimer':
        $bureauASupprimer = Bureau::getById($pdo, $_GET['id'] ?? 0);
        Bureau::delete($pdo, $_GET['id'] ?? 0);
        if ($bureauASupprimer) {
            journaliser($pdo, 'bureau', 'suppression', 'Suppression du bureau "' . $bureauASupprimer['NOM_BUREAU'] . '"');
        }
        $_SESSION['success'] = 'Bureau supprimé avec succès.';
        rediriger(BASE_URL . '/controllers/BureauController.php?action=list');
        break;
}