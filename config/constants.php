<?php
// config/constants.php - Constantes globales

define('BASE_URL', 'http://localhost/appli_parc_info_minac');
define('APP_NAME', 'Gestion du Parc Informatique');
define('APP_VERSION', '1.0.0');

// Chemins
define('VIEWS_PATH', __DIR__ . '/../views/');
define('UPLOADS_PATH', __DIR__ . '/../uploads/');

// Types d'utilisateurs (rôles)
define('ROLE_SUPER_ADMIN', 1);
define('ROLE_ADMIN', 2);
define('ROLE_TECHNICIEN', 3);
define('ROLE_RESPONSABLE', 4);
define('ROLE_DIRECTION', 5);