<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Code to search
        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }
        
        $templateParams["page-title"] = "Search";
        $templateParams["content"] = "templates/search-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        require("templates/container.php");
    }
?>