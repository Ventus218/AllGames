<?php

    require_once(__DIR__."/../../db/Database.php");
    require_once(__DIR__."/../../db/model/Utente.php");

    session_start();

    function checkIfSessionIsActive(): bool {
        if (!isset($_SESSION["LAST_INTERACTION"])) {
            return false;
        }

        // session expires after 30 minutes from last interaction.
        if (time() - $_SESSION["LAST_INTERACTION"] > 1800) {
            session_destroy();
            return false;
        } else {
            $_SESSION["LAST_INTERACTION"] = time();
            return true;
        }
    }

    function startSessionForUtente(UtenteDTO $user) {
        $_SESSION["USER_ID"] = $user->id;
        $_SESSION["USER_USERNAME"] = $user->username;
        $_SESSION["LAST_INTERACTION"] = time();
    }

    function logOut() {
        destroySession();
    }

    function destroySession() {
        session_unset();
        session_destroy();
    }

    function redirectToLogin(?string $returnAfterLoginPage = null)
    {
        if (isset($returnAfterLoginPage)) {
            header("Location: login.php?return=".$returnAfterLoginPage);
        } else {
            header("Location: login.php");
        }
    }

    function getSessionUserId(): ?int {
        if (isset($_SESSION["USER_ID"])) {
            return $_SESSION["USER_ID"];
        } else {
            return null;
        }
    }

    function getSessionUserUsername(): ?int {
        if (isset($_SESSION["USER_USERNAME"])) {
            return $_SESSION["USER_USERNAME"];
        } else {
            return null;
        }
    }
?>
