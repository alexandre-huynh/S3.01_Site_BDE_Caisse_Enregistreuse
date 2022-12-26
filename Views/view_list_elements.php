<!-- Titre de la liste d'élements -->
<h1> <?= e($titre) ?> </h1>

<!-- TODO: voir comment faire un truc de recherche avec le système actuel -->
<!-- peut être que c'est plus simple en faisant des view différentes -->
<form action = "?controller=list&action=elements&element=<?= e($element) ?>">
   <p>
     <label> Rechercher : <input type="text" name="name"/> </label>
   </p>
   <p>
     <!-- Pour indiquer qu'on cherche par exemple un nom de produit correspondant, ou un email etc -->
     <label> Par : 
        <select name="attribut">
          <?php foreach ($liste[0] as $c=>$v): ?>
          <option value="<?=e($c)?>"><?=e($c)?></option>
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
  <tr>
    <?php foreach ($liste[0] as $c=>$v): ?>
    <th><?=e($c)?></th>
    <?php endforeach ?>
  </tr>
  <?php foreach ($liste as $np): ?>
  <tr>
      <td><a href="?controller=list&action=informations&id=<?=e($np["id"])?>"> <?=e($np["name"])?> </a></td>
      <td> <?=e($np["category"])?> </td>
      <td> <?=e($np["year"])?> </td>

      <td class="sansBordure">
        <a href="?controller=set&action=form_update&id=<?=e($np["id"])?>">
          <img src="Content/img/edit-icon.png" alt="update"/>
        </a>
      </td>

      <td class="sansBordure">
        <a href="?controller=set&action=remove&id=<?=e($np["id"])?>">
          <img src="Content/img/remove-icon.png" alt="suppr"/>
        </a>
      </td>

  </tr>
  <?php endforeach ?>

</table>
