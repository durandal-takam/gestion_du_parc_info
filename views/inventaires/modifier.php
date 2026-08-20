<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier l'inventaire <?= h($inventaire['NUMERO_INVENTAIRE']) ?></h1>
        <a href="<?= BASE_URL ?>/controllers/InventaireController.php?action=list" class="btn">← Retour</a>
    </div>

    <form method="POST" action="<?= BASE_URL ?>/controllers/InventaireController.php?action=update&id=<?= h(urlencode($inventaire['NUMERO_INVENTAIRE'])) ?>">
        <div class="form-group">
            <label>Observation</label>
            <textarea name="observation" rows="3" class="form-control"><?= h($inventaire['OBSERVATION'] ?: '') ?></textarea>
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
                <?php foreach ($details as $d): ?>
                    <tr>
                        <td><?= h($d['MATERIEL_DESIGNATION']) ?></td>
                        <td><?= h($d['NUMERO_SERIE'] ?: '-') ?></td>
                        <td>
                            <select name="etat[<?= $d['ID_DETAIL'] ?>]" class="form-control">
                                <option value="disponible" <?= $d['ETAT_CONSTATE'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                                <option value="affecté" <?= $d['ETAT_CONSTATE'] == 'affecté' ? 'selected' : '' ?>>Affecté</option>
                                <option value="en maintenance" <?= $d['ETAT_CONSTATE'] == 'en maintenance' ? 'selected' : '' ?>>En maintenance</option>
                                <option value="hors service" <?= $d['ETAT_CONSTATE'] == 'hors service' ? 'selected' : '' ?>>Hors service</option>
                            </select>
                        </td>
                        <td><input type="text" name="remarque[<?= $d['ID_DETAIL'] ?>]" value="<?= h($d['REMARQUE'] ?: '') ?>" class="form-control"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>