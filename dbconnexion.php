<?php

    $conn = mysqli_connect("immo.cplswart70z6.us-east-1.rds.amazonaws.com", "admin", "adminImmobilier", "biblio");
    if (!$conn) {
        echo "Erreur : Impossible de se connecter à MySQL." ;
        exit;
    }
    
?>