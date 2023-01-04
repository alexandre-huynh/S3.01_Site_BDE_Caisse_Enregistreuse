<?php require "view_begin.php";?>

    <section class="connexion">
        <div class="se_connecter">
            <h1>Connexion</h1>
        </div>

        <form action="?controller=auth&action=login">
            <div>
            <label for="adresse_mail"> Adresse mail :</label>

            <input type="email" id="adresse_mail" name="Email" placeholder="etudiant@iutv.fr" required>
            <br>
            <label for="mot_de_passe"> Mot de passe :</label>

            <input type="password" id="mot_de_passe" name="Password" required>

            <p><a href="page_mdp_oublie.html">Mot de passe oublié ? </a></p>
            <button type="submit">Connexion</button>

            <p>Tu n'as de compte ? <a href="page_inscription.html"> &nbsp;Inscris-toi</a></p>

            </div>
        </form>
    </section>

<?php require "view_end.php";?>
