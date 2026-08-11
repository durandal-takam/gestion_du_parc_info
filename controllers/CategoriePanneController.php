<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/CategoriePanne.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $categories = CategoriePanne::getAll($pdo);
        require VIEWS_PATH . 'categories_pannes/liste.php';
        break;

    case 'ajouter':
        require VIEWS_PATH . 'categories_pannes/ajouter.php';
        break;

    case 'store':
        CategoriePanne::create($pdo, [
            'libelle'     => $_POST['libelle'] ?? '',
            'description' => $_POST['description'] ?? '',
        ]);
        $_SESSION['success'] = 'Catégorie de panne ajoutée avec succès.';
        rediriger(BASE_URL . '/controllers/CategoriePanneController.php?action=list');
        break;

    case 'modifier':
        $categorie = CategoriePanne::getById($pdo, $_GET['id'] ?? 0);
        if (!$categorie) {
            $_SESSION['error'] = 'Catégorie introuvable.';
            rediriger(BASE_URL . '/controllers/CategoriePanneController.php?action=list');
        }
        require VIEWS_PATH . 'categories_pannes/modifier.php';
        break;

    case 'update':
        CategoriePanne::update($pdo, $_GET['id'] ?? 0, [
            'libelle'     => $_POST['libelle'] ?? '',
            'description' => $_POST['description'] ?? '',
        ]);
        $_SESSION['success'] = 'Catégorie de panne modifiée avec succès.';
        rediriger(BASE_URL . '/controllers/CategoriePanneController.php?action=list');
        break;

    case 'supprimer':
        CategoriePanne::delete($pdo, $_GET['id'] ?? 0);
        $_SESSION['success'] = 'Catégorie de panne supprimée avec succès.';
        rediriger(BASE_URL . '/controllers/CategoriePanneController.php?action=list');
        break;
}