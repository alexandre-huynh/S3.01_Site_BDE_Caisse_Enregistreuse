<?php require "view_begin.php";?>
<link rel="stylesheet" href="Content/css/login.css">

    <section class="connexion">
        <div class="se_connecter">
            <h1>Connexion</h1>
        </div>

         <div class="formulaire">

            <form action="?controller=auth&action=login" method="post" >
            <label for="adresse_mail"> Adresse mail :</label> <br>

            <input type="email" id="adresse_mail" name="Email" placeholder="jean.dupont@mail.com" required>
            <br>
            <label for="mot_de_passe"> Mot de passe :</label><br>

            <input type="password" id="mot_de_passe" name="Password" required>

            <p><a href="?controller=auth&action=form_oublimdp">Mot de passe oublié ? </a></p> <br>
            <button type="submit">Connexion</button><br>

            <p>Tu n'as de compte ? <a href="?controller=auth&action=form_signup">Inscris-toi</a></p>
            </form>
        </div>
    </section>
    </main>

<?php require "view_end.php";?>
