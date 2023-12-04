<?php include '../index.php'; ?>

<div class="search-articles">
    <input class="searchbar" placeholder=" Rechercher un article..." type="text">
</div>

<section class="section visu-stock">
    <table class="table-visu-stock table-visu-stock-main">
        <thead class="table-header">
            <?php
            $columns = array('ID', 'Famille', 'Nom', 'Quantité', 'Commentaire', 'Code', 'Localisation', 'Dernière modification');
            $i = 0;
            echo '<tr class="row-0 row-values">';
            foreach ($columns as $column) {
                if ($column === 'ID' || $column === 'Code') {
                    echo "<th class='column-$i column-title hidden'>$column</th>\n";
                } else {
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
            $query = connectPdo()->query(" SELECT articles.id, familles.nom as Famille, articles.nom, articles.quantityStock ,articles.commentaire, code, localisation,articles.dateCreation, articles.dateModification FROM `articles` 
            INNER JOIN `familles` 
            ON articles.famille = familles.id
            ORDER BY familles.nom, articles.nom;");

            $i = 1;

            while ($data = $query->fetch()) {
                $date = date('d/m/Y, H:i', strtotime($data['dateModification']));
                echo "<tr class='row-$i row-values'>
                    <td class='column-0 column-values hidden'>{$data['id']}</td>
                    <td class='column-1 column-values'>{$data['Famille']}</td>
                    <td class='column-2 column-values'>{$data['nom']}</td>
                    <td class='column-3 column-values'>{$data['quantityStock']}</td>
                    <td class='column-4 column-values'>{$data['commentaire']}</td>
                    <td class='column-5 column-values hidden'>{$data['code']}</td>
                    <td class='column-6 column-values'>{$data['localisation']}</td>
                    <td class='column-7 column-values'>$date</td>
                    <td class='column-8 column-values action'><a class='redirect-entry' href='./stock_entry.php?nav=s-entry&id={$data['id']}'><i title='Entrée de stock pour {$data['nom']}' class='fa-solid fa-plus action entry'></i></a></td>
                    <td class='column-9 column-values action'><a class='redirect-out' href='./stock_out.php?nav=s-checkout&id={$data['id']}'><i title='Sortie de stocc pour {$data['nom']}' class='fa-solid fa-minus action checkout'></a></td>
                    <td class='column-10 column-values action'><a class='redirect-edit' href='./config-articles.php?nav=c-article&id={$data['id']}'><i title='Editer {$data['nom']}' class='fa-solid fa-pen-clip action edit'></i></a></td>
                </tr>\n";
                $i = $i + 1;
            }
            $query->closeCursor();
            ?>
        </tbody>
    </table>
</section>

<script type="module" src="<?= DOMAIN . "/js/pages/stock.js" ?>"></script>

</body>

</html>