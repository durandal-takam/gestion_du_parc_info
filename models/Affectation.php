<?php
require_once __DIR__ . '/../includes/functions.php';

class Affectation {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT a.*, u.NOM, u.PRENOM, m.DESIGNATION AS MATERIEL_DESIGNATION, m.NUMERO_SERIE
            FROM AFFECTATION a
            JOIN UTILISATEUR u ON a.ID_USER = u.ID_USER
            JOIN MATERIEL m ON a.ID_MATERIEL = m.ID_MATERIEL
            ORDER BY a.DATE_AFFECTATION DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT a.*, u.NOM, u.PRENOM, m.DESIGNATION AS MATERIEL_DESIGNATION
            FROM AFFECTATION a
            JOIN UTILISATEUR u ON a.ID_USER = u.ID_USER
            JOIN MATERIEL m ON a.ID_MATERIEL = m.ID_MATERIEL
            WHERE a.ID_AFFECTATION = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Seuls les matériels libres peuvent être affectés
    public static function getMaterielsDisponibles($pdo) {
        $stmt = $pdo->query("
            SELECT * FROM MATERIEL WHERE ETAT = 'disponible'
            ORDER BY DESIGNATION ASC
        ");
        return $stmt->fetchAll();
    }

    public static function create($pdo, $data) {
        $pdo->beginTransaction();
        try {
            // Garde : le matériel doit exister ET être disponible
            $stmt = $pdo->prepare("SELECT ID_MATERIEL FROM MATERIEL WHERE ID_MATERIEL = ? AND ETAT = 'disponible'");
            $stmt->execute([$data['id_materiel']]);
            if (!$stmt->fetch()) {
                throw new Exception('Ce matériel n\'est pas disponible.');
            }

            $stmt = $pdo->prepare("
                INSERT INTO AFFECTATION (ID_USER, ID_MATERIEL, DATE_AFFECTATION, STATUT)
                VALUES (?, ?, ?, 'active')
            ");
            $stmt->execute([$data['id_user'], $data['id_materiel'], $data['date_affectation']]);

            // Le matériel devient affecté
            $stmt = $pdo->prepare("UPDATE MATERIEL SET ETAT = 'affecté' WHERE ID_MATERIEL = ?");
            $stmt->execute([$data['id_materiel']]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return $e->getMessage();
        }
    }

    public static function terminer($pdo, $id) {
        $pdo->beginTransaction();
        try {
            // Garde : ne terminer que les affectations actives
            $stmt = $pdo->prepare("SELECT ID_MATERIEL FROM AFFECTATION WHERE ID_AFFECTATION = ? AND STATUT = 'active'");
            $stmt->execute([$id]);
            $aff = $stmt->fetch();
            if (!$aff) {
                throw new Exception('Cette affectation est déjà terminée ou n\'existe pas.');
            }

            $stmt = $pdo->prepare("UPDATE AFFECTATION SET STATUT = 'terminée', DATE_RETOUR = CURDATE() WHERE ID_AFFECTATION = ?");
            $stmt->execute([$id]);

            // Le matériel redevient disponible
            $stmt = $pdo->prepare("UPDATE MATERIEL SET ETAT = 'disponible' WHERE ID_MATERIEL = ?");
            $stmt->execute([$aff['ID_MATERIEL']]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return $e->getMessage();
        }
    }

    public static function delete($pdo, $id) {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("SELECT STATUT, ID_MATERIEL FROM AFFECTATION WHERE ID_AFFECTATION = ?");
        $stmt->execute([$id]);
        $aff = $stmt->fetch();

        $stmt = $pdo->prepare("DELETE FROM AFFECTATION WHERE ID_AFFECTATION = ?");
        $stmt->execute([$id]);

        // Si on supprime une affectation active, le matériel redevient disponible
        if ($aff && $aff['STATUT'] === 'active') {
            $stmt = $pdo->prepare("UPDATE MATERIEL SET ETAT = 'disponible' WHERE ID_MATERIEL = ?");
            $stmt->execute([$aff['ID_MATERIEL']]);
        }
        $pdo->commit();
        return true;
    }
}