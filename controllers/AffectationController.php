<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Affectation.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $affectations = Affectation::getAll($pdo);
        require VIEWS_PATH . 'affectations/liste.php';
        break;

    case 'ajouter':
        // Seuls les utilisateurs actifs peuvent recevoir du matériel
        $utilisateurs = $pdo->query("SELECT * FROM UTILISATEUR WHERE STATUT = 'actif' ORDER BY NOM ASC")->fetchAll();
        $materiels = Affectation::getMaterielsDisponibles($pdo);
        require VIEWS_PATH . 'affectations/ajouter.php';
        break;

    case 'store':
        $result = Affectation::create($pdo, [
            'id_user'          => $_POST['id_user'] ?? '',
            'id_materiel'      => $_POST['id_materiel'] ?? '',
            'date_affectation' => $_POST['date_affectation'] ?? date('Y-m-d'),
        ]);
        if ($result === true) {
            $_SESSION['success'] = 'Matériel affecté avec succès.';
        } else {
            $_SESSION['error'] = $result;
        }
        rediriger(BASE_URL . '/controllers/AffectationController.php?action=list');
        break;

    case 'terminer':
        $result = Affectation::terminer($pdo, $_GET['id'] ?? 0);
        if ($result === true) {
            $_SESSION['success'] = 'Affectation terminée, matériel libéré.';
        } else {
            $_SESSION['error'] = $result;
        }
        rediriger(BASE_URL . '/controllers/AffectationController.php?action=list');
        break;

    case 'supprimer':
        Affectation::delete($pdo, $_GET['id'] ?? 0);
        $_SESSION['success'] = 'Affectation supprimée.';
        rediriger(BASE_URL . '/controllers/AffectationController.php?action=list');
        break;
}