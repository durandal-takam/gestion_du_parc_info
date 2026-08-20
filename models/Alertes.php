<?php
require_once __DIR__ . '/../includes/functions.php';

class Alertes {

    public static function stocksFaibles($pdo) {
        $stmt = $pdo->query("
            SELECT a.DESIGNATION AS ARTICLE_DESIGNATION, s.QUANTITE_DISPO, s.SEUIL_ALERTE
            FROM STOCK s
            JOIN ARTICLE a ON s.ID_STOCK = a.ID_STOCK
            WHERE s.QUANTITE_DISPO <= s.SEUIL_ALERTE AND s.SEUIL_ALERTE > 0
            ORDER BY (s.QUANTITE_DISPO / s.SEUIL_ALERTE) ASC
        ");
        return $stmt->fetchAll();
    }

    public static function garantiesExpirees($pdo) {
        $stmt = $pdo->query("
            SELECT DESIGNATION, NUMERO_SERIE, GARANTIE
            FROM MATERIEL WHERE GARANTIE < CURDATE()
            ORDER BY GARANTIE ASC
        ");
        return $stmt->fetchAll();
    }

    public static function garantiesBientot($pdo) {
        $stmt = $pdo->query("
            SELECT DESIGNATION, NUMERO_SERIE, GARANTIE
            FROM MATERIEL WHERE GARANTIE BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY
            ORDER BY GARANTIE ASC
        ");
        return $stmt->fetchAll();
    }

    public static function ticketsUrgents($pdo) {
        $stmt = $pdo->query("
            SELECT d.*, u.NOM, u.PRENOM,
                   m.DESIGNATION AS MATERIEL_DESIGNATION
            FROM DEMANDE_MAINTENANCE d
            JOIN UTILISATEUR u ON d.ID_USER = u.ID_USER
            LEFT JOIN MATERIEL m ON d.ID_MATERIEL = m.ID_MATERIEL
            WHERE d.PRIORITE IN ('Critique', 'Haute')
              AND d.STATUT NOT IN ('Fermé', 'Résolu')
            ORDER BY d.DATE_DEMANDE DESC
        ");
        return $stmt->fetchAll();
    }

    public static function materielsEnPanne($pdo) {
        $stmt = $pdo->query("
            SELECT DESIGNATION, NUMERO_SERIE
            FROM MATERIEL WHERE ETAT = 'en panne'
            ORDER BY DESIGNATION ASC
        ");
        return $stmt->fetchAll();
    }
        public static function compteur($pdo) {
        $total = 0;
        $total += (int)$pdo->query("
            SELECT COUNT(*) FROM STOCK s
            JOIN ARTICLE a ON s.ID_STOCK = a.ID_STOCK
            WHERE s.QUANTITE_DISPO <= s.SEUIL_ALERTE AND s.SEUIL_ALERTE > 0
        ")->fetchColumn();
        $total += (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE GARANTIE < CURDATE()")->fetchColumn();
        $total += (int)$pdo->query("
            SELECT COUNT(*) FROM MATERIEL
            WHERE GARANTIE BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY
        ")->fetchColumn();
        $total += (int)$pdo->query("
            SELECT COUNT(*) FROM DEMANDE_MAINTENANCE
            WHERE PRIORITE IN ('Critique', 'Haute') AND STATUT NOT IN ('Fermé', 'Résolu')
        ")->fetchColumn();
        $total += (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE ETAT = 'en panne'")->fetchColumn();
        return $total;
    }
}