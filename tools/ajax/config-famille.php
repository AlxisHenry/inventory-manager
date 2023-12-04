<?php

include '../../constants.php';
include ROOT . '/functions.php';

$_family = new Familles();

$id = intval($_POST['id']);
$name = $_POST['nom'];
$comment = $_POST['comment'];
$type = $_POST['type'];

if ($type === 'insert') {
    $_family->Insert($name, $comment);
    echo json_encode(['insert', $name]);
} elseif ($type === 'update') {
    $_family->Update($name, $comment, $id);
    echo json_encode(['update', $name]);
} elseif ($type === 'delete') {
    $_family->Delete($id);
}