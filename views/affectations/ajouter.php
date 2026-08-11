<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Affecter un matériel</h1>
        <a href="<?= BASE_URL ?>/controllers/AffectationController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/AffectationController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_user">Utilisateur *</label>
                <select name="id_user" id="id_user" required>
                    <option value="">-- Choisir un utilisateur --</option>
                    <?php foreach ($utilisateurs as $u): ?>
                        <option value="<?= $u['ID_USER'] ?>"><?= h($u['PRENOM'] . ' ' . $u['NOM']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_materiel">Matériel *</label>
                <select name="id_materiel" id="id_materiel" required>
                    <option value="">-- Choisir un matériel disponible --</option>
                    <?php foreach ($materiels as $m): ?>
                        <option value="<?= $m['ID_MATERIEL'] ?>"><?= h($m['DESIGNATION']) ?> (<?= h($m['NUMERO_SERIE']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date_affectation">Date d'affectation *</label>
                <input type="date" name="date_affectation" id="date_affectation" value="<?= date('Y-m-d') ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Affecter</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>