<?php

$parcBaseUrl = "http://localhost:5050";

if ($_SERVER['SERVER_PORT'] == 81) {
    $parcBaseUrl .= ":81";
}
?>

<div class="logo">
    <a href="<?= DOMAIN . "?nav=mvmt"; ?>"> <img src="<?= DOMAIN . "/assets/images/logo.png"; ?>" title="Retourner à l'accueil " alt="Logo"> </a>
</div>

<div class="contain-features">
    <div class="features mvmt last-mouvements"><a class="nav-redirection" href="<?= DOMAIN . "views/movements.php?nav=mvmt"; ?>" title="Visualiser les mouvements"><i class="nav-fa-icons fa-solid fa-arrow-trend-up"></i><span class="nav-span">Derniers mouvements</span></a></div>
    <div class="features s-entry stock-entry"><a class="nav-redirection" href="<?= DOMAIN . "views/stock_entry.php?nav=s-entry"; ?>" title="Réaliser uen entrée de stock"><i class="nav-fa-icons fa-solid fa-boxes-stacked"></i><span class="nav-span">Entrée de stock</span></a></div>
    <div class="features s-checkout stock-checkout"><a class="nav-redirection" href="<?= DOMAIN . "views/stock_out.php?nav=s-checkout"; ?>" title="Sortir un/des articles"><i class="nav-fa-icons fa-solid fa-dolly"></i><span class="nav-span">Sortie de stock</span></a></div>
    <div class="features visu visualisation"><a class="nav-redirection" href="<?= DOMAIN . "views/stock.php?nav=visu"; ?>" title="Visualiser le stock"><i class="nav-fa-icons fa-solid fa-box-open"></i><span class="nav-span">Voir le stock</span></a></div>
    <div class="features c-users config-users configuration"><a class="nav-redirection" href="./config-users.php?nav=c-users&p=1" title="Configurer les utilisateurs"><i class="nav-fa-icons fa-solid fa-user-gear"></i><span class="nav-span">Configurer Utilisateurs</span></a></div>
<div class="features c-article config-article configuration"><a class="nav-redirection" href="./config-articles.php?nav=c-article" title="Configurer les articles"><i class="nav-fa-icons fa-solid fa-user-gear"></i><span class="nav-span">Configurer Articles</span></a></div>
<div class="features c-famille config-famille configuration"><a class="nav-redirection" href="./config-familles.php?nav=c-famille" title="Configurer les familles"><i class="nav-fa-icons fa-solid fa-user-gear"></i><span class="nav-span">Configurer Familles</span></a></div>

<hr class="nav-separator">

<div class="contain-actions">
    <div class="features alerts"><a class="nav-redirection" href="<?= DOMAIN . "views/alerts.php?nav=alerts"; ?>" title="Voir les alertes"><i class="nav-fa-icons fa-solid fa-bell"></i><span class="nav-span">Notifications</span></a>
        <?php include COMPONENTS . '/alerts-indicator.php'; ?>
    </div>
    <div class="features settings"><a class="nav-redirection" href="<?= DOMAIN . "views/settings.php?nav=settings"; ?>" title="Voir les paramètres"><i class="nav-fa-icons fa-solid fa-gear"></i><span class="nav-span">Paramètres</span></a></div>
</div>
