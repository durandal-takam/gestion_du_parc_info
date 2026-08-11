<?php
session_start();
require_once 'includes/functions.php';

// Redirection vers le tableau de bord
rediriger(BASE_URL . '/controllers/DashboardController.php');