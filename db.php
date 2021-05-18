<?php
try {
    $user="admin";
    $pass="adminImmobilier";
    $pdo = new PDO('mysql:host=immo.cplswart70z6.us-east-1.rds.amazonaws.com;dbname=image;charset=utf8', $user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}
catch(Exception $e) {
    echo 'Exception -> ';
    var_dump($e->getMessage());
}