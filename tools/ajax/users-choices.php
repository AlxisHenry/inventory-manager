<?php

include '../../constants.php';
include ROOT . '/functions.php';

$tempUsers = (connectPdo()->query("SELECT * FROM user_temp"))->fetchAll(PDO::FETCH_ASSOC);

if (count($tempUsers) < 1) {
	header("Location: /src/php/include/views/config-users.php?nav=c-users&p=1");
}

$action = true;
$params = ["method", "tmp"];

foreach ($params as $param) {
	if (!isset($_GET[$param])) {
		$action = false;
	}
}

if ($action) {
	$tmp = (connectPdo()->query("SELECT * FROM user_temp WHERE id = ". $_GET['tmp']))->fetch();
	switch ($_GET["method"]) {
		case "insert":
			$user = new Utilisateurs();
			$user->Insert($tmp["etablissement"], $tmp["matricule"], $tmp["nom"], $tmp["prenom"], $tmp["centreDeCout"], $tmp["centreAffection"]);						
			break;
		case "update":
			if (isset($_GET["user"])) {
				$i = Utilisateurs_OBJECT_($_GET["user"], "id");
				$i->setEtablissement($tmp["etablissement"]);
				$i->setMatricule($tmp["matricule"]);
				$i->setNom($tmp["nom"]);
				$i->setPrenom($tmp["prenom"]);
				$i->setCentreDeCout($tmp["centreDeCout"]);
				$i->setCentreAffection($tmp["centreAffection"]);
				$i->Update($i->getEtablissement(), $i->getMatricule(), $i->getNom(), $i->getPrenom(), $i->getCentreDeCout(), $i->getCentreAffection(), $i->getId());		
			}
			break;
	}
	(connectPdo()->query("DELETE FROM user_temp WHERE id = ". $tmp["id"]));	
	header("Location: /src/php/ajax/users-choices.php/");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta http-equiv='content-type' content='text/html' charset='utf-8' />
    <title>Gestion de stock en ligne</title>
</head>

<style>
table {
	border-collapse: collapse;
	width: 100%;
	max-width: 800px;
	margin: 0 auto;
	font-family: Arial, sans-serif;
}

thead {
	background-color: #F2F2F2;
	font-weight: bold;
}

th, td {
	padding: 10px;
	text-align: left;
}

th {
	border-bottom: 2px solid #ddd;
}

tr:nth-child(even) {
	background-color: #F2F2F2;
}

tr:hover {
	background-color: #ddd;
}

form {
	display: flex;
}

button {
	width: 100%;
}

.actions {
	width: 100%;
	display: flex;
	flex-direction: column;
	gap: 5px;
}

.actions a {
	display: inline-block;
	margin-right: 5px;
	padding: 5px 10px;
	border-radius: 3px;
	text-decoration: none;
	width: 100%;
	background-color: lightgray;
	color: black;
	text-align: center;
}

</style>

<body>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nom</th>
				<th>Prenom</th>
				<th>CC</th>
				<th>CA</th>
				<th>Matricule</th>
				<th>Etablissement</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach ($tempUsers as $user) { ?>
		<tr>
			<td><?= $user["id"] ?></td>
			<td><?= $user["nom"] ?></td>
			<td><?= $user["prenom"] ?></td>
			<td><?= $user["centreDeCout"] ?></td>
			<td><?= $user["centreAffection"] ?></td>
			<td><?= $user["matricule"] ?></td>
			<td><?= $user["etablissement"] ?></td>
			<td></td>
			<td class="actions">
				<form action="#">
					<input type="hidden" name="tmp" value="<?= $user["id"] ?>"/>
					<input type="hidden" name="method" value="update"/>
					<select name='user' id='user'>";
						<?= getSelectFromArray(getArrayFromTable("utilisateurs", "id", "nom,prenom", "","nom")); ?>
					</select>
					<button type="submit">Update</button>
				</form>
				<a href="?method=insert&tmp=<?= $user["id"] ?>">Insert</a>
			</td>
		</tr>
	<?php } ?>
		</tbody>
	
</body>
</html>