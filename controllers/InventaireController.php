<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Inventaire.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {

    case 'list':
        $inventaires = Inventaire::getAll($pdo);
        require VIEWS_PATH . 'inventaires/liste.php';
        break;

    case 'voir':
        $inventaire = Inventaire::getById($pdo, $_GET['id'] ?? '');
        if (!$inventaire) {
            $_SESSION['error'] = 'Inventaire introuvable.';
            rediriger(BASE_URL . '/controllers/InventaireController.php?action=list');
        }
        $details = Inventaire::getDetails($pdo, $inventaire['NUMERO_INVENTAIRE']);
        require VIEWS_PATH . 'inventaires/voir.php';
        break;

    case 'ajouter':
        $materiels = Inventaire::getMateriels($pdo);
        require VIEWS_PATH . 'inventaires/ajouter.php';
        break;

    case 'store':
        $details = [];
        foreach ($_POST['etat'] as $idMateriel => $etat) {
            $details[] = [
                'id_materiel' => $idMateriel,
                'etat'        => $etat,
                'remarque'    => $_POST['remarque'][$idMateriel] ?? '',
            ];
        }
        $ok = Inventaire::create($pdo, [
            'numero'      => Inventaire::genererNumero($pdo),
            'id_user'     => $_SESSION['user']['ID_USER'],
            'observation' => $_POST['observation'] ?? '',
        ], $details);
        if (!$ok) {
            $_SESSION['error'] = 'Erreur lors de l\'enregistrement de l\'inventaire.';
            rediriger(BASE_URL . '/controllers/InventaireController.php?action=ajouter');
        }
        $_SESSION['success'] = 'Inventaire enregistré avec succès.';
        journaliser($pdo, 'inventaire', 'creation', 'Inventaire enregistré (' . count($details) . ' matériel(s) contrôlé(s))');
        rediriger(BASE_URL . '/controllers/InventaireController.php?action=list');
        break;

    case 'modifier':
        $inventaire = Inventaire::getById($pdo, $_GET['id'] ?? '');
        if (!$inventaire) {
            $_SESSION['error'] = 'Inventaire introuvable.';
            rediriger(BASE_URL . '/controllers/InventaireController.php?action=list');
        }
        $details = Inventaire::getDetails($pdo, $inventaire['NUMERO_INVENTAIRE']);
        require VIEWS_PATH . 'inventaires/modifier.php';
        break;

    case 'update':
        $details = [];
        foreach ($_POST['etat'] as $idDetail => $etat) {
            $details[] = [
                'id_detail' => $idDetail,
                'etat'      => $etat,
                'remarque'  => $_POST['remarque'][$idDetail] ?? '',
            ];
        }
        $ok = Inventaire::update($pdo, $_GET['id'] ?? '', $_POST['observation'] ?? '', $details);
        $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Inventaire modifié avec succès.' : 'Erreur lors de la modification.';
        journaliser($pdo, 'inventaire', 'modification', 'Modification de l\'inventaire ' . ($_GET['id'] ?? ''));
        rediriger(BASE_URL . '/controllers/InventaireController.php?action=list');
        break;

    case 'supprimer':
        $ok = Inventaire::delete($pdo, $_GET['id'] ?? '');
        $_SESSION[$ok ? 'success' : 'error'] = $ok ? 'Inventaire supprimé.' : 'Suppression impossible.';
        journaliser($pdo, 'inventaire', 'suppression', 'Suppression de l\'inventaire ' . ($_GET['id'] ?? ''));
        rediriger(BASE_URL . '/controllers/InventaireController.php?action=list');
        break;
}