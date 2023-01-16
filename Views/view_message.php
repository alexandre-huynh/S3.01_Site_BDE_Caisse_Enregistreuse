<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>

<link rel="stylesheet" type="text/css" href="Content/css/message.css">


<h1> 
    <?= e($title) ?> 
</h1>

<p>   
    <?= e($message) ?>
</p>

<?php if (isset($produits_traite)) : ?>
  <ul>
    <?php foreach ($produits_traite as $c => $v): ?>
      <li><?=e($c)?> - <?=e($v)?> €</li>
    <?php endforeach ?>
  </ul>
<?php endif ?>

<?php if (isset($lien_retour) && isset($str_lien_retour)) : ?>
    <p>   
        <a href="<?= e($lien_retour) ?>"><?= e($str_lien_retour) ?></a>
    </p>
<?php endif ?>

</main>


<?php require "view_end.php"; ?>