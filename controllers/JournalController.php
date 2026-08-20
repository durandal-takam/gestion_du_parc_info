<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Journal.php';

// Réservé au Super Administrateur
if (!aRole(ROLE_SUPER_ADMIN)) {
    $_SESSION['error'] = "Accès refusé";
    rediriger(BASE_URL . '/index.php');
}

$action = $_GET['action'] ?? 'list';

switch ($action) {

    case 'list':
        $filtres = [
            'id_user'    => $_GET['id_user'] ?? '',
            'action'     => $_GET['action_filtre'] ?? '',
            'date_debut' => $_GET['date_debut'] ?? '',
            'date_fin'   => $_GET['date_fin'] ?? '',
        ];

        $par_page = 50;
        $page = max(1, (int)($_GET['page'] ?? 1));
        $total = Journal::countAll($pdo, $filtres);
        $pages = max(1, (int)ceil($total / $par_page));
        if ($page > $pages) { $page = $pages; }
        $offset = ($page - 1) * $par_page;

        $entrees = Journal::getAll($pdo, $filtres, $par_page, $offset);
        $utilisateurs = Journal::getUtilisateursDistincts($pdo);
        $actions = Journal::getActionsDistinctes($pdo);

        require VIEWS_PATH . 'journaux/liste.php';
        break;

    case 'export':
        $filtres = [
            'id_user'    => $_GET['id_user'] ?? '',
            'action'     => $_GET['action_filtre'] ?? '',
            'date_debut' => $_GET['date_debut'] ?? '',
            'date_fin'   => $_GET['date_fin'] ?? '',
        ];
        $entrees = Journal::getAll($pdo, $filtres);

        $lignes = [];
        foreach ($entrees as $j) {
            $lignes[] = [
                $j['DATE_ACTION'],
                $j['ID_USER'] ? ($j['PRENOM'] . ' ' . $j['NOM']) : 'système',
                $j['MODULE'],
                $j['ACTION'],
                $j['DESCRIPTION'] ?: '',
                $j['IP_ADRESSE'] ?: '',
            ];
        }

        journaliser($pdo, 'journal', 'export', 'Export du journal d\'activité (' . count($lignes) . ' entrées)');

        require_once __DIR__ . '/../libs/exporteurs.php';
        exportExcel('journal_activite', ['Date', 'Utilisateur', 'Module', 'Action', 'Description', 'IP'], $lignes);
        break;
}
