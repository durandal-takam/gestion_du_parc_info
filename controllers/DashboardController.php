<?php
session_start();
require_once __DIR__ . '/../includes/functions.php';

// Statistiques principales
$stats['total_equipements'] = $pdo->query("SELECT COUNT(*) FROM MATERIEL")->fetchColumn();
$stats['equipements_disponibles'] = $pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE ETAT = 'disponible'")->fetchColumn();
$stats['tickets_ouverts'] = $pdo->query("SELECT COUNT(*) FROM DEMANDE_MAINTENANCE WHERE STATUT IN ('Ouvert','En cours','En attente de pièces')")->fetchColumn();
$stats['tickets_fermes'] = $pdo->query("SELECT COUNT(*) FROM DEMANDE_MAINTENANCE WHERE STATUT = 'Fermé'")->fetchColumn();
$stats['maintenances'] = $pdo->query("SELECT COUNT(*) FROM MAINTENANCE")->fetchColumn();
$stats['equipements_en_panne'] = $pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE ETAT = 'en panne'")->fetchColumn();
$stats['equipements_affectes'] = $pdo->query("SELECT COUNT(*) FROM AFFECTATION WHERE STATUT = 'active'")->fetchColumn();
$stats['garanties_expirees'] = $pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE GARANTIE < CURDATE()")->fetchColumn();
$stats['fournisseurs'] = $pdo->query("SELECT COUNT(*) FROM FOURNISSEUR")->fetchColumn();
$stats['utilisateurs'] = $pdo->query("SELECT COUNT(*) FROM UTILISATEUR")->fetchColumn();

// ⚠️ NOUVEAU : utilisateurs en ligne
$stats['en_ligne'] = $pdo->query(
    "SELECT COUNT(*) FROM UTILISATEUR 
     WHERE DERNIERE_CONNEXION >= NOW() - INTERVAL 5 MINUTE"
)->fetchColumn();

// Nombre total d'alertes actives
require_once __DIR__ . '/../models/Alertes.php';
$stats['alertes_total'] = Alertes::compteur($pdo);
include VIEWS_PATH . 'dashboard/index.php';