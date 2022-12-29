<?php require "view_begin.php";?>

<!-- Pour plus tard quand les variables sessions seront crées
< ?php if ($connected==True) : ?>
  < ?php require "view_begin_connected.php";?>
< ?php else : ?>
  < ?php require "view_begin.php";?>
< ?php endif ?>
-->

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<form action = "?controller=set&action=add_<?=e($element_to_add)?>" method="post">
    <!--
    Champs de saisie
    manuellement rédigé pour adapter le type de saisie
    -->
    <!-- -----------Ajout produit---------------- -->
    <!-- TODO: voir si $id_disponible dépend si on comble les id non utilisés ou si on rajoute à la fin-->
    <?php if ($element_to_add=="produit") : ?>
      <p>
        <label>Identifiant produit :
          <input type="number" name="id_produit" value="<?=e($id_disponible)?>" disabled /> 
        </label>
      </p>
      <p>
        <label>Nom de produit :
          <input type="text" name="Nom" /> 
        </label>
      </p>
      <p>
        <label>Catégorie :
          <select name="Categorie">
            <!-- TODO: réfléchir si optgroup (grande catégorie) et option de noms similaire = confus? -->
            <optgroup label="[===Confiseries===]">
              <option value="Confiserie">Confiserie</option>
            </optgroup>
            <optgroup label="[===Boissons===]">
              <option value="Boisson">Boisson</option>
              <option value="Soda">Soda</option>
              <option value="Sirop">Eau + Sirop</option>
            </optgroup>
        </label>
      </p>
      <p>
        <label>Prix :
          <input type="text" name="Prix" /> 
        </label>
      </p>
      
      <label><input type="text" name="< ?=e($valeur)?>" /> </label></p>
    <?php endif ?>
    <!-- -----------Ajout autrechose---------------- -->
    
    <!--
    Champs de saisie par défaut (toutes les saisies sont des champs textes
    < ?php foreach ($attributs as $valeur): ?>
      <p><label> < ?=e($valeur)?> <input type="text" name="< ?=e($valeur)?>" /> </label></p>
    < ?php endforeach ?>
    -->

    <!--Validation-->
    <p> <input type="submit" value="Ajouter à la base de données"/> </p>
</form>

<?php require "view_end.php";?>
