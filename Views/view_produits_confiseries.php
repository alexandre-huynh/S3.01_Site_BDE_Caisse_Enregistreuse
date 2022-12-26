<?php require "view_begin.php";?>

<!--
  http://localhost/~12102253/index.php?controller=list&action=confiseries
  http://localhost/~12102253/index.php?controller=list&action=confiseries&filter=croissant
-->

      <section class="confiseries">
          <h1>Nos confiseries</h1>
          <hr>
          <div class="liste_confiseries">
              <?php foreach ($produits as $ligne): ?>
                <ul class="produit">
                  <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                  <li><?=e($ligne["Nom"])?></li>
                  <li><?=e($ligne["Prix"])?> €</li>
                </ul>
              <?php endforeach ?>
          </div>
      </section>



<?php require "view_end.php";?>
