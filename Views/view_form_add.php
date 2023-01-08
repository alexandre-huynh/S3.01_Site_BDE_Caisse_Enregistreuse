<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!--<form action = "?controller=set&action=add_< ?=e($element_to_add)?>" method="post">-->
<!-- TODO: vérifier dans le cas où le lien redirigé ne marche pas / ou donne la page d'accueil-->
<form action = "?controller=set&action=add_<?= e($element_to_add) ?>" method="post" enctype="multipart/form-data">  
  <!--
  Champs de saisie
  manuellement rédigé pour adapter le type de saisie
  -->
  <!----------------------------- 
            Ajout produit
  ------------------------------->
  <!-- TODO: voir si $id_disponible dépend si on comble les id non utilisés ou si on rajoute à la fin-->
  <?php if ($element_to_add=="produit") : ?>
    <p>
      <label>Identifiant produit* :
        <input type="number" name="id_produit" value="<?=e($id_disponible)?>" step="1" min="0" readonly required /> 
      </label>
    </p>
    <p>
      <label>Nom de produit* :
        <input type="text" name="Nom" maxlength="50" required /> 
      </label>
    </p>
    <p>
      <label>Catégorie* :
        <select name="Categorie" required >
          <!-- TODO: réfléchir si optgroup (grande catégorie) et option de noms similaire = confus? -->
          <optgroup label="-Snacks-">
            <option value="Snack">Snack</option>
          </optgroup>
          <optgroup label="-Boissons-">
            <option value="Boisson">Boisson</option>
            <option value="Soda">Soda</option>
            <option value="Sirop">Eau + Sirop</option>
          </optgroup>
        </select>
      </label>
    </p>
    <p>
      <label>Prix* :
        <input type="number" name="Prix" step="0.01" min="0" required/> €
      </label>
    </p>
    <p>
      <label>Image du produit* :
        <!-- TODO: adapter si jpeg, à modifier dans affichage de produits et inventaire-->
        <!-- TODO: Joe, trouver une manière d'ajouter l'image envoyé au répertoire Content/img/ -->
        <input type="file" name="produit_<?=e($id_disponible)?>" accept=".png,.jpeg,.jpg" required /> 
        <input type="hidden" name="Img_produit" value="produit_<?=e($id_disponible)?>" /> 
      </label>
    </p>
    <p>
      <label>Date de création* (corriger si nécessaire) :
        <!-- TODO: un truc pour avoir la date du jour-->
        <!-- utiliser fonction date('d-m-y'), mais dans controller-->
        <input type="date" name="Date_ajout" value="<?=e($date_today)?>" required /> 
      </label>
    </p>
    <p>
      <label>Nombre de points fidélité requis pour obtenir ce produit gratuitement* :
        <input type="number" name="Pts_fidelite_requis" step="1" min="0" required/> pts
      </label>
    </p>
    <p>
      <label>Nombre de points fidélité octroyés/donnés lors de l'achat de ce produit* :
        <input type="number" name="Pts_fidelite_donner" step="1" min="0" required/> pts
      </label>
    </p>
    <p>
      <label>Stock disponible* :
        <input type="number" name="Stock" step="1" min="0" required />
      </label>
    </p>
    <p>
      <label>Ventes effectués* :
        <input type="number" name="Nb_ventes" value="0" step="1" min="0" required />
      </label>
    </p>
  
  <!----------------------------- 
        Ajout Client / Admin
  ------------------------------->
  <?php elseif ($element_to_add=="client" || $element_to_add=="admin") : ?>
    <p>
      <label>Identifiant 
        <?php if ($element_to_add=="client") : ?>
          client*
        <?php elseif ($element_to_add=="admin") : ?>
          admin*
        <?php endif ?> :
        <input type="number" 
               name="id_<?php if ($element_to_add=="client") : ?>client<?php elseif ($element_to_add=="admin") : ?>admin<?php endif ?>" 
               value="<?=e($id_disponible)?>" step="1" min="0" readonly required /> 
      </label>
    </p>
    <p>
      <label>Numéro étudiant* :
        <input type="number" name="num_etudiant" step="1" min="0" required />
      </label>
    </p>
    <p>
      <label>Nom* :
        <input type="text" name="Nom" maxlength="50" required />
      </label>
    </p>
    <p>
      <label>Prénom* :
        <input type="text" name="Prenom" maxlength="50" required />
      </label>
    </p>
    <p>
      <label>N° de Téléphone (facultatif) :
        <!--TODO: possible d'implémenter attribut pattern qui utilise une expression régulière-->
        <input type="tel" name="Tel" maxlength="15" />
      </label>
    </p>
    <p>
      <label>Adresse mail* :
        <input type="email" name="Email" maxlength="255"  required/>
      </label>
    </p>
    <p>
      <label>Date de création* (corriger si nécessaire) :
        <!-- TODO: un truc pour avoir la date du jour-->
        <!-- utiliser fonction date('d-m-y'), mais dans controller-->
        <input type="date" name="Date_creation" value="<?=e($date_today)?>" required /> 
      </label>
    </p>
    <p>
      <label>Points fidélité* :
        <input type="number" name="Pts_fidelite" value="0" step="1" min="0" required />
      </label>
    </p>
    <p>
      <label>Mot de passe (min 8 caractères)* :
        <input type="password" name="Password" minlength="8" required />
      </label>
    </p>
    <p>
      <label>Confirmer le mot de passe* :
        <input type="password" name="Password_verify" minlength="8" required />
      </label>
    </p>
    <?php if ($element_to_add=="admin") : ?>
      <!--
        TODO: voir si un super administrateur peut créer un super administrateur
        étant donné qu'on est dans l'interface de gestion des administrateurs,
        celui qui crée un admin ici est un super admin

        voir aussi si c'est sécurisé, dans le cas où le gars inspecte le code et modifie?
        d'ailleurs bonjour au lecteur de ce commentaire
      -->
      <p>
        <label>Rôle de super-administrateur (ATTENTION: soyez-sûr de votre choix) :
          <input type="checkbox" name="Create_superadmin" value="True" required />
        </label>
      </p>
    <?php endif ?>
  <!----------------------------- 
        Ajout Vente
  ------------------------------->
  <?php elseif ($element_to_add=="vente") : ?>
    <p>
      <label>Numéro de vente* :
        <input type="number" name="num_vente" value="<?=e($id_disponible)?>" step="1" min="0" readonly required /> 
      </label>
    </p>
    <!--Sélection client-->
    <p>
      <label>Client acheteur* :
        <select name="id_client" required >
          <?php foreach ($clients as $ligne): ?>
            <option value="<?=e($ligne["id_client"])?>">
              n°<?=e($ligne["id_client"])?> - <?=e($ligne["Prenom"])?> <?=e($ligne["Nom"])?> (n° étud : <?=e($ligne["num_etudiant"])?>)
            </option>
          <?php endforeach ?>
        </select>
      </label>
    </p>
    <!--Sélection responsable/admin-->
    <p>
      <label>Responsable de la vente (administrateur)* :
        <select name="id_admin" required >
          <?php foreach ($admins as $ligne): ?>
            <option value="<?=e($ligne["id_admin"])?>">
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
        <select name="id_produit" required >
          <optgroup label="-Snacks-">
            <?php foreach ($snacks as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>">
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <optgroup label="-Boissons-">
            <?php foreach ($boissons as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>">
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <optgroup label="-Sodas-">
            <?php foreach ($sodas as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>">
                <?=e($ligne["Nom"])?> - <?=e($ligne["Prix"])?> € (en stock : <?=e($ligne["Stock"])?>)
              </option>
            <?php endforeach ?>
          </optgroup>
          <optgroup label="-Eau + Sirop-">
            <?php foreach ($sirops as $ligne): ?>
              <option value="<?=e($ligne["id_produit"])?>">
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
        <input type="date" name="Date_vente" value="<?=e($date_today)?>" required /> 
      </label>
    </p>
    <p>
      <label>Moyen de paiement utilisé* :
        <input id="payer_espece" type="radio" name="Paiement" value="Espece" required /> 
        <label for="payer_espece">Espèce</label>
        <input id="payer_carte" type="radio" name="Paiement" value="Carte bancaire" required />
        <label for="payer_carte">Carte bancaire</label>
      </label>
    </p>
    <p>
      <label>Le client a-t-il utilisé ses points de fidélité pour obtenir ce produit gratuitement ? :
        <input id="oui" type="radio" name="Use_fidelite" value="True" /> 
        <label for="oui">Oui</label>
        <input id="non" type="radio" name="Use_fidelite" value="False" checked/>
        <label for="non">Non</label>
      </label>
    </p>
  <?php endif ?>
  <!--
  Champs de saisie par défaut (toutes les saisies sont des champs textes)
  au cas où s'il peut être utile
  non testé
  < ?php foreach ($attributs as $valeur): ?>
    <p><label> < ?=e($valeur)?> <input type="text" name="< ?=e($valeur)?>" /> </label></p>
  < ?php endforeach ?>
  -->

  <!--Validation-->
  <p>* : obligatoire</p>
  <p> <input type="submit" value="Ajouter à la base de données"/> </p>
</form>

<?php require "view_end.php";?>
