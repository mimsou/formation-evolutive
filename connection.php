<?php

// declaré un objet de connection PDO
$db = new PDO(
    //chaine de caratére de descriotion de la connection
    'mysql:host=127.0.0.1;dbname=gestion',
    //user name
    'root',
    //Password
    'root',
    //tableau d'option pour la configuration de la connection
    array(
    )
);
