<?php

include 'constants.php';
include ROOT . '/functions.php';

// if (!Auth::attempt()) die();

$dev = false;
if ($_SERVER['SERVER_PORT'] == 81) $dev = true;

$title = "Gestion de stock en ligne";
if ($dev) $title = "(DEVELOPMENT) " . $title;

if (strpos($_SERVER['REQUEST_URI'], "php") === false) {
    header("Location: " . DOMAIN . "views/movements.php?nav=mvmt");
}

?>
<!DOCTYPE html>
<html lang="FR">

<head>
    <?php include COMPONENTS . '/header.php'; ?>
</head>

<body>

    <main class="features-navigation">
        <?php include COMPONENTS . '/navbar.php'; ?>
    </main>

    <div class="contain-send-message"></div>

    <?php include COMPONENTS . '/informations.php'; ?>
