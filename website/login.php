<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/auth.php");
    require_once("inc/php/session.php");


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST["username"]) || !isset($_POST["password"])) {
            internalServerError("Richiesti Username e Password");    
        }

        $username = $_POST["username"];
        $password = $_POST["password"];

        if ($utente = authenticateUtente($username, $password, $db)) {
            startSessionForUtente($utente);
            if (isset($_REQUEST["return"])) {
                header("Location: ".$_REQUEST["return"]);
            } else {
                header("Location: index.php");
            }
        } else {
            $templateParams["login-error"] = "Username o password errati";
        }

    } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        internalServerError("Sono accettate solo richieste GET o POST");
    }

    $templateParams["page-title"] = "Login";
    $templateParams["show-top-bar-buttons"] = false;
    $templateParams["show-footer"] = false;
    $templateParams["content"] = "templates/login-template.php";
    require("templates/container.php");
?>
