<?php
    /* just to remember syntax


    function sizeOfSet($set, $db) {
        $stmt = $db->prepare("SELECT COUNT(id) as N FROM insiemi WHERE insieme = ?");
        $stmt->bind_param('i',$set);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC)[0]["N"];
    }

    function contentOfSet($set, $db) {
        $stmt = $db->prepare("SELECT valore FROM insiemi WHERE insieme = ?");
        $stmt->bind_param('i',$set);
        $stmt->execute();
        $result = $stmt->get_result();
        $ass_arr = $result->fetch_all(MYSQLI_ASSOC);
        $arr = array();
        foreach ($ass_arr as $elem) {
            array_push($arr, $elem["valore"]);
        }
        return $arr;
    }

    function getNewId($db) {
        $result = $db->query("SELECT DISTINCT insieme FROM insiemi ORDER BY insieme DESC");
        return $result->fetch_all(MYSQLI_ASSOC)[0]["insieme"] + 1;
    }

    function createNewSet($content, $id, $db) {
        foreach ($content as $c) {
            $stmt = $db->prepare("INSERT INTO insiemi(valore, insieme) VALUE (?, ?)");
            $stmt->bind_param('ii', $c, $id);
            $stmt->execute();
        }
    } */


    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Si accettano solo richieste POST.");
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $port = 3306;

    $db = new mysqli($servername, $username, $password, "", $port);
    if($db->connect_error) {
        die("Connessione fallita al mysql");
    }

    $result = $db->query("DROP DATABASE IF EXISTS ALL_GAMES");
    var_dump($result);

    $ddl = file_get_contents("/allgames/db/scripts/ALL_GAMES_DDL.sql");
    $db->multi_query($ddl);

    $constr = file_get_contents("/allgames/db/scripts/ALL_GAMES_constraints.sql");
    $db->multi_query($constr);

    $notif = file_get_contents("/allgames/db/scripts/generazione_notifiche.sql");
    $db->multi_query($notif);



?>
