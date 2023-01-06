<?php

    require_once(__DIR__."/../bootstrap.php");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET["username"])) {
            header('Content-Type: application/json');
            echo(json_encode($dbh->usernameIsAvailable(trim($_GET["username"]))));
        } else {
            internalServerError("E' necessario fornire l'username da controllare");
        }

    } else {
        internalServerError("Sono accettate solo richieste GET");
    }

?>
