<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!-- TODO: voir comment faire un truc de recherche avec le système actuel -->
<!-- peut être que c'est plus simple en faisant des view différentes -->
<!-- par exemple $listed_elements -> action=gestion_clients -->
<form action = "?controller=list&action=<?= e($listed_elements) ?>">
   <p>
      <label> Rechercher : <input type="text" name="search"/> </label>
   </p>
   <p>
     <!-- Pour indiquer qu'on cherche par exemple un nom de produit correspondant, ou un email etc -->
     <label> Par : 
        <select name="attribut">
          <?php foreach ($liste[0] as $c=>$v): ?>
          <option value="<?=strtolower(e($c))?>"><?=e($c)?></option>
          <?php endforeach ?>
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
    <?php foreach ($liste[0] as $c=>$v): ?>
    <th><?=e($c)?></th>
    <?php endforeach ?>
  </tr>
  <!-- Lignes d'éléments / Tuples -->
  <?php foreach ($liste as $ligne): ?>
  <tr>
      <!-- 
      Cases, 1 ligne = $clé=>$valeur
      par exemple Nom => Blanc, Prénom => Laurent
      -->
      <?php foreach ($ligne as $c=>$v): ?>
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
