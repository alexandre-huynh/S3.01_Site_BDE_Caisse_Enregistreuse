<?php require "view_begin.php"; ?>

<h1>Bonjour, espace client de <?=e($nomprenom)?></h1>

<h2>Historique des achats</h2>

<?php foreach ($historique as $date=>$ligne): ?>
    <h3><?=date("d/m/Y",strtotime(e($date)))?></h3>
    <table>
        <tr>
            <?php foreach ($ligne[0] as $c=>$v): ?>
                <th><?=e($c)?></th>
            <?php endforeach ?>
        </tr>
        <?php foreach ($ligne as $sous_ligne): ?>
        <tr>
            <?php foreach ($sous_ligne as $v): ?>
                <td><?=e($v)?></td>
            <?php endforeach ?>
        </tr>
        <?php endforeach ?>
    </table>
<?php endforeach ?>

<?php require "view_end.php";?>