<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/DemandeMaintenance.php';
require_once __DIR__ . '/../models/CategoriePanne.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $demandes = DemandeMaintenance::getAll($pdo);
        require VIEWS_PATH . 'tickets/liste.php';
        break;

    case 'ajouter':
        $materiels  = $pdo->query("SELECT * FROM MATERIEL ORDER BY DESIGNATION ASC")->fetchAll();
        $categories = CategoriePanne::getAll($pdo);
        require VIEWS_PATH . 'tickets/ajouter.php';
        break;

    case 'store':
        DemandeMaintenance::create($pdo, [
            'id_user'            => $_SESSION['user']['ID_USER'],
            'id_materiel'        => $_POST['id_materiel'] ?? '',
            'id_categorie_panne' => $_POST['id_categorie_panne'] ?? '',
            'description'        => $_POST['description'] ?? '',
            'priorite'           => $_POST['priorite'] ?? 'Moyenne',
        ]);
         journaliser($pdo, 'demande', 'creation', 'Ticket créé par l\'utilisateur ID ' . $_SESSION['user']['ID_USER'] . ' pour le matériel ID ' . ($_POST['id_materiel'] ?? ''));
        $_SESSION['success'] = 'Ticket créé avec succès.';
        rediriger(BASE_URL . '/controllers/DemandeController.php?action=list');
        break;

    case 'modifier':
        $demande = DemandeMaintenance::getById($pdo, $_GET['id'] ?? 0);
        if (!$demande) {
            $_SESSION['error'] = 'Ticket introuvable.';
            rediriger(BASE_URL . '/controllers/DemandeController.php?action=list');
        }
        $materiels  = $pdo->query("SELECT * FROM MATERIEL ORDER BY DESIGNATION ASC")->fetchAll();
        $categories = CategoriePanne::getAll($pdo);
        require VIEWS_PATH . 'tickets/modifier.php';
        break;

    case 'update':
        DemandeMaintenance::update($pdo, $_GET['id'] ?? 0, [
            'id_materiel'        => $_POST['id_materiel'] ?? '',
            'id_categorie_panne' => $_POST['id_categorie_panne'] ?? '',
            'description'        => $_POST['description'] ?? '',
            'statut'             => $_POST['statut'] ?? 'Ouvert',
            'priorite'           => $_POST['priorite'] ?? 'Moyenne',
        ]);
        journaliser($pdo, 'demande', 'modification', 'Ticket ID ' . ($_GET['id'] ?? 0) . ' mis à jour (statut : ' . ($_POST['statut'] ?? '?') . ')');
        $_SESSION['success'] = 'Ticket mis à jour avec succès.';
        rediriger(BASE_URL . '/controllers/DemandeController.php?action=list');
        break;

    case 'supprimer':
        DemandeMaintenance::delete($pdo, $_GET['id'] ?? 0);
        journaliser($pdo, 'demande', 'suppression', 'Suppression du ticket ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Ticket supprimé.';
        rediriger(BASE_URL . '/controllers/DemandeController.php?action=list');
        break;
}