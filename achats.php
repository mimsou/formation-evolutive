<?php

require_once "./connection.php";

//ovrire la session pour pouvoir recupéré la variable $_session
session_start();

//si la variable session de login n'existe pas alor faire un retour de redirection vers index.php
if (isset($_SESSION["login"]) == false) {
    header('Location: /client/index.php');
}

$listeCliensActif = $db->query("select * from gestion.clients where etat = 1")->fetchAll();

//declation d'une variable qui recoit les paramétre POST venu de l'achats
$post = $_POST;
//declation d'une variable qui recoit les paramétre GET venu de l'achats
$get = $_GET;

$message = "";

//testé si la valeur du poste est bien remplie
// structure conditionel si l'expression entre paréthése est true le scripte entre accolade est executé
if (empty($post) == false) {

    $client = $post["client"];
    $article = $post["article"];
    $qte = $post["qte"];
    $prix = $post["prix"];

    //si la valeur du champ id du formulaire dans l'imput hidden est renségné faire update au lieu d'insert
    if (empty($post["id"]) == false) {

        //faire l'update de l'achat avec les information du formulaire
        $query = $db->query(
            "update gestion.achats  " .
            "set article =  '" . $article . "' , " .
            "  qte =  '" . $qte . "' , " .
            "  prix =  '" . $prix . "' , " .
            "  client =  '" . $client . "' " .
            " where id = " . $post["id"]
        );

        if ($query == false) {
            $message = "Erreur lors de l'update";
        } else {
            $message = "Achat mis à jour avec sucsses";
        }

    } else {

        //faire l'insert des donnée envoyer depuis le formulaire
        $query = $db->query(
            "insert into gestion.achats values(null, " .
            "'" . $article . "' , " .
            "'" . $qte . "' , " .
            "'" . $prix . "' , " .
            "'" . $client . "'  " .
            ")"
        );

        if ($query == false) {
            $message = "Erreur lors de l'insertion";
        } else {
            $message = "Achat inserer avec sucsses";
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
            $achat = $db->query("select * from gestion.achats where id =" . $id)->fetch();
            break;
        case "delete":
            $achat = $db->query("delete from gestion.achats where id =" . $id)->fetch();
            break;
        default:;
            break;
    }

}

// recupéré la liste des achats
$liste = $db->query("select a.id as idachat , a.article, a.qte , a.prix , b.designation   from gestion.achats as a  join gestion.clients as b on a.client = b.id ")->fetchAll();

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
        <form action="./achats.php" method="post"  class="client-form">

          <input type="hidden"  name="id" <?php if (isset($achat)) {echo 'value="' . $achat["id"] . '"';}
;?>  >

<label for="client"> Client </label>


   <select name="client"  >

     <?php
foreach ($listeCliensActif as $client) {

    //faire la selection du client a partir des donnée envoyer pour l'edition
    if ($client["id"] == $achat["client"]) {
        $selected = "selected";
    } else {
        $selected = "";
    }

    echo "<option " . $selected . "  value=" . $client["id"] . "  >" . $client["designation"] . "</option>";
}
?>
   </select>

          <label for="article"> article </label>


          <input type="text" name="article" <?php if (isset($achat)) {echo 'value="' . $achat["article"] . '"';}
;?> />

          <label for="qte"> Qte </label>
          <input type="text" name="qte" <?php if (isset($achat)) {echo 'value="' . $achat["qte"] . '"';}
;?>  />

          <label for="prix"> prix </label>
          <input type="text" name="prix" <?php if (isset($achat)) {echo 'value="' . $achat["prix"] . '"';}
;?>  />



          <input type="submit" />
        </form>
      </div>





      <div class="list-container">
      <table class="list-table">
          <thead>
              <tr>
              <th>Article</th>
              <th>Qte</th>
              <th>Prix</th>
              <th>Prix totale </th>
              <th>Client</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          <?php

foreach ($liste as $line) {

    $totale = $line["prix"] * $line["qte"];

    echo "<tr>";
    echo "<td>" . $line["article"] . "</td>";
    echo "<td>" . $line["qte"] . "</td>";
    echo "<td>" . $line["prix"] . "</td>";
    echo "<td>" . $totale . "</td>";
    echo "<td>" . $line["designation"] . "</td>";
    echo "<td>
    <a class='modifier-lien' href='./achats.php?option=edit&id=" . $line["idachat"] . "' >Modifier </a>
     <a class='modifier-lien' href='./achats.php?option=delete&id=" . $line["idachat"] . "' >Supprimer</a>
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
