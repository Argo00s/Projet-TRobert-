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
    $password = (isset($_POST['motDePasse'])) ? $_POST['motDePasse'] : null;
}

if(!empty($utilisateur)&&!empty($password)){

$sql = "select identifiant, motDePasse from comptes where identifiant= ?" ;
$connection = getConnection();
$instructions = $connection->prepare($sql);
$instructions->bindParam(1, $utilisateur, PDO::PARAM_STR);
$instructions->execute();
$resultat = $instructions->fetchAll() ;
$hash = $resultat[0]["motDePasse"];
print_r($resultat);
echo($hash);
$vef = password_verify($password, $hash);
$loginValide=false;
if ($vef == true){
    $loginValide=true;
}

// Récupération ici du hash du mot de passe en provenance de la BDD situé dans $resultat

// Vérification avec la fonction PHP password_verify

// Si vérification valide, on affiche que l'utilisateur est bien loggé
if ($loginValide)
echo '<script type="text/javascript">alert("Utilisateur bien loggé"); </script>';  
else // Sinon on l'informe d'un problème
echo '<script type="text/javascript">alert("identifiant ou mot de passe invalide"); </script>';  

}

else
{
    echo '<script type="text/javascript">alert("Vous devez remplir tous les champs"); </script>';
    }

