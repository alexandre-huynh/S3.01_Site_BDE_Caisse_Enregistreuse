<?php require "view_begin.php";?>

<h1>Nos boissons</h1>

<!--
  <a href="?controller=list&amp;action=confiseries"> Last Nobel Prizes</a>
  http://localhost/~12102253/index.php?controller=list&action=boissons
  http://localhost/~12102253/index.php?controller=list&action=boissons&type=soda
  http://localhost/~12102253/index.php?controller=list&action=boissons&type=soda&filter=decroissant
-->

<?php foreach ($produits as $ligne): ?>
  <ul>
    <li>Image_ici</li>
    <!--<li> < ? = e($ligne["img_produit"])?> </li> -->
    <li> <?=e($ligne["Nom"])?> </li>
    <li> <?=e($ligne["Prix"])?> </li>
  </ul>
<?php endforeach ?>

<?php require "view_end.php";?>
