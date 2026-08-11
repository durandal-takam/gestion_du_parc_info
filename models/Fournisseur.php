<?php
require_once __DIR__ . '/../includes/functions.php';

class Fournisseur {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT f.*, COUNT(a.ID_ARTICLE) AS NB_ARTICLES
            FROM FOURNISSEUR f
            LEFT JOIN ARTICLE a ON a.ID_FOURNISSEUR = f.ID_FOURNISSEUR
            GROUP BY f.ID_FOURNISSEUR
            ORDER BY f.NOM ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM FOURNISSEUR WHERE ID_FOURNISSEUR = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function emailExiste($pdo, $email, $exclure_id = 0) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM FOURNISSEUR WHERE EMAIL = ? AND ID_FOURNISSEUR != ?");
        $stmt->execute([$email, $exclure_id]);
        return $stmt->fetchColumn() > 0;
    }

    public static function countArticles($pdo, $id) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM ARTICLE WHERE ID_FOURNISSEUR = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO FOURNISSEUR (NOM, TELEPHONE, EMAIL, ADRESSE) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['nom'], $data['telephone'], $data['email'], $data['adresse']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE FOURNISSEUR SET NOM = ?, TELEPHONE = ?, EMAIL = ?, ADRESSE = ? WHERE ID_FOURNISSEUR = ?");
        return $stmt->execute([$data['nom'], $data['telephone'], $data['email'], $data['adresse'], $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM FOURNISSEUR WHERE ID_FOURNISSEUR = ?");
        return $stmt->execute([$id]);
    }
}