<?php

function Erreur($msgerreur)/*Afficher page html jusqua body*/
{
echo '
<!DOCTYPE html>
<html lang="fr" >
<head>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="http://localhost/h5ai/file/explorer.css" />
<script language="javascript" type="text/javascript" src="http://localhost/h5ai/file/javascript.js"></script> 
</head>
<body>
<div class="bulle">'.htmlentities($msgerreur).'</div>
</body></html>';
}

function GetFileName($path)/*Recupère le nom d'un fichier via le chemin*/
{
  $name=explode("/",$path);
  return $name[sizeof($name)-1];
}

function download($file)/*Fonction download, telecharges le fichier*/
{
  $name=GetFileName($file);/*Extraie le nom via GetFileName*/
/*
Modifie l'header forcer le telechargement au client , au  fichier desirer
*/
  header('Content-disposition: attachment; filename='.$name);/*Indique le nom*/
  header('Content-Type: application/force-download');/*Indique le type*/
  header('Content-Length: '.filesize($file));/*Indique la taille pour permet au client de savoir le % de telechargement Ceci n'est pas obligatoire .*/
  header('Pragma: no-cache');
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0, public');
  header('Expires: 0');
  readfile($file); /*Lit le fichier */
  exit; /*On Quit pour rien envoyez d'autre*/
}


?>
