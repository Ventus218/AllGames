<?php

    /**
    * Must be called before any output.
    * An exception can be given as parameter for debugging purposes.
    */
    function internalServerError(?string $message = null, Exception $error = null) {
        header('HTTP/1.1 500 Internal Server Error');
        if (is_null($message)) {
            $message = "Si è verificato un errore...";
        }

        if (isset($error)) {
            $message = $message."\nERROR: ".$error->__toString();
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

    function dateTimeFromSQLDate(string $sqlDate): DateTime {
        $dt = new DateTime($sqlDate, new DateTimeZone("UTC"));
        $dt->setTimezone(new DateTimeZone(date_default_timezone_get()));
        return $dt;
    }

    function sqlDateFromDateTime(DateTime $dateTime): string {
        $dateTime->setTimezone(new DateTimeZone("UTC"));
        return $dateTime->format('Y-m-d H:i:s');
    }

?>
