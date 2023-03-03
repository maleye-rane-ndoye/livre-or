<?php
     include 'config.php';
     if(isset($_POST['Envoyer'])){
      $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
      $nom = mysqli_real_escape_string($conn, $_POST['nom']);
      $login = mysqli_real_escape_string($conn, $_POST['login']);
      $password = mysqli_real_escape_string($conn, md5($_POST['password']));
      $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
      $message[] = '';
      $select = mysqli_query($conn, "SELECT * FROM `utilisateurs` WHERE login = '$login' AND password = '$password'") or die('requette échouée');
        if(mysqli_num_rows($select) > 0){
           $message[] = 'Utilisateur déja existant';
        }else{
          if($password != $cpassword){
            $message[] = 'mots de passe non identiques';
          }else{
            $insert = mysqli_query($conn, "INSERT INTO `utilisateurs`(login, password, nom, prenom) VALUES('$login', '$password', '$nom', '$prenom')")
             or die('requette échouée');
            if($insert){
              header('location:connexion.php');
            }else{
              $message[] = 'Inscription échouée';
            }
          }
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
    <title>Inscription</title>
</head>

<body> 
       <?php include'header.php';?>
       <div class="form-container">
         <form action="" method="POST" enctype="multipart/form-data">
            <h3>S'inscrir maintenant</h3>
            <?php
            if(isset($message)){
              foreach($message as $message){
                   echo '<div class="message">'.$message.'</div>';}}
           ?>
            <input type="text" name="prenom" placeholder="Entrer votre Prénom" class="box" required>
            <input type="text" name="nom" placeholder="Entrer votre Nom" class="box" required>
            <input type="text" name="login" placeholder="Entrer votre identifiant" class="box" required>
            <input type="password" name="password" placeholder="Entrer votre mot de passe" class="box" required>
            <input type="password" name="cpassword" placeholder="confirmer votre mot de passe" class="box" required>
            <input type="submit" name="Envoyer" value="Envoyer" class="button">
            <p>Déja inscrit ? <a href="connexion.php">Se connecter maintenant</a></p>
          </form>
        </div>
        <?php include'footer.php';?>
</body>
</html>