<?php

require_once "./connection.php";

//ovrire la session pour pouvoir recupéré la variable $_session
session_start();

//si la variable session de login n'existe pas alor faire un retour de redirection vers index.php
if (isset($_SESSION["login"]) == false) {
    header('Location: /client/index.php');
}

//declation d'une variable qui recoit les paramétre post venu du client
$valeur = $_POST;

$message = "";

//testé si la valeur du poste est bien remplie
// structure conditionel si l'expression entre paréthése est true le scripte entre accolade est executé
if (empty($valeur) == false) {

    $designation = $valeur["designation"];
    $responsable = $valeur["responsable"];
    $adresse = $valeur["adresse"];
    $tel = $valeur["tel"];

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
    ;

}

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
          <label for="designation"> Designation </label>
          <input type="text" name="designation" />

          <label for="responsable"> Responsable </label>
          <input type="text" name="responsable" />

          <label for="adresse"> Adresse </label>
          <input type="text" name="adresse" />

          <label for="tel"> Tel </label>
          <input type="text" name="tel" />

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
    echo "</tr>";
}
?>
    </tbody>
    </table>
      </div>
    </div>
  </body>
</html>
