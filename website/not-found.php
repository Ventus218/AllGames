<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");

    header('HTTP/1.1 404 Not Found');

    $templateParams["page-title"] = "Risorsa non trovata";
    $templateParams["show-top-bar-buttons"] = false;
    $templateParams["show-footer"] = false;
    $templateParams["content"] = "templates/not-found-template.php";
    require("templates/container.php");
?>
