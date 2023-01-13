<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!--<form action = "?controller=set&action=add_< ?=e($element_to_add)?>" method="post">-->
<!-- TODO: vérifier dans le cas où le lien redirigé ne marche pas / ou donne la page d'accueil-->
<form action = "?controller=set&action=update_vente" method="post">  
  <!--
  Champs de saisie
  manuellement rédigé pour adapter le type de saisie
  -->
  <!----------------------------- 
            Update Vente
  ------------------------------->
  <p>
      <label>Numéro de vente* (prédéfini par le système):
        <input type="number" name="num_vente" value="<?=e($infos["num_vente"])?>" step="1" min="0" readonly  /> 
      </label>
    </p>
    <!--Sélection client-->
    <p>
      <label>Client acheteur* :
        <select name="id_client"  >
          <?php foreach ($clients as $ligne): ?>
            <option value="<?=e($ligne["id_client"])?>" <?php if (isset($infos["id_client"]) && e($ligne["id_client"])==e($infos["id_client"])) : ?>selected<?php endif ?>>
              n°<?=e($ligne["id_client"])?> - <?=e($ligne["Prenom"])?> <?=e($ligne["Nom"])?> (n° étud : <?=e($ligne["num_etudiant"])?>)
            </option>
          <?php endforeach ?>
        </select>
      </label>
    </p>
    <!--Sélection responsable/admin-->
    <p>
      <label>Responsable de la vente (administrateur)* :
        <select name="id_admin"  >
          <?php foreach ($admins as $ligne): ?>
            <option value="<?=e($ligne["id_admin"])?>" <?php if (isset($infos["id_admin"]) && e($ligne["id_admin"])==e($infos["id_admin"])) : ?>selected<?php endif ?>>
              n°<?=e($ligne["id_admin"])?> - <?=e($ligne["Prenom"])?> <?=e($ligne["Nom"])?> (n° étud : <?=e($ligne["num_etudiant"])?>)
            </option>
          <?php endforeach ?>
        </select>
      </label>
    </p>
    <!--Sélection produit-->
    <!-- 
      TODO: possibilité de faire un input saisie si le produit est acheté n fois,
      créer n lignes de ventes avec incrémentation du numéro de vente
      (à faire dans controller set action add vente)
    -->
    <p>
      <label>Produit vendu (si le même produit est acheté plusieurs fois, créer une autre vente)* :
        <select name="id_produit"  >
          <optgroup label="-Snacks-">
            <?php foreach ($snacks as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>" <?php if (isset($infos["id_produit"]) && e($ligne["id_produit"])==e($infos["id_produit"])) : ?>selected<?php endif ?>>
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <optgroup label="-Boissons-">
            <?php foreach ($boissons as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>" <?php if (isset($infos["id_produit"]) && e($ligne["id_produit"])==e($infos["id_produit"])) : ?>selected<?php endif ?>>
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <optgroup label="-Sodas-">
            <?php foreach ($sodas as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>" <?php if (isset($infos["id_produit"]) && e($ligne["id_produit"])==e($infos["id_produit"])) : ?>selected<?php endif ?>>
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <optgroup label="-Eau + Sirop-">
            <?php foreach ($sirops as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>" <?php if (isset($infos["id_produit"]) && e($ligne["id_produit"])==e($infos["id_produit"])) : ?>selected<?php endif ?>>
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <!-- 
            Si on veut tous les produits sans catégoriser, 
            gain de performance possible, mais moins ergonomique
          < ?php foreach ($produits as $ligne): ?>
            <option value="< ?=e($ligne["id_produit"])?>">
              < ?=e($ligne["Nom"])?> - < ?=e($ligne["Prix"])?> (< ?=e($ligne["Prix"])?> en stock)
            </option>
          < ?php endforeach ?>
          -->
        </select>
      </label>
    </p>
    <p>
      <label>Date de la vente* (corriger si nécessaire) :
        <input type="date" name="Date_vente" value="<?=e($infos["Date_vente"])?>"  /> 
      </label>
    </p>
    <p>
      <label>Moyen de paiement utilisé* :
        <input id="payer_espece" type="radio" name="Paiement" value="Espece" <?php if (isset($infos["Paiement"]) && e($infos["Paiement"])=="Espece") : ?>checked<?php endif ?>  /> 
        <label for="payer_espece">Espèce</label>
        <input id="payer_carte" type="radio" name="Paiement" value="Carte bancaire" <?php if (isset($infos["Paiement"]) && e($infos["Paiement"])=="Carte Bancaire") : ?>checked<?php endif ?>  />
        <label for="payer_carte">Carte bancaire</label>
      </label>
    </p>
    <p>
      <label>Le client a-t-il utilisé ses points de fidélité pour obtenir ce produit gratuitement ? :
        <input id="oui" type="radio" name="Use_fidelite" value="True" <?php if (isset($infos["Use_fidelite"]) && e($infos["Use_fidelite"])) : ?>checked<?php endif ?>/> 
        <label for="oui">Oui</label>
        <input id="non" type="radio" name="Use_fidelite" value="False" <?php if (isset($infos["Use_fidelite"]) && e(!$infos["Use_fidelite"])) : ?>checked<?php endif ?>/>
        <label for="non">Non</label>
      </label>
    </p>

  <!--Validation-->
  <p> <input type="submit" value="Modifier le produit"/> </p>
</form>
</main>

<?php require "view_end.php";?>
