<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../models/Stock.php';

$action = $_GET['action'] ?? 'list';

switch ($action) {

    case 'list':
        $stocks = Stock::getAll($pdo);
        require VIEWS_PATH . 'stocks/liste.php';
        break;

    case 'ajuster':
        $stock = Stock::getById($pdo, $_GET['id'] ?? 0);
        if (!$stock) {
            $_SESSION['error'] = 'Stock introuvable.';
            rediriger(BASE_URL . '/controllers/StockController.php?action=list');
        }
        require VIEWS_PATH . 'stocks/ajuster.php';
        break;

    case 'store-ajuster':
        $ok = Stock::ajuster($pdo, $_GET['id'] ?? 0, $_POST['type'] ?? 'entree',
                             (int)($_POST['quantite'] ?? 0), $_POST['motif'] ?? '',
                             $_SESSION['user']['ID_USER']);
        if (!$ok) {
            $_SESSION['error'] = 'Quantité insuffisante en stock pour cette sortie.';
        } else {
            $_SESSION['success'] = 'Mouvement de stock enregistré.';
            journaliser($pdo, 'stock', $_POST['type'] ?? 'entree', ($_POST['type'] ?? '') . ' de ' . (int)($_POST['quantite'] ?? 0) . ' unité(s) pour le stock ID ' . ($_GET['id'] ?? 0));
        }
        rediriger(BASE_URL . '/controllers/StockController.php?action=list');
        break;

    case 'mouvements':
        $stock = Stock::getById($pdo, $_GET['id'] ?? 0);
        $mouvements = Stock::getMouvements($pdo, $_GET['id'] ?? 0);
        require VIEWS_PATH . 'stocks/mouvements.php';
        break;

    case 'modifier':
        $stock = Stock::getById($pdo, $_GET['id'] ?? 0);
        require VIEWS_PATH . 'stocks/modifier.php';
        break;

    case 'update':
        Stock::updateSeuil($pdo, $_GET['id'] ?? 0, (int)($_POST['seuil_alerte'] ?? 0));
        journaliser($pdo, 'stock', 'modification', 'Seuil d\'alerte du stock ID ' . ($_GET['id'] ?? 0) . ' fixé à ' . (int)($_POST['seuil_alerte'] ?? 0));
        $_SESSION['success'] = 'Seuil d\'alerte mis à jour.';
        rediriger(BASE_URL . '/controllers/StockController.php?action=list');
        break;
}