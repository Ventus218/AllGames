<?php
    require_once(__DIR__."/bootstrap.php");
    require_once(__DIR__."/inc/php/utils.php");
    require_once(__DIR__."/inc/php/auth.php");
    require_once(__DIR__."/inc/php/session.php");


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        require(__DIR__."/templates/login.html");

    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST["Username"]) || !isset($_POST["Password"])) {
            internalServerError("Richiesti Username e Password");    
        }

        $username = $_POST["Username"];
        $password = $_POST["Password"];

        if ($utente = authenticateUtente($username, $password, $db)) {
            startSessionForUtente($utente);
            if (isset($_REQUEST["return"])) {
                header("Location: ".$_REQUEST["return"]);
            } else {
                header("Location: index.php");
            }
        } else {
            $templateParams["login-error"] = "Username o password errati";
            require(__DIR__."/templates/login.html");
        }
    } else {
        internalServerError("Sono accettate solo richieste GET o POST");
    }
?>
