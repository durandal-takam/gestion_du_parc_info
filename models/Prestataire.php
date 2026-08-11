<?php
require_once __DIR__ . '/../includes/functions.php';

class Prestataire {

    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM PRESTATAIRE ORDER BY NOM ASC");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM PRESTATAIRE WHERE ID_PRESTATAIRE = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("INSERT INTO PRESTATAIRE (NOM, TELEPHONE, EMAIL, ADRESSE) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['nom'], $data['telephone'], $data['email'], $data['adresse']]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("UPDATE PRESTATAIRE SET NOM = ?, TELEPHONE = ?, EMAIL = ?, ADRESSE = ? WHERE ID_PRESTATAIRE = ?");
        return $stmt->execute([$data['nom'], $data['telephone'], $data['email'], $data['adresse'], $id]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM PRESTATAIRE WHERE ID_PRESTATAIRE = ?");
        return $stmt->execute([$id]);
    }
}