<?php

include ROOT . '/configuration/database-connexion.php';
include ROOT . '/classes/get_class_object.php';

/* Globals functions */

function datetime(): DateTime
{
    $datetime = new DateTime();
    $timezone = new DateTimeZone('Europe/Amsterdam');
    $datetime->setTimezone($timezone);
    return $datetime;
}

function getAssetName(): string
{
    return strtoupper(explode('.', gethostbyaddr($_SERVER['REMOTE_ADDR']))[0]);
}

function getFormatDate(): string
{
    return date('d/m/Y h:i');
}

function setCurrentTitle(): string
{
    $base = "";
    if ($_SERVER['SERVER_PORT'] == 81) {
        $base = "(DEVELOPMENT) ";
    }
    return $base . match ($_GET['nav'] ?? "") {
        'c-users' => 'Configuration Utilisateurs',
        'c-article' => 'Configuration Articles',
        'c-ccout' => 'Configuration Centre de Coûts',
        'c-famille' => 'Configuration Familles',
        's-entry' => 'Entrée de stock',
        's-checkout' => 'Sortie de stock',
        'visu' => 'Visualiser le stock',
        'alerts' => 'Alertes de stock',
        'settings' => 'Paramètres',
        'mvmt' => 'Derniers mouvements',
        default => 'Gestion de stock',
    };
}

/* Globals functions -- END */

function getCountOfAlerts()
{
    /*
     * Cette fonction va retourner le nombre d'articles étant sous le seuil minimal
     */
    $counts = [
        'undefined' => returnCountOfArticles('undefined', '=', 0) ?? '',
        'active' => returnCountOfArticles('active', '>', 0) ?? ''
    ];

    return intval($counts['undefined']) + intval($counts['active']);
}

function returnCountOfArticles(string $status, string $op, int $number)
{

    $request = '';
    $global_threshold = Alertes_OBJECT_(1, 'id')->getSeuil();

    switch ($status) {
        case 'undefined':
            $request = connectPdo()->query('SELECT COUNT(*) as Alertes FROM `articles` WHERE articles.quantityMin = 0 AND articles.quantityStock < ' . $global_threshold . ';');
            break;
        case 'active':
            $request = connectPdo()->query('SELECT COUNT(*) as Alertes FROM `articles` WHERE  articles.quantityStock < articles.quantityMin;');
            break;
        default:
            break;
    }

    return $request->fetch()[0];
}

function getAllMinArticles(): array
{
    $global_threshold = Alertes_OBJECT_(1, 'id')->getSeuil();
    $under_threshold = connectPdo()->query('SELECT * FROM `articles` WHERE (articles.quantityMin = 0 AND articles.quantityStock <' . $global_threshold . ') OR (articles.quantityStock < articles.quantityMin) ORDER BY  `articles`.nom;');
    return $under_threshold->fetchAll();
}

function getStockInUrl(string $url): Articles|bool
{
    $TEST_URL = (bool)strpos($url, '&id=');

    if (!$TEST_URL) return false;

    $EntryUrl = $url;
    $id = explode('&', $EntryUrl);
    $id_value = intval((explode('=', $id[1]))[1]);

    if (!$id_value) return false;
    if ($id_value < 0) return false;

    $ARTICLE = Articles_OBJECT_($id_value, 'id');

    if (!$ARTICLE) return false;

    return $ARTICLE;
}

function initializeStockEntry(): Articles|string
{

    $CHECK_ARTICLE = getStockInUrl($_SERVER['REQUEST_URI']);
    return !$CHECK_ARTICLE ? '' : $CHECK_ARTICLE;
}

function getFamilyList(): string
{
    $QUERY = connectPdo()->query('SELECT * FROM `familles` ORDER BY nom;');
    $LIST = ["<option value='null' selected>Choisissez une famille</option>"];
    $id = 1;
    while ($STOCK = $QUERY->fetch()) {
        $LIST[] = "<option data-name='" . $STOCK['nom'] . "' class='opt-family-" . $STOCK['id'] . "' value='" . $STOCK["id"] . "' data-id='" . $STOCK["id"] . "'>" . $STOCK['nom'] . "</option>\n";
        $id++;
    }
    $QUERY->closeCursor();
    return implode(" ", $LIST);
}

