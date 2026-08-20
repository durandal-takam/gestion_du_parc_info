<?php require_once __DIR__ . '/../models/Alertes.php'; ?>
<?php $nb_alertes = Alertes::compteur($pdo); ?>
<div class="sidebar">
    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>/index.php">📊 Tableau de bord</a></li>
            <li><a href="<?= BASE_URL ?>/controllers/PortailController.php?action=index">🏠 Mon espace</a></li>
                       <li><a href="<?= BASE_URL ?>/controllers/AlertesController.php?action=index">🔔 Alertes <?php if ($nb_alertes > 0): ?><span class="badge badge-primary"><?= $nb_alertes ?></span><?php endif; ?></a></li>
            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li class="nav-section">Gestion des utilisateurs</li>
                <li><a href="<?= BASE_URL ?>/controllers/UtilisateurController.php?action=list">👥 Utilisateurs</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/RoleController.php?action=list">🎭 Rôles</a></li>
            <?php endif; ?>

            <li class="nav-section">Parc informatique</li>
            <li><a href="<?= BASE_URL ?>/controllers/MaterielController.php?action=list">💻 Équipements</a></li> 
            <li><a href="<?= BASE_URL ?>/controllers/ArticleController.php?action=list">📦 Articles</a></li>
            <li><a href="<?= BASE_URL ?>/controllers/CategorieMaterielController.php?action=list">🏷️ Catégories</a></li>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li><a href="<?= BASE_URL ?>/controllers/AffectationController.php?action=list">📋 Affectations</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/MouvementController.php?action=list">🔄 Mouvements</a></li>
            <?php endif; ?>

            <li class="nav-section">Assistance</li>
            <li><a href="<?= BASE_URL ?>/controllers/CategoriePanneController.php?action=list">⚠️ Catégories de pannes</a></li>
            <li><a href="<?= BASE_URL ?>/controllers/DemandeController.php?action=list">🎫 Tickets</a></li>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN) || aRole(ROLE_TECHNICIEN)): ?>
                <li><a href="<?= BASE_URL ?>/controllers/MaintenanceController.php?action=list">🔧 Maintenances</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/FicheInterventionController.php?action=list">📄 Fiches d'intervention</a></li>
            <?php endif; ?>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li class="nav-section">Gestion</li>
                <li><a href="<?= BASE_URL ?>/controllers/FournisseurController.php?action=list">🏢 Fournisseurs</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/ContratController.php?action=list">📝 Contrats</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/StockController.php?action=list">📦 Stocks</a></li>                <li><a href="<?= BASE_URL ?>/controllers/PrestataireController.php?action=list">🛠️ Prestataires</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/DirectionController.php?action=list">🏢 Directions</a></li><li><a href="<?= BASE_URL ?>/controllers/BureauController.php?action=list">🚪 Bureaux</a></li>   
                <li><a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=list">📋 Inventaires</a></li>      
   <?php endif; ?>

            <li class="nav-section">Outils</li>
                <li><a href="<?= BASE_URL ?>/controllers/RapportController.php?action=index">📊 Rapports</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/BaseConnaissanceController.php?action=index">📚 Base de connaissances</a></li>
            <?php if (aRole(ROLE_DIRECTION)): ?>
                <li class="nav-section">Pilotage</li>
                <li><a href="<?= BASE_URL ?>/controllers/PilotageController.php?action=index">📈 Tableau de bord Direction</a></li>
            <?php endif; ?>
            <?php if (aRole(ROLE_SUPER_ADMIN)): ?>
                <li class="nav-section">Administration</li>
                <li><a href="<?= BASE_URL ?>/controllers/JournalController.php?action=list">📋 Journaux</a></li>
                <li><a href="#">💾 Sauvegarde</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>