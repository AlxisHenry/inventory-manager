<?php

function connectPdo(): PDO
{
    $host = "localhost";
    if ($_SERVER['SERVER_PORT'] == 81) {
        $dbname = "inventory_manager";
    } else {
        $dbname = "inventory_manager";
    }
    $dblogin = "username";
    $dbpassword = "password";
    try {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $dblogin, $dbpassword, array(
            PDO::ATTR_PERSISTENT => true
        ));
        // set the PDO error mode to exception
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // on affiche le message d'erreur si la connection plante
        die('Impossible de se connecter à la bd ' . $dbname . '.<br/>Erreur -> ' . $e->getMessage());
    }
    return $bdd;
}
