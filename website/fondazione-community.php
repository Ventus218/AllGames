<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");
    require_once("inc/php/auth.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {

        $utente = $dbh->getUtenteFromId(getSessionUserId());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!isset($_POST["nome-community"]) || !isset($_FILES["immagine-community"]) ) {
                internalServerError("Mancano alcuni dati");
            }

            $nome = $_POST["nome-community"];

            //Get the image
            $immagine = $_FILES["immagine-community"];
            $result = uploadMultimedia("multimedia-db", $immagine);

            if ($result["result"] !== 1) {
                internalServerError($result["msg"]);
            }

            if ($result["type"] === "video") {
                internalServerError("Non si può inserire un video come immagine della community");
            }

            $urlImmagine = $result["msg"];
    
            $templateParams["errors"] = array();
    
            if ($dbh->getCommunityFromName($nome) !== null) {
                array_push($templateParams["errors"], "Il nome scelto è già in uso.");
            }

            if (sizeof($templateParams["errors"]) === 0) {
                $dbh->createCommunity($nome, $urlImmagine, $utente);
                header("Location: community.php?community=".escapeSpacesForURIParam($nome));
            }

        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }

        $templateParams["utente"] = $utente;
        $templateParams["page-title"] = "Fondazione community";
        $templateParams["content"] = "templates/fondazione-community-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/change-image.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/form-control.js");
        require("templates/container.php");
    }
?>
