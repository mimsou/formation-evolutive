<?php

require_once "./connection.php";

//ovrire la session pour pouvoir recupéré la variable $_session
session_start();

//si la variable session de login n'existe pas alor faire un retour de redirection vers index.php
if (isset($_SESSION["login"]) == false) {
    header('Location: /client/index.php');
}

//declation d'une variable qui recoit les paramétre POST venu du client
$post = $_POST;
//declation d'une variable qui recoit les paramétre GET venu du client
$get = $_GET;

$message = "";

//testé si la valeur du poste est bien remplie
// structure conditionel si l'expression entre paréthése est true le scripte entre accolade est executé
if (empty($post) == false) {

    $designation = $post["designation"];
    $responsable = $post["responsable"];
    $adresse = $post["adresse"];
    $tel = $post["tel"];

    //si la valeur du champ id du formulaire dans l'imput hidden est renségné faire update au lieu d'insert
    if (empty($post["id"]) == false) {

        //faire l'update du client avec les information du formulaire
        $query = $db->query(
            "update gestion.clients  " .
            "set designation =  '" . $designation . "' , " .
            "  responsable =  '" . $responsable . "' , " .
            "  adresse =  '" . $adresse . "' , " .
            "  tel =  '" . $tel . "' " .
            " where id = " . $post["id"]
        );

        if ($query == false) {
            $message = "Erreur lors de l'update";
        } else {
            $message = "Clien mis à jour avec sucsses";
        }

    } else {

        //faire l'insert des donnée envoyer depuis le formulaire
        $query = $db->query(
            "insert into gestion.clients values(null, " .
            "'" . $designation . "' , " .
            "'" . $responsable . "' , " .
            "'" . $adresse . "' , " .
            "'" . $tel . "' , " .
            "1" .
            ")"
        );

        if ($query == false) {
            $message = "Erreur lors de l'insertion";
        } else {
            $message = "Clien inserer avec sucsses";
        }

    }

}

//testé si la variable option existe dans la varable globale GET
if (isset($get["option"])) {

    $option = $get["option"];
    $id = $get["id"];

    //selon la valeur de la varable $option on va executé différents traitements
    switch ($option) {
        case "edit":
            $client = $db->query("select * from gestion.clients where id =" . $id)->fetch();
            break;
        case "delete":
            $client = $db->query("delete from gestion.clients where id =" . $id)->fetch();
            break;
        default:;
            break;
    }

}

// recupéré la liste des clients
$liste = $db->query("select * from gestion.clients")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css">
    <title>Client</title>
  </head>
  <body>


      <div class="info-containe"><?php echo $message; ?></div>



    <div class="main-container">
      <div class="form-container">
        <form action="./clients.php" method="post"  class="client-form">

          <input type="hidden"  name="id" <?php if (isset($client)) {echo 'value="' . $client["id"] . '"';}
;?>  >

          <label for="designation"> Designation </label>


          <input type="text" name="designation" <?php if (isset($client)) {echo 'value="' . $client["designation"] . '"';}
;?> />

          <label for="responsable"> Responsable </label>
          <input type="text" name="responsable" <?php if (isset($client)) {echo 'value="' . $client["responsable"] . '"';}
;?>  />

          <label for="adresse"> Adresse </label>
          <input type="text" name="adresse" <?php if (isset($client)) {echo 'value="' . $client["adresse"] . '"';}
;?>  />

          <label for="tel"> Tel </label>
          <input type="text" name="tel" <?php if (isset($client)) {echo 'value="' . $client["tel"] . '"';}
;?>  />

          <input type="submit" />
        </form>
      </div>





      <div class="list-container">
      <table class="list-table">
          <thead>
              <tr>
              <th>Designation</th>
              <th>Responsable</th>
              <th>Adress</th>
              <th>Tel</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php
foreach ($liste as $line) {

    echo "<tr>";
    echo "<td>" . $line["designation"] . "</td>";
    echo "<td>" . $line["responsable"] . "</td>";
    echo "<td>" . $line["adresse"] . "</td>";
    echo "<td>" . $line["tel"] . "</td>";
    echo "<td>
    <a class='modifier-lien' href='./clients.php?option=edit&id=" . $line["id"] . "' >Modifier </a>
     <a class='modifier-lien' href='./clients.php?option=delete&id=" . $line["id"] . "' >Supprimer</a>
    </td>";
    echo "</tr>";

}

?>

    </tbody>
    </table>
      </div>
    </div>
  </body>
</html>
