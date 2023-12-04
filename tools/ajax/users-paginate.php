<?php

include '../../constants.php';
include ROOT . '/functions.php';

$nb_pages = getPagesCount()[0];
$page = intval($_POST['page']);

$rows = getPagesCount()[1];
(int) $min = (($page - 1) * $rows);

$query = "SELECT * FROM `utilisateurs` WHERE id > 0 LIMIT $min, $rows ";
$query = connectPdo()->query($query);

$i = 1;
while ($data = $query->fetch()) {

    echo '<div class="main-user-row user-row' . $i . ' user' . $data[0] . '">
        <div class="matricule">
            <span> ' . $data[2] . ' </span>
        </div>
        <div class="identity">
            <span>  ' . $data[3] . ', ' . $data[4][0] . '' . strtolower(substr($data[4], 1, strlen($data[4]))) . '</span>
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
