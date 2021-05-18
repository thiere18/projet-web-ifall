<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Ajout de photos</title>
</head>
<body>
    <!-- Menu de navigation en haut de page -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Page d'accueil</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="all.php">Afficher touts les images<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="affichage.php">Affichage par page<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ajouter.php">Ajouter des images</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="supprimer.php">Supprimer des images</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">Ajout d'image</h1>
        <hr class="mt-2 mb-5">

        <!-- Tableau d'un formulaire demandant à renseigner un fichier image -->
        <form action="" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Insersion</legend>
                <div>
                    <label for="file">Insérer image : </label>
                    <input type="file" name="file">
                </div>
                <div class="button">
                    <input type="submit" name="submit" id="submit">
                </div>
            </fieldset>
        </form>
    </div>

    <?php
        // Si soumission du formulaire par clic du bouton
        if (isset($_REQUEST["submit"])) {
            
            // Si erreur rencontrée affichage massage d'erreur approprié
            if ($_FILES["file"]["error"]) {
                switch ($_FILES["file"]["error"]) {
                    case 1: // UPLOAD_ERR_INI_SIZE
                    echo "Le fichier dépasse la limite autorisée par le serveur (fichier php.ini) !";
                    break;
                    case 2: // UPLOAD_ERR_FORM_SIZE
                    echo "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
                    break;
                    case 3: // UPLOAD_ERR_PARTIAL
                    echo "L'envoi du fichier a été interrompu pendant le transfert !";
                    break;
                    case 4: // UPLOAD_ERR_NO_FILE
                    echo "Le fichier que vous avez envoyé a une taille nulle !";
                    break;
                }
            } else if(isset($_FILES["file"])){
                // Liste les extensions acceptées
                $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");

                $filename = $_FILES["file"]["name"];
                $filetype = $_FILES["file"]["type"];
                $filesize = $_FILES["file"]["size"];
                $filetmp_name = $_FILES["file"]["tmp_name"];
        
                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");
        
                // Vérifie la taille du fichier - 5Mo maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");
        
                // Vérifie le type MIME du fichier
                if(in_array($filetype, $allowed)){
                    // Vérifie si le fichier existe avant de le télécharger.
                    if(file_exists("./images/".$filename)){
                        echo $filename." existe déjà.";
                    } else{
                        //Si le transfert se passe sans problème
                        if (move_uploaded_file($filetmp_name, "./images/".$filename)) {
                            // Connexion à la base de donnée et requête à faire
                            require "dbconnexion.php";
                            $query = "INSERT INTO image(url) VALUES('./images/$filename');";
                            $result = mysqli_query($conn,$query);
                            // Si la requête a bien été faite
                            if ($result) {
                                //Rien à signaler;
                            } else {?>
                                <script>
                                    alert("Erreur : <?= $query . mysqli_error($conn)?>");
                                </script>
                            <?php }
                            mysqli_close($conn);
                        } else {?>
                            <script>
                                alert("Le fichier n'a pas été uploadé. Réessayer ultérieurement !");
                            </script>
                        <?php }
                    } 
                } else{
                    echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
                }
            } else{
                echo "Error: " . $_FILES["file"]["error"];
            }
        }


    ?>

</body>
</html>