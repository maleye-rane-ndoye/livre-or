
<?php

include 'config.php';
session_start();
$login = $_SESSION['login'];;
if(!isset($login)){
    header('location:connexion.php');
}
if(isset($_GET['deconnexion'])){
    unset($login);
    session_destroy();
    header('location:connexion.php');
}

$select = mysqli_query($conn, "SELECT * FROM `utilisateurs`") or die('requette échouée');
if(mysqli_num_rows($select) > 0){
   $fetch = mysqli_fetch_assoc($select);
}


$print_user = ("SELECT * FROM `utilisateurs`");
if(mysqli_num_rows($select) > 0){
  $req = $conn->query($print_user);
  $users = $req->fetch_all();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylle.css">
    <title>Admine page</title>
</head>
<body>
         <?php include'header.php';?>
         <div class="container">
           
            <div class="content">
                <h3>Bonjour, <span>Admin <?php echo $fetch['prenom']?></span></h3>
                <h1>Bienvenue <span>sur la page administrateur</span></h1>
                
                <a href="connexion.php" class="button">Se connecter</a>
                <a href="inscription.php" class="button"> S'inscrir</a>
                <a href="session.php?deconnexion=<?php echo $login;?>" class="delete-button">Déconnexion</a>
            </div>
        </div>
         
        <table class="table">
             <thead>
                    <tr>
                          <th scope="col">utilisateur</th>
                          <th scope="col">Prénom</th>
                          <th scope="col">Nom</th>
                          <th scope="col">Login</th>
                    </tr>
             </thead>
             <tbody>
                <?php foreach($users as $champ):?>
                
                       <tr>
                          <th scope="row"></th>
                          <td><?=$champ["prenom"]?></td>
                          <td><?=$champ['nom']?></td>
                          <td><?=$champ['login']?></td>
                       </tr>
                 <?php endforeach; 
                 ?>
            </tbody>
    
        </table>
        <?php include'footer.php';?>

</body>
</html>