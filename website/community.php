<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_GET["community"])) {
            internalServerError("Nessuna community selezionata");
        }
        $communityName = $_GET["community"];
        $community = $dbh->getCommunityFromName($communityName);

        if (!isset($community)) {
            require("not-found.php");
            exit();
        }

        $utente = $dbh->getUtenteFromId(getSessionUserId());
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!isset($_POST["partecipa"])) {
                internalServerError("Mancano alcune informazioni per completare l'operazione");
            }
            $partecipazione = $dbh->setUtentePartecipaCommunity($utente, $community, boolval($_POST["partecipa"]));
        } else {
            $partecipazione = $dbh->getPartecipazioneCommunity($utente, $community);
        }
        
        $posts = $dbh->getPostFeedOfCommunity($community->nome);

        $postsData = array();
        for ($i=0; $i < sizeof($posts); $i++) {
            $post = $posts[$i];

            $postsData[$i]["post"] = $post;
            $postsData[$i]["utente"] = $dbh->getAuthorOfPost($post);
            $postsData[$i]["tags-in-post"] = $dbh->getTagsOfPost($post);
            $postsData[$i]["c_multimediali"] = $dbh->getContenutiMultimedialiOfPost($post);
            $postsData[$i]["commenti"] = sizeof($dbh->getCommentiOfPost($post));
            $postsData[$i]["mi_piace"] = sizeof($dbh->getMiPiaceOfPost($post));
            $postsData[$i]["is_mi_piace"] = $dbh->checkIfMiPiaceIsActive($post->id, getSessionUserId());
        }

        $templateParams["posts_data"] = $postsData;
        $templateParams["community"] = $community;
        $templateParams["fondatore"] = $dbh->fondatoreOfCommunity($community);
        $templateParams["partecipanti"] = $dbh->partecipantiOfCommunity($community);
        $templateParams["already-partecipa"] = isset($partecipazione);

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = $community->nome;
        $templateParams["content"] = "templates/community-template.php";
        $templateParams["feed-title"] = "Il feed di ".$community->nome;
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/mi-piace.js");
        require("templates/container.php");
    }
?>
