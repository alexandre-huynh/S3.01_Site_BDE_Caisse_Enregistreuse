<?php

class Controller_home extends Controller{

  public function action_home(){
    $m = Model::getModel();

    $tab_nouv_prod = $m->getProduitsNouveau(5);
    $tab_popular_prod = $m->getProduitsPopulaire(5);

    /* test conversion bytea en bytea unescaped image */
    foreach ($tab_nouv_prod as $c => $v) {
      // format bytea pour l'instant
      $v['img_produit'] = pg_unescape_bytea(strval($v['img_produit']));
    }

    foreach ($tab_popular_prod as $c => $v) {
      // format bytea pour l'instant
      $v['img_produit'] = pg_unescape_bytea(strval($v['img_produit']));
    }

    //------------------------------------
    /*
    $data =
      [
        "nouv_prod" => $m->getProduitsNouveau(5),
        "popular_prod" => $m->getProduitsPopulaire(5)
      ];
    */
    $data =
      [
        "nouv_prod" => $tab_nouv_prod,
        "popular_prod" => $tab_popular_prod
      ];

    $this->render("home", $data); // on affiche la page home avec la donnèe qu'on cherche/veut afficher
  }

  public function action_default(){
    $this->action_home();
  }

}
?>
