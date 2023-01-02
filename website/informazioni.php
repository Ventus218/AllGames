<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");
    require_once("inc/php/auth.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET");
        }

        $templateParams["sviluppatori"] = array(
            array("nome" => "Corrado Stortini", "github" => "https://github.com/Corstor"),
            array("nome" => "Alessandro Venturini", "github" => "https://github.com/Ventus218")
        );

        $templateParams["autori-flaticon"] = array(
            array("nome" => "Freepik", "link" => "https://www.flaticon.com/authors/freepik"),
            array("nome" => "Bingge Liu", "link" => "https://www.flaticon.com/authors/bingge-liu"),
            array("nome" => "Smashicons", "link" => "https://www.flaticon.com/authors/smashicons"),
            array("nome" => "WR Graphic Garage", "link" => "https://www.flaticon.com/authors/wr-graphic-garage"),
            array("nome" => "AB Design", "link" => "https://www.flaticon.com/authors/ab-design"),
            array("nome" => "Icon Hubs", "link" => "https://www.flaticon.com/authors/icon-hubs"),
            array("nome" => "Ilham Fitrotul Hayat", "link" => "https://www.flaticon.com/authors/ilham-fitrotul-hayat"),
            array("nome" => "kliwir art", "link" => "https://www.flaticon.com/authors/kliwir-art")
        );

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["page-title"] = "Informazioni";
        $templateParams["content"] = "templates/informazioni-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array();
        require("templates/container.php");
    }
?>