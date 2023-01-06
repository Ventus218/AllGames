<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if (!isset($_GET["utente"])) {
            internalServerError("Nessun utente selezionato");
        }

        $idUtente = $_GET["utente"];
        if (!is_numeric($idUtente)) {
            internalServerError("Formato errato del parametro utente.");
        }

        $utente = $dbh->getUtenteFromId($idUtente);
        if (!isset($utente)) {
            require("not-found.php");
            exit();
        }

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

            $dbh->setUtenteFollowUtente($currentUtente, $utente, boolval(trim($_POST["follow"])));
            $isFollowed = boolval(trim($_POST["follow"]));
        }

        $communities = $dbh->getCommunitiesOfUtente($utente);
        
        $posts = $dbh->getPostFeedOfUserProfile($utente);

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

        $templateParams["utente-of-profile"] = $utente;
        $templateParams["follow"] = $dbh->getFollowOfUtente($utente);
        $templateParams["followers"] = $dbh->getFollowersOfUtente($utente);
        $templateParams["is-current-user-profile"] = $isCurrentUserProfile;
        $templateParams["is-followed"] = $isFollowed;
        $templateParams["posts_data"] = $postsData;
        $templateParams["communities"] = $communities;

        $templateParams["utente"] = $currentUtente;
        $templateParams['notifications'] = $dbh->getNotificationsOfUser(getSessionUserId());
        $templateParams['total_notifications'] = sizeof($templateParams['notifications']);
        $templateParams["new_notifications"] = sizeof($dbh->getNewNotificationsOfUser(getSessionUserId()));
        $templateParams["page-title"] = $utente->username;
        $templateParams["content"] = "templates/profilo-utente-template.php";
        $templateParams["feed-title"] = "Il feed di ".$utente->username;
        $templateParams["show-top-bar-buttons"] = true;
        $templateParams["show-footer"] = true;
        $templateParams["js"] = array("inc/js/slider.js", "https://unpkg.com/axios/dist/axios.min.js", "inc/js/mi-piace.js");
        require("templates/container.php");
    }
?>
