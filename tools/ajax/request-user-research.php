<?php

include '../../constants.php';
include ROOT . '/functions.php';

$value = $_POST['Value'];

$query = connectPdo()->query("SELECT * FROM `utilisateurs` WHERE id > 0 AND (`nom` LIKE '%$value%' OR `prenom` LIKE '%$value%' OR `centreDeCout` LIKE '%$value%' OR `centreAffection` LIKE '%$value%') ORDER BY nom, prenom LIMIT 50;");

$i = 1;
while ($data = $query->fetch()) {
    echo '<div class="main-user-row user-row' . $i . ' user' . $data[0] . '">
        <div class="matricule">
            <span> ' . $data[2] . ' </span>
        </div>
        <div class="identity">
            <span>  ' . $data[3] . ', ' . $data[4][0] . strtolower(substr($data[4], 1, strlen($data[4]))) . '</span>
        </div>
        <div class="c_cout">
            <span>  ' . $data[5] . ' </span>
        </div>
        <div class="c_affection">
            <span>  ' . $data[6] . ' </span>
        </div>
    </div>';
    $i++;
}

$query->closeCursor();
