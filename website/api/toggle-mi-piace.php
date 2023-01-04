<?php

require_once(__DIR__."/../bootstrap.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        echo "bravo";
    }
} else {
    internalServerError("Sono accettate solo richieste POST");
}

?>