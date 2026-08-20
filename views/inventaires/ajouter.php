<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Nouvel inventaire</h1>
        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=list" class="btn">← Retour</a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= h($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/controllers/InventaireController.php?action=store">
        <div class="form-group">
            <label>Observation</label>
            <textarea name="observation" rows="3" class="form-control"></textarea>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Matériel</th>
                    <th>N° série</th>
                    <th>État constaté</th>
                    <th>Remarque</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($materiels as $m): ?>
                    <tr>
                        <td><?= h($m['DESIGNATION']) ?></td>
                        <td><?= h($m['NUMERO_SERIE'] ?: '-') ?></td>
                        <td>
                            <select name="etat[<?= $m['ID_MATERIEL'] ?>]" class="form-control">
                                <option value="disponible" <?= $m['ETAT'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                                <option value="affecté" <?= $m['ETAT'] == 'affecté' ? 'selected' : '' ?>>Affecté</option>
                                <option value="en maintenance" <?= $m['ETAT'] == 'en maintenance' ? 'selected' : '' ?>>En maintenance</option>
                                <option value="hors service" <?= $m['ETAT'] == 'hors service' ? 'selected' : '' ?>>Hors service</option>
                            </select>
                        </td>
                        <td><input type="text" name="remarque[<?= $m['ID_MATERIEL'] ?>]" class="form-control"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enregistrer l'inventaire</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>