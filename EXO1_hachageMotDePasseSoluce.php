<?php
session_start();

require "./ConnectionMySQL.php" ;
// Si il y a une entrée 'soumettre' comme clef dans la variable superglobale $_POST
// alors on valorise $utilisateur à la valeur correspondante à la clef identifiant
// si elle existe et à null sinon
// Pareil pour $password
// Autrement dit: si l'utilisateur a entré du texte pour le champ de formulaire
// ce texte va dans la variable utilisateur
// Et si il a saisi quelque chose dans le champ motDePasse ce texte va dans le
// variable $password

if (isset($_POST['soumettre'])){
    $utilisateur = (isset($_POST['identifiant'])) ? $_POST['identifiant'] : null;
    $numen = (isset($_POST['numen'])) ? $_POST['numen'] : null;
    $password = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : null;
    $passwordc = (isset($_POST['confmotDePasse'])) ? $_POST['confmotDePasse'] : null;
    $email = (isset($_POST['email'])) ? $_POST['email'] : null;
    $prenom = (isset($_POST['prenom'])) ? $_POST['prenom'] : null;
    $nom = (isset($_POST['nom'])) ? $_POST['nom'] : null;
    $telephone = (isset($_POST['tel'])) ? $_POST['tel'] : null;
}

if(!empty($utilisateur)&&!empty($password)&&!empty($numen)&&!empty($passwordc)&&!empty($email)&&!empty($prenom)&&!empty($nom)&&!empty($telephone)){

// hachage du mot de passe avec la fonction password_hash PHP et
// l'algorithme le plus fort PASSWORD_ARGON2ID
$hashDuMotDePasse = password_hash($password, PASSWORD_DEFAULT);

$connection = getConnection();
$statement = $connection->prepare("INSERT INTO COMPTES(identifiant,numen,motDePasse, nom, prenom, email, telephone) VALUES(:identifiant,:numen,:motDePasse,:nom,:prenom,:email,:telephone)");

$statement->bindParam(':identifiant', $utilisateur, PDO::PARAM_STR);
$statement->bindParam(':numen', $numen, PDO::PARAM_STR);
$statement->bindParam(':motDePasse', $hashDuMotDePasse, PDO::PARAM_STR);
$statement->bindParam(':nom', $nom, PDO::PARAM_STR);
$statement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
$statement->bindParam(':email', $email, PDO::PARAM_STR);
$statement->bindParam(':telephone', $telephone, PDO::PARAM_STR);

$statement->execute() ;

$_SESSION['utilisateur']=$utilisateur ;
$_SESSION['estValide']=true ;

// header('Location: ../vues/EXO3_sessionsForEver.php');    
}

else
{
session_destroy();
// header('Location: ../vues/inscription.htm');    
exit();
}
