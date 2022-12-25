<?php

class Controller_set extends Controller{

  public function action_form_add(){
    // on récupère le Model
    $m = Model::getModel();
    $data = ["categories" => $m->getCategories() ]; // np pour nobelprize

    $this->render("form_add", $data);
  }

  public function action_add(){

    $ajout = false;

    if (isset($_POST["name"]) and ! preg_match ("/^ *$/", $_POST["name"])
      and isset($_POST["category"]) and ! preg_match("/^ *$/", $_POST["category"])
      and isset($_POST["year"]) and preg_match("/^[12]\d{3}$/", $_POST["year"])) {
      // On vérifie que la catégorie est une des catégories possibles
      $m = Model::getModel();
      if (in_array($_POST["category"], $m->getCategories())){
        //prép tableau $infos
        $infos = [];
        $noms = ["year", "category", "name", "birthdate", "birthplace", "county", "motivation"];
        foreach ($noms as $v) {
          if (isset($_POST[$v]) and ! preg_match("/^ *$/", $_POST[$v]) ) {
            $infos[$v] = $_POST[$v];
          } else {
            $infos[$v] = null;
          }
        }
        // récup du modèle
        $m = Model::getModel();
        //Ajout du prix nobel dans la base
        $ajout = $m->addNobelPrize($infos);
      }
    }
    // prép $data et affichage vue message
    $data = ["title" => "Adding a Nobel Prize"];
    if ($ajout) {
      $data["message"] = "The Nobel Prize has been added in the database.";
    } else {
      $data["message"] = "There was a problem! The Nobel Prize could not be added to the list";
    }
    $this->render("message", $data);

    /* // ce que j'ai fais mais pas correct
    if(isset($_POST["name"]) and preg_match("/^[a-z]+$/", $_GET["name"]) and
      isset($_POST["category"]) and preg_match("/^[a-z]+$/", $_GET["category"]) and
      isset($_POST["year"]) and preg_match("/^[0-9]+$/", $_GET["year"])) {
      $m = Model::getModel();
      $data = $m->addNobelPrize([$_POST["name"],$_POST[""]]);
    }
    */
  }
  public function action_remove() {
    if (isset($_GET["id"]) and preg_match("/^[1-9]\d*$/", $_GET["id"])) {
      $id = $_GET["id"];

      $m = Model::getModel();
      $supression = $m->removeNobelPrize($id);
      if ($supression) {
        $message = "The Nobel Prize has been removed.";
      } else {
        $message = "There is no Nobel Prize with id " . $id . "!";
      }
    } else {
      $message = "There is no id in the URL!";
    }

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
