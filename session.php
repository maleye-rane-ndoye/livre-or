<?php

include 'config.php';
session_start();
$login = $_SESSION['login'];
if(!isset($login)){
    header('location:connexion.php');
}
if(isset($_GET['deconnexion'])){
    unset($login);
    session_destroy();
    header('location:connexion.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylle.css">
    <title>Profile</title>
</head>
<body>
    <?php include'header.php';?>
    <div class="container">
        <div class="profile">
            <?php
                 $select = mysqli_query($conn, "SELECT * FROM `utilisateurs` WHERE id = '$login'") or die('requette échouée');
                 if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                 
                    if($fetch['image'] == ''){
                       echo'<img src="avatar.jpg">';

                   }else{
                       echo '<img src="uploaded_img/'.$fetch['image'].'">';
                 }

                } 
            ?>

                
                <h3><?php echo $fetch['nom'];?></h3>
                
                <?php
                
                     if($fetch['user_type'] == 'admin'){
                        echo'<a href="admin.php" class="button">Page administration</a>';
                
                    }else{
                        echo '';
                      }
                ?>
                <a href="profile.php" class="button">Mettre à jour le profil</a>
                <a href="livre-or.php" class="button">Livre d'or</a>
                <a href="session.php?deconnexion=<?php echo $login;?>" class="delete-button">Déconnexion</a>
                <p>nouvelle <a href="connexion.php">Connexion</a> ou  <a href="inscription.php">Inscription</a></p>
                </div>
                </div>
                <?php include'footer.php';?>
</body>
</html>



