<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<p>Bonjour, espace administrateur de <?=e($nomprenom)?></p>

<?php require "view_end.php";?>