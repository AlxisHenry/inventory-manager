<?php include '../index.php'; ?>

<section class="section form-section article-section">
    <div class="form-section-card">
        <div class="card-action">
            <div class="new">
                Tous les articles
            </div>
            <div class="exist config-active-action">
                Sortie de stock
            </div>
        </div>
        <i class="exit-article-focus fa-solid fa-xmark invisible"></i>
        <div class="card-form-article">
            <div class="form-primary-article">
                <label class="form-label"> Nom de l'article
                    <select name="article-list" class="form-select article-name-select" <?= initializeStockEntry() === '' ? '' : ' data-art="' . initializeStockEntry()->getId() . '"' ?>>
                        <?= getArticlesList(); ?>
                    </select>
                    <input name="article" type="text" class="form-input article-name hidden" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getNom() . '"' ?> disabled>
                </label>
                <label class="form-label""> Sélectionner un utilisateur
                    <select name=" checkout-user" class="form-select checkout-user">
                    <?= getUsersList(); ?>
                    </select>
                    <span style="font-size: 12px; margin-bottom: -20px; margin-top: 6px; text-align: right; cursor: pointer;" class="subinfo-toggle show-cc-input">Je ne connais pas l'utilisateur</span>
                </label>
                <label class="form-label hidden"> Entrer un centre de coût
                    <select name="checkout-user" class="form-select centre-cout">
                        <?= GetCcoutList(); ?>
                    </select>
                    <span style="font-size: 12px; margin-bottom: -20px; margin-top: 6px; text-align: right; cursor: pointer;" class="subinfo-toggle show-user-input">Je connais l'utilisateur</span>
                </label>
                <label class="form-label""> Quantité assignée
                    <input name=" quantity-to-checkout" type="text" class="form-input article-quantity-to-checkout">
                </label>
                <label class="form-label""> À propos de la sortie
                    <input name=" about-checkout" type="text" class="form-input about-checkout">
                </label>
                <label class="form-label"> Quantité restante
                    <input name="quantity-rest" type="text" class="form-input quantity-rest" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getQuantityStock() . '"' ?> disabled>
                </label>
            </div>
            <div class="form-about-article">
                <label class="form-label"> Famille de l'article
                    <input name="family" type="text" class="form-input article-family" <?= initializeStockEntry() === '' ? '' : ' value="' . Familles_OBJECT_(initializeStockEntry()->getFamille(), 'id')->getNom() . '"' ?> disabled>
                </label>
                <label class="form-label"> Localisation dans le stock
                    <input name="localisation" type="text" class="form-input article-localisation" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getLocalisation() . '"' ?> disabled>
                </label>
                <label class="form-label"> À propos de l'article
                    <input name="commentary" type="text" class="form-input article-commentary" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getCommentaire() . '"' ?> disabled>
                </label>
                <label class="form-label"> Code correspondant
                    <input name="code" type="text" class="form-input article-code" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getCode() . '"' ?> disabled>
                </label>
                <label class="form-label"> Quantité totale
                    <input name="localisation" type="text" class="form-input article-localisation" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getQuantityTotal() . '"' ?> disabled>
                </label>
            </div>
        </div>
        <div class="submit-actions">
            <input type="submit" data-target="" value="Validation" class="form-submit card-form-article-submit">
        </div>
    </div>

</section>

<script type="module" src="<?= DOMAIN . "/js/pages/stock_out.js" ?>"></script>

</body>

</html>