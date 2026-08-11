<?php
require_once __DIR__ . '/../includes/functions.php';

class ContratMaintenance {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT c.*, p.NOM AS PRESTATAIRE_NOM
            FROM CONTRAT_MAINTENANCE c
            LEFT JOIN PRESTATAIRE p ON c.ID_PRESTATAIRE = p.ID_PRESTATAIRE
            ORDER BY c.DATE_DEBUT DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM CONTRAT_MAINTENANCE WHERE ID_CONTRAT = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("
            INSERT INTO CONTRAT_MAINTENANCE (ID_PRESTATAIRE, REFERENCE, DATE_DEBUT, DATE_FIN, MONTANT, OBSERVATION)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_prestataire'] ?: null,
            $data['reference'],
            $data['date_debut'] ?: null,
            $data['date_fin'] ?: null,
            $data['montant'] ?: null,
            $data['observation'],
        ]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE CONTRAT_MAINTENANCE SET
                ID_PRESTATAIRE = ?, REFERENCE = ?, DATE_DEBUT = ?, DATE_FIN = ?, MONTANT = ?, OBSERVATION = ?
            WHERE ID_CONTRAT = ?
        ");
        return $stmt->execute([
            $data['id_prestataire'] ?: null,
            $data['reference'],
            $data['date_debut'] ?: null,
            $data['date_fin'] ?: null,
            $data['montant'] ?: null,
            $data['observation'],
            $id,
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM CONTRAT_MAINTENANCE WHERE ID_CONTRAT = ?");
        return $stmt->execute([$id]);
    }
}