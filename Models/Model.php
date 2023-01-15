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
      $texte_req = "SELECT id_produit, Nom, Categorie, ROUND(Prix,2) AS 'Prix' , Img_produit, DATE_FORMAT(Date_ajout, '%e/%c/%Y') AS 'Date_ajout', Pts_fidelite_requis, Pts_fidelite_donner, Stock, Nb_ventes, Visible FROM Produit";

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
        $texte_req = $texte_req . " WHERE Categorie = 'Confiserie' OR Categorie = 'Snack'";
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
      elseif ($filter=="abc"){
        $texte_req = $texte_req . " ORDER BY Nom";
      }

      $req = $this->bd->prepare($texte_req);
      $req->bindValue(':type', $type);
      if ($use_marqueur==True){
        $req->bindValue(':search', $search);
      }
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProduitPrecis($id){
      $req = $this->bd->prepare("SELECT * FROM Produit WHERE id_produit = :id");
      $req->bindValue(':id', (int) $id, PDO::PARAM_INT);
      $req->execute();
      return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function getProduitsNouveau($limit)
    {
      $req = $this->bd->prepare("SELECT id_produit, Nom, ROUND(Prix,2) AS 'Prix' , Img_produit, Visible FROM Produit ORDER BY date_ajout DESC LIMIT :limit");
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
      $req = $this->bd->prepare("SELECT id_produit, Nom, ROUND(Prix,2) AS 'Prix' , Img_produit, Visible FROM Produit ORDER BY nb_ventes DESC LIMIT :limit");
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

    public function getClientPrecis($id_client){
      $req = $this->bd->prepare("SELECT * FROM Client WHERE id_client = :id");
      $req->bindValue(':id', (int) $id_client, PDO::PARAM_INT);
      $req->execute();
      return $req->fetch(PDO::FETCH_ASSOC);
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

    public function getAdminPrecis($id_admin){
      $req = $this->bd->prepare("SELECT * FROM Admin WHERE id_admin = :id");
      $req->bindValue(':id', (int) $id_admin, PDO::PARAM_INT);
      $req->execute();
      return $req->fetch(PDO::FETCH_ASSOC);
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
                                  JOIN Admin USING(id_admin) ORDER BY num_vente DESC,Date_vente DESC";
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
        'SELECT distinct id_client, date_vente, Produit.nom, count(*) as "Quantité", CONCAT(sum(ROUND(Prix,2))," €") as "Prix total", Paiement AS "Payé par"
        FROM Client join Vente using(id_client) join Produit using(id_produit)
        WHERE id_client=:id
        GROUP BY id_client, date_vente, Produit.nom, Paiement
        ORDER BY date_vente DESC
        ';

      // si on cherche les achats d'une date en particulier
      if ($date!="default"){
        $texte_req=
        'SELECT distinct Produit.nom AS "Produit", count(*) as "Quantité", CONCAT(sum(ROUND(Prix,2))," €") as "Prix total", Paiement AS "Payé par"
        FROM Client join Vente using(id_client) join Produit using(id_produit)
        WHERE id_client=:id AND date_vente=:date
        GROUP BY Produit.nom, Paiement
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

    public function getVentePrecis($num_vente)
    {
      $req = $this->bd->prepare("SELECT * FROM Vente WHERE num_vente = :id");
      $req->bindValue(':id', (int) $num_vente, PDO::PARAM_INT);
      $req->execute();
      return $req->fetch(PDO::FETCH_ASSOC);
    }

    public function getDatesVentesClient($id)
    {
      $req = $this->bd->prepare('SELECT DISTINCT Date_vente FROM Vente WHERE id_client = :id ORDER BY date_vente DESC');
      $req->bindValue(':id', $id);
      $req->execute();
      return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecettesJour()
    {
      $req = $this->bd->prepare('SELECT sum(ROUND(Prix,2)) AS "Recettes_Quotidien" FROM Vente JOIN Produit USING(id_produit) WHERE DATE(Date_vente)=CURDATE() AND Paiement!=1');
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
      if ($tab[0]==NULL || $req->rowCount()==0){
        return 0;
      }
      else{
        return $tab[0];
      }
    }

    public function getRecettesSemaine()
    {
      $req = $this->bd->prepare('SELECT sum(ROUND(Prix,2)) AS "Recettes_Hebdo" FROM Vente JOIN Produit USING(id_produit) WHERE WEEK(Date_vente)=WEEK(now()) AND Paiement!=1');
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
      return $tab[0];
    }

    public function getRecettesMois()
    {
      $req = $this->bd->prepare('SELECT sum(ROUND(Prix,2)) AS "Recettes_Mois" FROM Vente JOIN Produit USING(id_produit) WHERE MONTH(Date_vente)=MONTH(now()) AND Paiement!=1');
      $req->execute();
      $tab = $req->fetch(PDO::FETCH_NUM);
      return $tab[0];
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
      $req = $this->bd->prepare('SELECT id_admin FROM Admin WHERE Email = :email');
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

    public function getIdClientFromNumEtud($num_etud){
      $req = $this->bd->prepare('SELECT id_client FROM Client WHERE num_etudiant = :num_etud');
      $req->bindValue(':num_etud', $num_etud);
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

    public function getPointsFidelite($id, $table)
    {
      if ($table=="Client"){
        $req = $this->bd->prepare('SELECT Pts_fidelite FROM Client WHERE id_client = :id ');
      } 
      elseif ($table=="Admin"){
        $req = $this->bd->prepare('SELECT Pts_fidelite FROM Admin WHERE id_admin = :id ');
      }
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
        $requete = $this->bd->prepare('INSERT INTO Produit VALUES (:id_produit, :Nom, :Categorie, :Prix, :Img_produit, :Date_ajout, :Pts_fidelite_requis, :Pts_fidelite_donner, :Stock, :Nb_ventes, :Visible)');

        //Remplacement des marqueurs de place par les valeurs
        $marqueurs = ["id_produit", "Nom", "Categorie", "Prix", "Img_produit", "Date_ajout", "Pts_fidelite_requis", "Pts_fidelite_donner", "Stock", "Nb_ventes", "Visible"];
        foreach ($marqueurs as $value) {
            $requete->bindValue(':' . $value, $infos[$value]);
        }

        //Exécution de la requête
        $requete->execute();

        return (bool) $requete->rowCount();
    }

    public function updateProduit($id_produit, $attribut, $nouv_val){

      $tab = ["id_produit", "Nom", "Categorie", "Prix", "Date_ajout", "Pts_fidelite_requis", "Pts_fidelite_donner", "Stock", "Nb_ventes"];
      foreach ($tab as $v) {
        if ($v==$attribut){
          // pas de faille SQLi étant donné que $c est une variable défini dans cette fonction
          $requete = $this->bd->prepare('UPDATE Produit SET ' . $v . ' = :nouv_val WHERE id_produit = :id_produit');
          
          //Remplacement des marqueurs de place par les valeurs
          $requete->bindValue(':nouv_val', $nouv_val);
          $requete->bindValue(':id_produit', $id_produit);

          //Exécution de la requête
          $requete->execute();

          return (bool) $requete->rowCount();
        }
      }
      //$requete = $this->bd->prepare('UPDATE Produit SET WHERE id_produit = :id_produit');

      return False;
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

    public function updateClient($id_client, $attribut, $nouv_val){

      $tab = ["id_client", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
      foreach ($tab as $v) {
        if ($v==$attribut){
          // pas de faille SQLi étant donné que $c est une variable défini de cette fonction
          $requete = $this->bd->prepare('UPDATE Client SET ' . $v . ' = :nouv_val WHERE id_client = :id_client');
          
          //Remplacement des marqueurs de place par les valeurs
          $requete->bindValue(':nouv_val', $nouv_val);
          $requete->bindValue(':id_client', $id_client);

          //Exécution de la requête
          $requete->execute();

          return (bool) $requete->rowCount();
        }
      }

      return False;
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

    public function updateAdmin($id_admin, $attribut, $nouv_val){

      $tab = ["id_admin", "num_etudiant", "Nom", "Prenom", "Tel", "Email", "Date_creation", "Pts_fidelite"];
      foreach ($tab as $v) {
        if ($v==$attribut){
          // pas de faille SQLi étant donné que $c est une variable défini de cette fonction
          $requete = $this->bd->prepare('UPDATE Admin SET ' . $v . ' = :nouv_val WHERE id_admin = :id_admin');
          
          //Remplacement des marqueurs de place par les valeurs
          $requete->bindValue(':nouv_val', $nouv_val);
          $requete->bindValue(':id_admin', $id_admin);

          //Exécution de la requête
          $requete->execute();

          return (bool) $requete->rowCount();
        }
      }

      return False;
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

    public function addVente($infos)
    {
        // Ajout dans Vente

        //Préparation de la requête
        $requete = $this->bd->prepare('INSERT INTO Vente VALUES (:num_vente, :id_client, :id_admin, :id_produit, :Date_vente, :Paiement, :Use_fidelite)');

        //Remplacement des marqueurs de place par les valeurs
        $marqueurs = ["num_vente", "id_client", "id_admin", "id_produit", "Date_vente", "Paiement", "Use_fidelite"];
        foreach ($marqueurs as $value) {
            $requete->bindValue(':' . $value, $infos[$value]);
        }

        //Exécution de la requête
        $requete->execute();

        return (bool) $requete->rowCount();
    }

    public function updateVente($num_vente, $attribut, $nouv_val){

      $tab = ["num_vente", "id_client", "id_admin", "id_produit", "Date_vente", "Paiement", "Use_fidelite"];
      foreach ($tab as $v) {
        if ($v==$attribut){
          // pas de faille SQLi étant donné que $c est une variable défini de cette fonction
          $requete = $this->bd->prepare('UPDATE Vente SET ' . $v . ' = :nouv_val WHERE num_vente = :num_vente');
          
          //Remplacement des marqueurs de place par les valeurs
          $requete->bindValue(':nouv_val', $nouv_val);
          $requete->bindValue(':num_vente', $num_vente);

          //Exécution de la requête
          $requete->execute();

          return (bool) $requete->rowCount();
        }
      }

      //return False;
    }

    public function updateStock($id_produit)
    {
      //Préparation de la requête
      $requete = $this->bd->prepare('UPDATE Produit SET Stock = ((SELECT Stock FROM Produit WHERE id_produit = :id_produit) - 1) WHERE id_produit = :id_produit');

      //Remplacement des marqueurs de place par les valeurs
      $requete->bindValue(':id_produit', $id_produit);

      //Exécution de la requête
      $requete->execute();

      return (bool) $requete->rowCount();
    }

    public function updateNbVente($id_produit)
    {
      $requete = $this->bd->prepare('UPDATE Produit SET Nb_ventes = ((SELECT Nb_ventes FROM Produit WHERE id_produit = :id_produit) + 1) WHERE id_produit = :id_produit');

      //Remplacement des marqueurs de place par les valeurs
      $requete->bindValue(':id_produit', $id_produit);

      //Exécution de la requête
      $requete->execute();

      return (bool) $requete->rowCount();
    }

    public function updatePtsFideliteClient($id_client, $id_produit)
    {
      //Préparation de la requête
      $requete = $this->bd->prepare('UPDATE Client SET Pts_fidelite = ((SELECT Pts_fidelite FROM Client WHERE id_client = :id_client) + (SELECT Pts_fidelite_donner FROM Produit WHERE id_produit = :id_produit)) WHERE id_client = :id_client');

      //Remplacement des marqueurs de place par les valeurs
      $requete->bindValue(':id_client', $id_client);
      $requete->bindValue(':id_produit', $id_produit);

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
        return (bool) $req->rowCount();
      }
      elseif($table=="Admin"){

        $req = $this->bd->prepare('UPDATE Authentification JOIN Admin USING(num_etudiant) SET Password =:pass where Email= :email ');
        $req->bindValue(':pass',$hashedPassword);
        $req->bindValue(':email',$email);
        $req->execute();
      
        // Envoie message pour valider la modification ? 

        // Confirm requete réussie
        return (bool) $req->rowCount();
      }
      else{

        return False;

      }

    }

    //////
    
    
    public function verifNumEtudiant($num_etud, $table){
      if($table=="Client"){
        $req = $this->bd->prepare('SELECT * FROM Client WHERE num_etudiant = :num ');
      }
      elseif($table=="Admin"){
        $req = $this->bd->prepare('SELECT * FROM Admin WHERE num_etudiant = :num ');      
      }
      $req->bindValue(':num', $num_etud);
      $req->execute();
      return (bool) $req->rowCount();
      
    }
      /* ancien code
      if(isset($_POST['num_etudiant'])){
        $req = this->bd->prepare('SELECT * FROM client WHERE Num_etudiant = :num ')
        $req->bindValue('num',$_POST['num_etudiant']);
        $req->execute();
        $nb = $req->rowCount();
  
        if ($nb>0){
          $this->action_error("Numéro étudiant déjà utilisé "); 
        }
      }
      */
   
    public function removeCompteClient($id){
      // Supprimer de ventes pour supprimer les ventes du client 

      $req2 = $this->bd->prepare('DELETE FROM Vente WHERE id_client = :id');
      $req2->bindValue(':id',$id);
      $req2->execute();
      

      // Suppression de la table client
      $req = $this->bd->prepare('DELETE FROM Client where num_etudiant = (SELECT num_etudiant FROM Client WHERE id_client=:id) ');
      $req->bindValue(':id',$id);
      $req->execute();

      // Suppression de la table Authentification
      $req1 = $this->bd->prepare('DELETE FROM Authentification WHERE num_etudiant = (SELECT num_etudiant FROM Client WHERE id_client=:id)');
      $req1->bindValue(':id',$id);
      $req1->execute();

    } 

    public function removeCompteAdmin($id){

      $req = $this->bd->prepare('DELETE FROM Admin where num_etudiant = (SELECT num_etudiant FROM Client WHERE id_client=:id) ');
      $req->bindValue(':id',$id);
      $req->execute();
      return (bool) $req->rowCount();

    }


    public function removeProduit($id_produit){

      $req = $this->bd->prepare('DELETE FROM Produit where Id_produit = :id ');
      $req->bindValue(':id',$id_produit);
      $req->execute();
      return (bool) $req->rowCount();

    }

    public function updateNumEtudiant($num_etud,$new_num_etud,$table){
    
      //Désactivation temporaire de la clé étrangère num étudiant
      $req4 = $this->bd->prepare('SET FOREIGN_KEY_CHECKS = 0');
      $req4->execute();

      // Update dans client puis dans authentification 
      if($table=='Client'){
        //Désactivation temporaire de la clé étrangère num étudiant (méthode alt)
        //$req2 = $this->bd->prepare('ALTER TABLE Client DROP FOREIGN KEY Client_ibfk_1');
        //$req2->execute();
        
        $req = $this->bd->prepare('UPDATE Client SET num_etudiant =:newNum where num_etudiant= :num ');
        $req->bindValue(':newNum',$new_num_etud);
        $req->bindValue(':num',$num_etud);
        $req->execute();
      }
      // update dans Admin puis dans Authentification
      elseif($table=='Admin'){
        //Désactivation temporaire de la clé étrangère num étudiant (méthode alt)
        //$req2 = $this->bd->prepare('ALTER TABLE Admin DROP FOREIGN KEY Admin_ibfk_1');
        //$req2->execute();

        $req = $this->bd->prepare('UPDATE Admin SET num_etudiant =:newNum where num_etudiant= :num ');
        $req->bindValue(':newNum',$new_num_etud);
        $req->bindValue(':num',$num_etud);
        $req->execute();

        //Réactivation clé étrangère (méthode alt)
        //$req3 = $this->bd->prepare('ALTER TABLE Admin ADD FOREIGN KEY (num_etudiant) REFERENCES Authentification(num_etudiant)');
        //$req3->execute();
      }

      $req1 = $this->bd->prepare('UPDATE Authentification SET num_etudiant =:newNum where num_etudiant= :num ');
      $req1->bindValue(':newNum',$new_num_etud);
      $req1->bindValue(':num',$num_etud);
      $req1->execute();

      //Réactivation clé étrangère
      $req5 = $this->bd->prepare('SET FOREIGN_KEY_CHECKS = 1');
      $req5->execute();

      return (bool) $req->rowCount();

    }



} // fin model