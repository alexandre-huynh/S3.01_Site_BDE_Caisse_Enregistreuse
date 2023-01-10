<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<h1> Update a Nobel Prize </h1>

<form action = "?controller=set&action=update" method="post">

    <p>
      <input type="hidden" name="id" value="<?=e($id)?>" />
      <label> Name: <input type="text" name="name" value="<?=e($name)?>"/> </label>
    </p>

    <p>
      <label> Year: <input type="text" name="year" value="<?= e($year)?>"/> </label>
    </p>

    <p>
      <label> Birth Date: <input type="text" name="birthdate" value="<?= e($birthdate)?>"/></label>
    </p>

    <p>
      <label> Birth Place: <input type="text" name="birthplace" value="<?= e($birthplace)?>"/> </label>
    </p>
    <p>
      <label> County: <input type="text" name="county" value="<?= e($county)?>"/> </label>
    </p>

    <p>
    <?php foreach ($categories as $v): ?>
      <!-->Faire attention à ne pas mettre d'espace dans value, à part le php <!-->
        <label> <input type="radio" name="category" value="<?=e($v)?>"
        <?php
        if ($v == $category) {
          echo 'checked="checked"';
        }
        ?>
        /> <?= e(ucfirst($v)) ?>  </label>
    <?php endforeach ?>

    </p>

    <textarea name="motivation" cols="70" rows="10"> <?= e($motivation) ?> </textarea>
    <p>  <input type="submit" value="Update the database"/> </p>
</form>

<?php require "view_end.php";?>
