<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/espace_client.css">

<div class="content-main">

<h1>Bonjour <?=e($nomprenom)?> !</h1>
<hr>

<h5>Vous avez <?=e($ptsfidelite)?> points de fidélité.</h5>
<hr>
<!--peut être inclure une liste des articles dont il est éligible avec autant de points-->

<h2 class="historique_achat">Historique de vos achats</h2>

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

</div>
</main>

<?php require "view_end.php";?>