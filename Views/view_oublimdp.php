<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<section class="mdp_oublie">
  <div class="mot_de_passe_oublie">
  <h1>Mot de passe oublié</h1>
  <p>
    Saisissez votre adresse e-mail pour recevoir 
    les instructions expliquant comment réinitialiser votre mot de passe.
  </p>

  <form action="?controller=auth&action=oublimdp">
      <div>
      <label for="adresse_mail"> Adresse mail :</label>

      <input type="text" id="adresse_mail" name="Email" placeholder="etudiant@iutv.fr" />

      <input type="submit" value="Envoyer" />
      <p><a href="?controller=auth&action=form_login">Revenir à l'écran de connexion</a></p>
      </div>
  </form>
</section>

<?php require "view_end.php";?>