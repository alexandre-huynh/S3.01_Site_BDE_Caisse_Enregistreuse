<?php require "view_begin.php";?>

<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!-- TODO: voir comment faire un truc de recherche avec le système actuel -->
<!-- peut être que c'est plus simple en faisant des view différentes -->
<!-- par exemple $listed_elements -> action=gestion_clients -->
<!--<form action = "index.php?controller=list&action=< ?=e($listed_elements)?>">-->
<form action ="">
  <!-- Si ca marche toujours pas -->
  <input type="hidden" name="controller" value="list" />
  <input type="hidden" name="action" value="<?=e($listed_elements)?>" />
  <!-- -->
   <p>
      <label> Rechercher : <input type="text" name="search" <?php if (isset($_GET["search"])) : ?>value=<?=e($_GET["search"])?><?php endif ?> /> </label>
   </p>
   <p>
     <!-- Pour indiquer qu'on cherche par exemple un nom de produit correspondant, ou un email etc -->
     <label> Par : 
        <select name="attribut">
          <?php if ($listed_elements=="gestion_clients") : ?>
            <!-- Le php ici sert juste à ce que l'attribut de recherche choisi soit sélectionné parmi les autres -->
            <option value="num_etudiant" <?php if ($_GET["attribut"]=="num_etudiant") : ?>selected<?php endif ?>>Numéro étudiant</option>
            <option value="Nom" <?php if ($_GET["attribut"]=="Nom") : ?>selected<?php endif ?>>Nom</option>
            <option value="Prenom" <?php if ($_GET["attribut"]=="Prenom") : ?>selected<?php endif ?>>Prénom</option>
            <option value="Tel" <?php if ($_GET["attribut"]=="Tel") : ?>selected<?php endif ?>>Numéro de Téléphone</option>
            <option value="Email" <?php if ($_GET["attribut"]=="Email") : ?>selected<?php endif ?>>Email</option>
          <?php endif ?>
          <!-- Pour afficher tous les attributs possibles dont on veut trier avec
          < ?php foreach ($colonnes as $v): ?>
            <option value="< ?=strtolower(e($v))?>">< ?=e($v)?></option>
          < ?php endforeach ?>
          -->
        </select>
     </label>
   </p>
   <p>
     <input type="submit" value="Rechercher"/>
   </p>
</form>
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
      <!-- 
      Cases, 1 ligne = $clé=>$valeur
      par exemple Nom => Blanc, Prénom => Laurent
      -->
      <?php foreach ($ligne as $v): ?>
        <td><?=e($v)?></td>
      <?php endforeach ?>
      <!-- 
      $id_element peut être id_produit, id_client, id_admin ou num vente,
      s'adaptera selon $variable passé dans $data
      
      TODO: voir si lien = form_update&id ou form_update& < ?=$id_element?>, 
      dépend de comment on organise le formulaire de maj
      -->
      <td>
        <a href="?controller=set&action=form_update&id=<?=e($ligne[$id_element])?>">
          <img src="Content/img/edit-icon.png" alt="update"/>
        </a>
      </td>

      <td>
        <a href="?controller=set&action=remove&id=<?=e($ligne[$id_element])?>">
          <img src="Content/img/remove-icon.png" alt="suppr"/>
        </a>
      </td>
  </tr>
  <?php endforeach ?>

</table>

<?php require "view_end.php";?>