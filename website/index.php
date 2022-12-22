<?php
    require_once(__DIR__."/bootstrap.php");
    require_once(__DIR__."/inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        // set various templateParams...

        require(__DIR__."/templates/index-template.php");
    }
?>
