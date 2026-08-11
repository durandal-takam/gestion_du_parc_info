<?php
require_once __DIR__ . '/../includes/functions.php';

class Article {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT a.*, c.LIBELLE AS CATEGORIE_LIBELLE, f.NOM AS FOURNISSEUR_NOM, s.QUANTITE_DISPO
            FROM ARTICLE a
            LEFT JOIN CATEGORIE_MATERIEL c ON a.ID_CATEGORIE = c.ID_CATEGORIE
            LEFT JOIN FOURNISSEUR f ON a.ID_FOURNISSEUR = f.ID_FOURNISSEUR
            JOIN STOCK s ON a.ID_STOCK = s.ID_STOCK
            ORDER BY a.DESIGNATION ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("
            SELECT a.*, c.LIBELLE AS CATEGORIE_LIBELLE, f.NOM AS FOURNISSEUR_NOM
            FROM ARTICLE a
            LEFT JOIN CATEGORIE_MATERIEL c ON a.ID_CATEGORIE = c.ID_CATEGORIE
            LEFT JOIN FOURNISSEUR f ON a.ID_FOURNISSEUR = f.ID_FOURNISSEUR
            WHERE a.ID_ARTICLE = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        // 1. Créer le stock par défaut (0 disponible, 0 seuil)
        $stmt = $pdo->prepare("INSERT INTO STOCK (QUANTITE_DISPO, SEUIL_ALERTE, DATE_MISE_A_JOUR) VALUES (0, 0, NOW())");
        $stmt->execute();
        $id_stock = $pdo->lastInsertId();

        // 2. Créer l'article lié à ce stock
        $stmt = $pdo->prepare("
            INSERT INTO ARTICLE (ID_FOURNISSEUR, ID_STOCK, ID_CATEGORIE, DESIGNATION, MODELE, MARQUE, DESCRIPTION, PRIX_UNITAIRE)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_fournisseur'] ?: null,
            $id_stock,
            $data['id_categorie'] ?: null,
            $data['designation'],
            $data['modele'],
            $data['marque'],
            $data['description'],
            $data['prix_unitaire'] ?: null,
        ]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE ARTICLE SET
                ID_FOURNISSEUR = ?, ID_CATEGORIE = ?, DESIGNATION = ?, MODELE = ?, MARQUE = ?,
                DESCRIPTION = ?, PRIX_UNITAIRE = ?
            WHERE ID_ARTICLE = ?
        ");
        return $stmt->execute([
            $data['id_fournisseur'] ?: null,
            $data['id_categorie'] ?: null,
            $data['designation'],
            $data['modele'],
            $data['marque'],
            $data['description'],
            $data['prix_unitaire'] ?: null,
            $id,
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM ARTICLE WHERE ID_ARTICLE = ?");
        return $stmt->execute([$id]);
    }
}