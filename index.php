<?php

require_once "./connection.php";

//declation d'une variable qui recoit les paramétre post venu du client
$valeur = $_POST;

$message = "";

//testé si la valeur du poste est bien remplie
// structure conditionel si l'expression entre paréthése est true le scripte entre accolade est executé
if (empty($valeur) == false) {

    //recupéré la valeur du login a partir du tableau des poste
    $login = $valeur["login"];

    //recupéré la valeur du password a partir du tableau des poste
    $password = $valeur["password"];

    //Création d'une requette Sql pour la verification du login et mot de passe et recupéré le resultat dans la variable $resultat
    $resultat = $db->query("select * from gestion.user where login = '" . $login . "' and password = '" . $password . "'")->fetchAll();

    //on test si le resultat de la requete est vide si oui donc pas de connection
    if (empty($resultat) == false) {
        //ouvrire une session
        session_start();

        //definir une variable des session qui contien les infos de l'utilisateur
        $_SESSION["login"] = $resultat;

        //faire la redirection vers la page client a travers la fonction header
        header('Location: /client/clients.php');

    } else {
        $message = "Merci de verifier vos paramétres de connection";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
  </head>
  <body>
    <h1>Formulaire de login</h1>
    <div style="color:red"> <?php echo $message ?> </div>
    <form action="./index.php" method="post">
      <label for="login">Login</label>
      <input value="" name="login" /><br />
      <label for="password">Password</label>
      <input value="" name="password" />
      <input type="submit" />
    </form>
  </body>
</html>
