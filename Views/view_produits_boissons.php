<?php require "view_begin.php";?>

<!--
  http://localhost/~12102253/index.php?controller=list&action=boissons
  http://localhost/~12102253/index.php?controller=list&action=boissons&type=soda
  http://localhost/~12102253/index.php?controller=list&action=boissons&type=soda&filter=decroissant
-->

<!-- TODO: avec les 3 boutons pour choisir soit soda, soit boissons etc, cacher le contenu avec JavaScript-->
<!-- Exemple: on clique sur soda, ça affichera les sodas et ça cachera le reste-->
<!-- A voir si c'est une bonne idée -->
        <section class="boissons">
            <h1>Nos boissons</h1>
            <hr>
            <div class="liste_boissons">
                <!-- Boissons générales -->
                <div class="type_boissons">
                    <h4>Boissons</h4>
                    <?php foreach ($boissons as $ligne): ?>
                      <ul class="produit">
                        <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                        <li> <?=e($ligne["Nom"])?> </li>
                        <li> <?=e($ligne["Prix"])?> €</li>
                      </ul>
                    <?php endforeach ?>
                </div>

                <!-- Sodas -->
                <div class="type_sodas">
                    <h4>Sodas</h4>
                    <?php foreach ($sodas as $ligne): ?>
                      <ul class="produit">
                        <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                        <li> <?=e($ligne["Nom"])?> </li>
                        <li> <?=e($ligne["Prix"])?> €</li>
                      </ul>
                    <?php endforeach ?>
                </div>

                <!-- Eau + sirop -->
                <div class="type_eau_sirop">
                    <h4>Eau + sirop</h4>
                    <?php foreach ($sirops as $ligne): ?>
                      <ul class="produit">
                        <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                        <li> <?=e($ligne["Nom"])?> </li>
                        <li> <?=e($ligne["Prix"])?> €</li>
                      </ul>
                    <?php endforeach ?>
                </div>

                </div>

            </div>
        </section>

<?php require "view_end.php";?>
