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
  <!----------------------------- 
            Ajout produit
  ------------------------------->
  <!-- TODO: voir si $id_disponible dépend si on comble les id non utilisés ou si on rajoute à la fin-->
  <?php if ($element_to_add=="produit") : ?>
    <p>
      <label>Identifiant produit* :
        <input type="number" name="id_produit" value="<?=e($id_disponible)?>" step="1" min="0" disabled required /> 
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
          <optgroup label="[===Confiseries===]">
            <option value="Confiserie">Confiserie</option>
          </optgroup>
          <optgroup label="[===Boissons===]">
            <option value="Boisson">Boisson</option>
            <option value="Soda">Soda</option>
            <option value="Sirop">Eau + Sirop</option>
          </optgroup>
        </select>
      </label>
    </p>
    <p>
      <label>Prix :
        <input type="number" name="Prix" step="0.01" min="0" required/> €
      </label>
    </p>
    <p>
      <label>Image du produit* :
        <!-- TODO: adapter si jpeg, à modifier dans affichage de produits et inventaire-->
        <!-- TODO: Joe, trouver une manière d'ajouter l'image envoyé au répertoire Content/img/ -->
        <input type="file" name="Img_produit" accept=".png,.jpeg" required /> 
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
          client
        <?php elseif ($element_to_add=="admin") : ?>
          admin
        <?php endif ?> :
        <input type="number" 
               name=
                "id_
                <?php if ($element_to_add=="client") : ?>
                  client
                <?php elseif ($element_to_add=="admin") : ?>
                  admin
                <?php endif ?>
                " 
               value="<?=e($id_disponible)?>" step="1" min="0" disabled required /> 
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
          <input type="checkbox" name="Create_superadmin" required />
        </label>
      </p>
    <?php endif ?>
  <!----------------------------- 
        Ajout Vente
  ------------------------------->
  <?php elseif ($element_to_add=="vente") : ?>

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
