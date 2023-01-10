<?php

class Controller_auth extends Controller{

  public function action_form_login(){
    $m = Model::getModel();

    // =================================================
    // s'il est déjà connecté et est admin
    // au cas où, pour éviter qu'il se reconnecte alors qu'il est déjà connecté
    // =================================================
    if (isset($_SESSION["connected"]) && isset($_SESSION['statut']) && $_SESSION["connected"] && $_SESSION['statut']=="admin"){

      $data = [
          "nomprenom" => $m->getPrenomNomClient($m->getIdClientFromEmail($_SESSION["email"])),
          "recettes_today" => $m->getRecettesJour(),
          "recettes_week" => $m->getRecettesSemaine(),
          "recettes_month" => $m->getRecettesMois(),
        ]; 
      $this->render("espace_admin", $data);
    }

    // =================================================
    // s'il est déjà connecté et est client
    // au cas où, pour éviter qu'il se reconnecte alors qu'il est déjà connecté
    // =================================================
    elseif (isset($_SESSION["connected"]) && isset($_SESSION['statut']) && $_SESSION["connected"] && $_SESSION['statut']=="client"){
      $idClient = $_SESSION['id_client'];

      $datesVente = $m->getDatesVentesClient($idClient);

      $historique = [];

      foreach($datesVente as $ligne){
        $historique[$ligne["Date_vente"]] = $m->getHistoriqueAchatsClient($idClient, $ligne["Date_vente"]);
      }

      date_default_timezone_set('Europe/Paris');
      
      // Redirige le client vers la page d'accueil client
      $data = [
          "nomprenom" => $m->getPrenomNomClient($m->getIdClientFromEmail($_SESSION["email"])),
          "ptsfidelite" => $m->getPointsFidelite($_SESSION['id_client'],"Client"),
          "historique" => $historique
          ]; 
      $this->render("espace_client", $data);
    }
    else {
      $data = []; 

      $this->render("login", $data);
    }
  }

  public function action_form_signup(){
    $m = Model::getModel();

    $data = []; 

    $this->render("signup", $data);
  }

  public function action_form_oublimdp(){
    $m = Model::getModel();

    $data = []; 

    $this->render("oublimdp", $data);
  }

