<?php

    define('HOST', 'immo.cplswart70z6.us-east-1.rds.amazonaws.com');
    define('DB_NAME', 'image');
    define('USER', 'admin');
    define('PASS', 'adminImmobilier');

    try{
        $db = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
        echo $e;
    }
    // On détermine sur quelle page on se trouve
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }else{
        $currentPage = 1;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Affichage Pagination</title>
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
        <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">Affichage des images</h1>
        <hr class="mt-2 mb-5">
        <?php

            // On détermine le nombre total de photos
            $sql = "SELECT COUNT('url') AS nb_images FROM image;";
            $query = $db->prepare($sql);
            $query->execute();
            $result = $query->fetch();
            $nbImages = (int) $result['nb_images'];
            if ($nbImages != 0) {
                $parPage = 8;
                $pages = ceil($nbImages / $parPage);
                $premier = ($currentPage * $parPage) - $parPage;
                $sql = "SELECT url FROM image ORDER BY created_at ASC LIMIT :premier, :parpage;";
                $query = $db->prepare($sql);
                $query->bindValue(':premier', $premier, PDO::PARAM_INT);
                $query->bindValue(':parpage', $parPage, PDO::PARAM_INT);
                $query->execute();
                $urls = $query->fetchAll(PDO::FETCH_ASSOC);
                $i = 1;

                // Affichage d'un conteneur avec les informations à recueillir (url)
                ?><div class="row text-center text-lg-left"><?php
                    foreach($urls as $url) {
                        ?>
                        <!-- Affichage images dans cellules -->
                        <div class="col-md-3">
                            <div class="img-thumbnail">
                                <img src="<?= $url['url']; ?>" alt="image <?= $i;?>">
                            </div>
                        </div>
                        <?php $i++;?>
                    <?php } ?>
                </div>
                
                <br>
                <nav>
                    <ul class="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="affichage.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                            <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="affichage.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                            <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                            <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="affichage.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
            <?php }
            else {
                echo "<h1>Aucune images n'a été uploadée!<br>Veuillez envoyer des images svp</h1>";
            } ?>
    </div>
    
</body>
</html>