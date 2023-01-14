<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<section class="inscription">
  <h1>Formulaire d'inscription</h1>

  <form action="?controller=auth&action=signup" method="post" >
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
        <input type="email" name="Email" maxlength="255" required/>
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
    <p>* : obligatoire</p>
    <p> <input type="submit" value="S'inscrire"/> </p>
  </form>
</section>

</main>
<?php require "view_end.php";?>
