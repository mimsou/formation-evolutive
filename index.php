<?php
$valeur = $_POST;
if (!empty($valeur)) {
    echo "bonjour";
}
;

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
    <form action="./index.php" method="post">
      <label for="login">Login</label>
      <input value="" name="login" /><br />
      <label for="password">Password</label>
      <input value="" name="password" />
      <input type="submit" />
    </form>
  </body>
</html>
