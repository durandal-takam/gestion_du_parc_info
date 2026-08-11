<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/CategorieMateriel.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $categories = CategorieMateriel::getAll($pdo);
        require VIEWS_PATH . 'categories_materiel/liste.php';
        break;

    case 'ajouter':
        require VIEWS_PATH . 'categories_materiel/ajouter.php';
        break;

    case 'store':
        CategorieMateriel::create($pdo, [
            'libelle'     => $_POST['libelle'] ?? '',
            'description' => $_POST['description'] ?? '',
        ]);
        $_SESSION['success'] = 'Catégorie ajoutée avec succès.';
        rediriger(BASE_URL . '/controllers/CategorieMaterielController.php?action=list');
        break;

    case 'modifier':
        $categorie = CategorieMateriel::getById($pdo, $_GET['id'] ?? 0);
        if (!$categorie) {
            $_SESSION['error'] = 'Catégorie introuvable.';
            rediriger(BASE_URL . '/controllers/CategorieMaterielController.php?action=list');
        }
        require VIEWS_PATH . 'categories_materiel/modifier.php';
        break;

    case 'update':
        CategorieMateriel::update($pdo, $_GET['id'] ?? 0, [
            'libelle'     => $_POST['libelle'] ?? '',
            'description' => $_POST['description'] ?? '',
        ]);
        $_SESSION['success'] = 'Catégorie modifiée avec succès.';
        rediriger(BASE_URL . '/controllers/CategorieMaterielController.php?action=list');
        break;

    case 'supprimer':
        CategorieMateriel::delete($pdo, $_GET['id'] ?? 0);
        $_SESSION['success'] = 'Catégorie supprimée avec succès.';
        rediriger(BASE_URL . '/controllers/CategorieMaterielController.php?action=list');
        break;
}