function getArticlesList(): string
{
    $QUERY = connectPdo()->query('SELECT * FROM `articles` ORDER BY nom;');
    $LIST = ['<option selected>Sélectionner un article</option>'];
    $id = 1;
    while ($STOCK = $QUERY->fetch()) {
        $LIST[] = "<option data-name='" . $STOCK['nom'] . "' class='opt-name-" . $STOCK['id'] . "' value='" . $STOCK["id"] . "' data-id='" . $STOCK["id"] . "'>" . $STOCK['nom'] . "</option>\n";
        $id++;
    }
    $QUERY->closeCursor();
    return implode(" ", $LIST);
}

function getUsersList(): string
{
    $QUERY = connectPdo()->query('SELECT * FROM `utilisateurs` ORDER BY nom,prenom;');
    $LIST = ['<option disabled selected value>Sélectionner un utilisateur</option>'];
    $id = 1;
    while ($STOCK = $QUERY->fetch()) {
        $LIST[] = "<option data-name='" . $STOCK['nom'] . "' class='opt-name-" . $STOCK['id'] . "' value='" . $STOCK["id"] . "' data-id='" . $STOCK["id"] . "'>" . $STOCK['nom'] . ' ' . $STOCK['prenom'] . "</option>\n";
        $id++;
    }
    $QUERY->closeCursor();
    return implode(" ", $LIST);
}

function getCcoutList(): string
{
    $QUERY = connectPdo()->query('SELECT DISTINCT centreDeCout, centreAffection FROM utilisateurs ORDER BY centreAffection;');
    $LIST = ['<option disabled selected value>Sélectionner un centre de coût</option>'];
    $id = 1;
    while ($STOCK = $QUERY->fetch()) {
        $LIST[] = "<option>" . $STOCK['centreDeCout'] . "   -   " . $STOCK['centreAffection'] . "</option>\n";
        $id++;
    }
    $QUERY->closeCursor();
    return implode(" ", $LIST);
}

function getMaxCount(string $from): int
{
    $QUERY = connectPdo()->query("SELECT MAX(id) FROM $from");
    return intval($QUERY->fetch()[0]);
}

function getPagesCount(): array
{
    $COUNT_ROWS = connectPdo()->query("SELECT COUNT(*) AS Lignes FROM `utilisateurs`");
    $perPage = 50;
    return [ceil(($COUNT_ROWS->fetch()[0]) / $perPage), $perPage];
}

function getFamily(string $url): Familles|bool
{
    $FAMILY_URL = (bool)strpos($url, '&id=');

    if (!$FAMILY_URL) return false;

    $EntryUrl = $url;
    $id = explode('&', $EntryUrl);
    $id_value = intval((explode('=', $id[1]))[1]);

    if (!$id_value) return false;
    if ($id_value < 0) return false;

    $FAMILY = Familles_OBJECT_($id_value, 'id');

    if (!$FAMILY) return false;

    return $FAMILY;
}

function initializeFamily(): Familles|string
{

    $CHECK_FAMILY = GetFamily($_SERVER['REQUEST_URI']);
    return !$CHECK_FAMILY ? '' : $CHECK_FAMILY;
}


/**
 * @param string $table nom de la table
 * @param string $champsValue val retourné par le select
 * @param string $champsTexte 1 ou plusieurs champs séparés par des virgules. Si plusieurs champs, Select avec CONCAT séparé par des espaces.
 * @param string $filtre filtre après le WHERE
 * @param string $order nom du ou des champs pour le tri (si plusieurs, séparer par des virgules)
 * @return array
 */
function getArrayFromTable(string $table, string $champsValue, string $champsTexte, string $filtre, string $order): array
{
    $tab_champs = explode(",", $champsTexte);
    if (count($tab_champs) > 1) {
        $newExpr = "";
        foreach ($tab_champs as $champs) {
            if ($newExpr) $newExpr .= ",' ',";
            $newExpr .= $champs;
        }
        $champsTexte = "CONCAT($newExpr)";
    }
    $requete = "SELECT $champsValue,$champsTexte FROM $table";
    if ($filtre) $requete .= " WHERE $filtre";
    if ($order) $requete .= " ORDER BY $order";
    $req = connectPdo()->prepare($requete);
    $req->execute();
    $result = $req->fetchAll();
    $req->closeCursor();
    return $result;
}

function getSelectFromArray(array $tab, ?int $valueSelected = null): string
{
    $result = "";
    foreach ($tab as $ligne) {
        $selected = ($ligne[0] == $valueSelected ? " selected" : "");
        $result .= "<option value='" . $ligne[0] . "'$selected>" . $ligne[1] . "</option>";
    }
    return $result;
}
