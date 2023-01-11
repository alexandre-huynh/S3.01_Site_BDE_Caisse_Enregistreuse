<!--< ?php require "view_begin.php"; ?>-->

<link rel="stylesheet" href="Content/css/home.css">

<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

        <section class="banniere_accueil">
            <div class="phrase_bienvenue">
                <h1>Bienvenue au stand de confiseries du BDE</h1>
            </div>
        </section>

        <!-- Produits populaires -->
        <!--
          TODO Pour l'instant en format table,
          adapter à un format "carte produit"
          genre un petit bloc carré jsp
        -->
        <section class="produits_du_moment">
            <h4>Nos produits du moment</h4>
            <div class="liste_produits_actuels">
            <?php foreach ($popular_prod as $ligne): ?>
              <ul>
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li><?=e($ligne["Prix"])?> €</li>
              </ul>
              </br> <!-- à enlever si nécessaire--> 
            <?php endforeach ?>
            </div>

        </section>

        <section class="produits_nouveautes">
            <h4>Nos nouveautés</h4>
            <div class="liste_produits_nouveautes">
            <?php foreach ($nouv_prod as $ligne): ?>
              <ul>
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li><?=e($ligne["Prix"])?> €</li>
              </ul>
              </br> <!-- à enlever si nécessaire--> 
            <?php endforeach ?>
            </div>

        </section>

        <section class="bde_presentation">
            <div>
                <h4>Le Wolf BDE</h4>
            </div>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eligendi nemo perspiciatis voluptatibus ex eos optio similique repellat eius quibusdam reiciendis, repellendus vel accusantium ipsa, libero assumenda et dignissimos fugiat deserunt.</p>
        </section>

<?php require "view_end.php";?>