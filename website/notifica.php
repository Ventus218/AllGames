<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/auth.php");
    require_once("inc/php/session.php");

    if (!isset($_GET["notifica"])) {
        internalServerError("Nessuna notifica selezionata");
    }
    $notifica = $dbh->getNotificaFromId($_GET["notifica"]);

    if ($notifica->ricevente != getSessionUserId()) {
        internalServerError("Non sei autorizzato ad accedere alle notifiche di altri utenti");
    }

    $dbh->setNotificaLetta($notifica);

    $location = "";
    if ($notifica->isNotificaFollow) {
        $location = "profilo-utente.php?utente=".$notifica->utenteSeguace;    
    } else if ($notifica->isNotificaMiPiace) {
        $location = "post.php?post=".$notifica->postPiaciuto;    
    } else if ($notifica->isNotificaPostCommunity) {
        $location = "post.php?post=".$notifica->postCommunity;    
    } else if ($notifica->isNotificaCommento) {
        $commento = $dbh->getCommentoFromId($notifica->commento);
        $location = "post.php?post=".$commento->post."#commento-".$commento->id;    
    } else if ($notifica->isNotificaRisposta) {
        $commento = $dbh->getCommentoFromId($dbh->getRispostaFromId($notifica->risposta)->commento);
        $location = "post.php?post=".$commento->post."#commento-".$commento->id;
    }

    header("Location: ".$location);
?>