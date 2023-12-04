<?php

include '../src/php/configuration/database-connexion.php';
include '../src/php/get_class_object.php';

/**
 * 
 * @return array
 */
function getMouvements(): array 
{
	$mouvements = connectPdo()->query('SELECT * FROM mouvements');
	return $mouvements->fetchAll();
}

foreach (getMouvements() as $mouvement) {

	if ($mouvement['centreDeCout'] == $mouvement['users']) {
		$request = connectPdo()->prepare("UPDATE `mouvements` SET `centreDeCout` = :cc WHERE `id` = :id");
		$request->execute([
			'cc' => Utilisateurs_OBJECT_($mouvement['centreDeCout'], 'id')->getCentreDeCout(),
			'id' => $mouvement['id']
		]);
		$request->closeCursor();
	}

}

die;