<?php
require_once __DIR__ . '/../includes/functions.php';

class FicheIntervention {

    public static function getAll($pdo) {
               $stmt = $pdo->query("
            SELECT f.*, mat.DESIGNATION AS MATERIEL_DESIGNATION, mat.NUMERO_SERIE,
                   m.DESCRIPTION AS PANNE_DESCRIPTION, m.DATE_PANNE,
                   t.NOM, t.PRENOM
            FROM FICHE_INTERVENTION f
            JOIN MAINTENANCE m ON f.ID_MAINTENANCE = m.ID_MAINTENANCE
            JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            JOIN UTILISATEUR t ON f.ID_TECHNICIEN = t.ID_USER
            ORDER BY f.DATE_FICHE DESC, f.ID_FICHE DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
                $stmt = $pdo->prepare("
            SELECT f.*, mat.DESIGNATION AS MATERIEL_DESIGNATION, mat.NUMERO_SERIE,
                   m.DESCRIPTION AS PANNE_DESCRIPTION, m.DATE_PANNE,
                   t.NOM, t.PRENOM
            FROM FICHE_INTERVENTION f
            JOIN MAINTENANCE m ON f.ID_MAINTENANCE = m.ID_MAINTENANCE
            JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            JOIN UTILISATEUR t ON f.ID_TECHNICIEN = t.ID_USER
            WHERE f.ID_FICHE = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getMaintenancesSansFiche($pdo, $exclureIdFiche = null) {
        $stmt = $pdo->prepare("
            SELECT m.*, mat.DESIGNATION AS MATERIEL_DESIGNATION, mat.NUMERO_SERIE
            FROM MAINTENANCE m
            LEFT JOIN FICHE_INTERVENTION f ON f.ID_MAINTENANCE = m.ID_MAINTENANCE
            LEFT JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            WHERE f.ID_FICHE IS NULL OR f.ID_FICHE = ?
            ORDER BY m.ID_MAINTENANCE DESC
        ");
        $stmt->execute([$exclureIdFiche]);
        return $stmt->fetchAll();
    }

    public static function genererNumero($pdo) {
        $annee = date('Y');
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM FICHE_INTERVENTION WHERE YEAR(DATE_FICHE) = ?");
        $stmt->execute([$annee]);
        return 'FI-' . $annee . '-' . str_pad($stmt->fetchColumn() + 1, 4, '0', STR_PAD_LEFT);
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("
            INSERT INTO FICHE_INTERVENTION (NUMERO_FICHE, DATE_FICHE, TRAVAUX_EFFECTUES, OBSERVATIONS,
                                            FICHIER_NUMERISE, ID_MAINTENANCE, ID_TECHNICIEN, NOM_RESPONSABLE,
                                            SIGNATURE_TECHNICIEN, SIGNATURE_RESPONSABLE)
            VALUES (?, CURDATE(), ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['numero_fiche'],
            $data['travaux_effectues'],
            $data['observations'],
            $data['fichier_numerise'],
            $data['id_maintenance'],
            $data['id_technicien'],
            $data['nom_responsable'],
            $data['signature_technicien'],
            $data['signature_responsable'],
        ]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE FICHE_INTERVENTION SET
                TRAVAUX_EFFECTUES = ?, OBSERVATIONS = ?, FICHIER_NUMERISE = ?, ID_MAINTENANCE = ?,
                ID_TECHNICIEN = ?, NOM_RESPONSABLE = ?, SIGNATURE_TECHNICIEN = ?, SIGNATURE_RESPONSABLE = ?
            WHERE ID_FICHE = ?
        ");
        return $stmt->execute([
            $data['travaux_effectues'],
            $data['observations'],
            $data['fichier_numerise'],
            $data['id_maintenance'],
            $data['id_technicien'],
            $data['nom_responsable'],
            $data['signature_technicien'],
            $data['signature_responsable'],
            $id,
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM FICHE_INTERVENTION WHERE ID_FICHE = ?");
        return $stmt->execute([$id]);
    }
}