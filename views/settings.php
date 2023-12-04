<?php include '../index.php'; ?>

<section class="section">
    <div class="contain-settings-sections">
        <div class="fl admin-section">
            <h1>Paramètres généraux</h1>
            <hr class="settings-hr">
            <div data-alert-id="1" data-tg="alerts" class="alerts-minimal contain-settings">
                <label>
                    Modifier le seuil avant alerte :
                    <?= "<input type='number' value='" . Alertes_OBJECT_(1, 'id')->getSeuil() . "' class='change-count-alert'>" ?>
                </label>
                <span></span>
                <span class="save-modification">Sauvegarder</span>
            </div>
        </div>
    </div>
</section>

<script type="module" src="<?= DOMAIN . "/js/pages/settings.js" ?>"></script>

</body>

</html>