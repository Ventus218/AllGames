<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (
                !isset($_POST["text"]) || 
                !isset($_POST["multimedia"])
                ) {
                internalServerError("Mancano alcuni dati");    
            }

            $text = $_POST["text"];
            //TODO Get the url for the multimedia

            $utente = $dbh->getUtenteFromId(getSessionUserId());
    
            $templateParams["change-errors"] = array();
    

            if (sizeof($templateParams["change-errors"]) === 0) {
                //TODO get the url from the multimedia
                
            }

        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["communities"] = $dbh->getCommunitiesOfUtente($templateParams["utente"]);
        $templateParams["tags"] = $dbh->getAllTags();
        $templateParams["page-title"] = "Creazione post";
        $templateParams["content"] = "templates/creazione-post-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        require("templates/container.php");
    }
?>