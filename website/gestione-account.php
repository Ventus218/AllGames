<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TO DO            
        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["page-title"] = "Gestione account";
        $templateParams["content"] = "templates/gestione-account-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        $templateParams["js"] =array("inc/js/change-image.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/gestione-account.js", "inc/js/utils.js");
        require("templates/container.php");
    }
?>