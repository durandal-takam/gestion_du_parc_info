<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Direction.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $directions = Direction::getAll($pdo);
        require VIEWS_PATH . 'directions/liste.php';
        break;

    case 'ajouter':
        require VIEWS_PATH . 'directions/ajouter.php';
        break;

    case 'store':
        Direction::create($pdo, [
            'nom_direction' => $_POST['nom_direction'] ?? '',
            'description'   => $_POST['description'] ?? '',
        ]);
        journaliser($pdo, 'direction', 'creation', 'Création de la direction "' . ($_POST['nom_direction'] ?? '') . '"');
        $_SESSION['success'] = 'Direction ajoutée avec succès.';
        rediriger(BASE_URL . '/controllers/DirectionController.php?action=list');
        break;

    case 'modifier':
        $direction = Direction::getById($pdo, $_GET['id'] ?? 0);
        if (!$direction) {
            $_SESSION['error'] = 'Direction introuvable.';
            rediriger(BASE_URL . '/controllers/DirectionController.php?action=list');
        }
        require VIEWS_PATH . 'directions/modifier.php';
        break;

    case 'update':
        Direction::update($pdo, $_GET['id'] ?? 0, [
            'nom_direction' => $_POST['nom_direction'] ?? '',
            'description'   => $_POST['description'] ?? '',
        ]);
        journaliser($pdo, 'direction', 'modification', 'Modification de la direction ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Direction modifiée avec succès.';
        rediriger(BASE_URL . '/controllers/DirectionController.php?action=list');
        break;

    case 'supprimer':
        $directionASupprimer = Direction::getById($pdo, $_GET['id'] ?? 0);
        Direction::delete($pdo, $_GET['id'] ?? 0);
        if ($directionASupprimer) {
            journaliser($pdo, 'direction', 'suppression', 'Suppression de la direction "' . $directionASupprimer['NOM_DIRECTION'] . '"');
        }
        $_SESSION['success'] = 'Direction supprimée avec succès.';
        rediriger(BASE_URL . '/controllers/DirectionController.php?action=list');
        break;
}