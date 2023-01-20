<?php if (isset($_SESSION["connected"]) && $_SESSION["connected"]==True) : ?>
  <?php require "view_begin_connected.php";?>
<?php else : ?>
  <?php require "view_begin.php";?>
<?php endif ?>
<link rel="stylesheet" type="text/css" href="Content/css/espace_admin.css">

<h1 class="greeting">Bonjour <?=e($nomprenom)?> !</h1>
<hr>
<div class="content-main">

<!--Stats recettes-->
<p class="bilan">Le Wolf BDE a réalisé :
    <ul>
        <li><?=e($recettes_today)?> € de recettes <b>aujourd'hui</b></li>
        <li><?=e($recettes_week)?> € de recettes <b>cette semaine</b></li>
        <li><?=e($recettes_month)?> € de recettes <b>ce mois-ci</b></li>
    </ul>
</p>
<hr>

<!--TODO: Mettre des images d'illustration à côté des boutons liens, OPTIONEL-->
<div class="menu-list">
    <p>
        <a href="?controller=list&action=caisse" title="Caisse enregistreuse">Caisse enregistreuse</a>
    </p>
    <p>
        <a href="?controller=list&action=gestion_inventaire" title="Inventaire des produits">Inventaire des produits</a>
    </p>
    <p>
        <a href="?controller=list&action=gestion_ventes" title="Historique des ventes">Historique des ventes</a>
    </p>
    <p>
        <a href="?controller=list&action=gestion_clients" title="Gestion des comptes clients">Gestion des comptes clients</a>
    </p>
    <?php if (isset($_SESSION["superadmin"]) && $_SESSION["superadmin"]==True) : ?>
    <p>
        <a href="?controller=list&action=gestion_admins" title="Gestion des comptes administrateurs">Gestion des comptes administrateurs</a>
    </p>
    <?php endif ?>
</div>

</main>

<?php require "view_end.php";?>