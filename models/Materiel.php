<?php
require_once __DIR__ . '/../includes/functions.php';

class Materiel {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT m.*, a.DESIGNATION AS ARTICLE_DESIGNATION, a.MARQUE, a.MODELE,
                   c.LIBELLE AS CATEGORIE_LIBELLE
            FROM MATERIEL m
            LEFT JOIN ARTICLE a ON m.ID_ARTICLE = a.ID_ARTICLE
            LEFT JOIN CATEGORIE_MATERIEL c ON a.ID_CATEGORIE = c.ID_CATEGORIE
            ORDER BY m.ID_MATERIEL DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM MATERIEL WHERE ID_MATERIEL = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("
            INSERT INTO MATERIEL (ID_ARTICLE, DESIGNATION, NUMERO_SERIE, DATE_D_ACQUISITION,
                                  DATE_MISE_EN_SERVICE, ETAT, LOCALISATION, GARANTIE, CONFIGURATION)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_article'] ?: null,
            $data['designation'],
            $data['numero_serie'],
            $data['date_acquisition'] ?: null,
            $data['date_mise_en_service'] ?: null,
            $data['etat'] ?: 'disponible',
            $data['localisation'],
            $data['garantie'],
            $data['configuration'],
        ]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE MATERIEL SET
                ID_ARTICLE = ?, DESIGNATION = ?, NUMERO_SERIE = ?, DATE_D_ACQUISITION = ?,
                DATE_MISE_EN_SERVICE = ?, ETAT = ?, LOCALISATION = ?, GARANTIE = ?, CONFIGURATION = ?
            WHERE ID_MATERIEL = ?
        ");
        return $stmt->execute([
            $data['id_article'] ?: null,
            $data['designation'],
            $data['numero_serie'],
            $data['date_acquisition'] ?: null,
            $data['date_mise_en_service'] ?: null,
            $data['etat'] ?: 'disponible',
            $data['localisation'],
            $data['garantie'],
            $data['configuration'],
            $id,
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM MATERIEL WHERE ID_MATERIEL = ?");
        return $stmt->execute([$id]);
    }
}