<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_GET["tag"])) {
            internalServerError("Nessun tag selezionato");
        }
        $tagName = $_GET["tag"];
        $tag = $dbh->getTagFromName($tagName);
        
        $posts = $dbh->getPostFeedOfTag($tag);

        $postsData = array();
        for ($i=0; $i < sizeof($posts); $i++) {
            $post = $posts[$i];

            $postsData[$i]["post"] = $post;
            $postsData[$i]["utente"] = $dbh->getAuthorOfPost($post);
            $postsData[$i]["tags-in-post"] = $dbh->getTagsOfPost($post);
            $postsData[$i]["c_multimediali"] = $dbh->getContenutiMultimedialiOfPost($post);
            $postsData[$i]["commenti"] = sizeof($dbh->getCommentiOfPost($post));
            $postsData[$i]["mi_piace"] = sizeof($dbh->getMiPiaceOfPost($post));
        }

        $templateParams["posts_data"] = $postsData;
        $templateParams["tag"] = $tag;

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = "Tag: ".$tag->nome;
        $templateParams["content"] = "templates/tag-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js");
        require("templates/container.php");
    }
?>