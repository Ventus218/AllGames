<?php
    require_once(__DIR__."/inc/php/utils.php");
    require_once(__DIR__."/inc/php/session.php");

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        internalServerError("Si accettano solo richieste POST.");
    }

    logOut();
?>
