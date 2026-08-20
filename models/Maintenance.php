<?php
require_once __DIR__ . '/../includes/functions.php';

class Maintenance {

    public static function getAll($pdo) {
        $stmt = $pdo->query("
            SELECT m.*, t.LIBELLE AS TYPE_LIBELLE,
                   u.NOM, u.PRENOM,
                   c.REFERENCE AS CONTRAT_REFERENCE,
                   d.ID_DEMANDE,
                   mat.DESIGNATION AS MATERIEL_DESIGNATION, mat.NUMERO_SERIE,
                   cp.LIBELLE AS CATEGORIE_LIBELLE
            FROM MAINTENANCE m
            JOIN TYPE_MAINTENANCE t ON m.ID_TYPE = t.ID_TYPE
            JOIN UTILISATEUR u ON m.ID_USER = u.ID_USER
            LEFT JOIN CONTRAT_MAINTENANCE c ON m.ID_CONTRAT = c.ID_CONTRAT
            LEFT JOIN DEMANDE_MAINTENANCE d ON m.ID_DEMANDE = d.ID_DEMANDE
            LEFT JOIN MATERIEL mat ON m.ID_MATERIEL = mat.ID_MATERIEL
            LEFT JOIN CATEGORIE_PANNE cp ON m.ID_CATEGORIE_PANNE = cp.ID_CATEGORIE_PANNE
            ORDER BY m.DATE_INTERVENTION DESC
        ");
        return $stmt->fetchAll();
    }

    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM MAINTENANCE WHERE ID_MAINTENANCE = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function create($pdo, $data) {
                      $stmt = $pdo->prepare("
            INSERT INTO MAINTENANCE (ID_TYPE, ID_USER, ID_CONTRAT, ID_DEMANDE, ID_MATERIEL,
                                     DATE_PANNE, DESCRIPTION, DATE_INTERVENTION, SOLUTION, COUT, ID_CATEGORIE_PANNE)
            VALUES (?, ?, ?, ?, ?, COALESCE(?, NOW()), ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['id_type'],
            $data['id_user'],
            $data['id_contrat'] ?: null,
            $data['id_demande'] ?: null,
            $data['id_materiel'] ?: null,
            $data['date_panne'] ?: null,
            $data['description'],
            $data['date_intervention'] ?: null,
            $data['solution'],
            $data['cout'] ?: null,
            $data['id_categorie_panne'] ?: null,
        ]);
    }

    public static function update($pdo, $id, $data) {
        $stmt = $pdo->prepare("
            UPDATE MAINTENANCE SET
                ID_TYPE = ?, ID_USER = ?, ID_CONTRAT = ?, ID_DEMANDE = ?, ID_MATERIEL = ?,
                DATE_PANNE = ?, DESCRIPTION = ?, DATE_INTERVENTION = ?, SOLUTION = ?, COUT = ?, ID_CATEGORIE_PANNE = ?
            WHERE ID_MAINTENANCE = ?
        ");
        return $stmt->execute([
            $data['id_type'],
            $data['id_user'],
            $data['id_contrat'] ?: null,
            $data['id_demande'] ?: null,
            $data['id_materiel'] ?: null,
            $data['date_panne'] ?: null,
            $data['description'],
            $data['date_intervention'] ?: null,
            $data['solution'],
            $data['cout'] ?: null,
            $data['id_categorie_panne'] ?: null,
            $id,
        ]);
    }

    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM MAINTENANCE WHERE ID_MAINTENANCE = ?");
        return $stmt->execute([$id]);
    }
}