<?php

    require_once(__DIR__."/../bootstrap.php");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET["email"])) {
            header('Content-Type: application/json');
            echo(json_encode($dbh->emailIsAvailable(trim($_GET["email"]))));
        } else {
            internalServerError("E' necessario fornire l'e-mail da controllare");
        }

    } else {
        internalServerError("Sono accettate solo richieste GET");
    }

?>
