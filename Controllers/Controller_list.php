<?php

class Controller_list extends Controller{

  public function action_produits() {
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();
    $data =
      [
        "produits" => $m->getProduits($filter)
      ];

    $this->render("produits", $data);
  }

  public function action_confiseries() {
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();
    $data =
      [
        "produits" => $m->getProduits($filter, "food", "default")
      ];

    $this->render("produits_confiseries", $data);
  }

  public function action_boissons() {
    //--------------------------------------------------------
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $data =
      [
        "boissons" => $m->getProduits($filter, "Boisson", "default"),
        "sodas" => $m->getProduits($filter, "Soda", "default"),
        "sirops" => $m->getProduits($filter, "Sirop", "default")
      ];

    $this->render("produits_boissons", $data);
    /* ============================ANCIEN CODE======================
    non utilisé car changement de disposition html, emploi de javascript 
    (plus pratique, voir dans vue view_produits_boissons.php pour plus de détail)
    ================================================================
    // type de boissons recherchés
    // on définit par défaut type = drink pour toutes les boissons
    $type = "drink";

    //--------------------------------------------------------
    // si on veut que les sodas, on se basera sur les paramètres de l'url
    if (isset($_GET["type"])) {
      // étant donné que les catégories dans la bd ont une majuscule au début
      $type = ucfirst(e($_GET["type"]));
    }
    //--------------------------------------------------------
    // filtrage par ordre croissant/decroissant prix
    // valeurs possible : croissant ou decroissant
    $filter = "default";

    if (isset($_GET["filter"])) {
      $filter = e($_GET["filter"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $data =
      [
        "produits" => $m->getProduits($filter, $type, "default")
      ];

    $this->render("produits_boissons", $data);
    */
  }

  public function action_gestion_clients(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un admin
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $colonnes = $m->getClients();
    $colonnes = array_keys($colonnes[0]);
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Gestion des comptes clients",
        "listed_elements" => "gestion_clients",
        "id_element" => "id_client",
        "redirect_add_element" => "client",
        "str_add_element" => "un compte client",
        "colonnes" => $colonnes,
        "liste" => $m->getClients($search)
      ];

    $this->render("list", $data);
  }

  public function action_gestion_admins(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un super-admin
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $colonnes = $m->getAdmins();
    $colonnes = array_keys($colonnes[0]);
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Gestion des comptes administrateurs",
        "listed_elements" => "gestion_admins",
        "id_element" => "id_admin",
        "redirect_add_element" => "admin",
        "str_add_element" => "un compte administrateur",
        "colonnes" => $colonnes,
        "liste" => $m->getAdmins($search)
      ];

    $this->render("list", $data);
  }

  public function action_gestion_ventes(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un super-admin
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    $liste = $m->getHistoriqueAchats($search);

    // tentative pour remplacer les id par des prénom et noms pour que ça soit + concret
    // ne marche pas
    // solution: créer un nouveau tableau séparé qui copierait les valeurs ?
    /*
    foreach ($liste as $ligne){
      $ligne["id_client"] = $m->getPrenomNomClient($ligne["id_client"]);
      $ligne["id_admin"] = $m->getPrenomNomAdmin($ligne["id_admin"]);
    }
    */
    // à essayer :
    $liste_nouv = [];
    $i=0;
    foreach ($liste as $ligne){
      $use_fidelite = "Non";
      if ($ligne["Use_fidelite"]){
        $use_fidelite = "Oui";
      }
      $liste_nouv[$i] = 
        [
          "num_vente" => $ligne["num_vente"], 
          "id_client" => $m->getPrenomNomClient($ligne["id_client"]),
          "id_admin" => $m->getPrenomNomAdmin($ligne["id_admin"]),
          "id_produit" => $ligne["id_produit"],
          "Nom_produit" => $m->getNomProduit($ligne["id_produit"]),
          "Prix" => $m->getPrixProduit($ligne["id_produit"]),
          "Date_vente" => $ligne["Date_vente"],
          "Paiement" => $ligne["Paiement"],
          "Use_fidelite" => $use_fidelite
        ];
      $i+=1;
    }

    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Historique des ventes du stand",
        "listed_elements" => "gestion_ventes",
        "id_element" => "num_vente",
        "redirect_add_element" => "vente",
        "str_add_element" => "une vente",
        "colonnes" => ["Numéro de vente", "Client acheteur", "Responsable de la vente", "ID produit", "Produit acheté", "Prix", "Date de la vente", "Méthode de paiement", "A utilisé points de fidélité"],
        "liste" => $liste_nouv
      ];

    $this->render("list", $data);
  }

  public function action_gestion_inventaire(){
    // TODO: Pour Cléante --> implémenter sécurité, vérification variable session, si connecté et si c'est bien un super-admin
    // TODO: pour Alex H., changer l'ordre des attributs pour qu'on ait les images des produits d'abord? ici ou dans view_list
    $search = "default";
    //$attribut = "default";

    if (isset($_GET["search"])) {
      $search = e($_GET["search"]); // risque: si search est un int (on sait jamais), fonction e aka htmlspecialchars problématique?
      // $attribut = e($_GET["attribut"]);
    }
    //--------------------------------------------------------
    $m = Model::getModel();

    /*
    $colonnes = $m->getProduits();
    $colonnes = array_keys($colonnes[0]);
    */
    // titre sera destiné au titre en grand en haut de tableau/liste

    // listed_elements sert à adapter les liens de view_list.php 
    // au traitement par controller-action associé à ce dernier

    $data =
      [
        "titre" => "Inventaire des produits du stand",
        "listed_elements" => "gestion_inventaire",
        "id_element" => "id_produit",
        "redirect_add_element" => "produit",
        "str_add_element" => "un produit",
        "colonnes" => ["Identifiant", "Date d'ajout", "Image", "Nom du produit", "Catégorie", "Prix", "Nb pts fidélité requis", "Nb pts fidélité donné", "En stock", "Vendus"],
        "liste" => $m->getProduits("default","default",$search)
      ];

    $this->render("list", $data);
  }
  
  public function action_default(){
    $this->action_produits();
  }

}
?>
