<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<!--<link rel="stylesheet" type="text/css" href="Content/css/boissons.css">-->

<!-- TODO: avec les 3 boutons pour choisir soit soda, soit boissons etc, cacher le contenu avec JavaScript-->
<!-- Exemple: on clique sur soda, ça affichera les sodas et ça cachera le reste-->
<!-- A voir si c'est une bonne idée -->
        <section class="boissons">
            <h1>Nos boissons</h1>
            <hr>
            <div class="liste_boissons">
                <!-- Boissons générales -->
                <h4>Boissons</h4>
                <div class="type_boissons">
                    <?php foreach ($boissons as $ligne): ?>
                      <?php if ($ligne["Visible"]==1) : ?>
                      <ul class="produit">
                        <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                        <li> <?=e($ligne["Nom"])?> </li>
                        <li> <?=e($ligne["Prix"])?> €</li>
                      </ul>
                      <?php endif ?>
                    <?php endforeach ?>
                </div>

                <!-- Sodas -->
                <h4>Sodas</h4>
                <div class="type_sodas">
                    <?php foreach ($sodas as $ligne): ?>
                      <?php if ($ligne["Visible"]==1) : ?>
                      <ul class="produit">
                        <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                        <li> <?=e($ligne["Nom"])?> </li>
                        <li> <?=e($ligne["Prix"])?> €</li>
                      </ul>
                      <?php endif ?>
                    <?php endforeach ?>
                </div>

                <!-- Eau + sirop -->
                <h4>Eau + sirop</h4>
                <div class="type_eau_sirop">
                    <?php foreach ($sirops as $ligne): ?>
                      <?php if ($ligne["Visible"]==1) : ?>
                      <ul class="produit">
                        <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                        <li> <?=e($ligne["Nom"])?> </li>
                        <li> <?=e($ligne["Prix"])?> €</li>
                      </ul>
                      <?php endif ?>
                    <?php endforeach ?>
                </div>

                </div>

            </div>
        </section>
</main>

<?php require "view_end.php";?>
