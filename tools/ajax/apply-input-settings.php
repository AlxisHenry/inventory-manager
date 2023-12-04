<?php

include '../../constants.php';
include ROOT . '/functions.php';

$id = $_POST['id'];
$table = $_POST['table'];
$target = $_POST['target'];
$action = $_POST['action'];
$value = $_POST['value'];

$_alert = new Alertes();
$currentLevel = Alertes_OBJECT_($id , 'id')->getSeuil();

if (strlen($value) === 0) {
    echo json_encode([false, $action]);
    die();
}

// Test Alerts
if ((($value != $currentLevel) && $action === 'minimal')) {
    if ($value >= 0 && $value < 100) {
        $_alert->UpdateThreshold(
            $value,
            Access_OBJECT_($id, 'id')->getId()
        );
        echo json_encode([true, $action]);
        die();
    } else {
        echo json_encode(['none', $action]);
        die();
    }
}

echo json_encode(['admin', $action]);
