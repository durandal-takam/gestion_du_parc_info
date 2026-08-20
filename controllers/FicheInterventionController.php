<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/FicheIntervention.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $fiches = FicheIntervention::getAll($pdo);
        require VIEWS_PATH . 'fiches_interventions/liste.php';
        break;

    case 'voir':
        $fiche = FicheIntervention::getById($pdo, $_GET['id'] ?? 0);
        if (!$fiche) {
            $_SESSION['error'] = 'Fiche introuvable.';
            rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=list');
        }
        require VIEWS_PATH . 'fiches_interventions/voir.php';
        break;

    case 'ajouter':
        $maintenances = FicheIntervention::getMaintenancesSansFiche($pdo, null);
        $techniciens  = $pdo->query("SELECT * FROM UTILISATEUR WHERE STATUT = 'actif' ORDER BY NOM ASC")->fetchAll();
        require VIEWS_PATH . 'fiches_interventions/ajouter.php';
        break;

    case 'store':
        $fichier = null;
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
                $_SESSION['error'] = 'Format non autorisé (PDF, JPG, PNG uniquement).';
                rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=ajouter');
            }
            if ($_FILES['fichier']['size'] > 5 * 1024 * 1024) {
                $_SESSION['error'] = 'Fichier trop volumineux (5 Mo max).';
                rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=ajouter');
            }
                $fichier = 'fiche_' . uniqid() . '.' . $ext;
            if (!move_uploaded_file($_FILES['fichier']['tmp_name'], UPLOADS_PATH . 'fiches/' . $fichier)) {
                $_SESSION['error'] = 'Échec de l\'enregistrement du fichier.';
                $fichier = null;
            }
        }
        FicheIntervention::create($pdo, [
            'numero_fiche'         => FicheIntervention::genererNumero($pdo),
            'travaux_effectues'    => $_POST['travaux_effectues'] ?? '',
            'observations'         => $_POST['observations'] ?? '',
            'fichier_numerise'     => $fichier,
            'id_maintenance'       => $_POST['id_maintenance'] ?? '',
            'id_technicien'        => $_POST['id_technicien'] ?? '',
            'nom_responsable'      => $_POST['nom_responsable'] ?? '',
            'signature_technicien' => $_POST['signature_technicien'] ?? '',
            'signature_responsable' => $_POST['signature_responsable'] ?? '',
        ]);
                journaliser($pdo, 'fiche_intervention', 'creation', 'Fiche d\'intervention créée (maintenance ID ' . ($_POST['id_maintenance'] ?? '') . ')');
        $_SESSION['success'] = 'Fiche d\'intervention créée avec succès.';
        rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=list');
        break;

    case 'modifier':
        $fiche = FicheIntervention::getById($pdo, $_GET['id'] ?? 0);
        if (!$fiche) {
            $_SESSION['error'] = 'Fiche introuvable.';
            rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=list');
        }
        $maintenances = FicheIntervention::getMaintenancesSansFiche($pdo, $fiche['ID_FICHE']);
        $techniciens  = $pdo->query("SELECT * FROM UTILISATEUR WHERE STATUT = 'actif' ORDER BY NOM ASC")->fetchAll();
        require VIEWS_PATH . 'fiches_interventions/modifier.php';
        break;

    case 'update':
        $fiche = FicheIntervention::getById($pdo, $_GET['id'] ?? 0);
        $fichier = $fiche ? $fiche['FICHIER_NUMERISE'] : null;
        if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
                $_SESSION['error'] = 'Format non autorisé (PDF, JPG, PNG uniquement).';
                rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=modifier&id=' . ($_GET['id'] ?? 0));
            }
            if ($_FILES['fichier']['size'] > 5 * 1024 * 1024) {
                $_SESSION['error'] = 'Fichier trop volumineux (5 Mo max).';
                rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=modifier&id=' . ($_GET['id'] ?? 0));
            }
                       $fichier = 'fiche_' . uniqid() . '.' . $ext;
            if (!move_uploaded_file($_FILES['fichier']['tmp_name'], UPLOADS_PATH . 'fiches/' . $fichier)) {
                $_SESSION['error'] = 'Échec de l\'enregistrement du fichier.';
                $fichier = null;
            }
        }
        FicheIntervention::update($pdo, $_GET['id'] ?? 0, [
            'travaux_effectues'    => $_POST['travaux_effectues'] ?? '',
            'observations'         => $_POST['observations'] ?? '',
            'fichier_numerise'     => $fichier,
            'id_maintenance'       => $_POST['id_maintenance'] ?? '',
            'id_technicien'        => $_POST['id_technicien'] ?? '',
            'nom_responsable'      => $_POST['nom_responsable'] ?? '',
            'signature_technicien' => $_POST['signature_technicien'] ?? '',
            'signature_responsable' => $_POST['signature_responsable'] ?? '',
        ]);
        journaliser($pdo, 'fiche_intervention', 'modification', 'Modification de la fiche ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Fiche d\'intervention modifiée avec succès.';
        rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=list');
        break;

    case 'supprimer':
        FicheIntervention::delete($pdo, $_GET['id'] ?? 0);
        journaliser($pdo, 'fiche_intervention', 'suppression', 'Suppression de la fiche d\'intervention ID ' . ($_GET['id'] ?? 0));
        $_SESSION['success'] = 'Fiche supprimée avec succès.';
        rediriger(BASE_URL . '/controllers/FicheInterventionController.php?action=list');
        break;
}