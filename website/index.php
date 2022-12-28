<?php
    require_once(__DIR__."/bootstrap.php");
    require_once(__DIR__."/inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {

        $posts = $dbh->getPostFeedOfUtente(getSessionUserId());

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

        $templateParams["content"] = "templates/index-template.php";
        $templateParams["js"] = array("inc/js/slider.js");
        require(__DIR__."/templates/container.php");
    }
?>
