<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["page-title"] = "Impostazioni";
        $templateParams["content"] = "templates/impostazioni-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        require("templates/container.php");
    }

?>
