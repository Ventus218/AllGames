<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/auth.php");
    require_once("inc/php/session.php");

    if (!isset($_GET["notifica"])) {
        internalServerError("Nessuna notifica selezionata");
    }

    $idNotifica = trim($_GET["notifica"]);

    if (!is_numeric($idNotifica)) {
        internalServerError("Formato errato del parametro notifica.");
    }

    $notifica = $dbh->getNotificaFromId(intval($idNotifica));

    if (!isset($notifica)) {
        require("not-found.php");
        exit();
    }

    if ($notifica->ricevente != getSessionUserId()) {
        internalServerError("Non sei autorizzato ad accedere alle notifiche di altri utenti");
    }

    $dbh->setNotificaLetta($notifica);

    $location = "";
    if ($notifica->isNotificaFollow) {
        $location = "profilo-utente.php?utente=".escapeSpacesForURIParam($notifica->attoreSorgente);    

    } else if ($notifica->isNotificaMiPiace && isset($notifica->postPiaciuto)) {
        $location = "post.php?post=".escapeSpacesForURIParam($notifica->postPiaciuto);  

    } else if ($notifica->isNotificaPostCommunity && isset($notifica->postCommunity)) {
        $location = "post.php?post=".escapeSpacesForURIParam($notifica->postCommunity);    

    } else if ($notifica->isNotificaCommento && isset($notifica->commento)) {
        $commento = $dbh->getCommentoFromId($notifica->commento);
        $location = "post.php?post=".escapeSpacesForURIParam($commento->post)."#commento-".$commento->id; 

    } else if ($notifica->isNotificaRisposta && isset($notifica->risposta)) {
        $risposta = $dbh->getRispostaFromId($notifica->risposta);
        $commento = $dbh->getCommentoFromId($risposta->commento);
        $location = "post.php?post=".escapeSpacesForURIParam($commento->post)."#commento-".$commento->id;
    } else {
        require("not-found.php");
        exit();
    }

    header("Location: ".$location);
?>
