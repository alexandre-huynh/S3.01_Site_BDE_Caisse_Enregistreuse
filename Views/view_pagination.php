<?php require "view_begin.php";?>

<h1> List of Nobel prizes </h1>

<?php require 'view_list_nobel.php'; ?>

<div class="listePages">
  <p> Pages: </p>
  <?php if ($active >1) : ?>
    <a class="lienStart prev" href="?controller=list&action=pagination&start=<?= e($active) -1 ?>">
    <img class="icone" src="Content/img/previous-icon.png" alt="Previous" /> </a>
  <?php endif ?>

  <?php for($p = $debut; $p <= $fin; $p++): ?>
    <a class="<?= $p == $active ? "lienStart active" : "lienStart" ?>"
      href="?controller=list&action=pagination&start=<?= $p?>"> <?= $p ?> </a>
  <?php endfor ?>

  <?php if ($active < $nb_total_pages) : ?>
    <a class="lienStart next" href="?controller=list&action=pagination&start=<?= e($active) + 1 ?>">
    <img class="icone" src="Content/img/next-icon.png" alt="Next" /> </a>
  <?php endif ?>

</div>

</main>

<?php require "view_end.php";?>
