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

    function getTimeAgoFrom(DateTime $d): string {
        $interval = $d->diff(new DateTime('now', $d->getTimezone()), true);

        if ($interval->y >= 2) {
            return $interval->y." anni fa";
        } else if ($interval->y >= 1) {
            return $interval->y." anno fa";
        } else if ($interval->m >= 2) {
            return $interval->m." mesi fa";
        } else if ($interval->m >= 1) {
            return $interval->m." mese fa";
        } else if ($interval->d >= 2) {
            return $interval->d." giorni fa";
        } else if ($interval->d >= 1) {
            return $interval->d." giorno fa";
        } else if ($interval->h >= 2) {
            return $interval->h." ore fa";
        } else if ($interval->h >= 1) {
            return $interval->h." ora fa";
        } else if ($interval->i >= 2) {
            return $interval->i." minuti fa";
        } else if ($interval->i >= 1) {
            return $interval->i." minuto fa";
        } else if ($interval->s >= 2) {
            return $interval->s." secondi fa";
        } else if ($interval->s >= 1) {
            return $interval->s." secondo fa";
        } else {
            return "adesso";
        }
    }

?>
