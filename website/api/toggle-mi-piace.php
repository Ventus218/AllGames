<?php

require_once(__DIR__."/../bootstrap.php");
require_once(__DIR__."/../inc/php/session.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        
    }
} else {
    internalServerError("Sono accettate solo richieste POST");
}

?>