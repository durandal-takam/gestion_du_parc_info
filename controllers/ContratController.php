<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/ContratMaintenance.php';
require_once __DIR__ . '/../models/Prestataire.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $contrats = ContratMaintenance::getAll($pdo);
        require VIEWS_PATH . 'contrats/liste.php';
        break;

    case 'ajouter':
        $prestataires = Prestataire::getAll($pdo);
        require VIEWS_PATH . 'contrats/ajouter.php';
        break;

    case 'store':
        ContratMaintenance::create($pdo, [
            'id_prestataire' => $_POST['id_prestataire'] ?? '',
            'reference'      => $_POST['reference'] ?? '',
            'date_debut'     => $_POST['date_debut'] ?? '',
            'date_fin'       => $_POST['date_fin'] ?? '',
            'montant'        => $_POST['montant'] ?? '',
            'observation'    => $_POST['observation'] ?? '',
        ]);
        $_SESSION['success'] = 'Contrat ajouté avec succès.';
        rediriger(BASE_URL . '/controllers/ContratController.php?action=list');
        break;

    case 'modifier':
        $contrat = ContratMaintenance::getById($pdo, $_GET['id'] ?? 0);
        if (!$contrat) {
            $_SESSION['error'] = 'Contrat introuvable.';
            rediriger(BASE_URL . '/controllers/ContratController.php?action=list');
        }
        $prestataires = Prestataire::getAll($pdo);
        require VIEWS_PATH . 'contrats/modifier.php';
        break;

    case 'update':
        ContratMaintenance::update($pdo, $_GET['id'] ?? 0, [
            'id_prestataire' => $_POST['id_prestataire'] ?? '',
            'reference'      => $_POST['reference'] ?? '',
            'date_debut'     => $_POST['date_debut'] ?? '',
            'date_fin'       => $_POST['date_fin'] ?? '',
            'montant'        => $_POST['montant'] ?? '',
            'observation'    => $_POST['observation'] ?? '',
        ]);
        $_SESSION['success'] = 'Contrat modifié avec succès.';
        rediriger(BASE_URL . '/controllers/ContratController.php?action=list');
        break;

    case 'supprimer':
        ContratMaintenance::delete($pdo, $_GET['id'] ?? 0);
        $_SESSION['success'] = 'Contrat supprimé avec succès.';
        rediriger(BASE_URL . '/controllers/ContratController.php?action=list');
        break;
}