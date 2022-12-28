<?php
    require_once("inc/php/utils.php");
    require_once("inc/php/session.php");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        internalServerError("Si accettano solo richieste POST.");
    }

    logOut();
?>
