<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Article.php';
require_once __DIR__ . '/../models/CategorieMateriel.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $articles = Article::getAll($pdo);
        require VIEWS_PATH . 'articles/liste.php';
        break;

    case 'ajouter':
        $categories  = CategorieMateriel::getAll($pdo);
        $fournisseurs = $pdo->query("SELECT * FROM FOURNISSEUR ORDER BY NOM ASC")->fetchAll();
        require VIEWS_PATH . 'articles/ajouter.php';
        break;

    case 'store':
        Article::create($pdo, [
            'designation'    => $_POST['designation'] ?? '',
            'modele'         => $_POST['modele'] ?? '',
            'marque'         => $_POST['marque'] ?? '',
            'description'    => $_POST['description'] ?? '',
            'prix_unitaire'  => $_POST['prix_unitaire'] ?? '',
            'id_categorie'   => $_POST['id_categorie'] ?? '',
            'id_fournisseur' => $_POST['id_fournisseur'] ?? '',
        ]);
        journaliser($pdo, 'article', 'creation', 'Création de l\'article "' . ($_POST['designation'] ?? '') . '"');
        $_SESSION['success'] = 'Article ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/ArticleController.php?action=list');
        break;

    case 'modifier':
        $article = Article::getById($pdo, $_GET['id'] ?? 0);
        if (!$article) {
            $_SESSION['error'] = 'Article introuvable.';
            rediriger(BASE_URL . '/controllers/ArticleController.php?action=list');
        }
        $categories  = CategorieMateriel::getAll($pdo);
        $fournisseurs = $pdo->query("SELECT * FROM FOURNISSEUR ORDER BY NOM ASC")->fetchAll();
        require VIEWS_PATH . 'articles/modifier.php';
        break;

    case 'update':
        Article::update($pdo, $_GET['id'] ?? 0, [
            'designation'    => $_POST['designation'] ?? '',
            'modele'         => $_POST['modele'] ?? '',
            'marque'         => $_POST['marque'] ?? '',
            'description'    => $_POST['description'] ?? '',
            'prix_unitaire'  => $_POST['prix_unitaire'] ?? '',
            'id_categorie'   => $_POST['id_categorie'] ?? '',
            'id_fournisseur' => $_POST['id_fournisseur'] ?? '',
        ]);
        journaliser($pdo, 'article', 'modification', 'Modification de l\'article ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Article modifié avec succès.';
        rediriger(BASE_URL . '/controllers/ArticleController.php?action=list');
        break;

    case 'supprimer':
        $articleASupprimer = Article::getById($pdo, $_GET['id'] ?? 0);
        Article::delete($pdo, $_GET['id'] ?? 0);
        if ($articleASupprimer) {
            journaliser($pdo, 'article', 'suppression', 'Suppression de l\'article "' . $articleASupprimer['DESIGNATION'] . '"');
        }
        $_SESSION['success'] = 'Article supprimé avec succès.';
        rediriger(BASE_URL . '/controllers/ArticleController.php?action=list');
        break;
}