<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        $utente = $dbh->getUtenteFromId(getSessionUserId());

        if (!isset($_GET["post"])) {
            internalServerError("Nessun post selezionato");
        }

        $idPost = $_GET["post"];

        if (!is_numeric($idPost)) {
            internalServerError("Formato errato del parametro post.");
        }

        $post = $dbh->getPostFromId($idPost);

        if (!isset($post)) {
            internalServerError("Questo post non esiste.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["delete"]) && boolval($_POST["delete"])) {
                $dbh->deletePost($post);

                if(isset($_GET["return"])) {
                    header("Location: ".$_GET["return"]);
                } else {
                    header("Location: index.php");
                }
            } else {

                if (!isset($_POST["testo"]) || $_POST["testo"] === "") {
                    internalServerError("Non puoi creare commenti o risposte vuoti.");
                }
                $testo = $_POST["testo"];

                if (isset($_POST["commento"]) && $_POST["commento"] !== "") {
                    $idCommento = $_POST["commento"];
                    if (!is_numeric($idCommento)) {
                        internalServerError("Formato errato del parametro commento.");
                    }

                    $commento = $dbh->getCommentoFromId(intval($idCommento));
                    if (!isset($commento)) {
                        internalServerError("Il commento al quale stai cercando di rispondere non esiste.");
                    }

                    $dbh->replyCommento($commento, $utente, $testo);
                } else {
                    $dbh->commentPost($post, $utente, $testo);
                }
            }
        }

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
        $templateParams["is_mi_piace"] = $dbh->checkIfMiPiaceIsActive($post->id, getSessionUserId());

        $templateParams["utente"] = $utente;
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = "Post di ".$templateParams["utente-post"]->username;
        $templateParams["content"] = "templates/post-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js", "inc/js/commenta.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/mi-piace.js");
        require("templates/container.php");
    }
?>
