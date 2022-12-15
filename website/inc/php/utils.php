<?php

    /*
    Must be called before any output.
    An exception can be given as parameter for debugging purposes.
    */
    function internalServerError($message, Exception $error) {
        header('HTTP/1.1 500 Internal Server Error');
        if (isset($error)) {
            $message = $message."\nERROR: ".$error->getMessage();
        }
        exit($message);
    }
?>
