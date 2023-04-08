    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>View | ClickExchange </title>
    <link href="./assets/style.css" rel="stylesheet">
    <meta name="author" content="BEOSMO" />
    <meta name="revisit-after" content="15" />
    <meta name="language" content="FR" />
    <meta name="copyright" content="2020" />

    <meta name="theme-color" content="#005A82">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />
    
    <!-- CSS / Style -->
    <script src="https://kit.fontawesome.com/5b4181b8ea.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    </head>
    <body>
    <?php require './inc/config.php'; ?>
    
<?php if ($_SESSION['id']==0) { ?>
<meta http-equiv="refresh" content="0;URL=index">
<?php } else { ?>

<?php require './inc/menu.php'; ?>


<div class="container">
<div class="row">

<div style="margin-top:40px"></div>

<div class="col-xl-8 col-md-6 mb-8"> 
<div id="box">

<?php 
    if(isset($_GET['id']) AND $_GET['id']) {
   
                $g_key = $_GET['id'];
		$getData = $bdd->prepare('SELECT * FROM link WHERE id = ?');
		$getData->execute(array($g_key));

		if($getData->rowCount() == 1) {

			$data_key = $getData->fetch();

			
	}
	}


 ?>

<a href="<?php echo $data_key['url']; ?>"  target="_blank" id="sayme"><i class="fas fa-external-link-alt"></i> Visiter maintenant</a>
<br>

<b>Site web d'origne:</b> <?php echo $data_key['site']; ?><br>
<b>Description du lien:</b> <?php echo $data_key['msg']; ?><br>
<b>Posté le:</b>  <?php echo date('d/m/Y H:i', strtotime($data_key['date'])); ?>


<?php
$req = $bdd->prepare('SELECT * FROM link WHERE id = ? AND userid = ?');
$req->execute(array($g_key,$_SESSION['id']));
while ($idata = $req->fetch()) { 	
?>

</br></br>
<div id="box_info">
<?php if($data_key['hide'] == '1') { ?> <a href="hideout?id=<?php echo $data_key['id']; ?>" id="btnkey"><i class="fas fa-eye"></i> Démasqué </a> <?php } ?> 
<?php if($data_key['hide'] == '0') { ?> <a href="hide?id=<?php echo $data_key['id']; ?>"  id="btnkey"><i class="fas fa-low-vision"></i> Masqué </a> <?php } ?> 

<div style="margin-bottom:5px"></div>
<div style="margin-left:5px;">
<small><i class="far fa-eye"></i> Option pour désactivé l'annonce.</small>
</div>
</div>
<?php } ?>

</div>
</div> <!-- BOX -->


<div class="col-xl-4 col-md-6 mb-4"> 
<div id="box">
<center>
<img src="<?php echo $myData['avatar']; ?>" id="pp_profil"/>
<div style="margin-top:5px;"></div>
<div id="txt" style="color:black;">Hey, @<?php echo $myData['username']; ?></div>
<small><i class="fas fa-paper-plane"></i> <?php echo $myData['email']; ?></small>
</center>
</div>

</br>

<div id="box_tab">
<div id="txt">Affiliation</div>
N'hésite pas à partager ClickExchange à tout tes amis avec ton lien affiliation.

<div style="margin-top:10px;"></div>
<input type="text" class="form-control" value="https://clickexchange.fr?ref=<?php echo $myData['username']; ?>">

</div></div>


</div></div> <!-- CONTENU -->

</br></br></br>
<?php require './inc/footer.php'; ?>



<?php } ?>
    
    
  
    </body>
    </html>