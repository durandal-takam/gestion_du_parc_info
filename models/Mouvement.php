<?php
require_once __DIR__ . '/../includes/functions.php';

class Mouvement {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT m.*, mat.DESIGNATION AS MATERIEL_DESIGNATION, mat.NUMERO_SERIE,
                   u.NOM, u.PRENOM
            FROM MOUVEMENT m
            LEFT JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            LEFT JOIN UTILISATEUR u ON m.ID_USER = u.ID_USER
            ORDER BY m.DATE_MOUVEMENT DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM MOUVEMENT WHERE ID_MOUVEMENT = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("
            INSERT INTO MOUVEMENT (ID_MATERIEL, ID_DEMANDE, ID_USER, TYPE_MOUVEMENT, DATE_MOUVEMENT, OBSERVATION)
            VALUES (?, NULL, ?, ?, NOW(), ?)
        ");
        return $stmt->execute([
            $data['id_materiel'] ?: null,
            $data['id_user'] ?: null,
            $data['type_mouvement'],
            $data['observation'],
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM MOUVEMENT WHERE ID_MOUVEMENT = ?");
        return $stmt->execute([$id]);
    }
}