<?php
require_once __DIR__ . '/../includes/functions.php';

class CategorieMateriel {

    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM CATEGORIE_MATERIEL ORDER BY LIBELLE ASC");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM CATEGORIE_MATERIEL WHERE ID_CATEGORIE = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO CATEGORIE_MATERIEL (LIBELLE, DESCRIPTION) VALUES (?, ?)");
        return $stmt->execute([$data['libelle'], $data['description']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE CATEGORIE_MATERIEL SET LIBELLE = ?, DESCRIPTION = ? WHERE ID_CATEGORIE = ?");
        return $stmt->execute([$data['libelle'], $data['description'], $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM CATEGORIE_MATERIEL WHERE ID_CATEGORIE = ?");
        return $stmt->execute([$id]);
    }
}