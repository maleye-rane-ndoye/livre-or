<?php
include 'config.php';
session_start();

$requ_comm_all = $conn->query("SELECT prenom, commentaire, date FROM utilisateurs 
INNER JOIN commentaires ON utilisateurs.id = commentaires.id  ORDER BY date DESC;");

$requ_cita_all = $conn->query("SELECT auteur, commentaire FROM citations 
INNER JOIN commentaires ON citations.id = commentaires.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>livre or</title>
</head>
<body>
    <?php include'header.php';?>    
    
    <main>
    <div >

         <h1>Le livre d'Or</h1><br>
         

<?php
          $conn->set_charset("utf8");
          $requ_citations= "SELECT auteur, citation, commentaire, date FROM citations 
          INNER JOIN commentaires ON citations.id = commentaires.id";
          $resultat = $conn->query($requ_citations);
          while ($ligne = $resultat->fetch_assoc()){
            echo "Citation:".$ligne['citation'] . '<br/>' ."Auteur:". $ligne['auteur'].'<br/>' ."commentaire:"."<br/>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp".
            $ligne['commentaire']."&nbsp;&nbsp".$ligne['date']."<br/><br/><br/>";
		}
    
?>
         
    </div>


    <?php   // Si utilisateur connecté, possibilité de posté un commentaire.
    if (isset($_SESSION['login'])) { 
        $login = $_SESSION['login'];
       
        if (isset($_GET['submit'])){
            require 'config.php';
            $commentaire = addslashes(htmlspecialchars($_GET['commentaire']));
            $compt_len = strlen($commentaire);
            if ($compt_len > 6){
            
            //  recupirer la date du poste
            $requ_inser = $conn->query("INSERT INTO `commentaires`(`commentaire`, `date`) VALUES ('$commentaire',NOW());");
            $mess_inser = 'Votre message est bien enregistré !';
        } else {
                $err_comm = 'Votre commentaire est trop court -Minimum 6 caractère!';
        }
        }
        ?>
         <?php 
             if (isset($_SESSION['login'])) { 
                $login = $_SESSION['login'];
               
                if (isset($_GET['submit'])){
        
                    //  connexion BD.
                    require 'config.php';
                
                    // le commentaire.
                    $citation = addslashes(htmlspecialchars($_GET['citation']));
                    $auteur = addslashes(htmlspecialchars($_GET['auteur']));
                    $requ_citation = $conn->query("INSERT INTO `citations`(citation, auteur) VALUES ('$citation','$auteur')");
                    
           }
        }
         ?>
         <div class="form-container">

         <p><?php ?></p>

            <form action="#" type="get">
            <p><?php

            if (isset($mess_inser)) {
                echo $mess_inser;
            }
            if (isset($err_comm)) {
                echo $err_comm;
            } ?>
            <label for="citation"> Votre Citation</label>
            <input type="textarea" name="citation" placeholder="Entrer votre citation" class="box" required><br>
            <label for="auteur"> Nom de l'auteur</label>
            <input type="text" name="auteur" placeholder="Entrer le nom de l'auteur" class="box" required><br>
            <label for="commentaire">Votre Commentaire</label>
            <input type="textarea" name="commentaire" placeholder="Entrer Votre Commentaire ici" class="box">
            <input type="submit" name="submit" value="Envoyer" class="button">
            <a href="session.php" class="delete-button">Retour</a>
        </form>
        </div>
    <?php }?>
</main>

    <?php include'footer.php';?> 
</body>
</html>