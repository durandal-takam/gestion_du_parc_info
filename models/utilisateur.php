<?php
require_once __DIR__ . '/../includes/functions.php';

class Utilisateur {

    // Récupérer tous les utilisateurs avec leur rôle
    public static function getAll($pdo) {
        $stmt = $pdo->query("
           SELECT u.*, r.LIBELLE as ROLE_LIBELLE,
       (u.DERNIERE_CONNEXION >= NOW() - INTERVAL 5 MINUTE) AS EN_LIGNE
FROM UTILISATEUR u
JOIN ROLE r ON u.ID_ROLE = r.ID_ROLE
ORDER BY u.NOM ASC");
        return $stmt->fetchAll();
    }

    // Récupérer un utilisateur par son ID
    public static function getById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM UTILISATEUR WHERE ID_USER = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Créer un nouvel utilisateur
    public static function create($pdo, $data) {
        $mdp_hash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("
            INSERT INTO UTILISATEUR (NOM, PRENOM, EMAIL, TELEPHONE, LOGIN, MOT_DE_PASSE, ID_ROLE, STATUT)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['login'],
            $mdp_hash,
            $data['id_role'],
            $data['statut']
        ]);
    }

    // Modifier un utilisateur
    public static function update($pdo, $id, $data) {
        if (!empty($data['mot_de_passe'])) {
            $mdp_hash = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("
                UPDATE UTILISATEUR SET NOM=?, PRENOM=?, EMAIL=?, TELEPHONE=?, LOGIN=?, MOT_DE_PASSE=?, ID_ROLE=?, STATUT=?
                WHERE ID_USER = ?
            ");
            return $stmt->execute([
                $data['nom'], $data['prenom'], $data['email'], $data['telephone'],
                $data['login'], $mdp_hash, $data['id_role'], $data['statut'], $id
            ]);
        } else {
            $stmt = $pdo->prepare("
                UPDATE UTILISATEUR SET NOM=?, PRENOM=?, EMAIL=?, TELEPHONE=?, LOGIN=?, ID_ROLE=?, STATUT=?
                WHERE ID_USER = ?
            ");
            return $stmt->execute([
                $data['nom'], $data['prenom'], $data['email'], $data['telephone'],
                $data['login'], $data['id_role'], $data['statut'], $id
            ]);
        }
    }

    // Supprimer un utilisateur
    public static function delete($pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM UTILISATEUR WHERE ID_USER = ?");
        return $stmt->execute([$id]);
    }

    // Vérifier si un login existe déjà
    public static function loginExiste($pdo, $login, $exclude_id = null) {
        if ($exclude_id) {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM UTILISATEUR WHERE LOGIN = ? AND ID_USER != ?");
            $stmt->execute([$login, $exclude_id]);
        } else {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM UTILISATEUR WHERE LOGIN = ?");
            $stmt->execute([$login]);
        }
        return $stmt->fetchColumn() > 0;
    }
}