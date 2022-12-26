<?php require "view_begin.php";?>

<h1>Nos produits</h1>

<!--
  http://localhost/~12102253/index.php?controller=list&action=produits
  http://localhost/~12102253/index.php?controller=list&action=produits
-->

<?php foreach ($produits as $ligne): ?>
  <ul>
    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
    <li> <?=e($ligne["Nom"])?> </li>
    <li> <?=e($ligne["Prix"])?> </li>
  </ul>
<?php endforeach ?>

<?php require "view_end.php";?>
