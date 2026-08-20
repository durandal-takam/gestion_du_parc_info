<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <h1>Tableau de bord</h1>

    <?php if (($stats['alertes_total'] ?? 0) > 0): ?>
        <div style="background: #fdecea; border: 1px solid #f5c6cb; border-radius: 6px; padding: 10px 15px; margin-bottom: 15px;">
            🔔 <strong><?= $stats['alertes_total'] ?> alerte(s) active(s)</strong> —
            <a href="<?= BASE_URL ?>/controllers/AlertesController.php?action=index">Voir le centre d'alertes</a>
        </div>
    <?php endif; ?>
    <div class="dashboard-grid">
        <div class="stat-card"><h3>Équipements</h3><div class="number"><?= $stats['total_equipements'] ?></div></div>
        <div class="stat-card"><h3>Disponibles</h3><div class="number"><?= $stats['equipements_disponibles'] ?></div></div>
        <div class="stat-card"><h3>Affectés</h3><div class="number"><?= $stats['equipements_affectes'] ?></div></div>
        <div class="stat-card"><h3>En panne</h3><div class="number"><?= $stats['equipements_en_panne'] ?></div></div>
        <div class="stat-card"><h3>Tickets ouverts</h3><div class="number"><?= $stats['tickets_ouverts'] ?></div></div>
        <div class="stat-card"><h3>Tickets fermés</h3><div class="number"><?= $stats['tickets_fermes'] ?></div></div>
        <div class="stat-card"><h3>Maintenances</h3><div class="number"><?= $stats['maintenances'] ?></div></div>
        <div class="stat-card"><h3>Garanties expirées</h3><div class="number"><?= $stats['garanties_expirees'] ?></div></div>
        <div class="stat-card"><h3>Fournisseurs</h3><div class="number"><?= $stats['fournisseurs'] ?></div></div>
        <div class="stat-card"><h3>Utilisateurs</h3><div class="number"><?= $stats['utilisateurs'] ?></div></div>
        <div class="stat-card"><h3>Utilisateurs en ligne</h3><div class="number"><?= $stats['en_ligne'] ?></div></div>
    </div>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>