<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Alertes.php';

if (!estConnecte()) {
    rediriger(BASE_URL . '/views/auth/login.php');
}

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $stocks_faibles     = Alertes::stocksFaibles($pdo);
        $garanties_expirees = Alertes::garantiesExpirees($pdo);
        $garanties_bientot  = Alertes::garantiesBientot($pdo);
        $tickets_urgents    = Alertes::ticketsUrgents($pdo);
        $en_panne           = Alertes::materielsEnPanne($pdo);
        require VIEWS_PATH . 'alertes/index.php';
        break;
}