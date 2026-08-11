<?php
require_once __DIR__ . '/../includes/functions.php';

class Direction {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT d.*, COUNT(b.ID_BUREAU) AS NB_BUREAUX
            FROM DIRECTION d
            LEFT JOIN BUREAU b ON b.ID_DIRECTION = d.ID_DIRECTION
            GROUP BY d.ID_DIRECTION
            ORDER BY d.ID_DIRECTION ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM DIRECTION WHERE ID_DIRECTION = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO DIRECTION (NOM_DIRECTION, DESCRIPTION) VALUES (?, ?)");
        return $stmt->execute([$data['nom_direction'], $data['description']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE DIRECTION SET NOM_DIRECTION = ?, DESCRIPTION = ? WHERE ID_DIRECTION = ?");
        return $stmt->execute([$data['nom_direction'], $data['description'], $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM DIRECTION WHERE ID_DIRECTION = ?");
        return $stmt->execute([$id]);
    }
}