<?php
            require "dbconnexion.php";
            $query = "SELECT url FROM image;";
            $result = mysqli_query($conn,$query);
            $i = 1;        // Si le button du formulaire est soumit (existe)
        if (isset($_REQUEST["submit"])) {
            // Si des cages ont été cochées
            if (isset($_REQUEST["photo"])) {
                // Une boucle visant à prendre que les éléments cochés
                foreach ($_REQUEST["photo"] as $value) {
                    // Requête de suppression
                    $query2 = "DELETE FROM image WHERE url='$value'";
                    $path = $value;
                    // Si le fichier existe dans le système de fichier
                    if(file_exists($path)){
                        // Si ce n'est pas supprimé dans le serveur apache on le dit
                        if(!unlink($path)){
                            echo "Photo non supprimée.";
                        } else {
                            // Si oui on supprime aussi dans la base de donnée cette occurence
                            $result2 = mysqli_query($conn,$query2);
                            if ($result2) {
                                echo "La suppression a été effectuée avec succès";
                                $url = $_SERVER["HTTP_REFERER"];

                            }
                            header("Location:$url");
                        }
                    }
                }
            }
        }
        mysqli_close($conn);

    ?>