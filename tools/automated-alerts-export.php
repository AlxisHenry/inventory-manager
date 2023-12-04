<?php

# Executed with the following command in the task scheduler of windows
# C:\PHP8\php.exe C:\stock_it\web\$env\tools\automated-alerts-export.php

$env = "timken.prod";

include 'C:\stock_it\web\\'. $env .'\configuration\database-connexion.php';
include 'C:\stock_it\web\\'. $env .'\classes\get_class_object.php';

/*
 * Création d'un fichier excel nommé : notifications.csv au chemin suivant :
 */
$path = "C:\\stock_it\\web\\notifications\\";
$name = "notifications"; 
$extension = ".csv";
$delimiter = ';';
$file = $path . $name . $extension;
$csv = fopen($file, 'w');

// UTF-8 encoding
fputs($csv, $bom = chr(0xEF) . chr(0xBB) . chr(0xBF));

function getAlerts(): array
{
    $global_threshold = Alertes_OBJECT_(1, 'id')->getSeuil();
    $under_threshold = connectPdo()->query('SELECT familles.nom as famille, articles.nom as nom, quantityStock, quantityTotal, quantityGiven, quantityMin, articles.commentaire as commentaire, code, localisation, articles.dateCreation as dateCreation, articles.dateModification as dateModification FROM `articles` INNER JOIN familles ON articles.famille = familles.id WHERE (articles.quantityMin = 0 AND articles.quantityStock <'.$global_threshold.') OR (articles.quantityStock < articles.quantityMin) ORDER BY `articles`.nom;');
    return $under_threshold->fetchAll(PDO::FETCH_ASSOC);
}

function getColumnsNames(): array
{
	return ['Famille', 'Nom de l\'article', 'Quantité en stock', 'Quantité totale', 'Quantité attribuée', 'Quantité minimale', 'Commentaire', 'Code', 'Localisation', 'Date de création', 'Dernière modification'];
}

# Put columns name
fputcsv($csv, getColumnsNames(), $delimiter);

# Put rows
foreach (getAlerts() as $alert) {
	fputcsv($csv, $alert, $delimiter);
}

fclose($csv);

exit();