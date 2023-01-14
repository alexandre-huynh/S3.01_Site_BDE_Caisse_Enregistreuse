<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/caisse.css">

<!-- Implémenter un truc de vérification session aussi, si c'est bien un admin-->
<h1>Caisse enregistreuse</h1>

<div id="panier_et_produits">

    <div>
        <!-- 
        ======================================
                    Partie Graphique
        ======================================
        -->
        <p> Panier du client </p>
        <ul id="panier">
            <li>2 x Kinder Bueno (exemple)</li>
            <!-- 
                Affichage des produits ici, genre 2x Kinder bueno etc
            -->
        </ul>
        <p>TOTAL : <span id="totalprix">0</span></p>

        <p>Payé : <span id="reste">0</span></p>

        <p>Reste à payer: <span id="reste">0</span></p>

        <p>Paiement par : <b><span id="paiement">Espèce</span></b></p>
        

    </div>
    <!-- 
    ======================================
                Partie Formulaire
    ======================================
    -->
    <form>  
        <!--Client acheteur-->
        <p>
            <!-- SERA TRANSFORME EN ID dans le traitement en php-->
            <label>Numéro étudiant du client :
                <input type="number" name="num_etudiant_client" step="1" min="0" required />
            </label>
        </p>

        <!--Méthode de paiement-->
        <input type="hidden" name="Paiement" required />

        <!--Responsable de la vente-->
        <input type="hidden" name="id_admin" value="<?=e($admin)?>" required /> 

        <!--
        ======================================================    
        Les produits seront ajoutés ici, mais en type=hidden
        ======================================================
        -->
        
        <div id="panier_input_formulaire">
            <!--
            exemple:
            <input type="hidden" name="produit1" value="ID_PRODUIT_ICI" />
            <input type="hidden" name="produit2" value="ID_PRODUIT_ICI" />
            -->
        </div>

        <!-- boutons valider + abandon + méthode paiement-->

        <table>
            <tr>
                <td id="valider">
                    <!--Validation du panier-->
                    <input type="submit" value="Valider" />
                </td>
                <td id="abandon">
                    <p>Abandon</p>
                </td>
                <td id="espece">
                    <p><img src="Content/img/logo_espece.png" alt="Payer par Espece" height="60" /></p>
                </td>
                <td id="carte">
                    <p><img src="Content/img/logo_carte.png" alt="Payer par Carte" height="60" /></p>
                </td>
            </tr>
    </form>

    <hr>

    <!-- TEST 
    <p id="snack">
        < ?php foreach ($snacks as $ligne): ?>
        <div class="produit">
            <div><img src="Content/img/< ?=e($ligne["Img_produit"])?>" alt="Image" height="60" /></div>
            <div>< ?=e($ligne["Nom"])?></div>
            <div>< ?=e($ligne["Prix"])?> €</div>
        </div>
        < ?php endforeach ?>
    </p>
    -->
    <!-- boutons produits-->
    <table id="liste_produits">
        <tr>
            <th>Snacks</th>
            <?php foreach ($snacks as $ligne): ?>
            <td class="snacks">
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                    <li><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></li>
                </ul>
                <!--
                <div class="produit">
                    <div><img src="Content/img/< ?=e($ligne["Img_produit"])?>" alt="Image < ?=e($ligne["Nom"])?>" height="60" /></div>
                    <div>< ?=e($ligne["Nom"])?></div>
                    <div>< ?=e($ligne["Prix"])?> €</div>
                </div>
                -->
            </td>
            
            <?php endforeach ?>
        </tr>
        <tr id="boissons">
            <th>Boissons</th>
            <?php foreach ($boissons as $ligne): ?>
            <td class="boissons">
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                    <li><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></li>
                </ul>
            </td>
            <?php endforeach ?>
        </tr>
        <tr id="sodas">
            <th>Sodas</th>
            <?php foreach ($sodas as $ligne): ?>
            <td class="sodas">
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                    <li><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></li>
                </ul>
            </td>
            <?php endforeach ?>
        </tr>
        <tr id="sirops">
            <th>Sirops</th>
            <?php foreach ($sirops as $ligne): ?>
            <td class="sirops">
                <ul class="produit">
                    <li><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></li>
                    <li><?=e($ligne["Nom"])?></li>
                    <li><?=e($ligne["Prix"])?> €</li>
                    <li><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></li>
                </ul>
            </td>
            <?php endforeach ?>
        </tr>
    </table>

</div> <!--fin panier + produits-->  
</main>

<!-- CHARGEMENT JAVASCRIPT CAISSE -->
<script defer type="text/javascript" src="Utils/caisse_enregist.js"></script>
<!-- CHARGEMENT JAVASCRIPT CAISSE -->

<?php require "view_end.php";?>