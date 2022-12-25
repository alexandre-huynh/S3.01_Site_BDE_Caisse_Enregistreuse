<?php require "view_begin.php";?>

<h1>List of the last 25 Nobel prizes</h1>

<table>
  <tr>
    <th>Name</th>
    <th>Category</th>
    <th>Year</th>
    <th class="sansBordure"></th>
    <th class="sansBordure"></th>
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

<?php require "view_end.php";?>
