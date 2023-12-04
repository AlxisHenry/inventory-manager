<?php include '../index.php'; ?>

<section class="section visu-stock">
    <table class="table-visu-stock table-visu-alerts">
        <thead class="table-header">
            <?php
            $columns = array('ID', 'Famille', 'Nom', 'Quantité', 'Seuil', 'Commentaire', 'Code', 'Localisation', 'Dernière modification', '', '', '<a href="/tools/export-alerts.php" style="text-decoration: none; color: inherit;"><i class="fa-solid fa-file-export"></i></a>');
            $i = 0;
            echo '<tr class="row-0 row-values">';
            foreach ($columns as $column) {
                if ($column === 'ID' || $column === 'Famille') {
                    echo "<th class='column-$i column-title hidden'>$column</th>\n";
                } else {
                    echo "<th class='column-$i column-title'>$column</th>\n";
                }
                $i++;
            }
            ?>
            </tr>
        </thead>
        <tbody class="table-body">
            <?php echo "<tr class='row-1 row-values'>";
            $i = 2;
            foreach (getAllMinArticles() as $article) {
                $date = date('d/m/Y, H:i', strtotime($article['dateModification'] ?? ''));
                echo "<tr class='row-$i row-values'>
                    <td class='column-0 column-values hidden'>{$article['id']}</td>
                    <td class='column-1 column-values hidden'></td>
                    <td class='column-2 column-values'>{$article['nom']}</td>
                    <td class='column-3 column-values'>{$article['quantityStock']}</td>
                    <td class='column-3 column-values'>{$article['quantityMin']}</td>
                    <td class='column-4 column-values'>{$article['commentaire']}</td>
                    <td class='column-5 column-values'>{$article['code']}</td>
                    <td class='column-6 column-values'>{$article['localisation']}</td>
                    <td class='column-7 column-values'>$date</td>
                    <td class='column-8 column-values action'><a class='redirect-entry' href='./stock_entry.php?nav=s-entry&id={$article['id']}'><i title='Entrée de stock pour {$article['nom']}' class='fa-solid fa-plus action entry'></i></a></td>
                    <td class='column-9 column-values action'><a class='redirect-out' href='./stock_out.php?nav=s-checkout&id={$article['id']}'><i title='Sortie de stocc pour {$article['nom']}' class='fa-solid fa-minus action checkout'></a></td>
                    <td class='column-10 column-values action'><a class='redirect-edit' href='./config-articles.php?nav=c-article&id={$article['id']}'><i title='Editer {$article['nom']}' class='fa-solid fa-pen-clip action edit'></i></a></td>
                </tr>\n";
                $i++;
            }
            echo "</tr>";
            ?>
        </tbody>
    </table>
</section>
</body>

</html>