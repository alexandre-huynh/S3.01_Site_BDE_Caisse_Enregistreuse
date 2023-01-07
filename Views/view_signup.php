<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<section class="inscription">
            <div class="s_inscire">
                <h1>Formulaire d'inscription</h1>
            </div>

        <form action="?controller=auth&action=signup" method="post" >
            
            <div class="form_connexion">
                <label for="nom"> Nom :</label>
                <input type="text" id="nom" name="nom" required>
                <br>
    
                <label for="prenom"> Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
                <br>

                <label for="adresse_mail"> Adresse mail :</label>
                <input type="text" id="adresse_mail" name="adresse_mail" required>
                <br>

                <label for="telephone"> Téléphone <span>(facultatif) </span> :</label>
                <input type="text" id="telephone" name="telephone" required>
                <br>

                <label for="num_etudiant"> Numéro étudiant :</label>
                <input type="text" id="num_etudiant" name="num_etudiant" required>
                <br>

                <label for="mot_de_passe"> Mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <label for="mot_de_passe"> Confirmer mot de passe :</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required>

                <p>* obligatoire</p>
            </div>
        </form>
</section>

<?php require "view_end.php";?>
