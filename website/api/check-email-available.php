<?php

    require_once(__DIR__."/../bootstrap.php");

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET["email"])) {
            echo(json_encode($dbh->emailIsAvailable($_GET["email"])));
        } else {
            internalServerError("E' necessario fornire l'e-mail da controllare");
        }

    } else {
        internalServerError("Sono accettate solo richieste GET");
    }

?>
