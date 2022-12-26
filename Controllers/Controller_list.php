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
        "boissons" => $m->getProduits($filter, "boisson", "default"),
        "sodas" => $m->getProduits($filter, "soda", "default"),
        "sirops" => $m->getProduits($filter, "sirop", "default")
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

  public function action_default(){
    $this->action_produits();
  }

}
?>
