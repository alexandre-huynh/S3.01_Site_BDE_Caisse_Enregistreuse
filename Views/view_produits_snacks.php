<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/snack.css">
      <section class="snacks">
          <h1>Nos snacks</h1>
          <hr>
          <div class="liste_snacks">
              <?php foreach ($snacks as $ligne): ?>
                <?php if ($ligne["Visible"]==1) : ?>
                <ul class="produit">
                  <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                  <li><?=e($ligne["Nom"])?></li>
                  <li class="prix"><?=e($ligne["Prix"])?> €</li>
                </ul>
                <?php endif ?>
              <?php endforeach ?>
          </div>
      </section>
</main>


<?php require "view_end.php";?>
