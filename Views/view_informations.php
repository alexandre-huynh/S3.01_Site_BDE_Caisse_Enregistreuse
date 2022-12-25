<?php require "view_begin.php";?>

<h1> <?= e($name) ?> </h1>

<ul>
  <li> Year and place of birth : <?= $birthdate ===null ? '???' : e($birthdate) ?>
      at <?= $birthplace === null ? '???' : e($birthplace) ?> </li>
  <li> County : <?= $county === null ? '???' : e($county) ?> </li>
</ul>

<!-- <?= $birthplace === null ? '???' : e($birthplace) ?> soit l'un soit l'autre-->

<h2>
  Nobel Prize in <?= e($year) ?> in the field of <?= e($category) ?>
</h2>

<p>
    <?= e($motivation) ?>
</p>

<?php require "view_end.php";?>
