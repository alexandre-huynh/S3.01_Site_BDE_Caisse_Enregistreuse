<?php require "view_begin.php"; ?>

<!-- Implémenter un truc de vérification session aussi, si c'est bien un admin-->
<h1>Caisse enregistreuse</h1>

<div>
    <p> Panier du client </p>
    <ul>
        <!-- 
            Affichage des produits ici, genre 2x Kinder bueno etc
        -->
    </ul>
    <p>TOTAL : <span id="totalprix"></span></p>
</div>

<!-- boutons produits-->
<table>
    <tr id="snacks">
        <th>Snacks</th>
        <td>
            <?php foreach ($snacks as $ligne): ?>
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                </ul>
            <?php endforeach ?>
        </td>
    </tr>
    <tr id="boissons">
        <th>Boissons</th>
        <td>
            <?php foreach ($boissons as $ligne): ?>
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                </ul>
            <?php endforeach ?>
        </td>
    </tr>
    <tr id="boissons">
        <th>Sodas</th>
        <td>
            <?php foreach ($sodas as $ligne): ?>
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                </ul>
            <?php endforeach ?>
        </td>
    </tr>
    <tr id="sirops">
        <th>Sirops</th>
        <td>
            <?php foreach ($sirops as $ligne): ?>
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                </ul>
            <?php endforeach ?>
        </td>
    </tr>
</table>

<?php require "view_end.php";?>