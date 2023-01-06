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

        $email = trim($_POST["email"]);
        $username = trim($_POST["username"]);
        $telefono = trim($_POST["telefono"]);
        $password = trim($_POST["password"]);
        $confermaPassword = trim($_POST["conferma-password"]);
        $nome = trim($_POST["nome"]);
        $cognome = trim($_POST["cognome"]);
        $dataNascita = new DateTime(trim($_POST["data-nascita"]));
        $genere = trim($_POST["genere"]);

        if ($genere !== 'M' && $genere !== 'F' && $genere !== 'U') {
            internalServerError("Genere non valido");
        }
        $genere = GenereUtente::from($genere);

        $templateParams["registrazione-errors"] = array();

        if ($username === "" || $email === "") {
            array_push($templateParams["registrazione-errors"], "Username e email non possono essere vuoti.");
        }

        if ($telefono === "") {
            array_push($templateParams["registrazione-errors"], "Il telefono non può essere vuoto.");
        }

        if (!$dbh->usernameIsAvailable($username)) {
            array_push($templateParams["registrazione-errors"], "L'username scelto è già in uso");
        }

        if (!$dbh->emailIsAvailable($email)) {
            array_push($templateParams["registrazione-errors"], "L'e-mail scelta è già in uso");
        }

        if ($password === "") {
            array_push($templateParams["registrazione-errors"], "La password non può essere vuota.");
        }

        if (strlen($password) < 8) {
            array_push($templateParams["registrazione-errors"], "La password deve essere di almeno 8 caratteri ");
        }

        if ($password !== $confermaPassword) {
            array_push($templateParams["registrazione-errors"], "Le password non coincidono");
        }

        if ($dataNascita > new DateTime('now', $dataNascita->getTimezone())) {
            array_push($templateParams["registrazione-errors"], "La data di nascita non può essere successiva ad oggi.");
        }

        if ($nome === "" || $cognome === "") {
            array_push($templateParams["registrazione-errors"], "Nome e cognome non possono essere vuoti.");
        }

        if (sizeof($templateParams["registrazione-errors"]) === 0) {
            $id = registerUtente($db, $username, $password, $nome, $cognome, $dataNascita, $genere, $email, $telefono, null);

            $utente = $dbh->getUtenteFromId($id);
            startSessionForUtente($utente);
            
            header("Location: index.php");
            exit();
        }

    } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        internalServerError("Sono accettate solo richieste GET o POST");
    }

    $templateParams["page-title"] = "Registrazione";
    $templateParams["show-top-bar-buttons"] = false;
    $templateParams["show-footer"] = false;
    $templateParams["content"] = "templates/registrazione-template.php";
    $templateParams["js"] = array("https://unpkg.com/axios/dist/axios.min.js", "inc/js/form-control.js");
    require("templates/container.php");
?>
