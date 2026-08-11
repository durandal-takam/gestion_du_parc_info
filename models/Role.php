<?php
require_once __DIR__ . '/../includes/functions.php';

class Role {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT r.*, COUNT(u.ID_USER) AS NB_UTILISATEURS
            FROM ROLE r
            LEFT JOIN UTILISATEUR u ON u.ID_ROLE = r.ID_ROLE
            GROUP BY r.ID_ROLE
            ORDER BY r.ID_ROLE ASC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM ROLE WHERE ID_ROLE = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO ROLE (LIBELLE, DESCRIPTION) VALUES (?, ?)");
        return $stmt->execute([$data['libelle'], $data['description']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE ROLE SET LIBELLE = ?, DESCRIPTION = ? WHERE ID_ROLE = ?");
        return $stmt->execute([$data['libelle'], $data['description'], $id]);
    }

    public static function countUtilisateurs($pdo, $id) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM UTILISATEUR WHERE ID_ROLE = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM ROLE WHERE ID_ROLE = ?");
        return $stmt->execute([$id]);
    }
}