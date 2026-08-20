<?php
require_once __DIR__ . '/../includes/functions.php';

class Journal {

    public static function countAll($pdo, $filtres) {
        [$where, $params] = self::construireFiltres($filtres);
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM JOURNAL j $where");
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

        public static function getAll($pdo, $filtres, $limite = null, $offset = 0) {
        [$where, $params] = self::construireFiltres($filtres);
        $pagination = ($limite !== null)
            ? "LIMIT " . (int)$limite . " OFFSET " . (int)$offset
            : "";
        $sql = "
            SELECT j.*, u.PRENOM, u.NOM
            FROM JOURNAL j
            LEFT JOIN UTILISATEUR u ON j.ID_USER = u.ID_USER
            $where
            ORDER BY j.DATE_ACTION DESC, j.ID_JOURNAL DESC
            $pagination
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private static function construireFiltres($filtres) {
        $conditions = [];
        $params = [];
        if (!empty($filtres['id_user'])) {
            $conditions[] = 'j.ID_USER = ?';
            $params[] = $filtres['id_user'];
        }
        if (!empty($filtres['action'])) {
            $conditions[] = 'j.ACTION = ?';
            $params[] = $filtres['action'];
        }
        if (!empty($filtres['date_debut'])) {
            $conditions[] = 'j.DATE_ACTION >= ?';
            $params[] = $filtres['date_debut'] . ' 00:00:00';
        }
        if (!empty($filtres['date_fin'])) {
            $conditions[] = 'j.DATE_ACTION <= ?';
            $params[] = $filtres['date_fin'] . ' 23:59:59';
        }
        return [
            empty($conditions) ? '' : 'WHERE ' . implode(' AND ', $conditions),
            $params,
        ];
    }

    public static function getUtilisateursDistincts($pdo) {
        return $pdo->query("
            SELECT DISTINCT u.ID_USER, u.PRENOM, u.NOM
            FROM JOURNAL j JOIN UTILISATEUR u ON j.ID_USER = u.ID_USER
            ORDER BY u.NOM ASC
        ")->fetchAll();
    }

    public static function getActionsDistinctes($pdo) {
        return $pdo->query("SELECT DISTINCT ACTION FROM JOURNAL ORDER BY ACTION ASC")->fetchAll();
    }
}