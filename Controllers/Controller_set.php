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
  //
  // A FINIR
  //
  public function action_form_add_vente(){
    // on récupère le Model
    $m = Model::getModel();

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
    // TODO: voir comment on ajoute un fichier
    $ajout = false;

        //Test si les informations nécessaires sont fournies
        /* exemple de vérification
        if (isset($_POST["name"]) and ! preg_match("/^ *$/", $_POST["name"])
            and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
            and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
        */
        
        if (isset($_POST["Nom"])) {
            // !!
            // RAJOUTER DES TESTS / CONTROLE DE SAISIE DANS LE IF !!!
            // !!
            // On vérifie que la catégorie est une des catégories possibles
            $m = Model::getModel();
            if (in_array($_POST["Categorie"], $m->getCategories())) {
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

                //Conversion str image en nom de fichier
                // ex: Coca - Cola -> coca_-_cola.png
                $infos["Img_produit"] = str_replace(" ", "_", strtolower($infos["Nom"])) . ".png";

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
            // On vérifie que la catégorie est une des catégories possibles
            $m = Model::getModel();
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
            $m = Model::getModel();
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

            //Récupération du modèle
            $m = Model::getModel();

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
    // TODO: voir comment on ajoute un fichier
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
          $m = Model::getModel();

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
          
              
          //Récupération du modèle
          $m = Model::getModel();
          //Ajout de la vente
          $ajout = $m->addVente($infos);
          //Décrement -1 du produit acheté
          $m->updateStock($_POST["id_produit"]);          
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
  public function action_remove() {
    $m = Model::getModel();

    $data = [
      "title" => "Removing a Nobel Prize.",
      "message" => $message
    ];
    $this->render("message", $data);
  }

  public function action_form_update(){
    $in_database = false;
    if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"])) {
      $m = Model::getModel();
      $in_database = $m->isInDataBase($_GET["id"]);
    }

    if ($in_database) {
      // Récupération des informations du prix nobels
      $informations = $m->getNobelPrizeInformations($_GET["id"]);

      //Préparation de $data
      $data = [];
      foreach ($informations as $c => $v) {
        if ($v === null) {
          $data[$c] = "";
        } else {
          $data[$c] = $v;
        }
      }
      $data["categories"] = $m->getCategories();
      $this->render("form_update", $data);
    } else {
      $this->action_error("There is no Nobel Prize with such ID, it cannot be updated.");
    }
  }

  /*
  ===========================================================
                       MODIFICATION D'ELEMENT
  ===========================================================
  */
  public function action_update(){

    $in_database = false;

    if (isset($_POST["id"]) and preg_match("/^[1-9]\d*$/",$_POST["id"])
      and isset($_POST["name"]) and ! preg_match ("/^ *$/", $_POST["name"])
      and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
      and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
      $m = Model::getModel();
      $c_in_database = in_array($_POST["category"], $m->getCategories());
      $in_database = $c_in_database ? $m->isInDatabase($_POST["id"]) : false;
    }
    if ($in_database) {
      // Préparation $infos pour la mise à jour des informations du prix nobels
      $infos = [];
      $noms =  ["id", "year", "category", "name", "birthdate", "birthplace", "county", "motivation"];
      foreach ($noms as $v) {
        if (isset($_POST[$v]) and ! preg_match("/^ *$/", $_POST[$v])) {
          $infos[$v] = $_POST[$v];
        } else {
          $infos[$v] = null;
        }
      }
      $m->updateNobelPrize($infos);
      $message = "The informations of the Nobel Prize have been updated.";
    } else {
      $message = "There is no information to update.";
    }
    $data = [
      "title" => "Updating the Nobel Prize informations",
      "message" => $message
    ];
    $this->render("message", $data);
}

  public function action_default(){
    $this->action_form_add();
  }

}
?>
