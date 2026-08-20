<?php
require_once __DIR__ . '/../includes/functions.php';

class Portail {

    public static function mesAffectations($pdo, $id_user) {
        $stmt = $pdo->prepare("
            SELECT a.*, m.DESIGNATION AS MATERIEL_DESIGNATION, m.NUMERO_SERIE
            FROM AFFECTATION a
            JOIN MATERIEL m ON a.ID_MATERIEL = m.ID_MATERIEL
            WHERE a.ID_USER = ? AND a.STATUT = 'active'
            ORDER BY a.DATE_AFFECTATION DESC
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll();
    }

    public static function mesTickets($pdo, $id_user) {
        $stmt = $pdo->prepare("
            SELECT d.*, m.DESIGNATION AS MATERIEL_DESIGNATION,
                   cp.LIBELLE AS CATEGORIE_LIBELLE
            FROM DEMANDE_MAINTENANCE d
            LEFT JOIN MATERIEL m ON d.ID_MATERIEL = m.ID_MATERIEL
            LEFT JOIN CATEGORIE_PANNE cp ON d.ID_CATEGORIE_PANNE = cp.ID_CATEGORIE_PANNE
            WHERE d.ID_USER = ?
            ORDER BY d.DATE_DEMANDE DESC
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll();
    }

    public static function mesMaintenances($pdo, $id_user) {
        $stmt = $pdo->prepare("
            SELECT m.*, t.LIBELLE AS TYPE_LIBELLE,
                   mat.DESIGNATION AS MATERIEL_DESIGNATION
            FROM MAINTENANCE m
            JOIN TYPE_MAINTENANCE t ON m.ID_TYPE = t.ID_TYPE
            LEFT JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            WHERE m.ID_USER = ?
            ORDER BY m.DATE_INTERVENTION DESC
        ");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll();
    }
}