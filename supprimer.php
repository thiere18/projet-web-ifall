<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/stylesupp.css">
    <title>Suppression images</title>
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
                    <a class="nav-link" href="index.php">Page d'accueil</a>
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
        <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">Selectionner le(s) image(s) à supprimer</h1>
        <hr class="mt-2 mb-5">
        <?php

            // Connexion base de donnée et requête
            require "dbconnexion.php";
            $query = "SELECT url FROM image;";
            $result = mysqli_query($conn,$query);
            $i = 1;
        ?>
        <form action="del.php" method="POST">
            <!-- Demande dans formulaire invitant user à cocher l'image à supprimer -->
            <div class="row text-center text-lg-left">
                <?php
                    // Affichage des images
                    while($row = mysqli_fetch_assoc($result)) {?>
                        <div class="col-md-3">
                            <div class="img-thumbnail">
                                <input type="checkbox" name="photo[]" id="photo<?= $i;?>" value="<?= $row['url'];?>">
                                <label for="photo<?= $i;?>">
                                    <img src="<?= $row['url'];?>" alt="image <?= $i;?>">
                                </label>
                            </div>
                        </div>
                        <?php $i++;?>
                    <?php }
                ?>
                <div id="submit">
                    <button class="btn btn-danger" type="submit" name="submit">
                        Supprimer
                    </button>
                </div>
            </div>
        </form>
    </div>

    
</body>
</html>