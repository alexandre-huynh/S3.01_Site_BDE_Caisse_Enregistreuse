<?php require "view_begin.php";?>

<h1>Mes informations</h1>

<hr>

<form action="?controller=set&action=update_infos" method="post">
    <h2>Informations personnelles</h2>
    <!-- 
      pour le traitement, 
      vérifier si la valeur est changé, 
      si c'est le cas modifier, 
      sinon laisser intact
    -->

    <!--TODO: PREREMPLIR LES CHAMPS -->

    <p>
      <label>Numéro étudiant :
        <input type="number" name="num_etudiant" step="1" min="0" />
      </label>
    </p>
    <p>
      <label>Nom :
        <input type="text" name="Nom" maxlength="50" />
      </label>
    </p>
    <p>
      <label>Prénom :
        <input type="text" name="Prenom" maxlength="50"  />
      </label>
    </p>
    <p>
      <label>N° de Téléphone (facultatif) :
        <!--TODO: possible d'implémenter attribut pattern qui utilise une expression régulière-->
        <input type="tel" name="Tel" maxlength="15" />
      </label>
    </p>
    <p>
      <label>Adresse mail :
        <input type="email" name="Email" maxlength="255" />
      </label>
    </p>
    <p>
      Date de création : <!--< ?=e($infos["Date_creation"])?>-->
    </p>
    <p>
      Points fidélité : <!--< ?=e($date_today)?>-->
    </p>
</form>
<form action="?controller=auth&action=newmdp" method="post">
    <h2>Modifier son mot de passe</h2>
    <p>
      <label>Ancien mot de passe* :
        <input type="password" name="Password" minlength="8" required />
      </label>
    </p>
    <p>
      <label>Nouveau mot de passe (min 8 caractères)* :
        <input type="password" name="NewPassword" minlength="8" required />
      </label>
    </p>
    <p>
      <label>Confirmer le nouveau mot de passe* :
        <input type="password" name="New_password_verif" minlength="8" required />
      </label>
    </p>
</form>

<?php require "view_end.php";?>
