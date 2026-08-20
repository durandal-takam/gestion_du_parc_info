<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Rapport.php';

function donnees_rapport($pdo, $type) {
    switch ($type) {
        case 'etat':         return ['Matériels par état', ['État', 'Nombre'], Rapport::materielsParEtat($pdo)];
        case 'categorie':    return ['Matériels par catégorie', ['Catégorie', 'Nombre'], Rapport::materielsParCategorie($pdo)];
        case 'affectations': return ['Affectations actives par agent', ['Agent', 'Nombre'], Rapport::affectationsParAgent($pdo)];
        case 'mouvements':   return ['Mouvements par type', ['Type', 'Nombre'], Rapport::mouvementsParType($pdo)];
        case 'tickets':      return ['Tickets par statut', ['Statut', 'Nombre'], Rapport::ticketsParStatut($pdo)];
        case 'priorite':     return ['Tickets par priorité', ['Priorité', 'Nombre'], Rapport::ticketsParPriorite($pdo)];
        case 'pannes':       return ['Pannes les plus fréquentes', ['Catégorie', 'Nombre'], Rapport::pannesFrequentes($pdo)];
        case 'maintenances': return ['Maintenances par type', ['Type', 'Nombre', 'Coût total'], Rapport::maintenancesParType($pdo)];
        case 'couts':        return ['Top 5 matériels les plus coûteux', ['Matériel', 'Nombre', 'Coût total'], Rapport::coutsTop5($pdo)];
        case 'roles':        return ['Utilisateurs par rôle', ['Rôle', 'Nombre'], Rapport::utilisateursParRole($pdo)];
        case 'fournisseurs': return ['Liste des fournisseurs', ['ID', 'Nom', 'Téléphone', 'Email'], Rapport::fournisseurs($pdo)];
    }
    return null;
}

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'index':
        $stats = [
            'etat'      => Rapport::materielsParEtat($pdo),
            'categorie' => Rapport::materielsParCategorie($pdo),
            'affectations' => Rapport::affectationsParAgent($pdo),
            'mouvements' => Rapport::mouvementsParType($pdo),
            'tickets'   => Rapport::ticketsParStatut($pdo),
            'priorite'  => Rapport::ticketsParPriorite($pdo),
            'pannes'    => Rapport::pannesFrequentes($pdo),
            'maintenances' => Rapport::maintenancesParType($pdo),
            'couts'     => Rapport::coutsTop5($pdo),
            'garanties' => Rapport::garanties($pdo),
            'roles'     => Rapport::utilisateursParRole($pdo),
            'fournisseurs' => Rapport::fournisseurs($pdo),
            'kpi_dispo' => Rapport::kpiDisponibilite($pdo),
            'kpi_resolution' => Rapport::kpiTempsResolution($pdo),
        ];
        require VIEWS_PATH . 'rapports/index.php';
        break;

    case 'export':
        $donnees = donnees_rapport($pdo, $_GET['type'] ?? '');
        $format  = $_GET['format'] ?? 'excel';
        if (!$donnees) {
            $_SESSION['error'] = 'Rapport inconnu.';
            rediriger(BASE_URL . '/controllers/RapportController.php?action=index');
        }
        journaliser($pdo, 'rapport', 'export', 'Export "' . ($donnees[0] ?? '') . '" au format ' . strtoupper($format));
        require_once __DIR__ . '/../libs/exporteurs.php';
        if ($format === 'pdf') {
            exportPDF($donnees[0], $donnees[1], $donnees[2]);
        } else {
            exportExcel($donnees[0], $donnees[1], $donnees[2]);
        }
        break;
}