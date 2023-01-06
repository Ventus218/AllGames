<?php
    require_once("bootstrap.php");
    require_once("inc/php/utils.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST["search"])) {
                internalServerError("Nessun testo per la ricerca inserito");
            }

            $filter = trim($_POST["search"]);
            if ($filter === "") {
                internalServerError("Il testo da ricercare non può essere vuoto.");
            }

            $templateParams['searchedUsers'] = $dbh->getUtentiWithSubstring($filter);
            $templateParams['searchedCommunities'] = $dbh->getCommunityWithSubstring($filter);
            
        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }
        
        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = "Search";
        $templateParams["content"] = "templates/search-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        require("templates/container.php");
    }
?>