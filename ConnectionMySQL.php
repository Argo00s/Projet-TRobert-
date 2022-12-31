<?php
    const UTILISATEUR="root";
    const MOTDEPASSE="";
    const SERVEUR="localhost";
    const BASEDEDONNEES="tenti";
    function getConnection(){
        $utilisateur = UTILISATEUR;
        $motDePasse = MOTDEPASSE;
        $server = SERVEUR;
        $db = BASEDEDONNEES;
        $accesBDD="mysql:host=$server;dbname=$db;port=3306" ;
        try {
            $connection = new PDO($accesBDD,$utilisateur,$motDePasse);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Échec lors de la connexion : ' . $e->getMessage();
        }
        return $connection;
    }
    function queryList($sql){
        $connection = getConnection();
        $instructions = $connection->prepare($sql);
        $instructions->execute();
        return $instructions;
    }


?>
