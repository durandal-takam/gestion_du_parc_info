<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Rapport.php';

// Réservé à la Direction
if (!aRole(ROLE_DIRECTION)) {
    $_SESSION['error'] = 'Accès refusé';
    rediriger(BASE_URL . '/index.php');
}

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $kpi_dispo = Rapport::kpiDisponibilite($pdo);
        $kpi_resol = Rapport::kpiTempsResolution($pdo);
        $garanties = Rapport::garanties($pdo);

        $par_etat   = Rapport::materielsParEtat($pdo);
        $par_statut = Rapport::ticketsParStatut($pdo);
        $pannes     = Rapport::pannesFrequentes($pdo);

        $par_agent  = Rapport::affectationsParAgent($pdo);
        $par_type   = Rapport::maintenancesParType($pdo);
        $top5       = Rapport::coutsTop5($pdo);

        require VIEWS_PATH . 'pilotage/index.php';
        break;
}