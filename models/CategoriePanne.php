<?php
require_once __DIR__ . '/../includes/functions.php';

class CategoriePanne {

    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM CATEGORIE_PANNE ORDER BY LIBELLE ASC");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM CATEGORIE_PANNE WHERE ID_CATEGORIE_PANNE = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO CATEGORIE_PANNE (LIBELLE, DESCRIPTION) VALUES (?, ?)");
        return $stmt->execute([$data['libelle'], $data['description']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE CATEGORIE_PANNE SET LIBELLE = ?, DESCRIPTION = ? WHERE ID_CATEGORIE_PANNE = ?");
        return $stmt->execute([$data['libelle'], $data['description'], $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM CATEGORIE_PANNE WHERE ID_CATEGORIE_PANNE = ?");
        return $stmt->execute([$id]);
    }
}