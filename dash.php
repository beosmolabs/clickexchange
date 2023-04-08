    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Dashboard | ClickExchange </title>
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

if(isset($_GET['clientid'])) {
  $g_clientid = htmlspecialchars($_GET['clientid']);

  $checkClientExist = $bdd->prepare('SELECT id FROM users WHERE id = ?');
  $checkClientExist->execute(array($g_clientid));
    $rowc_ClientExist = $checkClientExist->rowCount();

  if($rowc_ClientExist == 1) {
    $data_ClientLogs = $checkClientExist->fetch();
  }
  else {
    header('Location: dash');
    exit;
    die;
  }
}

$messagesParPage=30; //Nous allons afficher 5 messages par page.
 
//Une connexion SQL doit être ouverte avant cette ligne...
    if(isset($data_ClientLogs)) {
      $retour_total = $bdd->prepare('SELECT COUNT(*) AS total FROM link WHERE userid = ?'); //Nous récupérons le contenu de la requête dans $retour_total
      $retour_total->execute(array($data_ClientLogs['id']));
    }
    else {
      $retour_total = $bdd->prepare('SELECT COUNT(*) AS total FROM link WHERE hide = ?'); //Nous récupérons le contenu de la requête dans $retour_total
      $retour_total->execute(array("0"));
    }
$donnees_total = $retour_total->fetch(); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
 
//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);
 
if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);
 
     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1    
}
 
$premiereEntree=($pageActuelle-1)*$messagesParPage; // On calcul la première entrée à lire

?>

<table id="customers">
<thead>
          <tr>
            
            
     
            <th>Lien</th>
            <th>Par </th>
            <th>+ d'infos</th> 
          </tr>
        </thead>
<?php
  if(isset($data_ClientLogs)) {
    $retourreq = $bdd->prepare('SELECT * FROM link WHERE hide = ? ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
    $retourreq->execute(array('0'));
  }
  else {
    $retourreq = $bdd->prepare('SELECT * FROM link WHERE hide = ? ORDER BY id DESC LIMIT '.$premiereEntree.', '.$messagesParPage.'');
    $retourreq->execute(array('0'));
  }
while ($news = $retourreq->fetch()) { 
    $getUserName = $bdd->prepare('SELECT username,email FROM users WHERE id = ?');
    $getUserName->execute(array($news['userid']));
      $rowc_getUN = $getUserName->rowCount();

      if($rowc_getUN == 1) {
        $d_UserName = $getUserName->fetch();
      }
?>

<tbody>
          <tr>
           
            
            
            
            <td><?php if($news['type'] == 'link') { ?>  <i class="fas fa-dollar-sign"></i>&nbsp; <?php } ?><?php if($news['type'] == 'aff') { ?>  <i class="fas fa-user-plus"></i>&nbsp; <?php } ?> <a href="<?php echo $news['url']; ?>" target="_blank"><?php echo $news['url']; ?></a></td>
            <td><?php echo $d_UserName['username']; ?></td>
            <td><a href="./view-<?php echo $news['id']; ?>"><i class="fas fa-eye"></i> Voir</a></td>
          </tr>
         </tbody>


<?php }
?></table>



</div> <!-- BOX -->
</div>

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

</div>

</div>



</div> 
</div> <!-- CONTENU -->

</br></br></br>
<?php require './inc/footer.php'; ?>

<style>
#customers {
  border-collapse: collapse;
  width: 100%;
  -webkit-border-top-left-radius: 15px;
-webkit-border-top-right-radius: 15px;
-moz-border-radius-topleft: 15px;
-moz-border-radius-topright: 15px;
border-top-left-radius: 15px;
border-top-right-radius: 15px;
}

#customers td, #customers th {
  border-bottom: 1px solid #ddd;
  padding: 10px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color:#2c3e50;
  color: white;
  
 
}
</style>

<?php } ?>
    
    
  
    </body>
    </html>