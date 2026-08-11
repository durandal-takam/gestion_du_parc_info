<?php
require_once __DIR__ . '/../includes/functions.php';

class DemandeMaintenance {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT d.*, u.NOM, u.PRENOM,
                   m.DESIGNATION AS MATERIEL_DESIGNATION, m.NUMERO_SERIE,
                   cp.LIBELLE AS CATEGORIE_LIBELLE
            FROM DEMANDE_MAINTENANCE d
            JOIN UTILISATEUR u ON d.ID_USER = u.ID_USER
            LEFT JOIN MATERIEL m ON d.ID_MATERIEL = m.ID_MATERIEL
            LEFT JOIN CATEGORIE_PANNE cp ON d.ID_CATEGORIE_PANNE = cp.ID_CATEGORIE_PANNE
            ORDER BY d.DATE_DEMANDE DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM DEMANDE_MAINTENANCE WHERE ID_DEMANDE = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
        $stmt = $pdo->prepare("
            INSERT INTO DEMANDE_MAINTENANCE (ID_USER, ID_MATERIEL, ID_CATEGORIE_PANNE, DATE_DEMANDE, DESCRIPTION, STATUT, PRIORITE)
            VALUES (?, ?, ?, NOW(), ?, 'Ouvert', ?)
        ");
        return $stmt->execute([
            $data['id_user'],
            $data['id_materiel'] ?: null,
            $data['id_categorie_panne'] ?: null,
            $data['description'],
            $data['priorite'],
        ]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE DEMANDE_MAINTENANCE SET
                ID_MATERIEL = ?, ID_CATEGORIE_PANNE = ?, DESCRIPTION = ?, STATUT = ?, PRIORITE = ?
            WHERE ID_DEMANDE = ?
        ");
        return $stmt->execute([
            $data['id_materiel'] ?: null,
            $data['id_categorie_panne'] ?: null,
            $data['description'],
            $data['statut'],
            $data['priorite'],
            $id,
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM DEMANDE_MAINTENANCE WHERE ID_DEMANDE = ?");
        return $stmt->execute([$id]);
    }
}