  public function action_login(){

    $m = Model::getModel();

    // Vérifie si l'utilisateur a soumis le formulaire de connexion
    if (isset($_POST['Email']) and isset($_POST['Password'])) {
      // Récupère les informations de connexion
      /* 
      TODO: Faire une fonction getIdClientFromEmail($email)
      faut que email deviennent un id client ou id admin ou num etudiant
      */
      $email = $_POST['Email'];
      $password = $_POST['Password'];
      // Vérifier si l'utilisateur existe dans la base de données avec les fonction isInDatabaseClient et isInDatabaseAdmin 
      if ($m->isInDatabaseAdmin($email)){
        // Vérifier si le mot de passe saisie est correct 
        if (password_verify($password, $m->getPassword($email,"Admin"))){

            //session_start();
            
            // Enregistre l'utilisateur dans la session
            $_SESSION['email'] = $email;
            $_SESSION['id_admin'] = $m->getIdAdminFromEmail($email);
            $_SESSION['prenomnom'] = $m->getPrenomNomAdmin($_SESSION['id_admin']);
            $_SESSION['num_etudiant'] = $m->getNumEtudiantAdminFromEmail($email);
            $_SESSION['connected'] = true;
            $_SESSION['statut'] = 'admin';
            // TODO: implémenter un statut superadmin s'il est superadmin,
            // pour cela, faire une requete SQL dans model
            if ($m->isInDatabaseSuperAdmin($_SESSION['id_admin'])){
              $_SESSION['superadmin'] = true;
            }
            // Redirige l'admin vers la page d'accueil admin                
            $data = [
                "nomprenom" => $m->getPrenomNomAdmin($_SESSION['id_admin']),
                "recettes_today" => $m->getRecettesJour(),
                "recettes_week" => $m->getRecettesSemaine(),
                "recettes_month" => $m->getRecettesMois(),
                ]; 
            $this->render("espace_admin", $data);
        }
        else {
          $this->action_error("Adresse mail ou mot de passe incorrect.");
        }
      }
      elseif ($m->isInDatabaseClient($email)){
        // Vérifier si le mot de passe saisie est correct
        if(password_verify($password, $m->getPassword($email,"Client"))){

                //session_start();
                
                // Enregistre l'utilisateur dans la session
                $_SESSION['email'] = $email;
                $_SESSION['id_client'] = $m->getIdClientFromEmail($email);
                $_SESSION['prenomnom'] = $m->getPrenomNomClient($_SESSION['id_client']);
                $_SESSION['num_etudiant'] = $m->getNumEtudiantClientFromEmail($email);
                $_SESSION['connected'] = true;
                $_SESSION['statut'] = 'client';

                //=====================================
                // Pour affichage des achats récents, par date
                // TODO: copier le code / action dans list pour quand le client accède
                // à son espace 

                // mettre en commentaire pour l'instant si problématique

                $idClient = $_SESSION['id_client'];

                $datesVente = $m->getDatesVentesClient($idClient);

                $historique = [];

                foreach($datesVente as $ligne){
                  $historique[$ligne["Date_vente"]] = $m->getHistoriqueAchatsClient($idClient, $ligne["Date_vente"]);
                }

                date_default_timezone_set('Europe/Paris');
                
                // Redirige le client vers la page d'accueil client
                $data = [
                    "nomprenom" => $m->getPrenomNomClient($m->getIdClientFromEmail($email)),
                    "ptsfidelite" => $m->getPointsFidelite($_SESSION['id_client'],"Client"),
                    "historique" => $historique
                    ]; 
                //$this->render("espace_client", $data);
                $this->render("espace_client", $data);
        }
        else {
          $this->action_error("Adresse mail ou mot de passe incorrect.");
        }
      }

      // Non client et non admin
      else {
        // Affiche un message d'erreur
        $this->action_error("Les identifiants fournis n'existent pas dans la base de données. Veuillez vous inscrire.");
      }
    }

    else {
      // Affiche un message d'erreur
      $this->action_error("L'adresse mail ou le mot de passe n'a pas été saisi.");
    }
    
  } // fin de fonction

