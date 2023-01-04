<?php
    require_once("bootstrap.php");
    require_once("inc/php/session.php");

    if (!checkIfSessionIsActive()) {
        redirectToLogin($_SERVER["REQUEST_URI"]);
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST["testo"])) {
                internalServerError("Mancano alcuni dati");    
            }

            $testo = trim($_POST["testo"]);
            if ($testo === "") {
                internalServerError("Non puoi creare post con testo vuoto.");
            }

            $utente = $dbh->getUtenteFromId(getSessionUserId());
            
            $community = null;

            if (isset($_POST["community"]) && $dbh->getCommunityFromName($_POST["community"]) != null) {
                $community = $_POST["community"];
            }

            $idPost = $dbh->createPost($testo, $utente->id, $community);

            if ($idPost == null) {
                internalServerError("Qualcosa è andato storto"); 
            }

            $nuoviTag = null;
            $allTags = null;

            //Aggiungo i nuovi tag se non esistono nel database, dopodichè li aggiungo al post
            if (isset($_POST["nuoviTag"])) {
                $nuoviTag = array();
                $allTags = array();
                $nuoviTag = explode(" ", $_POST["nuoviTag"]);
                foreach($nuoviTag as $tag) {
                    if($tag !== "") {
                        if (!$dbh->checkIfTagExists($tag))
                        {
                            $dbh->createTag($tag);
                        }
                        else {
                            $tag = $dbh->getTagThatAlreadyExists($tag);
                        }
                        $dbh->createTagInPost($tag, $idPost);
                        array_push($allTags, $tag);
                    }
                }
            }

            //Aggiungo i tag selezionati tra quelli già esistenti ai post
            if(isset($_POST["tags"])) {
                foreach($_POST["tags"] as $tag) {
                    if($tag !== "" && $dbh->checkIfTagExists($tag) && !in_array($tag, $allTags)) {
                        $dbh->createTagInPost($tag, $idPost);
                    }                    
                }
            }

            if(UPLOAD_ERR_OK === $_FILES["multimedia"]["error"][0]) {
                $i = 0;
                $files = reArrayFiles($_FILES['multimedia']);
                foreach($files as $multimedia) {
                    $result = uploadMultimedia($multimedia);
                    if ($result["result"] !== 1) {
                        internalServerError($result["msg"]);
                    }

                    $multimediaName = $result["msg"];
                    $dbh->createMultimediaInPost($multimediaName, $i, $idPost, $result["type"]);
                    $i++;
                }                
            } else {
                internalServerError("Non sono stati inseriti correttamente dei file da caricare");
            }

            header("Location: profilo-utente.php?utente=".$utente->id);

        } else if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            internalServerError("Sono accettate solo richieste GET o POST");
        }

        $templateParams["utente"] = $dbh->getUtenteFromId(getSessionUserId());
        $templateParams["communities"] = $dbh->getCommunitiesOfUtente($templateParams["utente"]);
        $templateParams["tags"] = $dbh->getAllTags();
        $templateParams["page-title"] = "Creazione post";
        $templateParams["content"] = "templates/creazione-post-template.php";
        $templateParams["show-top-bar-buttons"] = false;
        $templateParams["show-footer"] = true;
        require("templates/container.php");
    }
?>