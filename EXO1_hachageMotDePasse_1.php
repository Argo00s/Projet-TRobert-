<?php
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
    $numenu = (isset($_POST['ID_NUMEN'])) ? $_POST['ID_NUMEN'] : null;
    $password = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : null;
    $passwordc = (isset($_POST['confmotDePasse'])) ? $_POST['confmotDePasse'] : null;
    $mail = (isset($_POST['email'])) ? $_POST['email'] : null;
    $prenomu = (isset($_POST['prenom'])) ? $_POST['prenom'] : null;
    $nomu = (isset($_POST['nom'])) ? $_POST['nom'] : null;
    $telu = (isset($_POST['tel'])) ? $_POST['tel'] : null;



}

if(!empty($utilisateur)&&!empty($password)){

// hachage du mot de passe avec la fonction password_hash PHP et
// l'algorithme le plus fort PASSWORD_ARGON2ID
$hashDuMotDePasse = password_hash($password, PASSWORD_DEFAULT);
$hashDuMotDePasse = password_hash($passwordc, PASSWORD_DEFAULT);

$connection = getConnection();
$statement = $connection->prepare("INSERT INTO COMPTES(identifiant,ID_NUMEN,motDePasse,email,prenom,nom,tel) VALUES(:identifiant,:id_numen,:motDePasse,:email,:prenom,:nom,:tel)");

$statement->bindParam(':identifiant', $utilisateur, PDO::PARAM_STR);
$statement->bindParam(':id_numen', $numenu, PDO::PARAM_STR);
$statement->bindParam(':motDePasse', $hashDuMotDePasse, PDO::PARAM_STR);
//$statement->bindParam(':confmotDePasse', $hashDuMotDePasse, PDO::PARAM_STR);
$statement->bindParam(':email', $mail, PDO::PARAM_STR);
$statement->bindParam(':prenom', $prenomu, PDO::PARAM_STR);
$statement->bindParam(':nom', $nomu, PDO::PARAM_STR);
$statement->bindParam(':tel', $telu , PDO::PARAM_STR);
$statement->execute();

echo '<script type="text/javascript">alert("Données enregistrées avec succès"); </script>';  

}

else
{
    echo '<script type="text/javascript">alert("Vous devez remplir tous les champs"); </script>';
    }

