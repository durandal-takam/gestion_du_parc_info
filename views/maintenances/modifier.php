<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Modifier la maintenance</h1>
        <a href="<?= BASE_URL ?>/controllers/MaintenanceController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/MaintenanceController.php?action=update&id=<?= $maintenance['ID_MAINTENANCE'] ?>" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_type">Type de maintenance *</label>
                <select name="id_type" id="id_type" required>
                    <option value="">-- Choisir un type --</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['ID_TYPE'] ?>" <?= $maintenance['ID_TYPE'] == $t['ID_TYPE'] ? 'selected' : '' ?>>
                            <?= h($t['LIBELLE']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_user">Technicien *</label>
                <select name="id_user" id="id_user" required>
                    <option value="">-- Choisir un technicien --</option>
                    <?php foreach ($techniciens as $u): ?>
                        <option value="<?= $u['ID_USER'] ?>" <?= $maintenance['ID_USER'] == $u['ID_USER'] ? 'selected' : '' ?>>
                            <?= h($u['PRENOM'] . ' ' . $u['NOM']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_materiel">Matériel *</label>
                <select name="id_materiel" id="id_materiel" required>
                    <option value="">-- Choisir un matériel --</option>
                    <?php foreach ($materiels as $mat): ?>
                        <option value="<?= $mat['ID_MATERIEL'] ?>" <?= $maintenance['ID_MATERIEL'] == $mat['ID_MATERIEL'] ? 'selected' : '' ?>>
                            <?= h($mat['DESIGNATION']) ?> (<?= h($mat['NUMERO_SERIE']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_categorie_panne">Catégorie de panne</label>
                <select name="id_categorie_panne" id="id_categorie_panne">
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $c): ?>
                        <option value="<?= $c['ID_CATEGORIE_PANNE'] ?>" <?= $maintenance['ID_CATEGORIE_PANNE'] == $c['ID_CATEGORIE_PANNE'] ? 'selected' : '' ?>>
                            <?= h($c['LIBELLE']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="id_contrat">Contrat</label>
                <select name="id_contrat" id="id_contrat">
                    <option value="">-- Aucun contrat --</option>
                    <?php foreach ($contrats as $c): ?>
                        <option value="<?= $c['ID_CONTRAT'] ?>" <?= $maintenance['ID_CONTRAT'] == $c['ID_CONTRAT'] ? 'selected' : '' ?>>
                            <?= h($c['REFERENCE']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_demande">Ticket lié</label>
                <select name="id_demande" id="id_demande">
                    <option value="">-- Aucun ticket --</option>
                    <?php foreach ($demandes as $d): ?>
                        <option value="<?= $d['ID_DEMANDE'] ?>" <?= $maintenance['ID_DEMANDE'] == $d['ID_DEMANDE'] ? 'selected' : '' ?>>
                            Ticket #<?= h($d['ID_DEMANDE']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="date_panne">Date de la panne</label>
                <input type="datetime-local" name="date_panne" id="date_panne" value="<?= h(str_replace(' ', 'T', substr($maintenance['DATE_PANNE'] ?? '', 0, 16))) ?>">
            </div>
            <div class="form-group">
                <label for="date_intervention">Date d'intervention</label>
                <input type="datetime-local" name="date_intervention" id="date_intervention" value="<?= h(str_replace(' ', 'T', substr($maintenance['DATE_INTERVENTION'] ?? '', 0, 16))) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="description">Description *</label>
                <textarea name="description" id="description" rows="3" required><?= h($maintenance['DESCRIPTION']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="solution">Solution apportée</label>
                <textarea name="solution" id="solution" rows="3"><?= h($maintenance['SOLUTION']) ?></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="cout">Coût</label>
                <input type="number" step="0.01" name="cout" id="cout" value="<?= h($maintenance['COUT']) ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</main>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>