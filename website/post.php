<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_GET["post"])) {
            internalServerError("Nessun post selezionato");
        }
        $post = $dbh->getPostFromId($_GET["post"]);

        $commentiPost = $dbh->getCommentiOfPost($post);
        $commentiPostData = array();
        for ($i=0; $i < sizeof($commentiPost); $i++) { 
            $commentiPostData[$i]["commento"] = $commentiPost[$i];
            $commentiPostData[$i]["commentatore"] = $dbh->getAuthorOfCommento($commentiPost[$i]);

            $risposteCommento = $dbh->getRisposteOfCommento($commentiPost[$i]);
            $risposteData = array();
            for ($j=0; $j < sizeof($risposteCommento); $j++) { 
                $risposta = $risposteCommento[$j];
                $risposteData[$j]["risposta"] = $risposta;
                $risposteData[$j]["risponditore"] = $dbh->getAuthorOfRisposta($risposta);
            }
            $commentiPostData[$i]["risposte-data"] = $risposteData;
        }

        $templateParams["post"] = $post;
        $templateParams["utente-post"] = $dbh->getAuthorOfPost($post);
        $templateParams["tags-in-post"] = $dbh->getTagsOfPost($post);
        $templateParams["c_multimediali-post"] = $dbh->getContenutiMultimedialiOfPost($post);
        $templateParams["commenti-post-data"] = $commentiPostData;
        $templateParams["mi_piace-post"] = sizeof($dbh->getMiPiaceOfPost($post));

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = "Home";
        $templateParams["content"] = "templates/post-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js");
        require("templates/container.php");
    }
?>
