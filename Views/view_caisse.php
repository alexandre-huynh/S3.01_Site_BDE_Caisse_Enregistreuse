<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/caisse.css">

<!-- Implémenter un truc de vérification session aussi, si c'est bien un admin-->
<h1>Caisse enregistreuse</h1>

<div id="panier_et_produits">

    <div class="aside_total">
        <!-- 
        ======================================
                    Partie Graphique
        ======================================
        -->
        <h4 class="panier_client"> Panier du client </h4>
        <ul id="panier">
            <!-- 
                Affichage des produits ici, genre 2x Kinder bueno etc
            -->
        </ul>
        <p class="total">TOTAL : <span id="totalprix">0</span><span class="devise"> €</span></p>
        <p class="dejapayer">Payé : <span id="dejapayer">0</span><span class="devise"> €</span></p>
        <p class="reste">Reste à payer : <span id="reste">0</span><span class="devise"> €</span></p>
        <p>Paiement par : <b><span id="paiement">Espèce</span></b></p>
    </div>
    <!-- 
    ======================================
                Partie Formulaire
    ======================================
    -->

    <div class="form_display">
        <form action="?controller=set&action=traitement_caisse" method="post" >  
            <!--Client acheteur-->
            <p>
                <!-- SERA TRANSFORME EN ID dans le traitement en php-->
                <label>Numéro étudiant du client :
                    <input type="number" name="num_etudiant_client" step="1" min="0" required />
                </label>
            </p>

            <!--Responsable de la vente-->
            <input type="hidden" name="id_admin" value="<?=e($admin)?>" /> 

            <!--Date de vente-->
            <!--<input type="hidden" name="Date_vente" value="" />-->

            <!--Méthode de paiement-->
            <input type="hidden" id="select_paiement" name="Paiement" value="Espece" />

            <!--Si a utilisé pts de fidélité, par défaut à False, si veut utiliser ça enverra sur vue différente-->
            <!-- <input type="hidden" name="Use_fidelite" />-->


            <!--
            ======================================================    
            Les produits seront ajoutés ici, mais en type=hidden
            ======================================================
            -->
            
            <div id="panier_input_formulaire">
                <!-- TEST-->

                <!--
                exemple:
                <input type="hidden" name="produit1" value="ID_PRODUIT_ICI" />
                <input type="hidden" name="produit2" value="ID_PRODUIT_ICI" />
                -->
            </div>

            <!-- boutons valider + abandon + méthode paiement-->

            <div class="bouton-decision">
                <div id="valider">
                    <!--Validation du panier-->
                    <input type="submit" value="Valider" />
                </div>

                <div id="abandon">
                    <!--Annulation du panier-->
                    <a href="">Abandon</a>
                </div>

                <div id="espece">
                    <img src="Content/img/logo_espece.png" alt="Payer par Espece" height="60" />
                </div>

                <div id="carte">
                    <img src="Content/img/logo_carte.png" alt="Payer par Carte" height="60" />
                </div>
            </div>
        </form>
        </br>
        <div class="monnaie">
            <div>
                <img src="Content/img/20euro.png" alt="20 euro" height="60" />
                <span class="hidden" id="20euro">20</span>
            </div>
            <div>
                <img src="Content/img/10euro.png" alt="10 euro" height="60" />
                <span class="hidden" id="10euro">10</span>
            </div>
            <div>
                <img src="Content/img/5euro.png" alt="5 euro" height="60" />
                <span class="hidden" id="5euro">5</span>
            </div>
            <div>
                <img src="Content/img/2euro.png" alt="2 euro" height="60" />
                <span class="hidden" id="2euro">2</span>
            </div>
            <div>
                <img src="Content/img/1euro.png" alt="1 euro" height="60" />
                <span class="hidden" id="1euro">1</span>
            </div>
            <div>
                <img src="Content/img/50cent.png" alt="50 cent" height="60" />
                <span class="hidden" id="50cent">0.5</span>
            </div>
            <div>
                <img src="Content/img/20cent.png" alt="20 cent" height="60" />
                <span class="hidden" id="20cent">0.2</span>
            </div>
            <div>
                <img src="Content/img/10cent.png" alt="10 cent" height="60" />
                <span class="hidden" id="10cent">0.1</span>
            </div>
            <div>
                <img src="Content/img/5cent.png" alt="5 cent" height="60" />
                <span class="hidden" id="5cent">0.05</span>
            </div>
            <div>
                <img src="Content/img/2cent.png" alt="2 cent" height="60" />
                <span class="hidden" id="2cent">0.02</span>
            </div>
            <div>
                <img src="Content/img/1cent.png" alt="1 cent" height="60" />
                <span class="hidden" id="1cent">0.01</span>
            </div>
        </div>
        <div class="produits-panier">
            <table id="liste_produits">
                <th colspan=5>Snacks</th>
                <tr>
                    
                    <?php $i=0; ?>
                    <?php foreach ($snacks as $ligne): ?>     
                        <?php if ($ligne["Visible"]==1) : ?>
                            <!-- max 5 produits par ligne, si + alors ferme tr ligne et commence nouvelle -->
                            <?php if ($i>=5) : ?>
                                </tr>
                                <tr>
                                <?php $i=0; ?>
                            <?php endif ?>
                            <td class="snacks">
                                <div class="produit">
                                    <div><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></div>
                                    <div><b><?=e($ligne["Nom"])?></b></div>
                                    <span class="prix"><?=e($ligne["Prix"])?></span><span> €</span>
                                </div>
                                <div><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></div>
                                <div class="hidden"><span class="id_prod"><?=e($ligne["id_produit"])?></span></div>
                            </td>
                            <!-- incrément-->
                            <?php $i+=1; ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </tr>
                <th colspan=5>Boissons</th>
                <tr>
                    <?php $j=0; ?>
                    <?php foreach ($boissons as $ligne): ?>
                        <?php if ($ligne["Visible"]==1) : ?>
                            <?php if ($j>=5) : ?>
                                </tr>
                                <tr>
                                <?php $j=0; ?>
                            <?php endif ?>
                            <td class="boissons">
                                <div class="produit">
                                    <div><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></div>
                                    <div><b><?=e($ligne["Nom"])?></b></div>
                                    <span class="prix"><?=e($ligne["Prix"])?></span><span> €</span>
                                </div>
                                <div><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></div>
                                <div class="hidden"><span class="id_prod"><?=e($ligne["id_produit"])?></span></div>
                            </td>
                            <!-- incrément-->
                            <?php $j+=1; ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </tr>
                <th colspan=5>Sodas</th>
                <tr>
                    <?php $k=0; ?>
                    <?php foreach ($sodas as $ligne): ?>
                        <?php if ($ligne["Visible"]==1) : ?>
                            <?php if ($k>=5) : ?>
                                </tr>
                                <tr>
                                <?php $k=0; ?>
                            <?php endif ?>
                            <td class="sodas">
                                <div class="produit">
                                    <div><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></div>
                                    <div><b><?=e($ligne["Nom"])?></b></div>
                                    <span class="prix"><?=e($ligne["Prix"])?></span><span> €</span>
                                </div>
                                <div><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></div>
                                <div class="hidden"><span class="id_prod"><?=e($ligne["id_produit"])?></span></div>
                            </td>
                            <!-- incrément-->
                            <?php $k+=1; ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </tr>
                <th colspan=5>Eau + Sirop</th>
                <tr>
                    <?php $l=0; ?>
                    <?php foreach ($sirops as $ligne): ?>
                        <?php if ($ligne["Visible"]==1) : ?>
                            <?php if ($l>=5) : ?>
                                </tr>
                                <tr>
                                <?php $l=0; ?>
                            <?php endif ?>
                            <td class="sirops">
                                <div class="produit">
                                    <div><img src="Content/img/<?=e($ligne["Img_produit"])?>" alt="Image <?=e($ligne["Nom"])?>" height="60" /></div>
                                    <div><b><?=e($ligne["Nom"])?></b></div>
                                    <span class="prix"><?=e($ligne["Prix"])?></span><span> €</span>
                                </div>
                                <div><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" alt="Image illustration stock" height="20px" /></div>
                                <div class="hidden"><span class="id_prod"><?=e($ligne["id_produit"])?></span></div>
                            </td>
                            <!-- incrément-->
                            <?php $l+=1; ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </tr>
            </table>
        </div>

    </div>

    

    <hr>
    </br>


</div> <!--fin panier + produits-->  
</main>

<!-- CHARGEMENT JAVASCRIPT CAISSE -->
<script defer type="text/javascript" src="Utils/caisse_enregist.js"></script>
<!-- CHARGEMENT JAVASCRIPT CAISSE -->

<?php require "view_end.php";?>