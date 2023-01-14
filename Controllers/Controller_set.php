<?php

class Controller_set extends Controller{

  /*
  ===========================================================
                       AJOUT D'ELEMENT
  ===========================================================
  */

  // Affichage du formulaire
  public function action_form_add_produit(){
    // on récupère le Model
    $m = Model::getModel();

    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    // timezone date, pas nécessaire vu qu'on traite date du jour mais au cas où
    date_default_timezone_set('Europe/Paris');

    // date du jour
    $date_today = date("Y-m-d");

    /* trouver l'idée le 1er id disponible dans la bd: idée abandonné/mis en suspend
    $i=0;
    $liste = $m->getProduits();
    foreach ($liste as $c=>$v){
      $v;
      $i++;
    }
    */

    $data = [
      "titre" => "Création d'un nouveau produit",
      "date_today" => $date_today,
      "element_to_add" => "produit",
      "id_disponible" => $m->getDernierIdDisponible("Produit")
      ]; 

    $this->render("form_add", $data);
  }

  // Affichage du formulaire
  public function action_form_add_client(){
    // on récupère le Model
    $m = Model::getModel();

    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    // timezone date, pas nécessaire vu qu'on traite date du jour mais au cas où
    date_default_timezone_set('Europe/Paris');

    // date du jour
    $date_today = date("Y-m-d");

    $data = [
      "titre" => "Création d'un nouveau compte client",
      "date_today" => $date_today,
      "element_to_add" => "client",
      "id_disponible" => $m->getDernierIdDisponible("Client")
      ]; 

    $this->render("form_add", $data);
  }

  // Affichage du formulaire
  public function action_form_add_admin(){
    // on récupère le Model
    $m = Model::getModel();

    //==================================
    //  TEST SI C'EST UN SUPER ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"]) || !$m->isInDatabaseSuperAdmin($_SESSION["id_admin"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    // timezone date, pas nécessaire vu qu'on traite date du jour mais au cas où
    date_default_timezone_set('Europe/Paris');

    // date du jour
    $date_today = date("Y-m-d");

    $data = [
      "titre" => "Création d'un nouveau compte administrateur",
      "date_today" => $date_today,
      "element_to_add" => "admin",
      "id_disponible" => $m->getDernierIdDisponible("Admin")
      ]; 

    $this->render("form_add", $data);
  }

  // Affichage du formulaire
  public function action_form_add_vente(){
    // on récupère le Model
    $m = Model::getModel();

    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    // timezone date, pas nécessaire vu qu'on traite date du jour mais au cas où
    date_default_timezone_set('Europe/Paris');

    // date du jour
    $date_today = date("Y-m-d");

    $data = [
      "titre" => "Création manuelle d'une vente",
      "date_today" => $date_today,
      "element_to_add" => "vente",
      "clients" => $m->getClients(),
      "admins" => $m->getAdmins(),
      "snacks" => $m->getProduits("default","Snack","default"),
      "boissons" => $m->getProduits("default", "Boisson", "default"),
      "sodas" => $m->getProduits("default", "Soda", "default"),
      "sirops" => $m->getProduits("default", "Sirop", "default"),
      "id_disponible" => $m->getDernierIdDisponible("Vente")
      ]; 

    $this->render("form_add", $data);
  }

