<?php

require_once(__DIR__."/../bootstrap.php");
require_once(__DIR__."/../inc/php/session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_POST["postid"])) {
            internalServerError("Non è stato inserito alcun post id a cui mettere/togliere mi piace");
        }

        header('Content-Type: application/json');
        echo json_encode($dbh->toggleMiPiaceOfPost($_POST["postid"], getSessionUserId()));
    }
} else {
    internalServerError("Sono accettate solo richieste POST");
}

?>