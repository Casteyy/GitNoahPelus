<?php

// Différentes variables des illustrations
$DEFAULT=$_SERVER['DOCUMENT_ROOT']; /*Default redirection quand le script commence*/
$IMGFOLDER='img/file.png'; /*L'icon pour le dossier*/
$IMGFILE='img/fichier.gif'; /*Icon pour le fichier*/
$IMGCREATEFILE='img/filenew.png'; /*icon pour crée un fichier*/
$IMGUPLOAD='img/upload.gif'; /*icon pour upload des fichier*/
$IMGCREATEFOLDER='img/folder-new.png';
$IMGSEARCH='img/search.png';
$IMGRENAME='img/edit.png';





if(!isset($_GET['rename'])&&!isset($_GET['pathren'])&&!isset($_GET['en'])&&!isset($_GET['upload'])&&!isset($_POST['pathupload'])&&!isset($_GET['touch'])&&!isset($_GET['download'])&&/*Verifie si rien n'est appellé*/
!isset($_GET['delete'])&&!isset($_GET['path'])&&!isset($_GET['dir'])&&!isset($_FILES['fichier'])&&!isset($_GET['mkdir'])&&!isset
($_GET['pathmkdir']))
{
	header('location:?dir='.$DEFAULT);
}






if(isset($_GET['upload'])&&isset($_POST)&&!file_exists($_POST['pathupload'].$_FILES['fichier']['name']))
{
$tmp_file = $_FILES['fichier']['tmp_name'];
$name_file = $_FILES['fichier']['name'];

	header('location:'.$_SERVER['HTTP_REFERER']);
}







if(isset($_GET['touch'])&&!empty($_GET['touch'])&&isset($_GET['path'])&&!empty($_GET['path']))/*Permer de crée un fichier*/
{
 
 if(!@touch($_GET['path'].'/'.$_GET['touch']))
 {
     Erreur('Erreur l\'ors de la creation du fichier '.$_GET['touch'].'');
     exit;
 }
  
 header('location:'.'?dir='.$_GET['path']);/*Redirection a l'url precedent*/

}






if(isset($_GET['mkdir'])&&!empty($_GET['mkdir'])&&isset($_GET['pathmkdir'])&&!empty($_GET['pathmkdir']))
{
 if(!@mkdir($_GET['pathmkdir'].'/'.$_GET['mkdir'],0755)){
     Erreur('Erreur l\'ors de la création du fichier '.$_GET['mkdir'].'!');
     exit;
 }
  header('location:?dir='.$_GET['pathmkdir']);
}






if(isset($_GET['rename'])&&!empty($_GET['rename'])&&isset($_GET['pathren'])&&!empty($_GET['pathren'])&&isset($_GET['en'])&&!empty($_GET['en']))
{

 if(!@rename($_GET['pathren'].'/'.$_GET['rename'],$_GET['pathren'].'/'.$_GET['en'])){
     Erreur('Erreur pour renommer '.$_GET['rename'].' en '.$_GET['en']);
     exit;
}

  header('location:?dir='.$_GET['pathren']);
}





if(isset($_GET['download'])&&!empty($_GET['download'])&&file_exists($_GET['download'])&&is_file($_GET['download']))/*Telecharge un fichier*/
{
  download($_GET['download']);/*....*/
}




if(isset($_GET['delete'])&&!empty($_GET['delete'])&&file_exists($_GET['delete'])&&is_file($_GET['delete']))/*Supprimé un fichier ...*/
{
  
  if(!@unlink($_GET['delete']))
  {
		Erreur('Erreur l\ors de la suppresion de '.$_GET['delete'].'');
		exit;
  }
  header('location:'.$_SERVER['HTTP_REFERER']);
}




