<?php
session_start();
ini_set ('session.bug_compat_42', 0);
ini_set ('session.bug_compat_warn', 0); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<meta charset="UTF-8">
<head>
<!-- <link rel="stylesheet" href="stylecarnet.css"> -->
  <title>Présentation des notes</title>
  <!-- Fichier : SortieCarnet1.php -->
</head><html><body>
<?php include('fonctions/fonctions.php') ?>

<?php
ecrire_var("periode","$_POST[periode]");
header('Location: 90_administration.php');
?>

</body></html>
