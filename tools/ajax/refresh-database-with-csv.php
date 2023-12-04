<?php
include '../../constants.php';
include ROOT . '/functions.php';

set_time_limit(120);
$users = new Utilisateurs();
$row = 1;

if (($handle = fopen("users.csv", "r")) !== FALSE) {
	
	connectPdo()->query("TRUNCATE user_temp;");

    while (($rowData = fgetcsv($handle, 1000, ",")) !== FALSE) {

		if($row === 1){ $row++; continue; }  
		
		$line = $rowData;

		$etablissement = $line[1];
		$matricule = $line[0];
		$nom = $line[2];
		$prenom = $line[3];
		$centreDeCout = $line[4];
		$centreAffection = $line[5];
		
		if ($etablissement === "COLMAR") {
			/**
			 * Dans le cas où l'utilisateur est bien de COLMAR, on réalise les tâches suivantes: 
			 * 	- Matricule existant ?
			 *  - Nom/Prénom existant ?
			 * Dans ces deux cas, si la réponse est oui on met les utilisateurs dans une table temporaire qu'il faudra valider plus tard.
			 * Dans le cas contraire, si un matricule est trouvé, on effectue juste une mise à jour de l'enregistrement dans la table.
			 */
			 
			 if(!Utilisateurs_OBJECT_($matricule, "matricule")) {
				$req = connectPdo()->prepare("SELECT * FROM utilisateurs WHERE nom = :n AND prenom = :p;");
				$req->execute([
					":n" => $nom,
					":p" => $prenom
				]);
				$res = $req->fetch();
				$req->closeCursor();
				if (!$res) {
					$users->Insert($etablissement, $matricule, $nom, $prenom, $centreDeCout, $centreAffection);		
				} else {
					$req = connectPdo()->prepare("INSERT INTO user_temp 
						(nom, prenom, centreDeCout, centreAffection, matricule, etablissement)
						VALUES (:nom, :prenom, :centreDeCout, :centreAffection, :matricule, :etablissement);");
					$req->execute([
						":nom" => $nom,
						":prenom" => $prenom,
						":centreDeCout" => $centreDeCout,
						":centreAffection" => $centreAffection,		
						":matricule" => $matricule,
						":etablissement" => $etablissement,
					]);
					$req->closeCursor();
				}
			 } else {
				$u = false;

				$i = Utilisateurs_OBJECT_($matricule, 'matricule');

				if ($i->getEtablissement() !== $etablissement) {
					$i->setEtablissement($etablissement);
					$u = true;
				}
				if ($i->getNom() !== $nom) {
					$i->setNom($nom);
					$u = true;
				}
				if ($i->getPrenom() !== $prenom) {
					$i ->setPrenom($prenom);
					$u = true;
				}
				if ($i->getCentreDeCout() !== $centreDeCout) {
					$i->setCentreDeCout($centreDeCout);
					$u = true;
				}
				if ($i->getCentreAffection() !== $centreAffection) {
					$i->setCentreAffection($centreAffection);
					$u = true;
				}

				if ($u) {
					$users->Update($i->getEtablissement(), 
								   $i->getMatricule(),
								   $i->getNom(),
								   $i->getPrenom(),
								   $i->getCentreDeCout(),
								   $i->getCentreAffection(),
								   $i->getId());
				}				
			 }
			
		}
		
		$row++;

	}
	
	$c = connectPdo()->query("SELECT COUNT(*) as nb_tmp FROM user_temp;");
	$res = $c->fetch();
	
	if ($res["nb_tmp"] > 0) {
		// Si un/plusieurs enregistrements ont été créés dans la table user_temp, alors l'utilisateur est redirigé vers une page,
		// sur laquelle il décidera de quoi faire de chaque enregistrement
		echo json_encode([true]);
	}
	
	$c->closeCursor();
	
	fclose($handle);
    die();

}