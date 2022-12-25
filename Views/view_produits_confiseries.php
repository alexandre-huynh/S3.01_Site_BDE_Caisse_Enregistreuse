<?php require "view_begin.php";?>

<h1>Nos confiseries</h1>

<!--
  <a href="?controller=list&amp;action=confiseries"> Last Nobel Prizes</a>
  http://localhost/~12102253/index.php?controller=list&action=confiseries
  http://localhost/~12102253/index.php?controller=list&action=confiseries&filter=croissant
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
