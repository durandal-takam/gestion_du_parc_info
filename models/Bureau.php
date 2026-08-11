<?php
require_once __DIR__ . '/../includes/functions.php';

class Bureau {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT b.*, d.NOM_DIRECTION
            FROM BUREAU b
            JOIN DIRECTION d ON b.ID_DIRECTION = d.ID_DIRECTION
            ORDER BY b.NOM_BUREAU ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM BUREAU WHERE ID_BUREAU = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO BUREAU (ID_DIRECTION, NOM_BUREAU, LOCALISATION) VALUES (?, ?, ?)");
        return $stmt->execute([$data['id_direction'], $data['nom_bureau'], $data['localisation']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE BUREAU SET ID_DIRECTION = ?, NOM_BUREAU = ?, LOCALISATION = ? WHERE ID_BUREAU = ?");
        return $stmt->execute([$data['id_direction'], $data['nom_bureau'], $data['localisation'], $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM BUREAU WHERE ID_BUREAU = ?");
        return $stmt->execute([$id]);
    }
}