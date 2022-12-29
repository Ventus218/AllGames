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
        $community = CommunityDTO::getOneByID($db, $communityName);

        $partecipazione = PartecipazioneCommunityDTO::getOneByID($db, getSessionUserId(), $community->nome);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($partecipazione)) {
                PartecipazioneCommunityDeleteDTO::from($partecipazione)->deleteOn($db);
                $partecipazione = null;
            } else {
                $partecipazione = (new PartecipazioneCommunityCreateDTO(getSessionUserId(), $community->nome))->createOn($db);
            }
        }
        
        $posts = $dbh->getPostFeedOfCommunity($community->nome);

        $postsData = array();
        for ($i=0; $i < sizeof($posts); $i++) {
            $post = $posts[$i];

            $postsData[$i]["post"] = $post;
            $postsData[$i]["utente"] = $dbh->getAuthorOfPost($post);
            $postsData[$i]["tags"] = $dbh->getTagsOfPost($post);
            $postsData[$i]["c_multimediali"] = $dbh->getContenutiMultimedialiOfPost($post);
            $postsData[$i]["commenti"] = sizeof($dbh->getCommentiOfPost($post));
            $postsData[$i]["mi_piace"] = sizeof($dbh->getMiPiaceOfPost($post));
        }

        $templateParams["posts_data"] = $postsData;
        $templateParams["community"] = $community;
        $templateParams["fondatore"] = UtenteDTO::getOneByID($db, $community->fondatore);
        $templateParams["utente-partecipa"] = isset($partecipazione);

        $templateParams["page-title"] = $community->nome;
        $templateParams["content"] = "templates/community-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js");
        require("templates/container.php");
    }
?>
