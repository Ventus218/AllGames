<?php

    /**
    * Must be called before any output.
    * An exception can be given as parameter for debugging purposes.
    */
    function internalServerError($message, Exception $error = null) {
        header('HTTP/1.1 500 Internal Server Error');
        if (isset($error)) {
            $message = $message."\nERROR: ".$error->getMessage();
        }
        exit($message);
    }

    function authenticateAdminOrAbort() {
        /* AUTHORIZATION https://www.php.net/manual/en/features.http-auth.php */
        if (!isset($_SERVER["PHP_AUTH_USER"]) || !isset($_SERVER["PHP_AUTH_PW"])) {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
        if ($_SERVER["PHP_AUTH_USER"] !== "admin" || $_SERVER["PHP_AUTH_PW"] !== "passw") {
            header('HTTP/1.1 401 Unauthorized');
            exit;
        }
    }

?>
