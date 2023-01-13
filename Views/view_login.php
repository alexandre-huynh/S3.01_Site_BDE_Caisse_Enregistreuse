<?php require "view_begin.php";?>

    <section class="connexion">
        <div class="se_connecter">
            <h1>Connexion</h1>
        </div>

        <form action="?controller=auth&action=login" method="post" >
            <div>
            <label for="adresse_mail"> Adresse mail :</label>

            <input type="email" id="adresse_mail" name="Email" placeholder="jean.dupont@mail.com" required>
            <br>
            <label for="mot_de_passe"> Mot de passe :</label>

            <input type="password" id="mot_de_passe" name="Password" required>

            <p><a href="?controller=auth&action=form_oublimdp">Mot de passe oublié ? </a></p>
            <button type="submit">Connexion</button>

            <p>Tu n'as de compte ? <a href="?controller=auth&action=form_signup">Inscris-toi</a></p>

            </div>
        </form>
    </section>
    </main>

<?php require "view_end.php";?>
