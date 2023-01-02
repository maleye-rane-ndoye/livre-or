<?php
include 'config.php';
session_start();
$login = $_SESSION['login'];
if(isset($_POST['update_profile'])){
    $update_prenom = mysqli_real_escape_string($conn, $_POST['update_prenom']);
    $update_nom = mysqli_real_escape_string($conn, $_POST['update_nom']);
    $update_login = mysqli_real_escape_string($conn, $_POST['update_login']);
    mysqli_query($conn, "UPDATE `utilisateurs` SET prenom = '$update_prenom', nom = '$update_nom', login = '$update_login' WHERE id = '$login'")
     or die ('requette échouée');
    $update_password = $_POST['update_password'];
    $old_password = mysqli_real_escape_string($conn, md5($_POST['old_password']));
    $new_password = mysqli_real_escape_string($conn, md5($_POST['new_password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm_password']));

    if(!empty($old_password) || !empty($new_password) || !empty($confirm_password)){
       if($update_password != $old_password){
        $message[] = 'Ancien mot de passe incorrecte';       
    }elseif($new_password != $confirm_password){
        $message[] = 'Erreur veuillez confirmer avec le même mot de passe';  
    }else{
        mysqli_query($conn, "UPDATE `utilisateurs` SET password  = '$confirm_password' WHERE id = '$login'")or die ('requette échouée');
        $message[] = 'Mise à jour effectuer avec succès'; 
    }
    }
    @$update_image = $_FILES['update_image']['name'];
      @$update_image_size = $_FILES['update_image']['size'];
      @$update_image_tmp_name = $_FILES['update_image']['tmp_name'];
      $update_image_folder = 'uploaded_img/'.$update_image;

      if(!empty($update_image)){
        if($update_image_size > 2000000)
        $message[]= "La taille de l'image est trop large!";
      }else{
        $image_update_query = mysqli_query($conn, "UPDATE `utilisateurs` SET image = '$update_image' WHERE id = '$login'")or die ('requette échouée');
        if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
        }
        $message[] = ' Photo mise à jour effectuer avec succès'; 
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
    <title>Profile</title>
</head>
<body>
    <?php include'header.php';?>
    <div class="update-profile">
            <?php
                 $select = mysqli_query($conn, "SELECT * FROM `utilisateurs` WHERE id = '$login'") or die('requette échouée');
                 if(mysqli_num_rows($select) > 0){
                    $fetch = mysqli_fetch_assoc($select);
                 
            ?>
                 
            
            <form action="" method="POST" enctype="multipart/form-data">
                <?php
                 if($fetch['image'] == ''){
                    echo'<img src="avatar.jpg">';
                }else{
                    echo '<img src="uploaded_img/<?'.$fetch['image'].'?>">';
                }}
                ?>

                <div class="canva">
                    <div class="inputcanva">
                        <span>Utilisateur:</span>
                        <input type="text" name="update_nom" value="<?php echo $fetch['nom']?>" class="box">
                        <input type="text" name="update_prenom" value="<?php echo $fetch['prenom']?>" class="box">
                        <span>Votre identifiant:</span>
                        <input type="email" name="update_login" value="<?php echo $fetch['login']?>" class="box">
                        <span>changer votre photo de profile:</span>
                        <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                    </div>

                     <div class="inputcanva">
                     <span>changer votre mot de passe:</span>
                        <input type="hidden" name="update_password" value="<?php echo $fetch['password']?>">
                        <span>Ancien mot de passe</span>
                        <input type="password" name="old_password" placeholder="Entrer l'ancien mot de passe" class="box"">
                        <span>nouvelle mot de passe</span>
                        <input type="password" name="new_password" placeholder="Entrer le nouveau mot de passe" class="box"">
                        <span>confirmer le password</span>
                        <input type="password" name="confirm_password" placeholder="confirmer le nouveau mot de passe" class="box"">
                    </div>
                        
                </div>
                <input type="submit" value="Mettre à jour le profil" name="update_profile" class="button">
                <a href="session.php" class="delete-button">Retour</a>
            </form>
     </div>
     <?php include'footer.php';?>       
</body>
</html>