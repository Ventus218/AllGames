<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_GET["utente"])) {
            internalServerError("Nessun utente selezionato");
        }

        $utente = $dbh->getUtenteFromId($_GET["utente"]);
        $currentUtente = $dbh->getUtenteFromId(getSessionUserId());

        $isCurrentUserProfile = $utente->id === $currentUtente->id;

        if ($isCurrentUserProfile) {
            $isFollowed = false;
        } else {
            $isFollowed = $dbh->checkIfUserFollows($currentUtente, $utente);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($isCurrentUserProfile) {
                internalServerError("Non è possibile seguire se stessi");
            } else if(!isset($_POST["follow"])) {
                internalServerError("Mancano alcune informazioni per completare l'operazione");
            }

            if ($_POST["follow"]) {
                if (!$dbh->checkIfUserFollows($currentUtente, $utente)) {
                    (new FollowCreateDTO($currentUtente->id, $utente->id))->createOn($db);
                    $isFollowed = true;
                } else {
                    // this was probably a page reload after post so we are not crashing
                    // internalServerError("Sembra che tu stia già seguendo questo utente");
                }
            } else {
                if ($dbh->checkIfUserFollows($currentUtente, $utente)) {
                    (new FollowDeleteDTO($currentUtente->id, $utente->id))->deleteOn($db);
                    $isFollowed = false;
                } else {
                    // this was probably a page reload after post so we are not crashing
                    // internalServerError("Sembra che tu già non segua questo utente");
                }
            }
        }

        $communities = $dbh->getCommunitiesOfUtente($utente);
        
        $posts = $dbh->getPostFeedOfUserProfile($utente);

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

        $templateParams["utente"] = $utente;
        $templateParams["follow"] = $dbh->getNumberOfFollowOfUtente($utente);
        $templateParams["followers"] = $dbh->getNumberOfFollowersOfUtente($utente);
        $templateParams["is-current-user-profile"] = $isCurrentUserProfile;
        $templateParams["is-followed"] = $isFollowed;
        $templateParams["posts_data"] = $postsData;
        $templateParams["communities"] = $communities;


        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = $utente->username;
        $templateParams["content"] = "templates/profilo-utente-template.php";
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js");
        require("templates/container.php");
    }
?>
