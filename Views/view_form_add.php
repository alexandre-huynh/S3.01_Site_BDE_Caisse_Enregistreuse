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

<form action = "?controller=set&action=add" method="post">
    <p> <label> Name: <input type="text" name="name"/> </label>

    </p>
    <p> <label> Year: <input type="text" name="year"/> </label></p>
    <p> <label> Birth Date: <input type="text" name="birthdate"/></label> </p>
    <p> <label> Birth Place: <input type="text" name="birthplace"/> </label></p>
    <p> <label> County: <input type="text" name="county"/></label> </p>

    <p>
    <?php foreach ($categories as $v): ?>
        <label> <input type="radio" name="category" value="<?=e($v)?>"/> <?=e(ucfirst($v))?> </label>
    <?php endforeach ?>
    </p>


    <textarea name="motivation" cols="70" rows="10"></textarea>
    <p>  <input type="submit" value="Add in database"/> </p>
</form>

<?php require "view_end.php";?>
