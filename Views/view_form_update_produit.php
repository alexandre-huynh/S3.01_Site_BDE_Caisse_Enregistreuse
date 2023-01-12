<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!--<form action = "?controller=set&action=add_< ?=e($element_to_add)?>" method="post">-->
<!-- TODO: vérifier dans le cas où le lien redirigé ne marche pas / ou donne la page d'accueil-->
<form action = "?controller=set&action=update_produit" method="post" enctype="multipart/form-data">  
  <!--
  Champs de saisie
  manuellement rédigé pour adapter le type de saisie
  -->
  <!----------------------------- 
            Update produit
  ------------------------------->
    <p>
      <label>Identifiant produit* :
        <input type="number" name="id_produit" value="<?=e($infos["id_produit"])?>" step="1" min="0" readonly  /> 
      </label>
    </p>
    <p>
      <label>Nom de produit* :
        <input type="text" name="Nom" value="<?=e($infos["Nom"])?>" maxlength="50"  /> 
      </label>
    </p>
    <p>
      <label>Catégorie* :
        <select name="Categorie"  >
          <!-- TODO: réfléchir si optgroup (grande catégorie) et option de noms similaire = confus? -->
          <optgroup label="-Snacks-">
            <option value="Snack" <?php if (e($infos["Categorie"])=="Snack") : ?>selected<?php endif ?>>Snack</option>
          </optgroup>
          <optgroup label="-Boissons-">
            <option value="Boisson" <?php if (e($infos["Categorie"])=="Boisson") : ?>selected<?php endif ?>>Boisson</option>
            <option value="Soda" <?php if (e($infos["Categorie"])=="Soda") : ?>selected<?php endif ?>>Soda</option>
            <option value="Sirop" <?php if (e($infos["Categorie"])=="Sirop") : ?>selected<?php endif ?>>Eau + Sirop</option>
          </optgroup>
        </select>
      </label>
    </p>
    <p>
      <label>Prix* :
        <input type="number" name="Prix" value="<?=e($infos["Prix"])?>" step="0.01" min="0" /> €
      </label>
    </p>
    <p>
      <label>Cochez cette case si vous souhaitez mettre à jour l'image du produit dans le champs ci-dessous:
            <input type="checkbox" name="Update_img" value="True"  />
      </label>
    </p>
    <p>
      <label>Image du produit* (format .png / .jpg / .jpeg, taille de fichier max : 5 Mo) :
        <input type="file" name="produit_<?=e($infos["id_produit"])?>" accept=".png,.jpeg,.jpg"  />    
      </label>
      </br>
      <span>Fond transparent de préférence : Google Images > Outils > Couleur > Transparent</span>
    </p>
    <p>
      <label>Date de création* (corriger si nécessaire) :
        <input type="date" name="Date_ajout" value="<?=e($infos["Date_ajout"])?>"  /> 
      </label>
    </p>
    <p>
      <label>Nombre de points fidélité requis pour obtenir ce produit gratuitement* :
        <input type="number" name="Pts_fidelite_requis" value="<?=e($infos["Pts_fidelite_requis"])?>" step="1" min="0" /> pts
      </label>
    </p>
    <p>
      <label>Nombre de points fidélité octroyés/donnés lors de l'achat de ce produit* :
        <input type="number" name="Pts_fidelite_donner" value="<?=e($infos["Pts_fidelite_donner"])?>" step="1" min="0" /> pts
      </label>
    </p>
    <p>
      <label>Stock disponible* :
        <input type="number" name="Stock" value="<?=e($infos["Stock"])?>" step="1" min="0" /><img src="Content/img/logo_stock.png" alt="Logo Illustration Stock" height=20 />
      </label>
    </p>
    <p>
      <label>Ventes effectués* :
        <input type="number" name="Nb_ventes" value="<?=e($infos["Nb_ventes"])?>" step="1" min="0" /> <img src="Content/img/logo_ventes.png" alt="Logo Illustration Nb de Ventes" height=20 />
      </label>
    </p>
  <!--
  Champs de saisie par défaut (toutes les saisies sont des champs textes)
  au cas où s'il peut être utile
  non testé
  < ?php foreach ($attributs as $valeur): ?>
    <p><label> < ?=e($valeur)?> <input type="text" name="< ?=e($valeur)?>" /> </label></p>
  < ?php endforeach ?>
  -->

  <!--Validation-->
  <p> <input type="submit" value="Modifier le produit"/> </p>
</form>

<?php require "view_end.php";?>
