    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Add | ClickExchange </title>
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

	require './inc/config.php';
	// On prépare notre requete passante par "POST"
	if(isset($_POST['url']))
	{
		          // On récupère le champ 
                  $userid = $_SESSION['id'];
                  $url = $_POST['url'];
                  $msg = $_POST['msg'];
                  $site = $_POST['site'];
                  $type = $_POST['type'];
                   
                  // on prépare une date
                  $date = date("Y-m-d H:i:s");
                  $ip = $_SERVER['REMOTE_ADDR'];
                  

		// On vérifie que le champ est remplis
		if($url != "") {
		
			$link = $bdd->prepare("INSERT INTO link (userid,url,type,date,ip,msg,site) VALUES (?,?,?,?,?,?,?)");
			$link->execute(array($userid,$url,$type,$date,$ip,$msg,$site));
			
			echo '<div class="alert_good"><b>HEY !</b> Envoyé avec succès. </div></br>';

			$logs=$bdd->prepare('INSERT INTO logs (userid,type,description,ip,`date`) VALUES (?,?,?,?,?)');
            $logs->execute(array($_SESSION['id'],"account","Ajout par l'utilisateur d'un lien",$_SERVER['REMOTE_ADDR'],date('Y-m-d H:i:s')));

		} else {
		
			echo '<div class="alert_error"><b>AIE !</b> Oups un ou plusieurs champs sont vide.</div></br>';
			
		}
	
	}
	
?> 

 <form method="post" action="add">
 
            <div id="tkt">Type :</div>
            <select name="type" class="form-control">
            <option value="link">CashLink</option>
            <option value="aff">Lien Affiliation</option>
            </select>
            <div style="margin-top:10px"></div>
            
            <div id="tkt">Votre lien:</div> <div style="margin-bottom:5px;"></div>
            <input type="text" name="url"  class="form-control" placeholder="Indiquer le lien (EX: https://clickurl.eu)"/>
            <div style="margin-top:10px"></div>
            
            <div id="tkt">Nom du site:</div> <div style="margin-bottom:5px;"></div>
            <input type="text" name="site"  class="form-control" placeholder="Indiquer le nom du site ou va votre lien (EX: youtube)"/>
            <div style="margin-top:10px"></div>
            
            <div id="tkt">Description:</div> <div style="margin-bottom:5px;"></div>
            <input type="text" name="msg"  class="form-control" placeholder="Un courte description pour insisté les gens à cliqué"/>
            <div style="margin-top:10px"></div>
            
            

<input type="submit" value="Ajouter l'annonce" id="btn" style="width:100%; "/>
 </form>


</div>
</div>  <!-- BOX -->


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
<div id="txt">Attention ! @<?php echo $myData['username']; ?></div>
Tout abus du service entraînera un bannissement de ClickExchange.
</div><!-- box tab-->
</div>



</div>
</div> <!-- CONTENU -->

<?php require './inc/footer.php'; ?>

<?php } ?>
    
    
    </body>
    </body>
    </html>