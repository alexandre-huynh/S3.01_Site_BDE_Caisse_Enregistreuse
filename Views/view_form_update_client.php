<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!--<form action = "?controller=set&action=add_< ?=e($element_to_add)?>" method="post">-->
<!-- TODO: vérifier dans le cas où le lien redirigé ne marche pas / ou donne la page d'accueil-->
<form action = "?controller=set&action=update_client" method="post" enctype="multipart/form-data">  
  <!--
  Champs de saisie
  manuellement rédigé pour adapter le type de saisie
  -->
  <!----------------------------- 
            Update produit
  ------------------------------->
  <p>
      <label>Identifiant client* (prédéfini par le système) :
        <input type="number" name="id_client" value="<?=e($infos["id_produit"])?>" step="1" min="0" readonly  /> 
      </label>
    </p>
    <p>
      <label>Numéro étudiant* :
        <input type="number" name="num_etudiant" value="<?=e($infos["num_etudiant"])?>" step="1" min="0"  />
      </label>
    </p>
    <p>
      <label>Nom* :
        <input type="text" name="Nom" value="<?=e($infos["Nom"])?>" maxlength="50"  />
      </label>
    </p>
    <p>
      <label>Prénom* :
        <input type="text" name="Prenom" value="<?=e($infos["Prenom"])?>" maxlength="50"  />
      </label>
    </p>
    <p>
      <label>N° de Téléphone (facultatif) :
        <!--TODO: possible d'implémenter attribut pattern qui utilise une expression régulière-->
        <input type="tel" name="Tel" value="<?=e($infos["Tel"])?>" maxlength="15" />
      </label>
    </p>
    <p>
      <label>Adresse mail* :
        <input type="email" name="Email" value="<?=e($infos["Email"])?>" maxlength="255"  />
      </label>
    </p>
    <p>
      <label>Date de création* (corriger si nécessaire) :
        <input type="date" name="Date_creation" value="<?=e($infos["Date_creation"])?>"  /> 
      </label>
    </p>
    <p>
      <label>Points fidélité* :
        <input type="number" name="Pts_fidelite" value="<?=e($infos["Pts_fidelite"])?>" step="1" min="0"  />
      </label>
    </p>
    <p>
      <label>Mot de passe (min 8 caractères)* :
        <input type="password" name="Password" minlength="8"  />
      </label>
    </p>
    <p>
      <label>Confirmer le mot de passe* :
        <input type="password" name="Password_verify" minlength="8"  />
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
  <p> <input type="submit" value="Modifier les informations du client"/> </p>
</form>
</main>

<?php require "view_end.php";?>
