<?php
     include 'config.php';
     session_start();

     if(isset($_POST['authentification'])){

      $login = mysqli_real_escape_string($conn, $_POST['login']);
      $password = mysqli_real_escape_string($conn, md5($_POST['password']));
     
      $select = mysqli_query($conn, "SELECT * FROM `utilisateurs` WHERE login = '$login' AND password = '$password'") or die('requette échouée');
        if(mysqli_num_rows($select) > 0){
           $row = mysqli_fetch_assoc($select);
            //$_SESSION['login'] = $login ;
           $_SESSION['login'] = $row['id'];
           header('location:session.php');
        }else{
            $message[] = 'Identifiant ou mot de passe incorrecte';
        }




     }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylle.css">
    <title>Connexion</title>
</head>
<body>
       <?php include'header.php';?>
       <div class="form-container">
         <form action="" method="POST" enctype="multipart/form-data">
            <h3>Se connecter</h3>
            <?php
            if(isset($message)){
              foreach($message as $message){
                   echo '<div class="message">'.$message.'</div>';}
                  
            }
                ?>
            <input type="text" name="login" placeholder="Entrer votre identifiant" class="box" required>
            <input type="password" name="password" placeholder="Entrer votre mot de passe" class="box" required>
            
            <input type="submit" name="authentification" value="Se connecter" class="button">
            <p>Je ne suis pas inscrit <a href="inscription.php">S'inscrir maintenant</a></p>
          </form>
        </div>

        <?php include'footer.php';?>


</body>
</html>