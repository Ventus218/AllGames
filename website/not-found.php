<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {

        header('HTTP/1.1 404 Not Found');

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["page-title"] = "Risorsa non trovata";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        $templateParams["content"] = "templates/not-found-template.php";
        require("templates/container.php");
    }
?>
