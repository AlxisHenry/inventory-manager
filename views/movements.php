<?php include '../index.php'; ?>

<section class="section visu-stock">
	<table class="table-visu-stock table-visu-mouvements">
		<thead class="table-header">
			<?php
			$columns = array('ID', 'Réalisé le', 'Type', 'Article', 'Quantité', 'Attribué à', 'Créé par', 'CC');
			$i = 0;
			echo '<tr class="row-0 row-values">';
			foreach ($columns as $column) {
				if ($column !== 'ID') {
					echo "<th class='column-$i column-title'>$column</th>\n";
				}
				$i++;
			}
			echo "</tr>";
			?>
		</thead>
		<tbody class="table-body">
			<?php
			echo "<tr class='row-1 row-values'>";
			$rows = connectPdo()->query("
                SELECT
                    mouvements.id AS id,
                    mouvements.commentaire AS commentaire,
                    mouvements.type AS type,
                    mouvements.quantite AS quantite,
                    mouvements.orderNumber AS orderNumber,
                    mouvements.dateMouvement AS dateMouvement,
                    mouvements.centreDeCout AS centreDeCout,
                    CONCAT(utilisateurs.nom, ' ', utilisateurs.prenom) AS identity, 
                    access.username AS creator,
                    articles.nom AS ArticleNom,
                    mouvements.dateCreation,
                    mouvements.dateModification
                FROM
                    `mouvements`
                LEFT OUTER JOIN `utilisateurs` ON mouvements.users = utilisateurs.id
                INNER JOIN `articles` ON mouvements.article = articles.id
                INNER JOIN `access` ON mouvements.creator = access.id
                ORDER BY mouvements.dateMouvement DESC;
                ");
			echo "</tr>";
			$i = 1;
			while ($row = $rows->fetch()) {
				$date = date('d/m/Y, H:i', strtotime($row['dateModification']));
				$type = $row['type'] === 's' ? 'Sortie' : 'Entrée';
				echo "
                    <tr class='row-$i row-values " . ($row['type'] === 's' ? 'red-row' : 'green-row') . "'>
                    <td class='column-0 column-values hidden'>" . $row['id'] . "</td>
                    <td class='column-1 column-values'>" . $date . "</td>
                    <td class='column-2 column-values'>" . $type . "</td>
                    <td class='column-3 column-values'>" . $row['ArticleNom'] . "</td>
                    <td class='column-4 column-values'>" . $row['quantite'] . "</td>
                    <td class='column-5 column-values'>" . $row['identity'] . "</td>
                    <td class='column-5 column-values'>" . $row['creator'] . "</td>
                    <td class='column-6 column-values'>" . $row['centreDeCout'] . "</td>
                    </tr>\n";
				$i = $i + 1;
			}
			?>
		</tbody>
	</table>
</section>
</body>

</html>