<?php
    require_once("inc/php/utils.php");
    require_once("db/Database.php");
    require_once("db/DatabaseHelper.php");

    $db = new Database("localhost", "root", "", "ALL_GAMES", 3306);
    $dbh = new DatabaseHelper($db);


?>
