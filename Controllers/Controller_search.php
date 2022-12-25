<?php

class Controller_search extends Controller{

  public function action_form(){
    // pas terminé
    if (isset($_GET[$filters])){
      $m = Model::getModel();
      $data = ["categories" => $m->findNobelPrizes($filters) ];
    }



    $this->render("search",$data);
  }

  public function action_pagination(){

  }

  public function action_default(){
    $this->action_form();
  }

}
