<?php require "view_begin.php";?>

<h1>Nos produits</h1>

<!--
  http://localhost/~12102253/index.php?controller=list&action=produits
  http://localhost/~12102253/index.php?controller=list&action=produits
-->

<?php foreach ($produits as $ligne): ?>
  <ul>
    <li>Image_ici</li>
    <!--<li> < ? = e($ligne["img_produit"])?> </li> -->
    <li> <?=e($ligne["nom"])?> </li>
    <li> <?=e($ligne["prix"])?> </li>
  </ul>
<?php endforeach ?>

<?php require "view_end.php";?>
