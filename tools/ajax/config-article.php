<?php

include '../../constants.php';
include ROOT . '/functions.php';

$_article = new Articles();

$family = intval($_POST['family']);
$name = $_POST['nom'];
$id = intval($_POST['id']);
$qteStock = intval($_POST['quantity']);
$qteMin = intval($_POST['quantityMin']);
$comment = $_POST['comment'];
$code = $_POST['code'];
$localisation = $_POST['localisation'];
$type = $_POST['type'];

if ($type === 'insert') {
    $_article->Insert($family, $name, $qteStock, $qteMin, $comment, $code, $localisation);
    echo json_encode(['insert', $name]);
} elseif ($type === 'update') {
    $_article->Update($family, $name, $comment, $qteMin, $code, $localisation, $id);
    echo json_encode(['update', $name]);
} elseif ($type === 'delete') {
    $_article->Delete($id);
}