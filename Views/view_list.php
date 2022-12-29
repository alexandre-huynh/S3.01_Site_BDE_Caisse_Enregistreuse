<?php require "view_begin.php";?>

<!-- Pour plus tard quand les variables sessions seront crées
< ?php if ($connected==True) : ?>
  < ?php require "view_begin_connected.php";?>
< ?php else : ?>
  < ?php require "view_begin.php";?>
< ?php endif ?>
-->

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!-- par exemple $listed_elements -> action=gestion_clients -->
<!-- ne marche pas, redirige vers l'accueil : <form action = "index.php?controller=list&action=< ?=e($listed_elements)?>">-->
<form action ="">
  <input type="hidden" name="controller" value="list" />
  <input type="hidden" name="action" value="<?=e($listed_elements)?>" />
   <p>
      <label> Rechercher : <input type="search" 
                                  name="search" 
                                  <?php if (isset($_GET["search"]) && $_GET["search"]!="") : ?>
                                    value=<?=e($_GET["search"])?>
                                  <?php endif ?> 
                                  placeholder="Rechercher par mot clé" 
                                  required /> 
      </label>
   </p>
   <!--========================================ANCIEN CODE RECHERCHE PAR ATTRIBUT SELECTIONNABLE===========================
   <p>
      <!-Pour indiquer qu'on cherche par exemple un nom de produit correspondant, ou un email etc ->
     <label> Par : 
        <select name="attribut">
          < ?php if ($listed_elements=="gestion_clients") : ?>
            <!- Le php ici sert juste à ce que l'attribut de recherche choisi soit sélectionné parmi les autres ->
            <option value="num_etudiant" < ?php if (isset($_GET["attribut"]) && $_GET["attribut"]=="num_etudiant") : ?>selected< ?php endif ?>>Numéro étudiant</option>
            <option value="Nom" < ?php if (isset($_GET["attribut"]) && $_GET["attribut"]=="Nom") : ?>selected< ?php endif ?>>Nom</option>
            <option value="Prenom" < ?php if (isset($_GET["attribut"]) && $_GET["attribut"]=="Prenom") : ?>selected< ?php endif ?>>Prénom</option>
            <option value="Tel" < ?php if (isset($_GET["attribut"]) && $_GET["attribut"]=="Tel") : ?>selected< ?php endif ?>>Numéro de Téléphone</option>
            <option value="Email" < ?php if (isset($_GET["attribut"]) && $_GET["attribut"]=="Email") : ?>selected< ?php endif ?>>Email</option>
          < ?php endif ?>
          <!-- Pour afficher tous les attributs possibles dont on veut trier avec
          < ?php foreach ($colonnes as $v): ?>
            <option value="< ?=strtolower(e($v))?>">< ?=e($v)?></option>
          < ?php endforeach ?>
          ->
        </select>
     </label>
   </p>
   ========================================================================================================================
    -->
   <p>
     <input type="submit" value="Rechercher"/>
   </p>
</form>

<!-- Réinitialiser recherche -->
<p>
  <a href="?controller=list&action=<?=e($listed_elements)?>">Réinitialiser la recherche</a>
</p>
<!--=======================================================-->

<!-- Liste des éléments sous forme de table -->
<!-- Peut contenir par exemple la liste de produits, des clients inscrits, des ventes etc -->
<table>
  <!-- Titres de colonnes / attributs -->
  <tr>
    <!-- Ici si on prend que les clés, on a les noms de colonnes-->
    <?php foreach ($colonnes as $v): ?>
      <th><?=e($v)?></th>
    <?php endforeach ?>
  </tr>
  <!-- Lignes d'éléments / Tuples -->
  <?php foreach ($liste as $ligne): ?>
  <tr>
      <!-- -------------------------------------------------------------------  
      Affichage spécial pour les produits (ordre spécifique et plus pratique)
      Normalement pas besoin de vérifier si action=gestion_truc existe avec isset  
      car si elle n'existait pas on ne serait même pas sur cette page
      ------------------------------------------------------------------- -->
      <?php if ($_GET["action"]=="gestion_inventaire") : ?>
        <td><?=e($ligne["id_produit"])?></td>
        <td><?=e($ligne["Date_ajout"])?></td>
        <td><img src="Content/img/<?=e($ligne["Img_produit"])?>" height=60 /></td>
        <td><?=e($ligne["Nom"])?></td>
        <td><?=e($ligne["Categorie"])?></td>
        <td><?=e($ligne["Prix"])?> €</td>
        <td><?=e($ligne["Stock"])?><img src="Content/img/logo_stock.png" height=20 /></td>
        <td><?=e($ligne["Nb_ventes"])?><img src="Content/img/logo_ventes.png" height=20 /></td>
      <!-- ------------------------------------------------------------------- -->
      <!--< ?php elseif ($_GET["action"]=="gestion_quelquechose") : ?>-->
      <!-- ------------------------------------------------------------------- 
      Affichage par défaut, général 
      (même ordre de colonnes/attributs que dans base de données)
      ------------------------------------------------------------------- -->
      <?php else : ?>
        <!-- 
        Cases, on parcourt 1 ligne = $clé=>$valeur
        par exemple Nom => Blanc, Prénom => Laurent
        -->
        <?php foreach ($ligne as $v): ?>
          <td><?=e($v)?></td>
        <?php endforeach ?>
      <?php endif ?> 
      <!-- 
      $id_element peut être id_produit, id_client, id_admin ou num vente,
      s'adaptera selon $variable passé dans $data
      
      TODO: voir si lien = form_update&id ou form_update& < ?=$id_element?>, 
      dépend de comment on organise le formulaire de maj
      -->

      
      <!-- Case modifier cette ligne -->
      <td>
        <a href="?controller=set&action=form_update&id=<?=e($ligne[$id_element])?>">
          <img src="Content/img/edit-icon.png" alt="update"/>
        </a>
      </td>
      
      <!-- Case supprimer cette ligne -->
      <td>
        <a href="?controller=set&action=remove&id=<?=e($ligne[$id_element])?>">
          <img src="Content/img/remove-icon.png" alt="suppr"/>
        </a>
      </td>
  </tr>
  <?php endforeach ?>
</table>

<!--Risque de ne pas être vu ? étant donné que le tableau va peut-être être long-->
<p>
  <a href="?controller=set&action=form_add">
    Créer <?=e($str_add_element)?>
    <!-- 
    ou
    Ajouter < ?=e($str_add_element)?>
    -->
  </a>
</p>

<?php require "view_end.php";?>