  public function action_signup(){

    $m = Model::getModel();

    $ajout = false;

    //Test si les informations nécessaires sont fournies
    /* exemple de vérification
    if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
        and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
        and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
    */
    
    if (isset($_POST["num_etudiant"]) && 
    isset($_POST["Nom"]) && 
    isset($_POST["Prenom"]) && 
    isset($_POST['Password']) &&
    isset($_POST['Password_verify']) &&
    $_POST["Password"]==$_POST["Password_verify"] &&
    isset($_POST['Email']))
    {
      if($m->isInDatabaseClient($_POST['Email'])){
        $this->action_error("Cette adresse mail est déjà utilisée, veuillez en saisir une autre.");
      }
      elseif($m->verifNumEtudiant($_POST['num_etudiant'])){
        $this->action_error("Le numéro étudiant saisi est déjà utilisé, veuillez revérifiez votre saisie. 
        Si le problème persiste, parlez-en aux responsables du BDE");
      }
      else{
        // !!
        // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
        // !!
        $tab = [
          "id_client" => $m->getDernierIdDisponible("Client"),
          "num_etudiant" => $_POST["num_etudiant"], 
          "Nom" => $_POST["Nom"], 
          "Prenom" => $_POST["Prenom"], 
          "Tel" => $_POST["Tel"], 
          "Email" => $_POST["Email"], 
          "Date_creation" => date("Y-m-d"), 
          "Pts_fidelite" => 0
        ];


        // Préparation du tableau infos
        $infos = [];
        $noms = ["id_client", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
        foreach ($noms as $v) {
            if (isset($tab[$v]) && ((is_string($tab[$v]) && ! preg_match("/^ *$/", $tab[$v])) || ((is_int($tab[$v]) || is_float($tab[$v])) && $tab[$v]>=0))) {
              // && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)
              $infos[$v] = $tab[$v];
              //debug
              //echo "Ajout $v OK";
            } else {
              $infos[$v] = null;
              //echo "Ajout $v OK, valeur NULL";
            }
        }

        $infosAuth = [$_POST["num_etudiant"], password_hash($_POST["Password"], PASSWORD_DEFAULT)];

        //Récupération du modèle
        $m = Model::getModel();
        //Ajout du client
        $m->addAuth($infosAuth);
        $ajout = $m->addClient($infos);
        
    }
    }
    else{
      $this->action_error("Erreur, des informations n'ont pas été saisies ou le mot de passe n'est pas correspondant.");
    }

    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Bienvenue parmi nous !",
        "added_element" => "client",
        "str_lien_retour" => "Retour à la page d'accueil",
        "lien_retour" => "?controller=home&action=home" 
    ];
    if ($ajout) {
        $data["message"] = "Votre inscription a bien été prise en compte, " . $_POST["Prenom"] . " " . $_POST["Nom"] . ". Vous pouvez maintenant vous connecter à votre espace client en vous connectant.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, le compte client n'a pas été ajouté.";
    }

    $this->render("message", $data);
  }
        
  public function action_oublimdp(){
    $m = Model::getModel();

      if(isset($_POST['Email'])){

        $password = uniqid();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        $message = "Bonjour, voici votre nouveau mot de passe : $password";
        $headers = 'Content-Type: text/plain; charest="utf-8"'." ";
        
        if(mail($_POST['Email'], 'Mot de passe oublié',$message, $headers)){
    
          if($m->isInDatabaseAdmin($email)){

            $table = "Admin";
            $m->updatePassword($email,$hashedPassword,$table);        

          }
          elseif($m->isInDatabaseClient($email)){

            $table = "Client";
            $m->updatePassword($email,$hashedPassword,$table);

          }
            
        }
        else{
    
            $this->action_error("Une erreur est survenue .. ");
    
        }
    }
  }

  public function action_newmdp(){
    $m = Model::getModel();

    // verif si dans la DB de CLient ou Admin 
    if($m->isInDatabaseAdmin($_SESSION['email'])){
      $table = "Admin";
    }
    elseif($m->isInDatabaseClient($_SESSION['email'])){
      $table = "Client";
    }

    // Vérif si l'utilisateur est bien connecté 
    if (isset($_SESSION['connected']) and $_SESSION['connected']){

      // Faire verif si les champs ont bien été saisis 
        if (isset($_POST['Password']) and isset($_POST['NewPassword']) and isset($_POST['New_password_verif'])){

            // On récupère le password dans la BDD
            $pas = $m->getPassword($_SESSION['email'],$table);

            // vérifier si le password correspond bien à celui de l'utilisateur connecté
            if (password_verify($_POST['Password'],$pas )){

                if ($_POST['NewPassword']==$_POST['New_password_verif']){

                  // Pour update le nouveau password dans la BDD 
                  $m->updatePassword($_SESSION['email'], password_hash($_POST['NewPassword']), $table);
                  $data= [
                    "message" => "Mot de passe modifié."
                  ];
                  $this->render("message", $data);
                }
                else {
                  // Temporaire
                  $this->action_error("Mot de passe et confirmation non correspondant.");
                }
            }
            else {
              // Temporaire
              $this->action_error("Ancien mot de passe non correspondant.");
            }
        }
        else {
          // Temporaire
          $this->action_error("Champs non saisies.");
        }
    }
    else {
      // Temporaire
      $this->action_error("Non connecté.");
    }

  }
  
  public function action_logout(){
    if(isset($_SESSION['connected']) && $_SESSION['connected'] !== null ){
      $_SESSION = array();
      session_destroy();
      $data = [
        "message" => "Vous avez été déconnecté."
      ];
      $this->render("message", $data);
    }
    else{
      $this->action_error("Vous n'êtes pas connectés ");
    }
  }


  public function action_default(){
      $this->action_form_login();
  }

}
?>
