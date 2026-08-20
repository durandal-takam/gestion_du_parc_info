<?php
require_once __DIR__ . '/../includes/functions.php';

class Inventaire {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT i.*, u.PRENOM, u.NOM, COUNT(d.ID_DETAIL) AS NB_DETAILS
            FROM INVENTAIRE i
            JOIN UTILISATEUR u ON i.ID_USER = u.ID_USER
            LEFT JOIN DETAIL_INVENTAIRE d ON d.NUMERO_INVENTAIRE = i.NUMERO_INVENTAIRE
            GROUP BY i.NUMERO_INVENTAIRE, i.ID_USER, i.DATE_INVENTAIRE, i.OBSERVATION, u.PRENOM, u.NOM
            ORDER BY i.DATE_INVENTAIRE DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $numero) {
        $stmt = $pdo->prepare("
            SELECT i.*, u.PRENOM, u.NOM
            FROM INVENTAIRE i
            JOIN UTILISATEUR u ON i.ID_USER = u.ID_USER
            WHERE i.NUMERO_INVENTAIRE = ?
        ");
        $stmt->execute([$numero]);
        return $stmt->fetch();
    }

    public static function getDetails($pdo, $numero) {
        $stmt = $pdo->prepare("
            SELECT d.*, mat.DESIGNATION AS MATERIEL_DESIGNATION, mat.NUMERO_SERIE, mat.ETAT
            FROM DETAIL_INVENTAIRE d
            JOIN MATERIEL mat ON d.ID_MATERIEL = mat.ID_MATERIEL
            WHERE d.NUMERO_INVENTAIRE = ?
            ORDER BY mat.DESIGNATION ASC
        ");
        $stmt->execute([$numero]);
        return $stmt->fetchAll();
    }

    public static function getMateriels($pdo) {
        return $pdo->query("
            SELECT ID_MATERIEL, DESIGNATION, NUMERO_SERIE, ETAT
            FROM MATERIEL ORDER BY DESIGNATION ASC
        ")->fetchAll();
    }

    public static function genererNumero($pdo) {
        $annee = date('Y');
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM INVENTAIRE WHERE YEAR(DATE_INVENTAIRE) = ?");
        $stmt->execute([$annee]);
        return 'INV-' . $annee . '-' . str_pad($stmt->fetchColumn() + 1, 4, '0', STR_PAD_LEFT);
    }

    public static function create($pdo, $data, $details) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("
                INSERT INTO INVENTAIRE (NUMERO_INVENTAIRE, ID_USER, DATE_INVENTAIRE, OBSERVATION)
                VALUES (?, ?, CURDATE(), ?)
            ");
            $stmt->execute([$data['numero'], $data['id_user'], $data['observation']]);

            $stmt = $pdo->prepare("
                INSERT INTO DETAIL_INVENTAIRE (ID_MATERIEL, ETAT_CONSTATE, REMARQUE, NUMERO_INVENTAIRE)
                VALUES (?, ?, ?, ?)
            ");
            foreach ($details as $d) {
                $stmt->execute([$d['id_materiel'], $d['etat'], $d['remarque'], $data['numero']]);
            }

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public static function update($pdo, $numero, $observation, $details) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("
                UPDATE DETAIL_INVENTAIRE SET ETAT_CONSTATE = ?, REMARQUE = ? WHERE ID_DETAIL = ?
            ");
            foreach ($details as $d) {
                $stmt->execute([$d['etat'], $d['remarque'], $d['id_detail']]);
            }

            $stmt = $pdo->prepare("UPDATE INVENTAIRE SET OBSERVATION = ? WHERE NUMERO_INVENTAIRE = ?");
            $stmt->execute([$observation, $numero]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public static function delete($pdo, $numero) {
        $pdo->beginTransaction();
        try {
            $pdo->prepare("DELETE FROM DETAIL_INVENTAIRE WHERE NUMERO_INVENTAIRE = ?")->execute([$numero]);
            $pdo->prepare("DELETE FROM INVENTAIRE WHERE NUMERO_INVENTAIRE = ?")->execute([$numero]);
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }
}