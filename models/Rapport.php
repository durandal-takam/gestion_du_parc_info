<?php
require_once __DIR__ . '/../includes/functions.php';

class Rapport {

    public static function materielsParEtat($pdo) {
        return $pdo->query("SELECT ETAT, COUNT(*) AS NB FROM MATERIEL GROUP BY ETAT ORDER BY NB DESC")->fetchAll();
    }

    public static function materielsParCategorie($pdo) {
        return $pdo->query("
            SELECT c.LIBELLE, COUNT(*) AS NB
            FROM MATERIEL m
            JOIN ARTICLE a ON m.ID_ARTICLE = a.ID_ARTICLE
            JOIN CATEGORIE_MATERIEL c ON a.ID_CATEGORIE = c.ID_CATEGORIE
            GROUP BY c.LIBELLE ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function affectationsParAgent($pdo) {
        return $pdo->query("
            SELECT u.PRENOM, u.NOM, COUNT(*) AS NB
            FROM AFFECTATION a
            JOIN UTILISATEUR u ON a.ID_USER = u.ID_USER
            WHERE a.STATUT = 'active'
            GROUP BY u.ID_USER, u.PRENOM, u.NOM ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function mouvementsParType($pdo) {
        return $pdo->query("
            SELECT TYPE_MOUVEMENT, COUNT(*) AS NB
            FROM MOUVEMENT GROUP BY TYPE_MOUVEMENT ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function ticketsParStatut($pdo) {
        return $pdo->query("
            SELECT STATUT, COUNT(*) AS NB FROM DEMANDE_MAINTENANCE GROUP BY STATUT ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function ticketsParPriorite($pdo) {
        return $pdo->query("
            SELECT PRIORITE, COUNT(*) AS NB FROM DEMANDE_MAINTENANCE GROUP BY PRIORITE ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function pannesFrequentes($pdo) {
        return $pdo->query("
            SELECT cp.LIBELLE, COUNT(*) AS NB
            FROM DEMANDE_MAINTENANCE d
            JOIN CATEGORIE_PANNE cp ON d.ID_CATEGORIE_PANNE = cp.ID_CATEGORIE_PANNE
            GROUP BY cp.LIBELLE ORDER BY NB DESC LIMIT 5
        ")->fetchAll();
    }

    public static function maintenancesParType($pdo) {
        return $pdo->query("
            SELECT t.LIBELLE, COUNT(*) AS NB, COALESCE(SUM(m.COUT), 0) AS COUT_TOTAL
            FROM MAINTENANCE m
            JOIN TYPE_MAINTENANCE t ON m.ID_TYPE = t.ID_TYPE
            GROUP BY t.ID_TYPE, t.LIBELLE ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function coutsTop5($pdo) {
        return $pdo->query("
            SELECT mat.DESIGNATION, COUNT(*) AS NB, COALESCE(SUM(m.COUT), 0) AS COUT_TOTAL
            FROM MAINTENANCE m
            JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            GROUP BY mat.ID_MATERIEL, mat.DESIGNATION
            ORDER BY COUT_TOTAL DESC LIMIT 5
        ")->fetchAll();
    }

    public static function garanties($pdo) {
        $expirees = (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE GARANTIE < CURDATE()")->fetchColumn();
        $bientot  = (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE GARANTIE BETWEEN CURDATE() AND CURDATE() + INTERVAL 30 DAY")->fetchColumn();
        $valides  = (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE GARANTIE > CURDATE() + INTERVAL 30 DAY")->fetchColumn();
        return ['expirees' => $expirees, 'bientot' => $bientot, 'valides' => $valides];
    }

    public static function utilisateursParRole($pdo) {
        return $pdo->query("
            SELECT r.LIBELLE, COUNT(*) AS NB
            FROM UTILISATEUR u JOIN ROLE r ON u.ID_ROLE = r.ID_ROLE
            GROUP BY r.ID_ROLE, r.LIBELLE ORDER BY NB DESC
        ")->fetchAll();
    }

    public static function fournisseurs($pdo) {
        return $pdo->query("SELECT ID_FOURNISSEUR, NOM, TELEPHONE, EMAIL FROM FOURNISSEUR ORDER BY NOM ASC")->fetchAll();
    }

    public static function kpiDisponibilite($pdo) {
        $total = (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL")->fetchColumn();
        $dispo = (int)$pdo->query("SELECT COUNT(*) FROM MATERIEL WHERE ETAT = 'disponible'")->fetchColumn();
        return $total > 0 ? round($dispo * 100 / $total, 1) : 0;
    }

    public static function kpiTempsResolution($pdo) {
        $heures = $pdo->query("
            SELECT AVG(TIMESTAMPDIFF(HOUR, DATE_PANNE, DATE_INTERVENTION))
            FROM MAINTENANCE WHERE DATE_PANNE IS NOT NULL AND DATE_INTERVENTION IS NOT NULL
        ")->fetchColumn();
        return $heures === null ? 0 : round((float)$heures, 1);
    }
}