  // Traitement du formulaire
  public function action_add_produit(){
    // TODO: si quelqu'un peut s'occuper de faire les vérifications logiques des données avec isset
    // genre si c'est bien un int, c'est bien supérieur à 0 mais inférieur à truc etc
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================
    $ajout = false;

        //Test si les informations nécessaires sont fournies
        /* exemple de vérification
        if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
            and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
            and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
        */
        
        if (isset($_POST["id_produit"]) &&
          isset($_POST["Nom"]) &&
          isset($_POST["Categorie"]) &&
          isset($_POST["Prix"]) &&
          isset($_POST["Date_ajout"]) &&
          isset($_POST["Pts_fidelite_requis"]) &&
          isset($_POST["Pts_fidelite_donner"]) &&
          isset($_POST["Stock"]) &&
          isset($_POST["Nb_ventes"])
          ) {
            // !!
            // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
            // !!
            // On vérifie que la catégorie est une des catégories possibles
            if (in_array($_POST["Categorie"], ["Snack", "Boisson", "Soda", "Sirop"] /*ancien $m->getCategories())*/ )) {
                // Préparation du tableau infos
                $infos = [];
                $noms = ["id_produit", "Nom", "Categorie", "Prix", "Date_ajout", "Pts_fidelite_requis", "Pts_fidelite_donner", "Stock", "Nb_ventes"];
                foreach ($noms as $v) {
                  /*if (isset($_POST[$v])) {
                    $infos[$v] = $_POST[$v];
                  */
                    if (isset($_POST[$v]) && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)) {
                      $infos[$v] = $_POST[$v];
                
                    /*  même erreur
                    if (isset($_POST[$v])) {
                      // si c'est un STR
                      if (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])){
                        $infos[$v] = $_POST[$v];
                      }
                      // si c'est un entier/float
                      elseif ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0){
                        $infos[$v] = $_POST[$v];
                      } 
                      else {
                        $infos[$v] = null;
                      }
                    */
                    } else {
                      $infos[$v] = null;
                    }
                }

                //=============Ajout de l'image====================

                $msg_error = "";

                $target_dir = "Content/img/";
                $target_file = $target_dir . $_POST["Img_produit"];//basename($_FILES[$_POST["Img_produit"]]["name"]);
                $uploadOk = 1;
                $temporaire= $target_dir . basename($_FILES[$_POST["Img_produit"]]["name"]);
                $imageFileType = strtolower(pathinfo($temporaire,PATHINFO_EXTENSION));
                //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                // Check if image file is a actual image or fake image
                if(isset($_POST["submit"])) {
                  $check = getimagesize($_FILES[$_POST["Img_produit"]]["tmp_name"]);
                  if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                  } else {
                    $msg_error = $msg_error . "File is not an image.";
                    $uploadOk = 0;
                  }
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                  $msg_error = $msg_error . "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                  $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                  $this->action_error("Sorry, your file was not uploaded : " . $msg_error);
                // if everything is ok, try to upload file
                } else {
                  if (move_uploaded_file($_FILES[$_POST["Img_produit"]]["tmp_name"], $target_file . "." . $imageFileType)) {
                    //echo "The file ". e( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                  } else {
                    $this->action_error("Sorry, there was an error uploading your file :" . $msg_error);
                  }
                }
                //===============fin ajout image=================

                //Conversion str image en nom de fichier
                $infos["Img_produit"] = "produit_" . $infos["id_produit"];
                //ancienne idée
                // ex: Coca - Cola -> coca_-_cola.png
                //$infos["Img_produit"] = str_replace(" ", "_", strtolower($infos["Nom"])) . ".png";

                //Récupération du modèle
                $m = Model::getModel();
                //Ajout du produit
                $ajout = $m->addProduit($infos);


            }
        }
        

        //Préparation de $data pour l'affichage de la vue message
        $data = [
            "title" => "Création d'un nouveau produit",
            "added_element" => "produit",
            "str_lien_retour" => "Retour à la page de gestion de l'inventaire",
            "lien_retour" => "?controller=list&action=gestion_inventaire" 
        ];
        if ($ajout) {
            $data["message"] = "Le produit " . $_POST["Nom"] . " a été créé avec succès.";
        } else {
            $data["message"] = "Erreur dans la saisie des informations, le produit n'a pas été ajouté.";
        }

    $this->render("message", $data);
  }

  public function action_add_client(){
    // TODO: si quelqu'un peut s'occuper de faire les vérifications logiques des données avec isset
    // genre si c'est bien un int, c'est bien supérieur à 0 mais inférieur à truc etc
    // TODO: vérifier que password et password verify sont identiques
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================
    $ajout = false;

        //Test si les informations nécessaires sont fournies
        /* exemple de vérification
        if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
            and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
            and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
        */
        
        if (isset($_POST["id_client"]) && 
        isset($_POST["num_etudiant"]) && 
        isset($_POST["Nom"]) && 
        isset($_POST["Prenom"]) && 
        isset($_POST["Email"]) &&
        isset($_POST["Date_creation"]) && 
        isset($_POST["Pts_fidelite"]) && $_POST["Password"]==$_POST["Password_verify"]) {
            // !!
            // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
            // !!

            // Préparation du tableau infos
            $infos = [];
            $noms = ["id_client", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
            foreach ($noms as $v) {
                if (isset($_POST[$v]) && ((is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0))
                ) {
                  // && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)
                  $infos[$v] = $_POST[$v];
                  //debug
                  //echo "Ajout $v OK";
                } else {
                  $infos[$v] = null;
                  //echo "Ajout $v OK, valeur NULL";
                }
            }

            $infosAuth = [$_POST["num_etudiant"], password_hash($_POST["Password"], PASSWORD_DEFAULT)];

            /*
            $tab=[
              "id_client" => $infos["id_client"], 
              "num_etudiant" => $infos["num_etudiant"], 
              "Nom" => $infos["Nom"], 
              "Prenom" => $infos["Prenom"], 
              "Tel" => $infos["Tel"], 
              "Email" => $infos["Email"], 
              "Date_creation" => $infos["Date_creation"], 
              "Pts_fidelite" => $infos["Pts_fidelite"]
            ];
            */

            //Récupération du modèle
            $m = Model::getModel();
            //Ajout du produit
            $m->addAuth($infosAuth);
            $ajout = $m->addClient($infos);

        }

        else{
          $this->action_error("Erreur, des informations n'ont pas été saisies ou le mot de passe n'est pas correspondant.");
        }


        //Préparation de $data pour l'affichage de la vue message
        $data = [
            "title" => "Création d'un nouveau client",
            "added_element" => "client",
            "str_lien_retour" => "Retour à la page de gestion des comptes clients",
            "lien_retour" => "?controller=list&action=gestion_clients" 
        ];
        if ($ajout) {
            $data["message"] = "Le compte client " . $_POST["Prenom"] . " " . $_POST["Nom"] . " a été créé avec succès.";
        } else {
            $data["message"] = "Erreur dans la saisie des informations, le compte client n'a pas été ajouté.";
        }

    $this->render("message", $data);
  }

  public function action_add_admin(){
    // TODO: si quelqu'un peut s'occuper de faire les vérifications logiques des données avec isset
    // genre si c'est bien un int, c'est bien supérieur à 0 mais inférieur à truc etc
    // TODO: vérifier que password et password verify sont identiques
    $m = Model::getModel();

    //==================================
    //  TEST SI C'EST UN SUPER ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"]) || !$m->isInDatabaseSuperAdmin($_SESSION["id_admin"])){
      $this->action_error("Vous ne possédez pas les droits super administrateurs pour consulter cette page.");
    }
    //===================================
    $ajout = false;

        //Test si les informations nécessaires sont fournies
        /* exemple de vérification
        if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
            and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
            and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
        */

        if (isset($_POST["id_admin"]) && 
        isset($_POST["num_etudiant"]) && 
        isset($_POST["Nom"]) && 
        isset($_POST["Prenom"]) && 
        isset($_POST["Email"]) &&
        isset($_POST["Date_creation"]) && 
        isset($_POST["Pts_fidelite"]) && $_POST["Password"]==$_POST["Password_verify"]) {
            // !!
            // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
            // !!
            // On vérifie que la catégorie est une des catégories possibles

            // Préparation du tableau infos
            $infos = [];
            $noms = ["id_admin", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
            foreach ($noms as $v) {
                if (isset($_POST[$v]) && ((is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0))
                ) {
                  // && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)
                  $infos[$v] = $_POST[$v];
                  //debug
                  //echo "Ajout $v OK";
                } else {
                  $infos[$v] = null;
                  //echo "Ajout $v OK, valeur NULL";
                }
            }

            $infosAuth = [$_POST["num_etudiant"], password_hash($_POST["Password"], PASSWORD_DEFAULT)];

            //Ajout de l'admin
            $m->addAuth($infosAuth);
            $ajout = $m->addAdmin($infos);
            
            //Si coché, ajout de l'admin à la table des super admins
            if (isset($_POST["Create_superadmin"])){
              $infosSuperAdmin=[$m->getDernierIdDisponible("SuperAdmin"), $_POST["id_admin"]];
              $m->addSuperAdmin($infosSuperAdmin);
            }
            
        }

        else{
          $this->action_error("Erreur, des informations n'ont pas été saisies ou le mot de passe n'est pas correspondant.");
        }
        

        //Préparation de $data pour l'affichage de la vue message
        $data = [
            "title" => "Création d'un nouveau compte administrateur",
            "added_element" => "admin",
            "str_lien_retour" => "Retour à la page de gestion des comptes administrateurs",
            "lien_retour" => "?controller=list&action=gestion_admins" 
        ];
        if ($ajout) {
            $data["message"] = "Le compte administrateur " . $_POST["Prenom"] . " " . $_POST["Nom"] . " a été créé avec succès.";
        } else {
            $data["message"] = "Erreur dans la saisie des informations, le compte administrateur n'a pas été ajouté.";
        }

    $this->render("message", $data);
  }

  public function action_add_vente(){
    // TODO: si quelqu'un peut s'occuper de faire les vérifications logiques des données avec isset
    // genre si c'est bien un int, c'est bien supérieur à 0 mais inférieur à truc etc
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================
    $ajout = false;

        //Test si les informations nécessaires sont fournies
        /* exemple de vérification
        if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
            and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
            and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
        */
        
        if (isset($_POST["num_vente"]) &&
          isset($_POST["id_client"]) &&
          isset($_POST["id_admin"]) &&
          isset($_POST["id_produit"]) &&
          isset($_POST["Date_vente"]) && 
          isset($_POST["Paiement"]) &&
          isset($_POST["Use_fidelite"])) 
        {
          // !!
          // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
          // !!
          // On vérifie que la catégorie est une des catégories possibles

          // Préparation du tableau infos
          $infos = [];
          $noms = ["num_vente", "id_client", "id_admin", "id_produit", "Date_vente", "Paiement", "Use_fidelite"];
          foreach ($noms as $v) {
            if (isset($_POST[$v]) && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)) {
              $infos[$v] = $_POST[$v];
            } else {
              $infos[$v] = null;
            }
          }

          //Conversion use_fidelite en bool MYSQL
          if ($infos["Use_fidelite"]=="False"){
            $infos["Use_fidelite"] = 0;
          }
          else {
            $infos["Use_fidelite"] = 1;
          }
          //Ajout de la vente
          $ajout = $m->addVente($infos);

          // - décrémente stock  
          $m->updateStock($infos["id_produit"]);

          // + incrémente nb vente
          $m->updateNbVente($infos["id_produit"]);

          // + incrément pts fidélité client selon produit acheté
          $m->updatePtsFideliteClient($infos["id_client"], $infos["id_produit"]);
          
          /*
          //Ajout de la vente
          $ajout = $m->addVente($infos);
          //Décrement -1 du produit acheté
          $m->updateStock($_POST["id_produit"]);
          */          
        }
        

        //Préparation de $data pour l'affichage de la vue message
        $data = [
            "title" => "Création d'une nouvelle vente",
            "added_element" => "vente",
            "str_lien_retour" => "Retour à la page de l'historique des ventes",
            "lien_retour" => "?controller=list&action=gestion_ventes" 
        ];
        if ($ajout) {
            $data["message"] = "La vente du produit " . $m->getNomProduit($_POST["id_produit"]) . " géré par le responsable " . $m->getPrenomNomAdmin($_POST["id_admin"]) . " pour le client " . $m->getPrenomNomClient($_POST["id_client"]) . " a été répertorié avec succès.";
        } else {
            $data["message"] = "Erreur dans la saisie des informations, la vente n'a pas été ajouté.";
        }

    $this->render("message", $data);
  }

  /*
  ===========================================================
                       SUPPRESSION D'ELEMENT
  ===========================================================
  */

  // !!! DISTINGUER REMOVE PRODUIT, REMOVE CLIENT ETC? !!!
  // modifier les liens dans les view de modification pour que ça utilise bien l'action en question

  public function action_remove_produit() {
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    if(!isset($_GET['id'])){
      $this->action_error("Erreur l'identifiant du produit n'a pas été renseigné");
    }
    else{
    
      // Afficher message, êtes vous sur de vouloir supprimer le produit ? 
      // Ceci entrainera la suppression des ventes associés à ce produit 
  
    // Associer à la fonction removeProduit de model.php pour supprimer le produit 
    $m->removeProduit($_GET['id']);
    }


    $data = [
      "title" => "Supprimer un produit",
      "message" => "Le produit à été supprimé avec succès",
      "str_lien_retour" => "Retour à la page de l'inventaire",
      "lien_retour" => "?controller=list&action=gestion_inventaire" 
    ];
    $this->render("message", $data);
  }

  public function action_remove_client() {
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }

    if(!isset($_GET['id_client'])){
      $this->action_error("Erreur l'identifiant du client n'est pas valide");
    }
    else{
    
      // Afficher message, êtes vous sur de vouloir supprimer le client ? 
      // Ceci entrainera la suppression des ventes associés à ce client 
  
    // Associer à la fonction removeclient de model.php pour supprimer le client 
    $m->removeCompteClient($_GET['id']);
    }


    $data = [
      "title" => "Supprimer un client",
      "message" => "Le client à été supprimé avec succès",
      "str_lien_retour" => "Retour à la page de gestion des clients",
      "lien_retour" => "?controller=list&action=gestion_clients" 
    ];
    $this->render("message", $data);
  }

  public function action_remove_admin() {
    $m = Model::getModel();
    //==================================
    //  TEST SI C'EST UN SUPER ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"]) || !$m->isInDatabaseSuperAdmin($_SESSION["id_admin"])){
      $this->action_error("Vous ne possédez pas les droits super administrateurs pour consulter cette page.");
    }
    //===================================
  
      if(!isset($_GET['id_admin'])){
        $this->action_error("Erreur l'identifiant de l'admin n'est pas valide");
      }
      else{
      
        // Afficher message, êtes vous sur de vouloir supprimer l'admin ? 
    
      // Associer à la fonction removeAdmin de model.php pour supprimer l'admin 
      $m->removeCompteAdmin($_GET['id']);
      }
  
  
      $data = [
        "title" => "Supprimer un admin",
        "message" => "L'admin à été supprimé avec succès",
        "str_lien_retour" => "Retour à la page de gestion des comptes",
        "lien_retour" => "?controller=list&action=gestion_admins" 
      ];
      $this->render("message", $data);
    }



  

  /*
  ===========================================================
                       MODIFICATION D'ELEMENT
  ===========================================================
  */

  public function action_form_update_produit(){
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    $data = [
      "titre" => "Mis à jour d'un produit",
      "infos" => $m->getProduitPrecis($_GET["id"])
      ]; 

    $this->render("form_update_produit", $data);
  
  }

  public function action_form_update_client(){
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    $data = [
      "titre" => "Mis à jour des informations d'un client",
      "infos" => $m->getClientPrecis($_GET["id"])
      ]; 

    $this->render("form_update_client", $data);
  
  }

  public function action_form_update_admin(){
    $m = Model::getModel();
    //==================================
    //  TEST SI C'EST UN SUPER ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"]) || !$m->isInDatabaseSuperAdmin($_SESSION["id_admin"])){
      $this->action_error("Vous ne possédez pas les droits super administrateurs pour consulter cette page.");
    }
    //===================================

    $infos = $m->getAdminPrecis($_GET["id"]);
    if ($m->isInDatabaseSuperAdmin($infos["id_admin"])){
      $infos["super_admin"]=True;
    }

    $data = [
      "titre" => "Mis à jour des informations d'un administrateur",
      "infos" => $infos
      ]; 

    $this->render("form_update_admin", $data);
  
  }

  public function action_form_update_vente(){
    // on récupère le Model
    $m = Model::getModel();

    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    $infos = $m->getVentePrecis($_GET["id"]);

    $data = [
      "titre" => "Mis à jour d'une vente",
      "infos" => $infos,
      "clients" => $m->getClients(),
      "admins" => $m->getAdmins(),
      "snacks" => $m->getProduits("default","Snack","default"),
      "boissons" => $m->getProduits("default", "Boisson", "default"),
      "sodas" => $m->getProduits("default", "Soda", "default"),
      "sirops" => $m->getProduits("default", "Sirop", "default"),
      ]; 

    $this->render("form_update_vente", $data);
  }

  public function action_update_produit(){
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    $ajout = false;

    if (isset($_POST["id_produit"]) &&
      isset($_POST["Nom"]) &&
      isset($_POST["Categorie"]) &&
      isset($_POST["Prix"]) &&
      isset($_POST["Date_ajout"]) &&
      isset($_POST["Pts_fidelite_requis"]) &&
      isset($_POST["Pts_fidelite_donner"]) &&
      isset($_POST["Stock"]) &&
      isset($_POST["Nb_ventes"])) 
    {
      $produit = $m->getProduitPrecis($_POST["id_produit"]);

      // Préparation du tableau infos
      foreach($produit as $c=>$v){
        if ($c!="Img_produit" && $v!=$_POST[$c]){
          $ajout = $m->updateProduit($_POST["id_produit"], $c, $_POST[$c]);
        }
      }

      //=============Changement de l'image====================
      if (isset($_POST["Update_img"]) && $_POST["Update_img"]){

        $msg_error = "";

        $target_dir = "Content/img/";
        $target_file = $target_dir . $produit["Img_produit"];//basename($_FILES[$_POST["Img_produit"]]["name"]);
        $uploadOk = 1;
        $temporaire= $target_dir . basename($_FILES[$produit["Img_produit"]]["name"]);
        $imageFileType = strtolower(pathinfo($temporaire,PATHINFO_EXTENSION));
        //$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
          $check = getimagesize($_FILES[$produit["Img_produit"]]["tmp_name"]);
          if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
          } else {
            $msg_error = $msg_error . "File is not an image.";
            $uploadOk = 0;
          }
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
          $msg_error = $msg_error . "Sorry, only JPG, JPEG, PNG files are allowed.";
          $uploadOk = 0;
        }

        // Suppression / délien de l'ancienne image
        if(file_exists($target_file)) {
          unlink($target_file); //remove the file
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
          $this->action_error("Sorry, your file was not uploaded : " . $msg_error);
        // if everything is ok, try to upload file
        } else {
          if (move_uploaded_file($_FILES[$produit["Img_produit"]]["tmp_name"], $target_file . "." . $imageFileType)) {
            //echo "The file ". e( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
            $ajout = true;
          } else {
            $this->action_error("Sorry, there was an error uploading your file :" . $msg_error);
          }
        }
      }
      //===============fin changement image=================
    }

    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Modification du produit",
        "str_lien_retour" => "Retour à la page de l'inventaire des produits",
        "lien_retour" => "?controller=list&action=gestion_inventaire" 
    ];
    if ($ajout) {
        $data["message"] = "Le produit " . $_POST["Nom"] . " a été mis à jour avec succès.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, le produit n'a pas été modifié.";
    }

    $this->render("message", $data);
  }

  public function action_update_client(){
    $m = Model::getModel();
    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================

    $ajout = false;

    if (isset($_POST["id_client"]) && 
      isset($_POST["num_etudiant"]) && 
      isset($_POST["Nom"]) && 
      isset($_POST["Prenom"]) && 
      isset($_POST["Email"]) &&
      isset($_POST["Date_creation"]) && 
      isset($_POST["Pts_fidelite"])) 
    {
      $client = $m->getClientPrecis($_POST["id_client"]);

      // Préparation du tableau infos
      foreach($client as $c=>$v){
        if ($v!=$_POST[$c]){
          // si le num étudiant est modifié, modif dans client puis dans authentif
          if ($c=="num_etudiant"){
            // si existe déjà, pas de modif, erreur
            if ($m->verifNumEtudiant($_POST["num_etudiant"], "Admin")){
              $this->action_error("Le numéro étudiant " . $_POST["num_etudiant"] . " est déjà utilisé par un admin, veuillez en saisir un autre.");
            }
            elseif ($m->verifNumEtudiant($_POST["num_etudiant"], "Client")){
              $this->action_error("Le numéro étudiant " . $_POST["num_etudiant"] . " est déjà utilisé par un autre client, veuillez en saisir un autre.");
            }
            // si existe pas déjà, modifie dans client puis dans authentif
            else{
              $ajout = $m->updateNumEtudiant($client["num_etudiant"], $_POST["num_etudiant"], "Client");
            }
          }
          // si email existe déjà
          elseif($c=="Email"){
            if ($m->isInDatabaseAdmin($_POST["Email"])){
              $this->action_error("L'adresse mail " . $_POST["Email"] . " est déjà utilisé par un admin. Veuillez saisir une autre adresse.");
            }
            elseif ($m->isInDatabaseClient($_POST["Email"])){
              $this->action_error("L'adresse mail " . $_POST["Email"] . " est déjà utilisé par un autre client. Veuillez saisir une autre adresse.");
            }
            else{
              $ajout = $m->updateClient($_POST["id_client"], $c, $_POST[$c]);
            }
          }
          else {
            $ajout = $m->updateClient($_POST["id_client"], $c, $_POST[$c]);
          }
        }
      }

      if (isset($_POST["Password"]) && 
        isset($_POST["Password_verify"]) && 
        ! preg_match("/^ *$/", $_POST["Password"])
        )
      {
        if ($_POST["Password"]!=$_POST["Password_verify"]) {
          $this->action_error("Le mot de passe saisi ne correspond pas au mot de passe de confirmation. Néanmoins, si des informations client ont été modifiés précédemment, ces changements ont bien été pris en compte.");
        }
        else{
          $ajout = $m->updatePassword($_POST["Email"],password_hash($_POST["Password"], PASSWORD_DEFAULT),"Client");     
        }
      }
    }
    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Modification des infos client",
        "str_lien_retour" => "Retour à la page de gestion des comptes clients",
        "lien_retour" => "?controller=list&action=gestion_clients" 
    ];
    if ($ajout) {
        $data["message"] = "Les informations du client  " . $_POST["Prenom"] . " " . $_POST["Nom"] . " ont été mis à jour avec succès.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, les informations du client n'ont pas été modifié.";
    }

    $this->render("message", $data);

  }

  public function action_update_admin(){
    $m = Model::getModel();
    //==================================
    //  TEST SI C'EST UN SUPER ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"]) || !$m->isInDatabaseSuperAdmin($_SESSION["id_admin"])){
      $this->action_error("Vous ne possédez pas les droits super administrateurs pour consulter cette page.");
    }
    //===================================

    $ajout = false;

    if (isset($_POST["id_admin"]) && 
      isset($_POST["num_etudiant"]) && 
      isset($_POST["Nom"]) && 
      isset($_POST["Prenom"]) && 
      isset($_POST["Email"]) &&
      isset($_POST["Date_creation"]) && 
      isset($_POST["Pts_fidelite"])) 
    {
      $admin = $m->getAdminPrecis($_POST["id_admin"]);

      // Préparation du tableau infos
      foreach($admin as $c=>$v){
        if ($v!=$_POST[$c]){
          if ($c=="num_etudiant"){
            // si existe déjà, pas de modif, erreur
            if ($m->verifNumEtudiant($_POST["num_etudiant"], "Admin")){
              $this->action_error("Le numéro étudiant " . $_POST["num_etudiant"] . " est déjà utilisé par un autre admin, veuillez en saisir un autre.");
            }
            elseif ($m->verifNumEtudiant($_POST["num_etudiant"], "Client")){
              $this->action_error("Le numéro étudiant " . $_POST["num_etudiant"] . " est déjà utilisé par un client, veuillez en saisir un autre.");
            }
            // si existe pas déjà, modifie dans admin puis dans authentif
            else{
              $ajout = $m->updateNumEtudiant($admin["num_etudiant"], $_POST["num_etudiant"], "Admin");
            }
          }
          // si email existe déjà
          elseif($c=="Email"){
            if ($m->isInDatabaseAdmin($_POST["Email"])){
              $this->action_error("L'adresse mail " . $_POST["Email"] . " est déjà utilisé par un autre admin. Veuillez saisir une autre adresse.");
            }
            elseif ($m->isInDatabaseClient($_POST["Email"])){
              $this->action_error("L'adresse mail " . $_POST["Email"] . " est déjà utilisé par un client. Veuillez saisir une autre adresse.");
            }
            else{
              $ajout = $m->updateAdmin($_POST["id_admin"], $c, $_POST[$c]);
            }
          }
          else {
            $ajout = $m->updateAdmin($_POST["id_admin"], $c, $_POST[$c]);
          }
        }
      }

      if (isset($_POST["Password"]) && 
        isset($_POST["Password_verify"]) && 
        ! preg_match("/^ *$/", $_POST["Password"])){
        if ($_POST["Password"]!=$_POST["Password_verify"]) {
          $this->action_error("Le mot de passe saisi ne correspond pas au mot de passe de confirmation. Néanmoins, si des informations admin ont été modifiés précédemment, ces changements ont bien été pris en compte.");
        }
        else{
          $ajout = $m->updatePassword($_POST["Email"],password_hash($_POST["Password"], PASSWORD_DEFAULT),"Admin");     
        }
      }

      //TODO: Traitement si on veut créer un superadmin ou supprimer un superadmin jsp
    }

    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Modification des infos admin",
        "str_lien_retour" => "Retour à la page de gestion des comptes admins",
        "lien_retour" => "?controller=list&action=gestion_admins" 
    ];
    if ($ajout) {
        $data["message"] = "Les informations de l'admin  " . $_POST["Prenom"] . " " . $_POST["Nom"] . " ont été mis à jour avec succès.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, les informations du admin n'ont pas été modifié.";
    }

    $this->render("message", $data);
  }

  public function action_update_infos_client(){
    $m = Model::getModel();

    $ajout = false;

    if ( 
      isset($_POST["num_etudiant"]) && 
      isset($_POST["Nom"]) && 
      isset($_POST["Prenom"]) && 
      isset($_POST["Email"])
      ) 
    {
      $client = $m->getClientPrecis($_SESSION["id_client"]);
      /*
      $client = [
        "num_etudiant"=>$client["num_etudiant"],
        "Nom"=>$client["Nom"],
        "Prenom"=>$client["Prenom"],
        "Email"=>$client["Email"],
        "Tel"=>$client["Tel"]
      ];
      */

      // Préparation du tableau infos
      foreach($client as $c=>$v){
        if (($c!="id_client" && $c!="Pts_fidelite" && $c!="Date_creation") && $v!=$_POST[$c] ){
          // si le num étudiant est modifié, modif dans client puis dans authentif
          if ($c=="num_etudiant"){
            // si existe déjà, pas de modif, erreur
            if ($m->verifNumEtudiant($_POST["num_etudiant"], "Admin") || $m->verifNumEtudiant($_POST["num_etudiant"], "Client")){
              $this->action_error("Le numéro étudiant " . $_POST["num_etudiant"] . " est déjà utilisé par un autre utilisateur, veuillez en saisir un autre.");
            }
            // si existe pas déjà, modifie dans client puis dans authentif
            else{
              $ajout = $m->updateNumEtudiant($client["num_etudiant"], $_POST["num_etudiant"], "Client");
            }
          }
          // si email existe déjà
          elseif($c=="Email"){
            if ($m->isInDatabaseAdmin($_POST["Email"]) || $m->isInDatabaseClient($_POST["Email"])){
              $this->action_error("L'adresse mail " . $_POST["Email"] . " est déjà utilisé par un autre utilisateur. Veuillez saisir une autre adresse.");
            }
            else{
              $ajout = $m->updateClient($_POST["id_client"], $c, $_POST[$c]);
            }
          }
          else {
            $ajout = $m->updateClient($_SESSION["id_client"], $c, $_POST[$c]);
          }
        }
      }
    }

    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Modification des infos client",
        "str_lien_retour" => "Retour à votre espace client",
        "lien_retour" => "?controller=list&action=espace_client" 
    ];
    if ($ajout) {
        $data["message"] = "Vos informations ont été mises à jour avec succès.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, les informations n'ont pas été modifié.";
    }

    $this->render("message", $data);
  }

  public function action_update_infos_admin(){
    $m = Model::getModel();

    $ajout = false;

    if ( 
      isset($_POST["num_etudiant"]) && 
      isset($_POST["Nom"]) && 
      isset($_POST["Prenom"]) && 
      isset($_POST["Email"])
      ) 
    {
      $admin = $m->getAdminPrecis($_SESSION["id_admin"]);
      /*
      $admin = [
        "num_etudiant"=>$admin["num_etudiant"],
        "Nom"=>$admin["Nom"],
        "Prenom"=>$admin["Prenom"],
        "Email"=>$admin["Email"],
        "Tel"=>$admin["Tel"]
      ];
      */

      // Préparation du tableau infos
      foreach($admin as $c=>$v){
        if (($c!="id_admin" && $c!="Pts_fidelite" && $c!="Date_creation") && $v!=$_POST[$c]){
          // si le num étudiant est modifié, modif dans admin puis dans authentif
          if ($c=="num_etudiant"){
            // si existe déjà, pas de modif, erreur
            if ($m->verifNumEtudiant($_POST["num_etudiant"], "Admin") || $m->verifNumEtudiant($_POST["num_etudiant"], "Admin")){
              $this->action_error("Le numéro étudiant " . $_POST["num_etudiant"] . " est déjà utilisé par un autre utilisateur, veuillez en saisir un autre.");
            }
            // si existe pas déjà, modifie dans admin puis dans authentif
            else{
              $ajout = $m->updateNumEtudiant($admin["num_etudiant"], $_POST["num_etudiant"], "Admin");
            }
          }
          // si email existe déjà
          elseif($c=="Email"){
            if ($m->isInDatabaseAdmin($_POST["Email"]) || $m->isInDatabaseAdmin($_POST["Email"])){
              $this->action_error("L'adresse mail " . $_POST["Email"] . " est déjà utilisé par un autre utilisateur. Veuillez saisir une autre adresse.");
            }
            else{
              $ajout = $m->updateAdmin($_SESSION["id_admin"], $c, $_POST[$c]);
            }
          }
          else {
            $ajout = $m->updateAdmin($_SESSION["id_admin"], $c, $_POST[$c]);
          }
        }
      }
    }

    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Modification des infos admins",
        "str_lien_retour" => "Retour à votre espace administrateur",
        "lien_retour" => "?controller=list&action=espace_admin" 
    ];
    if ($ajout) {
        $data["message"] = "Vos informations ont été mises à jour avec succès.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, les informations n'ont pas été modifié.";
    }

    $this->render("message", $data);
  }

  /*
  ===========================================================
            TRAITEMENT PANIER CAISSE ENREGISTREUSE
  ===========================================================
  */

  public function action_traitement_caisse(){
    $m = Model::getModel();

    //==================================
    //     TEST SI C'EST UN ADMIN
    //==================================
    if (!isset($_SESSION['connected']) || !isset($_SESSION['statut']) || !isset($_SESSION['id_admin']) || !$_SESSION['connected'] || $_SESSION['statut']!='admin' || !$m->isInDatabaseAdmin($_SESSION["email"])){
      $this->action_error("Vous ne possédez pas les droits administrateurs pour consulter cette page.");
    }
    //===================================
    
    // TODO: TRAITEMENT SPECIAL SI POINtS DE FIDELITE A FAIRE PLUS TARD
    /*
    if ($m->getPointsFidelite($m->getIdClientFromNumEtud($_POST["num_etudiant_client"]),"Client") > 0){
      // envoyer sur une page proposition points fidélité
      // Préparation du tableau infos
      $infos = [];
      $noms = ["num_vente", "id_client", "id_admin", "id_produit", "Date_vente", "Paiement", "Use_fidelite"];
      foreach ($noms as $v) {
        if (isset($_POST[$v]) && (is_string($_POST[$v]) && ! preg_match("/^ *$/", $_POST[$v])) || ((is_int($_POST[$v]) || is_float($_POST[$v])) && $_POST[$v]>=0)) {
          $infos[$v] = $_POST[$v];
        } else {
          $infos[$v] = null;
        }
      }
    }
    */

    $ajout = false;

    $id_client = $m->getIdClientFromNumEtud($_POST["num_etudiant_client"]);

    if (!$id_client || $id_client == null){
      $this->action_error("Le numéro étudiant fourni n'a pas permis à identifier le client.");
    }
    elseif (!isset($_POST["id_admin"])){
      $this->action_error("L'identifiant de l'administrateur gérant cette vente n'a pas été détecté.");
    }
    elseif (!isset($_POST["Paiement"])){
      $this->action_error("Le moyen de paiement n'a pas été spécifié.");
    }


    $infos = [
      "num_vente" => $m->getDernierIdDisponible("Vente"),
      "id_client" => $id_client,
      "id_admin" => $_POST["id_admin"],
      "id_produit" => "",
      "Date_vente" => date("Y-m-d"),
      "Paiement" => $_POST["Paiement"],
      "Use_fidelite" => 0
    ];

    $produits_traite = [];

    foreach($_POST as $c=>$v){
      if (str_contains($c,"produit")){
        $ajout=false;

        $infos["id_produit"] = $v;

        // vente va être ajouté
        $ajout = $m->addVente($infos);

        // vérif si ça a marché sinon erreur
        if (!$ajout){
          $this->action_error("Une erreur est survenue lors de l'ajout de la vente du produit " . $v .".");
        }

        //----vente ajouté----

        // ajout aux produits traités pour affichage à la fin
        $produits_traite[$m->getNomProduit($infos["id_produit"])] = $m->getPrixProduit($infos["id_produit"]);
        
        // - décrémente stock  
        $m->updateStock($infos["id_produit"]);

        // + incrémente nb vente
        $m->updateNbVente($infos["id_produit"]);

        // + incrément pts fidélité client selon produit acheté
        $m->updatePtsFideliteClient($infos["id_client"], $infos["id_produit"]);

        // + incrément numéro de vente
        $infos["num_vente"] = $m->getDernierIdDisponible("Vente");
      }
    }

    //Préparation de $data pour l'affichage de la vue message
    $data = [
        "title" => "Validation d'une vente",
        "added_element" => "vente",
        "str_lien_retour" => "Retour à la caisse enregistreuse",
        "lien_retour" => "?controller=list&action=caisse",
        "produits_traite" => $produits_traite
    ];
    if ($ajout) {
        $data["message"] = "La vente des produits ci-dessous géré par le responsable " . $m->getPrenomNomAdmin($_POST["id_admin"]) . " pour le client " . $m->getPrenomNomClient($_POST["id_client"]) . " a été comptabilisé avec succès.";
    } else {
        $data["message"] = "Erreur dans la saisie des informations, la vente n'a pas été ajouté.";
    }

    $this->render("message", $data);
  }

  public function action_default(){
    $this->action_error("Erreur dans le contrôleur set, action par défaut utilisé.");
  }

  

}

?>
