<?php

class Model
{
    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;

    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;

    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {
        include "Utils/credentials.php"; // ou credentials.php
        //include "../../Utils/credentials.php"; marche pas
        $this->bd = new PDO($dsn, $login, $mdp);
        $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->bd->query("SET nameS 'utf8'");
    }

    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    //===========================================================================================
    // TODO faire les autres filters
    // peut être pas de barre de recherche donc pas de $name??
    public function getProduits($filter = "default", $type = "default", $search = "default")
    {
      $use_marqueur = False;
      // Requête de base auquelle on ajoutera des conditions order by ou filtre
      //$texte_req = "SELECT * FROM Produit";
      $texte_req = "SELECT id_produit, Nom, Categorie, ROUND(Prix,2) AS 'Prix' , Img_produit, DATE_FORMAT(Date_ajout, '%e/%c/%Y') AS 'Date_ajout', Pts_fidelite_requis, Pts_fidelite_donner, Stock, Nb_ventes FROM Produit";

      // ------------------
      // $type
      // ------------------
      // default = tout
      // food = que confiseries/snacks
      // drink = que boissons : boisson, sirop, soda
      // autre = par exemple soda, affichage seuelement des sodas
      // lien sur les boutons de filtre va faire controller ... action .. et se baser sur le $_GET

      // food = que confiseries/snacks
      if ($type=="food"){
        $texte_req = $texte_req . " WHERE Categorie = 'Confiserie'";
        /* si on décide d'implémenter des boutons de tri ET une barre de recherche dans la page de l'inventaire
        if ($search!="default"){
          $search = "%" . $search . "%";
          $texte_req = $texte_req . " AND id_produit LIKE :search OR Nom LIKE :search ";
          $use_marqueur = True;
        }
        */
      }

      // drink = que boissons : boisson, sirop, soda
      elseif ($type=="drink"){
        $texte_req = $texte_req . " WHERE Categorie = 'Boisson' OR Categorie = 'Sirop' OR Categorie = 'Soda'";
        /* si on décide d'implémenter des boutons de tri ET une barre de recherche dans la page de l'inventaire
        if ($search!="default"){
          $search = "%" . $search . "%";
          $texte_req = $texte_req . " AND id_produit LIKE :search OR Nom LIKE :search ";
          $use_marqueur = True;
        }
        */
      }

      // autre = par exemple soda, affichage seuelement des sodas
      // problème éventuel : casse
      // solution : adapter les boutons de filtrage

      elseif ($type!="default"){
        $texte_req = $texte_req . " WHERE Categorie = :type";
        /* si on décide d'implémenter des boutons de tri ET une barre de recherche dans la page de l'inventaire
        if ($search!="default"){
          $search = "%" . $search . "%";
          $texte_req = $texte_req . " AND id_produit LIKE :search OR Nom LIKE :search ";
          $use_marqueur = True;
        }
        */
      }

      // ------------------
      // $search
      // -----------------
      // destiné à l'affichage de l'inventaire, quand on utilise la barre de recherche
      if ($type=="default" && $search!="default"){
        $search = "%" . $search . "%";
        $texte_req = $texte_req . " WHERE id_produit LIKE :search OR Nom LIKE :search OR Categorie LIKE :search ";
        $use_marqueur = True;
      }

      // ------------------
      // $filter
      // -----------------
      if ($filter=="croissant"){
        $texte_req = $texte_req . " ORDER BY prix";
      }
      elseif ($filter=="decroissant"){
        $texte_req = $texte_req . " ORDER BY prix DESC";
      }

      $req = $this->bd->prepare($texte_req);
      $req->bindValue(':type', $type);
      if ($use_marqueur==True){
        $req->bindValue(':search', $search);
      }
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduitsNouveau($limit)
    {
      $req = $this->bd->prepare("SELECT id_produit, Nom, ROUND(Prix,2) AS 'Prix' , Img_produit FROM Produit ORDER BY date_ajout DESC LIMIT :limit");
      $req->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
      $req->execute();
      $reponse = [];
      while ($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
          $reponse[] = $ligne;
      }
      return $reponse;
    }

    public function getProduitsPopulaire($limit)
    {
      $req = $this->bd->prepare("SELECT id_produit, Nom, ROUND(Prix,2) AS 'Prix' , Img_produit FROM Produit ORDER BY nb_ventes DESC LIMIT :limit");
      $req->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
      $req->execute();
      $reponse = [];
      while ($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
          $reponse[] = $ligne;
      }
      return $reponse;
    }

    public function getNomProduit($id)
    {
      $req = $this->bd->prepare('SELECT Nom FROM Produit WHERE id_produit = :id ');
      $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getPrixProduit($id_prod)
    {
      $req = $this->bd->prepare('SELECT ROUND(Prix,2) FROM Produit WHERE id_produit = :id_prod');
      $req->bindValue(':id_prod', (int) $id_prod, PDO::PARAM_INT);
      $req->execute();
      return $req->fetch(PDO::FETCH_NUM)[0];
    }

    public function getClients($search="default")
    {
      // $search si on veut chercher un client en particulier
      $search = "%" . $search . "%";

      //$texte_req = 'SELECT * FROM Client';
      $texte_req = "SELECT id_client, num_etudiant, Nom, Prenom, Tel, Email, DATE_FORMAT(Date_creation, '%e/%c/%Y') AS 'Date_creation', Pts_fidelite FROM Client";

      if ($search!="%default%") {
        $texte_req = $texte_req . " WHERE 
          num_etudiant LIKE :search OR 
          Nom LIKE :search OR 
          Prenom LIKE :search OR 
          Tel LIKE :search OR 
          Email LIKE :search "; 
      }

      $req = $this->bd->prepare($texte_req);
      $req->bindValue(':search', $search);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
      /*Ancien code

      if ($search!="default" && $attribut!="default"){
        if ($attribut=="num_etudiant") {
          $texte_req = $texte_req . " WHERE num_etudiant = :search";
        }
        elseif ($attribut=="Nom") {
          $texte_req = $texte_req . " WHERE Nom = :search";
        }
        elseif ($attribut=="Prenom") {
          $texte_req = $texte_req . " WHERE Prenom = :search";
        }
        elseif ($attribut=="Tel") {
          $texte_req = $texte_req . " WHERE Tel = :search";
        }
        elseif ($attribut=="Email") {
          $texte_req = $texte_req . " WHERE Email = :search";
        }
        //$texte_req = $texte_req . " WHERE :attribut = :search";
      }

      $req = $this->bd->prepare($texte_req);
      /*
      normalement, utilisation de marqueur de place mais 
      difficilement utilisable à cause des du signe " devant et derrière l'attribut
      idéal aurait été d'insérer directement la variable mais faille SQLi dans ce cas
      $req->bindValue(':attribut', $attribut);
      * /
      $req->bindValue(':search', $search);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
      */
    }

    public function getAdmins($search="default")
    {
      // $search si on veut chercher un admin en particulier
      $search = "%" . $search . "%";

      //$texte_req = 'SELECT * FROM Admin';
      $texte_req = "SELECT id_admin, num_etudiant, Nom, Prenom, Tel, Email, DATE_FORMAT(Date_creation, '%e/%c/%Y') AS 'Date_creation', Pts_fidelite FROM Admin";

      if ($search!="%default%") {
        $texte_req = $texte_req . " WHERE 
          num_etudiant LIKE :search OR 
          Nom LIKE :search OR 
          Prenom LIKE :search OR 
          Tel LIKE :search OR 
          Email LIKE :search "; 
      }

      $req = $this->bd->prepare($texte_req);
      $req->bindValue(':search', $search);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    //==================================================

    public function getHistoriqueAchats($search="default") // ou getVentes
    {
      // $search si on veut chercher une vente en particulier
      $search = "%" . $search . "%";

      //$texte_req = 'SELECT * FROM Vente';

      //peut être:
      $texte_req = "SELECT num_vente, Vente.id_client, Vente.id_admin, Vente.id_produit, DATE_FORMAT(Date_vente, '%e/%c/%Y') AS 'Date_vente', Paiement, Use_fidelite ,Client.Nom, Client.Prenom, Admin.Nom, Admin.Prenom 
                      FROM Client JOIN Vente USING(id_client) 
                                  JOIN Admin USING(id_admin) ORDER BY Date_vente DESC";
      // TODO : rajouter quelque chose pour traiter les recherches par nom prénom 
      // sachant que la table ventes ne possède pas ces attributs
      // solution: jointure?
      if ($search!="%default%") {
        $texte_req = $texte_req . " WHERE 
          num_vente LIKE :search OR 
          Nom_produit LIKE :search OR 
          Date_vente LIKE :search OR 
          Paiement LIKE :search OR
          Client.Nom LIKE :search OR
          Client.Prenom LIKE :search OR
          Admin.Nom LIKE :search OR
          Admin.Prenom LIKE :search ";//OR  enlever OR si à la fin
      }

      $req = $this->bd->prepare($texte_req);
      $req->bindValue(':search', $search);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistoriqueAchatsClient($id,$date="default")
    {
      $texte_req=
        'SELECT distinct id_client, date_vente, Produit.nom, count(*) as "Quantité" , sum(prix) as "Total prix"
        FROM Client join Vente using(id_client) join Produit using(id_produit)
        WHERE id_client=:id
        GROUP BY id_client, date_vente, Produit.nom
        ORDER BY date_vente DESC
        ';

      // si on cherche les achats d'une date en particulier
      if ($date!="default"){
        $texte_req=
        'SELECT distinct id_client, date_vente, Produit.nom, count(*) as "Quantité" , sum(prix) as "Total prix"
        FROM Client join Vente using(id_client) join Produit using(id_produit)
        WHERE id_client=:id AND date_vente=:date
        GROUP BY id_client, date_vente, Produit.nom
        ORDER BY date_vente DESC
        ';
        $use_marqueur=True;
      }

      $req = $this->bd->prepare($texte_req);
      $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
      if ($use_marqueur==True){
        $req->bindValue(':date', $date);
      }
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDatesVentesClient($id)
    {
      $req = $this->bd->prepare('SELECT DISTINCT date_vente FROM Vente WHERE id_client = :id ORDER BY date_vente DESC');
      $req->bindValue(':id', $id);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    //==================================================
    // donne l'id client à partir de l'email fourni
    public function getIdClientFromEmail($email){
      $req = $this->bd->prepare('SELECT id_client FROM Client WHERE Email = :email');
      $req->bindValue(':email', $email);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    // donne l'id admin à partir de l'email fourni
    public function getIdAdminFromEmail($email){
      $req = $this->bd->prepare('SELECT id_client FROM Admin WHERE Email = :email');
      $req->bindValue(':email', $email);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }
    //=====================================================
    public function getNumEtudiantClientFromEmail($email){
      $req = $this->bd->prepare('SELECT num_etudiant FROM Client WHERE Email = :email');
      $req->bindValue(':email', $email);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getNumEtudiantAdminFromEmail($email){
      $req = $this->bd->prepare('SELECT num_etudiant FROM Admin WHERE Email = :email');
      $req->bindValue(':email', $email);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }
    //=====================================================

    public function getPrenomNomClient($id)
    {
      $req = $this->bd->prepare('SELECT CONCAT(Prenom, " ", Nom) as Prenom_Nom FROM Client WHERE id_client = :id ');
      $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    public function getPrenomNomAdmin($id)
    {
      $req = $this->bd->prepare('SELECT CONCAT(Prenom, " ", Nom) as Prenom_Nom FROM Admin WHERE id_admin = :id ');
      $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    // retourne l'id s'il existe dans la BD, sinon retourne false
    // Idée abandonnée pour l'instant
    // TODO: Trouver un moyen de trouver un id disponible dans la table
    // afin d'éviter les trous dans la bd
    /*
    public function getIdDisponible($table,)
    {

    }
    */

    // TODO: y'aura des trous de ID non utilisé dans la bd, trouver une solution?
    // pour ajouter une ligne à la fin de la table avec un id non encore utilisé
    // problème: trous ID non utilisé dans la BD
    // solution: utiliser AUTO INCREMENT pour les attributs id : id MEDIUMINT NOT NULL AUTO_INCREMENT,
    // https://dev.mysql.com/doc/refman/8.0/en/example-auto-increment.html 
    public function getDernierIdDisponible($table)
    {
      if ($table=="Produit"){
        $req = $this->bd->prepare('SELECT MAX(id_produit)+1 as LastIDAvailable FROM Produit');
      }
      elseif ($table=="Client") {
        $req = $this->bd->prepare('SELECT MAX(id_client)+1 as LastIDAvailable FROM Client');
      }
      elseif ($table=="Admin"){
        $req = $this->bd->prepare('SELECT MAX(id_admin)+1 as LastIDAvailable FROM Admin');
      }
      elseif ($table=="Vente"){
        $req = $this->bd->prepare('SELECT MAX(num_vente)+1 as LastIDAvailable FROM Vente');
      }
      //probablement non utilisé mais au cas où
      elseif ($table=="SuperAdmin"){
        $req = $this->bd->prepare('SELECT MAX(id_superadmin)+1 as LastIDAvailable FROM SuperAdmin');
      }

      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
    }

    // Catégories de produits
    public function getCategories()
    {
        $requete = $this->bd->prepare('SELECT DISTINCT Categorie FROM Produit');
        $requete->execute();
        $reponse = [];
        while ($ligne = $requete->fetch(PDO::FETCH_ASSOC)) {
            $reponse[] = $ligne['Categorie'];
        }
        return $reponse;
    }

    public function addProduit($infos)
    {
        //Préparation de la requête
        $requete = $this->bd->prepare('INSERT INTO Produit VALUES (:id_produit, :Nom, :Categorie, :Prix, :Img_produit, :Date_ajout, :Pts_fidelite_requis, :Pts_fidelite_donner, :Stock, :Nb_ventes)');

        //Remplacement des marqueurs de place par les valeurs
        $marqueurs = ["id_produit", "Nom", "Categorie", "Prix", "Img_produit", "Date_ajout", "Pts_fidelite_requis", "Pts_fidelite_donner", "Stock", "Nb_ventes"];
        foreach ($marqueurs as $value) {
            $requete->bindValue(':' . $value, $infos[$value]);
        }

        //Exécution de la requête
        $requete->execute();

        return (bool) $requete->rowCount();
    }

    public function isInDatabaseClient($email){
      /* Ancien code
      $requete = $this->bd->prepare('SELECT id_client FROM Client WHERE  id_client=:id');
      $requete->bindValue(':id',$id);
      $requete->execute();
      $nb = $requete->rowCount();

      if ($nb<1){
        // L'utilisateur n'est pas présent dans la base de données du client
        // Ce n'est donc pas un client 
        return False ;
      }
      else{
        // Il est bien présent dans la base de données client 
        return True ;
      }
      */
      // Nouveau code plus ergonomique
      $requete = $this->bd->prepare('SELECT id_client FROM Client WHERE Email=:email');
      $requete->bindValue(':email', $email);
      $requete->execute();

      return (bool) $requete->rowCount(); // si rien trouvé = 0 convertit en false, si trouvé, = 1 convertit en true  
    }

    public function isInDatabaseAdmin($email){
      /*
      $requete = $this->bd->prepare('SELECT id_admin FROM Admin WHERE id_admin=:id');
      $requete->bindValue(':id',$id);
      */
      /*
      $requete = $this->bd->prepare('SELECT id_admin FROM Admin WHERE Email=:email');
      $requete->bindValue(':email',$email);
      $requete->execute();
      $nb = $requete->rowCount();

      if ($nb<1){
        // L'utilisateur n'est pas présent dans la base de données de l'admin
        // Ce n'est donc pas un admin 
        return False ;
      }
      else{
        // Il est bien présent dans la base de données admin
        return True ;
      }
      */
      $requete = $this->bd->prepare('SELECT id_admin FROM Admin WHERE Email=:email');
      $requete->bindValue(':email', $email);
      $requete->execute();

      return (bool) $requete->rowCount();
    }

    public function isInDatabaseSuperAdmin($id){
      $requete = $this->bd->prepare('SELECT * FROM SuperAdmin WHERE id_admin=:id');
      $requete->bindValue(':id', (int) $id, PDO::PARAM_INT);
      $requete->execute();

      return (bool) $requete->rowCount();
    }

    public function addAuth($infosAuth)
    {
      // Ajout dans Authentification

        //Préparation de la requête
        $requete = $this->bd->prepare('INSERT INTO Authentification VALUES (:num_etudiant, :Password )');
        $requete->bindValue(':num_etudiant', $infosAuth[0]);
        $requete->bindValue(':Password', $infosAuth[1]);

        //Exécution de la requête
        $requete->execute();
        
        // debug,à enlever
        //echo "addAuthClient OK";
    }

    public function addClient($infos)
    {
        // Ajout dans Client
        //unset($infos["Password"]);
        //unset($infos["Password_verify"]);

        //Préparation de la requête
        $requete = $this->bd->prepare('INSERT INTO Client VALUES (:id_client, :num_etudiant, :Nom, :Prenom, :Tel, :Email, :Date_creation, :Pts_fidelite)');

        //Remplacement des marqueurs de place par les valeurs
        $marqueurs = ["id_client", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
        foreach ($marqueurs as $value) {
            $requete->bindValue(':' . $value, $infos[$value]);
        }

        //Exécution de la requête
        $requete->execute();

        return (bool) $requete->rowCount();
      }
  
      public function addAdmin($infos)
      {
          // Ajout dans Admin
  
          //Préparation de la requête
          $requete = $this->bd->prepare('INSERT INTO Admin VALUES (:id_admin, :num_etudiant, :Nom, :Prenom, :Tel, :Email, :Date_creation, :Pts_fidelite)');
  
          //Remplacement des marqueurs de place par les valeurs
          $marqueurs = ["id_admin", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
          foreach ($marqueurs as $value) {
              $requete->bindValue(':' . $value, $infos[$value]);
          }
  
          //Exécution de la requête
          $requete->execute();
  
          return (bool) $requete->rowCount();
      }
  
      public function addSuperAdmin($infos)
      {
          // Ajout dans SuperAdmin
  
          //Préparation de la requête
          $requete = $this->bd->prepare('INSERT INTO SuperAdmin VALUES (:id_superadmin, :id_admin)');
  
          //Remplacement par marqueur de place
          $requete->bindValue(':id_superadmin', $infos[0]);
          $requete->bindValue(':id_admin', $infos[1]);
  
          //Exécution de la requête
          $requete->execute();
  
          return (bool) $requete->rowCount();
      }

    public function getPassword($email,$table){

      if($table=="Admin"){
        $req = $this->bd->prepare('SELECT Password FROM Admin JOIN Authentification USING(num_etudiant) WHERE Email = :email');
        $req->bindValue(':email',$email);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
      }
      elseif($table=="Client"){
        $req = $this->bd->prepare('SELECT Password FROM Client JOIN Authentification USING(num_etudiant) WHERE Email = :email');
        $req->bindValue(':email',$email);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_NUM);
        return $tab[0];
      }

    }

    public function updatePassword($email,$hashedPassword,$table){
      
      if($table=="Client"){

        $req = $this->bd->prepare('UPDATE Authentification JOIN Client USING(num_etudiant) SET Password =:pass where Email= :email ');
        $req->bindValue(':pass',$hashedPassword);
        $req->bindValue(':email',$email);
        $req->execute();

        // Confirm requete réussie
        return (bool) $requete->rowCount();
      }
      elseif($table=="Admin"){

        $req = $this->bd->prepare('UPDATE Authentification JOIN Admin USING(num_etudiant) SET Password =:pass where Email= :email ');
        $req->bindValue(':pass',$hashedPassword);
        $req->bindValue(':email',$email);
        $req->execute();
      
        // Envoie message pour valider la modification ? 

        // Confirm requete réussie
        return (bool) $requete->rowCount();
      }
      else{

        return False;

      }

    }

   

    

}