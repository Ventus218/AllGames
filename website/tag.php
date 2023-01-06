<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_GET["tag"])) {
            internalServerError("Nessun tag selezionato");
        }

        $tagName = trim($_GET["tag"]);
        if ($tagName === "") {
            internalServerError("Il parametro tag non può essere vuoto.");
        }
    
        $tag = $dbh->getTagFromName($tagName);
    
        if (!isset($tag)) {
            require("not-found.php");
            exit();
        }
        
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
            $postsData[$i]["is_mi_piace"] = $dbh->checkIfMiPiaceIsActive($post->id, getSessionUserId());
        }

        $templateParams["posts_data"] = $postsData;
        $templateParams["tag"] = $tag;

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = "Tag: ".$tag->nome;
        $templateParams["content"] = "templates/tag-template.php";
        $templateParams["feed-title"] = "Il feed del tag ".$tag->nome;
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/mi-piace.js");
        require("templates/container.php");
    }
?>
