<?php include '../index.php'; ?>

<section class="section form-section article-section">
    <div class="form-section-card">
        <div class="card-action">
            <div class="new">
                Nouvel article
            </div>
            <div class="exist">
                Article existant
            </div>
        </div>
        <i class="exit-article-focus fa-solid fa-xmark invisible"></i>
        <div class="card-form-article">
            <div class="form-primary-article">
                <label class="form-label"> Nom de l'article
                    <input name="name" type="text" class="form-input article-new-name" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getNom() . '"' ?> required>
                    <select name="name" class="form-select article-name-select hidden" <?= initializeStockEntry() === '' ? '' : ' data-art="' . initializeStockEntry()->getId() . '"' ?>>
                        <?= GetArticlesList(); ?>
                    </select>
                </label>
                <label class="form-label"> Famille de l'article
                    <select name="family" class="form-select article-family-select" <?= initializeStockEntry() === '' ? '' : ' data-family="' . initializeStockEntry()->getFamille() . '"' ?>>
                        <?= GetFamilyList(); ?>
                    </select>
                </label>
                <label class="form-label""> Quantité assignée

                        <input name=" quantity" type="number" class="form-input article-quantity" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getQuantityStock() . '" disabled' ?>>

                </label>
                <label class="form-label"> Quantité minimale
                    <input name="quantity" type="number" class="form-input article-quantity-minimal" <?= initializeStockEntry() === '' ? '' : ' value="' . (initializeStockEntry()->getQuantityMin() <= 0 ? null : initializeStockEntry()->getQuantityMin()) . '"' . (initializeStockEntry()->getQuantityMin() === -1 ? " disabled" : ' ') ?>>
                </label>
            </div>
            <div class="form-about-article">
                <label class="form-label"> Localisation dans le stock
                    <input name="localisation" type="text" class="form-input article-localisation" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getLocalisation() . '"' ?>>
                </label>
                <label class="form-label"> Commentaire
                    <input name="commentary" type="text" class="form-input article-commentary" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getCommentaire() . '"' ?>>
                </label>
                <label class="form-label"> Code correspondant
                    <input name="code" type="text" class="form-input article-code" <?= initializeStockEntry() === '' ? '' : ' value="' . initializeStockEntry()->getCode() . '"' ?>>
                </label>
                <label class="form-label"> Désactiver les alertes
                    <input name="code" type="checkbox" class="form-input article-alert-state" <?= initializeStockEntry() === '' ? '' : (intval(initializeStockEntry()->getQuantityMin()) === -1 ? 'checked' :  '') ?>>
                </label>
            </div>
        </div>
        <div class="submit-actions">
            <input type="submit" data-target="" value="Enregistrer" class="form-submit card-form-article-submit">
            <button class="exist-article-deleted delete-article hidden" data-target="delete">Supprimer</button>
        </div>
    </div>
</section>
<script type="module" src="<?= DOMAIN . "/js/pages/article.js" ?>"></script>
</body>

</html>