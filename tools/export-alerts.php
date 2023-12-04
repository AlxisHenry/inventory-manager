<?php

$filename = "alertes.csv";
$file = fopen('php://output', 'w');
# UTF-8 encoding
fputs($file, $bom = chr(0xEF) . chr(0xBB) . chr(0xBF));
$tablename = 'articles';
$delimiter = ';';

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename=' . $filename);

include '../constants.php';
include '../configuration/database-connexion.php';
include '../classes/get_class_object.php';

function getAlerts(): array
{
    $global_threshold = Alertes_OBJECT_(1, 'id')->getSeuil();
    $under_threshold = connectPdo()->query('SELECT familles.nom as famille, articles.nom as nom, quantityStock, quantityTotal, quantityGiven, quantityMin, articles.commentaire as commentaire, code, localisation, articles.dateCreation as dateCreation, articles.dateModification as dateModification FROM `articles` INNER JOIN familles ON articles.famille = familles.id WHERE (articles.quantityMin = 0 AND articles.quantityStock <'.$global_threshold.') OR (articles.quantityStock < articles.quantityMin) ORDER BY `articles`.nom;');
    return $under_threshold->fetchAll(PDO::FETCH_ASSOC);
}

function getColumnsNames(): array
{
	$fields = ['Famille', 'Nom de l\'article', 'Quantité en stock', 'Quantité totale', 'Quantité attribuée', 'Quantité minimale', 'Commentaire', 'Code', 'Localisation', 'Date de création', 'Dernière modification'];
	return $fields;
}

# Get fields and values
$fields = getColumnsNames();
$alerts = getAlerts();

# Put columns name
fputcsv($file, $fields, $delimiter);

# Put rows
foreach ($alerts as $alert) {
	fputcsv($file, $alert, $delimiter);
}

exit();