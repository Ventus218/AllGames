<?php

    require_once("../../inc/php/utils.php");

    /* https://www.php.net/manual/en/mysqli.multi-query.php */
    function consume_multi_query_results($db) {
        do {
             if ($res = $db->store_result()) {
                $res->free();
            }
        } while ($db->more_results() && $db->next_result());
    }


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        exit("Si accettano solo richieste POST.");
    }

    /* AUTHORIZATION https://www.php.net/manual/en/features.http-auth.php */
    if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"])) {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }
    if ($_SERVER["PHP_AUTH_USER"] !== "admin" || $_SERVER["PHP_AUTH_PW"] !== "passw") {
        header('HTTP/1.1 401 Unauthorized');
        exit;
    }


    $servername = "localhost";
    $username = "root";
    $password = "";
    $port = 3306;

    $db = new mysqli($servername, $username, $password, "", $port);
    if($db->connect_error) {
        internalServerError("Connessione fallita a mysql");
    }

    try {
        $db->query("DROP DATABAsSE IF EXISTS ALL_GAMES");
    } catch (Exception $e) {
        internalServerError("Qualcosa è andato storto eliminando il vecchio database se presente.", $e);
    }

    try {
        $ddl = file_get_contents("/allgames/db/scripts/ALL_GAMES_DDL.sql");
        $db->multi_query($ddl);
        consume_multi_query_results($db);
    } catch (Exception $e) {
        internalServerError("Qualcosa è andato storto nella creazione del database.", $e);
    }

    try {
        $constr = file_get_contents("/allgames/db/scripts/ALL_GAMES_constraints.sql");
        $db->multi_query($constr);
        consume_multi_query_results($db);
    } catch (Exception $e) {
        internalServerError("Qualcosa è andato storto nella creazione dei constraints.", $e);
    }

    try {
        $notif = file_get_contents("/allgames/db/scripts/generazione_notifiche.sql");
        $result = $db->multi_query($notif);
        consume_multi_query_results($db);
    } catch (Exception $e) {
        internalServerError("Qualcosa è andato storto nella creazione dei trigger per le notifiche.", $e);
    }

    $db->close();

    echo("Il reset del database è riuscito.");
?>
