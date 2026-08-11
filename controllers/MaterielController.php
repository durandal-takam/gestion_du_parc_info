<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Materiel.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $materiels = Materiel::getAll($pdo);
        require VIEWS_PATH . 'equipements/liste.php';
        break;

    case 'ajouter':
        $articles = $pdo->query("SELECT * FROM ARTICLE ORDER BY DESIGNATION ASC")->fetchAll();
        require VIEWS_PATH . 'equipements/ajouter.php';
        break;

    case 'store':
        Materiel::create($pdo, [
            'id_article'        => $_POST['id_article'] ?? '',
            'designation'       => $_POST['designation'] ?? '',
            'numero_serie'      => $_POST['numero_serie'] ?? '',
            'date_acquisition'  => $_POST['date_acquisition'] ?? '',
            'etat'              => $_POST['etat'] ?? 'disponible',
            'localisation'      => $_POST['localisation'] ?? '',
            'garantie'          => $_POST['garantie'] ?? '',
            'configuration'     => $_POST['configuration'] ?? '',
            'date_mise_en_service' => $_POST['date_mise_en_service'] ?? '',
        ]);
        $_SESSION['success'] = 'Matériel ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/MaterielController.php?action=list');
        break;

    case 'modifier':
        $materiel = Materiel::getById($pdo, $_GET['id'] ?? 0);
        if (!$materiel) {
            $_SESSION['error'] = 'Matériel introuvable.';
            rediriger(BASE_URL . '/controllers/MaterielController.php?action=list');
        }
        $articles = $pdo->query("SELECT * FROM ARTICLE ORDER BY DESIGNATION ASC")->fetchAll();
        require VIEWS_PATH . 'equipements/modifier.php';
        break;

    case 'update':
        Materiel::update($pdo, $_GET['id'] ?? 0, [
            'id_article'        => $_POST['id_article'] ?? '',
            'designation'       => $_POST['designation'] ?? '',
            'numero_serie'      => $_POST['numero_serie'] ?? '',
            'date_acquisition'  => $_POST['date_acquisition'] ?? '',
            'etat'              => $_POST['etat'] ?? 'disponible',
            'localisation'      => $_POST['localisation'] ?? '',
            'garantie'          => $_POST['garantie'] ?? '',
            'configuration'     => $_POST['configuration'] ?? '',
            'date_mise_en_service' => $_POST['date_mise_en_service'] ?? '',
        ]);
        $_SESSION['success'] = 'Matériel modifié avec succès.';
        rediriger(BASE_URL . '/controllers/MaterielController.php?action=list');
        break;

    case 'supprimer':
        Materiel::delete($pdo, $_GET['id'] ?? 0);
        $_SESSION['success'] = 'Matériel supprimé avec succès.';
        rediriger(BASE_URL . '/controllers/MaterielController.php?action=list');
        break;
}