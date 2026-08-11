<div class="sidebar">
    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>/index.php">📊 Tableau de bord</a></li>

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
                <li><a href="#">🔧 Maintenances</a></li>
                <li><a href="#">📄 Fiches d'intervention</a></li>
            <?php endif; ?>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li class="nav-section">Gestion</li>
                <li><a href="<?= BASE_URL ?>/controllers/FournisseurController.php?action=list">🏢 Fournisseurs</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/ContratController.php?action=list">📝 Contrats</a></li>
                <li><a href="#">📦 Stocks</a></li>
                <li><a href="<?= BASE_URL ?>/controllers/PrestataireController.php?action=list">🛠️ Prestataires</a></li>
<li><a href="<?= BASE_URL ?>/controllers/DirectionController.php?action=list">🏢 Directions</a></li><li><a href="<?= BASE_URL ?>/controllers/BureauController.php?action=list">🚪 Bureaux</a></li>         
   <?php endif; ?>

            <li class="nav-section">Outils</li>
            <li><a href="#">📊 Rapports</a></li>
            <li><a href="#">📚 Base de connaissances</a></li>

            <?php if (aRole(ROLE_SUPER_ADMIN)): ?>
                <li class="nav-section">Administration</li>
                <li><a href="#">📋 Journaux</a></li>
                <li><a href="#">💾 Sauvegarde</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>