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
        $_SESSION['success'] = 'Direction modifiée avec succès.';
        rediriger(BASE_URL . '/controllers/DirectionController.php?action=list');
        break;

    case 'supprimer':
        Direction::delete($pdo, $_GET['id'] ?? 0);
        $_SESSION['success'] = 'Direction supprimée avec succès.';
        rediriger(BASE_URL . '/controllers/DirectionController.php?action=list');
        break;
}