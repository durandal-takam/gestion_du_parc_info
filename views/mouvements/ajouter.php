<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Enregistrer un mouvement</h1>
        <a href="<?= BASE_URL ?>/controllers/MouvementController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/MouvementController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_materiel">Matériel *</label>
                <select name="id_materiel" id="id_materiel" required>
                    <option value="">-- Choisir un matériel --</option>
                    <?php foreach ($materiels as $m): ?>
                        <option value="<?= $m['ID_MATERIEL'] ?>"><?= h($m['DESIGNATION']) ?> (<?= h($m['NUMERO_SERIE']) ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_user">Utilisateur concerné</label>
                <select name="id_user" id="id_user">
                    <option value="">-- Choisir un utilisateur --</option>
                    <?php foreach ($utilisateurs as $u): ?>
                        <option value="<?= $u['ID_USER'] ?>"><?= h($u['PRENOM'] . ' ' . $u['NOM']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="type_mouvement">Type de mouvement *</label>
                <select name="type_mouvement" id="type_mouvement" required>
                    <option value="">-- Choisir un type --</option>
                    <?php foreach (['transfert', 'prêt', 'retour', 'changement bureau', 'changement service', 'réforme'] as $t): ?>
                        <option value="<?= $t ?>"><?= ucfirst($t) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="observation">Observation</label>
                <input type="text" name="observation" id="observation">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>