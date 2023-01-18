<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<h1>Programme fidélité</h1>

<p>Les produits suivants ont été vendus pour le client <?=e($nom_client)?> : </p>

<?php if (isset($produits_traite)) : ?>
  <ul>
    <?php foreach ($produits_traite as $c => $v): ?>
      <li><?=e($c)?> - <?=e($v)?> €</li>
    <?php endforeach ?>
  </ul>
<?php endif ?>

<p><?=e($nom_client)?> possède <?=e($solde_points)?> et peut bénéficier d'<b>un produit gratuit</b> grâce au programme fidélité :</p>

<p>Sélectionnez 1 produit de la liste, ou <a href="?controller=list&action=caisse">retournez à la page Caisse enregistreuse</a></p>

<form action="?controller=set&action=traitement_fidelite" method="post">
  <input type="hidden" name="id_client" value="<?=e($id_client)?>">
  <table>
    <tr>
      <th>Sélection</th>
      <th>Image</th>
      <th>Nom</th>
      <th>Categorie</th>
      <th>Prix</th>
      <th>Stock</th>
      <th>Nb de points requis</th>
    </tr>
  <?php foreach ($produits_eligible as $ligne): ?>
    <tr>
      <td><input type="radio" name="produit_fidelite" value="<?=e($ligne["id_produit"])?>"></td>
      <td><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height=60 /></td>
      <td><?=e($ligne["Nom"])?></td>
      <td><?=e($ligne["Categorie"])?></td>
      <td><?=e($ligne["Prix"])?> €</td>
      <td><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Logo Illustration Stock" height=20 /></td>
      <td><?=e($ligne["Pts_fidelite_requis"])?> pts</td>
    </tr>
    <?php endforeach ?>
  </table>
</form>




<?php require "view_end.php";?>