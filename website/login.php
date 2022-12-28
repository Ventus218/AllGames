<?php
    require_once(__DIR__."/bootstrap.php");
    require_once(__DIR__."/inc/php/utils.php");
    require_once(__DIR__."/inc/php/auth.php");
    require_once(__DIR__."/inc/php/session.php");


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
    $templateParams["content"] = "templates/login-template.php";
    require(__DIR__."/templates/container.php");
?>
