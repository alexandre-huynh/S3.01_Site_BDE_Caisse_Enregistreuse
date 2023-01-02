<?php require "view_begin.php"; ?>


<h1> 
    <?= e($title) ?> 
</h1>

<p>   
    <?= e($message) ?>
</p>

<?php if (isset($lien_retour) && isset($str_lien_retour)) : ?>
    <p>   
        <a href="<?= e($lien_retour) ?>"><?= e($str_lien_retour) ?></a>
    </p>
<?php endif ?>

<?php require "view_end.php"; ?>