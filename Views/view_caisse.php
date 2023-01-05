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
        <?php foreach ($snacks as $ligne): ?>
        <td>
            <ul class="produit">
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li><?=e($ligne["Prix"])?> €</li>
            </ul>
        </td>
        <?php endforeach ?>
    </tr>
    <tr id="boissons">
        <th>Boissons</th>
        <?php foreach ($boissons as $ligne): ?>
        <td>
            <ul class="produit">
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li><?=e($ligne["Prix"])?> €</li>
            </ul>
        </td>
        <?php endforeach ?>
    </tr>
    <tr id="boissons">
        <th>Sodas</th>
        <?php foreach ($sodas as $ligne): ?>
        <td>
            <ul class="produit">
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li><?=e($ligne["Prix"])?> €</li>
            </ul>
        </td>
        <?php endforeach ?>
    </tr>
    <tr id="sirops">
        <th>Sirops</th>
        <?php foreach ($sirops as $ligne): ?>
        <td>
            <ul class="produit">
                <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                <li><?=e($ligne["Nom"])?></li>
                <li><?=e($ligne["Prix"])?> €</li>
            </ul>
        </td>
        <?php endforeach ?>
    </tr>
</table>

<script defer src="Utils/caisse_enregist.js"></script>

<?php require "view_end.php";?>