<?php
require_once __DIR__ . '/../includes/functions.php';

class Stock {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT s.*, a.DESIGNATION AS ARTICLE_DESIGNATION, a.MARQUE, a.MODELE,
                   c.LIBELLE AS CATEGORIE_LIBELLE
            FROM STOCK s
            JOIN ARTICLE a ON s.ID_STOCK = a.ID_STOCK
            LEFT JOIN CATEGORIE_MATERIEL c ON a.ID_CATEGORIE = c.ID_CATEGORIE
            ORDER BY a.DESIGNATION ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT s.*, a.DESIGNATION AS ARTICLE_DESIGNATION, a.MARQUE, a.MODELE,
                   c.LIBELLE AS CATEGORIE_LIBELLE
            FROM STOCK s
            JOIN ARTICLE a ON s.ID_STOCK = a.ID_STOCK
            LEFT JOIN CATEGORIE_MATERIEL c ON a.ID_CATEGORIE = c.ID_CATEGORIE
            WHERE s.ID_STOCK = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function getMouvements($pdo, $idStock) {
        $stmt = $pdo->prepare("
            SELECT sm.*, u.PRENOM, u.NOM
            FROM STOCK_MOUVEMENT sm
            LEFT JOIN UTILISATEUR u ON sm.ID_USER = u.ID_USER
            WHERE sm.ID_STOCK = ?
            ORDER BY sm.DATE_MOUVEMENT DESC
        ");
        $stmt->execute([$idStock]);
        return $stmt->fetchAll();
    }

    public static function ajuster($pdo, $idStock, $type, $quantite, $motif, $idUser) {
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("SELECT QUANTITE_DISPO FROM STOCK WHERE ID_STOCK = ? FOR UPDATE");
            $stmt->execute([$idStock]);
            $dispo = $stmt->fetchColumn();

            if ($type === 'sortie' && $quantite > $dispo) {
                $pdo->rollBack();
                return false;
            }

            $stmt = $pdo->prepare("
                INSERT INTO STOCK_MOUVEMENT (ID_STOCK, TYPE_MOUVEMENT, QUANTITE, MOTIF, ID_USER, DATE_MOUVEMENT)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $stmt->execute([$idStock, $type, $quantite, $motif ?: null, $idUser]);

            $nouvelle_dispo = $type === 'entree' ? $dispo + $quantite : $dispo - $quantite;
            $stmt = $pdo->prepare("UPDATE STOCK SET QUANTITE_DISPO = ?, DATE_MISE_A_JOUR = NOW() WHERE ID_STOCK = ?");
            $stmt->execute([$nouvelle_dispo, $idStock]);

            $pdo->commit();
            return true;
        } catch (Exception $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public static function updateSeuil($pdo, $id, $seuil) {
        $stmt = $pdo->prepare("UPDATE STOCK SET SEUIL_ALERTE = ?, DATE_MISE_A_JOUR = NOW() WHERE ID_STOCK = ?");
        return $stmt->execute([$seuil, $id]);
    }
}