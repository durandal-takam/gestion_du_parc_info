<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Mouvement.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $mouvements = Mouvement::getAll($pdo);
        require VIEWS_PATH . 'mouvements/liste.php';
        break;

    case 'ajouter':
        $materiels    = $pdo->query("SELECT * FROM MATERIEL ORDER BY DESIGNATION ASC")->fetchAll();
        $utilisateurs = $pdo->query("SELECT * FROM UTILISATEUR WHERE STATUT = 'actif' ORDER BY NOM ASC")->fetchAll();
        require VIEWS_PATH . 'mouvements/ajouter.php';
        break;

    case 'store':
        Mouvement::create($pdo, [
            'id_materiel'    => $_POST['id_materiel'] ?? '',
            'id_user'        => $_POST['id_user'] ?? '',
            'type_mouvement' => $_POST['type_mouvement'] ?? '',
            'observation'    => $_POST['observation'] ?? '',
        ]);
        journaliser($pdo, 'mouvement', 'creation', 'Mouvement "' . ($_POST['type_mouvement'] ?? '') . '" pour le matériel ID ' . ($_POST['id_materiel'] ?? ''));
        $_SESSION['success'] = 'Mouvement enregistré avec succès.';
        rediriger(BASE_URL . '/controllers/MouvementController.php?action=list');
        break;

    case 'supprimer':
        Mouvement::delete($pdo, $_GET['id'] ?? 0);
        journaliser($pdo, 'mouvement', 'suppression', 'Suppression du mouvement ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Mouvement supprimé.';
        rediriger(BASE_URL . '/controllers/MouvementController.php?action=list');
        break;
}