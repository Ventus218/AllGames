<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/auth.php");
    require_once("inc/php/session.php");


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        if (
            !isset($_POST["email"]) || 
            !isset($_POST["username"]) || 
            !isset($_POST["telefono"]) || 
            !isset($_POST["password"]) || 
            !isset($_POST["conferma-password"]) || 
            !isset($_POST["nome"]) || 
            !isset($_POST["cognome"]) || 
            !isset($_POST["data-nascita"]) || 
            !isset($_POST["genere"])
            ) {
            internalServerError("Mancano alcuni dati");    
        }

        $email = $_POST["email"];
        $username = $_POST["username"];
        $telefono = $_POST["telefono"];
        $password = $_POST["password"];
        $confermaPassword = $_POST["conferma-password"];
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $dataNascita = new DateTime($_POST["data-nascita"]);
        $genere = $_POST["genere"];

        if ($genere !== 'M' && $genere !== 'F' && $genere !== 'U') {
            internalServerError("Genere non valido");
        }
        $genere = GenereUtente::from($genere);

        $templateParams["registrazione-errors"] = array();

        if (!$dbh->usernameIsAvailable($username)) {
            array_push($templateParams["registrazione-errors"], "L'username scelto è già in uso");
        }

        if (!$dbh->emailIsAvailable($email)) {
            array_push($templateParams["registrazione-errors"], "L'e-mail scelta è già in uso");
        }

        if ($password !== $confermaPassword) {
            array_push($templateParams["registrazione-errors"], "Le password non coincidono");
        }

        $dataNascita = new DateTime($_POST["data-nascita"]);
        if ($dataNascita > new DateTime()) {
            array_push($templateParams["registrazione-errors"], "La data di nascita non può essere successiva ad oggi.");
        }

        if (sizeof($templateParams["registrazione-errors"]) === 0) {
            registerUtente($db, $username, $password, $nome, $cognome, $dataNascita, $genere, $email, $telefono, null);
            header("Location: login.php");
        }

    } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        internalServerError("Sono accettate solo richieste GET o POST");
    }

    $templateParams["page-title"] = "Registrazione";
    $templateParams["show-top-bar-buttons"] = false;
    $templateParams["show-footer"] = false;
    $templateParams["content"] = "templates/registrazione-template.php";
    $templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "inc/js/registrazione.js");
    require("templates/container.php");
?>
