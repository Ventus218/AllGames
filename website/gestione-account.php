<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");
    require_once("inc/php/auth.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
            if (
                !isset($_POST["email"]) || 
                !isset($_POST["username"]) || 
                !isset($_POST["telefono"]) || 
                !isset($_POST["password"]) || 
                !isset($_POST["nome"]) || 
                !isset($_POST["cognome"]) || 
                !isset($_POST["conferma-password"]) ||
                !isset($_POST["data-nascita"]) || 
                !isset($_POST["genere"]) ||
                !isset($_POST["oldPassword"])
                ) {
                internalServerError("Mancano alcuni dati");    
            }

            $email = $_POST["email"];
            $username = $_POST["username"];
            $telefono = $_POST["telefono"];
            $password = $_POST["password"];
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $confermaPassword = $_POST["conferma-password"];
            $dataNascita = new DateTime($_POST["data-nascita"]);
            $genere = $_POST["genere"];

            $oldPassword = $_POST["oldPassword"];

            $utente = $dbh->getUtenteFromId(getSessionUserId());
            $urlImmagine = $utente->urlImmagine;

            if (UPLOAD_ERR_OK === $_FILES["immagineProfilo"]["error"]) {
                $immagine = $_FILES["immagineProfilo"];

                $result = uploadMultimedia($immagine);

                if ($result["result"] !== 1) {
                    internalServerError($result["msg"]);
                }

                if ($result["type"] === "video") {
                    internalServerError("Non si può inserire un video come foto profilo");
                }

                $urlImmagine = $result["msg"];
            }

            if ($genere !== 'M' && $genere !== 'F' && $genere !== 'U') {
                internalServerError("Genere non valido");
            }
            $genere = GenereUtente::from($genere);
    
            $templateParams["change-errors"] = array();

            if ($username === "" || $email === "") {
                array_push($templateParams["change-errors"], "Username e email non possono essere vuoti.");
            }

            if ($telefono === "") {
                array_push($templateParams["change-errors"], "Il telefono non può essere vuoto.");
            }
    
            if (!$dbh->usernameIsAvailable($username) && $username != $utente->username) {
                array_push($templateParams["change-errors"], "L'username scelto è già in uso.");
            }
    
            if (!$dbh->emailIsAvailable($email) && $email != $utente->email) {
                array_push($templateParams["change-errors"], "L'e-mail scelta è già in uso.");
            }
    
            if ($password !== $confermaPassword) {
                array_push($templateParams["change-errors"], "Le password non coincidono.");
            }

            if ($password === "" && $confermaPassword !== "") {
                array_push($templateParams["change-errors"], "La password non può essere vuota.");
            }

            if ($dataNascita > new DateTime('now', $dataNascita->getTimezone())) {
                array_push($templateParams["change-errors"], "La data di nascita non può essere successiva ad oggi.");
            }

            if ($nome === "" || $cognome === "") {
                array_push($templateParams["change-errors"], "Nome e cognome non possono essere vuoti.");
            }

            if (!password_verify($oldPassword, $utente->passwordHash)) {
                array_push($templateParams["change-errors"], "Non è stata inserita la password giusta.");
            }

            if (sizeof($templateParams["change-errors"]) === 0) {
                $dbh->updateUtente($username, $password, $nome, $cognome, $dataNascita, $genere, $email, $telefono, $urlImmagine, $utente);
            }

        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["page-title"] = "Gestione account";
        $templateParams["content"] = "templates/gestione-account-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        $templateParams["js"] =array("inc/js/change-image.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/form-control.js");
        require("templates/container.php");
    }
?>