if(isset($_GET['dir'])&&!empty($_GET['dir'])&&file_exists($_GET['dir'])&&is_dir($_GET['dir']))/*Verifie la variable bien un repertoire*/
{
$rep=$_GET['dir'];
$rep=str_replace("//","/",$rep);
$handle = @opendir($rep);/* Ouvre le repertoire */



/**************************************------------------------HTML-------------------------*************************************/
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<link rel="stylesheet" media="screen" type="text/css" title="Design" href="http://localhost/h5ai/file/explorer.css" />
<script language="javascript" type="text/javascript" src="http://localhost/h5ai/file/javascript.js"></script> 
</head>
<body>
<div id="logo">
<a href="#" onclick="display_('touch');"><img title="Cree un fichier"  title="Cree un fichier" src="<?php echo $IMGCREATEFILE; ?>" /></a><br />
<a href="#" onclick="display_('upload');"><img title="Telecharger un fichier"  title="Telecharger un fichier" src="<?php echo $IMGUPLOAD; ?>" /></a><br />
<a href="#" onclick="display_('mkdir');"><img title="Cree un dossier"  title="Cree un dossier" src="<?php echo $IMGCREATEFOLDER; ?>" /></a><br />
<a href="#" onclick="display_('search');"><img title="Chercher"  title="Chercher" src="<?php echo $IMGSEARCH; ?>" /></a></span><br />
<a href="#" onclick="display_('rename');"><img title="Renommer"  title="Renommer" src="<?php echo $IMGRENAME; ?>" /></a></span><br />

</div>
</body>
</html>
<?php
while ($f = readdir($handle)) { //Boucle qui enumere tout les fichier d'un repertoire
     $lien=str_replace(" ",'%20',$f); /*Pour les espace fichier*/
	 $replien=str_replace(" ",'%20',$rep);/*idem pour les dossier*/
     

	 
  if(@is_dir($rep.'/'.$f)){ /*verifie si c'est un repertoire*/
	  
     echo '<a href="?dir='.$replien.'/'.$lien.'"><img alt="Dossier" src="'.$IMGFOLDER.'" />'.$f.'</a><br />'; 
   
   }elseif(@is_file($rep.'/'.$f)){/*Verifie si c'est bien un fichier*/
   
	  echo '<img src="'.$IMGFILE.'" alt="Fichier"/>'.$f.'<a href="?delete='.$replien.'/'.$lien.'" onclick="return confirm(\'Supprimer '.$f.' ?\');"><img alt="Supprimmer" title="/!\Supprimer/!\ " src="img/delete.gif" /></a><a href="?download='.$replien.'/'.$lien.'" ><img alt="Telecharger" title="Telecharger " src="img/download.png" /></a><br />';
}
echo '</div>'."\n"; /*ferme la div pour la couleur.*/
/*Crée le formulaire pour crée un fichier par default display:none affiche en cliquant en  haut*/

}
}

/*Formulaire Pour crée un fichier */
echo '<div class="bulle" id="touch" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGFILE.'"></img><input type="text" name="touch"  title="Fichier a cree" size="30" />
<input type="hidden" name="path" value="'.$replien.'" />
</form></div>';

/*Formulaire pour upload un fichier*/
echo '<div class="bulle" id="upload" style="display:none;">
<form method="post" enctype="multipart/form-data" action="?upload">
<input type="file" name="fichier" size="25">
<input type="submit" name="upload" value="Go">
<input type="hidden" name="pathupload" value="'.$replien.'" />
</form></div>';

/*Formulaire pour crée un dossier :)*/

echo '<div class="bulle" id="mkdir" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGFOLDER.'" ></img><input type="text" name="mkdir"  title="Cree dossier" size="30" />
<input type="hidden" name="pathmkdir" value="'.$replien.'" />
</form></div>';

/*renommer*/

echo '<div class="bulle" id="rename" style="display:none;"><form method="get" action="?" >
<img src="'.$IMGRENAME.'"></img><input type="text" name="rename"  title="Renommer ?" size="10" /> en <input type="text" name="en"  title="en" size="10" /><input type="submit" value="go" />
<input type="hidden" name="pathren" value="'.$replien.'" />
</form></div>';

echo '<div class="bulle" id="search" style="display:none;">
<img src='.$IMGSEARCH.'></img><input type="text" size="20" id="larecherche"/><br><div id="recherche"></div></div>
';

?>
</body>
</html>
