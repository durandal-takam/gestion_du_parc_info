<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Maintenance.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $maintenances = Maintenance::getAll($pdo);
        require VIEWS_PATH . 'maintenances/liste.php';
        break;

    case 'ajouter':
        $types        = $pdo->query("SELECT * FROM TYPE_MAINTENANCE ORDER BY ID_TYPE ASC")->fetchAll();
        $techniciens  = $pdo->query("SELECT * FROM UTILISATEUR WHERE STATUT = 'actif' ORDER BY NOM ASC")->fetchAll();
        $contrats     = $pdo->query("SELECT * FROM CONTRAT_MAINTENANCE ORDER BY DATE_DEBUT DESC")->fetchAll();
        $demandes     = $pdo->query("SELECT * FROM DEMANDE_MAINTENANCE ORDER BY DATE_DEMANDE DESC")->fetchAll();
        $materiels    = $pdo->query("SELECT * FROM MATERIEL ORDER BY DESIGNATION ASC")->fetchAll();
        $categories   = $pdo->query("SELECT * FROM CATEGORIE_PANNE ORDER BY LIBELLE ASC")->fetchAll();
        require VIEWS_PATH . 'maintenances/ajouter.php';
        break;

    case 'store':
        Maintenance::create($pdo, [
            'id_type'             => $_POST['id_type'] ?? '',
            'id_user'             => $_POST['id_user'] ?? '',
            'id_contrat'          => $_POST['id_contrat'] ?? '',
            'id_demande'          => $_POST['id_demande'] ?? '',
            'id_materiel'         => $_POST['id_materiel'] ?? '',
            'date_panne'          => str_replace('T', ' ', $_POST['date_panne'] ?? ''),
            'description'         => $_POST['description'] ?? '',
            'date_intervention'   => str_replace('T', ' ', $_POST['date_intervention'] ?? ''),
            'solution'            => $_POST['solution'] ?? '',
            'cout'                => $_POST['cout'] ?? '',
            'id_categorie_panne'  => $_POST['id_categorie_panne'] ?? '',
        ]);
        journaliser($pdo, 'maintenance', 'creation', 'Maintenance sur le matériel ID ' . ($_POST['id_materiel'] ?? '') . ' (coût : ' . ($_POST['cout'] ?? 0) . ')');
        $_SESSION['success'] = 'Maintenance ajoutée avec succès.';
        rediriger(BASE_URL . '/controllers/MaintenanceController.php?action=list');
        break;

    case 'modifier':
        $maintenance = Maintenance::getById($pdo, $_GET['id'] ?? 0);
        if (!$maintenance) {
            $_SESSION['error'] = 'Maintenance introuvable.';
            rediriger(BASE_URL . '/controllers/MaintenanceController.php?action=list');
        }
        $types        = $pdo->query("SELECT * FROM TYPE_MAINTENANCE ORDER BY ID_TYPE ASC")->fetchAll();
        $techniciens  = $pdo->query("SELECT * FROM UTILISATEUR WHERE STATUT = 'actif' ORDER BY NOM ASC")->fetchAll();
        $contrats     = $pdo->query("SELECT * FROM CONTRAT_MAINTENANCE ORDER BY DATE_DEBUT DESC")->fetchAll();
        $demandes     = $pdo->query("SELECT * FROM DEMANDE_MAINTENANCE ORDER BY DATE_DEMANDE DESC")->fetchAll();
        $materiels    = $pdo->query("SELECT * FROM MATERIEL ORDER BY DESIGNATION ASC")->fetchAll();
        $categories   = $pdo->query("SELECT * FROM CATEGORIE_PANNE ORDER BY LIBELLE ASC")->fetchAll();
        require VIEWS_PATH . 'maintenances/modifier.php';
        break;

    case 'update':
        Maintenance::update($pdo, $_GET['id'] ?? 0, [
            'id_type'             => $_POST['id_type'] ?? '',
            'id_user'             => $_POST['id_user'] ?? '',
            'id_contrat'          => $_POST['id_contrat'] ?? '',
            'id_demande'          => $_POST['id_demande'] ?? '',
            'id_materiel'         => $_POST['id_materiel'] ?? '',
            'date_panne'          => str_replace('T', ' ', $_POST['date_panne'] ?? ''),
            'description'         => $_POST['description'] ?? '',
            'date_intervention'   => str_replace('T', ' ', $_POST['date_intervention'] ?? ''),
            'solution'            => $_POST['solution'] ?? '',
            'cout'                => $_POST['cout'] ?? '',
            'id_categorie_panne'  => $_POST['id_categorie_panne'] ?? '',
        ]);
        journaliser($pdo, 'maintenance', 'modification', 'Modification de la maintenance ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Maintenance modifiée avec succès.';
        rediriger(BASE_URL . '/controllers/MaintenanceController.php?action=list');
        break;

    case 'supprimer':
        Maintenance::delete($pdo, $_GET['id'] ?? 0);
                journaliser($pdo, 'maintenance', 'suppression', 'Suppression de la maintenance ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Maintenance supprimée avec succès.';
        rediriger(BASE_URL . '/controllers/MaintenanceController.php?action=list');
        break;
}