<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/mes_infos.css">

<h1>Mes informations</h1>

<hr>

<form action="?controller=set&action=update_infos_<?php if (isset($_SESSION["statut"]) && $_SESSION["statut"]=="admin") : ?>admin<?php elseif (isset($_SESSION["statut"]) && $_SESSION["statut"]=="client") : ?>client<?php endif ?>" method="post">
    <h2>Informations personnelles</h2>
    <br>
    <!-- 
      pour le traitement, 
      vérifier si la valeur est changé, 
      si c'est le cas modifier, 
      sinon laisser intact
    -->

    <!--TODO: PREREMPLIR LES CHAMPS -->

    <p>
      <label>Numéro étudiant :
        <input type="number" name="num_etudiant" value="<?=e($infos["num_etudiant"])?>" step="1" min="0" />
      </label>
    </p>
    <p>
      <label>Nom :
        <input type="text" name="Nom" value="<?=e($infos["Nom"])?>" maxlength="50" />
      </label>
    </p>
    <p>
      <label>Prénom :
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
      <label>Adresse mail :
        <input type="email" name="Email" value="<?=e($infos["Email"])?>" maxlength="255" />
      </label>
    </p>
    <p>
      Date de création : <b><?=date("d/m/Y",strtotime(e($infos["Date_creation"])))?></b>
    </p>
    <p>
      Points fidélité : <b><?=e($infos["Pts_fidelite"])?></b>
    </p>

    <!--Validation-->

    <p> <input type="submit" value="Modifier les informations"/> </p>
</form>
<form action="?controller=auth&action=newmdp" method="post">
    <h2>Modification de mot de passe</h2>
    <p>
      <label>Ancien mot de passe* :
        <br>
        <input type="password" name="Password" minlength="8" required />
      </label>
    </p>
    <p>
      <label>Nouveau mot de passe (min 8 caractères)* :
        <br>
        <input type="password" name="NewPassword" minlength="8" required />
      </label>
    </p>
    <p>
      <label>Confirmer le nouveau mot de passe* :
        <br>
        <input type="password" name="New_password_verif" minlength="8" required />
      </label>
    </p>
    <!--Validation-->
    <p><span>* </span> : obligatoire</p>
    <p> <input type="submit" value="Modifier le mot de passe"/> </p>
</form>
</main>

<?php require "view_end.php";?>
