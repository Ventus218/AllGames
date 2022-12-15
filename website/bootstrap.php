<?php
    session_start();
    require_once("inc/php/utils.php");
    require_once("db/Database.php");
    $db = new Database("localhost", "root", "", "ALL_GAMES", 3306);

    var_dump($db->getAllUtenti());
?>
