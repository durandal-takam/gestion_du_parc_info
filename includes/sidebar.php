<div class="sidebar">
    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>/index.php">📊 Tableau de bord</a></li>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li class="nav-section">Gestion des utilisateurs</li>
                <li><a href="#">👥 Utilisateurs</a></li>
                <li><a href="#">🎭 Rôles</a></li>
            <?php endif; ?>

            <li class="nav-section">Parc informatique</li>
            <li><a href="#">💻 Équipements</a></li>
            <li><a href="#">📦 Articles</a></li>
            <li><a href="#">🏷️ Catégories</a></li>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li><a href="#">📋 Affectations</a></li>
                <li><a href="#">🔄 Mouvements</a></li>
            <?php endif; ?>

            <li class="nav-section">Assistance</li>
            <li><a href="#">🎫 Tickets</a></li>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN) || aRole(ROLE_TECHNICIEN)): ?>
                <li><a href="#">🔧 Maintenances</a></li>
                <li><a href="#">📄 Fiches d'intervention</a></li>
            <?php endif; ?>

            <?php if (aRole(ROLE_SUPER_ADMIN) || aRole(ROLE_ADMIN)): ?>
                <li class="nav-section">Gestion</li>
                <li><a href="#">🏢 Fournisseurs</a></li>
                <li><a href="#">📝 Contrats</a></li>
                <li><a href="#">📦 Stocks</a></li>
                <li><a href="#">🏢 Bureaux & Directions</a></li>
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