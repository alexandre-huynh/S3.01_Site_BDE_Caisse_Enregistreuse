<?php require "view_begin.php"; ?>

<section class="mdp_oublie">
            <div class="mot_de_passe_oublie">
                <h1>Mot de passe oublié</h1>
                <p>Saisissez votre adresse e-mail pour recevoir 
                    les instructions expliquant comment réinitialiser votre mot de passe.
                </p>

                <form>
                    <div>
                    <label for="adresse_mail"> Adresse mail :</label>
            
                    <input type="text" id="adresse_mail" name="Email" placeholder="etudiant@iutv.fr">

                    <button type="submit">Envoyer</button>
                    <p><a href="?controller=home&action=home">Revenir à l'écran de connexion</a></p>
                    </div>
                </form>
</section>

<?php require "view_end.php";?>