<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<?php require_once __DIR__ . '/../../includes/sidebar.php'; ?>

<main class="content">
    <div class="page-header">
        <h1>Ajouter un bureau</h1>
        <a href="<?= BASE_URL ?>/controllers/BureauController.php?action=list" class="btn">← Retour à la liste</a>
    </div>

    <form action="<?= BASE_URL ?>/controllers/BureauController.php?action=store" method="POST" class="form">
        <div class="form-row">
            <div class="form-group">
                <label for="id_direction">Direction *</label>
                <select name="id_direction" id="id_direction" required>
                    <option value="">-- Choisir une direction --</option>
                    <?php foreach ($directions as $d): ?>
                        <option value="<?= $d['ID_DIRECTION'] ?>"><?= h($d['NOM_DIRECTION']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nom_bureau">Nom du bureau *</label>
                <input type="text" name="nom_bureau" id="nom_bureau" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="localisation">Localisation</label>
                <input type="text" name="localisation" id="localisation">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>